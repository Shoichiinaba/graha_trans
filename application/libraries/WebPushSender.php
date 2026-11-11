<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WebPushSender
{
    public function b64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function b64url_decode($data)
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    private function _openssl_config_array()
    {
        $cfg = array(
            'curve_name'       => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC
        );
        $candidates = array(
            getenv('OPENSSL_CONF'),
            'C:/xampp/php/extras/openssl/openssl.cnf',
            'C:/xampp/apache/conf/openssl.cnf',
            '/etc/ssl/openssl.cnf'
        );
        foreach ($candidates as $path) {
            if (!empty($path) && @file_exists($path)) {
                $cfg['config'] = $path;
                break;
            }
        }
        return $cfg;
    }

    public function generate_vapid_keys()
    {
        $cfg = $this->_openssl_config_array();
        $res = openssl_pkey_new($cfg);
        if (!$res) {
            return false;
        }

        $privPem = '';
        openssl_pkey_export($res, $privPem, null, $cfg);
        $details = openssl_pkey_get_details($res);

        if (empty($details['ec']['x']) || empty($details['ec']['y'])) {
            return false;
        }

        $x = str_pad($details['ec']['x'], 32, "\x00", STR_PAD_LEFT);
        $y = str_pad($details['ec']['y'], 32, "\x00", STR_PAD_LEFT);
        $pubRaw = "\x04" . $x . $y;

        return array(
            'public_key'  => $this->b64url_encode($pubRaw),
            'private_pem' => $privPem
        );
    }

    private function _der_sig_to_raw($der)
    {
        $pos = 0;
        if (ord($der[$pos++]) !== 0x30) {
            return false;
        }
        $seqLen = ord($der[$pos++]);
        if ($seqLen & 0x80) {
            $pos += ($seqLen & 0x7f);
        }
        if (ord($der[$pos++]) !== 0x02) {
            return false;
        }
        $rLen = ord($der[$pos++]);
        $r = substr($der, $pos, $rLen);
        $pos += $rLen;

        if (ord($der[$pos++]) !== 0x02) {
            return false;
        }
        $sLen = ord($der[$pos++]);
        $s = substr($der, $pos, $sLen);

        $r = ltrim($r, "\x00");
        $s = ltrim($s, "\x00");
        $r = str_pad($r, 32, "\x00", STR_PAD_LEFT);
        $s = str_pad($s, 32, "\x00", STR_PAD_LEFT);

        return $r . $s;
    }

    public function create_vapid_jwt($audience, $subject, $privatePem)
    {
        $header = $this->b64url_encode(json_encode(array('typ' => 'JWT', 'alg' => 'ES256')));
        $claims = $this->b64url_encode(json_encode(array(
            'aud' => $audience,
            'exp' => time() + 43200,
            'sub' => $subject
        )));
        $signingInput = $header . '.' . $claims;

        $pkey = openssl_pkey_get_private($privatePem);
        if (!$pkey) {
            return false;
        }
        $derSig = '';
        if (!openssl_sign($signingInput, $derSig, $pkey, OPENSSL_ALGO_SHA256)) {
            return false;
        }
        $rawSig = $this->_der_sig_to_raw($derSig);
        if ($rawSig === false || strlen($rawSig) !== 64) {
            return false;
        }

        return $signingInput . '.' . $this->b64url_encode($rawSig);
    }

    public function encrypt_payload($payloadJson, $p256dhB64Url, $authB64Url)
    {
        $userPub = $this->b64url_decode($p256dhB64Url);
        $userAuth = $this->b64url_decode($authB64Url);

        if (strlen($userPub) !== 65 || strlen($userAuth) < 16) {
            return false;
        }

        $cfg = $this->_openssl_config_array();
        $ephem = openssl_pkey_new($cfg);
        if (!$ephem) {
            return false;
        }
        $ephemDetails = openssl_pkey_get_details($ephem);
        $ephemPub = "\x04"
            . str_pad($ephemDetails['ec']['x'], 32, "\x00", STR_PAD_LEFT)
            . str_pad($ephemDetails['ec']['y'], 32, "\x00", STR_PAD_LEFT);

        // Wrap raw 65-byte P-256 public key into SubjectPublicKeyInfo PEM
        $spkiHeader = hex2bin('3059301306072a8648ce3d020106082a8648ce3d030107034200');
        $peerPem = "-----BEGIN PUBLIC KEY-----\n"
            . chunk_split(base64_encode($spkiHeader . $userPub), 64, "\n")
            . "-----END PUBLIC KEY-----\n";
        $peerKey = openssl_pkey_get_public($peerPem);
        if (!$peerKey) {
            return false;
        }

        $sharedSecret = openssl_pkey_derive($peerKey, $ephem, 32);
        if ($sharedSecret === false) {
            return false;
        }
        $sharedSecret = str_pad($sharedSecret, 32, "\x00", STR_PAD_LEFT);

        // RFC 8291 key derivation
        $ikmInfo = "WebPush: info\x00" . $userPub . $ephemPub;
        $prkKey = hash_hmac('sha256', $sharedSecret, $userAuth, true);
        $ikm = substr(hash_hmac('sha256', $ikmInfo . "\x01", $prkKey, true), 0, 32);

        $salt = random_bytes(16);
        $prk = hash_hmac('sha256', $ikm, $salt, true);
        $cek = substr(hash_hmac('sha256', "Content-Encoding: aes128gcm\x00\x01", $prk, true), 0, 16);
        $nonce = substr(hash_hmac('sha256', "Content-Encoding: nonce\x00\x01", $prk, true), 0, 12);

        $plaintext = $payloadJson . "\x02";
        $tag = '';
        $ciphertext = openssl_encrypt($plaintext, 'aes-128-gcm', $cek, OPENSSL_RAW_DATA, $nonce, $tag, '', 16);
        if ($ciphertext === false) {
            return false;
        }

        // RFC 8188 aes128gcm header: salt(16) + rs(4) + idlen(1=65) + keyid(65)
        return $salt . pack('N', 4096) . chr(65) . $ephemPub . $ciphertext . $tag;
    }

    public function send_web_push($subscription, $payloadArray, $vapidPublicKey, $vapidPrivatePem, $subject)
    {
        $endpoint = $subscription->endpoint;
        $parsed = parse_url($endpoint);
        if (empty($parsed['scheme']) || empty($parsed['host'])) {
            return array('ok' => false, 'code' => 0, 'error' => 'Invalid endpoint URL');
        }
        $audience = $parsed['scheme'] . '://' . $parsed['host'] . (!empty($parsed['port']) ? ':' . $parsed['port'] : '');

        $jwt = $this->create_vapid_jwt($audience, $subject, $vapidPrivatePem);
        if (!$jwt) {
            return array('ok' => false, 'code' => 0, 'error' => 'Failed creating VAPID JWT');
        }

        $body = $this->encrypt_payload(json_encode($payloadArray), $subscription->p256dh, $subscription->auth);
        if ($body === false) {
            return array('ok' => false, 'code' => 0, 'error' => 'Failed encrypting push payload');
        }

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: vapid t=' . $jwt . ', k=' . $vapidPublicKey,
            'Content-Encoding: aes128gcm',
            'Content-Type: application/octet-stream',
            'Content-Length: ' . strlen($body),
            'TTL: 86400',
            'Urgency: high'
        ));
        $resp = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        return array(
            'ok'      => ($code >= 200 && $code < 300),
            'code'    => $code,
            'expired' => ($code === 404 || $code === 410),
            'error'   => $err ?: $resp
        );
    }

    public function send_ntfy($topic, $title, $message, $clickUrl = '')
    {
        $topic = trim($topic);
        if ($topic === '') {
            return false;
        }
        $url = 'https://ntfy.sh/' . rawurlencode($topic);
        $headers = array(
            'Title: ' . $title,
            'Priority: urgent',
            'Tags: warning,car'
        );
        if ($clickUrl !== '') {
            $headers[] = 'Click: ' . $clickUrl;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $resp = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($code >= 200 && $code < 300 && $resp !== false);
    }

    public function send_telegram($botToken, $chatId, $text)
    {
        if (trim($botToken) === '' || trim($chatId) === '') {
            return false;
        }
        $url = 'https://api.telegram.org/bot' . trim($botToken) . '/sendMessage';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'chat_id'    => trim($chatId),
            'text'       => $text,
            'parse_mode' => 'HTML'
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        $resp = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($code >= 200 && $code < 300 && $resp !== false);
    }

    public function send_fonnte($token, $target, $message)
    {
        if (trim($token) === '' || trim($target) === '') {
            return false;
        }
        $ch = curl_init('https://api.fonnte.com/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'target'  => trim($target),
            'message' => $message
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . trim($token)
        ));
        $resp = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($code >= 200 && $code < 300 && $resp !== false);
    }
}


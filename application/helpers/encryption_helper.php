<?php
    if (!function_exists('encode_id')) {
        function encode_id($id) {
            $padded_id = str_pad($id, 10, '0', STR_PAD_LEFT);
            return strtr(base64_encode($padded_id), '+/=', '._-');
        }
    }

    if (!function_exists('decode_id')) {
        function decode_id($encoded_id) {
            $decoded = base64_decode(strtr($encoded_id, '._-', '+/='));
            return ltrim($decoded, '0');
        }
    }
?>
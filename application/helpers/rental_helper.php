<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka)
    {
        $nilai = (float) $angka;
        $prefix = $nilai < 0 ? '-Rp' : 'Rp';
        return $prefix . number_format(abs($nilai), 0, ',', '.');
    }
}

if (!function_exists('format_tanggal_id')) {
    function format_tanggal_id($date)
    {
        if (empty($date) || $date === '0000-00-00') {
            return '-';
        }
        return date('d/m/Y', strtotime($date));
    }
}

if (!function_exists('nama_hari_id')) {
    function nama_hari_id($date)
    {
        $days = array(
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu'
        );
        $eng = date('l', strtotime($date));
        return isset($days[$eng]) ? $days[$eng] : $eng;
    }
}

if (!function_exists('nama_bulan_id')) {
    function nama_bulan_id($month)
    {
        $months = array(
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        $m = (int) $month;
        return isset($months[$m]) ? $months[$m] : '';
    }
}

if (!function_exists('format_hari_tanggal_id')) {
    function format_hari_tanggal_id($date)
    {
        if (empty($date) || $date === '0000-00-00') {
            return '-';
        }
        $ts = strtotime($date);
        $hari = nama_hari_id($date);
        $tgl = date('d', $ts);
        $bulan = nama_bulan_id(date('n', $ts));
        $tahun = date('Y', $ts);
        return $hari . ', ' . $tgl . ' ' . $bulan . ' ' . $tahun;
    }
}

if (!function_exists('format_tanggal_panjang_id')) {
    function format_tanggal_panjang_id($date)
    {
        if (empty($date) || $date === '0000-00-00') {
            return '-';
        }
        $ts = strtotime($date);
        return date('d', $ts) . ' ' . nama_bulan_id(date('n', $ts)) . ' ' . date('Y', $ts);
    }
}

if (!function_exists('hitung_hari_sewa')) {
    function hitung_hari_sewa($tgl_mulai, $tgl_selesai)
    {
        $start = strtotime(date('Y-m-d', strtotime($tgl_mulai)));
        $end = strtotime(date('Y-m-d', strtotime($tgl_selesai)));
        if ($end < $start) {
            return 1;
        }
        $diff = (int) round(($end - $start) / 86400) + 1;
        return max(1, $diff);
    }
}

if (!function_exists('hitung_akumulasi_terlambat')) {
    /**
     * Hitung keterlambatan sewa harian (00:00 - 24:00) dengan toleransi s/d jam 06:00 pagi hari berikutnya.
     * Contoh: tanggal_selesai = 2026-11-11
     * - s/d 2026-11-12 06:00:00 => hari_akumulasi = 0 (dalam toleransi)
     * - 2026-11-12 06:00:01 s/d 2026-11-13 06:00:00 => hari_akumulasi = 1
     * - 2026-11-13 06:00:01 s/d 2026-11-14 06:00:00 => hari_akumulasi = 2
     */
    function hitung_akumulasi_terlambat($tanggal_selesai, $return_datetime = null)
    {
        $now_ts = $return_datetime ? strtotime($return_datetime) : time();
        $now_date = date('Y-m-d', $now_ts);
        $now_time = date('H:i:s', $now_ts);

        $end_ts = strtotime(date('Y-m-d', strtotime($tanggal_selesai)));
        $now_date_ts = strtotime($now_date);
        $day_diff = (int) round(($now_date_ts - $end_ts) / 86400);

        if ($day_diff <= 0) {
            return array(
                'is_past_date'       => false,
                'in_grace_period'    => false,
                'hari_akumulasi'     => 0,
                'deadline_toleransi' => date('d/m/Y', strtotime('+1 day', $end_ts)) . ' 06:00'
            );
        }

        $hari_akumulasi = ($now_time > '06:00:00') ? $day_diff : max(0, $day_diff - 1);

        return array(
            'is_past_date'       => true,
            'in_grace_period'    => ($hari_akumulasi === 0),
            'hari_akumulasi'     => $hari_akumulasi,
            'deadline_toleransi' => date('d/m/Y', strtotime('+1 day', $end_ts)) . ' 06:00'
        );
    }
}

if (!function_exists('label_minggu_id')) {
    function label_minggu_id($minggu)
    {
        $map = array(
            '1' => 'Minggu Pertama',
            '2' => 'Minggu Kedua',
            '3' => 'Minggu Ketiga',
            '4' => 'Minggu Keempat',
            '5' => 'Minggu Kelima'
        );
        return isset($map[(string) $minggu]) ? $map[(string) $minggu] : '';
    }
}

if (!function_exists('terbilang_id')) {
    function terbilang_id($angka, $is_root = true)
    {
        $angka = abs((int) round($angka));
        if ($angka === 0) {
            return $is_root ? 'Nol' : '';
        }
        $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
        if ($angka < 12) {
            return $baca[$angka];
        } elseif ($angka < 20) {
            return terbilang_id($angka - 10, false) . ' Belas';
        } elseif ($angka < 100) {
            return trim(terbilang_id((int) ($angka / 10), false) . ' Puluh ' . terbilang_id($angka % 10, false));
        } elseif ($angka < 200) {
            return trim('Seratus ' . terbilang_id($angka - 100, false));
        } elseif ($angka < 1000) {
            return trim(terbilang_id((int) ($angka / 100), false) . ' Ratus ' . terbilang_id($angka % 100, false));
        } elseif ($angka < 2000) {
            return trim('Seribu ' . terbilang_id($angka - 1000, false));
        } elseif ($angka < 1000000) {
            return trim(terbilang_id((int) ($angka / 1000), false) . ' Ribu ' . terbilang_id($angka % 1000, false));
        } elseif ($angka < 1000000000) {
            return trim(terbilang_id((int) ($angka / 1000000), false) . ' Juta ' . terbilang_id($angka % 1000000, false));
        } elseif ($angka < 1000000000000) {
            return trim(terbilang_id((int) ($angka / 1000000000), false) . ' Miliar ' . terbilang_id($angka % 1000000000, false));
        }
        return (string) $angka;
    }
}

if (!function_exists('bulan_romawi')) {
    function bulan_romawi($month)
    {
        $map = array(
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        );
        $m = (int) $month;
        return isset($map[$m]) ? $map[$m] : 'I';
    }
}

if (!function_exists('format_jangka_waktu_id')) {
    function format_jangka_waktu_id($hari)
    {
        $h = max(1, (int) $hari);
        if ($h >= 28 && $h <= 31) {
            return '1 (satu) bulan';
        }
        if ($h % 30 === 0 && $h >= 60) {
            $bln = (int) ($h / 30);
            return $bln . ' (' . strtolower(terbilang_id($bln)) . ') bulan';
        }
        return $h . ' (' . strtolower(terbilang_id($h)) . ') hari';
    }
}


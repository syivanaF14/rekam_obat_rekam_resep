<?php

if (!function_exists('status_expired')) {
    /**
     * Menghitung status expired obat.
     *
     * - Aman    : expired lebih dari 30 hari dari hari ini
     * - Waspada : expired kurang dari atau sama dengan 30 hari
     * - Expired : tanggal expired sudah lewat
     *
     * @return array{label: string, badge: string}
     */
    function status_expired(?string $tanggalExpired): array
    {
        if (!$tanggalExpired) {
            return ['label' => 'Aman', 'badge' => 'success'];
        }

        $today = new \DateTime(date('Y-m-d'));
        $expired = new \DateTime($tanggalExpired);

        $days = (int) $today->diff($expired)->format('%r%a');

        if ($days < 0) {
            return ['label' => 'Expired', 'badge' => 'danger'];
        }

        if ($days <= 30) {
            return ['label' => 'Waspada', 'badge' => 'warning'];
        }

        return ['label' => 'Aman', 'badge' => 'success'];
    }
}

if (!function_exists('badge_status_resep')) {
    /**
     * Badge Bootstrap untuk status resep.
     *
     * @return string
     */
    function badge_status_resep(string $status): string
    {
        return $status === 'Sudah Diambil' ? 'success' : 'warning';
    }
}

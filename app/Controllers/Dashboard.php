<?php

namespace App\Controllers;

use App\Models\ObatModel;
use App\Models\ResepModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $obatModel  = new ObatModel();
        $resepModel = new ResepModel();

        $semuaObat = $obatModel->findAll();

        $totalJenis = count($semuaObat);
        $totalStok  = array_sum(array_column($semuaObat, 'stok_akhir'));

        $waspada   = 0;
        $expired   = 0;
        $daftarWaspada = [];
        $daftarExpired = [];

        foreach ($semuaObat as $obat) {
            $status = status_expired($obat['tanggal_expired']);

            if ($status['badge'] === 'danger') {
                $expired++;
                $daftarExpired[] = $obat;
            } elseif ($status['badge'] === 'warning') {
                $waspada++;
                $daftarWaspada[] = $obat;
            }
        }

        $resepHariIni = $resepModel->where('tanggal_resep', date('Y-m-d'))->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'              => 'Dashboard',
            'active'             => 'dashboard',
            'totalJenis'         => $totalJenis,
            'totalStok'          => $totalStok,
            'jumlahSehat'        => $totalJenis - $waspada - $expired,
            'jumlahWaspada'      => $waspada,
            'jumlahExpired'      => $expired,
            'daftarWaspada'      => $daftarWaspada,
            'daftarExpired'      => $daftarExpired,
            'resepHariIni'       => $resepHariIni,
            'jumlahResepHariIni' => count($resepHariIni),
        ];

        return view('dashboard/index', $data);
    }
}

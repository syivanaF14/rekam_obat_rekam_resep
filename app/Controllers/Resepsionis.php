<?php

namespace App\Controllers;

use App\Models\DetailResepModel;
use App\Models\ObatModel;
use App\Models\ResepModel;

class Resepsionis extends BaseController
{
    protected $resepModel;
    protected $detailModel;
    protected $obatModel;

    public function __construct()
    {
        $this->resepModel  = new ResepModel();
        $this->detailModel = new DetailResepModel();
        $this->obatModel   = new ObatModel();
    }

    public function index()
    {
        $resepModel = new \App\Models\ResepModel();

        $semuaObat = $this->obatModel->findAll();
        $totalJenis = count($semuaObat);

        $resepHariIni = $resepModel->where('tanggal_resep', date('Y-m-d'))->orderBy('id', 'DESC')->findAll();
        $resepTerakhir = (new \App\Models\ResepModel())->orderBy('tanggal_resep', 'DESC')->orderBy('id', 'DESC')->limit(5)->findAll();

        $totalResep = (new \App\Models\ResepModel())->countAllResults();
        $resepBelumDiambil = (new \App\Models\ResepModel())->where('status', 'Belum Diambil')->countAllResults();
        $resepSudahDiambil = (new \App\Models\ResepModel())->where('status', 'Sudah Diambil')->countAllResults();

        $pasienList = $this->resepModel->select('nama_pasien')->groupBy('nama_pasien')->findAll();
        $totalPasien = count($pasienList);

        $data = [
            'title'               => 'Dashboard Resepsionis',
            'active'              => 'dashboard',
            'totalJenis'          => $totalJenis,
            'totalResep'          => $totalResep,
            'resepBelumDiambil'   => $resepBelumDiambil,
            'resepSudahDiambil'   => $resepSudahDiambil,
            'resepHariIni'        => $resepHariIni,
            'resepTerakhir'       => $resepTerakhir,
            'jumlahResepHariIni'  => count($resepHariIni),
            'totalPasien'         => $totalPasien,
        ];

        return view('resepsionis/dashboard', $data);
    }

    public function pasien()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        $builder = $this->resepModel->builder();
        $builder->select('nama_pasien, COUNT(*) as jumlah_resep, MIN(tanggal_resep) as pertama_kali, MAX(tanggal_resep) as terakhir_kunjungan');
        $builder->groupBy('nama_pasien');
        $builder->orderBy('terakhir_kunjungan', 'DESC');

        if ($keyword !== '') {
            $builder->like('nama_pasien', $keyword);
        }

        $pasien = $builder->get()->getResultArray();

        $data = [
            'title'   => 'Data Pasien',
            'active'  => 'pasien',
            'pasien'  => $pasien,
            'keyword' => $keyword,
        ];

        return view('resepsionis/pasien', $data);
    }

    public function pasienDetail(string $nama)
    {
        $nama = urldecode($nama);

        $resep = $this->resepModel
            ->where('nama_pasien', $nama)
            ->orderBy('tanggal_resep', 'DESC')
            ->findAll();

        if (empty($resep)) {
            return redirect()->to('/resepsionis/pasien')->with('error', 'Pasien tidak ditemukan.');
        }

        $data = [
            'title'     => 'Detail Pasien',
            'active'    => 'pasien',
            'nama'      => $nama,
            'resep'     => $resep,
            'jumlahResep' => count($resep),
        ];

        return view('resepsionis/pasien_detail', $data);
    }

    public function resep()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $status  = trim((string) $this->request->getGet('status'));

        $this->resepModel->orderBy('tanggal_resep', 'DESC')->orderBy('id', 'DESC');

        if ($keyword !== '') {
            $this->resepModel->groupStart()
                ->like('nomor_resep', $keyword)
                ->orLike('nama_pasien', $keyword)
                ->orLike('nama_dokter', $keyword)
                ->orLike('tanggal_resep', $keyword)
                ->groupEnd();
        }

        if ($status !== '' && in_array($status, ['Belum Diambil', 'Sudah Diambil'])) {
            $this->resepModel->where('status', $status);
        }

        $data = [
            'title'   => 'Resep Pasien',
            'active'  => 'resep',
            'resep'   => $this->resepModel->paginate(10),
            'pager'   => $this->resepModel->pager,
            'keyword' => $keyword,
            'status'  => $status,
        ];

        if ($keyword !== '' || $status !== '') {
            $params = [];
            if ($keyword !== '') $params['q'] = $keyword;
            if ($status !== '') $params['status'] = $status;
            $data['pager']->only($params);
        }

        return view('resepsionis/resep', $data);
    }

    public function resepDetail(int $id)
    {
        $resep = $this->resepModel->find($id);

        if (!$resep) {
            return redirect()->to('/resepsionis/resep')->with('error', 'Resep tidak ditemukan.');
        }

        $data = [
            'title'  => 'Detail Resep',
            'active' => 'resep',
            'resep'  => $resep,
            'detail' => $this->detailModel->findByResep($id),
        ];

        return view('resepsionis/resep_detail', $data);
    }
}

<?php

namespace App\Controllers;

use App\Models\ObatModel;

class Obat extends BaseController
{
    protected $obatModel;

    public function __construct()
    {
        $this->obatModel = new ObatModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Rekam Obat',
            'active' => 'obat',
            'obat'   => $this->obatModel->orderBy('tanggal_input', 'DESC')->orderBy('id', 'DESC')->findAll(),
        ];

        return view('obat/index', $data);
    }

    public function create()
    {
        $data = [
            'title'  => 'Tambah Obat',
            'active' => 'obat',
            'action' => site_url('obat/store'),
            'obat'   => null,
        ];

        return view('obat/form', $data);
    }

    public function store()
    {
        if (!$this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->obatModel->save($this->collectData());

        session()->setFlashdata('swal_success', 'Data obat berhasil disimpan.');

        return redirect()->to('/obat');
    }

    public function edit(int $id)
    {
        $obat = $this->obatModel->find($id);

        if (!$obat) {
            return redirect()->to('/obat')->with('error', 'Data obat tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit Obat',
            'active' => 'obat',
            'action' => site_url('obat/update/' . $id),
            'obat'   => $obat,
        ];

        return view('obat/form', $data);
    }

    public function update(int $id)
    {
        if (!$this->obatModel->find($id)) {
            return redirect()->to('/obat')->with('error', 'Data obat tidak ditemukan.');
        }

        if (!$this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->obatModel->update($id, $this->collectData());

        session()->setFlashdata('swal_success', 'Data obat berhasil diubah.');

        return redirect()->to('/obat');
    }

    public function delete(int $id)
    {
        $obat = $this->obatModel->find($id);

        if (!$obat) {
            return redirect()->to('/obat')->with('error', 'Data obat tidak ditemukan.');
        }

        $this->obatModel->delete($id);

        session()->setFlashdata('swal_success', 'Data obat berhasil dihapus.');

        return redirect()->to('/obat');
    }

    private function rules(): array
    {
        return [
            'nama_obat'       => 'required|max_length[150]',
            'tanggal_input'   => 'required|valid_date',
            'periode_stok'    => 'required|max_length[10]',
            'stok_awal'       => 'required|integer|greater_than_equal_to[0]',
            'stok_masuk'      => 'required|integer|greater_than_equal_to[0]',
            'stok_keluar'     => 'permit_empty|integer|greater_than_equal_to[0]',
            'tanggal_expired' => 'required|valid_date',
        ];
    }

    private function collectData(): array
    {
        $stokAwal   = (int) $this->request->getPost('stok_awal');
        $stokMasuk  = (int) $this->request->getPost('stok_masuk');
        $stokKeluar = (int) ($this->request->getPost('stok_keluar') ?: 0);

        return [
            'nama_obat'       => $this->request->getPost('nama_obat'),
            'tanggal_input'   => $this->request->getPost('tanggal_input'),
            'periode_stok'    => $this->request->getPost('periode_stok'),
            'stok_awal'       => $stokAwal,
            'stok_masuk'      => $stokMasuk,
            'stok_keluar'     => $stokKeluar,
            'stok_akhir'      => $stokAwal + $stokMasuk - $stokKeluar,
            'tanggal_expired' => $this->request->getPost('tanggal_expired'),
        ];
    }
}

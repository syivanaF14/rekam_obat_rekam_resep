<?php

namespace App\Controllers;

use App\Models\DetailResepModel;
use App\Models\ObatModel;
use App\Models\ResepModel;

class Resep extends BaseController
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
        $keyword = trim((string) $this->request->getGet('q'));

        $this->resepModel->orderBy('tanggal_resep', 'DESC')->orderBy('id', 'DESC');

        if ($keyword !== '') {
            $this->resepModel->groupStart()
                ->like('nomor_resep', $keyword)
                ->orLike('nama_pasien', $keyword)
                ->orLike('nama_dokter', $keyword)
                ->orLike('tanggal_resep', $keyword)
                ->groupEnd();
        }

        $data = [
            'title'  => 'Riwayat Resep',
            'active' => 'resep',
            'resep'  => $this->resepModel->paginate(10),
            'pager'  => $this->resepModel->pager,
            'keyword' => $keyword,
        ];

        if ($keyword !== '') {
            $data['pager']->only(['q' => $keyword]);
        }

        return view('resep/index', $data);
    }

    public function create()
    {
        $data = [
            'title'       => 'Tambah Resep',
            'active'      => 'resep',
            'action'      => site_url('resep/store'),
            'resep'       => null,
            'detail'      => [],
            'obat'        => $this->obatModel->orderBy('nama_obat', 'ASC')->findAll(),
            'edit'        => false,
            'nomor_resep' => $this->resepModel->generateNomorResep(),
        ];

        return view('resep/form', $data);
    }

    public function store()
    {
        if (!$this->validate($this->rulesMaster())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $details = $this->collectDetails();

        if (empty($details)) {
            return redirect()->back()->withInput()->with('error', 'Minimal satu obat harus diisi.');
        }

        $stockError = $this->validateStock($details);
        if ($stockError) {
            return redirect()->back()->withInput()->with('error', $stockError);
        }

        $db = db_connect();
        $db->transStart();

        $resepId = $this->resepModel->insert([
            'nomor_resep'   => $this->resepModel->generateNomorResep(),
            'tanggal_resep' => $this->request->getPost('tanggal_resep'),
            'nama_pasien'   => $this->request->getPost('nama_pasien'),
            'nama_dokter'   => $this->request->getPost('nama_dokter'),
            'diagnosa'      => $this->request->getPost('diagnosa') ?: null,
            'status'        => $this->request->getPost('status'),
            'nama_apoteker' => $this->request->getPost('nama_apoteker'),
            'catatan'       => $this->request->getPost('catatan') ?: null,
        ]);

        foreach ($details as $d) {
            $this->detailModel->insert([
                'resep_id'    => $resepId,
                'obat_id'     => $d['obat_id'],
                'jumlah'      => $d['jumlah'],
                'dosis'       => $d['dosis'],
                'aturan_pakai' => $d['aturan_pakai'],
            ]);

            $this->deductStock($d['obat_id'], $d['jumlah']);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan resep.');
        }

        session()->setFlashdata('swal_success', 'Resep berhasil disimpan dan stok obat berkurang.');

        return redirect()->to('/resep');
    }

    public function detail(int $id)
    {
        $resep = $this->resepModel->find($id);

        if (!$resep) {
            return redirect()->to('/resep')->with('error', 'Resep tidak ditemukan.');
        }

        $data = [
            'title'  => 'Detail Resep',
            'active' => 'resep',
            'resep'  => $resep,
            'detail' => $this->detailModel->findByResep($id),
        ];

        return view('resep/detail', $data);
    }

    public function edit(int $id)
    {
        $resep = $this->resepModel->find($id);

        if (!$resep) {
            return redirect()->to('/resep')->with('error', 'Resep tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit Resep',
            'active' => 'resep',
            'action' => site_url('resep/update/' . $id),
            'resep'  => $resep,
            'detail' => $this->detailModel->findByResep($id),
            'obat'   => $this->obatModel->orderBy('nama_obat', 'ASC')->findAll(),
            'edit'   => true,
        ];

        return view('resep/form', $data);
    }

    public function update(int $id)
    {
        $resep = $this->resepModel->find($id);

        if (!$resep) {
            return redirect()->to('/resep')->with('error', 'Resep tidak ditemukan.');
        }

        if (!$this->validate($this->rulesMaster())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $oldDetails = $this->detailModel->findByResep($id);
        $newDetails = $this->collectDetails();

        if (empty($newDetails)) {
            return redirect()->back()->withInput()->with('error', 'Minimal satu obat harus diisi.');
        }

        $stockError = $this->validateStock($newDetails);
        if ($stockError) {
            return redirect()->back()->withInput()->with('error', $stockError);
        }

        $db = db_connect();
        $db->transStart();

        foreach ($oldDetails as $old) {
            $this->restoreStock((int) $old['obat_id'], (int) $old['jumlah']);
        }

        $this->resepModel->update($id, [
            'tanggal_resep' => $this->request->getPost('tanggal_resep'),
            'nama_pasien'   => $this->request->getPost('nama_pasien'),
            'nama_dokter'   => $this->request->getPost('nama_dokter'),
            'diagnosa'      => $this->request->getPost('diagnosa') ?: null,
            'status'        => $this->request->getPost('status'),
            'nama_apoteker' => $this->request->getPost('nama_apoteker'),
            'catatan'       => $this->request->getPost('catatan') ?: null,
        ]);

        $this->detailModel->where('resep_id', $id)->delete();

        foreach ($newDetails as $d) {
            $this->detailModel->insert([
                'resep_id'    => $id,
                'obat_id'     => $d['obat_id'],
                'jumlah'      => $d['jumlah'],
                'dosis'       => $d['dosis'],
                'aturan_pakai' => $d['aturan_pakai'],
            ]);

            $this->deductStock($d['obat_id'], $d['jumlah']);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengubah resep.');
        }

        session()->setFlashdata('swal_success', 'Resep berhasil diubah dan stok obat diperbarui.');

        return redirect()->to('/resep');
    }

    public function delete(int $id)
    {
        $resep = $this->resepModel->find($id);

        if (!$resep) {
            return redirect()->to('/resep')->with('error', 'Resep tidak ditemukan.');
        }

        $details = $this->detailModel->findByResep($id);

        $db = db_connect();
        $db->transStart();

        foreach ($details as $d) {
            $this->restoreStock((int) $d['obat_id'], (int) $d['jumlah']);
        }

        $this->resepModel->delete($id);

        $db->transComplete();

        session()->setFlashdata('swal_success', 'Resep berhasil dihapus dan stok dikembalikan.');

        return redirect()->to('/resep');
    }

    private function rulesMaster(): array
    {
        return [
            'tanggal_resep' => 'required|valid_date',
            'nama_pasien'   => 'required|max_length[150]',
            'nama_dokter'   => 'required|max_length[150]',
            'diagnosa'      => 'permit_empty|max_length[255]',
            'status'        => 'required|in_list[Belum Diambil,Sudah Diambil]',
            'nama_apoteker' => 'required|max_length[150]',
            'obat_id'       => 'required',
        ];
    }

    private function collectDetails(): array
    {
        $obatId = $this->request->getPost('obat_id') ?: [];
        $jumlah = $this->request->getPost('jumlah') ?: [];
        $dosis  = $this->request->getPost('dosis') ?: [];
        $aturan = $this->request->getPost('aturan_pakai') ?: [];

        $details = [];

        foreach ($obatId as $i => $id) {
            $id  = (int) $id;
            $qty = (int) ($jumlah[$i] ?? 0);

            if ($id <= 0 || $qty <= 0) {
                continue;
            }

            $details[] = [
                'obat_id'      => $id,
                'jumlah'       => $qty,
                'dosis'        => trim((string) ($dosis[$i] ?? '')),
                'aturan_pakai' => trim((string) ($aturan[$i] ?? '')),
            ];
        }

        return $details;
    }

    private function validateStock(array $details): ?string
    {
        foreach ($details as $d) {
            $obat = $this->obatModel->find($d['obat_id']);

            if (!$obat) {
                return 'Obat tidak ditemukan.';
            }

            if ($d['jumlah'] > (int) $obat['stok_akhir']) {
                return 'Stok obat "' . $obat['nama_obat'] . '" tidak mencukupi. Sisa stok: ' . $obat['stok_akhir'];
            }
        }

        return null;
    }

    private function deductStock(int $obatId, int $jumlah): void
    {
        $obat = $this->obatModel->find($obatId);

        if (!$obat) {
            return;
        }

        $this->obatModel->update($obatId, [
            'stok_akhir'   => (int) $obat['stok_akhir'] - $jumlah,
            'stok_keluar'  => (int) $obat['stok_keluar'] + $jumlah,
        ]);
    }

    private function restoreStock(int $obatId, int $jumlah): void
    {
        $obat = $this->obatModel->find($obatId);

        if (!$obat) {
            return;
        }

        $this->obatModel->update($obatId, [
            'stok_akhir'  => (int) $obat['stok_akhir'] + $jumlah,
            'stok_keluar' => max(0, (int) $obat['stok_keluar'] - $jumlah),
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailResepModel extends Model
{
    protected $table         = 'detail_resep';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'resep_id',
        'obat_id',
        'jumlah',
        'dosis',
        'aturan_pakai',
    ];

    public function findByResep(int $resepId)
    {
        return $this->join('obat', 'obat.id = detail_resep.obat_id')
                    ->where('detail_resep.resep_id', $resepId)
                    ->select('detail_resep.*, obat.nama_obat, obat.stok_akhir AS stok_obat')
                    ->orderBy('detail_resep.id', 'ASC')
                    ->findAll();
    }
}

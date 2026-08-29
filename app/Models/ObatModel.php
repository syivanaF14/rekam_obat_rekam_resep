<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table         = 'obat';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'nama_obat',
        'tanggal_input',
        'periode_stok',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_akhir',
        'tanggal_expired',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

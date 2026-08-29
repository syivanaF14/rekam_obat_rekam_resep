<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepModel extends Model
{
    protected $table         = 'resep';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'nomor_resep',
        'tanggal_resep',
        'nama_pasien',
        'nama_dokter',
        'diagnosa',
        'status',
        'nama_apoteker',
        'catatan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function generateNomorResep(string $tahun = null): string
    {
        $tahun = $tahun ?? date('Y');
        $prefix = 'RSP-' . $tahun;

        $last = $this->like('nomor_resep', $prefix . '%', 'after')
                    ->selectMax('nomor_resep')
                    ->first();

        $seq = 1;

        if ($last && !empty($last['nomor_resep'])) {
            $seq = (int) substr($last['nomor_resep'], -6) + 1;
        }

        return $prefix . str_pad((string) $seq, 6, '0', STR_PAD_LEFT);
    }
}

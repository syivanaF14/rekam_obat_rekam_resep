<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('obat')->insertBatch([
            [
                'nama_obat'       => 'Paracetamol 500mg',
                'tanggal_input'   => '2026-08-01',
                'periode_stok'    => '08-2026',
                'stok_awal'       => 100,
                'stok_masuk'      => 50,
                'stok_keluar'     => 20,
                'stok_akhir'      => 130,
                'tanggal_expired' => '2026-12-31',
            ],
            [
                'nama_obat'       => 'Amoxicillin 500mg',
                'tanggal_input'   => '2026-08-02',
                'periode_stok'    => '08-2026',
                'stok_awal'       => 80,
                'stok_masuk'      => 40,
                'stok_keluar'     => 15,
                'stok_akhir'      => 105,
                'tanggal_expired' => '2027-06-30',
            ],
            [
                'nama_obat'       => 'Antasida DOEN',
                'tanggal_input'   => '2026-08-03',
                'periode_stok'    => '08-2026',
                'stok_awal'       => 60,
                'stok_masuk'      => 0,
                'stok_keluar'     => 10,
                'stok_akhir'      => 50,
                'tanggal_expired' => '2026-08-20',
            ],
            [
                'nama_obat'       => 'Vitamin C 50mg',
                'tanggal_input'   => '2026-07-20',
                'periode_stok'    => '07-2026',
                'stok_awal'       => 200,
                'stok_masuk'      => 0,
                'stok_keluar'     => 50,
                'stok_akhir'      => 150,
                'tanggal_expired' => '2026-06-30',
            ],
            [
                'nama_obat'       => 'Ibuprofen 200mg',
                'tanggal_input'   => '2026-07-25',
                'periode_stok'    => '07-2026',
                'stok_awal'       => 90,
                'stok_masuk'      => 0,
                'stok_keluar'     => 30,
                'stok_akhir'      => 60,
                'tanggal_expired' => '2026-07-15',
            ],
        ]);
    }
}

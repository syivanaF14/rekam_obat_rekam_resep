<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insertBatch([
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'username' => 'apoteker',
                'password' => password_hash('apoteker', PASSWORD_DEFAULT),
                'role'     => 'apoteker',
            ],
            [
                'username' => 'resepsionis',
                'password' => password_hash('resepsionis', PASSWORD_DEFAULT),
                'role'     => 'resepsionis',
            ],
        ]);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResep extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nomor_resep' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'tanggal_resep' => [
                'type' => 'DATE',
            ],
            'nama_pasien' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'nama_dokter' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'diagnosa' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'Belum Diambil',
            ],
            'nama_apoteker' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('nomor_resep');
        $this->forge->createTable('resep');
    }

    public function down()
    {
        $this->forge->dropTable('resep');
    }
}

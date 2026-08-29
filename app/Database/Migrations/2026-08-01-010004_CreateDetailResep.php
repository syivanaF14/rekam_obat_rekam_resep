<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailResep extends Migration
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
            'resep_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'obat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'dosis' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'aturan_pakai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('resep_id');
        $this->forge->addForeignKey('resep_id', 'resep', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_resep');
    }

    public function down()
    {
        $this->forge->dropTable('detail_resep');
    }
}

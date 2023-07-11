<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLapakTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'img_lapak' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'title_lapak' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'short_description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description_lapak' => [
                'type' => 'TEXT'
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('lapak');
    }

    public function down()
    {
        $this->forge->dropTable('lapak');
    }
}

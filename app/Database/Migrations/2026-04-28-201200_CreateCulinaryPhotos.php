<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCulinaryPhotos extends Migration
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
            'location_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'photo_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('location_id', 'culinary_locations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('culinary_photos');
    }

    public function down()
    {
        $this->forge->dropTable('culinary_photos');
    }
}

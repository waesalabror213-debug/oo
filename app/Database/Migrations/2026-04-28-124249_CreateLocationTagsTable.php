<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLocationTagsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'location_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tag_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('location_id', 'culinary_locations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('location_tags');
    }

    public function down()
    {
        $this->forge->dropTable('location_tags');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('roles', true); // true = IF NOT EXISTS
    }

    public function down(): void
    {
        $this->forge->dropTable('roles', true);
    }
}
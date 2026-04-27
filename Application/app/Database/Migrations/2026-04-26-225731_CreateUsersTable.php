<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'matricule' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
            ],
            'prenom' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role_id' => [
                'type'     => 'TINYINT',
                'unsigned' => true,
            ],
            'departement' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'filiere' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'numero_ordre_medical' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'actif' => [
                'type'    => 'TINYINT',
                'default' => 1,
            ],
            'statut' => [
                'type'       => 'ENUM',
                'constraint' => ['actif', 'inactif', 'en_attente'],
                'default'    => 'actif',
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users');
    }

    public function down(): void
    {
        $this->forge->dropTable('users');
    }
}
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeriodesVisiteTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'titre' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'departement' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'filiere' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'date_debut' => [
                'type' => 'DATE',
            ],
            'date_fin' => [
                'type' => 'DATE',
            ],
            'max_par_creneau' => [
                'type'    => 'TINYINT',
                'default' => 5,
            ],
            'duree_consultation' => [
                'type'    => 'TINYINT',
                'default' => 15,
            ],
            'medecin_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'statut' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'terminee', 'annulee'],
                'default'    => 'active',
            ],
            'created_by' => [
                'type'     => 'INT',
                'unsigned' => true,
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
        $this->forge->addForeignKey('medecin_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('periodes_visite', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('periodes_visite', true);
    }
}
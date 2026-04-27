<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRendezVousTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'etudiant_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'creneau_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'periode_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'statut' => [
                'type'       => 'ENUM',
                'constraint' => ['confirme', 'annule', 'present', 'absent'],
                'default'    => 'confirme',
            ],
            'est_urgent' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'rappel_envoye' => [
                'type'    => 'TINYINT',
                'default' => 0,
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
        $this->forge->addForeignKey('etudiant_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('creneau_id', 'creneaux', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('periode_id', 'periodes_visite', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rendezvous', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('rendezvous', true);
    }
}
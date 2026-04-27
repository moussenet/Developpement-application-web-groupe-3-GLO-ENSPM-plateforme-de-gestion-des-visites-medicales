<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCreneauxTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'periode_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'date_creneau' => [
                'type' => 'DATE',
            ],
            'heure_debut' => [
                'type' => 'TIME',
            ],
            'heure_fin' => [
                'type' => 'TIME',
            ],
            'places_total' => [
                'type'    => 'TINYINT',
                'default' => 5,
            ],
            'places_prises' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'est_urgent' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('periode_id', 'periodes_visite', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('creneaux', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('creneaux', true);
    }
}
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('roles')->delete();
        $this->db->table('roles')->insertBatch([
            ['id' => 1, 'name' => 'superadmin', 'label' => 'Super Administrateur'],
            ['id' => 2, 'name' => 'admin',      'label' => 'Administrateur'],
            ['id' => 3, 'name' => 'medecin',    'label' => 'Personnel médical'],
            ['id' => 4, 'name' => 'etudiant',   'label' => 'Étudiant'],
        ]);
    }
}
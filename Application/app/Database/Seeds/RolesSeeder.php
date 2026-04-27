<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('roles')->insertBatch([
            ['id' => 1, 'name' => 'etudiant', 'label' => 'Étudiant'],
            ['id' => 2, 'name' => 'medecin',  'label' => 'Personnel médical'],
            ['id' => 3, 'name' => 'admin',    'label' => 'Administrateur'],
        ]);
    }
}
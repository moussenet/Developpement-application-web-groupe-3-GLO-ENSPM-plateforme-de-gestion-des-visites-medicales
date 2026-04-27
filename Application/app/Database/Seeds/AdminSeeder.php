<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('users')->insert([
            'nom'           => 'Super',
            'prenom'        => 'Admin',
            'email'         => 'admin@medicampus.cm',
            'password_hash' => password_hash('Admin@2025', PASSWORD_DEFAULT),
            'role_id'       => 3,
            'actif'         => 1,
            'statut'        => 'actif',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
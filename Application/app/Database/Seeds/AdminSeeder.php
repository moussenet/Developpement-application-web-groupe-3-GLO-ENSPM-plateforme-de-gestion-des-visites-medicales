<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si le superadmin existe déjà
        $exists = $this->db->table('users')
                           ->where('email', 'superadmin@medicampus.cm')
                           ->countAllResults();

        if (! $exists) {
            $this->db->table('users')->insert([
                'nom'           => 'Super',
                'prenom'        => 'Admin',
                'email'         => 'superadmin@medicampus.cm',
                'password_hash' => password_hash('SuperAdmin@2025', PASSWORD_DEFAULT),
                'role_id'       => 1,
                'actif'         => 1,
                'statut'        => 'actif',
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
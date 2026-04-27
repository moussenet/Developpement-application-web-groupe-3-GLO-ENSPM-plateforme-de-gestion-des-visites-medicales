<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'matricule', 'nom', 'prenom', 'email',
        'password_hash', 'role_id', 'departement',
        'filiere', 'numero_ordre_medical', 'actif', 'statut',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Règles de validation étudiant
    public array $validationEtudiant = [
        'nom'              => 'required|min_length[2]|max_length[80]',
        'prenom'           => 'required|min_length[2]|max_length[80]',
        'matricule'        => 'required|is_unique[users.matricule]',
        'departement'      => 'required',
        'filiere'          => 'required',
        'email'            => 'required|valid_email|is_unique[users.email]',
        'password'         => 'required|min_length[8]',
        'confirm_password' => 'required|matches[password]',
    ];

    // Règles de validation staff (admin/médecin)
    public array $validationStaff = [
        'nom'      => 'required|min_length[2]|max_length[80]',
        'prenom'   => 'required|min_length[2]|max_length[80]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'role_id'  => 'required|in_list[2,3]',
    ];

    // Messages personnalisés — nom différent de $validationMessages
    public array $customMessages = [
        'matricule' => [
            'is_unique' => 'Ce matricule est déjà utilisé.',
        ],
        'email' => [
            'is_unique' => 'Cette adresse email est déjà utilisée.',
        ],
        'confirm_password' => [
            'matches' => 'Les mots de passe ne correspondent pas.',
        ],
        'password' => [
            'min_length' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ],
    ];

    public function findByEmail(string $email): array|null
    {
        return $this->select('users.*, roles.name as role_name, roles.label as role_label')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('users.email', $email)
                    ->where('users.actif', 1)
                    ->first();
    }

    public function getUserWithRole(int $id): array|null
    {
        return $this->select('users.*, roles.name as role_name, roles.label as role_label')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('users.id', $id)
                    ->first();
    }

    public function getStaff(): array
    {
        return $this->select('users.*, roles.label as role_label')
                    ->join('roles', 'roles.id = users.role_id')
                    ->whereIn('users.role_id', [2, 3])
                    ->orderBy('users.role_id', 'ASC')
                    ->findAll();
    }
}
<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
    }

    // Liste admins + médecins
    public function index(): string
    {
        return view('superadmin/users/index', [
            'title' => 'Gestion des comptes — Super Admin',
            'users' => $this->userModel
                            ->select('users.*, roles.label as role_label')
                            ->join('roles', 'roles.id = users.role_id')
                            ->whereIn('users.role_id', [2, 3])
                            ->orderBy('users.role_id', 'ASC')
                            ->orderBy('users.nom', 'ASC')
                            ->findAll(),
        ]);
    }

    // Formulaire création
    public function create(): string
    {
        return view('superadmin/users/create', [
            'title' => 'Créer un compte — Super Admin',
        ]);
    }

    // Enregistrement
    public function store()
    {
        $roleId = (int) $this->request->getPost('role_id');

        $rules = [
            'nom'      => 'required|min_length[2]|max_length[80]',
            'prenom'   => 'permit_empty|min_length[2]|max_length[80]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'role_id'  => 'required|in_list[2,3]',
        ];

        $messages = [
            'email'    => ['is_unique' => 'Cette adresse email est déjà utilisée.'],
            'password' => ['min_length' => 'Le mot de passe doit contenir au moins 8 caractères.'],
        ];

        // Champs spécifiques selon le rôle
        if ($roleId === 2) {
            // Administrateur — ID vérifié par la direction
            $rules['id_direction'] = 'required|min_length[3]|is_unique[users.id_direction]';
            $messages['id_direction'] = [
                'is_unique' => 'Cet ID direction est déjà utilisé.',
                'required'  => 'L\'ID direction est obligatoire pour un administrateur.',
            ];
        }

        if ($roleId === 3) {
            // Personnel médical — numéro ordre médical
            $rules['numero_ordre_medical'] = 'required|min_length[4]|is_unique[users.numero_ordre_medical]';
            $messages['numero_ordre_medical'] = [
                'is_unique' => 'Ce numéro d\'ordre médical est déjà utilisé.',
                'required'  => 'Le numéro d\'ordre médical est obligatoire.',
            ];
        }

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $insert = [
            'nom'           => $this->request->getPost('nom'),
            'prenom'        => $this->request->getPost('prenom'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash(
                                   $this->request->getPost('password'),
                                   PASSWORD_DEFAULT
                               ),
            'role_id' => $roleId,
            'actif'   => 1,
            'statut'  => 'actif',
        ];

        if ($roleId === 2) {
            $insert['id_direction'] = strtoupper(trim($this->request->getPost('id_direction')));
        }

        if ($roleId === 3) {
            $insert['numero_ordre_medical'] = $this->request->getPost('numero_ordre_medical');
            $insert['specialite']           = $this->request->getPost('specialite');
        }

        $this->userModel->insert($insert);

        return redirect()->to(base_url('superadmin/users'))
                         ->with('success', 'Compte créé avec succès.');
    }

    // Activer / désactiver
    public function toggleActif(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(base_url('superadmin/users'))
                             ->with('error', 'Utilisateur introuvable.');
        }

        $this->userModel->update($id, [
            'actif'  => $user['actif'] ? 0 : 1,
            'statut' => $user['actif'] ? 'inactif' : 'actif',
        ]);

        return redirect()->to(base_url('superadmin/users'))
                         ->with('success', 'Statut du compte mis à jour.');
    }

    // Suppression
    public function delete(int $id)
    {
        $this->userModel->delete($id);
        return redirect()->to(base_url('superadmin/users'))
                         ->with('success', 'Compte supprimé.');
    }
}
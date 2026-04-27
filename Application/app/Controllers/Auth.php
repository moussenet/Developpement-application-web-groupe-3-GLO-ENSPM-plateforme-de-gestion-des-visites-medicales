<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // -------------------------------------------------------------------------
    // LOGIN
    // -------------------------------------------------------------------------

    public function login()
    {
        helper('form');
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role_name'));
        }
        return view('auth/login', ['title' => 'Connexion — CMS-ENSPM']);
    }

    public function loginPost()
    {
        helper('form');

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $user  = $model->findByEmail($this->request->getPost('email'));

        if (! $user || ! password_verify($this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'    => $user['id'],
            'user_nom'   => $user['nom'] . ' ' . $user['prenom'],
            'user_email' => $user['email'],
            'role_name'  => $user['role_name'],
            'logged_in'  => true,
        ]);

        return $this->redirectByRole($user['role_name']);
    }

    // -------------------------------------------------------------------------
    // LOGOUT
    // -------------------------------------------------------------------------

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))
                         ->with('success', 'Vous êtes déconnecté.');
    }

    // -------------------------------------------------------------------------
    // REGISTER (étudiants uniquement)
    // -------------------------------------------------------------------------

    public function register(): string
    {
        helper('form');

        $departements = [
            'Énergies Renouvelables',
            'Agriculture, Élevage et Produits Dérivés (AGEPD)',
            'Génie Civil et Architecture (GCA)',
            'Hydraulique et Maîtrise des Eaux (HYMAE)',
            'Informatique et Télécommunications (INFOTEL)',
            'Sciences Environnementales (SCIENV)',
            'Génie Textile et Cuir',
            'Météorologie, Climatologie, Hydrologie et Pédologie (MCHP)',
            'Art et Humanités Numériques (AHN)',
        ];

        $filieres = [
            'Énergies Renouvelables' => [
                'Solaire photovoltaïque',
                'Solaire thermique',
                'Éolien',
                'Biomasse',
                'Hydro-électricité',
            ],
            'Agriculture, Élevage et Produits Dérivés (AGEPD)' => [
                'Agronomie',
                'Zootechnie',
                'Pisciculture',
                'Agroforesterie',
                'Industrie alimentaire',
            ],
            'Génie Civil et Architecture (GCA)' => [
                'Génie civil',
                'Architecture',
            ],
            'Hydraulique et Maîtrise des Eaux (HYMAE)' => [
                'Hydraulique et maîtrise des eaux',
            ],
            'Informatique et Télécommunications (INFOTEL)' => [
                'Informatique',
                'Télécommunications',
            ],
            'Sciences Environnementales (SCIENV)' => [
                'Génie de l\'environnement',
                'Hygiène, sûreté et sécurité industrielle',
            ],
            'Génie Textile et Cuir' => [
                'Génie textile',
                'Génie du cuir',
            ],
            'Météorologie, Climatologie, Hydrologie et Pédologie (MCHP)' => [
                'Météorologie',
                'Climatologie',
                'Hydrologie',
                'Pédologie',
            ],
            'Art et Humanités Numériques (AHN)' => [
                'Art numérique',
                'Humanités numériques',
            ],
        ];

        return view('auth/register', [
            'title'        => 'Inscription étudiant — CMS-ENSPM',
            'departements' => $departements,
            'filieres'     => $filieres,
        ]);
    }

    public function registerPost()
    {
        helper('form');
        $model = new UserModel();

        $rules = [
            'nom'              => 'required|min_length[2]|max_length[80]',
            'prenom'           => 'required|min_length[2]|max_length[80]',
            'matricule'        => 'required|is_unique[users.matricule]',
            'departement'      => 'required',
            'filiere'          => 'required',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        $messages = [
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

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'nom'           => $this->request->getPost('nom'),
            'prenom'        => $this->request->getPost('prenom'),
            'matricule'     => strtoupper(trim($this->request->getPost('matricule'))),
            'departement'   => $this->request->getPost('departement'),
            'filiere'       => $this->request->getPost('filiere'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash(
                                   $this->request->getPost('password'),
                                   PASSWORD_DEFAULT
                               ),
            'role_id' => 1,
            'actif'   => 1,
            'statut'  => 'actif',
        ]);

        return redirect()->to(base_url('login'))
                         ->with('success', 'Compte créé avec succès. Connectez-vous.');
    }

    // -------------------------------------------------------------------------
    // HELPER PRIVÉ
    // -------------------------------------------------------------------------

    private function redirectByRole(string $role)
    {
        return match($role) {
            'admin'   => redirect()->to(base_url('admin/dashboard')),
            'medecin' => redirect()->to(base_url('medecin/dashboard')),
            default   => redirect()->to(base_url('etudiant/dashboard')),
        };
    }
}
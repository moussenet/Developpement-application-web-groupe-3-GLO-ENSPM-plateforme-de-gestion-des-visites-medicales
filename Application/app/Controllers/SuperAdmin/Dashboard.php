<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PeriodeVisiteModel;
use App\Models\RendezVousModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $userModel    = new UserModel();
        $periodeModel = new PeriodeVisiteModel();
        $rdvModel     = new RendezVousModel();

        return view('superadmin/dashboard', [
            'title'          => 'Super Administration — MediCampus',
            'nb_admins'      => $userModel->where('role_id', 2)->countAllResults(),
            'nb_medecins'    => $userModel->where('role_id', 3)->countAllResults(),
            'nb_etudiants'   => $userModel->where('role_id', 4)->countAllResults(),
            'nb_periodes'    => $periodeModel->countAll(),
            'nb_rdv'         => $rdvModel->countAll(),
            'derniers_users' => $userModel->select('users.*, roles.label as role_label')
                                          ->join('roles', 'roles.id = users.role_id')
                                          ->whereIn('users.role_id', [2, 3])
                                          ->orderBy('users.created_at', 'DESC')
                                          ->limit(5)
                                          ->findAll(),
        ]);
    }
}
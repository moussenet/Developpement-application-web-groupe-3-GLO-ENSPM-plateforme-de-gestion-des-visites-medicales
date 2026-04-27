<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeriodeVisiteModel;
use App\Models\RendezVousModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $periodeModel = new PeriodeVisiteModel();
        $rdvModel     = new RendezVousModel();
        $userModel    = new UserModel();

        return view('admin/dashboard', [
            'title'               => 'Tableau de bord — Administration',
            'user_nom'            => session()->get('user_nom'),
            'nb_periodes'         => $periodeModel->countAll(),
            'nb_periodes_actives' => $periodeModel->where('statut', 'active')->countAllResults(),
            'nb_etudiants'        => $userModel->where('role_id', 1)->countAllResults(),
            'nb_medecins'         => $userModel->where('role_id', 2)->countAllResults(),
            'nb_rendezvous'       => $rdvModel->where('statut', 'confirme')->countAllResults(),
            'nb_urgents'          => $rdvModel->where('est_urgent', 1)->countAllResults(),
            'dernieres_periodes'  => $periodeModel->select('periodes_visite.*')
                                                   ->orderBy('created_at', 'DESC')
                                                   ->limit(5)
                                                   ->findAll(),
        ]);
    }
}
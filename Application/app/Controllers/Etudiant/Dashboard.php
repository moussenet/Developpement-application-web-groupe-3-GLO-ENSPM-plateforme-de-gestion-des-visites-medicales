<?php

namespace App\Controllers\Etudiant;

use App\Controllers\BaseController;
use App\Models\PeriodeVisiteModel;
use App\Models\RendezVousModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $periodeModel = new PeriodeVisiteModel();
        $rdvModel     = new RendezVousModel();
        $etudiantId   = session()->get('user_id');

        // Périodes actives du département de l'étudiant
        $periodes = $periodeModel->getPeriodesActives();

        // RDV de l'étudiant
        $rendezvous = $rdvModel->getRdvEtudiant($etudiantId);

        // Prochain RDV confirmé
        $prochainRdv = null;
        foreach ($rendezvous as $rdv) {
            if ($rdv['statut'] === 'confirme' && $rdv['date_creneau'] >= date('Y-m-d')) {
                $prochainRdv = $rdv;
                break;
            }
        }

        return view('etudiant/dashboard', [
            'title'        => 'Mon espace — Dashboard',
            'user_nom'     => session()->get('user_nom'),
            'periodes'     => $periodes,
            'rendezvous'   => $rendezvous,
            'prochainRdv'  => $prochainRdv,
            'nb_periodes'  => count($periodes),
            'nb_rdv'       => count($rendezvous),
        ]);
    }
}
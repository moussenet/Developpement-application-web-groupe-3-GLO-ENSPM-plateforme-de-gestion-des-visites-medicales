<?php

namespace App\Controllers\Etudiant;

use App\Controllers\BaseController;
use App\Models\RendezVousModel;
use App\Models\CreneauModel;
use App\Models\PeriodeVisiteModel;

class RendezVous extends BaseController
{
    protected RendezVousModel    $rdvModel;
    protected CreneauModel       $creneauModel;
    protected PeriodeVisiteModel $periodeModel;

    public function __construct()
    {
        $this->rdvModel     = new RendezVousModel();
        $this->creneauModel = new CreneauModel();
        $this->periodeModel = new PeriodeVisiteModel();
    }

    // -------------------------------------------------------------------------
    // LISTE DES RDV DE L'ÉTUDIANT
    // -------------------------------------------------------------------------

    public function index(): string
    {
        $etudiantId = session()->get('user_id');

        return view('etudiant/rendezvous/index', [
            'title'      => 'Mes rendez-vous',
            'rendezvous' => $this->rdvModel->getRdvEtudiant($etudiantId),
        ]);
    }

    // -------------------------------------------------------------------------
    // PRENDRE UN RDV
    // -------------------------------------------------------------------------

    public function store()
    {
        $etudiantId = session()->get('user_id');
        $creneauId  = (int) $this->request->getPost('creneau_id');
        $periodeId  = (int) $this->request->getPost('periode_id');

        // 1. Vérifier que le créneau existe
        $creneau = $this->creneauModel->find($creneauId);
        if (! $creneau) {
            return redirect()->back()
                             ->with('error', 'Créneau introuvable.');
        }

        // 2. Vérifier qu'il reste des places
        if ($creneau['places_prises'] >= $creneau['places_total']) {
            return redirect()->back()
                             ->with('error', 'Ce créneau est complet. Veuillez en choisir un autre.');
        }

        // 3. Vérifier que l'étudiant n'a pas déjà un RDV pour cette période
        if ($this->rdvModel->aDejaRdv($etudiantId, $periodeId)) {
            return redirect()->back()
                             ->with('error', 'Vous avez déjà un rendez-vous pour cette période.');
        }

        // 4. Enregistrer le RDV
        $this->rdvModel->insert([
            'etudiant_id'   => $etudiantId,
            'creneau_id'    => $creneauId,
            'periode_id'    => $periodeId,
            'statut'        => 'confirme',
            'est_urgent'    => 0,
            'rappel_envoye' => 0,
        ]);

        // 5. Incrémenter les places prises
        $this->creneauModel->incrementerPlaces($creneauId);

        return redirect()->to(base_url('etudiant/rendezvous'))
                         ->with('success', 'Rendez-vous confirmé avec succès !');
    }

    // -------------------------------------------------------------------------
    // ANNULER UN RDV
    // -------------------------------------------------------------------------

    public function annuler(int $id)
    {
        $etudiantId = session()->get('user_id');

        // Récupérer le RDV
        $rdv = $this->rdvModel->find($id);

        if (! $rdv) {
            return redirect()->to(base_url('etudiant/rendezvous'))
                             ->with('error', 'Rendez-vous introuvable.');
        }

        // Vérifier que ce RDV appartient bien à l'étudiant connecté
        if ($rdv['etudiant_id'] != $etudiantId) {
            return redirect()->to(base_url('etudiant/rendezvous'))
                             ->with('error', 'Action non autorisée.');
        }

        // Vérifier que le RDV est encore annulable (statut confirme)
        if ($rdv['statut'] !== 'confirme') {
            return redirect()->to(base_url('etudiant/rendezvous'))
                             ->with('error', 'Ce rendez-vous ne peut plus être annulé.');
        }

        // Vérifier que la date n'est pas dépassée
        $creneau = $this->creneauModel->find($rdv['creneau_id']);
        if ($creneau && $creneau['date_creneau'] < date('Y-m-d')) {
            return redirect()->to(base_url('etudiant/rendezvous'))
                             ->with('error', 'Impossible d\'annuler un rendez-vous passé.');
        }

        // Annuler le RDV
        $this->rdvModel->update($id, ['statut' => 'annule']);

        // Libérer la place
        $this->creneauModel->decrementerPlaces($rdv['creneau_id']);

        return redirect()->to(base_url('etudiant/rendezvous'))
                         ->with('success', 'Rendez-vous annulé.');
    }
}
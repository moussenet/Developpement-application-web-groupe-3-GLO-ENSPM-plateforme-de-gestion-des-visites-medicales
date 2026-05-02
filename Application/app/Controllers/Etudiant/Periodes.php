<?php

namespace App\Controllers\Etudiant;

use App\Controllers\BaseController;
use App\Models\PeriodeVisiteModel;
use App\Models\CreneauModel;
use App\Models\RendezVousModel;

class Periodes extends BaseController
{
    protected PeriodeVisiteModel $periodeModel;
    protected CreneauModel       $creneauModel;
    protected RendezVousModel    $rdvModel;

    public function __construct()
    {
        $this->periodeModel = new PeriodeVisiteModel();
        $this->creneauModel = new CreneauModel();
        $this->rdvModel     = new RendezVousModel();
    }

    // -------------------------------------------------------------------------
    // LISTE DES PÉRIODES ACTIVES
    // -------------------------------------------------------------------------

    public function index(): string
    {
        $departement = session()->get('departement');

        // Récupérer les périodes actives du département de l'étudiant
        if ($departement) {
            $periodes = $this->periodeModel->getPeriodesParDepartement($departement);
        } else {
            $periodes = $this->periodeModel->getPeriodesActives();
        }

        return view('etudiant/periodes/index', [
            'title'       => 'Périodes de visite médicale',
            'periodes'    => $periodes,
            'departement' => $departement,
        ]);
    }

    // -------------------------------------------------------------------------
    // DÉTAIL D'UNE PÉRIODE — créneaux disponibles
    // -------------------------------------------------------------------------

    public function show(int $id): string
    {
        $periode = $this->periodeModel
                        ->select('periodes_visite.*, CONCAT(u.nom, " ", u.prenom) as medecin_nom')
                        ->join('users u', 'u.id = periodes_visite.medecin_id')
                        ->where('periodes_visite.id', $id)
                        ->where('periodes_visite.statut', 'active')
                        ->first();

        if (! $periode) {
            return redirect()->to(base_url('etudiant/periodes'))
                             ->with('error', 'Période introuvable ou inactive.');
        }

        // Vérifier si l'étudiant a déjà un RDV pour cette période
        $etudiantId  = session()->get('user_id');
        $dejaRdv     = $this->rdvModel->aDejaRdv($etudiantId, $id);

        // Récupérer les créneaux disponibles
        $creneaux = $this->creneauModel->getCreneauxDisponibles($id);

        // Grouper par date
        $creneauxParDate = [];
        foreach ($creneaux as $c) {
            $creneauxParDate[$c['date_creneau']][] = $c;
        }

        return view('etudiant/periodes/show', [
            'title'          => 'Créneaux — ' . $periode['titre'],
            'periode'        => $periode,
            'creneauxParDate'=> $creneauxParDate,
            'dejaRdv'        => $dejaRdv,
        ]);
    }
}
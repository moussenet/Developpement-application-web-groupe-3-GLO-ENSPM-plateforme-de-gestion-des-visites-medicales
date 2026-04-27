<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeriodeVisiteModel;
use App\Models\CreneauModel;
use App\Models\UserModel;

class Periodes extends BaseController
{
    protected PeriodeVisiteModel $periodeModel;
    protected CreneauModel $creneauModel;
    protected UserModel $userModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->periodeModel = new PeriodeVisiteModel();
        $this->creneauModel = new CreneauModel();
        $this->userModel    = new UserModel();
    }

    // -------------------------------------------------------------------------
    // LISTE DES PÉRIODES
    // -------------------------------------------------------------------------

    public function index(): string
    {
        return view('admin/periodes/index', [
            'title'    => 'Périodes de visite — Administration',
            'periodes' => $this->periodeModel->getAllPeriodes(),
        ]);
    }

    // -------------------------------------------------------------------------
    // FORMULAIRE DE CRÉATION
    // -------------------------------------------------------------------------

    public function create(): string
    {
        // Récupérer uniquement les médecins
        $medecins = $this->userModel
                         ->select('id, nom, prenom')
                         ->where('role_id', 2)
                         ->findAll();

        $departements = [
            'Énergies Renouvelables',
            'Agriculture, Élevage et Produits Dérivés (AGEPD)',
            'Génie Civil et Architecture (GCA)',
            'Hydraulique et Maîtrise des Eaux (HYMAE)',
            'Informatique et Télécommunications (INFOTEL)',
            'Sciences Environnementales (SCIENV)',
            'Génie Textile et Cuir',
            'Météorologie, Climatologie, Hydrologie et Pédologie (MCHP)',
        ];

        return view('admin/periodes/create', [
            'title'        => 'Créer une période de visite',
            'medecins'     => $medecins,
            'departements' => $departements,
        ]);
    }

    // -------------------------------------------------------------------------
    // ENREGISTREMENT + GÉNÉRATION AUTOMATIQUE DES CRÉNEAUX
    // -------------------------------------------------------------------------

    public function store()
    {
        $rules = [
            'titre'               => 'required|min_length[3]',
            'departement'         => 'required',
            'date_debut'          => 'required|valid_date',
            'date_fin'            => 'required|valid_date',
            'max_par_creneau'     => 'required|integer|greater_than[0]',
            'duree_consultation'  => 'required|integer|greater_than[0]',
            'medecin_id'          => 'required|integer',
            'heure_debut_journee' => 'required',
            'heure_fin_journee'   => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $dateDebut  = $this->request->getPost('date_debut');
        $dateFin    = $this->request->getPost('date_fin');
        $duree      = (int) $this->request->getPost('duree_consultation');
        $maxPlaces  = (int) $this->request->getPost('max_par_creneau');
        $heureDebut = $this->request->getPost('heure_debut_journee');
        $heureFin   = $this->request->getPost('heure_fin_journee');

        // Vérifier que date_fin >= date_debut
        if ($dateFin < $dateDebut) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'date_fin' => 'La date de fin doit être après la date de début.'
                             ]);
        }

        // Créer la période
        $periodeId = $this->periodeModel->insert([
            'titre'               => $this->request->getPost('titre'),
            'departement'         => $this->request->getPost('departement'),
            'filiere'             => $this->request->getPost('filiere') ?: null,
            'date_debut'          => $dateDebut,
            'date_fin'            => $dateFin,
            'max_par_creneau'     => $maxPlaces,
            'duree_consultation'  => $duree,
            'medecin_id'          => $this->request->getPost('medecin_id'),
            'statut'              => 'active',
            'created_by'          => session()->get('user_id'),
        ]);

        // Générer automatiquement les créneaux
        $this->genererCreneaux(
            $periodeId,
            $dateDebut,
            $dateFin,
            $heureDebut,
            $heureFin,
            $duree,
            $maxPlaces
        );

        return redirect()->to(base_url('admin/periodes'))
                         ->with('success', 'Période créée avec succès. Les créneaux ont été générés automatiquement.');
    }

    // -------------------------------------------------------------------------
    // DÉTAIL D'UNE PÉRIODE (créneaux)
    // -------------------------------------------------------------------------

    public function show(int $id): string
    {
        $periode  = $this->periodeModel->find($id);
        if (! $periode) {
            return redirect()->to(base_url('admin/periodes'))
                             ->with('error', 'Période introuvable.');
        }

        $creneaux = $this->creneauModel->getCreneauxParPeriode($id);

        // Grouper les créneaux par date
        $creneauxParDate = [];
        foreach ($creneaux as $c) {
            $creneauxParDate[$c['date_creneau']][] = $c;
        }

        return view('admin/periodes/show', [
            'title'          => 'Détail — ' . $periode['titre'],
            'periode'        => $periode,
            'creneauxParDate'=> $creneauxParDate,
        ]);
    }

    // -------------------------------------------------------------------------
    // CHANGER LE STATUT D'UNE PÉRIODE
    // -------------------------------------------------------------------------

    public function changerStatut(int $id)
    {
        $periode = $this->periodeModel->find($id);
        if (! $periode) {
            return redirect()->to(base_url('admin/periodes'))
                             ->with('error', 'Période introuvable.');
        }

        $nouveauStatut = $this->request->getPost('statut');
        $this->periodeModel->update($id, ['statut' => $nouveauStatut]);

        return redirect()->to(base_url('admin/periodes'))
                         ->with('success', 'Statut mis à jour.');
    }

    // -------------------------------------------------------------------------
    // GÉNÉRATION AUTOMATIQUE DES CRÉNEAUX (méthode privée)
    // -------------------------------------------------------------------------

    private function genererCreneaux(
        int    $periodeId,
        string $dateDebut,
        string $dateFin,
        string $heureDebut,
        string $heureFin,
        int    $dureeMinutes,
        int    $maxPlaces
    ): void {
        $current = strtotime($dateDebut);
        $fin     = strtotime($dateFin);

        while ($current <= $fin) {
            // Ignorer les dimanches (0 = dimanche)
            $jourSemaine = (int) date('w', $current);
            if ($jourSemaine !== 0) {
                $date        = date('Y-m-d', $current);
                $heureActuel = strtotime($date . ' ' . $heureDebut);
                $heureFinTs  = strtotime($date . ' ' . $heureFin);

                while (($heureActuel + $dureeMinutes * 60) <= $heureFinTs) {
                    $debut = date('H:i:s', $heureActuel);
                    $finCr = date('H:i:s', $heureActuel + $dureeMinutes * 60);

                    $this->creneauModel->insert([
                        'periode_id'   => $periodeId,
                        'date_creneau' => $date,
                        'heure_debut'  => $debut,
                        'heure_fin'    => $finCr,
                        'places_total' => $maxPlaces,
                        'places_prises'=> 0,
                        'est_urgent'   => 0,
                    ]);

                    $heureActuel += $dureeMinutes * 60;
                }
            }

            $current = strtotime('+1 day', $current);
        }
    }
}
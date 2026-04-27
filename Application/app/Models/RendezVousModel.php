<?php

namespace App\Models;

use CodeIgniter\Model;

class RendezVousModel extends Model
{
    protected $table         = 'rendezvous';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'etudiant_id', 'creneau_id', 'periode_id',
        'statut', 'est_urgent', 'rappel_envoye',
    ];
    protected $useTimestamps = true;

    // RDV d'un étudiant
    public function getRdvEtudiant(int $etudiantId): array
    {
        return $this->select('rendezvous.*, 
                              creneaux.date_creneau,
                              creneaux.heure_debut,
                              creneaux.heure_fin,
                              periodes_visite.titre as periode_titre,
                              periodes_visite.departement,
                              CONCAT(u.nom, " ", u.prenom) as medecin_nom')
                    ->join('creneaux', 'creneaux.id = rendezvous.creneau_id')
                    ->join('periodes_visite', 'periodes_visite.id = rendezvous.periode_id')
                    ->join('users u', 'u.id = periodes_visite.medecin_id')
                    ->where('rendezvous.etudiant_id', $etudiantId)
                    ->orderBy('creneaux.date_creneau', 'DESC')
                    ->findAll();
    }

    // Vérifier si un étudiant a déjà un RDV pour une période
    public function aDejaRdv(int $etudiantId, int $periodeId): bool
    {
        return $this->where('etudiant_id', $etudiantId)
                    ->where('periode_id', $periodeId)
                    ->where('statut !=', 'annule')
                    ->countAllResults() > 0;
    }

    // RDV du jour pour le médecin
    public function getRdvDuJour(int $medecinId): array
    {
        return $this->select('rendezvous.*,
                              creneaux.heure_debut,
                              creneaux.heure_fin,
                              periodes_visite.departement,
                              CONCAT(u.nom, " ", u.prenom) as etudiant_nom,
                              u.matricule')
                    ->join('creneaux', 'creneaux.id = rendezvous.creneau_id')
                    ->join('periodes_visite', 'periodes_visite.id = rendezvous.periode_id')
                    ->join('users u', 'u.id = rendezvous.etudiant_id')
                    ->where('creneaux.date_creneau', date('Y-m-d'))
                    ->where('periodes_visite.medecin_id', $medecinId)
                    ->orderBy('creneaux.heure_debut', 'ASC')
                    ->findAll();
    }

    // RDV à rappeler (48h avant, rappel pas encore envoyé)
    public function getRdvARappeler(): array
    {
        $dateCible = date('Y-m-d', strtotime('+2 days'));
        return $this->select('rendezvous.*,
                              creneaux.date_creneau,
                              creneaux.heure_debut,
                              u.email, u.nom, u.prenom')
                    ->join('creneaux', 'creneaux.id = rendezvous.creneau_id')
                    ->join('users u', 'u.id = rendezvous.etudiant_id')
                    ->where('creneaux.date_creneau', $dateCible)
                    ->where('rendezvous.rappel_envoye', 0)
                    ->where('rendezvous.statut', 'confirme')
                    ->findAll();
    }
}
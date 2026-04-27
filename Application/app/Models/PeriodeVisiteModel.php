<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeVisiteModel extends Model
{
    protected $table         = 'periodes_visite';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'titre', 'departement', 'filiere',
        'date_debut', 'date_fin',
        'max_par_creneau', 'duree_consultation',
        'medecin_id', 'statut', 'created_by',
    ];
    protected $useTimestamps = true;

    // Toutes les périodes actives avec le nom du médecin
    public function getPeriodesActives(): array
    {
        return $this->select('periodes_visite.*, 
                              CONCAT(u.nom, " ", u.prenom) as medecin_nom')
                    ->join('users u', 'u.id = periodes_visite.medecin_id')
                    ->where('periodes_visite.statut', 'active')
                    ->orderBy('periodes_visite.date_debut', 'ASC')
                    ->findAll();
    }

    // Périodes d'un département spécifique
    public function getPeriodesParDepartement(string $departement): array
    {
        return $this->select('periodes_visite.*, 
                              CONCAT(u.nom, " ", u.prenom) as medecin_nom')
                    ->join('users u', 'u.id = periodes_visite.medecin_id')
                    ->where('periodes_visite.statut', 'active')
                    ->where('periodes_visite.departement', $departement)
                    ->orderBy('periodes_visite.date_debut', 'ASC')
                    ->findAll();
    }

    // Toutes les périodes pour l'admin
    public function getAllPeriodes(): array
    {
        return $this->select('periodes_visite.*, 
                              CONCAT(u.nom, " ", u.prenom) as medecin_nom')
                    ->join('users u', 'u.id = periodes_visite.medecin_id')
                    ->orderBy('periodes_visite.created_at', 'DESC')
                    ->findAll();
    }
}
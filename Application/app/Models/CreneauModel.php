<?php

namespace App\Models;

use CodeIgniter\Model;

class CreneauModel extends Model
{
    protected $table         = 'creneaux';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'periode_id', 'date_creneau', 'heure_debut',
        'heure_fin', 'places_total', 'places_prises', 'est_urgent',
    ];

    // Créneaux disponibles pour une période
    public function getCreneauxDisponibles(int $periodeId): array
    {
        return $this->where('periode_id', $periodeId)
                    ->where('places_prises <', 'places_total', false)
                    ->where('date_creneau >=', date('Y-m-d'))
                    ->orderBy('date_creneau', 'ASC')
                    ->orderBy('heure_debut', 'ASC')
                    ->findAll();
    }

    // Tous les créneaux d'une période
    public function getCreneauxParPeriode(int $periodeId): array
    {
        return $this->where('periode_id', $periodeId)
                    ->orderBy('date_creneau', 'ASC')
                    ->orderBy('heure_debut', 'ASC')
                    ->findAll();
    }

    // Incrémenter les places prises
    public function incrementerPlaces(int $creneauId): void
    {
        $this->set('places_prises', 'places_prises + 1', false)
             ->where('id', $creneauId)
             ->update();
    }

    // Décrémenter les places prises (annulation)
    public function decrementerPlaces(int $creneauId): void
    {
        $this->set('places_prises', 'places_prises - 1', false)
             ->where('id', $creneauId)
             ->where('places_prises >', 0)
             ->update();
    }
}
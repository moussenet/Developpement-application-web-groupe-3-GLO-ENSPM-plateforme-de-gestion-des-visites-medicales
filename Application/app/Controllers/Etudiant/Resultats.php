<?php

namespace App\Controllers\Etudiant;

use App\Controllers\BaseController;

class Resultats extends BaseController
{
    public function index(): string
    {
        return view('etudiant/resultats/index', [
            'title'    => 'Mes résultats médicaux',
            'resultats'=> [],
        ]);
    }
}
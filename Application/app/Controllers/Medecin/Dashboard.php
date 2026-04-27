<?php

namespace App\Controllers\Medecin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
        return view('medecin/dashboard', [
            'title'    => 'Espace médical — Centre Medico-Sanitaire - ENSPM',
            'user_nom' => session()->get('user_nom'),
        ]);
    }
}
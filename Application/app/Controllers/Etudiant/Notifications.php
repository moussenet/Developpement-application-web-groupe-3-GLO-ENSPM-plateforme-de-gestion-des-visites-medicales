<?php

namespace App\Controllers\Etudiant;

use App\Controllers\BaseController;

class Notifications extends BaseController
{
    public function index(): string
    {
        return view('etudiant/notifications/index', [
            'title'         => 'Mes notifications',
            'notifications' => [],
        ]);
    }
}
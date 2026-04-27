<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): mixed
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $defaultPath = match (session()->get('role_name')) {
            'admin'   => '/admin/dashboard',
            'medecin' => '/medecin/dashboard',
            default   => '/etudiant/dashboard',
        };

        // $arguments contient le(s) rôle(s) autorisé(s)
        // ex: ['admin'] ou ['admin', 'medecin']
        if ($arguments && ! in_array(session()->get('role_name'), $arguments)) {
            return redirect()->to($defaultPath)
                             ->with('error', 'Accès non autorisé.');
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): mixed
    {
        return null;
    }
}
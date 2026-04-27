<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): mixed
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): mixed
    {
        return null;
    }
}
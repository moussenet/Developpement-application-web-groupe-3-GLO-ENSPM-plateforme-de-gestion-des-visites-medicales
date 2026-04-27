<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes publiques
$routes->get('/',         'Auth::login');
$routes->get('login',     'Auth::login');
$routes->post('login',    'Auth::loginPost');
$routes->get('logout',    'Auth::logout');
$routes->get('register',  'Auth::register');
$routes->post('register', 'Auth::registerPost');

// Espace étudiant — rôle : etudiant
$routes->group('etudiant', ['filter' => 'role:etudiant'], function($routes) {
    $routes->get('dashboard', 'Etudiant\Dashboard::index');
});

// Espace médecin — rôle : medecin
$routes->group('medecin', ['filter' => 'role:medecin'], function($routes) {
    $routes->get('dashboard', 'Medecin\Dashboard::index');
});

// Espace admin — rôle : admin
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('periodes',               'Admin\Periodes::index');
    $routes->get('periodes/create',        'Admin\Periodes::create');
    $routes->post('periodes/store',        'Admin\Periodes::store');
    $routes->get('periodes/(:num)',        'Admin\Periodes::show/$1');
    $routes->post('periodes/statut/(:num)','Admin\Periodes::changerStatut/$1');
    // users
    $routes->get('users',                  'Admin\Users::index');
    $routes->get('users/create',           'Admin\Users::create');
    $routes->post('users/store',           'Admin\Users::store');
    $routes->get('users/delete/(:num)',    'Admin\Users::delete/$1');
});

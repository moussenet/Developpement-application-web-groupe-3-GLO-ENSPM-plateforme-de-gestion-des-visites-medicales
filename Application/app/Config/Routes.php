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

// Étudiant
$routes->group('etudiant', ['filter' => 'role:etudiant'], function($routes) {
    $routes->get('dashboard',                  'Etudiant\Dashboard::index');
    $routes->get('periodes',                   'Etudiant\Periodes::index');
    $routes->get('periodes/(:num)',            'Etudiant\Periodes::show/$1');
    $routes->post('rendezvous/store',          'Etudiant\RendezVous::store');
    $routes->get('rendezvous',                 'Etudiant\RendezVous::index');
    $routes->post('rendezvous/annuler/(:num)', 'Etudiant\RendezVous::annuler/$1');
    $routes->get('notifications',              'Etudiant\Notifications::index');
    $routes->get('resultats',                  'Etudiant\Resultats::index');
});


// Personnel médical
$routes->group('medecin', ['filter' => 'role:medecin'], function($routes) {
    $routes->get('dashboard',                    'Medecin\Dashboard::index');
    $routes->get('rendezvous',                   'Medecin\RendezVous::index');
    $routes->post('rendezvous/presence/(:num)',  'Medecin\RendezVous::validerPresence/$1');
    $routes->get('resultats/create/(:num)',      'Medecin\Resultats::create/$1');
    $routes->post('resultats/store',             'Medecin\Resultats::store');
});
// Super Admin
$routes->group('superadmin', ['filter' => 'role:superadmin'], function($routes) {
    $routes->get('dashboard',              'SuperAdmin\Dashboard::index');
    $routes->get('users',                  'SuperAdmin\Users::index');
    $routes->get('users/create',           'SuperAdmin\Users::create');
    $routes->post('users/store',           'SuperAdmin\Users::store');
    $routes->post('users/toggle/(:num)',   'SuperAdmin\Users::toggleActif/$1');
    $routes->post('users/delete/(:num)',   'SuperAdmin\Users::delete/$1');
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

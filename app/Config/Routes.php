<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ============================================================
// AUTH (tidak butuh login)
// ============================================================
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

// ============================================================
// SEMUA HALAMAN DI BAWAH INI WAJIB LOGIN
// ============================================================
$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // Dashboard (semua role)
    $routes->get('dashboard', 'Dashboard::index');

    // ========================================================
    // MODUL DATA USER (hanya admin)
    // ========================================================
    $routes->group('users', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('create', 'Users::create');
        $routes->post('store', 'Users::store');
        $routes->get('edit/(:num)', 'Users::edit/$1');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->post('delete/(:num)', 'Users::delete/$1');
    });

    // ========================================================
    // MODUL REKAM OBAT (admin & apoteker)
    // ========================================================
    $routes->group('obat', ['filter' => 'role:admin,apoteker'], static function ($routes) {
        $routes->get('/', 'Obat::index');
        $routes->get('create', 'Obat::create');
        $routes->post('store', 'Obat::store');
        $routes->get('edit/(:num)', 'Obat::edit/$1');
        $routes->post('update/(:num)', 'Obat::update/$1');
        $routes->post('delete/(:num)', 'Obat::delete/$1');
    });

    // ========================================================
    // MODUL REKAM RESEP (admin & apoteker)
    // ========================================================
    $routes->group('resep', ['filter' => 'role:admin,apoteker'], static function ($routes) {
        $routes->get('/', 'Resep::index');
        $routes->get('create', 'Resep::create');
        $routes->post('store', 'Resep::store');
        $routes->get('detail/(:num)', 'Resep::detail/$1');
        $routes->get('edit/(:num)', 'Resep::edit/$1');
        $routes->post('update/(:num)', 'Resep::update/$1');
        $routes->post('delete/(:num)', 'Resep::delete/$1');
    });

    // ========================================================
    // MODUL RESEPSIONIS (hanya resepsionis)
    // ========================================================
    $routes->group('resepsionis', ['filter' => 'role:resepsionis'], static function ($routes) {
        $routes->get('/', 'Resepsionis::index');
        $routes->get('pasien', 'Resepsionis::pasien');
        $routes->get('pasien/detail/(:segment)', 'Resepsionis::pasienDetail/$1');
        $routes->get('resep', 'Resepsionis::resep');
        $routes->get('resep/detail/(:num)', 'Resepsionis::resepDetail/$1');
    });
});

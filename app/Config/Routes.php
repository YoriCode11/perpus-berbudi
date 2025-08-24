<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', function () {
    return session()->get('isLoggedIn')
        ? redirect()->to('/dashboard')
        : redirect()->to('/auth/login');
});

$routes->get('auth/login', 'Auth::login', ['filter' => 'noauth']);
$routes->post('auth/login', 'Auth::attempt', ['filter' => 'noauth']);
$routes->get('auth/logout', 'Auth::logout');
$routes->get('forgot-password', 'Auth::forgotPassword',['filter' => 'noauth']);
$routes->post('forgot-password', 'Auth::processForgotPassword',['filter' => 'noauth']);
$routes->get('security-question/(:any)', 'Auth::securityQuestion/$1',['filter' => 'noauth']);
$routes->post('security-question/(:any)', 'Auth::processSecurityQuestion/$1',['filter' => 'noauth']);
$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1',['filter' => 'noauth']);
$routes->post('reset-password/(:any)', 'Auth::processResetPassword/$1',['filter' => 'noauth']);

$routes->group('', ['filter' => 'auth'], function($routes){
    $routes->get('dashboard', 'Dashboard::index');
   
    $routes->group('profile', function($routes){
        $routes->get('/', 'Profile::index');
        $routes->get('edit', 'Profile::edit');
        $routes->post('update', 'Profile::update');
        $routes->get('change-password', 'Profile::changepass');
        $routes->post('changePassword', 'Profile::changePassword');

    });

    $routes->group('buku', function($routes){
        $routes->get('/', 'Buku::index');
        $routes->get('new', 'Buku::new');
        $routes->post('store', 'Buku::store');
        $routes->get('edit/(:num)', 'Buku::edit/$1');
        $routes->post('update/(:num)', 'Buku::update/$1');
        $routes->delete('(:num)', 'Buku::delete/$1');
    });

    $routes->group('anggota', function($routes){
        $routes->get('/', 'Anggota::index');
        $routes->get('new', 'Anggota::new');
        $routes->post('store', 'Anggota::store');
        $routes->get('edit/(:num)', 'Anggota::edit/$1');
        $routes->post('update/(:num)', 'Anggota::update/$1');
        $routes->delete('(:num)', 'Anggota::delete/$1');
    });

    $routes->group('kategori', function($routes){
        $routes->get('/', 'Kategori::index');
        $routes->get('new', 'Kategori::new');
        $routes->post('store', 'Kategori::store');
        $routes->get('edit/(:num)', 'Kategori::edit/$1');
        $routes->post('update/(:num)', 'Kategori::update/$1');
        $routes->delete('(:num)', 'Kategori::delete/$1');
    });

    $routes->group('absensi', function($routes){
        $routes->get('/', 'Absensi::index');
        $routes->get('new', 'Absensi::new');
        $routes->post('store', 'Absensi::store');
        $routes->get('edit/(:num)', 'Absensi::edit/$1');
        $routes->post('update/(:num)', 'Absensi::update/$1');
        $routes->delete('(:num)', 'Absensi::delete/$1');

    });

    $routes->group('peminjaman', function($routes){
        $routes->get('/', 'Peminjaman::index');
        $routes->get('new', 'Peminjaman::new');
        $routes->post('store', 'Peminjaman::store');
        $routes->get('edit/(:num)', 'Peminjaman::edit/$1');
        $routes->post('update/(:num)', 'Peminjaman::update/$1');
        $routes->delete('(:num)', 'Peminjaman::delete/$1');

    });


    
});
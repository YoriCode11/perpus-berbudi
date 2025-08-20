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
});
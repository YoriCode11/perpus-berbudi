<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/', 'Dashboard::index');

// Auth Routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');
$routes->get('/login', 'Auth::index'); // Mengarahkan GET request ke metode index()
$routes->post('/login', 'Auth::processLogin'); // Mengarahkan POST request ke metode processLogin()
$routes->get('/logout', 'Auth::logout');

// Kategori (Data Master)
$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/new', 'Kategori::new');
$routes->post('kategori', 'Kategori::create');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->put('kategori/(:num)', 'Kategori::update/$1');
$routes->delete('kategori/(:num)', 'Kategori::delete/$1');

// Anggota (Data Master)
$routes->group('anggota', function($routes){
    $routes->get('/', 'Anggota::index'); // Route untuk menampilkan daftar anggota
    $routes->get('create', 'Anggota::create'); // Route untuk menampilkan form tambah anggota
    $routes->post('store', 'Anggota::store'); // Route untuk menyimpan data anggota baru
    $routes->get('edit/(:num)', 'Anggota::edit/$1'); // Route untuk menampilkan form edit anggota
    $routes->put('update/(:num)', 'Anggota::update/$1'); // Route untuk update data anggota
    $routes->delete('(:num)', 'Anggota::delete/$1'); // Route untuk menghapus data anggota
});

// Buku (Data Master)
$routes->resource('buku');

// Peminjaman (Transaksi)
$routes->resource('peminjaman');
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1'); // Route untuk pengembalian

// Absensi Pengunjung
$routes->resource('absensi'); // Ini akan membuat CRUD routes untuk absensi
$routes->get('absensi/checkout/(:num)', 'Absensi::checkout/$1'); // Route khusus untuk checkout

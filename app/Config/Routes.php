<?php

namespace Config;

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
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::processLogin');
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
    $routes->get('/', 'Anggota::index');
    $routes->get('create', 'Anggota::create');
    $routes->post('store', 'Anggota::store');
    $routes->get('edit/(:num)', 'Anggota::edit/$1');
    $routes->put('update/(:num)', 'Anggota::update/$1');
    $routes->delete('(:num)', 'Anggota::delete/$1');
});

// Buku (Data Master)
$routes->resource('buku');

// Peminjaman (Transaksi)
$routes->resource('peminjaman');
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');

// Absensi Pengunjung (Rute Eksplisit)
// Ganti baris $routes->resource('absensi'); dengan rute-rute eksplisit ini
$routes->get('absensi', 'Absensi::index');
$routes->get('absensi/new', 'Absensi::new'); // Menampilkan form tambah absensi
$routes->post('absensi', 'Absensi::create'); // Memproses data POST dari form tambah absensi
$routes->get('absensi/edit/(:num)', 'Absensi::edit/$1'); // Jika ada form edit absensi
$routes->put('absensi/(:num)', 'Absensi::update/$1'); // Jika ada proses update absensi
$routes->delete('absensi/(:num)', 'Absensi::delete/$1'); // Untuk menghapus absensi
$routes->get('absensi/checkout/(:num)', 'Absensi::checkout/$1'); // Route khusus untuk checkout

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

// Peminjaman (Transaksi) - Rute Eksplisit
// Ganti baris $routes->resource('peminjaman'); dengan rute-rute eksplisit ini
$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/new', 'Peminjaman::new'); // Menampilkan form tambah peminjaman
$routes->post('peminjaman', 'Peminjaman::create'); // Memproses data POST dari form tambah peminjaman
$routes->get('peminjaman/edit/(:num)', 'Peminjaman::edit/$1'); // Jika ada form edit peminjaman
$routes->put('peminjaman/(:num)', 'Peminjaman::update/$1'); // Jika ada proses update peminjaman
$routes->delete('peminjaman/(:num)', 'Peminjaman::delete/$1'); // Untuk menghapus peminjaman
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1'); // Route khusus untuk pengembalian

// Absensi Pengunjung (Rute Eksplisit)
$routes->get('absensi', 'Absensi::index');
$routes->get('absensi/new', 'Absensi::new');
$routes->post('absensi', 'Absensi::create');
$routes->get('absensi/edit/(:num)', 'Absensi::edit/$1');
$routes->put('absensi/(:num)', 'Absensi::update/$1');
$routes->delete('absensi/(:num)', 'Absensi::delete/$1');
$routes->get('absensi/checkout/(:num)', 'Absensi::checkout/$1');

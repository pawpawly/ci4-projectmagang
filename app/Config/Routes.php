<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Utama dan Halaman Lain
$routes->get('/', 'Home::index');
$routes->get('/aboutus', 'AboutUs::index');
$routes->get('/schedule', 'ReservationController::index');
// Login Routes
$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/logout', 'Login::logout');


// Route untuk Detail Event dan Daftar Event
$routes->group('event', function ($routes) {
    $routes->get('index', 'Event::index');  // Daftar event
    $routes->get('(:segment)', 'Event::detail/$1');  // Detail event berdasarkan nama
});

$routes->group('reservasi', function ($routes) {
    $routes->post('store', 'ReservationController::store'); 
    $routes->get('/update-status/(:num)/(:alpha)', 'ReservasiController::updateStatus/$1/$2');
});

// Grouping Logout dengan Middleware Auth
$routes->group('logout', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Auth::logout');
});

// Grouping untuk SuperAdmin dengan Middleware Auth
$routes->group('superadmin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'SuperAdminController::dashboard');  // Dashboard SuperAdmin
});

// Route untuk Manajemen User
$routes->group('superadmin/user', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::userManage');  // Manajemen Pengguna
    $routes->get('add', 'SuperAdminController::addUserForm');  // Tambah Pengguna
    $routes->post('save', 'SuperAdminController::saveUser');  // Simpan Pengguna Baru
    $routes->get('edit/(:any)', 'SuperAdminController::editUser/$1');  // Edit Pengguna
    $routes->post('update', 'SuperAdminController::updateUser');  // Update Pengguna
    $routes->delete('delete/(:any)', 'SuperAdminController::deleteUser/$1');  // Hapus Pengguna
});


// Route untuk Manajemen Event
$routes->group('superadmin/event', ['filter' => 'auth'], function ($routes) {
    $routes->get('category', 'SuperAdminController::eventCategory');  
    $routes->get('manage', 'SuperAdminController::eventManage'); 
    $routes->get('category/add', 'SuperAdminController::addCategory');
    $routes->post('category/save', 'SuperAdminController::saveCategory');
    $routes->get('category/edit/(:num)', 'SuperAdminController::editCategory/$1');
    $routes->post('category/update', 'SuperAdminController::updateCategory');
    $routes->delete('category/delete/(:num)', 'SuperAdminController::deleteCategory/$1');
    $routes->get('add', 'SuperAdminController::addEventForm');
    $routes->post('save', 'SuperAdminController::saveEvent');
    $routes->get('edit/(:num)', 'SuperAdminController::editEvent/$1');
    $routes->post('update', 'SuperAdminController::updateEvent');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteEvent/$1');

});

// Route untuk Manajemen Berita
$routes->group('superadmin/berita', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::beritaManage');
    $routes->get('add', 'SuperAdminController::addBeritaForm');
    $routes->post('save', 'SuperAdminController::saveBerita');  // Simpan Berita
    $routes->post('update', 'SuperAdminController::updateBerita');  // Update Berita
    $routes->get('edit/(:num)', 'SuperAdminController::editBerita/$1');  // Edit Berita
    $routes->post('delete/(:num)', 'SuperAdminController::deleteBerita/$1');

});


// Route untuk Manajemen Koleksi
$routes->group('superadmin/koleksi', ['filter' => 'auth'], function ($routes) {
    $routes->get('category', 'SuperAdminController::kategoriKoleksi');  
    $routes->get('category/add', 'SuperAdminController::addKategoriKoleksiForm');
    $routes->post('category/save', 'SuperAdminController::saveKategoriKoleksi');
    $routes->get('category/edit/(:num)', 'SuperAdminController::editKategoriKoleksi/$1');
    $routes->post('category/update', 'SuperAdminController::updateKategoriKoleksi');
    $routes->delete('category/delete/(:num)', 'SuperadminController::deleteKategoriKoleksi/$1');
    $routes->get('manage', 'SuperAdminController::koleksiManage');
    $routes->get('add', 'SuperAdminController::addKoleksiForm');
    $routes->post('save', 'SuperAdminController::saveKoleksi');
    $routes->get('edit/(:num)', 'SuperAdminController::editKoleksi/$1');
    $routes->post('update', 'SuperAdminController::updateKoleksi');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteKoleksi/$1');




});

$routes->group('superadmin/reservasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::reservationManage');
    $routes->post('status/(:num)', 'SuperAdminController::reservationStatus/$1');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteReservation/$1');
 
});
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Utama dan Halaman Lain
$routes->get('/', 'Home::index');
$routes->get('/aboutus', 'AboutUs::index');
$routes->get('/schedule', 'ReservationController::index');
$routes->post('saran/saveSaran', 'SaranController::saveSaran');


// Login Routes
$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/logout', 'Login::logout');

// Route untuk Detail Berita dan Daftar Berita
$routes->group('berita', function ($routes) {
    $routes->get('/', 'Berita::index'); // Daftar berita
    $routes->get('(:segment)', 'Berita::detail/$1'); // Detail berita berdasarkan slug
});

// Route untuk Koleksi
$routes->group('koleksi', function ($routes) {
    $routes->get('/', 'Koleksi::index');  // Route untuk halaman daftar koleksi
    $routes->get('detail/(:num)', 'Koleksi::detail/$1');  // Route untuk halaman detail koleksi
});

// Route untuk Buku Digital
$routes->group('bukudigital', function ($routes) {
    $routes->get('/', 'BukuDigitalController::index'); // Daftar buku digital
    $routes->get('detail/(:num)', 'BukuDigitalController::detail/$1'); // Detail buku digital berdasarkan ID
});

// Route untuk Detail Event dan Daftar Event
$routes->group('event', function ($routes) {
    $routes->get('index', 'Event::index');  // Daftar event
    $routes->get('(:segment)', 'Event::detail/$1');  // Detail event berdasarkan nama
});

$routes->group('reservasi', function ($routes) {
    $routes->post('store', 'ReservationController::storeReservasi'); 
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
    $routes->get('detail/(:num)', 'SuperAdminController::eventDetail/$1');

});

// Route untuk Manajemen Berita
$routes->group('superadmin/berita', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::beritaManage');
    $routes->get('add', 'SuperAdminController::addBeritaForm');
    $routes->post('save', 'SuperAdminController::saveBerita');  // Simpan Berita
    $routes->post('update', 'SuperAdminController::updateBerita');  // Update Berita
    $routes->get('edit/(:num)', 'SuperAdminController::editBerita/$1');  // Edit Berita
    $routes->post('delete/(:num)', 'SuperAdminController::deleteBerita/$1');
    $routes->get('detail/(:num)', 'SuperAdminController::detailBerita/$1');

});

// Route untuk Manajemen Koleksi
$routes->group('superadmin/koleksi', ['filter' => 'auth'], function ($routes) {
    $routes->get('category', 'SuperAdminController::kategoriKoleksi');  
    $routes->get('category/add', 'SuperAdminController::addKategoriKoleksiForm');
    $routes->post('category/save', 'SuperAdminController::saveKategoriKoleksi');
    $routes->get('category/edit/(:num)', 'SuperAdminController::editKategoriKoleksi/$1');
    $routes->post('category/update', 'SuperAdminController::updateKategoriKoleksi');
    $routes->delete('category/delete/(:num)', 'SuperAdminController::deleteKategoriKoleksi/$1');
    $routes->get('manage', 'SuperAdminController::koleksiManage');
    $routes->get('add', 'SuperAdminController::addKoleksiForm');
    $routes->post('save', 'SuperAdminController::saveKoleksi');
    $routes->get('edit/(:num)', 'SuperAdminController::editKoleksi/$1');
    $routes->post('update', 'SuperAdminController::updateKoleksi');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteKoleksi/$1');
    $routes->get('detail/(:num)', 'SuperAdminController::koleksiDetail/$1');
});

$routes->group('superadmin/reservasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::reservationManage');
    $routes->post('status/(:num)', 'SuperAdminController::reservationStatus/$1');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteReservation/$1');
    $routes->get('detail/(:num)', 'SuperAdminController::detail_reservasi/$1');
    $routes->post('update-status/(:num)', 'SuperAdminController::updateStatus/$1');


});

$routes->group('superadmin/bukutamu', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::manageBukuTamu');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteBukuTamu/$1');
    $routes->get('form', 'SuperAdminController::grantGuestbookAccess');
    $routes->get('detailGuestBook/(:num)', 'SuperAdminController::detailGuestBook/$1');


});

$routes->group('bukutamu', ['filter' => 'guestbookAuth'], function ($routes) {
    $routes->get('form', 'BukuTamuController::form');
    $routes->post('storeIndividual', 'BukuTamuController::storeIndividual');
    $routes->post('storeInstansi', 'BukuTamuController::storeInstansi');
    $routes->get('individual', 'BukuTamuController::individual');
    $routes->get('agency', 'BukuTamuController::agency');
    $routes->post('storeAgency', 'BukutamuController::storeAgency');
    $routes->get('foto_tamu/(:any)', 'BukuTamuController::getFoto/$1');
});

$routes->group('superadmin/bukudigital', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::manageBukuDigital');
    $routes->get('add', 'SuperAdminController::addBukuDigital');
    $routes->post('save', 'SuperAdminController::saveBukuDigital');
    $routes->get('view/(:num)', 'SuperAdminController::viewBukuDigital/$1');
    $routes->get('edit/(:num)', 'SuperAdminController::editBukuDigital/$1');
    $routes->post('update', 'SuperAdminController::updateBukuDigital');
    $routes->post('delete/(:num)', 'SuperAdminController::deleteBukuDigital/$1');
});

$routes->group('superadmin/saran', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::manageSaran');
    $routes->delete('delete/(:num)', 'SuperAdminController::deleteSaran/$1');
});


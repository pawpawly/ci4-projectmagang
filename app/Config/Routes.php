<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

///////////////////////////// PUBLIC ROUTE ///////////////////////////// 
$routes->get('/', 'Home::index');
$routes->get('/aboutus', 'AboutUs::index');
$routes->get('/schedule', 'ScheduleController::index');
$routes->post('saran/saveSaran', 'SaranController::saveSaran');

$routes->group('berita', function ($routes) {
    $routes->get('/', 'Berita::index');
    $routes->get('(:segment)', 'Berita::detail/$1');
});
$routes->group('koleksi', function ($routes) {
    $routes->get('/', 'Koleksi::index');  
    $routes->get('detail/(:num)', 'Koleksi::detail/$1');
});
$routes->group('bukudigital', function ($routes) {
    $routes->get('/', 'BukuDigitalController::index'); 
    $routes->get('detail/(:num)', 'BukuDigitalController::detail/$1');
    $routes->get('flipbook/(:num)', 'BukuDigitalController::flipbook/$1');
});
$routes->group('event', function ($routes) {
    $routes->get('index', 'Event::index'); 
    $routes->get('(:segment)', 'Event::detail/$1');  
});
$routes->group('reservasi', function ($routes) {
    $routes->post('store', 'ReservationController::storeReservasi'); 
});

///////////////////////////// LOGIN/LOGOUT SESSION ///////////////////////////// 
$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/logout', 'Login::logout');
$routes->get('restricted', 'LoginController::restricted');

///////////////////////////// GUESTBOOK SESSION ///////////////////////////// 
$routes->group('bukutamu', ['filter' => 'guestbookAuth'], function ($routes) {
    $routes->get('form', 'BukuTamuController::form');
    $routes->post('storeIndividual', 'BukuTamuController::storeIndividual');
    $routes->post('storeInstansi', 'BukuTamuController::storeInstansi');
    $routes->get('individual', 'BukuTamuController::individual');
    $routes->get('agency', 'BukuTamuController::agency');
    $routes->post('storeAgency', 'BukutamuController::storeAgency');
    $routes->get('foto_tamu/(:any)', 'BukuTamuController::getFoto/$1');
});


///////////////////////////// ADMIN ///////////////////////////// 
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard/getDashboardCounts', 'AdminController::getDashboardCounts');
    $routes->get('dashboard', 'AdminController::dashboard');
});
$routes->group('logout', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'LogoutController::index');
});
$routes->group('admin/user', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'AdminController::userManage');
    $routes->get('add', 'AdminController::addUserForm');
    $routes->post('save', 'AdminController::saveUser');
    $routes->get('edit/(:any)', 'AdminController::editUser/$1');
    $routes->post('update', 'AdminController::updateUser');
    $routes->delete('delete/(:any)', 'AdminController::deleteUser/$1');
});
$routes->group('admin/event', ['filter' => 'auth'], function ($routes) {
    $routes->get('category', 'AdminController::eventCategory');  
    $routes->get('manage', 'AdminController::eventManage'); 
    $routes->get('category/add', 'AdminController::addCategory');
    $routes->post('category/save', 'AdminController::saveCategory');
    $routes->get('category/edit/(:num)', 'AdminController::editCategory/$1');
    $routes->post('category/update', 'AdminController::updateCategory');
    $routes->delete('category/delete/(:num)', 'AdminController::deleteCategory/$1');
    $routes->get('add', 'AdminController::addEventForm');
    $routes->post('save', 'AdminController::saveEvent');
    $routes->get('edit/(:num)', 'AdminController::editEvent/$1');
    $routes->post('update', 'AdminController::updateEvent');
    $routes->delete('delete/(:num)', 'AdminController::deleteEvent/$1');
    $routes->get('detail/(:num)', 'AdminController::eventDetail/$1');

});
$routes->group('admin/berita', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'AdminController::beritaManage');
    $routes->get('add', 'AdminController::addBeritaForm');
    $routes->post('save', 'AdminController::saveBerita');
    $routes->post('update', 'AdminController::updateBerita');
    $routes->get('edit/(:num)', 'AdminController::editBerita/$1');
    $routes->post('delete/(:num)', 'AdminController::deleteBerita/$1');
    $routes->get('detail/(:num)', 'AdminController::detailBerita/$1');
});
$routes->group('admin/koleksi', ['filter' => 'auth'], function ($routes) {
    $routes->get('category', 'AdminController::kategoriKoleksi');  
    $routes->get('category/add', 'AdminController::addKategoriKoleksiForm');
    $routes->post('category/save', 'AdminController::saveKategoriKoleksi');
    $routes->get('category/edit/(:num)', 'AdminController::editKategoriKoleksi/$1');
    $routes->post('category/update', 'AdminController::updateKategoriKoleksi');
    $routes->delete('category/delete/(:num)', 'AdminController::deleteKategoriKoleksi/$1');
    $routes->get('manage', 'AdminController::koleksiManage');
    $routes->get('add', 'AdminController::addKoleksiForm');
    $routes->post('save', 'AdminController::saveKoleksi');
    $routes->get('edit/(:num)', 'AdminController::editKoleksi/$1');
    $routes->post('update', 'AdminController::updateKoleksi');
    $routes->delete('delete/(:num)', 'AdminController::deleteKoleksi/$1');
    $routes->get('detail/(:num)', 'AdminController::koleksiDetail/$1');
});
$routes->group('admin/reservasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'AdminController::reservationManage');
    $routes->post('status/(:num)', 'AdminController::reservationStatus/$1');
    $routes->delete('delete/(:num)', 'AdminController::deleteReservation/$1');
    $routes->get('detail/(:num)', 'AdminController::detail_reservasi/$1');
    $routes->post('update-status/(:num)', 'AdminController::updateStatus/$1');
});
$routes->group('admin/bukutamu', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'AdminController::manageBukuTamu');
    $routes->delete('delete/(:num)', 'AdminController::deleteBukuTamu/$1');
    $routes->get('form', 'AdminController::grantGuestbookAccess');
    $routes->get('detailGuestBook/(:num)', 'AdminController::detailGuestBook/$1');
});
$routes->group('admin/bukudigital', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'AdminController::manageBukuDigital');
    $routes->get('add', 'AdminController::addBukuDigital');
    $routes->post('save', 'AdminController::saveBukuDigital');
    $routes->get('view/(:num)', 'AdminController::viewBukuDigital/$1');
    $routes->get('edit/(:num)', 'AdminController::editBukuDigital/$1');
    $routes->post('update', 'AdminController::updateBukuDigital');
    $routes->post('delete/(:num)', 'AdminController::deleteBukuDigital/$1');
});
$routes->group('admin/saran', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'AdminController::manageSaran');
    $routes->delete('delete/(:num)', 'AdminController::deleteSaran/$1');
    $routes->get('detail/(:num)', 'AdminController::detailSaran/$1');
});


///////////////////////////// SUPERADMIN ///////////////////////////// 
$routes->group('superadmin', ['filter' => 'auth'], function ($routes) {
    $routes->get('superadmin/dashboard/getDashboardCounts', 'SuperAdminController::getDashboardCounts');
    $routes->get('dashboard', 'SuperAdminController::dashboard');
});
$routes->group('logout', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'LogoutController::index');
});
$routes->group('superadmin/user', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::userManage');
    $routes->get('add', 'SuperAdminController::addUserForm');
    $routes->post('save', 'SuperAdminController::saveUser');
    $routes->get('edit/(:any)', 'SuperAdminController::editUser/$1');
    $routes->post('update', 'SuperAdminController::updateUser');
    $routes->delete('delete/(:any)', 'SuperAdminController::deleteUser/$1');
});
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
$routes->group('superadmin/berita', ['filter' => 'auth'], function ($routes) {
    $routes->get('manage', 'SuperAdminController::beritaManage');
    $routes->get('add', 'SuperAdminController::addBeritaForm');
    $routes->post('save', 'SuperAdminController::saveBerita');
    $routes->post('update', 'SuperAdminController::updateBerita');
    $routes->get('edit/(:num)', 'SuperAdminController::editBerita/$1');
    $routes->post('delete/(:num)', 'SuperAdminController::deleteBerita/$1');
    $routes->get('detail/(:num)', 'SuperAdminController::detailBerita/$1');
});
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
    $routes->get('detail/(:num)', 'SuperAdminController::detailSaran/$1');
});


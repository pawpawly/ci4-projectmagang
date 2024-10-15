<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Utama dan Halaman Lain
$routes->get('/', 'Home::index');
$routes->get('/aboutus', 'AboutUs::index');

// Login Routes
$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/login/logout', 'Login::logout');

// Admin Dashboard
$routes->get('/admin/dashboard', 'Admin::dashboard');

// Grouping untuk SuperAdmin dengan Middleware Auth
$routes->group('superadmin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'SuperAdminController::dashboard');
    $routes->get('user-management', 'SuperAdminController::index');
    $routes->get('user-management/add', 'SuperAdminController::addUserForm');
    $routes->post('user-management/save', 'SuperAdminController::saveUser');
    $routes->get('user-management/edit/(:any)', 'SuperAdminController::editUser/$1');
    $routes->post('user-management/update', 'SuperAdminController::updateUser');
    $routes->get('user-management/delete/(:any)', 'SuperAdminController::deleteUser/$1');


});

 // Event Management Routes
$routes->group('event', function($routes) {
    $routes->get('category', 'SuperAdminController::eventCategory');
    $routes->get('manage', 'SuperAdminController::eventManage');
});
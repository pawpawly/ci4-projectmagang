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

// Grouping untuk SuperAdmin
$routes->group('superadmin', function ($routes) {
    // Dashboard SuperAdmin
    $routes->get('dashboard', 'Superadmin::dashboard');
    
    // Manajemen User
    $routes->get('user-management', 'SuperAdminController::index');
    $routes->get('user-management/add', 'SuperAdminController::addUserForm');
    $routes->post('user-management/save', 'SuperAdminController::saveUser');
    $routes->get('user-management/edit/(:any)', 'SuperAdminController::editUser/$1');
    $routes->post('user-management/update', 'SuperAdminController::updateUser');
    $routes->get('user-management/delete/(:any)', 'SuperAdminController::deleteUser/$1');
});

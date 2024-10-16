<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Utama dan Halaman Lain
$routes->get('/', 'Home::index');
$routes->get('/aboutus', 'AboutUs::index');

// Route untuk About Us
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

$routes->group('event', function ($routes) {
    $routes->get('category', 'SuperAdminController::eventCategory');
    $routes->get('category/add', 'SuperAdminController::addCategoryForm');
    $routes->post('category/save', 'SuperAdminController::saveCategory');
    $routes->get('category/edit/(:num)', 'SuperAdminController::editCategory/$1');
    $routes->post('category/update', 'SuperAdminController::updateCategory');
    $routes->get('category/delete/(:num)', 'SuperAdminController::deleteCategory/$1');

    // **Route untuk Event Manage**
    $routes->get('manage', 'SuperAdminController::eventManage');
    $routes->get('add', 'SuperAdminController::addEventForm');
    $routes->post('save', 'SuperAdminController::saveEvent');
    $routes->get('delete/(:num)', 'SuperAdminController::deleteEvent/$1');
    $routes->get('edit/(:num)', 'SuperAdminController::editEvent/$1');
    $routes->post('update', 'SuperAdminController::updateEvent');
});






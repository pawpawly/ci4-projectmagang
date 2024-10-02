<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); 
$routes->get('/login', 'Login::index'); 
$routes->get('aboutus', 'AboutUs::index');


/** Admin Only */
$routes->get('/admin/dashboard', 'Admin::dashboard');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/login/logout', 'Login::logout');
$routes->get('superadmin/dashboard', 'Superadmin::dashboard');
$routes->get('superadmin/user-management', 'SuperadminUserManagement::index');






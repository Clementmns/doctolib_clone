<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('patients', 'Patients::index');
$routes->get('etablishments', 'Etablishments::index');


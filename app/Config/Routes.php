<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('patients', 'Patients::index');
$routes->get('etablishments', 'Etablishments::index');
$routes->get('specialites', 'Specialites::index');

// PRACTITIONERS
$routes->get('practitioners', 'Practitioner::index');
$routes->get('practitioners/new', 'Practitioner::addView');
$routes->post('practitioners/create', 'Practitioner::create');

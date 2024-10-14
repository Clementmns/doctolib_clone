<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// HOME
$routes->get('/', 'Home::index');

// PATIENTS
$routes->get('patients', 'Patients::index');

// ETABLISSEMENTS
$routes->get('etablishments', 'Etablishments::index');

//SPECIALITES
$routes->get('specialities', 'Specialities::index');

// PRACTITIONERS
$routes->get('practitioners', 'Practitioner::index');
$routes->get('practitioners/new', 'Practitioner::addView');
$routes->post('practitioners/create', 'Practitioner::create');

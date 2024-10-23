<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ACCUEIL
$routes->get('/', 'Home::index');

// PATIENTS
$routes->get('patients', 'Patients::index');
$routes->get('patients/create', 'Patients::create');
$routes->post('patients/create', 'Patients::create');


// ÉTABLISSEMENTS
$routes->get('etablishments', 'Etablishments::index');

//SPÉCIALITÉS
$routes->get('specialities', 'Specialities::index');

// PRATICIENS
$routes->get('practitioners', 'Practitioner::index');
$routes->get('practitioners/new', 'Practitioner::addView');
$routes->post('practitioners/create', 'Practitioner::create');


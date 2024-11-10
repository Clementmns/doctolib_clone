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
// add
$routes->get('practitioners/new', 'Practitioner::add');
$routes->post('practitioners/create', 'Practitioner::create');
// update
$routes->get('practitioners/edit/(:segment)', 'Practitioner::edit/$1');
$routes->post('practitioners/update/(:segment)', 'Practitioner::update/$1');
// delete
$routes->post('practitioners/delete/(:segment)', 'Practitioner::delete/$1');



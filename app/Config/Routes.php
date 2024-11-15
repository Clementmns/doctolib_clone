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

// ETABLISSEMENTS
$routes->get('etablishments', 'Etablishments::index');
$routes->get('etablishments/new', 'Etablishments::addView');
$routes->post('etablishments/create', 'Etablishments::create');
$routes->get('etablishments/edit/(:num)', 'Etablishments::edit/$1'); 
$routes->post('etablishments/update/(:num)', 'Etablishments::update/$1'); 





//SPÉCIALITÉS
$routes->get('specialities', 'Specialities::index');
$routes->get('specialities', 'Specialities::index');
$routes->get('specialities/add', 'Specialities::addView');
$routes->post('specialities/create', 'Specialities::create');
$routes->get('specialities/edit/(:num)', 'Specialities::edit/$1');
$routes->post('specialities/update/(:num)', 'Specialities::update/$1');


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


//APPPOINTMENT
$routes->get('patients/appointment', 'Appointment::index');
$routes->get('appointments', 'Appointment::all');
$routes->get('appointment/new', 'Appointment::add');
$routes->post('appointment/new', 'Appointment::add');
$routes->post('appointment/create', 'Appointment::create');


$routes->post('appointment/update', 'Appointment::update');
$routes->post('appointment/delete', 'Appointment::delete');
$routes->get('practitioners/appointments', 'Appointment::practitionerAppointments');
$routes->post('appointments/updatePrac', 'Appointment::updatePrac');
$routes->post('appointments/deletePrac', 'Appointment::deletePrac');


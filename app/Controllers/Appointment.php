<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;  // Utilisez AppointmentsModel ici

class Appointment extends BaseController
{
    public function index()
    {
        // Instancier correctement le modèle AppointmentsModel
        $model = new AppointmentsModel();

        // Récupérer l'ID du patient depuis l'URL
        $idPatient = $this->request->getVar('id_patient');
        if (!$idPatient) {
            return redirect()->to('/patients')->with('error', 'ID du patient non spécifié.');
        }

        // Pagination
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        // Récupérer les rendez-vous pour l'ID du patient
        $appointments = $model->getAppointments($idPatient, $page, $perPage);

        // Total des rendez-vous pour le patient spécifié
        $totalAppointments = $model->where('id_patient', $idPatient)->countAllResults();

        // Service de pagination
        $pager = \Config\Services::pager();

        // Données à envoyer à la vue
        $data = [
            'appointments' => $appointments,
            'title' => "Visualisation des rendez-vous du patient",
            'pager' => $pager->makeLinks($page, $perPage, $totalAppointments),
        ];

        // Chargement des vues
        echo view('templates/header', $data);
        echo view('patients/rdv_patient', $data);
        echo view('templates/footer', $data);
    }
}

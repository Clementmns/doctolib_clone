<?php

namespace App\Controllers;

use App\Models\PatientsModel;

class Patients extends BaseController {
    public function index(): void {
        $model = model(PatientsModel::class);

        // Récupère la page actuelle depuis l'URL (par exemple, page=2)
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10; // Nombre de patients par page

        // Récupère les patients paginés
        $patients = $model->getPatients($page, $perPage);

        // Récupère le nombre total de patients dans la base de données
        $totalPatients = $model->countAllResults();

        // Charger la bibliothèque de pagination de CodeIgniter
        $pager = \Config\Services::pager();

        $data = [
            'patients' => $patients,
            'title' => "Visualisation de tous les patients de la BDD",
            'pager' => $pager->makeLinks($page, $perPage, $totalPatients),
        ];

        echo view('templates/header', $data);
        echo view('patients/view', $data);
        echo view('templates/footer', $data);
    }
}

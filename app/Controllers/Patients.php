<?php

namespace App\Controllers;

use App\Models\PatientsModel;

class Patients extends BaseController {
    public function index(): void {
        // $model = model(PatientsModel::class);

        // $data = [
        //     'patients' => $model->getPatients(),
        //     'title' => "Visualisation de tous les patients de la BDD",
        // ];

        echo view('templates/header');
        echo view('patients/view');
        echo view('templates/footer');
    }
}
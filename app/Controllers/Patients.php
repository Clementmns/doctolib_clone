<?php

namespace App\Controllers;

use App\Models\PatientsModel;

class Patients extends BaseController {
    public function index(): void {
        $model = model(PatientsModel::class);

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $patients = $model->getPatients($page, $perPage);

        $totalPatients = $model->countAllResults();

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

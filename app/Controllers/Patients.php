<?php

namespace App\Controllers;

use App\Models\PatientsModel;

class Patients extends BaseController
{
    // Méthode pour afficher la liste des patients
    public function index(): void
    {
        $model = model(PatientsModel::class);

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        // Récupérer le terme de recherche
        $search = $this->request->getVar('search');

        // Filtrer les patients en fonction de la recherche
        $patients = $model->getPatients($page, $perPage, $search);
        $totalPatients = $model->countPatients($search);

        $pager = \Config\Services::pager();

        $data = [
            'patients' => $patients,
            'title' => "Visualisation de tous les patients de la BDD",
            'pager' => $pager->makeLinks($page, $perPage, $totalPatients),
            'search' => $search,
        ];

        echo view('templates/header', $data);
        echo view('patients/view', $data);
        echo view('templates/footer', $data);
    }

    // Méthode pour créer un patient
    public function create(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $validation = \Config\Services::validation();

        // Règles de validation pour les champs du formulaire
        $validation->setRules([
            'last_name' => 'required|max_length[50]',
            'first_name' => 'required|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'required|max_length[20]',
            'gender' => 'required|in_list[male,female,other]',
            'birth_date' => 'required|valid_date',
            'address' => 'required|max_length[255]',
        ]);

        helper('form');

        // Si la validation échoue, on affiche le formulaire avec les erreurs
        if (!$validation->withRequest($this->request)->run()) {
            echo view('templates/header', ['title' => 'Ajouter un patient']);
            echo view('patients/add_patient', ['validation' => $validation]);
            echo view('templates/footer');
            return '';
        }

        // Si la validation réussit, on enregistre les données
        $patientModel = new PatientsModel();
        $patientModel->save([
            'last_name' => $this->request->getPost('last_name'),
            'first_name' => $this->request->getPost('first_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'gender' => $this->request->getPost('gender'),
            'birth_date' => $this->request->getPost('birth_date'),
            'address' => $this->request->getPost('address'),
        ]);

        // Redirection après l'ajout avec un message de succès
        return redirect()->to(base_url('patients'))->with('success', 'Patient ajouté avec succès');
    }
}

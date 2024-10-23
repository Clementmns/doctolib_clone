<?php

namespace App\Controllers;

use App\Models\EtablishmentsModel;

class Etablishments extends BaseController {

    public function index(): void {
        $model = model(EtablishmentsModel::class);

        // Récupérer la page actuelle depuis l'URL
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10; // Nombre d'établissements par page

        // Récupérer les établissements paginés
        $etablishments = $model->getEtablishments($page, $perPage);

        // Récupérer le nombre total d'établissements dans la base de données
        $totalEtablishments = $model->countAllResults();

        // Charger la bibliothèque de pagination de CodeIgniter
        $pager = \Config\Services::pager(); 

        $data = [
            'etablishments' => $etablishments,
            'title' => "Liste des établissements",
            'pager' => $pager->makeLinks($page, $perPage, $totalEtablishments),
        ];

        echo view('templates/header', $data);
        echo view('etablishments/view', $data);
        echo view('templates/footer', $data);
    }

    // Méthode pour afficher la vue d'ajout
    public function addView() {
        helper('form');

        $data = [
            'title' => 'Ajouter un établissement',
        ];

      if (!$validation->withRequest($this->request)->run()) {
    echo view('templates/header', ['title' => 'Ajouter un établissement']);
    echo view('etablishments/add_etablishments', ['validation' => $validation]);
    echo view('templates/footer');
    return '';
}


    }

    // Méthode pour créer un nouvel établissement
    public function create() {
        $validation = \Config\Services::validation();

        // Définir les règles de validation
        $validation->setRules([
            'name' => 'required|max_length[50]',
            'location' => 'required|max_length[50]',
            'open_hour' => 'required|max_length[50]', // Ajout de la validation pour open_hour
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // En cas d'erreur de validation, retourner à la vue d'ajout avec les erreurs
            return view('etablishments/add_etablishments', ['validation' => $validation]);
        }

        $model = new EtablishmentsModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'open_hour' => $this->request->getPost('open_hour'), // Sauvegarde de open_hour
        ]);

        return redirect()->to(base_url('etablishments'))->with('success', 'Établissement ajouté avec succès');
    }
}

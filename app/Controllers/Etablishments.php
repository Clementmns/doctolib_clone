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


}

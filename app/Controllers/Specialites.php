<?php

namespace App\Controllers;

use App\Models\SpecialitesModel;

class Specialites extends BaseController
{
    public function index(): void
    {
        $model = model(SpecialitesModel::class);

        $perPage = 10; // Nombre d'éléments par page
        $specialites = $model->paginate($perPage); // Récupère les spécialités paginées
        $pager = $model->pager; // Génère la pagination

        $data = [
            'specialites' => $specialites,
            'title' => "Visualisation de toutes les spécialités de la BDD",
            'pager' => $pager,
        ];

        echo view('templates/header', $data);
        echo view('specialities/view', $data);
        echo view('templates/footer', $data);
    }
}

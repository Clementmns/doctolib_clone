<?php

namespace App\Controllers;

use App\Models\SpecialitiesModel;

class Specialities extends BaseController
{
    public function index(): void
    {
        $model = model(SpecialitiesModel::class);

        $perPage = 10; // Nombre d'éléments par page
        $specialities = $model->paginate($perPage); // Récupère les spécialités paginées
        $pager = $model->pager; // Génère la pagination

        $data = [
            'specialities' => $specialities,
            'title' => "Visualisation de toutes les spécialités de la BDD",
            'pager' => $pager,
        ];

        echo view('templates/header', $data);
        echo view('specialities/view', $data);
        echo view('templates/footer', $data);
    }
}

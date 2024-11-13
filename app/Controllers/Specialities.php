<?php
namespace App\Controllers;

use App\Models\SpecialitiesModel;

class Specialities extends BaseController
{
    // Méthode pour afficher la liste des spécialités
    public function index(): void
    {
        $model = model(SpecialitiesModel::class);
        $perPage = 10;
        $specialities = $model->paginate($perPage);
        $pager = $model->pager;

        $data = [
            'specialities' => $specialities,
            'title' => "Visualisation de toutes les spécialités de la BDD",
            'pager' => $pager,
        ];

        echo view('templates/header', $data);
        echo view('specialities/view', $data);
        echo view('templates/footer', $data);
    }

    // Méthode pour afficher le formulaire d'ajout de spécialité
    public function addView()
    {
        $data = [
            'title' => 'Ajouter une spécialité',
            'description' => old('description'),
        ];

        echo view('templates/header', $data);
        echo view('specialities/add', $data);
        echo view('templates/footer');
    }

    // Méthode pour enregistrer une nouvelle spécialité
    public function create()
    {
        $validation = \Config\Services::validation();

        // Définir les règles de validation
        $validation->setRules([
            'description' => 'required|max_length[255]',
        ]);

        // Si la validation échoue
        if (!$validation->withRequest($this->request)->run()) {
            return view('specialities/add', [
                'validation' => $validation,
                'description' => $this->request->getPost('description'),
            ]);
        }

        // Si la validation réussit, sauvegarder la nouvelle spécialité
        $model = model(SpecialitiesModel::class);
        $model->save([
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('specialities'))->with('success', 'Spécialité ajoutée avec succès');
    }
}

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

    // Méthode pour afficher le formulaire d'édition d'une spécialité
    public function edit($id): void
    {
        $model = model(SpecialitiesModel::class);
        $speciality = $model->find($id);

        if (!$speciality) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Spécialité avec l'id $id non trouvée");
        }

        $data = [
            'speciality' => $speciality,
            'title' => "Modifier la spécialité",
            'validation' => \Config\Services::validation(),
        ];

        echo view('templates/header', $data);
        echo view('specialities/edit', $data); // Vue pour le formulaire de modification
        echo view('templates/footer');
    }

    // Méthode pour afficher le formulaire d'ajout d'une spécialité
    public function addView(): void
    {
        $data = [
            'title' => 'Ajouter une spécialité',
            'validation' => \Config\Services::validation(),
        ];

        echo view('templates/header', $data);
        echo view('specialities/add', $data); // Vue pour le formulaire d'ajout
        echo view('templates/footer');
    }

    // Méthode pour ajouter une spécialité
    public function create()
    {
        $validation = \Config\Services::validation();

        // Définir les règles de validation
        $validation->setRules([
            'description' => 'required|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('specialities/add', [
                'validation' => $validation,
                'title' => 'Ajouter une spécialité',
            ]);
        }

        $model = model(SpecialitiesModel::class);
        $model->save([
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('specialities'))->with('success', 'Spécialité ajoutée avec succès');
    }

    // Méthode pour mettre à jour une spécialité
    public function update($id)
    {
        $validation = \Config\Services::validation();

        // Définir les règles de validation
        $validation->setRules([
            'description' => 'required|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('specialities/edit/' . $id))->withInput()->with('validation', $validation);
        }

        $model = model(SpecialitiesModel::class);
        $model->update($id, [
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('specialities'))->with('success', 'Spécialité modifiée avec succès');
    }
}

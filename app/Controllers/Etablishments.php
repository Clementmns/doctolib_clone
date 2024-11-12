<?php

namespace App\Controllers;

use App\Models\EtablishmentsModel;

class Etablishments extends BaseController {

    public function __construct() {
        helper('form');  // Charger le helper 'form' pour les formulaires
    }

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
        $data = [
            'title' => 'Ajouter un établissement',
            // Si vous avez déjà saisi des données, elles peuvent être envoyées ici
            'name' => old('name'),
            'location' => old('location'),
            'open_hour' => old('open_hour'),
        ];

        echo view('templates/header', ['title' => 'Ajouter un établissement']);
        echo view('etablishments/add_etablishments', $data);
        echo view('templates/footer');
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

        // Si la validation échoue
        if (!$validation->withRequest($this->request)->run()) {
            // Retourner à la vue d'ajout avec les erreurs et les données déjà saisies
            return view('etablishments/add_etablishments', [
                'validation' => $validation,
                'name' => $this->request->getPost('name'),
                'location' => $this->request->getPost('location'),
                'open_hour' => $this->request->getPost('open_hour'),
            ]);
        }

        // Si la validation réussit, on sauvegarde les données dans la base de données
        $model = new EtablishmentsModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'open_hour' => $this->request->getPost('open_hour'), // Sauvegarde de open_hour
        ]);

        return redirect()->to(base_url('etablishments'))->with('success', 'Établissement ajouté avec succès');
    }

    // Méthode pour afficher la vue de modification
    public function edit($id) {
        $model = new EtablishmentsModel();
        $etablishment = $model->find($id);

        if (!$etablishment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Établissement avec l'ID $id non trouvé");
        }

        // Afficher le formulaire avec les données de l'établissement à modifier
        $data = [
            'title' => 'Modifier un établissement',
            'etablishment' => $etablishment,
            'name' => old('name', $etablishment['name']),
            'location' => old('location', $etablishment['location']),
            'open_hour' => old('open_hour', $etablishment['open_hour']),
        ];

        echo view('templates/header', $data);
        echo view('etablishments/edit_etablishments', $data);
        echo view('templates/footer');
    }

    // Méthode pour mettre à jour un établissement
    public function update($id) {
        $validation = \Config\Services::validation();

        // Définir les règles de validation
        $validation->setRules([
            'name' => 'required|max_length[50]',
            'location' => 'required|max_length[50]',
            'open_hour' => 'required|max_length[50]',
        ]);

        // Si la validation échoue
        if (!$validation->withRequest($this->request)->run()) {
            // Retourner à la vue de modification avec les erreurs et les données déjà saisies
            return redirect()->to('etablishments/edit/' . $id)->withInput()->with('validation', $validation);
        }

        $model = new EtablishmentsModel();

        // Mettre à jour les informations de l'établissement
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'open_hour' => $this->request->getPost('open_hour'),
        ]);

        return redirect()->to(base_url('etablishments'))->with('success', 'Établissement mis à jour avec succès');
    }
    
}

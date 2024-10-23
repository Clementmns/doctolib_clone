<?php

namespace App\Controllers;

use App\Models\PatientsModel;
use App\Models\PractitionersModel;
use App\Models\SpecialitiesModel;

class Practitioner extends BaseController {
    public function index(): void {
        $model = model(PractitionersModel::class);

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $practitioners = $model->getPractitioner($page, $perPage);

        $totalPractitioners = $model->countAllResults();

        $pager = \Config\Services::pager();

        $data = [
            'practitioners' => $practitioners,
            'title' => "Visualisation de tous les pratitiens de la BDD",
            'pager' => $pager->makeLinks($page, $perPage, $totalPractitioners),
        ];

        echo view('templates/header', $data);
        echo view('practitioners/view', $data);
        echo view('templates/footer', $data);
    }

    public function addView(): void
    {
        helper('form');
        echo view('templates/header', ['title' => 'Ajout d\'un praticien']);
        echo view('practitioners/add_practitioner');
        echo view('templates/footer');
    }

    public function create(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'last_name' => 'required|max_length[50]',
            'first_name' => 'required|max_length[50]',
            'availability' => 'max_length[100]',
        ]);

        helper('form');

        if (!$validation->withRequest($this->request)->run()) {
            return view('practitioners/add_practitioner', ['validation' => $validation]);
        }

        $days = $this->request->getPost('day');
        $start_times = $this->request->getPost('start_time');
        $end_times = $this->request->getPost('end_time');

        $availability = [];

        foreach ($days as $index => $day) {
            $availability[] = [
                'day' => $day,
                'from' => $start_times[$index],
                'to' => $end_times[$index],
            ];
        }

        $availability_json = json_encode($availability);

        $practitionerModel = new PractitionersModel();
        $practitionerModel->save([
            'last_name' => $this->request->getPost('last_name'),
            'first_name' => $this->request->getPost('first_name'),
            'availability' => $availability_json,
        ]);

        return redirect()->to(base_url('practitioners'))->with('success', 'Praticien ajouté avec succès');
    }

    public function addSpeciality(): void
    {
        $practitionersModel = model(PractitionersModel::class);
        $specialitiesModel = model(SpecialitiesModel::class);

        $practitioners = $practitionersModel->findAll();
        $specialities = $specialitiesModel->findAll();

        $data = [
            'practitioners' => $practitioners,
            'specialities' => $specialities,
        ];

        helper('form');
        echo view('templates/header', ['title' => 'Association d\'une spécialité à un praticien']);
        echo view('practitioners/add_speciality', $data);
        echo view('templates/footer');
    }

    public function associatePraSpe(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'first_name' => 'required',
            'last_name' => 'required',
            'speciality_id' => 'required|is_not_unique[speciality.id_speciality]',
        ]);

        helper('form');

        if (!$validation->withRequest($this->request)->run()) {
            echo view('templates/header', ['title' => 'Association d\'une spécialité à un praticien']);
            echo view('practitioners/add_speciality', [
                'validation' => $validation,
                'practitioners' => model(PractitionersModel::class)->findAll(),
                'specialities' => model(SpecialitiesModel::class)->findAll(),
            ]);
            echo view('templates/footer');
        }

        $speciality_id = $this->request->getPost('speciality_id');
        $practitioner_first_name = $this->request->getPost('first_name');
        $practitioner_last_name = $this->request->getPost('last_name');

        $practitionerModel = new PractitionersModel();
        $practitioner = $practitionerModel->where('first_name', $practitioner_first_name)
            ->where('last_name', $practitioner_last_name)
            ->first();

        if (!$practitioner) {
            return redirect()->back()->with('error', 'Praticien introuvable. Vérifiez le prénom et le nom de famille.')->withInput();
        }

        $practitioner_id = $practitioner['id_practitioner'];

        $practitionerModel = new PractitionersModel();
        $practitionerModel->addSpecialityToPractitioner($practitioner_id, $speciality_id);

        return redirect()->to(base_url('practitioners'))->with('success', 'Spécialité associée au praticien avec succès');
    }

}

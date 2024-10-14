<?php

namespace App\Controllers;

use App\Models\PatientsModel;
use App\Models\PractitionersModel;

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

    public function addView(): string
    {
        helper('form');
        return view('practitioners/add_practitioner');
    }

    /**
     * @throws \ReflectionException
     */
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
}

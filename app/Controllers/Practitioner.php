<?php

namespace App\Controllers;

use App\Models\EtablishmentsModel;
use App\Models\PatientsModel;
use App\Models\PractitionersModel;
use App\Models\SpecialitiesModel;

class Practitioner extends BaseController {

    private function getSpecialities(): array
    {
        $specialityModel = new SpecialitiesModel();
        return $specialityModel->findAll();
    }

    public function index(): void {
        $model = new PractitionersModel();
        $establishmentModel = new EtablishmentsModel();

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $specialityId = $this->request->getVar('speciality') ?? null;

        if ($specialityId) {
            $practitioners = $model->getPractitionersBySpeciality($specialityId, $page, $perPage);
        } else {
            $practitioners = $model->getPractitioner($page, $perPage);
        }

        foreach ($practitioners as &$practitioner) {
            $specialities = $model->getSpecialitiesByPractitionerId($practitioner['id_practitioner']);
            $establishments = $establishmentModel->getEstablishmentsByPractitionerId($practitioner['id_practitioner']);

            $practitioner['specialities'] = array_column($specialities, 'description');
            $practitioner['establishments'] = array_column($establishments, 'name');
        }

        $totalPractitioners = $model->countAllResults();

        $pager = \Config\Services::pager();

        $specialities = $this->getSpecialities();

        $data = [
            'practitioners' => $practitioners,
            'specialities' => $specialities,
            'pager' => $pager->makeLinks($page, $perPage, $totalPractitioners),
        ];

        echo view('templates/header', $data);
        echo view('practitioners/view', $data);
        echo view('templates/footer', $data);
    }

    public function create(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'last_name' => 'required|max_length[50]',
            'first_name' => 'required|max_length[50]',
            'availability' => 'max_length[100]',
            'etablishment' => 'required',
        ]);

        helper('form');

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout du praticien.');
        }

        $days = $this->request->getPost('day') ?? [];
        $start_times = $this->request->getPost('start_time') ?? [];
        $end_times = $this->request->getPost('end_time') ?? [];

        if (!empty($days) && is_array($days)) {
            $availability = [];
            $count = count($days);

            for ($index = 0; $index < $count; $index++) {
                if (isset($start_times[$index]) && isset($end_times[$index])) {
                    $availability[] = [
                        'day' => $days[$index],
                        'from' => $start_times[$index],
                        'to' => $end_times[$index],
                    ];
                }
            }
        } else {
            $availability = [];
        }

        $availability_json = json_encode($availability);

        $practitionerModel = new PractitionersModel();
        $speciality_ids = $this->request->getPost('speciality_ids') ?? [];

        $establishment_id = $this->request->getPost('etablishment');

        try {
            $practitionerModel->save([
                'last_name' => $this->request->getPost('last_name'),
                'first_name' => $this->request->getPost('first_name'),
                'availability' => $availability_json,
            ]);

            $practitioner_id = $practitionerModel->getInsertID();

            foreach ($speciality_ids as $speciality_id) {
                $practitionerModel->addSpecialityToPractitioner($practitioner_id, $speciality_id);
            }
            (new EtablishmentsModel())->addEstablishmentToPractitioner($practitioner_id, $establishment_id);

        } catch (\ReflectionException $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout du praticien.');
        }

        return redirect()->to(base_url('practitioners'))->with('success', 'Praticien ajouté avec succès');
    }

    public function edit($id): void {
        $practitionersModel = new PractitionersModel();
        $practitioner = $practitionersModel->getPractitionerById($id);

        $specialitiesModel = new SpecialitiesModel();
        $availableSpecialities = $specialitiesModel->findAll();

        $establishmentModel = new EtablishmentsModel();
        $availableEstablishments = $establishmentModel->findAll();
        $establishment = $establishmentModel->getEstablishmentsByPractitionerId($id);

        if (!$practitioner) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Praticien non trouvé');
        }

        $specialities = $practitionersModel->getSpecialitiesByPractitionerId($id);

        echo view('templates/header', ['title' => 'Modification d\'un praticien']);
        echo view('practitioners/edit_practitioner', [
            'practitioner' => $practitioner,
            'selectedSpecialities' => $specialities,
            'specialities' => $availableSpecialities,
            'selectedEstablishment' => $establishment,
            'availableEstablishments' => $availableEstablishments,
        ]);
        echo view('templates/footer');
    }

    public function add(): void
    {
        $specialitiesModel = model(SpecialitiesModel::class);
        $specialities = $specialitiesModel->findAll();
        $establishmentModel = new EtablishmentsModel();
        $establishments = $establishmentModel->findAll();

        $data = [
            'specialities' => $specialities,
            'establishments' => $establishments,
        ];

        helper('form');
        echo view('templates/header', ['title' => 'Ajout d\'un praticien']);
        echo view('practitioners/add_practitioner', $data);
        echo view('templates/footer');
    }

    public function update($id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $practitionersModel = new PractitionersModel();
        $specialitiesModel = new SpecialitiesModel();
        $establishmentModel = new EtablishmentsModel();

        $data = [
            'last_name' => $this->request->getPost('last_name'),
            'first_name' => $this->request->getPost('first_name'),
        ];

        if ($this->validate([
            'last_name' => 'required|min_length[2]|max_length[50]',
            'first_name' => 'required|min_length[2]|max_length[50]',
        ])) {
            $days = $this->request->getPost('day');
            $startTimes = $this->request->getPost('start_time');
            $endTimes = $this->request->getPost('end_time');

            $availability = [];
            if ($days && $startTimes && $endTimes) {
                for ($i = 0; $i < count($days); $i++) {
                    if (!empty($days[$i]) && !empty($startTimes[$i]) && !empty($endTimes[$i])) {
                        $availability[] = [
                            'day' => $days[$i],
                            'from' => $startTimes[$i],
                            'to' => $endTimes[$i],
                        ];
                    }
                }
            }

            if (!empty($availability)) {
                $data['availability'] = json_encode($availability);
            }

            $selectedSpecialities = $this->request->getPost('speciality_ids');
            var_dump($selectedSpecialities);

            $practitionersModel->deleteSpecialitiesToPractitioner($id);
            $establishmentModel->deleteEstablishmentToPractitioner($id);
            $establishmentModel->addEstablishmentToPractitioner($id, $this->request->getPost('etablishment'));

            if (!empty($selectedSpecialities)) {
                foreach ($selectedSpecialities as $specialityId) {
                    $practitionersModel->addSpecialityToPractitioner($id, $specialityId);
                }
            }

            try {
                $practitionersModel->update($id, $data);
            } catch (\ReflectionException $e) {
                return redirect()->back()->with('error', 'Erreur lors de la mise à jour du praticien : ' . $e->getMessage());
            }

            return redirect()->to(base_url('practitioners'))->with('success', 'Praticien mis à jour avec succès.');
        } else {
            $data['validation'] = $this->validator;

            $data['practitioner'] = $practitionersModel->find($id);
            $data['specialities'] = $practitionersModel->getSpecialitiesByPractitionerId($id);
            $data['selectedEstablishment'] = $establishmentModel->getEstablishmentsByPractitionerId($id);
            $data['establishments'] = $establishmentModel->findAll();
            $data['selectedSpecialities'] = $practitionersModel->getSpecialitiesByPractitionerId($id);

            return view('practitioners/edit', $data);
        }
    }

    public function delete($id): \CodeIgniter\HTTP\RedirectResponse
    {
        $establishmentModel = new EtablishmentsModel();
        $practitionersModel = new PractitionersModel();
        $practitionersModel->deleteSpecialitiesToPractitioner($id);
        $establishmentModel->deleteEstablishmentToPractitioner($id);
        $practitionersModel->delete($id);

        return redirect()->to(base_url('practitioners'))->with('success', 'Praticien supprimé avec succès.');
    }
}

<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;
use App\Models\EtablishmentsModel;
use App\Models\PatientsModel;
use App\Models\PractitionersModel;
use App\Models\SpecialitiesModel;

class Appointment extends BaseController
{
    public function index()
    {
        $model = new AppointmentsModel();
        $practitionerModel = new PractitionersModel();

        $idPatient = $this->request->getVar('id_patient');
        if (!$idPatient) {
            return redirect()->back()->with('error', 'ID du patient non spécifié.');
        }

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $appointments = $model->getAppointments($idPatient, $page, $perPage);

        foreach ($appointments as &$appointment) {
            $practitioner = $practitionerModel->getPractitionerByAppointmentId($appointment['id_appointment']);
            $appointment['practitioner'] = $practitioner[0]["first_name"] . ' ' . $practitioner[0]["last_name"];
            $appointment['practitioner_id'] = $practitioner[0]["id_practitioner"];
        }
        unset($appointment);

        $totalAppointments = $model->where('id_patient', $idPatient)->countAllResults();

        $pager = \Config\Services::pager();

        $data = [
            'appointments' => $appointments,
            'practitioners' => $practitionerModel->findAll(),
            'title' => "Visualisation des rendez-vous du patient",
            'pager' => $pager->makeLinks($page, $perPage, $totalAppointments),
        ];

        echo view('templates/header', $data);
        echo view('patients/rdv_patient', $data);
        echo view('templates/footer', $data);
    }

    public function all(): void
    {
        $model = new AppointmentsModel();
        $practitionerModel = new PractitionersModel();
        $patientModel = new PatientsModel();
        $etablishmentModel = new EtablishmentsModel();
        $specialityModel = new SpecialitiesModel();

        $filterType = $this->request->getGet('filterType');
        $filterValue = $this->request->getGet('filterValue');

        $appointments = $model->getAppointmentsByFilter($filterType, $filterValue);

        foreach ($appointments as &$appointment) {
            $appointment['practitioner'] = $practitionerModel->getPractitionerById($appointment['id_practitioner']);
            $appointment['patient'] = $patientModel->getPatientById($appointment['id_patient']);
            $appointment['etablishment'] = $etablishmentModel->getEtablishmentById($appointment['id_etablishment']);
        }
        unset($appointment);

        $data = [
            'appointments' => $appointments,
            'practitioners' => $practitionerModel->findAll(),
            'patients' => $patientModel->findAll(),
            'etablishments' => $etablishmentModel->findAll(),
            'specialities' => $specialityModel->findAll(),
            'filterType' => $filterType,
            'filterValue' => $filterValue,
        ];

        echo view('templates/header', $data);
        echo view('appointments/view', $data);
        echo view('templates/footer', $data);
    }

    public function add()
    {
        $practitionerModel = new PractitionersModel();
        $specialityModel = new SpecialitiesModel();
        $etablishmentModel = new EtablishmentsModel();
        $patientModel = new PatientsModel();

        $specialities = $specialityModel->findAll();
        $etablishments = [];
        $practitioners = [];
        $selectedPatientId = null;
        $patients = $patientModel->orderBy('last_name', 'ASC')->findAll();

        $selectedSpecialityId = $this->request->getVar('id_speciality');
        $selectedEstablishmentId = $this->request->getVar('id_etablishment');
        $selectedPractitionerId = $this->request->getVar('id_practitioner');
        $selectedPatientId = $this->request->getVar('id_patient');
        $appointment_time = $this->request->getVar('appointment_time');

        if ($selectedSpecialityId) {
            $etablishments = $etablishmentModel->getEstablishmentsBySpeciality($selectedSpecialityId);
        }

        if ($selectedEstablishmentId && $selectedSpecialityId) {
            $practitioners = $practitionerModel->getPractitionersByEstablishmentAndSpeciality($selectedEstablishmentId, $selectedSpecialityId);
        }

        if($appointment_time){
            $appointment_time = date('Y-m-d', strtotime($appointment_time));
            if ($selectedPatientId || $selectedEstablishmentId || $selectedPractitionerId || $selectedSpecialityId) {
                $model = new AppointmentsModel();
                $data = [
                    'date' => $appointment_time,
                    'id_practitioner' => $selectedPractitionerId,
                    'id_patient' => $selectedPatientId,
                    'id_etablishment' => $selectedEstablishmentId,
                    'title' => $this->request->getVar('appointment_title'),
                ];
                try {
                    $model->insert($data);
                    return redirect()->to('appointments')->with('success', 'Rendez-vous ajouté avec succès.');
                } catch (\ReflectionException $e) {
                    return redirect()->back()->with('error', 'Erreur lors de l\'ajout du rendez-vous : ' . $e->getMessage());
                }
            }
        }


        $data = [
            'specialities' => $specialities,
            'selectedSpecialityId' => $selectedSpecialityId,
            'etablishments' => $etablishments,
            'selectedEstablishmentId' => $selectedEstablishmentId,
            'practitioners' => $practitioners,
            'selectedPractitionerId' => $selectedPractitionerId,
            'selectedPatientId' => $selectedPatientId,
            'patients' => $patients,
            'appointment_time' => $appointment_time,
        ];

        // Charger la vue
        echo view('templates/header', $data);
        echo view('appointments/add', $data);
        echo view('templates/footer', $data);
    }

    public function update(): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new AppointmentsModel();

        $appointmentId = $this->request->getPost('id_appointment');
        $date = $this->request->getPost('date');
        $practitionerId = $this->request->getPost('id_practitioner');
        $title = $this->request->getPost('title');

        if (!$appointmentId || !$date || !$practitionerId || !$title) {
            return redirect()->to('patients/appointment')->with('error', 'Données manquantes pour la mise à jour.');
        }

        $updateData = [
            'date' => $date,
            'id_practitioner' => $practitionerId,
            'title' => $title,
        ];

        try {
            $model->update($appointmentId, $updateData);
        } catch (\ReflectionException $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du praticien : ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Le rendez-vous a été mis à jour.');
    }

    public function delete(): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new AppointmentsModel();
        $appointmentId = $this->request->getPost('id_appointment');

        if (!$appointmentId) {
            return redirect()->back()->with('error', 'Aucun rendez-vous spécifié pour la suppression.');
        }
        try {
            $model->delete($appointmentId);
        } catch (\ReflectionException $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du rendez-vous : ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Rendez-vous supprimé avec succès.');
    }

    public function practitionerAppointments()
    {
        $model = new AppointmentsModel();
        $practitionerModel = new PractitionersModel();

        $idPractitioner = $this->request->getVar('id_practitioner');
        if (!$idPractitioner) {
            return redirect()->to('/practitioners')->with('error', 'ID du praticien non spécifié.');
        }

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $appointments = $model->getAppointmentsByPractitioner($idPractitioner, $page, $perPage);

        $practitioner = $practitionerModel->find($idPractitioner);
        $totalAppointments = $model->where('id_practitioner', $idPractitioner)->countAllResults();
        $pager = \Config\Services::pager();

        $data = [
            'appointments' => $appointments,
            'practitioner' => $practitioner,
            'title' => "Rendez-vous du praticien",
            'pager' => $pager->makeLinks($page, $perPage, $totalAppointments),
        ];

        echo view('templates/header', $data);
        echo view('practitioners/rdv_prac', $data);
        echo view('templates/footer', $data);
    }

    public function updatePrac(): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new AppointmentsModel();

        // Récupérer les données postées
        $appointmentId = $this->request->getPost('id_appointment');
        $date = $this->request->getPost('date');
        $title = $this->request->getPost('title');

        // Validation des données
        if (!$appointmentId || !$date || !$title
        ) {
            return redirect()->to('/practitioners/appointments')->with('error', 'Données manquantes pour la mise à jour.');
        }

        // Vérification que le rendez-vous existe dans la base de données
        $appointment = $model->find($appointmentId);
        if (!$appointment) {
            return redirect()->to('/practitioners/appointments')->with('error', 'Rendez-vous non trouvé.');
        }

        // Préparer les données à mettre à jour
        $updateData = [
                'date' => $date,
                'title' => $title,
            ];

        try {
            // Mise à jour du rendez-vous
            $model->update($appointmentId, $updateData);
        } catch (\Exception $e) {
            return redirect()->to('/practitioners/appointments')->with('error', 'Erreur lors de la mise à jour du rendez-vous : ' . $e->getMessage());
        }

        // Si la mise à jour réussit, rediriger avec un message de succès
        return redirect()->to('/practitioners')->with('success', 'Le rendez-vous a été mis à jour.');
    }

    public function deletePrac(): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new AppointmentsModel();
        $appointmentId = $this->request->getPost('id_appointment');

        if (!$appointmentId) {
            return redirect()->to('/practitioners/appointments')->with('error', 'Aucun rendez-vous spécifié pour la suppression.');
        }

        try {
            $model->delete($appointmentId);
        } catch (\ReflectionException $e) {
            return redirect()->to('/practitioners/appointments')->with('error', 'Erreur lors de la suppression du rendez-vous : ' . $e->getMessage());
        }

        return redirect()->to('/practitioners')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}

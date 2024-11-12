<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;
use App\Models\PractitionersModel;

class Appointment extends BaseController
{
    // Fonction index : Afficher les rendez-vous d'un patient
    public function index()
    {
        $model = new AppointmentsModel();
        $practitionerModel = new PractitionersModel();

        $idPatient = $this->request->getVar('id_patient');
        if (!$idPatient) {
            return redirect()->to('/patients')->with('error', 'ID du patient non spécifié.');
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

    // Fonction update : Mise à jour d'un rendez-vous
    public function update(): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new AppointmentsModel();

        $appointmentId = $this->request->getPost('id_appointment');
        $date = $this->request->getPost('date');
        $practitionerId = $this->request->getPost('id_practitioner');
        $title = $this->request->getPost('title');

        // Validation des données
        if (!$appointmentId || !$date || !$practitionerId || !$title) {
            return redirect()->to('/patients/appointment')->with('error', 'Données manquantes pour la mise à jour.');
        }

        $updateData = [
            'date' => $date,
            'id_practitioner' => $practitionerId,
            'title' => $title,
        ];

        try {
            $model->update($appointmentId, $updateData);
        } catch (\ReflectionException $e) {
            return redirect()->to('/patients/appointment')->with('error', 'Erreur lors de la mise à jour du rendez-vous : ' . $e->getMessage());
        }

        return redirect()->to('/patients/appointment')->with('success', 'Le rendez-vous a été mis à jour.');
    }

    // Fonction delete : Suppression d'un rendez-vous
    public function delete(): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new AppointmentsModel();
        $appointmentId = $this->request->getPost('id_appointment');

        if (!$appointmentId) {
            return redirect()->to('/patients/appointment')->with('error', 'Aucun rendez-vous spécifié pour la suppression.');
        }

        try {
            $model->delete($appointmentId);
        } catch (\ReflectionException $e) {
            return redirect()->to('/patients/appointment')->with('error', 'Erreur lors de la suppression du rendez-vous : ' . $e->getMessage());
        }

        return redirect()->to('/patients/appointment')->with('success', 'Rendez-vous supprimé avec succès.');
    }

    // Fonction practitionerAppointments : Liste des rendez-vous pour un praticien
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

    // Fonction updatePrac : Mise à jour d'un rendez-vous d'un praticien
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


    // Fonction deletePrac : Suppression d'un rendez-vous d'un praticien
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

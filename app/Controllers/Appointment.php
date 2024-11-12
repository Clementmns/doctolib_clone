<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;
use App\Models\PractitionersModel;

class Appointment extends BaseController
{
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
        return redirect()->to('patients')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}

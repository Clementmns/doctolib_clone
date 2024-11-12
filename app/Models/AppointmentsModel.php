<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentsModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'id_appointment';
    protected $allowedFields = [
        'id_practitioner',
        'id_patient',
        'date',
        'title',
        'id_etablishment'
    ];

    public function getAppointments($idPatient, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        return $this->where('id_patient', $idPatient)
            ->orderBy('date', 'ASC')
            ->limit($perPage, $offset)
            ->find();
    }

    public function getAppointmentsByPractitioner($idPractitioner, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        return $this->where('id_practitioner', $idPractitioner)
            ->orderBy('date', 'ASC')
            ->limit($perPage, $offset)
            ->find();
    }

    // Nouvelle méthode de mise à jour d'un rendez-vous
    public function updateAppointment($appointmentId, $data)
    {
        return $this->update($appointmentId, $data);
    }
}

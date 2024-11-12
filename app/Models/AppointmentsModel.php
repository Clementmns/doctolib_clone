<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentsModel extends Model
{

    protected $table = 'appointment';
    protected $primaryKey = 'id_appointment'; // Clé primaire
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

        $results = $this->where('id_patient', $idPatient)
            ->orderBy('date', 'ASC')
            ->limit($perPage, $offset)
            ->find();

        return $results;
    }

    public function getAllAppointments($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        return $this->orderBy('date', 'ASC')
            ->limit($perPage, $offset)
            ->find();
    }
}

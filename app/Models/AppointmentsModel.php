<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentsModel extends Model
{
    protected $table = 'appointment';
    protected $allowedFields = [
        'id_practioner',
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
}

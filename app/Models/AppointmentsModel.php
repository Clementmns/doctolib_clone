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



    public function getAppointmentBySpecialityId($specialityId): array|object|null
    {
        return $this->select('appointment.*')
            ->join('pra_spe', 'pra_spe.id_practitioner = appointment.id_practitioner')
            ->where('pra_spe.id_speciality', $specialityId)
            ->find();
    }
    public function getAppointmentsByFilter($filterType, $filterValue): array
    {
        if (!$filterType || !$filterValue) {
            return $this->findAll();
        }

        $this->select('appointment.*')
            ->join('practitioner', 'practitioner.id_practitioner = appointment.id_practitioner')
            ->join('pra_spe', 'pra_spe.id_practitioner = practitioner.id_practitioner')
            ->join('speciality', 'speciality.id_speciality = pra_spe.id_speciality')
            ->join('patient', 'patient.id_patient = appointment.id_patient')
            ->join('pra_etab', 'pra_etab.id_practitioner = practitioner.id_practitioner')
            ->join('etablishment', 'etablishment.id_etablishment = appointment.id_etablishment');

        switch ($filterType) {
            case 'speciality':
                $this->where('speciality.id_speciality', $filterValue);
                break;
            case 'etablishment':
                $this->where('etablishment.id_etablishment', $filterValue);
                break;
            case 'patient':
                $this->where('patient.id_patient', $filterValue);
                break;
            case 'practitioner':
                $this->where('practitioner.id_practitioner', $filterValue);
                break;
        }

        return $this->findAll();
    }

}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PractitionersModel extends Model
{
    protected $table = 'practitioner';
    protected $primaryKey = 'id_practitioner';
    protected $allowedFields = ['last_name', 'first_name', 'availability'];

    public function getPractitioner($page = 1, $perPage = 10): object|array|null
    {
        $offset = ($page - 1) * $perPage;

        return $this->orderBy('last_name', 'ASC')
            ->limit($perPage, $offset)
            ->find();
    }

    public function getPractitionerById(int $id): object|array|null
    {
        return $this->where('id_practitioner', $id)->first();
    }

    public function getSpecialitiesByPractitionerId($practitioner_id): array
    {
        return $this->db->table('pra_spe')
            ->join('speciality', 'pra_spe.id_speciality = speciality.id_speciality')
            ->where('pra_spe.id_practitioner', $practitioner_id)
            ->select('speciality.*')
            ->get()
            ->getResultArray();
    }

    public function getPractitionersBySpeciality($speciality_id, $page = 1, $perPage = 10): object|array|null
    {
        $offset = ($page - 1) * $perPage;

        return $this->db->table('pra_spe')
            ->join('practitioner', 'pra_spe.id_practitioner = practitioner.id_practitioner')
            ->where('pra_spe.id_speciality', $speciality_id)
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }

    public function addSpecialityToPractitioner($practitioner_id, $speciality_id): bool
    {
        $data = [
            'id_practitioner' => $practitioner_id,
            'id_speciality' => $speciality_id,
        ];

        return $this->db->table('pra_spe')->insert($data);
    }

    public function deleteSpecialitiesToPractitioner($practitioner_id): bool
    {
        return $this->db->table('pra_spe')
            ->where('id_practitioner', $practitioner_id)
            ->delete();
    }

    public function getPractitionerByAppointmentId($appointment_id): array
    {
        return $this->db->table('appointment')
            ->join('practitioner', 'appointment.id_practitioner = practitioner.id_practitioner')
            ->where('appointment.id_appointment', $appointment_id)
            ->select('practitioner.*')
            ->get()
            ->getResultArray();
    }
}

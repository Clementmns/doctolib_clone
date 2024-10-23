<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientsModel extends Model
{
    protected $table = 'patient';
    protected $allowedFields = [
        'last_name',
        'first_name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'address'
    ];

    public function getPatients($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        $results = $this->orderBy('last_name', 'ASC')
            ->limit($perPage, $offset)
            ->find();

        return $results;
    }
}

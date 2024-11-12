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

    public function getPatients($page = 1, $perPage = 10, $search = null)
    {
        $offset = ($page - 1) * $perPage;

        // Requête de base pour récupérer les patients
        $builder = $this->orderBy('last_name', 'ASC');

        // Ajouter une condition de recherche si un terme est fourni
        if ($search) {
            $builder->groupStart()
                ->like('last_name', $search)
                ->orLike('first_name', $search)
                ->groupEnd();
        }

        // Appliquer la limite et l'offset pour la pagination
        return $builder->limit($perPage, $offset)->find();
    }

    public function countPatients($search = null)
    {
        $builder = $this;

        if ($search) {
            $builder->groupStart()
                ->like('last_name', $search)
                ->orLike('first_name', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}

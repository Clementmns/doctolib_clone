<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecialitiesModel extends Model
{
    protected $table = 'speciality';
    protected $primaryKey = 'id_speciality';
    protected $allowedFields = ['description'];

    public function getSpecialities($perPage = 10): ?array
    {
        return $this->orderBy('description', 'ASC')
            ->paginate($perPage);
    }
}

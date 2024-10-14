<?php

namespace App\Models;

use CodeIgniter\Model;

class PractitionersModel extends Model
{
    protected $table = 'practitioner';
    protected $allowedFields = ['last_name', 'first_name', 'availability'];

    public function getPractitioner($page = 1, $perPage = 10): object|array|null
    {
        $offset = ($page - 1) * $perPage;

        return $this->orderBy('last_name', 'ASC')
            ->limit($perPage, $offset)
            ->find();
    }
}

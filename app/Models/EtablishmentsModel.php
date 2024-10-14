<?php

namespace App\Models;

use CodeIgniter\Model;

class EtablishmentsModel extends Model
{
    protected $table = 'etablishment'; // Le nom de ta table d'établissements

    public function getEtablishments($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        $results = $this->orderBy('name', 'ASC') // Tri par nom d'établissement
                        ->limit($perPage, $offset)
                        ->find();

        return $results;
    }
}

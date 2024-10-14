<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecialitiesModel extends Model
{
    protected $table = 'speciality';
    protected $allowedFields = ['description']; // Spécifie les champs que tu veux manipuler

    public function getSpecialites($perPage = 10)
    {
        // On ordonne par description et on pagine les résultats
        return $this->orderBy('description', 'ASC')
            ->paginate($perPage);
    }
}

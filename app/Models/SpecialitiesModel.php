<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecialityModel extends Model
{
    protected $table      = 'speciality';      // Nom de la table
    protected $primaryKey = 'id_speciality';   // Clé primaire

    protected $allowedFields = ['description']; // Champs autorisés à être insérés

    protected $returnType     = 'array';
    protected $useTimestamps  = true;          // Si vous voulez utiliser les timestamps
    protected $createdField   = 'created_at';  // Le champ pour la date de création
    protected $updatedField   = 'updated_at';  // Le champ pour la date de mise à jour
}

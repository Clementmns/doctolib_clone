<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecialityModel extends Model
{
    protected $table = 'speciality';
    protected $primaryKey = 'id_speciality';
    protected $allowedFields = ['description'];

    protected $returnType     = 'array';
    protected $useTimestamps  = true;          // Si vous voulez utiliser les timestamps
    protected $createdField   = 'created_at';  // Le champ pour la date de création
    protected $updatedField   = 'updated_at';  // Le champ pour la date de mise à jour

    public function getSpecialitiesByEstablishmentId($establishment_id): array
    {
        //there is pra_spe table for the relationship between practitioner and speciality
        //there is pra_etab table for the relationship between practitioner and establishment
        //there isn't any table for the relationship between speciality and establishment
        // make a join between pra_spe and pra_etab and specialities to get the specialities of a practitioner in a specific establishment
        return $this->db->table('pra_spe')
            ->join('pra_etab', 'pra_spe.id_practitioner = pra_etab.id_practitioner')
            ->join('speciality', 'pra_spe.id_speciality = speciality.id_speciality')
            ->where('pra_etab.id_etablishment', $establishment_id)
            ->select('speciality.*')
            ->get()
            ->getResultArray();
    }
}

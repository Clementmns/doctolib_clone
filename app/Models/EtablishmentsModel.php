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

    public function addEstablishmentToPractitioner($practitioner_id, $establishment_id): bool
    {
        $data = [
            'id_practitioner' => $practitioner_id,
            'id_etablishment' => $establishment_id,
        ];

        return $this->db->table('pra_etab')->insert($data);
    }

    public function deleteEstablishmentToPractitioner($practitioner_id): bool
    {
        return $this->db->table('pra_etab')
            ->where('id_practitioner', $practitioner_id)
            ->delete();
    }

    public function getEstablishmentsByPractitionerId($practitioner_id): array
    {
        return $this->db->table('pra_etab')
            ->join('etablishment', 'pra_etab.id_etablishment = etablishment.id_etablishment')
            ->where('pra_etab.id_practitioner', $practitioner_id)
            ->select('etablishment.*')
            ->get()
            ->getResultArray();
    }
}

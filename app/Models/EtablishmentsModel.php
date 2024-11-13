<?php

namespace App\Models;

use CodeIgniter\Model;

class EtablishmentsModel extends Model {
    protected $table = 'etablishment'; // Le nom de la table d'établissements
    protected $primaryKey = 'id_etablishment'; // Clé primaire
    protected $allowedFields = ['location', 'name', 'open_hour']; // Champs autorisés pour l'insertion

    // Méthode pour récupérer les établissements paginés
    public function getEtablishments($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        return $this->orderBy('name', 'ASC') // Tri par nom d'établissement
                    ->limit($perPage, $offset)
                    ->find();
    }

    public function getEtablishmentById($id) {
        return $this->where('id_etablishment', $id)->first();
    }

    public function addEstablishmentToPractitioner($practitioner_id, $establishment_id): bool
    {
        $data = [
            'id_practitioner' => $practitioner_id,
            'id_etablishment' => $establishment_id,
        ];

        return $this->db->table('pra_etab')->insert($data);
    }

    public function deleteEstablishmentToPractitioner($practitioner_id): bool {
        return $this->db->table('pra_etab')
            ->where('id_practitioner', $practitioner_id)
            ->delete();
    }

    public function getEstablishmentByPractitionerId($practitioner_id): array
    {
        return $this->db->table('pra_etab')
            ->join('etablishment', 'pra_etab.id_etablishment = etablishment.id_etablishment')
            ->where('pra_etab.id_practitioner', $practitioner_id)
            ->select('etablishment.*')
            ->get()
            ->getResultArray();
    }

    public function getEstablishmentsBySpeciality($speciality_id): array
    {
        return $this->db->table('pra_spe')
            ->join('pra_etab', 'pra_spe.id_practitioner = pra_etab.id_practitioner')
            ->join('etablishment', 'pra_etab.id_etablishment = etablishment.id_etablishment')
            ->where('pra_spe.id_speciality', $speciality_id)
            ->select('etablishment.*')
            ->get()
            ->getResultArray();
    }

}

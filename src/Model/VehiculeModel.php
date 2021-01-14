<?php

// Espace de nom
namespace App\Model;

// Import des classes auxquels on fait référence
use App\Core\AbstractModel;

class VehiculeModel extends AbstractModel
{
    public function addVehicule(string $marque, string $model, string $couleur, string $immatriculation)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO vehicule (marque, modele, couleur, immatriculation)
                VALUES (?, ?, ?, ?)';

        $this->database->prepareAndExecuteQuery($sql, [$marque, $model, $couleur, $immatriculation]);
    }

    public function getAllVehicules()
    {
        // Requête d'insertion SQL
        $sql = 'SELECT *
                FROM vehicule';

        return $this->database->selectAll($sql);
    }

    public function getVehiculeById(int $id)
    {
        // Requête d'insertion SQL
        $sql = 'SELECT *
                FROM vehicule
                WHERE id_vehicule = ?';

        return $this->database->selectOne($sql, [$id]);
    }

    public function updateVehicule(string $marque, string $model, string $couleur, string $immatriculation, int $vehiculeId)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE vehicule
                SET marque = ?, modele = ?, couleur = ?, immatriculation = ?
                WHERE id_vehicule = ?';

        $this->database->prepareAndExecuteQuery($sql, [$marque, $model, $couleur, $immatriculation, $vehiculeId]);
    }

    public function deleteVehicule(int $vehiculeId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM vehicule
                WHERE id_vehicule = ?';

        $this->database->prepareAndExecuteQuery($sql, [$vehiculeId]);
    }

    public function numberVehicule()
    {
        $sql = 'SELECT COUNT(*) FROM vehicule';

        return $this->database->selectAll($sql);
    }
}
<?php

// Espace de nom
namespace App\Model;

// Import des classes auxquels on fait référence
use App\Core\AbstractModel;

class AssociationModel extends AbstractModel
{
    public function addAssociation(int $vehiculeId, int $conducteurId)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO association_vehicule_conducteur (id_vehicule, id_conducteur)
                VALUES (?, ?)';

        $this->database->prepareAndExecuteQuery($sql, [$vehiculeId, $conducteurId]);
    }

    public function getAllAssociations()
    {
        // Requête d'insertion SQL
        $sql = 'SELECT *
                FROM association_vehicule_conducteur
                JOIN vehicule
                ON association_vehicule_conducteur.id_vehicule = vehicule.id_vehicule
                JOIN conducteur
                ON association_vehicule_conducteur.id_conducteur = conducteur.id_conducteur';

        return $this->database->selectAll($sql);
    }

    public function getAssociationById(int $id)
    {
        // Requête d'insertion SQL
        $sql = 'SELECT *
                FROM association_vehicule_conducteur
                WHERE id_association = ?';

        return $this->database->selectOne($sql, [$id]);
    }

    public function updateAssociation(int $vehiculeId, int $conducteurId, int $associationId)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE association_vehicule_conducteur
                SET id_vehicule = ?, id_conducteur = ?
                WHERE id_association = ?';

        $this->database->prepareAndExecuteQuery($sql, [$vehiculeId, $conducteurId, $associationId]);
    }

    public function deleteAssociation(int $associationId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM association_vehicule_conducteur
                WHERE id_association = ?';

        $this->database->prepareAndExecuteQuery($sql, [$associationId]);
    }
}
<?php

// Espace de nom
namespace App\Model;

// Import des classes auxquels on fait référence
use App\Core\AbstractModel;

class ConducteurModel extends AbstractModel
{
    public function addConducteur(string $lastname, string $firstname)
    {
        // Requête d'insertion SQL
        $sql = 'INSERT INTO conducteur (prenom, nom)
                VALUES (?, ?)';

        $this->database->prepareAndExecuteQuery($sql, [$firstname, $lastname]);
    }

    public function getAllConducteurs()
    {
        // Requête d'insertion SQL
        $sql = 'SELECT *
                FROM conducteur';

        return $this->database->selectAll($sql);
    }

    public function getConducteurById(int $id)
    {
        // Requête d'insertion SQL
        $sql = 'SELECT *
                FROM conducteur
                WHERE id_conducteur = ?';

        return $this->database->selectOne($sql, [$id]);
    }

    public function updateConducteur(string $lastname, string $firstname, int $conducteurId)
    {
        // Requête de mise à jour SQL
        $sql = 'UPDATE conducteur
                SET prenom = ?, nom = ?
                WHERE id_conducteur = ?';

        $this->database->prepareAndExecuteQuery($sql, [$firstname, $lastname, $conducteurId]);
    }

    public function deleteConducteur(int $conducteurId)
    {
        // Requête de suppression SQL
        $sql = 'DELETE FROM conducteur
                WHERE id_conducteur = ?';

        $this->database->prepareAndExecuteQuery($sql, [$conducteurId]);
    }
}
<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\AssociationModel;
use App\Model\ConducteurModel;
use App\Model\VehiculeModel;
use App\Service\Flashbag;

class AssociationController extends AbstractController
{
    public function index()
    {
        $associations = (new AssociationModel($this->database))->getAllAssociations();
        $vehicules = (new VehiculeModel($this->database))->getAllVehicules();
        $conducteurs = (new ConducteurModel($this->database))->getAllConducteurs();

        // Inclusion du fichier de template et ses variables
        render('association', [
            'pageTitle' => 'Association Administration',
            'associations' => $associations,
            'formAction' => "/association/add",
            'vehicules' => $vehicules,
            'conducteurs' => $conducteurs
        ]);
    }

    public function addAssociation()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Si le formulaire a correctement été soumis
        if(!empty($_POST)) {

            // Récupération des données du formulaire
            $vehiculeId = intval($_POST['id-vehicule']);
            $conducteurId = intval($_POST['id-conducteur']);

            // Ajout du commentaire et ses informations dans la BDD
            (new AssociationModel($this->database))->addAssociation($vehiculeId, $conducteurId);

            // Création d'un message flash
            $flashModel->addFlashMessage("L'association a bien été ajouté.");

            // Redirection vers la page du produit
            header('Location: /association');
        }
    }

    public function editAssociation()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo 'Error : no association id parameter';
            exit;
        }

        // Récupération de l'id du produit dans l'url
        $associationId = intval($_GET['id']);

        $associations = (new AssociationModel($this->database))->getAllAssociations();
        $associationDetails = (new AssociationModel($this->database))->getAssociationById($associationId);
        $vehicules = (new VehiculeModel($this->database))->getAllVehicules();
        $conducteurs = (new ConducteurModel($this->database))->getAllConducteurs();

        // Si le formulaire est soumis
        if (!empty($_POST)) {

            // Récupération des données du formulaire
            $vehiculeId = intval($_POST['id-vehicule']);
            $conducteurId = intval($_POST['id-conducteur']);

            // Ajout du commentaire et ses informations dans la BDD
            (new AssociationModel($this->database))->updateAssociation($vehiculeId, $conducteurId, $associationId);

            // Création d'un message flash
            $flashModel->addFlashMessage("L'association a bien été mis à jour.");

            // Redirection vers la page du produit
            header('Location: /association');
            exit;
        }

        $formAction = '/association/edit?id=' . $associationId;

        // Inclusion du fichier de template et ses variables
        render('association', [
            'pageTitle' => 'Association Administration',
            'associations' => $associations,
            'associationDetails' => $associationDetails,
            'formAction' => $formAction,
            'vehicules' => $vehicules,
            'conducteurs' => $conducteurs
        ]);
    }

    public function deleteAssociation()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo 'Error : no association id parameter';
            exit;
        }

        // Récupération de l'id du produit dans l'url
        $associationId = intval($_GET['id']);

        (new AssociationModel($this->database))->deleteAssociation($associationId);

        // Création d'un message flash
        $flashModel->addFlashMessage("L'association a bien été supprimé.");

        // Redirection vers la page du produit
        header('Location: /association');
        exit;

    }
}
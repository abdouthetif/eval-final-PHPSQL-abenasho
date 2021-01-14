<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\VehiculeModel;
use App\Service\Flashbag;

class VehiculeController extends AbstractController
{
    public function index()
    {
        $vehicules = (new VehiculeModel($this->database))->getAllVehicules();

        // Inclusion du fichier de template et ses variables
        render('vehicule', [
            'pageTitle' => 'Vehicule Administration',
            'vehicules' => $vehicules,
            'formAction' => "/vehicule/add"
        ]);
    }

    public function addVehicule()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Si le formulaire a correctement été soumis
        if(!empty($_POST)) {

            // Récupération des données du formulaire
            $marque = strip_tags($_POST['brand']);
            $model = strip_tags($_POST['model']);
            $couleur = strip_tags($_POST['color']);
            $immatriculation = strip_tags($_POST['matriculation']);

            // Vérification du formulaire de commentaire
            $errors = validateVehiculeForm($marque, $model, $couleur, $immatriculation);

            // Si il n'y a pas d'erreur, ajout du commentaire
            if (empty($errors)) {

                // Ajout du commentaire et ses informations dans la BDD
                (new VehiculeModel($this->database))->addVehicule($marque, $model, $couleur, $immatriculation);

                // Création d'un message flash
                $flashModel->addFlashMessage('Le vehicule a bien été ajouté.');
            }
            else {

                // Ajoute les erreurs dans un message flash
                foreach ($errors as $error) {
                    $flashModel->addFlashMessage($error);
                }
            }

            // Redirection vers la page du produit
            header('Location: /vehicule');
        }
    }

    public function editVehicule()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo 'Error : no vehicule id parameter';
            exit;
        }

        // Récupération de l'id du produit dans l'url
        $vehiculeId = intval($_GET['id']);

        $vehicules = (new VehiculeModel($this->database))->getAllVehicules();
        $vehiculeDetails = (new VehiculeModel($this->database))->getVehiculeById($vehiculeId);

        // Si le formulaire est soumis
        if (!empty($_POST)) {

            $marque = strip_tags($_POST['brand']);
            $model = strip_tags($_POST['model']);
            $couleur = strip_tags($_POST['color']);
            $immatriculation = strip_tags($_POST['matriculation']);

            // Vérification du formulaire de commentaire
            $errors = validateVehiculeForm($marque, $model, $couleur, $immatriculation);

            // Si il n'y a pas d'erreur, ajout du commentaire
            if (empty($errors)) {

                // Ajout du commentaire et ses informations dans la BDD
                (new VehiculeModel($this->database))->updateVehicule($marque, $model, $couleur, $immatriculation, $vehiculeId);

                // Création d'un message flash
                $flashModel->addFlashMessage('Le vehicule a bien été mis à jour.');

                // Redirection vers la page du produit
                header('Location: /vehicule');
                exit;
            }
            else {

                // Ajoute les erreurs dans un message flash
                foreach ($errors as $error) {
                    $flashModel->addFlashMessage($error);
                }

                // Redirection vers la page du produit
                header('Location: /vehicule/edit?id='. $vehiculeId);
                exit;
            }
        }

        $formAction = '/vehicule/edit?id=' . $vehiculeId;

        // Inclusion du fichier de template et ses variables
        render('vehicule', [
            'pageTitle' => 'Vehicule Administration',
            'vehicules' => $vehicules,
            'vehiculeDetails' => $vehiculeDetails,
            'formAction' => $formAction
        ]);
    }

    public function deleteVehicule()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo 'Error : no vehicule id parameter';
            exit;
        }

        // Récupération de l'id du produit dans l'url
        $vehiculeId = intval($_GET['id']);

        (new VehiculeModel($this->database))->deleteVehicule($vehiculeId);

        // Création d'un message flash
        $flashModel->addFlashMessage('Le vehicule a bien été supprimé.');

        // Redirection vers la page du produit
        header('Location: /vehicule');
        exit;

    }
}
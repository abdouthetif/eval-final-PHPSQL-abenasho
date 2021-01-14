<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\ConducteurModel;
use App\Service\Flashbag;

class ConducteurController extends AbstractController
{
    public function index()
    {
        $conducteurs = (new ConducteurModel($this->database))->getAllConducteurs();

        // Inclusion du fichier de template et ses variables
        render('conducteur', [
            'pageTitle' => 'Conducteur Administration',
            'conducteurs' => $conducteurs,
            'formAction' => "/conducteur/add"
        ]);
    }

    public function addConducteur()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Si le formulaire a correctement été soumis
        if(!empty($_POST)) {

            // TODO: add strip_tags on forms
            // Récupération des données du formulaire
            $lastname = strip_tags($_POST['lastname']);
            $firstname = strip_tags($_POST['firstname']);

            // Vérification du formulaire de commentaire
            $errors = validateConducteurForm($lastname, $firstname);

            // Si il n'y a pas d'erreur, ajout du commentaire
            if (empty($errors)) {

                // Ajout du commentaire et ses informations dans la BDD
                (new ConducteurModel($this->database))->addConducteur($lastname, $firstname);

                // Création d'un message flash
                $flashModel->addFlashMessage('Le conducteur a bien été ajouté.');
            }
            else {

                // Ajoute les erreurs dans un message flash
                foreach ($errors as $error) {
                    $flashModel->addFlashMessage($error);
                }
            }

            // Redirection vers la page du produit
            header('Location: /conducteur');
        }
    }

    public function editConducteur()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo 'Error : no conducteur id parameter';
            exit;
        }

        // Récupération de l'id du produit dans l'url
        $conducteurId = intval($_GET['id']);

        $conducteurs = (new ConducteurModel($this->database))->getAllConducteurs();
        $conducteurDetails = (new ConducteurModel($this->database))->getConducteurById($conducteurId);

        // Si le formulaire est soumis
        if (!empty($_POST)) {

            $lastname = strip_tags($_POST['lastname']);
            $firstname = strip_tags($_POST['firstname']);

            // Vérification du formulaire de commentaire
            $errors = validateConducteurForm($lastname, $firstname);

            // Si il n'y a pas d'erreur, ajout du commentaire
            if (empty($errors)) {

                // Ajout du commentaire et ses informations dans la BDD
                (new ConducteurModel($this->database))->updateConducteur($lastname, $firstname, $conducteurId);

                // Création d'un message flash
                $flashModel->addFlashMessage('Le conducteur a bien été mis à jour.');

                // Redirection vers la page du produit
                header('Location: /conducteur');
                exit;
            }
            else {

                // Ajoute les erreurs dans un message flash
                foreach ($errors as $error) {
                    $flashModel->addFlashMessage($error);
                }

                // Redirection vers la page du produit
                header('Location: /conducteur/edit?id='. $conducteurId);
                exit;
            }
        }

        $formAction = '/conducteur/edit?id=' . $conducteurId;

        // Inclusion du fichier de template et ses variables
        render('conducteur', [
            'pageTitle' => 'Conducteur Administration',
            'conducteurs' => $conducteurs,
            'conducteurDetails' => $conducteurDetails,
            'formAction' => $formAction
        ]);
    }

    public function deleteConducteur()
    {
        // Initialise l'objet Flashbag
        $flashModel = new Flashbag();

        // Récupération de l'id du produit à modifier dans la chaîne de requête de l'URL
        if (!array_key_exists('id', $_GET) || !isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo 'Error : no conducteur id parameter';
            exit;
        }

        // Récupération de l'id du produit dans l'url
        $conducteurId = intval($_GET['id']);

        (new ConducteurModel($this->database))->deleteConducteur($conducteurId);

        // Création d'un message flash
        $flashModel->addFlashMessage('Le conducteur a bien été supprimé.');

        // Redirection vers la page du produit
        header('Location: /conducteur');
        exit;

    }
}
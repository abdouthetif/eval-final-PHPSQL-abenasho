<?php

// Inclusion du fichier de configuration
require '../config.php';

/* Inclut le template de base et ses variables */
function render(string $template, array $values = [], string $baseTemplate = 'base')
{
    // Extraction des variables
    extract($values);

    // Affichage des messages flash
    $flashModel = new \App\Service\Flashbag();
    $flashMessages = $flashModel->fetchAllFlashMessages();

    /* Inclusion du template de base */
    include '../templates/'.$baseTemplate.'.phtml';
}

function validateFirstname(string $firstname)
{
    $errors = "";

    // Vérifie si le champ est vide
    if (!isset($firstname) || empty($firstname)) {
        $errors = 'Erreur: Le champ "Prénom" est obligatoire';
    }

    // Vérifie si le firstname est trop court
    else if (iconv_strlen($firstname) < 4) {
        $errors = 'Erreur: Le champ "Prénom" est trop court';
    }

    // Vérifie si le firstname est trop long
    else if (iconv_strlen($firstname) > 15) {
        $errors = 'Erreur: Le champ "Prénom" est trop long';
    }

    return $errors;
}

function validateLastname(string $lastname)
{
    $errors = "";

    // Vérifie si le champ est vide
    if (!isset($lastname) || empty($lastname)) {
        $errors = 'Erreur: Le champ "Nom" est obligatoire';
    }

    // Vérifie si le firstname est trop court
    else if (iconv_strlen($lastname) < 4) {
        $errors = 'Erreur: Le champ "Nom" est trop court';
    }

    // Vérifie si le firstname est trop long
    else if (iconv_strlen($lastname) > 15) {
        $errors = 'Erreur: Le champ "Nom" est trop long';
    }

    return $errors;
}

function validateConducteurForm(string $lastname, string $firstname)
{
    $errors = [];

    // Stock les messages d'erreurs dans un tableau
    if (!empty(validateFirstname($firstname))) {

        $errors[] = validateFirstname($firstname);
    }
    else if (!empty(validateLastname($lastname))) {

        $errors[] = validateLastname($lastname);
    }

    return $errors;
}
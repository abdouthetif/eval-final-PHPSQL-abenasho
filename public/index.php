<?php

/**
 * L'index.php est maintenant la porte d'entrée unique pour toutes les pages du site
 */

// Inclusion des dépendances
require '../vendor/autoload.php'; // autoloader de composer
require '../src/functions.php';

use App\Core\PDOFactory;
use App\Core\Database;

$path = $_SERVER['PATH_INFO'] ?? '/';

// Routing
$routes = [
    '/' => [
        'class' => 'App\\Controller\\HomeController',
        'method' => 'index'
    ],
    '/conducteur' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'index'
    ],
    '/vehicule' => [
        'class' => 'App\\Controller\\VehiculeController',
        'method' => 'index'
    ],
    '/association' => [
        'class' => 'App\\Controller\\AssociationController',
        'method' => 'index'
    ],
    '/affichage-divers' => [
        'class' => 'App\\Controller\\AffichageDiversController',
        'method' => 'index'
    ],
    '/conducteur/add' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'addConducteur'
    ],
    '/conducteur/edit' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'editConducteur'
    ],
    '/conducteur/delete' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'deleteConducteur'
    ]
];

// Si le path existe dans le tableau de routes...
if (array_key_exists($path, $routes)) {

    $pdo = PDOFactory::get();

    $database = new Database($pdo);

    // Instanciation de la classe de contrôleur
    $controller = new $routes[$path]['class']($database);

    // Récupération de la méthode associée à l'action
    $method = $routes[$path]['method'];

    // Exécution de cette méthode sur l'objet contrôleur
    call_user_func([$controller, $method]);
}
else {

    // Sinon on fait une erreur 404
    http_response_code(404);

    render('404', [
        'pageTitle' => 'Erreur 404 : page non trouvée'
    ]);
}
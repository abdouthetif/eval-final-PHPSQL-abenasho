<?php

namespace App\Controller;

use App\Core\AbstractController;

class HomeController extends AbstractController
{

    public function index()
    {
        // Inclusion du fichier de template et ses variables
        render('home', [
            'pageTitle' => 'Dashboard Admin'
        ]);
    }
}

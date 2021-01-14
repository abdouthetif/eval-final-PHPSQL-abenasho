<?php

namespace App\Core;

use App\Service\Flashbag;

abstract class AbstractModel
{
    // Propriétés
    protected $database;

    // Constructeur
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}
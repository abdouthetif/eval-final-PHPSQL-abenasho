<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\AssociationModel;
use App\Model\ConducteurModel;
use App\Model\VehiculeModel;

class AffichageDiversController extends AbstractController
{
    public function index()
    {
        $nbConducteur = (new ConducteurModel($this->database))->numberConducteur();
        $nbVehicule = (new VehiculeModel($this->database))->numberVehicule();
        $nbAssociation = (new AssociationModel($this->database))->numberAssociation();
        $vehiculeNoConducteurs = (new AssociationModel($this->database))->vehiculeNoConducteur();
        $conducteurNoVehicules = (new AssociationModel($this->database))->conducteurNoVehicule();

        //dump($vehiculeNoConducteurs);

        // Inclusion du fichier de template et ses variables
        render('affichagedivers', [
            'pageTitle' => 'Affichage divers',
            'nbConducteur' => $nbConducteur,
            'nbVehicule' => $nbVehicule,
            'nbAssociation' => $nbAssociation,
            'vehiculeNoConducteurs' => $vehiculeNoConducteurs,
            'conducteurNoVehicules' => $conducteurNoVehicules
        ]);
    }
}
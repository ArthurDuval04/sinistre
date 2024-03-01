<?php 

class Donateur {

    private $idDonnateur,$nom,$prenom,$adresse,$numTel,$typeDonateur,$nomOrganisme;

    public function __construct()
    {
        
    }
    public function idDonnateur()
    {
        return $this->idDonnateur;
    }
    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom() { 
        return $this->prenom;
    }

    public function getAdresse() { 
        return $this->adresse;
    }
    public function getNumTel() {
        return $this->numTel;
    }
    public function getTypeDonnateur() {
        return $this->typeDonateur;
    }
    public function getNomOrganisme() {
        return $this->nomOrganisme;
    }
 

}

?>
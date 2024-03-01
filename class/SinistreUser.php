<?php 
class SinistreUser {

    public $idPers, $nom, $prenom, $adresse,$numTel,$statutRelogement, $adresseRelogement, $numSinistre, $numDonnateur;

    public function __construct()
    {
        
    }
    public function getId() {
        return $this->idPers;
    }
    public function getNom() {
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
    public function getStatutRelogement() {
        return $this->statutRelogement;
    }
    public function getAdresseRelogement() {
        return $this->adresseRelogement;
    }
    public function getSinistreId() {
        return $this->numSinistre;
    }
    public function getDonateurId() {
        return $this->numDonnateur;
    }

}
?>
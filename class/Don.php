<?php 

class Don {

    private $id,$idDonateur,$montantDons,$dateDon,$typeDon,$idPersonne;

    public function __construct()
    {
        
    }

    public function getId() {
        return $this->id;
    }
    public function getIdDonnateur() {
        return $this->idDonateur;
    }
    public function getMontantDons() {
        return $this->montantDons;
    }
    public function getDateDon() { 
        return $this->dateDon;
    }
    public function getTypeDon() {
        return $this->typeDon;
    }
    public function getIdPersonne() {
        return $this->idPersonne;
    }

    public function setIdDonnateur($id) {
        $this->idDonateur = $id;
    }
    
    


}


?>
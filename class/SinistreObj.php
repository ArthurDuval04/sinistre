<?php 

class SinistreObj {
    private $numSinistre;
    private $dateDebut;

    private $dateFin;
    private $totalSin;

    public function __construct() {
        
    }

    public function getIdSin() {
        return $this->numSinistre;
    }
    public function getSinistreDebut() {
        return $this->dateDebut;
    }

    public function getSinistreFin() {
        return $this->dateFin;
    }

    public function getTotalSinistres() { 
        return $this->totalSin;
    }

    private function setSinistreDebut($dateDebut) {
        $this->dateDebut = $dateDebut;
    }

    private function setDateFin($dateFin) {
        $this->dateFin = $dateFin;
    }




}
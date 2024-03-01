<?php 

class User {
    public $id;
    public $nom;
    public $prenom;
    public $mail;
    public $idRole;

    public function __construct() {
        
    }

    // Accesseur 
    public function getUserId() {
        return $this->id;
    }
    public function getNomUser() {
        return $this->nom;
    }
    public function getPrenomUser() {
        return $this->prenom;
    }
    public function getMailUser() {
        return $this->mail;
    }
    public function getRole() {
        return $this->idRole;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
    public function setMail($mail) {
        $this->mail = $mail;
    }
    public function setRole($role) {
        $this->idRole = $role;
    }
}


?>
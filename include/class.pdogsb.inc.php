<?php
include './class/User.php';
/** 
 * 
 * Classe d'accÃ¨s aux donnÃ©es. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=sinistre';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
	public static $monPdo;
	private static $monPdoGsb=null;
		
/**
 * Constructeur privÃ©, crÃ©e l'instance de PDO qui sera sollicitÃ©e
 * pour toutes les mÃ©thodes de la classe
 */				
	private function __construct(){
          
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crÃ©e l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * vÃ©rifie si le login et le mot de passe sont corrects
 * renvoie true si les 2 sont corrects
 * @param type $lePDO
 * @param type $login
 * @param string $pwd
 * @return bool
 * @throws Exception
//  */
function checkUser($login,$pwd):bool {
   
    $user=false;
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("SELECT password FROM users WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){
           if (password_verify($pwd, $unUser['password']))
            	$user=true;
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $user;   
}
function getAllSinistreData() {
   
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("SELECT numSinistre,dateDebut,dateFin,totalSin FROM sinistre_data");
    $monObjPdoStatement->execute();
    $lesS=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "SinistreObj");
        

    
return $lesS;   
}
function getUnSinistreById($id) {
    $pdoStatement = PdoGsb::$monPdo->prepare("SELECT numSinistre,dateDebut,dateFin,totalSin FROM sinistre_data WHERE numSinistre = :id");
    
    $pdoStatement->bindValue(':id', $id);
  
   
    $pdoStatement->execute();
    $lesS=$pdoStatement->fetchAll(PDO::FETCH_CLASS, "SinistreObj");

    
    return $lesS;

}
function deleteUnSinistre($id) {
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM personne WHERE idPers = :id");
    
    $pdoStatement->bindValue(':id', $id);
  
    try {
        $pdoStatement->execute();
        $execution = true;
    } catch (Exception $e) {
        $execution = $e->getMessage();
    }
   

    
    return $execution; 
}
function deleteSinistre($id) {
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM sinistre_data WHERE numSinistre = :id");
    
    $pdoStatement->bindValue(':id', $id);
  
    try {
        $pdoStatement->execute();
        $execution = true;
    } catch (Exception $e) {
        $execution = $e->getMessage();
    }
   

    
    return $execution;

}

function getAllVictimeData() {
   
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("SELECT idPers,nom,prenom,adresse,numTel,statutRelogement,adresseRelogement,numSinistre,numDonnateur FROM personne");
    $monObjPdoStatement->execute();
    $lesS=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "SinistreUser");
    
    
    return $lesS; 
}

function getAllVictimeSansDons() {
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("SELECT idPers,nom,prenom,adresse,numTel,statutRelogement,adresseRelogement,numSinistre,numDonnateur FROM personne WHERE numDonnateur IS NULL");
    $monObjPdoStatement->execute();
    $lesS=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "SinistreUser");
    
    
    return $lesS; 
}
function getUneVictimeData($id) {
   
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("SELECT idPers,nom,prenom,adresse,numTel,statutRelogement,adresseRelogement,numSinistre,numDonnateur FROM personne WHERE idPers=:id");
    $monObjPdoStatement->bindValue(':id',$id);
    $monObjPdoStatement->execute();
    $lesS=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "SinistreUser");
    
    
    return $lesS ; 
}

function CreateDonateur($nom, $prenom, $adresse, $numtel, $typeCat, $nomOrg) {
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO donateurs (nom, prenom, adresse, numTel, typeDonateur, nomOrganisme) VALUES (:nom, :prenom, :adresse, :numtel, :typeCat, :nomOrg)");
    $pdoStatement->bindValue(':nom', $nom);
    $pdoStatement->bindValue(':prenom', $prenom);
    $pdoStatement->bindValue(':adresse', $adresse);
    $pdoStatement->bindValue(':numtel', $numtel);
    $pdoStatement->bindValue(':typeCat', $typeCat);
    $pdoStatement->bindValue(':nomOrg', $nomOrg);
    $execution = $pdoStatement->execute();
    return $execution;
}

function getUnDonateurById($id) {
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT idDonnateur,nom,prenom,adresse,numTel,typeDonateur,nomOrganisme FROM donateurs WHERE idDonnateur = :idDon");
    $monObjPdoStatement->bindValue(':idDon',$id);
    $monObjPdoStatement->execute();
    $lesS=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "Donateur");
    if (!empty($lesS)) {
        return $lesS[0];
    } else {
        return null;
    }
}
function getAllDonateur() {
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT idDonnateur,nom,prenom,adresse,numTel,typeDonateur,nomOrganisme FROM donateurs");
    $monObjPdoStatement->execute();
    $lesS=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "Donateur");
    if ($lesS !== false && !empty($lesS)) { // Vérifier si $lesS n'est pas false et n'est pas vide
        return $lesS;
    } else {
        return []; // Retourner un tableau vide si aucune donnée n'est trouvée
    }
        
}
function deleteDonnateur($id) {
    
    
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM donateurs WHERE idDonnateur =  :id");

    
    $pdoStatement->bindValue(':id', $id);
    try {
        $pdoStatement->execute();
        $execution = true;
    } catch (Exception $e) {
        $execution = $e->getMessage();
    }

    return $execution;
    

}
function CreateUser($unU, $password) {
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO users (nom,prenom,mail,password,idRole) VALUES(:nom ,:prenom,:mail,:password,:idRole)");
    $pdoStatement->bindValue(':nom', $unU->getNomUser());
    $pdoStatement->bindValue(':prenom', $unU->getPrenomUser());
    $pdoStatement->bindValue(':mail', $unU->getMailUser());
    $pdoStatement->bindValue(':password', $password);
    $pdoStatement->bindValue(':idRole', $unU->getRole());

    $execution = $pdoStatement->execute();
    return $execution;

}

function donneUserByMail($mail) {
    $pdo = PdoGsb::$monPdo;
    $objpdo = $pdo->prepare("SELECT id, nom, prenom, mail, idRole FROM users WHERE mail = :mail");
    $objpdo->bindValue(':mail',$mail);
    $objpdo->execute();
    $unUser = $objpdo->fetchAll(PDO::FETCH_CLASS, "User");

    return $unUser[0];
}
function donneUserByID($id) {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail,idRole FROM users WHERE id= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$id);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "User");
       
    }
    else
        throw new Exception("erreur dans la requête");
    return $unUser[0];   
}
function donneAllUser() {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail,idRole FROM users ");
    if ($monObjPdoStatement->execute()) {
        $allUser=$monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, "User");
       
    }
    else
        throw new Exception("erreur dans la requÃªte");
    return $allUser;   
}

function modifSinistre($id, $nom, $prenom, $adresse, $numTel, $statutRelogement, $adresseRelogement, $numSinistre) {
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE personne SET nom = :nom, prenom = :prenom, adresse = :adresse, numTel = :numTel, statutRelogement = :statutRelogement, adresseRelogement = :adresseRelog, numSinistre = :numSin WHERE idPers = :id");
    
    $pdoStatement->bindValue(':id', $id);
    $pdoStatement->bindValue(':nom', $nom);
    $pdoStatement->bindValue(':prenom', $prenom);
    $pdoStatement->bindValue(':adresse', $adresse);
    $pdoStatement->bindValue(':numTel', $numTel);
    $pdoStatement->bindValue(':statutRelogement', $statutRelogement);
    $pdoStatement->bindValue(':adresseRelog', $adresseRelogement);
    $pdoStatement->bindValue(':numSin', $numSinistre);

    $execution = $pdoStatement->execute();
    return $execution;
}
function getLeTypeById($id) {
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT nomType FROM typedon WHERE idType= :id");
    $bvc1=$monObjPdoStatement->bindValue(':id',$id);
    if ($monObjPdoStatement->execute()) {
        $unType=$monObjPdoStatement->fetch();
       
    }
    else
        throw new Exception("erreur dans la requÃªte");
    return $unType[0];   
}
function getAllType() {
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT idType, nomType FROM typedon");
    if ($monObjPdoStatement->execute()) {
        $unType=$monObjPdoStatement->fetchAll();
       
    }
    else
        throw new Exception("erreur dans la requÃªte");
    return $unType;   
}

function creerDonateur($nom,$prenom,$adresse,$numtel,$type,$nomorg) {
    $pdo = PdoGsb::$monPdo;
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO donateur (nom,prenom,adresse, numTel, typeDonateur, nomOrganisme) VALUES(:nom ,:prenom,:adresse,:numTel,:typeDon,:nomOrg)");
    $pdoStatement->bindValue(':nom', $nom);
    $pdoStatement->bindValue(':prenom', $prenom);
    $pdoStatement->bindValue(':numTel', $adresse);
    $pdoStatement->bindValue(':numTel', $numtel);
    $pdoStatement->bindValue(':typeDon', $type);
    $pdoStatement->bindValue(':nomOrg', $nomorg);
    
    
}
/**
 * ajouterSinistre
 * Permet d'ajouter une personne sinistrée et du lui attribuer un sinistre déjà créer 
 * /!\ PENSER A CREER LE SINISTRE AVANT DE CREER LA PERSONNE POUR EVITER DE DEVOIR LA MODIFIER
 * /!\ PENSER A CREER AUSSI LE DONATEUR AVANT DE CREER LA PERSONNE (la valeur est nulable)
 * @param  string $nom
 * @param  string $prenom
 * @param  string $adresse
 * @param  int $numTel
 * @param  bool $statutRelogement
 * @param  string $adresseRelogement
 * @param  int $numSinistre
 * @return void
 */
function ajouterSinistre($nom, $prenom, $adresse, $numTel, $statutRelogement, $adresseRelogement, $numSinistre) {
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO personne (nom,prenom,adresse, numTel, statutRelogement, adresseRelogement , numSinistre) VALUES(:nom ,:prenom,:adresse,:numTel,:statutRelogement,:adresseRelog,:numSin)");
    

    $pdoStatement->bindValue(':nom', $nom);
    $pdoStatement->bindValue(':prenom', $prenom);
    $pdoStatement->bindValue(':adresse', $adresse);
    $pdoStatement->bindValue(':numTel', $numTel);
    $pdoStatement->bindValue(':statutRelogement', $statutRelogement);
    $pdoStatement->bindValue(':adresseRelog', $adresseRelogement);
    $pdoStatement->bindValue(':numSin', $numSinistre);

    $execution = $pdoStatement->execute();
    return $execution;
}
function addDon($idIdonateur,$dateAjout,$montant,$typeDon,$personne) {
    $pdo = PdoGsb::$monPdo;
    if ($personne == "none") {
        $objpdo = $pdo->prepare("INSERT INTO dons (idDonateur, montantDons, dateDon,typeDon) VALUES(:idDonateur,:montant,:dateDon,:typeDon)");
        $objpdo->bindValue(':idDonateur', $idIdonateur);
        $objpdo->bindValue(':montant', $montant);
        $objpdo->bindValue(':dateDon', $dateAjout);
        $objpdo->bindValue(":typeDon", $typeDon);
   
       

            
    } else {
        $objpdo = $pdo->prepare("INSERT INTO dons (idDonateur, montantDons, dateDon,typeDon,idPersonne) VALUES(:idDonateur,:montant,:dateDon,:typeDon,:person)");
        $objpdo->bindValue(':idDonateur', $idIdonateur);
        $objpdo->bindValue(':montant', $montant);
        $objpdo->bindValue(':dateDon', $dateAjout);
        $objpdo->bindValue(":typeDon", $typeDon);
        $objpdo->bindValue(':person', $personne);
   

    }

    $execution = $objpdo->execute();
    return $execution;

}

function getAllDons() {
    $pdo = PdoGsb::$monPdo;
    $objpdo = $pdo->prepare("SELECT id, idDonateur, montantDons, dateDon, typeDon, idPersonne FROM dons");
    $objpdo->execute();
    $lesDons = $objpdo->fetchAll(PDO::FETCH_CLASS, "Don");

    return $lesDons;

}
function modifDon($idSin,$idPers) {
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE dons SET idPersonne = :idPers WHERE id = :idSin");
    
    $pdoStatement->bindValue(':idSin', $idSin);
    $pdoStatement->bindValue(':idPers', $idPers);


    $execution = $pdoStatement->execute();
    return $execution;
}

function deleteDon($id) {
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM dons WHERE id = :id");
    
    $pdoStatement->bindValue(':id', $id);
  


    $execution = $pdoStatement->execute();
    return $execution;
}

function ajouterUnSinistre($dateDebut, $dateFin) {

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO sinistre_data(dateDebut,dateFin) 
    VALUES (:debut,:fin)");
    $bv1 = $pdoStatement->bindValue(':debut', $dateDebut);
    $bv2 = $pdoStatement->bindValue(':fin', $dateFin);
    
    $execution = $pdoStatement->execute();
    return $execution;

}

public function creeUser($email, $mdp, $nom, $prenom)
{

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO users(id, mail, password, nom, prenom) 
            VALUES (null, :leMail, :leMdp, :leNom, :lePrenom)");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $bv5 = $pdoStatement->bindValue(':leNom', $nom);
    $bv6 = $pdoStatement->bindValue(':lePrenom', $prenom);
    $execution = $pdoStatement->execute();
    return $execution;
    
}
// function ajouteConnexionInitiale($id){
//     $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
//             . "VALUES (:user, now(), null)");
//     $bv1 = $pdoStatement->bindValue(':user', $id);
//     $execution = $pdoStatement->execute();
//     return $execution;
    
// }
// function ajouteDeconnexionInitiale($id){
//     $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE historiqueconnexion SET dateFinLog = now() WHERE idUser = :user AND dateFinLog IS NULL ");
//     $bv1 = $pdoStatement->bindValue(':user', $id);
//     $execution = $pdoStatement->execute();
//     return $execution;
    
// }
function deleteUser($id) {
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM users WHERE id = :id");
    
    $pdoStatement->bindValue(':id', $id);
  


    $execution = $pdoStatement->execute();
    return $execution;

}

}

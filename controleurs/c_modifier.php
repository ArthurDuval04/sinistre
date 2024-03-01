<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeModif';
    
}
if(!isset($_SESSION['email'])){
    header('Location: index.php?uc=retour&action=valideRetour');
    
}
$action = $_GET['action'];

switch($action){
    
	case 'demandeModifSinistre':{
		include("vues/v_listeSinistres.php");
		break;
	}

    case 'validerAjoutSinistre' : {
        $debut = htmlspecialchars($_POST["date-add"]);
        $fin = htmlspecialchars($_POST["date2-add"]);
        if (isset($debut) && isset($fin)) {
            
            $pdo->ajouterUnSinistre($debut, $fin);
            include("vues/v_consulterSinistre.php");
        } else {
            include("vues/v_consulterSinistre.php");
        }
      
        break;
    }

    case 'validerModifSinistre':{
        $id = htmlspecialchars($_POST['idaa']);
        $nom = htmlspecialchars($_POST['name']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $tel = htmlspecialchars($_POST['tel']);
        $adresseRelog = htmlspecialchars($_POST['adresseRelog']);
        $category1 = htmlspecialchars($_POST['category1']);
        $category2 = htmlspecialchars($_POST['category2']);
    
		$pdo->modifSinistre($id,$nom,$prenom,$adresse,$tel,$category1,$adresseRelog, $category2); 
                            
		break;
	}

    case 'validerCreerSinistre' : {

        $nom = htmlspecialchars($_POST['name-add']);
        $prenom = htmlspecialchars($_POST['prenom-add']);
        $adresse = htmlspecialchars($_POST['adresse-add']);
        $tel = htmlspecialchars($_POST['tel-add']);
        $adresseRelog = htmlspecialchars($_POST['adresseRelog-add']);
        $category1 = htmlspecialchars($_POST['category1-add']);
        $category2 = htmlspecialchars($_POST['category-add2']);




        if ($pdo->ajouterSinistre($nom,$prenom,$adresse,$tel,$category1,$adresseRelog, $category2)) {
            include('./vues/v_listeSinistres.php');
            echo"<script language=\"javascript\"> alert('Crée avec succès') </script>";		
        } else {
            include('./vues/v_listeSinistres.php');
            echo"<script language=\"javascript\"> alert('Erreur');</script>";
        }
         

        break;
    }

    case 'validerAttribuerUser': {

        $idSinistre = htmlspecialchars($_POST["idaa"]);
        $IdPersonne = htmlspecialchars($_POST['category2']);
        if ($pdo->modifDon($idSinistre,$IdPersonne)) {
            include('./vues/v_dons.php');
            echo "<script language=\"javascript\"> alert('Crée avec succès') </script>";		
        } else {
            include('./vues/v_dons.php');
            echo"<script language=\"javascript\"> alert('Erreur');</script>";
        }
        break;
    }
    case 'validerAjouterDonnateur' : {

        $nom = htmlspecialchars($_POST["name-add"]);
        $prenom = htmlspecialchars($_POST["prenom-add"]);
        $adresse = htmlspecialchars($_POST["adresse-add"]);
        $numtel = htmlspecialchars($_POST["tel-add"]);
        $typeCat = htmlspecialchars($_POST["category1-add"]);
        $nomorg = htmlspecialchars($_POST["nomorg-add"]);
        
        $pdo->CreateDonateur($nom, $prenom, $adresse, $numtel,$typeCat,$nomorg);
        include('./vues/v_donnateur.php');

        break;
    }

    case 'validerAjoutDon' : {
        $idIdonateur = htmlspecialchars($_POST["category1-add"]);
        $dateAjout = htmlspecialchars($_POST["date-add"]);
        $montant = htmlspecialchars($_POST["montant-add"]);
        $typeDon = htmlspecialchars($_POST["category2-add"]);
        $personne = htmlspecialchars($_POST["category3-add"]);
        $pdo->addDon($idIdonateur, $dateAjout,$montant,$typeDon,$personne);
        include('./vues/v_dons.php');

        break;

    }

}




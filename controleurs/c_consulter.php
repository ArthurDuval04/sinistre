<?php 
if(!isset($_GET['action'])){
	$_GET['action'] = 'consulteSinistre';
}
if(!isset($_SESSION['email'])){
    header('Location: index.php?uc=retour&action=valideRetour');
    
}
$action = $_GET['action'];
switch($action){
	
	case 'consulteSinistre':{
		include("vues/v_consulterSinistre.php");
		break;
	}

    case 'consulteVictimes':{
		include("vues/v_listeSinistres.php");
		break;
	}
	case 'consulteDons':{
		include("vues/v_dons.php");
		break;
	}
	case 'consulterDonateurs' : {
		include("vues/v_donnateur.php");
	}


}

?>
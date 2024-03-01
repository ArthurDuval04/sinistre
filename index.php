<?php
require_once("include/fct.inc.php");
require_once("include/class.pdogsb.inc.php");
require_once("class/User.php");
require_once("class/Donateur.php");
require_once("class/SinistreObj.php");
require_once("class/SinistreUser.php");
require_once("class/Don.php");
session_start();
date_default_timezone_set('Europe/Paris');

?>
<link href="./tailwind/output.css" rel="stylesheet">
<link rel="icon" href="./assets/img/ville.png" type="image/x-icon">
<?php
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();



	if(!isset($_GET['uc'])){
		$_GET['uc'] = 'connexion';
   }
   else {
	   if($_GET['uc']=="connexion" && !estConnecte()){
		   $_GET['uc'] = 'connexion';
	   }       
   }
   
   $uc = $_GET['uc'];
   switch($uc){
	   case 'connexion':{
		   include("controleurs/c_connexion.php");break;
	   }
		case 'creation':{
		   include("controleurs/c_creation.php");break;
	   }
	   case 'consulter' :{
		include("controleurs/c_consulter.php");break;
	   }
	   case 'retour' :{
		include("controleurs/c_retour.php");break;
	   }
	   case 'deconnect' : {
		include("controleurs/c_deconnexion.php");break;
	   }
	   case 'modifier' : {
		include("controleurs/c_modifier.php");break;
	   }
	   case 'admin' : {
		include("controleurs/c_admin.php");break;
	   }
	   case 'supprimer' : {
		include("controleurs/c_supprimer.php");break;
	   }
	}

   
	   include("vues/v_footer.php");





?>








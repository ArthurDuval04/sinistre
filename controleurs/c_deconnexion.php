<?php 
if(!isset($_GET['action'])){
	$_GET['action'] = 'valideDeco';
}
$action = $_GET['action'];
switch($action){
	
	case 'valideDeco':{
		include("vues/v_connexion.php");
        session_destroy();
		break;
	}
	
	
}

<?php
if(!isset($_GET['action'])){
	$_GET['action'] = 'valideRetour';
    
}
$action = $_GET['action'];
switch($action){
	
	case 'valideRetour':{
		include("vues/v_home.php");
		break;
	}

    


}
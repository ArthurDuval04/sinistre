<?php
if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeCreation';
    
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeCreation':{
		include("vues/v_creation.php");
		break;
	}
	case 'valideCreation':{


		
		if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['nom'] && isset($_POST['prenom']) ){
			$mail = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);
			$password2 = htmlspecialchars($_POST['password2']);
			$nom = htmlspecialchars($_POST['nom']);
			$prenom = htmlspecialchars($_POST['prenom']);
			$patternPassword='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#';
			$passwordOk = true;
            // if (preg_match($patternPassword, $password)==false){
            //     echo 'Le mot de passe doit contenir au moins 12 caractères, une majuscule,'
            //     . ' une minuscule et un caractère spécial<br/>';
            //     $passwordOk=false;
            // }
			if($password != $password2) {
				echo"<script language=\"javascript\"> alert('Les mots de passe ne correspondent pas') </script>";
				$passwordOk=false;
			}
			$hashpwd = password_hash($password,PASSWORD_DEFAULT);
			if($passwordOk) {
				$pdo->creeUser($mail, $hashpwd, $nom, $prenom);	
				include('vues/v_connexion.php');
				echo"<script language=\"javascript\"> alert('Compte créer avec succes.') </script>";
			}
				
		} else {
			echo "pasok";
		}


    }
}
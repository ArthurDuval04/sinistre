<?php 
if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeConnexion';
}

$action = $_GET['action'];
switch($action){
	
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	
	case 'valideConnexion':{
		
	
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$login = htmlspecialchars($_POST['email']);
			$pwd = htmlspecialchars($_POST['password']); 
			$toutok = $pdo->checkUser($login,$pwd);
			
			if($toutok) {
				
				$_SESSION['email'] = $login;
			
				include('vues/v_home.php');
				break;

			}else {
				include('vues/v_connexion.php');
				?><script>alert("Mot de passe ou nom d'utilisateur incorrect")</script> <?php 
				
				break;
			}
		}
		
    }

}

?>
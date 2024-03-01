<?php 
if(!isset($_GET['action'])){
	$_GET['action'] = 'consulter';
}
if(!isset($_SESSION['email'])){
    header('Location: index.php?uc=retour&action=valideRetour');
    
}
$action = $_GET['action'];
switch($action){

    case 'consulter': {
        $user = $pdo->donneUserByMail($_SESSION["email"]);
        if($user->getRole() != 1) {
            include('vues/v_unauthorized.php');
            
        } else {
            include('vues/v_admin.php');
        }
        break;
    }
    case 'validerAjoutUser' : {

        if (isset($_POST['name-add']) && isset($_POST['prenom-add']) && isset($_POST['mail-add']) && $_POST['password1-add'] && isset($_POST['password2-add']) && isset($_POST["category1-add"])) {
            $nom = htmlspecialchars($_POST["name-add"]);
            $prenom = htmlspecialchars($_POST["prenom-add"]);
            $mail = htmlspecialchars($_POST["mail-add"]);
            $password1 = htmlspecialchars($_POST["password1-add"]);
            $password2 = htmlspecialchars($_POST["password2-add"]);
            $idRole = htmlspecialchars($_POST["category1-add"]);
            if ($password1 == $password2) {
                $securePasswd = password_hash($password1,PASSWORD_DEFAULT);
                $unUser = new User($nom,$mail,$idRole);
                $unUser->setNom($nom); 
                $unUser->setPrenom($prenom);
                $unUser->setMail($mail);
                $unUser->setRole($idRole);

                if ($pdo->CreateUser($unUser,$securePasswd)) {
                   
                    include('vues/v_home.php');
				    break;
                  
                
                } else {
                    include('vues/v_home.php');
				    break;
                }
            }
        }
        

        
    }

}

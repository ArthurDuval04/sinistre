<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeSuppr';
    
}
if(!isset($_SESSION['email'])){
    header('Location: index.php?uc=retour&action=valideRetour');
    
}
$action = $_GET['action'];
switch($action){
	
	case 'validerDemandeSuprrUser':{
        $pdo->deleteUnSinistre(htmlspecialchars($_GET["id"]));
        include('./vues/v_listeSinistres.php');
        break;   
    }

    case 'validerSupprDon':{
        $pdo->deleteDon(htmlspecialchars($_GET['id']));
        include('vues/v_dons.php');
        break;
    }



    case 'validerSupprDonateur': {
        
        if($pdo->deleteDonnateur(htmlspecialchars($_GET['id']))!=1){
            echo"<script language=\"javascript\"> alert('Vous ne pouvez pas supprimer un donateur quand il est attribué sur un à plusieurs dons ! ');</script>";
            include('vues/v_donnateur.php');
        };
        include('vues/v_donnateur.php');
        break;
    }

    case 'validerSupprSinistre': {
        

        if($pdo->deleteSinistre(htmlspecialchars($_GET['id']))==1) {
            include('vues/v_consulterSinistre.php');
        } else{
            include('vues/v_consulterSinistre.php');
            echo"<script language=\"javascript\"> alert('Vous ne pouvez pas supprimer un sinistre quand il est attribué sur un à plusieurs sinistrés ! ');</script>";
        }; 
    }

    case 'validerSupprUser' : {
        $user = $pdo->donneUserByID(htmlspecialchars($_GET['id']));
       
     
        if ($user->getMailUser() == $_SESSION["email"]) {
            echo '<script>alert("Vous ne pouvez pas supprimer votre propre compte")</script>';
            include('vues/v_admin.php');
        }else {

            if($pdo->deleteUser(htmlspecialchars($_GET['id']))) {
                include('vues/v_admin.php');
            } else {
                include('vues/v_admin.php');
            }
        
        } 
        
    }
}

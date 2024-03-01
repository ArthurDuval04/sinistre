<?php 
$lesPeriodes = $pdo->getAllSinistreData();
$lesSinitres = $pdo->getAllVictimeData();

if (!isset($_SESSION["email"])) {
  include('v_connexion.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter</title>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
  <link href="../tailwind/output.css" rel="stylesheet">

  <script>
  document.addEventListener('DOMContentLoaded', function() {
  function remplirFormulaire(id,nom, prenom, adresse, tel, reloge, adresseRelog) {
    document.getElementById('idaa').value = id;
    document.getElementById('name').value = nom;
    document.getElementById('prenom').value = prenom;
    document.getElementById('adresse').value = adresse;
    document.getElementById('tel').value = tel;
    document.getElementById('category1').value = reloge ? '2' : '1';
    document.getElementById('adresseRelog').value = adresseRelog;
  }

  var elementsDeclencheurs = document.querySelectorAll('[data-modal-toggle]');

  elementsDeclencheurs.forEach(function(element) {
    element.addEventListener('click', function() {
      var id = element.getAttribute('data-id');
      var nom = element.getAttribute('data-nom');
      var prenom = element.getAttribute('data-prenom');
      var adresse = element.getAttribute('data-adresse');
      var tel = element.getAttribute('data-tel');
      var reloge = element.getAttribute('data-reloge') === '1';
      var adresseRelog = element.getAttribute('data-adresseRelog');

      
      remplirFormulaire(id,nom, prenom, adresse, tel, reloge, adresseRelog);

      
      document.getElementById(element.getAttribute('data-modal-target')).classList.remove('hidden');
    });
  });


  var boutonFermerModal = document.querySelectorAll('[data-modal-target] [data-modal-close]');

  boutonFermerModal.forEach(function(bouton) {
    bouton.addEventListener('click', function() {
     
      document.getElementById(bouton.getAttribute('data-modal-target')).classList.add('hidden');
    });
  });
});

</script>

</head>
<body>
  
<div class="w-screen h-screen bg-gray-900 overflow-y-auto">
  <a href='index.php?uc=deconnect&action=valideDeco' class='flex flex-wrap absolute top-3 right-4 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>
    <svg class="mr-2 mt-1/2" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
    </svg>
    <button type='button'>Déconnexion</button>
  </a>
  <a href='index.php?uc=retour&action=valideRetour' class='flex flex-wrap absolute top-3 ml-4 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>
  <svg class="mr-2"xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H6M12 5l-7 7 7 7"/></svg>
    <button type='button'>Retour</button>
  </a>
  <div class="text-white text-center p-6 ">
    <h1 class="text-xl font-serif p-6 ">Liste des sinistrés </h1>
    <button data-modal-target='modal-ajouter' data-modal-toggle='modal-ajouter' type='button' id='toto' class='p-6 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>+ Ajouter</button>

  </div>
 
  <div class="flex items-center justify-center mb-5">

    <table class="h-full mb-5 table-auto md:w-2/3 lg:w-1/2 text-sm sm:text-xs text-left rtl:text-right text-gray-300 dark:text-gray-400 mx-auto justify-center overflow-hidden rounded-lg">
      <thead class="text-xs sm:text-sm text-gray-400 uppercase bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">Date</th>
          <th scope="col" class="px-6 py-3">Nom</th>
          <th scope="col" class="px-6 py-3">Prénom</th>
          <th scope="col" class="px-6 py-3">Adresse</th>
          <th scope="col" class="px-6 py-3">Tel</th>
          <th scope="col" class="px-6 py-3">Relogé</th>
          <th scope="col" class="px-6 py-3">Adresse Relogement</th>
          <th scope="col" class="px-6 py-3">Sinistre</th>
          <th scope="col" class="px-10 py-3">Reçus par</th>
          <th scope="col" class="px-10 py-3">Action</th>

        </tr>
      </thead>
      <tbody>
        
      <?php 
        foreach ($lesSinitres as $unePers => $k) {
          $numSin = $pdo->getUnSinistreById($k->getSinistreId());
          
          echo "<tr class='border-t border-gray-700 bg-gray-800 dark:border-gray-700'>";
          foreach ($numSin as $leSin) {
            echo "<th scope='row' class='p-6 px-6 py-4 font-medium text-gray-300 whitespace-nowrap dark:text-white'>". $leSin->getSinistreDebut()."</th>
          
          ";}
          
          echo "
          <th scope='row' class='p-6 px-6 py-4 font-medium text-gray-300 whitespace-nowrap dark:text-white'>". $k->getNom()."</th>
          <td class='px-6 py-4 text-center'>".$k->getPrenom()."</td>
          <td class='px-6 py-4'> ".$k->getAdresse()."</td>
          <td class='px-6 py-4'> ".$k->getNumTel()."</td>
          <td class='px-6 py-4'> ";
          if ($k->getStatutRelogement()) {
            echo "Oui";
          } else  echo "Non"; 
          
          echo "</td>
          <td class='px-6 py-4'> ".$k->getAdresseRelogement()."</td>
          <td class='px-6 py-4'> ".$k->getSinistreId()."</td>";
          $donnateurData = $pdo->getUnDonateurById($k->getDonateurId());
          if ($donnateurData) { 
         
            
            echo "<td class='px-7 py-2'> ".$donnateurData->getNom()." ".$donnateurData->getPrenom()."<br/> [".$donnateurData->getNomOrganisme()." ] ";
            
          }
          else 
          {
            echo "<td class='px-7 py-2'>Aucun don </td>";
          }
          ?>
          
           

          <?php
          
           echo "
           </td>
         
              <td class='px-3 py-4 inline-flex'>
              
                <button data-modal-target='crud-modal' data-modal-toggle='crud-modal' data-id='" . $k->getId() . "' data-nom='" . $k->getNom() . "'  data-prenom='" . $k->getPrenom() . "' data-adresse='" . $k->getAdresse() . "' data-tel='" . $k->getNumTel() . "' data-reloge='" . ($k->getStatutRelogement() ? '1' : '0') . "' data-adresseRelog='" . $k->getAdresseRelogement() . "' class='btn-modifier bg-red-500 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>Modifier</button>
                <button type='button' data-modal-target='popup-modal'  data-modal-toggle='popup-modal'  class='text-white bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>
                
                </button>
              
              </td>
              
         
    
        </tr>";
        }   
      ?>  
      
      </tbody>
    </table>
    <div id="modal-ajouter" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center text-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
              Ajouter une personne
          </h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modal-ajouter">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Fermer la fenêtre</span>
          </button>
        </div>
          <form class="p-4 md:p-5" method="post" action="index.php?uc=modifier&action=validerCreerSinistre">
            <div class="grid gap-4 mb-4 grid-cols-2 p-4">
              <div class="col-span-2">
                  <label for="name-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                  <input type="text" name="name-add" id="name-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
              </div>
            
              <div class="col-span-2 sm:col-span-1">
                  <label for="prenom-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                  <input type="text" name="prenom-add" id="prenom-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
              </div>
              <div class="col-span-2 sm:col-span-1">
                  <label for="adresse-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse (complète)</label>
                  <input type="text" name="adresse-add" id="adresse-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" >
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label for="tel-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tel</label>
                <input type="tel" name="tel-add" maxlength=10 id="tel-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
              </div>
              <div class="col-span-2 sm:col-span-1">
                  <label for="category1-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Relogé</label>
                  <select id="category1-add" name ="category1-add"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="1">Non</option>
                    <option value="2">Oui</option>
                    <option value="3">Non concerné</option>   
                  </select>
              </div>
              <div class="col-span-2 sm:col-span-1">
                  <label for="adresseRelog-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse Relogement (laisser vide si non)</label>
                  <input type="text" name="adresseRelog-add" id="adresseRelog-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" >
              </div>
              <div class="col-span-2 sm:col-span-1">
                  <label for="category-add2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Sinistre</label>
                  <select id="category-add2" name ="category-add2"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <?php 
                        foreach($lesPeriodes as $uneP) {
                          echo "<option value=".$uneP->getIdSin().">Du ".date("d-m-Y", strtotime($uneP->getSinistreDebut())). " au ". date("d-m-Y", strtotime($uneP->getSinistreFin()))."</option>";
                        }
                      ?>
                  </select>
              </div>
            </div>
            <div class="flex items-center justify-center">
            <button type="submit" class="text-white inline-flex items-center mt-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Valider
            </button>
          </div>
          </form>
      </div>
    </div>
  </div> 
  </div>
  <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
              Modifier une personne
          </h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Fermer la fenêtre</span>
          </button>
        </div>
        <form class="p-4 md:p-5" method="post" action="index.php?uc=modifier&action=validerModifSinistre">
          <div class="grid gap-4 mb-4 grid-cols-2 p-4">
            <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                <input value=<?php echo $k->getNom()?> type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1 hidden ">
              <label for="idaa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
              <input value=<?php echo $k->getId()?> name="idaa" id="idaa" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" value=<?php echo $k->getPrenom()?>>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="adresse" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse (complète)</label>
                <input type="text" name="adresse" id="adresse" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" value=<?php echo $k->getAdresse()?>>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="tel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tel</label>
                <input type="text" name="tel" id="tel" maxlength=10 class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" value=<?php echo $k->getNumTel()?>>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Relogé</label>
                <select id="category" name ="category1"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  <option value="1">Non</option>
                  <option value="2">Oui</option>
                  <option value="3">Non concerné</option>   
                </select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="adresseRelog" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse Relogement (laisser vide si non)</label>
                <input type="text" name="adresseRelog" id="adresseRelog" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value=<?php echo $k->getAdresseRelogement()?>>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Sinistre</label>
                <select id="category" name ="category2"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <?php 
                      foreach($lesPeriodes as $uneP) {
                        echo "<option value=".$uneP->getIdSin().">Du ".date("d-m-Y", strtotime($uneP->getSinistreDebut())). " au ". date("d-m-Y", strtotime($uneP->getSinistreFin()))."</option>";
                      }
                    ?>
                </select>
            </div>
          </div>
          <div class="flex items-center justify-center">
            <button type="submit" class="text-white inline-flex items-center mt-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Valider
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  
  <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative rounded-lg shadow bg-gray-700">
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 :hover:text-white" data-modal-hide="popup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Fermer la fenêtre</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-400 dark:text-gray-400">Voulez vous vraiment supprimer ce donateur ?</h3>
                                <a href ='index.php?uc=supprimer&action=validerDemandeSuprrUser&id=<?php echo $k->getId()?>'>
                              
                                <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                    Oui, supprimer
                                </button>
                                </a>
                                <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Non, annuler</button>
                            </div>
                        </div>
                    </div>
                  </div>
</div>




</body>
</html>
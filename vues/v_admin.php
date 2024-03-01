<!DOCTYPE html>
<html lang="fr">
  <?php 
  
    $requestUserPage = $pdo->donneUserByMail($_SESSION["email"]);
    if ($requestUserPage->getRole() != 1 ) {
      include('vues/v_unauthorized.php');
    }
  
  ?> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <title>Admin</title>
    <link href="../tailwind/output.css" rel="stylesheet">
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    function remplirFormulaire(id,nom, prenom, role,mail) {
        document.getElementById('idaa').value = id;
        document.getElementById('name').value = nom;
        document.getElementById('prenom').value = prenom;
        document.getElementById('category1').value = role ? '2' : '1';
        document.getElementById('mail-id').value = mail;

    }

  var elementsDeclencheurs = document.querySelectorAll('[data-modal-toggle]');

  elementsDeclencheurs.forEach(function(element) {
    element.addEventListener('click', function() {
        var id = element.getAttribute('data-id');
        var nom = element.getAttribute('data-nom');
        var prenom = element.getAttribute('data-prenom');
        var role = element.getAttribute('data-role') === '2';
        var mail = element.getAttribute('data-mail');

      
      remplirFormulaire(id,nom, prenom,role, mail);

      
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

<div class="h-full w-100 bg-gray-900 overflow-y-auto">
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
  <div class="text-white text-center p-6">
    <h1 class="text-xl font-serif p-6 ">Liste des utilisateurs </h1>
    <button data-modal-target='Add-modal' data-modal-toggle='Add-modal' type='button' class='p-6 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>+ Ajouter</button>
  </div>
 
  <div class="flex items-center justify-center pb-4">
    <table class="overflow-hidden table-auto md:w-2/3 lg:w-1/2 text-sm sm:text-xs text-left rtl:text-right text-gray-300 dark:text-gray-400 mx-auto justify-center rounded-lg">
        <thead class="text-xs sm:text-sm text-gray-400 uppercase bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">Nom</th>
          <th scope="col" class="px-6 py-3">Prénom</th>
          <th scope="col" class="px-6 py-3">Mail</th>
          <th scope="col" class="px-10 py-3">Action</th>
        </tr>
      </thead>   
      <tbody>
        <?php 
            $lesUsers = $pdo->donneAllUser();
        
            foreach($lesUsers as $unUser) {
                echo "
                <tr class='border-t bg-gray-800 border-gray-700'>
                <th scope='row' class='p-6 px-6 py-4 font-medium text-gray-300 whitespace-nowrap dark:text-white'>". $unUser->getNomUser()."</th>
                <td class='px-6 py-4 text-center'>".$unUser->getPrenomUser()."</td>
                <td class='px-6 py-4'> ".$unUser->getMailUser()."</td>
                </td>
         
                <td class='px-6 py-4 inline-flex'>
                
                  <button data-modal-target='crud-modal' data-modal-toggle='crud-modal' data-id='" . $unUser->getUserId() . "' data-nom='" . $unUser->getNomUser() . "'  data-prenom='" . $unUser->getPrenomUser() ."' data-mail = '" .$unUser->getMailUser(). "'data-role ='".$unUser->getRole()."' class='btn-modifier  bg-red-500 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>Modifier</button>
                  <button type='button' data-modal-target='popup-modal' data-modal-toggle='popup-modal'  class='text-white bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>
                  
                  </button>
                </td>";
            }
        
        ?>

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
                                <h3 class="mb-5 text-lg font-normal text-gray-400 dark:text-gray-400">Voulez vous vraiment supprimer cet utilisateur ?</h3>
                                <a href ='index.php?uc=supprimer&action=validerSupprUser&id=
                                <?php if(!empty($unUser)) 
                                  
                                  echo $unUser->getUserId()
                                
                                
                                
                                ?>'>
                                <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                    Oui, supprimer
                                </button>
                                </a>
                                <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Non, annuler</button>
                            </div>
                        </div>
                    </div>
        </div>
      </tbody>
    </table>
  </div>
  <div id="Add-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
                  <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center text-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                              Ajouter un utilisateur
                          </h3>
                          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="Add-modal">
                              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                              </svg>
                              <span class="sr-only">Fermer la fenêtre</span>
                          </button>
                    </div>
            <form class="p-4 md:p-5" method="post" action="index.php?uc=admin&action=validerAjoutUser">
                <div class="grid gap-4 mb-4 grid-cols-2 p-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label for="name-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                        <input type="text" name="name-add" id="name-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                    </div>
                           
                    <div class="col-span-2 sm:col-span-1">
                        <label for="prenom-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                        <input type="text" name="prenom-add" id="prenom-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                    </div>
                    <div class="col-span-2">
                        <label for="adresse-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mail</label>
                        <input type="mail" name="mail-add" id="mail-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" >
                    </div>
                    <div class="col-span-2">
                        <label for="password1-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                        <input type="password" name="password1-add" id="password1-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                    </div>
                    <div class="col-span-2 ">
                        <label for="password2-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmer le mot de passe</label>
                        <input type="password" name="password2-add" id="password2-add" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                    </div>
                    <div class="col-span-2 ">
                        <label for="category1-add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select id="category1-add" name ="category1-add"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="1">Admin</option> 
                            <option value="2">User</option>    
                        </select>
                    </div>
                    

                          
                        <!-- @TODO FAIRE CONDITION SI RELOGE ALORS PAR QUI -->
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
        <form class="p-4 md:p-5" method="post" action="#">
            <div class="grid gap-4 mb-4 grid-cols-2 p-4">
                <div class="col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                    <input value=<?php echo $unUser->getNomUser()?> type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                </div>
                <div class="col-span-2 hidden">
                  <label for="idaa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Id</label>
                  <input value=<?php echo $unUser->getUserId()?> name="idaa" id="idaa" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </div>
                <div class="col-span-2">
                    <label for="prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" value=<?php echo $unUser->getPrenomUser()?>>
                </div>
                <div class="col-span-2">
                    <label for="mail-id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mail</label>
                    <input type="mail" name="mail-id" id="mail-id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                </div>
                <div class="col-span-2">
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Attribuer un rôle</label>
                    <select id="category" name ="category"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option value="1">Admin</option> 
                      <option value="1">User</option> 
                    </select>
                </div>
                
            

                          
                    <!-- @TODO FAIRE CONDITION SI RELOGE ALORS PAR QUI -->
            </div>
            <div class="flex items-center justify-center">

            <button type="submit" class="text-white inline-flex items-center mt-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Valider
            </button>

            </div>
           
        </form>
         
    </div>
</div>


</body>
</html>
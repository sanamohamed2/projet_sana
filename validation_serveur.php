<?php
$ine=trim($_POST['ine']??'');
$mdp=$_POST['mdp']??'';
$erreurs=[];
if(strlen($ine)!==11||!str_starts_with($ine,'N'))
$erreurs[]='INE invalide (11 caractères, commence par N).';
if(strlen($mdp)<8)
$erreurs[]='Mot de passe trop court.';
if($erreurs){
  http_response_code(422);
  foreach($erreurs as $erreur)
  echo '<p>'.htmlspecialchars($erreur).'</p>';
}
else{
  echo '<p>Données valides sur le serveur (aucune authentification effectuée).</p>';
}

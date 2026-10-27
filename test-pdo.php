<?php

require __DIR__  . "/config/database.php";

echo "<h1>Connexion PDO reussie </h1>";

$requete = $pdo->query( "SELECT DATABASE() AS base_actuelle");
$ligne = $requete ->fetch();

echo "<p>Base : " . htmlspecialchars($ligne["base_actuelle"]) . "</p>";
        

?>
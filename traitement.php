<?php

$ine = $_POST["ine"] ?? "";

$mdp = $_POST["mdp"] ?? "";
?>
<!DOCTYPE html>
    <html lang="fr">
        
    <head>
        <meta charset="UTF-8">
        <title>Données reçues</title>
    </head>
    
    <body>
        <h1>Données reçues</h1>";
        <p>INE : <?php echo htmlspecialchars($ine); ?> </p>";
       
        
    </body>



</html>
<?php
session_start();

if (!isset($_SESSION['ine'])) {
    header('Location: connexion.html');
    exit;
}

if (empty($_SESSION['reclamation_succes'])) {
    header('Location: reclamation.php');
    exit;
}

unset($_SESSION['reclamation_succes']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réclamation enregistrée</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header>
    <h1>Portail étudiant - ULBO</h1> <?php include 'menu.php'; ?>
</header>

<main>
    <h2>Réclamation envoyée avec succès</h2>

    <p> Votre réclamation a bien été enregistrée dans la base de données. </p>

    <p> <a href="reclamation.php"> Déposer une autre réclamation </a> </p>
</main>

</body>
</html>

<?php
session_start();

// Vérifier si l'étudiant est connecté
if (!isset($_SESSION['ine'])) {
    header('Location: connexion.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil étudiant</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include 'menu.php'; ?>

<main class="accueil-background">

<h2>Bienvenue sur votre espace étudiant</h2>

<p> Bonjour, <?= htmlspecialchars($_SESSION['prenom']) ?>  <?= htmlspecialchars($_SESSION['nom']) ?> ! </p>

<p> Vous êtes connecté avec l'INE :  <?= htmlspecialchars($_SESSION['ine']) ?> </p>

<p> Utilisez le menu pour consulter vos notes ou déposer une réclamation. </p>

        <!-- Bouton vers Mes notes -->
        <a href="notes.php" class="btn-notes"> Consulter mes notes </a>

</main>

<footer class="site-footer">
    <p> &copy; 2026 Université Lédéa Bernard Ouédraogo (ULBO) </p>
    <p>Portail étudiant — Tous droits réservés.</p>
</footer>

</body>

</html>

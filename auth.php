<?php
session_start();
require_once 'connexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: connexion.html');
    exit;
}

$ine = trim($_POST['ine'] ?? ' ');
$mdp = $_POST['mdp'] ?? ' ';
$sql = "SELECT ine, nom, prenom, mdp_hash
        FROM comptes
        WHERE ine = :ine" ;
$stmt = $pdo->prepare($sql);
$stmt->execute(['ine' => $ine]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($etudiant &&
    password_verify($mdp, $etudiant['mdp_hash'])) {
    session_regenerate_id(true);
    $_SESSION['ine'] = $etudiant['ine'];
    $_SESSION['nom'] = $etudiant['nom'];
    $_SESSION['prenom'] = $etudiant['prenom'];
    header('Location: accueil.php');
    exit;
}
echo "INE ou mot de passe incorrect.";
?>


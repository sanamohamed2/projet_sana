<?php
session_start();

// Vérifier la session
if (!isset($_SESSION['ine'])) {
    header('Location: connexion.html');
    exit;
}

// Accepter uniquement les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reclamation.php');
    exit;
}

// Vérifier le jeton CSRF
$token = $_POST['csrf_token'] ?? '';

if (!is_string($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    exit("Requête non autorisée.");
}

require_once 'connexion_bd.php';

// L'INE provient uniquement de la session
$ine = $_SESSION['ine'];

// Récupérer les champs
$ue = trim($_POST['ue'] ?? '');
$objet = trim($_POST['objet'] ?? '');
$message = trim($_POST['message'] ?? '');

// Vérifier les champs
if ($ue === '' || $objet === '' || $message === '') {
    exit("Veuillez remplir tous les champs.");
}

if (mb_strlen($ue, 'UTF-8') > 120 || mb_strlen($objet, 'UTF-8') > 150 || mb_strlen($message, 'UTF-8') > 2000) {
    exit("Un ou plusieurs champs sont trop longs.");
}

try {
    // date_creation est générée automatiquement
    $sql = "INSERT INTO reclamations (ine, ue, objet, message) VALUES (:ine, :ue, :objet, :message)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ine' => $ine, 'ue' => $ue, 'objet' => $objet, 'message' => $message]);

    // Éviter de réutiliser le même jeton
    unset($_SESSION['csrf_token']);

    $_SESSION['reclamation_succes'] = true;

    header('Location: reclamation_succes.php');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("Erreur lors de l'enregistrement de la réclamation.");
}
?>

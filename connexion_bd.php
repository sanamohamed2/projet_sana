<?php
require_once 'config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST .
        ";dbname=" . DB_NAME .
        ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Erreur de connexion à MySQL.");
}
?>
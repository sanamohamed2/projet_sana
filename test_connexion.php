<?php
require_once 'connexion_bd.php';

try {
    $stmt = $pdo->query("SELECT DATABASE() AS base_active");
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h2>Connexion MySQL réussie !</h2>";
    echo "<p>Base active : " .
        htmlspecialchars(
            $resultat['base_active'],
            ENT_QUOTES,
            'UTF-8'
        ) .
        "</p>";

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Erreur pendant le test SQL.";
}
?>

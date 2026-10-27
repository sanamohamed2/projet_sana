
<?php
session_start();

// Vérifier que l'étudiant est connecté
if (!isset($_SESSION['ine'])) {
    header('Location: connexion.html');
    exit;
}

// Générer un jeton CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réclamation - ULBO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>


    <?php include 'menu.php'; ?>


<main class="accueil-background">
    <h2>Déposer une réclamation</h2>

    <p>
        Étudiant :
        <?= htmlspecialchars(
            ($_SESSION['prenom'] ?? '') . ' ' .
            ($_SESSION['nom'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <p>
        INE :
        <?= htmlspecialchars(
            $_SESSION['ine'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <form action="traiter_reclamation.php" method="post">

        <input type="hidden"
               name="csrf_token"
               value="<?= htmlspecialchars(
                   $_SESSION['csrf_token'],
                   ENT_QUOTES,
                   'UTF-8'
               ) ?>">

        <label for="ue">Unité d'enseignement :</label>
        <input type="text"
               id="ue"
               name="ue"
               maxlength="120"
               required>

        <label for="objet">Objet :</label>
        <input type="text"
               id="objet"
               name="objet"
               maxlength="150"
               required>

        <label for="message">Message :</label>
        <textarea id="message"
                  name="message"
                  rows="5"
                  maxlength="2000"
                  required></textarea>

        <button type="submit">
            Envoyer la réclamation
        </button>
    </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>

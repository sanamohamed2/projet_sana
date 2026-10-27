<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['ine'])) {
    header('Location: connexion.html');
    exit;
}

require_once 'connexion_bd.php';

$ine = $_SESSION['ine'];

// Récupération des notes de l'étudiant connecté
$sql = "SELECT ue, credits, note
        FROM releves
        WHERE ine = :ine
        ORDER BY ue";

$stmt = $pdo->prepare($sql);
$stmt->execute(['ine' => $ine]);

$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul de la moyenne pondérée
$totalPoints = 0;
$totalCredits = 0;

foreach ($notes as $ligne) {
    $credits = (int) $ligne['credits'];
    $note = (float) $ligne['note'];

    if ($credits > 0) {
        $totalPoints += $note * $credits;
        $totalCredits += $credits;
    }
}

$moyenne = ($totalCredits > 0)
    ? $totalPoints / $totalCredits
    : null;

// Calcul de la mention
$mention = "Non disponible";

if ($moyenne !== null) {
    if ($moyenne >= 16) {
        $mention = "Très bien";
    } elseif ($moyenne >= 14) {
        $mention = "Bien";
    } elseif ($moyenne >= 12) {
        $mention = "Assez bien";
    } elseif ($moyenne >= 10) {
        $mention = "Passable";
    } else {
        $mention = "Ajourne";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes notes - ULBO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'menu.php'; ?>
<main >
    <h2>Mes notes</h2>

    <p> Étudiant : <?= htmlspecialchars( ($_SESSION['prenom'] ?? '') . ' ' .($_SESSION['nom'] ?? ''), ENT_QUOTES,  'UTF-8') ?> </p>

    <p> INE : <?= htmlspecialchars($ine, ENT_QUOTES, 'UTF-8') ?> </p>

    <?php if (count($notes) > 0): ?>

        <table>
            <thead>
                <tr>
                    <th>Unité d'enseignement</th>
                    <th>Crédits</th>
                    <th>Note /20</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($notes as $ligne): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars( $ligne['ue'], ENT_QUOTES, 'UTF-8' ) ?>
                        </td>

                        <td>
                            <?= (int) $ligne['credits'] ?>
                        </td>

                        <td>
                            <?= number_format( (float) $ligne['note'], 2, ',',  ' ' ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>
            Moyenne :
            <?php if ($moyenne !== null): ?>
                <?= number_format($moyenne, 2, ',', ' ') ?>/20
            <?php else: ?>
                Non disponible
            <?php endif; ?>
        </h3>

        <p>
            <strong>Mention :</strong>
            <?= htmlspecialchars($mention, ENT_QUOTES, 'UTF-8') ?>
        </p>

        <p> <strong>Total des crédits :</strong> <?= $totalCredits ?> </p>

    <?php else: ?>

        <p>Aucune note disponible pour cet étudiant.</p>
    <?php endif; ?>
</main>

</body>
<?php include 'footer.php'; ?>
</html>
<?php

// =====================================================
// 1. DÉMARRER LA SESSION
// =====================================================

session_start();


// =====================================================
// 2. SI L'ÉTUDIANT EST DÉJÀ CONNECTÉ
// =====================================================

if (isset($_SESSION['ine'])) {

    header('Location: notes.php');

    exit;
}


// =====================================================
// 3. RÉCUPÉRER UN ÉVENTUEL MESSAGE D'ERREUR
// =====================================================

$erreur = $_SESSION['erreur_connexion'] ?? '';


// Une fois récupéré, on le supprime de la session.
// Il ne sera donc affiché qu'une seule fois.

unset($_SESSION['erreur_connexion']);

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Connexion étudiant - ULBO
    </title>


    <!-- =================================================
         FEUILLE DE STYLE
         Le fichier se trouve dans :
         assets/css/style.css
         ================================================= -->

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>


<body>


<!-- =====================================================
     EN-TÊTE DU PORTAIL
     ===================================================== -->

<header class="site-header">

    <div class="container header-layout">


        <!-- Logo + nom de l'université -->

        <a
            href="index.php"
            class="brand"
            aria-label="Accueil ULBO"
        >

            <img
                src="assets/images/logo-ulbo.jpg"
                alt="Logo de l'Université Lédéa Bernard Ouédraogo"
                class="university-logo"
            >


            <div class="brand-text">

                <h1>
                    Portail étudiant ULBO
                </h1>

                <p>
                    Université Lédéa Bernard Ouédraogo
                </p>

            </div>

        </a>


        <!-- Navigation -->

        <nav>

            <a href="index.php">
                Accueil
            </a>

            <a
                href="connexion.php"
                aria-current="page"
            >
                Connexion
            </a>

        </nav>

    </div>

</header>



<!-- =====================================================
     CONTENU PRINCIPAL
     ===================================================== -->

<main class="container narrow">


    <section class="panel">


        <h2>
            Connexion étudiant
        </h2>


        <p>
            Saisissez votre INE et votre mot de passe
            pour accéder à votre espace étudiant.
        </p>



        <!-- =================================================
             MESSAGE D'ERREUR ENVOYÉ PAR auth.php
             ================================================= -->

        <?php if ($erreur): ?>

            <p class="message error">

                <?= htmlspecialchars(
                    $erreur,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </p>

        <?php endif; ?>



        <!-- =================================================
             FORMULAIRE DE CONNEXION

             Les données seront envoyées vers auth.php
             avec la méthode POST.
             ================================================= -->

        <form
            id="formConnexion"
            action="auth.php"
            method="post"
        >


            <!-- =============================================
                 CHAMP INE
                 ============================================= -->

            <div class="form-group">

                <label for="ine">
                    INE
                </label>


                <input
                    type="text"
                    id="ine"
                    name="ine"
                    required
                    maxlength="30"
                    autocomplete="username"
                    placeholder="Ex. N2025001234"
                >

            </div>



            <!-- =============================================
                 CHAMP MOT DE PASSE
                 ============================================= -->

            <div class="form-group">

                <label for="mdp">
                    Mot de passe
                </label>


                <input
                    type="password"
                    id="mdp"
                    name="mdp"
                    required
                    autocomplete="current-password"
                    placeholder="Votre mot de passe"
                >

            </div>



            <!-- =============================================
                 BOUTON
                 ============================================= -->

            <button type="submit">

                Se connecter

            </button>


        </form>



        <!-- =================================================
             COMPTE DE DÉMONSTRATION
             ================================================= -->

        <div class="demo-box">

            <strong>
                Compte de démonstration
            </strong>


            <p>

                INE :

                <code>
                    N2025001234
                </code>

                <br>

                Mot de passe :

                <code>
                    Etudiant2026!
                </code>

            </p>

        </div>


    </section>


</main>



<!-- =====================================================
     JAVASCRIPT

     Important :
     placer le script juste avant </body>
     ===================================================== -->

<script src="assets/js/app.js"></script>


</body>

</html>
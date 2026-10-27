<?php

$message = '';
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // =====================================================
        // 1. CONNEXION À MYSQL
        // =====================================================

        $pdo = new PDO(
            'mysql:host=localhost;charset=utf8mb4',
            'root',
            '',
            [
                PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION,

                PDO::ATTR_DEFAULT_FETCH_MODE =>
                    PDO::FETCH_ASSOC,

                PDO::ATTR_EMULATE_PREPARES =>
                    false,
            ]
        );


        // =====================================================
        // 2. CRÉATION DE LA BASE
        // =====================================================

        $pdo->exec("
            CREATE DATABASE IF NOT EXISTS scolarite
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
        ");

        // Sélection de la base
        $pdo->exec("USE scolarite");


        // =====================================================
        // 3. SUPPRESSION DES ANCIENNES TABLES
        // =====================================================

        /*
         * Important :
         * reclamations et releves dépendent de comptes
         * à cause des clés étrangères.
         *
         * Il faut donc supprimer d'abord les tables enfants.
         */

        $pdo->exec("
            DROP TABLE IF EXISTS reclamations
        ");

        $pdo->exec("
            DROP TABLE IF EXISTS releves
        ");

        $pdo->exec("
            DROP TABLE IF EXISTS comptes
        ");


        // =====================================================
        // 4. CRÉATION DE LA TABLE comptes
        // =====================================================

        $pdo->exec("
            CREATE TABLE comptes (

                ine VARCHAR(30)
                    PRIMARY KEY,

                nom VARCHAR(100)
                    NOT NULL,

                prenom VARCHAR(100)
                    NOT NULL,

                email VARCHAR(190)
                    NOT NULL
                    UNIQUE,

                mdp_hash VARCHAR(255)
                    NOT NULL

            ) ENGINE=InnoDB
        ");


        // =====================================================
        // 5. CRÉATION DE LA TABLE releves
        // =====================================================

        $pdo->exec("
            CREATE TABLE releves (

                id INT
                    AUTO_INCREMENT
                    PRIMARY KEY,

                ine VARCHAR(30)
                    NOT NULL,

                ue VARCHAR(150)
                    NOT NULL,

                credits INT
                    NOT NULL,

                note DECIMAL(5,2)
                    NOT NULL,

                CONSTRAINT fk_releves_compte

                    FOREIGN KEY (ine)

                    REFERENCES comptes(ine)

                    ON DELETE CASCADE

            ) ENGINE=InnoDB
        ");


        // =====================================================
        // 6. CRÉATION DE LA TABLE reclamations
        // =====================================================

        $pdo->exec("
            CREATE TABLE reclamations (

                id INT
                    AUTO_INCREMENT
                    PRIMARY KEY,

                ine VARCHAR(30)
                    NOT NULL,

                ue VARCHAR(120)
                    NOT NULL,

                objet VARCHAR(150)
                    NOT NULL,

                message TEXT
                    NOT NULL,

                date_creation TIMESTAMP
                    DEFAULT CURRENT_TIMESTAMP,

                CONSTRAINT fk_reclamations_compte

                    FOREIGN KEY (ine)

                    REFERENCES comptes(ine)

                    ON DELETE CASCADE

            ) ENGINE=InnoDB
        ");


        // =====================================================
        // 7. DONNÉES DU PREMIER COMPTE DE DÉMONSTRATION
        // =====================================================

        $ine1 = 'N2025001234';
        $nom1 = 'OUEDRAOGO';
        $prenom1 = 'Awa';
        $email1 = 'awa.demo@ulbo.bf';
        $mdp1 = 'Etudiant2026!';

        // Le mot de passe n'est jamais stocké en clair
        $hash1 = password_hash(
            $mdp1,
            PASSWORD_DEFAULT
        );


        // =====================================================
        // 8. INSERTION DU PREMIER COMPTE
        // =====================================================

        $reqCompte = $pdo->prepare("
            INSERT INTO comptes
            (
                ine,
                nom,
                prenom,
                email,
                mdp_hash
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ");

        $reqCompte->execute([
            $ine1,
            $nom1,
            $prenom1,
            $email1,
            $hash1
        ]);


        // =====================================================
        // 9. DEUXIÈME COMPTE DE DÉMONSTRATION
        // =====================================================

        $ine2 = 'N2025005678';
        $nom2 = 'KABORE';
        $prenom2 = 'Issa';
        $email2 = 'issa.demo@ulbo.bf';
        $mdp2 = 'Web2026!';

        $hash2 = password_hash(
            $mdp2,
            PASSWORD_DEFAULT
        );


        // =====================================================
        // 10. INSERTION DU DEUXIÈME COMPTE
        // =====================================================

        $reqCompte->execute([
            $ine2,
            $nom2,
            $prenom2,
            $email2,
            $hash2
        ]);


        // =====================================================
        // 11. NOTES DU PREMIER ÉTUDIANT
        // =====================================================

        $notesEtudiant1 = [

            [
                'Programmation Web',
                4,
                14.50
            ],

            [
                'Machine Learning',
                2,
                12.00
            ],

            [
                'Base de donnees',
                3,
                8.50
            ],

            [
                'Reseaux',
                3,
                15.00
            ],

            [
                'Statistique appliquee',
                4,
                13.50
            ]

        ];


        // =====================================================
        // 12. NOTES DU DEUXIÈME ÉTUDIANT
        // =====================================================

        $notesEtudiant2 = [

            [
                'Programmation Web',
                4,
                16.00
            ],

            [
                'Machine Learning',
                2,
                11.50
            ],

            [
                'Base de donnees',
                3,
                13.00
            ],

            [
                'Reseaux',
                3,
                9.00
            ],

            [
                'Statistique appliquee',
                4,
                15.00
            ]

        ];


        // =====================================================
        // 13. PRÉPARATION DE L'INSERTION DES NOTES
        // =====================================================

        $reqNote = $pdo->prepare("
            INSERT INTO releves
            (
                ine,
                ue,
                credits,
                note
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ");


        // =====================================================
        // 14. INSERTION DES NOTES DU PREMIER ÉTUDIANT
        // =====================================================

        foreach (
            $notesEtudiant1 as
            [$ue, $credits, $note]
        ) {

            $reqNote->execute([
                $ine1,
                $ue,
                $credits,
                $note
            ]);

        }


        // =====================================================
        // 15. INSERTION DES NOTES DU DEUXIÈME ÉTUDIANT
        // =====================================================

        foreach (
            $notesEtudiant2 as
            [$ue, $credits, $note]
        ) {

            $reqNote->execute([
                $ine2,
                $ue,
                $credits,
                $note
            ]);

        }


        // =====================================================
        // 16. MESSAGE DE SUCCÈS
        // =====================================================

        $message =
            "Installation terminée avec succès. "
            . "Deux comptes de démonstration ont été créés.";


    } catch (Throwable $e) {

        // =====================================================
        // 17. GESTION DES ERREURS
        // =====================================================

        $erreur = $e->getMessage();

    }

}

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
        Installation du fil rouge ULBO
    </title>

    <!--
        Si votre fichier CSS est dans :
        fil_rouge_ulbo/assets/css/style.css
    -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>


<body class="page-centree">


<main class="carte">


    <!-- =====================================================
         LOGO ULBO
         ===================================================== -->

    <div class="install-brand">

        <img
            src="assets/images/logo-ulbo.jpg"
            alt="Logo de l'Université Lédéa Bernard Ouédraogo"
            class="install-logo"
        >

        <div>

            <h1>
                Installation du fil rouge ULBO
            </h1>

            <p>
                Université Lédéa Bernard Ouédraogo
            </p>

        </div>

    </div>


    <!-- =====================================================
         MESSAGE DE SUCCÈS
         ===================================================== -->

    <?php if ($message): ?>

        <p class="succes">

            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </p>


        <div class="demo-box">

            <h2>
                Comptes de démonstration
            </h2>


            <p>

                <strong>
                    Étudiant 1
                </strong>

                <br>

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


            <p>

                <strong>
                    Étudiant 2
                </strong>

                <br>

                INE :
                <code>
                    N2025005678
                </code>

                <br>

                Mot de passe :
                <code>
                    Web2026!
                </code>

            </p>

        </div>


        <p>

            <a
                class="bouton-lien"
                href="connexion.php"
            >
                Aller à la connexion
            </a>

        </p>

    <?php endif; ?>


    <!-- =====================================================
         MESSAGE D'ERREUR
         ===================================================== -->

    <?php if ($erreur): ?>

        <div class="erreur">

            <strong>
                Une erreur est survenue :
            </strong>

            <br><br>

            <?= htmlspecialchars(
                $erreur,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         EXPLICATION
         ===================================================== -->

    <section>

        <h2>
            Que fait cette page ?
        </h2>

        <p>
            Cette page prépare automatiquement la base de données
            <code>scolarite</code>.
        </p>


        <p>
            Elle réalise les opérations suivantes :
        </p>


        <ol>

            <li>
                connexion à MySQL ;
            </li>

            <li>
                création de la base
                <code>scolarite</code> ;
            </li>

            <li>
                suppression des anciennes tables du projet ;
            </li>

            <li>
                création de la table
                <code>comptes</code> ;
            </li>

            <li>
                création de la table
                <code>releves</code> ;
            </li>

            <li>
                création de la table
                <code>reclamations</code> ;
            </li>

            <li>
                création de deux comptes étudiants ;
            </li>

            <li>
                création de notes de démonstration.
            </li>

        </ol>

    </section>


    <!-- =====================================================
         AVERTISSEMENT
         ===================================================== -->

    <div class="attention">

        <strong>
            Attention :
        </strong>

        cliquer sur le bouton ci-dessous supprime les anciennes
        données contenues dans les tables
        <code>comptes</code>,
        <code>releves</code>
        et
        <code>reclamations</code>.

        Cette fonction est destinée uniquement au projet
        pédagogique local.

    </div>


    <!-- =====================================================
         FORMULAIRE D'INSTALLATION
         ===================================================== -->

    <form
        method="post"
        action=""
    >

        <button
            type="submit"
        >
            Installer / réinitialiser la base
        </button>

    </form>


</main>


</body>

</html>
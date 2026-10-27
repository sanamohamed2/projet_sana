# Portail etudiant ULBO (fil rouge)

Portail web des etudiants de l'Universite Ledea Bernard Ouedraogo :
connexion, consultation des notes, depot de reclamations.
Projet realise en cours (HTML, CSS, JavaScript, PHP, MySQL).

## Pages principales

| Page              | Role                                             |
|-------------------|--------------------------------------------------|
| `index.html`      | Page d'accueil publique, lien vers la connexion  |
| `connexion.html`  | Formulaire de connexion (INE + mot de passe)     |
| `auth.php`        | Verifie les identifiants, ouvre la session       |
| `accueil.php`     | Espace etudiant (apres connexion)                |
| `notes.php`       | Releve de notes                                  |
| `reclamation.php` | Depot d'une reclamation                          |
| `install.php`     | Cree et **reinitialise** la base (outil de dev)  |

## Structure

```
index.html, connexion.html     pages publiques
*.php                          pages et scripts du portail
includes/                      fichiers PHP partages
assets/css, assets/js, assets/images
config.example.php             modele de configuration (copier en config.php)
database/                      reserve aux scripts SQL
```

## Installation (XAMPP ou MAMP)

1. Placer ce dossier dans `htdocs` (ex. `C:\xampp\htdocs\fil_rouge_ulbo`).
2. Copier `config.example.php` en `config.php`, puis adapter DB_USER / DB_PASS.
3. Demarrer **Apache** et **MySQL** depuis le panneau XAMPP/MAMP.
4. Ouvrir `http://localhost/fil_rouge_ulbo/install.php` et cliquer sur
   le bouton : la base `scolarite` et deux comptes de demonstration sont crees.
5. Ouvrir `http://localhost/fil_rouge_ulbo/index.html`.

> **Attention** : `install.php` supprime puis recree les tables. Ne jamais le
> deployer sur un serveur reel.

## Travailler avec Git

- `main` reste toujours fonctionnelle ; une branche par tache
  (`fonction/...`, `correctif/...`, `docs/...`).
- Messages de commit clairs : quoi et pourquoi.
- Ne jamais commiter `config.php` ni de vrais mots de passe.

## Auteurs

- (a completer : noms et prenoms)


"use strict";

const formulaire = document.getElementById('form-connexion');

formulaire.addEventListener('submit', function(e) {

    let valide = true;

    const ine = document.getElementById('ine').value.trim();
    const mdp = document.getElementById('mdp').value;

    const erreurIne = document.getElementById('erreur-ine');
    const erreurMdp = document.getElementById('erreur-mdp');

    // Autoriser admin ou un INE étudiant valide
    const estAdmin = (ine === 'admin');
    const estEtudiant = (ine.length === 11 && ine.startsWith('N'));

    if (!estAdmin && !estEtudiant) {
        erreurIne.textContent =
            "Saisissez 'admin' ou un INE de 11 caractères commençant par N.";
        valide = false;
    } else {
        erreurIne.textContent = '';
    }

    // Vérifier le mot de passe
    if (mdp.length < 8) {
        erreurMdp.textContent =
            'Mot de passe : 8 caractères minimum.';
        valide = false;
    } else {
        erreurMdp.textContent = '';
    }

    // Empêcher l'envoi si les données sont invalides
    if (!valide) {
        e.preventDefault();
    }

});

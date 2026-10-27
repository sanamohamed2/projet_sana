const formulaire =
    document.querySelector("form");

formulaire.addEventListener(
    "submit",
    function(event) {

        const ine =
            document.querySelector("#ine");

        if (ine.value.trim() === "") {

            event.preventDefault();

            alert(
                "Veuillez saisir votre INE"
            );

        }

    }
);
function validateForm(event) {
    var now = new Date();
    var pickupDateTime = new Date(document.getElementById('pickupDateTime').value);
    var returnDateTime = new Date(document.getElementById('returnDateTime').value);

    // Vérifier si Return Date est après Pickup Date
    if (returnDateTime <= pickupDateTime) {
        displayErrorMessage('Date and Time must be after Pickup Date and Time.');
        handleInvalidForm();
        return false;
    }

    // Vérifier si la différence est d'au moins 24 heures
    var timeDifference = returnDateTime - pickupDateTime;
    var minimumDifference = 24 * 60 * 60 * 1000; // 24 heures en millisecondes
    if (timeDifference < minimumDifference) {
        displayErrorMessage('The minimum rental duration is 24 hours.');
        handleInvalidForm();
        return false;
    }

    // Vérifier si les dates sont antérieures à la date d'aujourd'hui
    if (pickupDateTime < now || returnDateTime < now) {
        displayErrorMessage('Dates cannot be earlier than today.');
        handleInvalidForm();
        return false;
    }

    
    // Vérifier la disponibilité de la voiture avec une requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'check_availability.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    var formData = 'carId=' + encodeURIComponent(<?php echo $carId; ?>) +
                   '&pickupDateTime=' + encodeURIComponent(document.getElementById('pickupDateTime').value) +
                   '&returnDateTime=' + encodeURIComponent(document.getElementById('returnDateTime').value);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var isCarAvailable = JSON.parse(xhr.responseText).available;

            if (isCarAvailable) {
                showConfirmationMessage();
                calculateAndDisplayPrice();
                toggleConfirmationButton(true);
            } else {
                displayErrorMessage('The car is not available on this date.');
                handleInvalidForm();
            }
        }
    };

    xhr.send(formData);
    event.preventDefault(); // Empêcher le rechargement de la page par défaut
    return true;
}

function handleInvalidForm() {
    toggleConfirmationButton(false); // Désactiver le bouton
    showConfirmationMessage(); // Afficher le message
    calculateAndDisplayPrice();
}

// ... (le reste du code JavaScript reste inchangé) ...

        function displayErrorMessage(message) {
            document.getElementById('error-message').innerHTML = message;
        }

        function toggleConfirmationButton(enable) {
            var confirmationButton = document.getElementById('confirmButton');
            if (confirmationButton) {
                if (enable) {
                    confirmationButton.classList.remove('disabled');
                } else {
                    confirmationButton.classList.add('disabled');
                }
            }
        }

        function calculateNumberOfDays(pickupDateTime, returnDateTime) {
            // Convertir les chaînes de date en objets Date
            var pickupDate = new Date(pickupDateTime);
            var returnDate = new Date(returnDateTime);

            // Calculer la différence en millisecondes
            var timeDifference = returnDate - pickupDate;

            // Convertir la différence en jours
            var daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

            return daysDifference;
        }

        function calculateAndDisplayPrice() {
            var pickupDateTime = new Date(document.getElementById('pickupDateTime').value.replace("T", " "));
            var returnDateTime = new Date(document.getElementById('returnDateTime').value.replace("T", " "));

            var timeDifference = returnDateTime - pickupDateTime;
            var minimumDifference = 24 * 60 * 60 * 1000;

            if (timeDifference >= minimumDifference) {
                // Calculer le prix TTC et l'afficher
                var numberOfDays = calculateNumberOfDays(pickupDateTime, returnDateTime);
                var prixTTC = numberOfDays * <?php echo $resultat['prix_journalier']; ?>;
                console.log("Prix TTC: " + prixTTC + " €");

                // Afficher le prix TTC dans le HTML
                document.getElementById('prixTTC').innerHTML = "Prix TTC: " + prixTTC.toFixed(2) + " €";
            }
        }

        function showConfirmationMessage() {
            var confirmationMessage = document.getElementById('confirmationMessage');
            if (confirmationMessage) {
                confirmationMessage.style.display = 'block';
                // Ajouter la classe blink pour le clignotement
                confirmationMessage.classList.add('blink');
            }
        }
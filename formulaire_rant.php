<?php
session_start();
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la clé 'id' existe, alors $id_voiture prend la valeur correspondante dans $_GET['id']. Sinon, $id_voiture est défini à null.
    $id_voiture = isset($_GET['id']) ? $_GET['id'] : null;

    // sélectionne toutes les colonnes de la table voiture où l'ID est égal à une valeur spécifiée.
    $sqlQuery = "SELECT * FROM voiture WHERE id = :id";
    $requete = $db->prepare($sqlQuery);
    // lie la valeur de la variable $id_voiture au marqueur de paramètre :id dans la requête préparée. 
    //Cela permet d'associer dynamiquement la valeur de l'ID récupérée à partir de la requête GET à la requête SQL.
    $requete->bindParam(':id', $id_voiture);
    $requete->execute();
    //Le tableau associatif $resultat contient les détails de la voiture
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Fermeture de la connexion à la base de données
    $db = null;

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifiez si la voiture a été trouvée
if (!$resultat) {
    // Gérer le cas où la voiture n'a pas été trouvée
    die('Voiture non trouvée');
}


// Génération du chemin complet de l'image
$cheminDossierImages = 'assets/';
$nomFichierImage = $resultat['image'];
$cheminCompletImage = $cheminDossierImages . $nomFichierImage;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <style>
         .prix-ttc {
            text-align: center; /* Centrer le texte */
            font-size: 24px; /* Taille de la police */
            font-weight: bold; /* Gras */
            margin-top: 20px; /* Espacement en haut pour l'esthétique */
            color: #007bff; /* Couleur du texte */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .details-container {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fff;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-column-gap: 20px;
        }

        .car-details {
            grid-column: 1 / 2;
        }

        .car-image {
            grid-column: 2 / 3;
            text-align: center;
        }

        .car-image img {
            max-width: 100%;
            height: auto;
        }

        .form-overlay {
            grid-column: 1 / -1;
            margin-top: 20px;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.1);
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .btn-light {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-light:hover {
            background-color: #0056b3;
        }
        
        .confirmation-button {
            clear: both;
            display: block;
            margin-top: 20px;
        }

        .confirmation-button.disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .details-container {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fff;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-column-gap: 20px;
        }

        .car-details {
            grid-column: 1 / 2;
        }

        .car-image {
            grid-column: 2 / 3;
            text-align: center;
        }

        .car-image img {
            max-width: 100%;
            height: auto;
        }

        .form-overlay {
            grid-column: 1 / -1;
            margin-top: 20px;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.1);
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .btn-light {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-light:hover {
            background-color: #0056b3;
        }
        
        .confirmation-button {
            clear: both;
            display: block;
            margin-top: 20px;
        }

        .confirmation-button.disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .btn-danger {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            background-color: #d9534f;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .confirmation-message {
            margin-top: 10px;
            display: none;
            text-align: center;
        }

        .blink {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }  opacity: 0.5;

       
        
    </style>
</head>
<body>
   <div class="details-container">
        <div class="car-details">
            <h2>Car Details</h2>
            <p>Modèle: <?php echo $resultat['modele']; ?></p>
            <p>Marque: <?php echo $resultat['marque']; ?></p>
            <p>Année: <?php echo $resultat['annee']; ?></p>
            <p>Couleur: <?php echo $resultat['couleur']; ?></p>
            <p>Prix journalier: <?php echo $resultat['prix_journalier']; ?> €</p>
            <?php
            // Assurez-vous que les valeurs sont définies et ne sont pas vides
            if (isset($_POST['pickupDateTime']) && isset($_POST['returnDateTime'])) {
                $pickupDateTime = new DateTime($_POST['pickupDateTime']);
                $returnDateTime = new DateTime($_POST['returnDateTime']);

                // Appel de la fonction calculateNumberOfDays côté serveur
                $numberOfDays = calculateNumberOfDays($pickupDateTime, $returnDateTime);
                $prixTTC = $numberOfDays * $resultat['prix_journalier'];
                var_dump($numberOfDays);
                var_dump($prixTTC);

                echo "<p >Prix TTC: $prixTTC €</p>";
            }
            ?>
        </div>
        <div class="car-image">
            <img src="<?php echo $cheminCompletImage; ?>" alt="Image de la voiture">
        </div>
        <div class="form-overlay">
            <form onsubmit="return validateForm(event)" action="facture.php" method="post">
                <div class="form-group">
                    <label for="pickupDateTime">Pickup Date and Time</label>
                    <input type="datetime-local" class="form-control" id="pickupDateTime" name="pickupDateTime" placeholder="Pickup Date and Time" required>
                </div>
                <div class="form-group">
                    <label for="returnDateTime">Return Date and Time</label>
                    <input type="datetime-local" class="form-control" id="returnDateTime" name="returnDateTime" placeholder="Return Date and Time" required>
                </div>
                <div id="error-message" class="error-message"></div>
                <button type="submit" class="btn-light">Check if the car is available</button>
            <!-- Bouton pour confirmer et ajouter à la base de données -->
            <button type="button" id="confirmButton" class="btn btn-danger confirmation-button disabled">Confirmed</button>
           
            <div id="confirmationMessage" class="confirmation-message">
                <p class="blink">The car is available on this date.</p>
            </div>
            </form>
            <!-- Élément pour afficher le prix TTC -->
            <div style='text-align: center; font-size: 24px; font-weight: bold; margin-top: 20px; color: #007bff;' id="prixTTC"></div>
        </div>
    </div>
    <?php 
    function isCarAvailable($carId, $pickupDateTime, $returnDateTime) {
        // Convertir les objets DateTime en chaînes de date MySQL
        $pickupDateStr = $pickupDateTime->format('Y-m-d H:i:s');
        $returnDateStr = $returnDateTime->format('Y-m-d H:i:s');
    
        // Effectuer la requête dans la base de données
        // Assurez-vous d'ajuster cela en fonction de votre propre structure de table et de votre logique de disponibilité
        $query = "SELECT COUNT(*) AS count
                  FROM commands
                  WHERE car_id = :carId
                    AND ((date_deb >= :pickupDateTime AND date_deb < :returnDateTime)
                        OR (date_fin > :pickupDateTime AND date_fin <= :returnDateTime)
                        OR (date_deb <= :pickupDateTime AND date_fin >= :returnDateTime))";
    
        // Utilisez PDO ou une autre méthode pour exécuter la requête avec les paramètres
        // Assurez-vous d'adapter cela à votre environnement et à votre connexion à la base de données
        
        $pdo =PDO('mysql:host=localhost;dbname=etudiant;charset=utf8','root', '');
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->bindParam(':pickupDateTime', $pickupDateStr, PDO::PARAM_STR);
        $stmt->bindParam(':returnDateTime', $returnDateStr, PDO::PARAM_STR);
        $stmt->execute();
    
        // Récupérer le résultat de la requête
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Si le nombre de lignes retourné est 0, la voiture est disponible
        // Sinon, la voiture n'est pas disponible
        return ($result['count'] == 0);
    }
    
    ?>

    <script>


    
        function validateForm(event) {
            var now = new Date(); // Obtenir la date actuelle
            var pickupDateTime = new Date(document.getElementById('pickupDateTime').value);
            var returnDateTime = new Date(document.getElementById('returnDateTime').value);

            // Vérifier si Return Date est après Pickup Date
            if (returnDateTime <= pickupDateTime) {
                displayErrorMessage('Date and Time must be after Pickup Date and Time.');
                toggleConfirmationButton(false); // Désactiver le bouton
                return false;
            }

            // Vérifier si la différence est d'au moins 24 heures
            var timeDifference = returnDateTime - pickupDateTime;
            var minimumDifference = 24 * 60 * 60 * 1000; // 24 heures en millisecondes
            if (timeDifference < minimumDifference) {
                displayErrorMessage('The minimum rental duration is 24 hours.');
                toggleConfirmationButton(false); // Désactiver le bouton
                return false;
            }

            // Vérifier si les dates sont antérieures à la date d'aujourd'hui
            if (pickupDateTime < now || returnDateTime < now) {
                displayErrorMessage('Dates cannot be earlier than today.');
                toggleConfirmationButton(false); // Désactiver le bouton
                return false;
            }

            // Aucune erreur, réinitialiser le message d'erreur et activer le bouton
            displayErrorMessage('');
            toggleConfirmationButton(true); // Activer le bouton
            showConfirmationMessage(); // Afficher le message
            calculateAndDisplayPrice();
            event.preventDefault(); // Empêcher le rechargement de la page par défaut 5ater kent thezni lpage
            return true;
        }

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
    </script>

   
</body>
</html>
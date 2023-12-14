<?php
session_start();
// Check if user is not logged in, redirect to index.php
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

try {
    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate and secure the car ID
    $id_voiture = isset($_GET['id']) ? $_GET['id'] : null;

    // SQL query to retrieve car details
    $sqlQuery = "SELECT * FROM voiture WHERE id = :id";
    $requete = $db->prepare($sqlQuery);
    $requete->bindParam(':id', $id_voiture);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    $db = null;

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

// Check if the car is found
if (!$resultat) {
    // Handle the case where the car is not found
    die('Car not found');
}

// Generate the full path of the image
$cheminDossierImages = 'assets/';
$nomFichierImage = $resultat['image'];
$cheminCompletImage = $cheminDossierImages . $nomFichierImage;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la voiture</title>
    <!-- Ajoutez ici vos balises meta, styles, etc. -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Ajoutez votre CSS personnalisé ici si nécessaire */
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .details-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .details-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .btn-danger,
        .btn-return {
            width: 100%;
            margin-top: 10px;
        }

        .btn-return {
            background-color: #007bff;
            color: white;
        }

        .btn-return:hover {
            background-color: #0056b3;
        }

        .btn-danger:hover {
            background-color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="details-container">
        <h2>Car Details</h2>

        <p>Modèle: <?php echo $resultat['modele']; ?></p>
        <p>Marque: <?php echo $resultat['marque']; ?></p>
        <p>Année: <?php echo $resultat['annee']; ?></p>
        <p>Couleur: <?php echo $resultat['couleur']; ?></p>
        <p>Prix journalier: <?php echo $resultat['prix_journalier']; ?> €</p>
        <!-- Autres détails de la voiture -->

        <!-- Affichage de l'image de la voiture -->
        <img src="<?php echo $cheminCompletImage; ?>" alt="Image de la voiture">

        <!-- Bouton pour supprimer la voiture -->
        <a href="supprimer.php?id=<?php echo $resultat['id']; ?>" class="btn btn-danger">Delete Car</a>
        <a href="listVoiture.php?id=<?php echo $resultat['id']; ?>" class="btn btn-return">Back to Car List</a>
    </div>

    <!-- Ajoutez ici le lien vers Bootstrap JS et les scripts nécessaires -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

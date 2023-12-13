<?php
session_start();
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

try {
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

// Check if the car was found
if (!$resultat) {
    // Handle the case where the car was not found
    die('Car not found');
}

// Generate the full path of the image
$imagesFolder = 'assets/';
$imageFileName = $resultat['image'];
$imageFullPath = $imagesFolder . $imageFileName;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car Details</title>
    <!-- Add your meta tags, styles, etc. here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add your custom CSS here if needed */
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .update-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .update-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary,
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

        .btn-primary:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="update-container">
        <h2>Edit Car Details</h2>

        <!-- Form to update a car -->
        <form action="updateCarProcess.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $resultat['id']; ?>">

            <div class="form-group">
                <label for="modele">Model:</label>
                <input type="text" class="form-control" id="modele" name="modele" value="<?php echo $resultat['modele']; ?>" required>
            </div>

            <div class="form-group">
                <label for="marque">Brand:</label>
                <input type="text" class="form-control" id="marque" name="marque" value="<?php echo $resultat['marque']; ?>" required>
            </div>

            <div class="form-group">
                <label for="annee">Year:</label>
                <input type="text" class="form-control" id="annee" name="annee" value="<?php echo $resultat['annee']; ?>" required>
            </div>

            <div class="form-group">
                <label for="couleur">Color:</label>
                <input type="text" class="form-control" id="couleur" name="couleur" value="<?php echo $resultat['couleur']; ?>" required>
            </div>

            <div class="form-group">
                <label for="prix_journalier">Daily Price:</label>
                <input type="text" class="form-control" id="prix_journalier" name="prix_journalier" value="<?php echo $resultat['prix_journalier']; ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Car Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>

            <button  type="submit" class="btn btn-primary" name="modifier">Update Car</button>
        </form>

        <!-- Add a link to go back to the list of cars -->
        <a href="listVoiture.php" class="btn btn-return">Back to Car List</a>
    </div>

    <!-- Add the link to Bootstrap JS and necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

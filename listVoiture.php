<?php
session_start();
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlQuery = "SELECT * FROM voiture";
    $requete = $db->prepare($sqlQuery);
    $requete->execute();
    $cars = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Fermeture de la connexion à la base de données
    $db = null;

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Voitures</title>
    <!-- Ajoutez ici le lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 20px;
        }

        button {
            padding: 15px 30px;
            font-size: 18px;
            margin: 15px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .car-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .car {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            max-width: 300px;
            background-color: #fff;
            transition: box-shadow 0.3s;
        }

        .car:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .car img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .btn-info,
        .btn-danger ,
        .btn-primary{
            width: 100%;
            margin-top: 10px;
        }

        .btn-info:hover {
            background-color: #0056b3;
        }

        .btn-danger:hover {
            background-color: #d9534f;
        }
        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<div class="container">
        <div class="button-container">
            <!-- Link to go back to admin dashboard -->
            <a href="admin.php" class="btn btn-primary back-btn">Back to  Dashboard</a>
        </div>

    <div class="car-container">
        
        <?php foreach ($cars as $car): ?>
            <div class="car">
            <h3><?php echo $car['marque'] . '<br>' . $car['modele']; ?></h3>

                <img src="assets/<?php echo $car['image']; ?>" alt="Image de la voiture">
                <!-- Lien vers les détails de la voiture -->
                <a href="details_voiture.php?id=<?php echo $car['id']; ?>" class="btn btn-info">Details</a>
                <!-- Bouton pour supprimer la voiture -->
                <a href="supprimer.php?id=<?php echo $car['id']; ?>" class="btn btn-danger">Delete</a>

                <a href="update.php?id=<?php echo $car['id']; ?>" class="btn btn-primary">Update</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Ajoutez ici le lien vers Bootstrap JS et les scripts nécessaires -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

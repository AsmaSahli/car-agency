<?php
session_start();
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: index.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlQuery = "SELECT * FROM user";
    $requete = $db->prepare($sqlQuery);
    $requete->execute();
    $users = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            margin: 50px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        .card {
            margin: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["nom"]; ?></h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User List</h5>
                <p class="card-text">View and manage users.</p>
                <a href="afficheusers.php" class="btn btn-primary">Go to User List</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Car List</h5>
                <p class="card-text">View and manage cars.</p>
                <a href="listVoiture.php" class="btn btn-primary">Go to Car List</a>
                <a href="ajouterVoiture.php" class="btn btn-primary">Add a New car</a>
                
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Bookings</h5>
                <p class="card-text">View and manage bookings.</p>
                <a href="booking.php" class="btn btn-primary">Go to Bookings</a>
            </div>
        </div>

        <!-- Logout button -->
        <form method="post">
            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

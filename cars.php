
<?php
session_start();
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

// Initialize the cars array
$cars = [];

try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if a search query is submitted
    if (isset($_GET['search'])) {
        // Filter cars by brand
        $searchBrand = $_GET['search'];
        $sqlQuery = "SELECT * FROM voiture WHERE marque LIKE :brand";
        $requete = $db->prepare($sqlQuery);
        $requete->bindValue(':brand', '%' . $searchBrand . '%', PDO::PARAM_STR);
    } else {
        // If no search query, retrieve all cars
        $sqlQuery = "SELECT * FROM voiture";
        $requete = $db->prepare($sqlQuery);
    }

    $requete->execute();
    $cars = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Fermeture de la connexion à la base de données
    $db = null;

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .grey-section {
            background-color: #ced4da;
            text-align: center;
            padding: 2px;
            margin-left: 1px;
            margin-right: 1px;
        }


        .white-navbar {
            background-color: #ffffff;
            box-shadow: #000000;
        }

        .form-inline .form-control:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .Ca11 {
            position: relative;
            top: 20%;
            /* Adjust this value to set the distance below the navbar */
            width: 100%;
            height: calc(100% - 20%);
            /* Adjust this value to make the image same size as the container */
            overflow: hidden;
        }

        .Ca11 video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-overlay {
            position: absolute;
            top: 50%;
            left: 0;
            /* Change 'right' to 'left' */
            transform: translate(0, -50%);
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            width: 300px;
            /* Adjust the width as needed */
        }

        .form-overlay form {
            margin-top: 20px;
        }

        .form-overlay input,
        .form-overlay button {
            width: 100%;
            margin-bottom: 10px;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            /* Set minimum height to 100% of the viewport height */
            display: flex;
            flex-direction: column;
        }

        .container-fluid {
            flex: 1;
        }

        .bottom-footer {
            background-color: #ffffff;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;

        }

        /* Additional Styles */
        .bottom-footer input {
            width: 150px;
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
        
        .btn-primary{
            width: 100%;
            margin-top: 10px;
        }

        .btn-info:hover {
            background-color: #0056b3;
        }

       
 
    </style>

    <title>Car Rental Agency</title>
</head>

<body>

    <div class="container-fluid">

        <!-- Grey Section -->
        <div class="row grey-section">
            <div class="col">
                <span>Rent a car and enjoy the open road</span>
            </div>
        </div>

        <!-- White Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
            <a class="navbar-brand" href="index.html">Car Rentals</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cars.php">Cars</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Subscribe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">LOGOUT</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="cars.php" method="GET">
    <input class="form-control mr-sm-2" type="search" placeholder="Search by brand" aria-label="Search" name="search">
    <button class="btn btn-light my-2 my-sm-0" type="submit" style="color: #000000;">Search</button>
</form>
            </div>
        </nav>
       
       

    <div class="car-container">
        
        <?php foreach ($cars as $car): ?>
            <div class="car">
            <h3><?php echo $car['marque'] . '<br>' . $car['modele']; ?></h3>

                <img src="assets/<?php echo $car['image']; ?>" alt="Image de la voiture">
                <!-- Lien vers les détails de la voiture -->
                <a href="details_voiture1.php?id=<?php echo $car['id']; ?>" class="btn btn-info">Details</a>
               

                <a href="formulaire_rant.php?id=<?php echo $car['id']; ?>" class="btn btn-primary">Rent</a>
            </div>
        <?php endforeach; ?>
    </div>





    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
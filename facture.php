<?php
session_start();

if (isset($_SESSION["nom"], $_SESSION["id"])) {
    $id_user = $_SESSION["id"];
    $nom=$_SESSION["nom"];
    $id_car= isset($_GET['id']) ? $_GET['id'] : null;

    $prixTTC = isset($_GET['prixTTC']) ? urldecode($_GET['prixTTC']) : null;
    $drivingLicenseNumber = isset($_GET['drivingLicenseNumber']) ? $_GET['drivingLicenseNumber'] : null;
    
    $pickupDateTime = isset($_GET['pickupDateTime']) ? urldecode($_GET['pickupDateTime']) : null;
    $returnDateTime = isset($_GET['returnDateTime']) ? urldecode($_GET['returnDateTime']) : null;}
    else {
    header("Location: index.php");
    exit();
}

//connexion à la base de données
try
{
$db =new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8',
'root', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

// execution de la requete d insertion
$sqlQuery = "INSERT INTO commands(user_id,car_id,date_deb,date_fin,prixTTC,num_lic_driving)
VALUES('$id_user','$id_car','$pickupDateTime','$returnDateTime','$prixTTC',' $drivingLicenseNumber')";
$requete = $db->prepare($sqlQuery);
$requete->execute();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5; /* Set your desired background color */
        }

        .card {
            background-color: white;
            padding: 80px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            text-align: center;
            width: 80%; /* Set the width as a percentage or in pixels */
        }
    </style>
</head>
<body>
    <div class="card">
        <div style="border-radius: 200px;height:200px;width:200px;background-color:hsl(84, 33%, 97%);margin:0 auto;">
            <img style="width: 188px;" src="https://cdn.pixabay.com/photo/2017/01/13/01/22/ok-1976099_1280.png">
        </div>
        <h2>Rental Reservation Successful</h2>
<strong>Thank you for Choosing Our Car Rental Service</strong>
<h5 style="margin-top:20px; color: green;">Please Pay the Amount of <strong style="color:blue;"><?php echo $prixTTC; ?> €</strong>&nbsp; upon Delivery</h5>

</body>
<script>
        // Utilisez setTimeout pour rediriger après 50 secondes
        setTimeout(function() {
            window.location.href = "cars.php";
        }, 4000);  // 50000 millisecondes équivalent à 50 secondes
    </script>
</html>





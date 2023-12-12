<?php

if (!empty($_POST)) {
    $id_voiture = isset($_GET['id']) ? $_GET['id'] : null;
    $id_user = $_SESSION['user_id'];
    $date_deb = $_POST['pickupDateTime'];
    $date_fin = $_POST['returnDateTime'];
    $prixt = $_POST['prixTTC'];

    try {
        $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $sqlQuery = "INSERT INTO commands(user_id, car_id, date_deb, date_fin, prixTTC)
                 VALUES(:id_user, :id_voiture, :date_deb, :date_fin, :prixt)";
    $requete = $db->prepare($sqlQuery);
    $requete->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $requete->bindParam(':id_voiture', $id_voiture, PDO::PARAM_INT);
    $requete->bindParam(':date_deb', $date_deb, PDO::PARAM_STR);
    $requete->bindParam(':date_fin', $date_fin, PDO::PARAM_STR);
    $requete->bindParam(':prixt', $prixt, PDO::PARAM_STR);
    $requete->execute();

    // You can send a JSON response back to the client if needed
    echo json_encode(['success' => true, 'message' => 'Command added successfully']);
}




?>

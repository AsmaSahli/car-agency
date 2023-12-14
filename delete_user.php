<?php
// delete_user.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    try {
        $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Perform the delete operation
        $sqlQuery = "DELETE FROM user WHERE id = ?";
        $requete = $db->prepare($sqlQuery);
        $requete->execute([$user_id]);

        // Redirect back to the admin page after deletion
        header("Location: afficheusers.php");
        exit();
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>

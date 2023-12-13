<?php
session_start();
if (!isset($_SESSION["nom"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['modifier'])) {
    try {
        $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validate and sanitize the data
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $modele = filter_input(INPUT_POST, 'modele', FILTER_SANITIZE_STRING);
        $marque = filter_input(INPUT_POST, 'marque', FILTER_SANITIZE_STRING);
        $annee = filter_input(INPUT_POST, 'annee', FILTER_SANITIZE_STRING);
        $couleur = filter_input(INPUT_POST, 'couleur', FILTER_SANITIZE_STRING);
        $prix_journalier = filter_input(INPUT_POST, 'prix_journalier', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Check if a new image file is uploaded
        if ($_FILES['image']['error'] === 0) {
            $imageFileName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imagePath = 'assets/' . $imageFileName;

            // Move the uploaded file to the specified folder
            move_uploaded_file($imageTmpName, $imagePath);

            // Update the database record with the new image
            $sqlUpdate = "UPDATE voiture SET modele=?, marque=?, annee=?, couleur=?, prix_journalier=?, image=? WHERE id=?";
            $stmt = $db->prepare($sqlUpdate);
            $stmt->execute([$modele, $marque, $annee, $couleur, $prix_journalier, $imageFileName, $id]);
        } else {
            // Update the database record without changing the existing image
            $sqlUpdate = "UPDATE voiture SET modele=?, marque=?, annee=?, couleur=?, prix_journalier=? WHERE id=?";
            $stmt = $db->prepare($sqlUpdate);
            $stmt->execute([$modele, $marque, $annee, $couleur, $prix_journalier, $id]);
        }

        // Close the database connection
        $db = null;

        // Redirect to the list of cars after updating
        header("Location: listVoiture.php");
        exit();

    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
} else {
    // Handle the case where the form was not submitted properly
    echo "Invalid request.";
}
?>

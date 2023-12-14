<?php
// Check if the form with the name 'ajouter' is submitted
if (isset($_POST['ajouter'])) {
    // Database connection
    try {
        $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve form data
        $modele = $_POST['modele'];
        $marque = $_POST['marque'];
        $annee = $_POST['annee'];
        $couleur = $_POST['couleur'];
        $prix_journalier = $_POST['prix_journalier'];

        // Add other form fields here

        // Image processing
        $uploadDir = 'C:/xampp/htdocs/project/assets/'; // Replace with the actual path on your server
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Check if the file is uploaded successfully
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Insert data into the database
            $sql = "INSERT INTO voiture (modele, marque, annee, couleur, prix_journalier, image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$modele, $marque, $annee, $couleur, $prix_journalier, $_FILES['image']['name']]);

            // Close the database connection
            $db = null;

            // Redirect to the list of cars
            header("Location: ajouterVoiture.php");
            exit();
        } else {
            echo "Error uploading the image.";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<?php
if (isset($_POST['ajouter'])) {
    // Connexion à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération des données du formulaire
        $modele = $_POST['modele'];
        $marque = $_POST['marque'];
        $annee= $_POST['annee'];
        $couleur= $_POST['couleur'];
        $prix_journalier= $_POST['prix_journalier'];
        

        // Ajoutez d'autres champs du formulaire ici

        // Traitement de l'image
        $uploadDir = 'C:/xampp/htdocs/project/assets/';
 // Remplacez par le chemin réel sur votre serveur
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Vérifie si le fichier a été correctement téléchargé
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Insertion des données dans la base de données
            $sql = "INSERT INTO voiture (modele, marque, annee, couleur, prix_journalier, image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$modele, $marque, $annee, $couleur, $prix_journalier, $_FILES['image']['name']]);
           

            // Fermeture de la connexion à la base de données
            $db = null;

            // Redirection vers la liste des voitures
            header("Location: ajouterVoiture.php");
            exit();
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>

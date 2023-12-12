<?php
// Assurez-vous de valider et de sécuriser l'ID de la voiture
$id_voiture = isset($_GET['id']) ? $_GET['id'] : null;

try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour supprimer la voiture
    $sqlQuery = "DELETE FROM voiture WHERE id = :id";
    $requete = $db->prepare($sqlQuery);
    $requete->bindParam(':id', $id_voiture);
    $requete->execute();

    // Fermeture de la connexion à la base de données
    $db = null;

    // Redirigez l'utilisateur vers la liste des voitures après la suppression
    header("Location:listVoiture.php");
    exit();

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

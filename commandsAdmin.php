<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');

    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted for deletion
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];
        $sqlQuery = "DELETE FROM commands WHERE id=$deleteId";
        $requete = $db->prepare($sqlQuery);
        $requete->execute();
    
    }

    $sqlQuery = 'SELECT * FROM commands';
    $requete = $db->prepare($sqlQuery);
    $requete->execute();
    $res = $requete->fetchAll();
} catch (PDOException $e) {
    // Handle database connection or query errors
    die('Erreur : ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Bookings List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .fa-edit{
    color:orange;
}
.fa-trash{
    color: rgb(0, 255, 26)(234, 255, 0);
}
      
    </style>
</head>
<body>
    <h2>Bookings List</h2>
    <table>
        <tr>
            <th>Order Number</th>
            <th>Customer ID </th>
            <th>Car ID</th>
            <th>Pickup Date and Time</th>
            <th>Return Date and Time</th>
            <th>Prix TTC</th>
            <th>Driving License Number</th>
            <th> Delete </th>
            
        </tr>
        <?php foreach ($res as $command): ?>
            <tr>
                <td><?php echo isset($command['id']) ? $command['id'] : ''; ?></td>
                <td><?php echo isset($command['user_id']) ? $command['user_id'] : ''; ?></td>
                <td><?php echo isset($command['car_id']) ? $command['car_id'] : ''; ?></td>
                <td><?php echo isset($command['date_deb']) ? $command['date_deb'] : ''; ?></td>
                <td><?php echo isset($command['date_fin']) ? $command['date_fin'] : ''; ?></td>
                <td><?php echo isset($command['prixTTC']) ? $command['prixTTC'] : ''; ?></td>
                <td><?php echo isset($command['num_lic_driving']) ? $command['num_lic_driving'] : ''; ?></td>
                <td><form method="post" action="">
                        <input type="hidden" name="delete_id" value="<?php echo $command['id']; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                
                </td>
              
            </tr>
            
        <?php endforeach; ?>
    </table>
    <a href="admin.php" class="btn btn-primary">Go Back to Admin Page</a>
   
    

</body>
</html>

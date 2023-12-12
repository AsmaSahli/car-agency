<?php

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>User List</title>
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

      
    </style>
</head>
<body>
    <h2>User List</h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Title</th>
            <th>ID</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Date of Birth</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo isset($user['nom']) ? $user['nom'] : ''; ?></td>
                <td><?php echo isset($user['prenom']) ? $user['prenom'] : ''; ?></td>
                <td><?php echo isset($user['title']) ? $user['title'] : ''; ?></td>
                <td><?php echo isset($user['id']) ? $user['id'] : ''; ?></td>
                <td><?php echo isset($user['email']) ? $user['email'] : ''; ?></td>
                <td><?php echo isset($user['tel']) ? $user['tel'] : ''; ?></td>
                <td><?php echo isset($user['dob']) ? $user['dob'] : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="admin.php" class="btn btn-primary">Go Back to Admin Page</a>
    

</body>
</html>

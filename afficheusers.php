<?php
// Attempt to connect to the MySQL database
try {
    $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select all users from the "user" table
    $sqlQuery = "SELECT * FROM user";
    $requete = $db->prepare($sqlQuery);
    $requete->execute();
    // Fetch all users as associative arrays
    $users = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Display an error message and terminate the script if there's an exception
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add Bootstrap CSS link -->
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
    <!-- Display a heading for the user list -->
    <h2>User List</h2>
    
    <!-- Create a table to display user information -->
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
<!-- Loop through the users and display their information in the table rows -->
<?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo isset($user['nom']) ? $user['nom'] : ''; ?></td>
        <td><?php echo isset($user['prenom']) ? $user['prenom'] : ''; ?></td>
        <td><?php echo isset($user['title']) ? $user['title'] : ''; ?></td>
        <td><?php echo isset($user['id']) ? $user['id'] : ''; ?></td>
        <td><?php echo isset($user['email']) ? $user['email'] : ''; ?></td>
        <td><?php echo isset($user['tel']) ? $user['tel'] : ''; ?></td>
        <td><?php echo isset($user['dob']) ? $user['dob'] : ''; ?></td>
        <td>
            <!-- Add a delete button with a form -->
            <form method="post" action="delete_user.php">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>

    </table>
    
    <!-- Add a button to navigate back to the admin page -->
    <a href="admin.php" class="btn btn-primary">Go Back to Admin Page</a>
</body>
</html>

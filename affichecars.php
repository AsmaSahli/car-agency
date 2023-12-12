<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management System</title>
    <!-- Add the link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            margin-right: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="button-container">
            <!-- Links to different features -->
            <button class="btn btn-primary" onclick="location.href='ajouterVoiture.php'">Add New Car</button>
            <button class="btn btn-primary" onclick="location.href='listVoiture.php'">Car List</button>
            <button class="btn btn-primary" onclick="location.href='admin.php'">Admin Dashboard</button>
        </div>
    </div>

    <!-- Add the link to Bootstrap JS and necessary scripts -->
</body>

</html>

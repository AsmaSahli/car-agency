<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata for character set and viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title of the page -->
    <title>Add a New Car</title>
    <!-- Add the link to Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Internal styling for the page -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff; /* Bootstrap primary color */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Main content container -->
    <div class="container mt-5">
        <!-- Heading for the page -->
        <h2>Add a New Car</h2>

        <!-- Form to add a new car -->
        <form action="ajouterVoitureTraitement.php" method="post" enctype="multipart/form-data">
            <!-- Input field for the car model -->
            <div class="form-group">
                <label for="modele">Model:</label>
                <input type="text" class="form-control" id="modele" name="modele" required>
            </div>

            <!-- Input field for the car brand -->
            <div class="form-group">
                <label for="marque">Brand:</label>
                <input type="text" class="form-control" id="marque" name="marque" required>
            </div>

            <!-- Input field for the car year -->
            <div class="form-group">
                <label for="annee">Year:</label>
                <input type="text" class="form-control" id="annee" name="annee" required>
            </div>

            <!-- Input field for the car color -->
            <div class="form-group">
                <label for="couleur">Color:</label>
                <input type="text" class="form-control" id="couleur" name="couleur" required>
            </div>

            <!-- Input field for the car daily price -->
            <div class="form-group">
                <label for="prix_journalier">Daily Price:</label>
                <input type="text" class="form-control" id="prix_journalier" name="prix_journalier" required>
            </div>

            <!-- Input field for uploading the car image -->
            <div class="form-group">
                <label for="image">Car Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>

            <!-- Button to submit the form and add the car -->
            <button type="submit" class="btn btn-primary" name="ajouter">Add Car</button>
        </form>

        <!-- Link to go back to the list of cars in the admin page -->
        <a href="admin.php" class="btn btn-secondary">Back to Car List</a>
    </div>

    <!-- Add the link to Bootstrap JS and necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

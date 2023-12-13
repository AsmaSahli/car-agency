<?php
$host = "localhost";
$user = "root";
$password = "";
$dbName = "car_agency";

session_start();

$data = mysqli_connect($host, $user, $password, $dbName);

if (!$data) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($data, $_POST["signupFirstName"]);
    $prenom = mysqli_real_escape_string($data, $_POST["signupLastName"]);
    $id = mysqli_real_escape_string($data, $_POST["signupID"]);
    $title = mysqli_real_escape_string($data, $_POST["signupTitle"]);
    $email = mysqli_real_escape_string($data, $_POST["signupEmail"]);
    $tel = mysqli_real_escape_string($data, $_POST["signupTelephone"]);
    $dob = mysqli_real_escape_string($data, $_POST["dob"]);
    $password = mysqli_real_escape_string($data, $_POST["signupPassword"]);

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO user (nom, prenom, id, title, email, tel, dob, password, usertype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'user')";
    $stmt = mysqli_stmt_init($data);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, $nom, $prenom, $id, $title, $email, $tel, $dob, $password);
        mysqli_stmt_execute($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the connection
        mysqli_close($data);

        // Display a JavaScript alert
        echo "<script>
                alert('Account created successfully! Click OK to go back to the Home Page');
                window.location.href = 'index.php';
              </script>";
        exit(); // Ensure that the script stops after the JavaScript redirect
    } else {
        // Handle errors here
        echo "Error: " . mysqli_error($data);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        .grey-section {
            background-color: #ced4da;
            text-align: center;
            padding: 2px;
            margin-left: 1px;
            margin-right: 1px;
        }


        .white-navbar {
            background-color: #ffffff;
            box-shadow: #000000;
        }

        .form-inline .form-control:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .Ca11 {
            position: relative;
            top: 20%;
            /* Adjust this value to set the distance below the navbar */
            width: 100%;
            height: calc(100% - 20%);
            /* Adjust this value to make the image same size as the container */
            overflow: hidden;
        }

        .Ca11 video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-overlay {
            position: absolute;
            top: 50%;
            left: 0;
            /* Change 'right' to 'left' */
            transform: translate(0, -50%);
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            width: 300px;
            /* Adjust the width as needed */
        }

        .form-overlay form {
            margin-top: 20px;
        }

        .form-overlay input,
        .form-overlay button {
            width: 100%;
            margin-bottom: 10px;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            /* Set minimum height to 100% of the viewport height */
            display: flex;
            flex-direction: column;
        }

        .container-fluid {
            flex: 1;
        }

        .bottom-footer {
            background-color: #ffffff;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;

        }

        /* Additional Styles */
        .bottom-footer input {
            width: 150px;
        }


.signup-form {
    position: absolute;
    top: 70%; /* Change to 100% to position it below the navbar */
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    max-width: 500px; /* Set a maximum width for the form */
    width: 100%; /* Adjust the width as needed */
    text-align: left;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

/* Update the .signup-form input width */
.signup-form input,
.signup-form select,
.signup-form button {
    width: 100%;
    margin-bottom: 10px;
}

/* Update the .form-group styles to control the input width */
.signup-form .form-group {
    margin-bottom: 10px;
}

/* Additional Styles for responsive design */
@media (max-width: 576px) {
    .signup-form {
        padding: 10px; /* Adjust padding for smaller screens */
    }
}


        
    </style>

    <title>Sign Up - Car Rental Agency</title>
</head>

<body>

    <div class="container-fluid">

       

            <!-- Grey Section -->
            <div class="row grey-section">
                <div class="col">
                    <span>Rent a car and enjoy the open road</span>
                </div>
            </div>

            <!-- White Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
                <a class="navbar-brand" href="index.html">Car Rentals</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">

                        <button class="btn btn-light my-2 my-sm-0" type="submit" style="color: #000000;">Search</button>
                    </form>
                </div>
            </nav>





  <!-- Signup Form -->
  <div class="signup-form">
    <h2>Create an Account</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="signupFirstName">First Name</label>
            <input type="text" class="form-control" id="signupFirstName" name="signupFirstName"
                placeholder="Enter your first name">
        </div>
        <div class="form-group">
            <label for="signupLastName">Last Name</label>
            <input type="text" class="form-control" id="signupLastName" name="signupLastName"
                placeholder="Enter your last name">
        </div>
        <div class="form-group">
            <label for="signupID">ID</label>
            <input type="text" class="form-control" id="signupID" name="signupID"
                placeholder="Enter your ID">
        </div>
        <div class="form-group">
            <label for="signupTitle">Title</label>
            <select class="form-control" id="signupTitle" name="signupTitle">
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
            </select>
        </div>
        <div class="form-group ">
            
                <label for="signupEmail">Email</label>
                <input type="email" class="form-control" id="signupEmail" name="signupEmail"
                    placeholder="Enter your email">
        </div>
        <div class="form-group ">
                <label for="signupTelephone">Telephone</label>
                <input type="tel" class="form-control" id="signupTelephone" name="signupTelephone"
                    placeholder="Enter your telephone">
        
        </div>
        <div class="form-group ">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required class="form-control">
         
        </div>
        <div class="form-group">
            <label for="signupPassword">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="signupPassword"
                placeholder="Choose a password">
        </div>
        <button type="submit" class="btn btn-light">Sign Up</button>
    </form>
</div>

            <!-- Include your existing footer here -->

</div>
<?php
if (!empty($_POST)) {
    $nom = $_POST['signupFirstName'];
    $prenom = $_POST['signupLastName'];
    $id = $_POST['signupID'];
    $title = $_POST['signupTitle'];
    $email = $_POST['signupEmail'];
    $tel = $_POST['signupTelephone'];
    $dob = $_POST['dob'];
    $password = $_POST['signupPassword'];

    try {
        $db = new PDO('mysql:host=localhost;dbname=car_agency;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sqlQuery = "INSERT INTO user(nom, prenom, id, title, email, tel, dob, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $requete = $db->prepare($sqlQuery);
        $requete->execute([$nom, $prenom, $id, $title, $email, $tel, $dob, $password]);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>

  





</body>

</html>


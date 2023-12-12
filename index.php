<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "car_agency";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($data, $_POST["nom"]);
    $password = mysqli_real_escape_string($data, $_POST["password"]);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM user WHERE nom=? AND password=?";
    $stmt = mysqli_stmt_init($data);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $nom, $password);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $_SESSION["nom"] = $nom;

            if ($row["usertype"] == "user") {
                header("Location: cars.php");
            } elseif ($row["usertype"] == "admin") {
                header("Location: admin.php");
            }
        } else {
            echo "Invalid username or password";
        }

        mysqli_stmt_close($stmt);
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
      left:6%;
      /* Change 'right' to 'left' */
      transform: translate(0, -50%);
      background-color: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
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
      padding: 5px;
      width: 100%;
    }

    /* Additional Styles */
    .bottom-footer input {
      width: 150px;
    }
    /* Your existing styles */

/* Additional Styles for Signup Link */
.form-overlay a {
  color: #ffffff; 
  font-size: 14px; /* Small font size */
  text-decoration: none; /* Remove underline */
}

.form-overlay a:hover {
  text-decoration: underline; /* Underline on hover */
}

  </style>

  <title>Car Rental Agency</title>
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
      <a class="navbar-brand" href="index.php">Car Rentals</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Subscribe</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">

          <button class="btn btn-light my-2 my-sm-0" type="submit" style="color: #000000;">Search</button>
        </form>
      </div>
    </nav>

    <div class="Ca11">
      <video width="1440" height="521" autoplay muted loop style="max-height: 521px ; object-fit: cover;">
        <source src="assets/pexels-roman-odintsov-5658932 (720p).mp4" type="video/mp4">
      </video>
    </div>
<!-- Form Overlay -->
<div class="form-overlay">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <!-- Login Form -->
    <div class="form-group">
    <h4 style="color: white; text-align: center;">Login</h4>
      <label for="username" style="color:white">Username</label>
      <input type="text" class="form-control" id="username" name="nom" placeholder="Enter your username">
    </div>
    <div class="form-group">
      <label for="password" style="color:white">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
    </div>
    <div class="form-group">
      <a href="signup.php" >Don't have an account? Sign up here.</a>
    </div>
    <button type="submit" class="btn btn-light">Login</button>
  </form>
</div>

    <!-- Promotions Section -->
    <div class="row mt-5">
      <div class="col text-center">
        <h3>PROMOTIONS</h3> <br>
        <h4>Discover our vehicles</h4>
        <div id="promotions-carousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <!-- Add your carousel items here -->
            <div class="carousel-item active">
              <!-- First set of images -->
              <div class="d-flex">
                <div class="p-2 flex-fill"><img src="assets/1.png" class="img-fluid"
                    alt="Promotion 1"></div>
                <div class="p-2 flex-fill"><img src="assets/2.png" class="img-fluid"
                    alt="Promotion 2"></div>
                <div class="p-2 flex-fill"><img src="assets/3.png" class="img-fluid"
                    alt="Promotion 3"></div>
              </div>
            </div>
            <div class="carousel-item">
              <!-- Second set of images -->
              <div class="d-flex">
                <div class="p-2 flex-fill"><img src="assets/4.png" class="img-fluid"
                    alt="Promotion 4"></div>
                <div class="p-2 flex-fill"><img src="assets/5.png" class="img-fluid"
                    alt="Promotion 5"></div>
                <div class="p-2 flex-fill"><img src="assets/6.png" class="img-fluid"
                    alt="Promotion 6"></div>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#promotions-carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#promotions-carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>


    <!-- Bottom Footer -->
    <footer class="bottom-footer">
      <div class="container">
        <div class="row">
          <!-- Left Section -->
          <div class="col-md-6">
            <p class="mb-0">Follow us</p>
            <!-- Font Awesome Icons -->
           
            <a href="#" class="text-dark mr-3"><img src="assets/instagram (1).svg" alt=""
                style="height: 20px; width: 20px;"></a>
            <a href="#" class="text-dark"><img src="assets/facebook (3).svg" alt="" style="height: 20px; width: 20px;"></a>
          </div>

          <!-- Right Section -->
          <div class="col-md-6">
            <div class="input-group">
              <!-- Email Subscription Input -->
              <input type="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <!-- Subscribe Button -->
                <button class="btn btn-light" type="button">Subscribe</button>
              </div>
            </div>
            <p class="mt-2">Stay Updated! Get Exclusive Deals and Offers. Sign up Now!</p>
          </div>
        </div>
      </div>
    </footer>

  </div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
<?php
if (session_status() == PHP_SESSION_NONE) {
  // Start the session only if it's not already started
  session_start();
}
?>
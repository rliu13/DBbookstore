
<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
<?php
session_start();
require 'vendor/autoload.php'; // Include Composer's autoloader
// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Access environment variables
$servername = $_ENV['DB_SERVERNAME'];
$database = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
            
// get the ISBN parameter from the URL
$isbn = $_GET['isbn'];

// connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// query the reviews table with the ISBN parameter
$sql = "SELECT * FROM reviews WHERE isbn = '$isbn'";
$result = $conn->query($sql);
// query the books table with the ISBN parameter
$sql2 = "SELECT title FROM Books WHERE isbn = '$isbn'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>BOOK REVIEWS - 3-B.com</title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

        <div class="container-fluid">
			<div class="standard-container bg-white shadow">
				<h1 class="h3 mb-3 fw-normal">Reviews for: <?php echo($row2["title"]) ?></h1>
				<div class="reviews-container">
<?php

    // output the reviews for the selected book
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="row">';
            echo '<div class="col">';
            echo $row["reviewText"];
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No reviews found.";
    }

    // close database connection
    $conn->close();
    header("Cache-Control: no cache");
    session_cache_limiter("private_no_expire");
?>
				<div class="text-center">
					<a class="btn btn-md btn-primary"  onclick="document.location.href='process3.php'">Done</a>
                		</div>
			</div>
		</div>

		<?php include("./view/footer.php"); ?>

	</body>
</html>

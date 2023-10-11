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


// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
echo "error";

    $username = $_SESSION['username'];
	$pin = $_POST['pin'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
    $cardProvider = $_POST['cardProvider'];
    $cardNum = $_POST['cardNum'];
    $ccExp = $_POST['ccExp'];
 
	$sql = "UPDATE users SET pin='$pin',fname='$fname',lname='$lname',address='$address',city='$city',state='$state',zip='$zip',
            cardProvider='$cardProvider',cardNum='$cardNum',ccExp='$ccExp' WHERE username='$username'";
  

    $result = $conn->query($sql);
  
    
if ($result) {
    $conn->close();
    echo "<script>
    alert('You have successfully updated your profile');
    window.location.href='confirm_order.php';
    </script>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


?>
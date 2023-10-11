<?php

require 'vendor/autoload.php'; // Include Composer's autoloader

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Access environment variables
$servername = $_ENV['DB_SERVERNAME'];
$database = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];


session_start();
if(isset($_POST['username'])){
   
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['pin'] = $_POST['pin'];
	
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
  

  $username = $_POST['username'];
  $pin = $_POST['pin'];
	
  $sql = "SELECT username FROM users WHERE username = '$username' AND pin = '$pin' ";
  $result = $conn->query($sql); 
  if ($result->num_rows > 0) {
    header('Location: http://198.211.110.204/screen2.php');
  }
  else {
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
    echo "<script>
    alert('User or pin incorrect');
    window.location.href='user_login.php';
    </script>";
  }



$conn->close();

?>
<html>
<p><a href="user_login.php">return</a></p>
</html>
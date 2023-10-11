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

if(isset($_POST['adminName'])){
   
	$name = $_POST['adminName'];
	$pin = $_POST['adminPin'];
	
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
  
	
  $sql = "SELECT * FROM admin WHERE admin_name = '$name' AND admin_pin = '$pin' ";
  $result = $conn->query($sql); 

  if ($result->num_rows > 0) {
    session_destroy();
    header('Location: http://198.211.110.204/admin_tasks.php');
  }
  else {

    echo "<script>
    alert('User or pin incorrect');
    window.location.href='admin_login.php';
    </script>";
  }



$conn->close();

?>
<html>
<p><a href="user_login.php">return</a></p>
</html>
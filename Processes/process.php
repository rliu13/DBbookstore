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

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
echo "<script>
alert('Username already exists');
window.location.href='customer_registration.php';
</script>";

  $username = $_POST['username'];
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
 
	$sql = "INSERT INTO users VALUES ('$username','$fname','$lname','$address','$city','$state','$zip','$pin','$cardProvider','$cardNum','$ccExp')";
  //$sql2 = "INSERT INTO user_payment VALUES ('$cardNum','$username','$ccExp','$cardProvider')";

  $result = $conn->query($sql);
 // $result2 = $conn->query($sql2);  

if ($result) {
  echo "New record created successfully";
  $conn->close();
  echo "<script>
  alert('You have successfully signed up');
  window.location.href='user_login.php';
  </script>";
  header('Location: http://198.211.110.204/user_login.php');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


?>
<html>
<p><a href="customer_registration.php">return</a></p>
</html>
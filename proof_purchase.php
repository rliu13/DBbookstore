
<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
<?php
require 'vendor/autoload.php'; // Include Composer's autoloader
session_start();

//check which radio button is checked
if($_POST['flexRadioDefault']=="button2"){
	$_SESSION["cardProvider"] = $_POST["ccProvider"];
	$_SESSION["cardNum"] = $_POST["ccNum"];
}

// Calculate cart subtotal
$subtotal = 0;
foreach ($_SESSION['cart'] as $isbn => $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

// Calculate cart shipping
$shipping = 0;
foreach ($_SESSION['cart'] as $isbn => $item) {
    $shipping += 2 * $item['quantity'];
}

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

date_default_timezone_set('America/New_York');
$date = date("m/d/y");
$date2 = date("Y-m-d");
$time = date("h:i:s");
$username = $_SESSION['username'];
$total = number_format($shipping+$subtotal, 2);



$sql = "INSERT INTO orders(username,total,date_paid) VALUES ('$username',$total,'$date2')";


$result = $conn->query($sql);


if ($result) {
$conn->close();
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

<!DOCTYPE HTML>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>PROOF OF PURCHASE</title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

		<div class="container-fluid">
			<div class="standard-container bg-white shadow">
				<h1 class="h3 mb-3 fw-normal">Proof of Purchase</h1>
				<div class="row">
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12">
							<?php echo($_SESSION['fname']." ".$_SESSION['lname']); ?>
							</div>
							<div class="col-md-12">
								<?php echo($_SESSION['address']); ?>
							</div>
							<div class="col-md-12">
							<?php echo($_SESSION['city']); ?>
							</div>
							<div class="col-md-6">
							<?php echo($_SESSION['state']); ?>
							</div>
							<div class="col-md-6">
							<?php echo($_SESSION['zip']); ?>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-5 text-end">
								<b>User ID:</b>
							</div>
							<div class="col-md-6">
							<?php echo($_SESSION['username']); ?>
							</div>
							<div class="col-md-5 text-end">
								<b>Date:</b>
							</div>
							<div class="col-md-6">
							<?php echo($date); ?>
							</div>
							<div class="col-md-5 text-end">
								<b>Time:</b>
							</div>
							<div class="col-md-6">
							<?php echo($time); ?>
							</div>
							<br/>
							<br/>
							<div class="col-md-12 text-center">
								<b>Credit Card Information:</b>
							</div>
							<div class="col-md-12 text-center">
							<?php echo($_SESSION['cardProvider']." ".$_SESSION['cardNum']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="cart-container">
				<div class="row head">
				<div class="col-md-9">
					Book Description
				</div>
				<div class="col-md-1 text-center">
					Qty
				</div>
				<div class="col-md-2 text-end">
					Price
				</div>
				</div>
				<div class="body">
				<?php foreach ($_SESSION['cart'] as $isbn => $item) { ?>
					<div class="row">
					<div class="col-md-9">
						<p>
						<?php echo $item['title']; ?><br/>
						<b>By:</b> <?php echo $item['author']; ?><br/>
						<b>Price:</b> $<?php echo number_format($item['price'], 2); ?>
						</p>
					</div>
					<div class="col-md-1 text-center">
						<?php echo $item['quantity']; ?>
					</div>
					<div class="col-md-2 text-end">
						$<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
					</div>
					</div>
				<?php } ?>
				</div>
				</div>
			
				<div class="row">
					<div class="col-md-5">
						<p class="shipping-note"><b>SHIPPING NOTE:</b> The books will be delivered within 5 business days.</p>
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-7 text-end">
								<b>Subtotal:</b>
							</div>
							<div class="col-md-5">
							</b> $<?php echo number_format($subtotal, 2); ?>
							</div>
							<div class="col-md-7 text-end">
								<b>Shipping & Handling:</b>
							</div>
							<div class="col-md-5">
							$<?php echo number_format($shipping, 2); ?>
							</div>
							<div class="col-md-12">
								<hr>
							</div>
							<div class="col-md-7 text-end">
								<b>Total:</b>
							</div>
							<div class="col-md-5">
								$<?php echo number_format($shipping+$subtotal, 2); ?>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-4">
						<a class="btn btn-md btn-warning" href="index.php">Exit 3-B.com</a>
					</div>
					<div class="col-md-4 text-center">
						<a class="btn btn-md btn-secondary" href="#">Print</a>
					</div>
					<div class="col-md-4 text-end">
						<a class="btn btn-md btn-primary" href="screen2.php">New Search</a>
					</div>
				</div>
			</div>
		</div>

		<?php include("./view/footer.php"); ?>
		<?php unset($_SESSION['cart']); ?>

	</body>
</HTML>

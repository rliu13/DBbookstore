
<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
<?php 
session_start(); 

if(!isset($_SESSION['username'])){
   
	echo "<script>
    alert('You must register before placing an order');
    window.location.href='customer_registration.php';
    </script>";
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

$servername   = "localhost";
$database = "cosc471";
$username = "root";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}



$username = $_SESSION['username'];
  
$sql = "SELECT * FROM users WHERE username = '$username'";


// Execute the query and fetch the result into an associative array
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$_SESSION["fname"] = $row["fname"];
$_SESSION["lname"] = $row["lname"];
$_SESSION["address"] = $row["address"];
$_SESSION["city"] = $row["city"];
$_SESSION["state"] = $row["state"];
$_SESSION["zip"] = $row["zip"];
$_SESSION["cardProvider"] = $row["cardProvider"];
$_SESSION["cardNum"] = $row["cardNum"];


$conn->close();

?>
<!DOCTYPE HTML>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">	
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>CONFIRM ORDER</title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

		<div class=container-fluid>
			<div class="standard-container bg-white shadow">
				<h1 class="h3 mb-3 fw-normal">Confirm Order</h1>
				<div class="row">
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12">
							<?php	echo($row["fname"]." ".$row["lname"] ) ?>
							</div>
							<div class="col-md-12">
							<?php	echo($row["address"]) ?>
							</div>
							<div class="col-md-12">
							<?php	echo($row["city"]) ?>
							</div>
							<div class="col-md-6">
							<?php	echo($row["state"]) ?>
							</div>
							<div class="col-md-6">
							<?php	echo($row["zip"]) ?>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="row">
						<form action="proof_purchase.php" method="POST">
							<div class="col-md-12">
								<input class="form-check-input" type="radio" name="flexRadioDefault" value="button1" id="flexRadioDefault1" checked>
								<label class="form-check-label" for="flexRadioDefault1">
									Use Credit Card on file
								</label>
							</div>
							<div class="col-md-12">
							<?php	echo($row["cardProvider"]." ".$row["cardNum"] ) ?>
							</div>
							<div class="col-md-12">
								<input class="form-check-input" type="radio" name="flexRadioDefault" value="button2" id="flexRadioDefault2">
								<label class="form-check-label" for="flexRadioDefault2">
									New Credit Card
								</label>
							</div>
							<div class="col-md-5">
								<select id="inputCardType" name="ccProvider" class="form-select">
									<option selected disabled>Choose...</option>
									<option value="Discover">Discover</option>
									<option value="Mastercard">MasterCard</option>
									<option value="Visa">Visa</option>
								</select>
							</div>
							<div class="col-md-7">
								<input name="ccNum" class="form-control" id="inputCardNum" placeholder="Enter credit card number">
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
					<div class="col-md-3">
						<a class="btn btn-md btn-warning" href="screen2.php">Cancel</a>
					</div>
					<div class="col-md-6 text-center">
						<a class="btn btn-md btn-secondary" href="update_customerprofile.php">Update Customer Profile</a>
					</div>
					<div class="col-md-3 text-end">
						<button type="submit" class="btn btn-md btn-primary" href="#">Place Order</button>
					</div>
				</form>
				</div>
			</div>
		</div>

		<?php include("./view/footer.php"); ?>

	</body>
</HTML>


<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
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

session_start();

// // Initialize cart session variable if it doesn't exist
// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = array();
// }


// Add item to cart if "add_to_cart" form was submitted
if (isset($_POST['add_to_cart'])) {
    $isbn = $_POST['isbn'];
    $sql = "SELECT isbn, title, author, publisher, price FROM Books WHERE isbn = $isbn";

    // Execute the query and fetch the result into an associative array
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $title = $row["title"];
    $price = $row["price"]; 
	$author = $row["author"];
	$publisher = $row["publisher"];
    $quantity = 1; // Default quantity is 1
    $_SESSION['cart'][$isbn] = array('title' => $title, 'price' => (float)$price,'author' => $author,'publisher' => $publisher, 'quantity' => $quantity);
	header("Cache-Control: no cache");
    session_cache_limiter("private_no_expire");
    header( "Location: process3.php" );
}

// Remove item from cart if "remove_from_cart" form was submitted
if (isset($_POST['remove_from_cart'])) {
    $isbn = $_POST['isbn'];
    unset($_SESSION['cart'][$isbn]);
}

// Update cart item quantity if "update_quantity" form was submitted
if (isset($_POST['update_quantity'])) {
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $_SESSION['cart'][$isbn]['quantity'] = $quantity;
}
// Calculate cart subtotal
$subtotal = 0;
foreach ($_SESSION['cart'] as $isbn => $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$conn->close();
?>
<!DOCTYPE HTML>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Shopping Cart</title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

		<div class="container-fluid">
			<div class="standard-container bg-white shadow">
					<h1 class="h3 mb-3 fw-normal">Shopping Cart</h1>
					<div class="row">
						<div class="col-md-3">
							<a class="btn btn-md btn-warning" href="index.php">Exit 3-B.com</a>
						</div>
						<div class="col-md-3">
							<a class="btn btn-md btn-secondary" href="screen2.php">New Search</a>
						</div>
						<div class="col-md-6 text-end">
							<a class="btn btn-md btn-primary" href="confirm_order.php">Proceed to Checkout</a>
						</div>
					</div>
					<div class="cart-container">
    <div class="row head">
        <div class="col-md-2">
            Remove
        </div>
        <div class="col-md-7">
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
                <div class="col-md-2">
                    <form method="post">
                        <input type="hidden" name="isbn" value="<?php echo $isbn; ?>">
                        <button type="submit" name="remove_from_cart" class="btn btn-md btn-danger">Delete</button>
                    </form>
                </div>
                <div class="col-md-7">
                    <p>
                        <?php echo $item['title']; ?><br/>
                        <b>By:</b> <?php echo $item['author']; ?><br/>
                        <b>Publisher:</b> <?php echo $item['publisher']; ?><br/>
                        <b>Price:</b> $<?php echo number_format($item['price'], 2); ?>
                    </p>
                </div>
                <div class="col-md-1 text-center">
				<form method="post">
   				 <input type="hidden" name="isbn" value="<?php echo $isbn; ?>">
    			<div class="input-group">
        		<input type="number" name="quantity" class="form-control-plaintext" min="1" autocomplete="off" value="<?php echo $item['quantity']; ?>">
				<button type="submit" name="update_quantity" class="btn btn-md btn-primary">Update</button>
   				 </div>
				</form>

                </div>
                <div class="col-md-2 text-end">
				$<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                </div>
            </div>
			<?php } ?>
    			</div>
				</div>

					<div class="row">
						<div class="col-md-6">
							
						</div>
						<div class="col-md-6 text-end">
							<b>Subtotal:</b> $<?php echo number_format($subtotal, 2); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include("./view/footer.php"); ?>

	</body>
</html>

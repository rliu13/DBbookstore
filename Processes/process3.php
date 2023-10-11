
<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
<?php 
session_start(); 
require 'vendor/autoload.php'; // Include Composer's autoloader

// Initialize cart session variable if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_POST['category'])){
   
	$_SESSION['searchText'] = $_POST['searchText'];
	$_SESSION['category'] = $_POST['category'];
	$_SESSION['searchIn'] = $_POST['searchIn'];
}
?>
<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title> Search Result - 3-B.com </title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

        <div class="container-fluid">
			<div class="standard-container bg-white shadow">
				<h1 class="h3 mb-3 fw-normal">Search Results</h1>
				<div class="row">
					<div class="col-md-6">
					Your shopping cart has <?php echo count($_SESSION['cart']); ?> items
					</div>
					<div class="col-md-6 text-end">
						<a class="btn btn-md btn-primary" href="shopping_cart.php">Manage Shopping Cart</a>
					</div>
				</div>
				<div class="cart-container">
					<div class="row head">
						<div class="col-md-3 text-center">
							Controls
						</div>
						<div class="col-md-7">
							Book Description
						</div>
						<div class="col-md-2 text-end">
							Price
						</div>
					</div>
					<div class="body">
<?PHP

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
//post values
$searchText = $_SESSION['searchText'];
$category = $_SESSION['category'];
$searchIn = $_SESSION['searchIn'];

//transform text input into array
$keywords = explode(",", $searchText);

// Create the WHERE clause
$whereClause = "WHERE";
if ($category != 'All') {
    $whereClause .= " category = '{$category}' AND";
}
$whereClause .= " (";
foreach ($keywords as $keyword) {
    foreach ($searchIn as $field) {
        if ($field == 'anywhere') {
            $whereClause .= " title LIKE '%{$keyword}%' OR author LIKE '%{$keyword}%' OR publisher LIKE '%{$keyword}%' OR";
        } else {
            $whereClause .= " {$field} LIKE '%{$keyword}%' OR";
        }
    }
}
$whereClause = rtrim($whereClause, "OR") . ")";

   
// Create the SQL query
$sql = "SELECT isbn, title, author, publisher, price FROM Books {$whereClause}";

// Execute the query
$result = $conn->query($sql);

// Loop through the result set
while($row = $result->fetch_assoc()) {
    // Output the block for each row
    echo '<div class="row">';
    echo '<div class="col-md-3 text-center">';
	
	echo'<form method="post" action="shopping_cart.php">';
  	echo'<input type="hidden" name="isbn" value="' . $row["isbn"] . '">';
  	echo'<button type="submit" name="add_to_cart" class="btn btn-md btn-primary">Add to Cart</button>';
	echo'</form>';


    echo '<br/>';
    echo '<br/>';
	echo '<a class="btn btn-sm btn-secondary" href="screen4.php?isbn=' . $row["isbn"] . '">Reviews</a>';
    echo '</div>';
    echo '<div class="col-md-7">';
    echo '<p>';
    echo $row["title"] . '<br/>';
    echo '<b>By:</b> ' . $row["author"] . '<br/>';
    echo '<b>Publisher:</b> ' . $row["publisher"] . '<br/>';
    echo '<b>ISBN:</b> ' . $row["isbn"] . '<br/>';
    echo '</p>';
    echo '</div>';
    echo '<div class="col-md-2 text-end">';
    echo $row["price"];
    echo '</div>';
    echo '</div>';
    
}

// Close the connection
$conn->close();
?>

				<div class="row">
					<div class="col-md-3">
						<a class="btn btn-md btn-warning" href="index.php">Exit 3-B.com</a>
					</div>
					<div class="col-md-4">
						<a class="btn btn-md btn-secondary" href="screen2.php">New Search</a>
					</div>
					<div class="col-md-5 text-end">
						<a type="submit" class="btn btn-md btn-primary" href="confirm_order.php">Proceed to Checkout</a>
					</div>
				</div>
			</div>
		</div>

		<?php include("./view/footer.php"); ?>

	</body>
</html>

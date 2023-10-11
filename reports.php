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
  

  $username = $_POST['username'];
  $pin = $_POST['pin'];
  
  // get number of users
  $sql = "SELECT COUNT(*) as num_users FROM users";
  $result = $conn->query($sql); 
  $row = $result->fetch_assoc();
  $num_users =  $row['num_users']; 

// Get number of titles in each category
$sql2 = "SELECT category, COUNT(DISTINCT title) AS title_count
FROM Books
GROUP BY category
ORDER BY title_count DESC";
$result2 = $conn->query($sql2);
 

// Execute the SQL query
$sql3 = "SELECT DATE_FORMAT(date_paid, '%Y-%m') AS month, AVG(total) AS avg_sales 
        FROM orders 
        WHERE YEAR(date_paid) = YEAR(CURRENT_DATE())
        GROUP BY month 
        ORDER BY month";

$result3 = $conn->query($sql3);

// Run the SQL query
$sql4 = "SELECT b.title, COUNT(r.reviewID) AS num_reviews
        FROM Books b
        LEFT JOIN reviews r ON b.isbn = r.isbn
        GROUP BY b.title";
$result4 = $conn->query($sql4);
?>
<html>
<p>Number of registered customers: <?php echo($num_users) ?></p>

<table>
<tr>
    <th>Category</th>
    <th>Number of Titles</th>
</tr>
<?php while($row2 = $result2->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row2["category"] ?></td>
    <td><?php echo $row2["title_count"] ?></td>
</tr>
<?php } ?>
</table>

</br>
<table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Average Sales</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row3 = $result3->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row3["month"]; ?></td>
                    <td><?php echo "$" . number_format($row3["avg_sales"], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </br>            
    <table>
        <tr>
            <th>Title</th>
            <th>Number of Reviews</th>
        </tr>
        <?php while($row4 = $result4->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row4["title"]; ?></td>
                <td><?php echo $row4["num_reviews"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</html>

<?php $conn->close(); ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, productname, price FROM product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "รายการ: " . $row["id"]. " - ชื่อเมนู: " . $row["productname"]. " ราคา: " . $row["price"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
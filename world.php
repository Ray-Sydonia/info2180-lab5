<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
  // Establish a database connection
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch the 'country' GET variable
  $country = isset($_GET['country']) ? $_GET['country'] : '';

  if ($country) {
      // Query for a specific country or matching countries
      $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
      $stmt->execute([':country' => '%' . $country . '%']);
  } else {
      // Query for all countries if no country is specified
      $stmt = $conn->query("SELECT * FROM countries");
  }

  // Fetch results
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Output the results
  if (!empty($results)) {
      echo "<ul>";
      foreach ($results as $row) {
          echo "<li>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['continent']) . " - " . htmlspecialchars($row['independence_year']) . "</li>";
      }
      echo "</ul>";
  } else {
      echo "No results found.";
  }
} catch (PDOException $e) {
  // Handle connection errors
  echo "Error: " . $e->getMessage();
}
?>


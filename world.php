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

  // Output the results as an HTML table
  if (!empty($results)) {
    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
        echo "<td>" . htmlspecialchars($row['independence_year'] ? $row['independence_year'] : 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['head_of_state'] ? $row['head_of_state'] : 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "No results found.";
}

} catch (PDOException $e) {
// Handle connection errors
echo "Error: " . $e->getMessage();
}
?>


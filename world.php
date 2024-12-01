<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
  // Establish a database connection
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Get the query parameters
  $country = isset($_GET['country']) ? $_GET['country'] : '';
  $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : 'country';

  if ($lookup === 'cities') {
      // Query to get cities in the specified country
      $stmt = $conn->prepare("
          SELECT cities.name AS city_name, cities.district, cities.population 
          FROM cities 
          JOIN countries ON cities.country_code = countries.code 
          WHERE countries.name LIKE :country
      ");
      $stmt->execute([':country' => '%' . $country . '%']);
  } else {
      // Query to get country details
      $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
      $stmt->execute([':country' => '%' . $country . '%']);
  }

  // Fetch results
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Output as HTML table
  if (!empty($results)) {
      echo "<table border='1'>";
      echo "<thead>";
      if ($lookup === 'cities') {
          echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
          foreach ($results as $row) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['district']) . "</td>";
              echo "<td>" . htmlspecialchars(number_format($row['population'])) . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";
          foreach ($results as $row) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
              echo "<td>" . htmlspecialchars($row['independence_year'] ? $row['independence_year'] : 'N/A') . "</td>";
              echo "<td>" . htmlspecialchars($row['head_of_state'] ? $row['head_of_state'] : 'N/A') . "</td>";
              echo "</tr>";
          }
      }
      echo "</thead>";
      echo "</table>";
  } else {
      echo "No results found.";
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>


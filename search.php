<

  <?php
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", " ", "javatpoint");

  // Retrieve search query parameters
  $name = isset($_GET['name']) ? $_GET['name'] : '';
  $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
  $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : PHP_FLOAT_MAX;

  // Prepare the SQL statement with placeholders for the search parameters
  $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE name LIKE ? AND price BETWEEN ? AND ?");

  // Bind parameters to the prepared statement
  $search_name = "%" . mysqli_real_escape_string($conn, $name) . "%";
  mysqli_stmt_bind_param($stmt, "sdd", $search_name, $min_price, $max_price);

  // Execute the prepared statement
  mysqli_stmt_execute($stmt);

  // Retrieve the query results
  $result = mysqli_stmt_get_result($stmt);

  // Display the search results with product images
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>";
    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
    echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' />";
    echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
    echo "</div>";
  }

  // Close the statement and the database connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  ?>


<!DOCTYPE html>
<html>
<head>
    <title>Selected City Data</title>
    <style>
        table { width: 70%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #5dade2; }
    </style>
</head>
<body>

<h2 style="text-align:center;">AQI Data for Selected Cities</h2>

<?php
if (isset($_POST['cities']) && is_array($_POST['cities'])) {
    $selectedCities = $_POST['cities'];

    if (count($selectedCities) > 10) {
        echo "<p style='text-align:center;color:red;'>You can select up to 10 cities only.</p>";
        exit;
    }

    $con = mysqli_connect("localhost", "root", "", "aqi");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare query
    $placeholders = implode(',', array_fill(0, count($selectedCities), '?'));
    $stmt = mysqli_prepare($con, "SELECT City, Country, AQI FROM info WHERE City IN ($placeholders)");

    // Bind params dynamically
    $types = str_repeat('s', count($selectedCities));
    mysqli_stmt_bind_param($stmt, $types, ...$selectedCities);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    echo "<table>";
    echo "<tr><th>City</th><th>Country</th><th>AQI</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['City']}</td><td>{$row['Country']}</td><td>{$row['AQI']}</td></tr>";
    }
    echo "</table>";

    mysqli_close($con);
} else {
    echo "<p style='text-align:center;'>No cities selected.</p>";
}
?>

</body>
</html>

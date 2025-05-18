<!DOCTYPE html>
<html>
<head>
    <title>Select Cities</title>
    <style>
        body { text-align: center; font-family: Arial; }
        form { display: inline-block; margin-top: 30px; }
        .city-list { text-align: left; max-height: 300px; overflow-y: auto; }
    </style>
    <script>
        function limitCheckboxes(limit) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    let checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
                    checkboxes.forEach(box => {
                        if (!box.checked) box.disabled = checked >= limit;
                        else box.disabled = false;
                    });
                });
            });
        }

        window.onload = function () {
            limitCheckboxes(10); // Limit to 10 checkboxes
        };
    </script>
</head>
<body>

<h2>Select up to 10 Cities</h2>
<form method="POST" action="show.php">
    <div class="city-list">
        <?php
        $con = mysqli_connect("localhost", "root", "", "aqi");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = mysqli_query($con, "SELECT DISTINCT City FROM info LIMIT 20");
        while ($row = mysqli_fetch_assoc($result)) {
            $city = htmlspecialchars($row['City']);
            echo "<label><input type='checkbox' name='cities[]' value='$city'> $city</label><br>";
        }

        mysqli_close($con);
        ?>
    </div>
    <br>
    <input type="submit" value="Show Data">
</form>

</body>
</html>

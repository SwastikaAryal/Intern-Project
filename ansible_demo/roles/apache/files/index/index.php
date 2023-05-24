<!DOCTYPE html>
<html>
<head>
    <title>Insert user</title>
</head>
<body>
<?php
        $ip_address = $_SERVER['SERVER_ADDR'];
        ?>
        <p>IP Address: <?php echo $ip_address; ?></p>

    <h1>Insert User Details</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Name: <input type="text" name="name"><br>
        Email: <input type="email" name="email"><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Database connection
    // Get the IP address of the client

    // Display the IP address
    $servername = "terraform-20230524064706387100000004.c58l01rn1yea.us-east-2.rds.amazonaws.com";
    $username = "terraform";
    $password = "mysql123";
    $dbname = "mydb";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert user
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
        if (mysqli_query($conn, $sql)) {
            echo "User inserted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Show users
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<h1>Users</h1>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Email</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>

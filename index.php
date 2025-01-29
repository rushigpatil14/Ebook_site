<?php

    // Check if the necessary fields are set in the POST request
    if (isset($_POST['YourName'], $_POST['YourEmail'], $_POST['Subject'], $_POST['YourMessage'])) {
        
        // Sanitize the input to avoid XSS or other issues
        $YourName = htmlspecialchars($_POST['YourName']);
        $YourEmail = htmlspecialchars($_POST['YourEmail']);
        $Subject = htmlspecialchars($_POST['Subject']);
        $YourMessage = htmlspecialchars($_POST['YourMessage']);

        // Database connection setup
        $servername = "localhost";  // Your database server
        $username = "root";         // Your database username
        $password = "";             // Your database password
        $dbname = "ebook";  // Your database name

        // Establish connection to the database
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare the SQL query using prepared statements
        $sql = "INSERT INTO contact (YourName, YourEmail, Subject, YourMessage) VALUES (?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters (s for string type)
        mysqli_stmt_bind_param($stmt, "ssss", $YourName, $YourEmail, $Subject, $YourMessage);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    } else {
        echo "All fields are required.";
    }

?>

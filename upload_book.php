<?php
// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "ebook";

// Create a connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $file = $_FILES['file'];

    // File upload directory
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if not exists
    }

    // Generate a unique file name
    $fileName = uniqid() . '-' . basename($file['name']);
    $targetFilePath = $uploadDir . $fileName;

    // Allowed file types
    $allowedTypes = ['application/pdf'];

    if (in_array($file['type'], $allowedTypes)) {
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // Save book info to the database
            $sql = "INSERT INTO books (title, author, file_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $title, $author, $targetFilePath);

            if ($stmt->execute()) {
                echo "Book uploaded successfully!";
            } else {
                echo "Error saving book to database: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only PDF files are allowed.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>

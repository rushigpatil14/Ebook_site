<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

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

// Handle book upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['book_file'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $file = $_FILES['book_file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $filePath = $targetDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Save book info to the database
            $stmt = $conn->prepare("INSERT INTO books (title, author, file_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $author, $filePath);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('Book uploaded successfully!');</script>";
        } else {
            echo "<script>alert('Failed to upload book file.');</script>";
        }
    }
}

// Handle book deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Book deleted successfully!');</script>";
}

// Fetch all books
$result = $conn->query("SELECT * FROM books");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
<header>
        <h1>Admin Dashboard</h1>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </header>

    <main>
        <section class="upload-section">
            <h2>Upload a New Book</h2>
            <form id="uploadForm">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" required>
                <label for="author">Author</label>
                <input type="text" id="author" name="author" required>
                <label for="file">Book File</label>
                <input type="file" id="file" name="file" accept=".pdf" required>
                <button type="submit">Upload</button>
            </form>
        </section>

        <section class="book-list">
            <h2>Manage Books</h2>
            <table id="bookTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><a href="<?php echo $row['file_path']; ?>" download>Download</a></td>
            <td><a href="admin_dashboard.html?delete_id=<?php echo $row['id']; ?>">Delete</a></td>
        </tr>
        <?php endwhile; ?>
                </thead>
                <tbody>
                    <!-- Books will be dynamically loaded here -->
                </tbody>
            </table>
        </section>
    </main>
   
</body>
</html>
<?php $conn->close(); ?>

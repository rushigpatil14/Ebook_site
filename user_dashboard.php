<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
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

// Fetch all books
$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>

<header>
        <h1>Welcome, User</h1>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </header>

    <main>
        <section class="book-list">
            <h2>Available Books</h2>
            <table id="bookTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><a href="<?php echo $row['file_path']; ?>" download>Download</a></td>
        </tr>
        <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script >

document.addEventListener('DOMContentLoaded', () => {
    const bookTable = document.getElementById('bookTable').querySelector('tbody');

    // Fetch and display books
    fetch('fetch_books.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${book.title}</td>
                    <td>${book.author}</td>
                    <td><a href="${book.file_path}" download>Download</a></td>
                `;
                bookTable.appendChild(row);
            });
        });
});

// Logout function
function logout() {
    // Implement logout logic (e.g., clear session and redirect)
    
    alert('Logging out...');
   window.location.href="index.html"
  
}

    </script>

</body>
</html>
<?php $conn->close(); ?>

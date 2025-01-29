<?php
// Start the session
session_start();

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

// Get form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    // Fetch user from the database
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if ($redirect === 'payment' && !empty($book_id)) {
                // Redirect to different pages based on the book_id
                switch ($book_id) {
                    case '299':
                        header("Location: https://buy.stripe.com/test_bIY8zla8LgUV9ws3ci");
                        exit();
                    case '399':
                        header("Location: https://buy.stripe.com/test_28o3f1ep1489cIE14b");
                        exit();
                    case '499':
                        header("Location: https://buy.stripe.com/test_5kA3f1ep1fQR2404go");
                        exit();
                    default:
                        header("Location: error.php?message=InvalidBookID");
                        exit();
                }
            }


            // Redirect based on role or payment context
            if ($user['role'] === 'admin') {
                echo "<script>
                        alert('Welcome Admin!');
                        window.location.href = 'admin_dashboard.php';
                      </script>";
            } else {
                // Check if user is coming from a specific page (e.g., payment page)
                $redirect_to = isset($_SESSION['return_url']) ? $_SESSION['return_url'] : 'user_dashboard.php';
                unset($_SESSION['return_url']); // Clear the return_url session variable

                echo "<script>
                        alert('Login Successful! Redirecting...');
                        window.location.href = '$redirect_to';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Incorrect password. Please try again.');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No user found with that email.');
                window.location.href = 'login.php';
              </script>";
    }
}
$conn->close();
?>

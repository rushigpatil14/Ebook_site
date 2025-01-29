<?php
session_start();

// Capture redirect and book_id from the URL if present
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';
$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eBook Login</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #dfb5e1, #1d60d3);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .login-container {
      background: #fff;
      color: #333;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 14px;
      margin-bottom: 5px;
      display: block;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ddd;
      font-size: 14px;
      outline: none;
      transition: border 0.3s;
    }

    .form-group input:focus {
      border: 1px solid #6a11cb;
      box-shadow: 0 0 8px rgba(106, 17, 203, 0.2);
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      color: #fff;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #2575fc, #6a11cb);
    }

    .login-footer {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #555;
    }

    .login-footer a {
      color: #6a11cb;
      text-decoration: none;
      font-weight: bold;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Welcome Back!</h2>
    <p style="text-align: center; color: #555; margin-bottom: 20px;">
      Please log in to access your eBooks.
    </p>
    <form action="login_process.php" method="POST">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
      <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book_id); ?>">
      <button type="submit" class="btn-login">Login</button>
    </form>
    <div class="login-footer">
      <p>Don't have an account? <a href="signup.html">Sign up</a></p>
    </div>
  </div>
</body>
</html>

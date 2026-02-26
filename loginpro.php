<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    $conn = new mysqli("localhost", "root", "", "lfdb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['userid'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;

            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not registered.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - LilyFlower</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link rel="stylesheet" href="css/common.css">
  <style>
    *{ box-sizing: border-box; }
    body, html {
      margin: 0; padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #ffe6f0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background: deeppink;
      color: white;
      padding: 12px 30px;
      display: flex;
      align-items: center;
      gap: 15px;
      flex-wrap: wrap;
    }
    header img.logo-header { width: 50px; }
    header h1.site-title {
      font-weight: 800;
      font-size: 22px;
      margin: 0;
      flex-grow: 1;
    }
    nav {
      display: flex;
      gap: 20px;
    }
    nav a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.3s ease;
    }
    nav a:hover { color: #ff69b4; }
    main.main-content {
      flex: 1;
      background: #ffc0cb;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }
    .login-box {
      width: 100%;
      max-width: 420px;
      background: #ffeef5;
      padding: 40px 35px;
      border-radius: 18px;
      box-shadow: 0 4px 20px rgba(255, 105, 180, 0.25);
      text-align: center;
    }
    .login-box .logo-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .login-box img.logo { width: 80px; }
    .login-box .brand-name {
      margin: 0;
      color: deeppink;
      font-size: 24px;
      font-weight: 800;
    }
    .login-box h2 {
      color: deeppink;
      font-weight: 700;
      margin-bottom: 25px;
      letter-spacing: 1.5px;
    }
    .login-box form {
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }
    .login-box input {
      padding: 14px 16px;
      margin-bottom: 16px;
      border-radius: 12px;
      border: 2px solid #ffc0cb;
      font-size: 15px;
      transition: border-color 0.3s ease;
    }
    .login-box input:focus {
      outline: none;
      border-color: deeppink;
      box-shadow: 0 0 8px rgba(255, 20, 147, 0.4);
    }
    .show-password-container {
      display: flex;
      align-items: center;
      margin-bottom: 16px;
      font-size: 14px;
      color: deeppink;
      user-select: none;
    }
    .show-password-container input[type="checkbox"] {
      margin-right: 8px;
      cursor: pointer;
    }
    .login-box button {
      background-color: deeppink;
      border: none;
      color: white;
      font-weight: 700;
      padding: 15px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 17px;
      transition: background-color 0.3s ease;
      margin-top: 10px;
    }
    .login-box button:hover {
      background-color: #ff1493;
    }
    .error {
      color: #b22222;
      background-color: #ffe6e6;
      border: 1px solid #b22222;
      padding: 12px;
      margin-bottom: 20px;
      border-radius: 12px;
      text-align: center;
      font-weight: 600;
    }
    .register-link {
      margin-top: 16px;
      font-size: 14px;
    }
    .register-link a {
      color: deeppink;
      font-weight: bold;
      text-decoration: none;
    }
    footer {
      background: #ff1493;
      color: white;
      text-align: center;
      padding: 14px 20px;
      font-size: 14px;
      font-weight: 600;
    }
    @media (max-width: 720px) {
      main.main-content { padding: 20px; }
      .login-box {
        padding: 30px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(255, 105, 180, 0.15);
      }
      .login-box img.logo { width: 60px; }
      header img.logo-header { width: 40px; }
      header h1.site-title {
        font-size: 18px;
        flex-basis: 100%;
      }
      nav {
        flex-basis: 100%;
        justify-content: center;
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>

<header>
  <img src="images/lily.svg" alt="LilyFlower Logo" class="logo-header" />
  <h1 class="site-title">Lily Flower</h1>
</header>

<main class="main-content">
  <div class="login-box">
    <div class="logo-title">
      <img src="images/lily.svg" alt="LilyFlower Logo" class="logo" />
      <h1 class="brand-name">Lily Flower</h1>
    </div>
    <h2>Login</h2>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="" method="post" novalidate>
      <input type="email" name="email" placeholder="Email (@gmail.com only)" required />
      <input id="password" type="password" name="password" placeholder="Password" required />
      <label class="show-password-container">
        <input type="checkbox" id="showPassword" />
        Show Password
      </label>
      <button type="submit">Login</button>
      <p class="register-link">Don't have an account? <a href="registerpro.php">Register</a></p>
    </form>
  </div>
</main>

<footer>
  &copy; <?= date('Y') ?> Lily Flower. All rights reserved.
</footer>

<script>
  const showPasswordCheckbox = document.getElementById('showPassword');
  const passwordInput = document.getElementById('password');
  showPasswordCheckbox.addEventListener('change', function () {
    passwordInput.type = this.checked ? 'text' : 'password';
  });
</script>

</body>
</html>

<?php
include 'db.php'; 

$error = "";

function checkPasswordStrength($password) {
    $strength = 0;
    if (strlen($password) >= 8) $strength++;
    if (preg_match('/[a-z]/', $password)) $strength++;
    if (preg_match('/[A-Z]/', $password)) $strength++;
    if (preg_match('/[0-9]/', $password)) $strength++;
    if (preg_match('/[\W]/', $password)) $strength++;

    if ($strength < 3) {
        return "Weak";
    } elseif ($strength < 5) {
        return "Medium";
    } else {
        return "Strong";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!preg_match('/@gmail\.com$/i', $email)) {
        $error = "Email must be a valid @gmail.com address.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $strength = checkPasswordStrength($password);
        if ($strength === "Weak") {
            $error = "Password is too weak. Use at least 8 characters, mix of uppercase, lowercase, numbers, and symbols.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Email already registered.";
            } else {
              
                $insert = $conn->prepare("INSERT INTO users (username, email, dob, gender, password) VALUES (?, ?, ?, ?, ?)");
                $insert->bind_param("sssss", $username, $email, $dob, $gender, $hashed_password);

                if ($insert->execute()) {
                    header("Location: loginpro.php");
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                }
                $insert->close();
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register - LilyFlower</title>
 <link rel="stylesheet" href="css/common.css">
<style>
  * {
    box-sizing: border-box;
  }

  body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #ffe6f0;
  }

  header {
    background: #ffc0cb;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(255, 105, 180, 0.3);
  }

  header .brand {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  header .brand img {
    width: 50px;
  }

  header .brand .logo {
    font-size: 24px;
    font-weight: 700;
    color: deeppink;
    user-select: none;
  }

  nav a {
    text-decoration: none;
    color: deeppink;
    font-weight: 600;
    margin-left: 25px;
    font-size: 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.3s ease;
  }

  nav a:hover {
    color: #ff1493;
  }

  footer {
    text-align: center;
    padding: 15px 10px;
    background: #ffc0cb;
    color: deeppink;
    font-weight: 600;
    position: fixed;
    bottom: 0;
    width: 100%;
    box-shadow: 0 -2px 8px rgba(255, 105, 180, 0.3);
  }

  .main-content {
    min-height: calc(100vh - 120px);
    background: #ffc0cb;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    padding-bottom: 60px;
  }

  .register-box {
    width: 100%;
    max-width: 420px;
    background: #ffeef5;
    padding: 40px 35px;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(255, 105, 180, 0.25);
    text-align: center;
  }

  .register-box .logo-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
  }

  .register-box img.logo {
    width: 80px;
  }

  .register-box .brand-name {
    margin: 0;
    color: deeppink;
    font-size: 24px;
    font-weight: 800;
  }

  .register-box h2 {
    color: deeppink;
    font-weight: 700;
    margin-bottom: 25px;
    letter-spacing: 1.5px;
  }

  .register-box form {
    display: flex;
    flex-direction: column;
    align-items: stretch;
  }

  .register-box input,
  .register-box select {
    padding: 14px 16px;
    margin-bottom: 6px;
    border-radius: 12px;
    border: 2px solid #ffc0cb;
    font-size: 15px;
    transition: border-color 0.3s ease;
  }

  .register-box input:focus,
  .register-box select:focus {
    outline: none;
    border-color: deeppink;
    box-shadow: 0 0 8px rgba(255, 20, 147, 0.4);
  }

  .register-box button {
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

  .register-box button:hover {
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

  .password-strength {
    margin-bottom: 20px;
    font-weight: 700;
    font-size: 14px;
  }

  .weak {
    color: #b22222;
  }

  .medium {
    color: #ff8c00;
  }

  .strong {
    color: #228b22;
  }

  .show-password {
    text-align: left;
    margin: 8px 0 14px;
    font-size: 14px;
  }

  .login-link {
    margin-top: 16px;
    font-size: 14px;
  }

  .login-link a {
    color: deeppink;
    font-weight: bold;
    text-decoration: none;
  }

  @media (max-width: 720px) {
    .main-content {
      padding: 20px;
    }

    .register-box {
      padding: 30px 20px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(255, 105, 180, 0.15);
    }

    .register-box img.logo {
      width: 60px;
    }

    header nav a {
      margin-left: 15px;
      font-size: 14px;
    }
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<header>
  <div class="brand">
    <img src="images/lily.svg" alt="Lily Flower Logo" />
    <div class="logo">Lily Flower</div>
  </div>
</header>

<main class="main-content">
  <div class="register-box">
    <div class="logo-title">
      <img src="images/lily.svg" alt="LilyFlower Logo" class="logo" />
      <h1 class="brand-name">Lily Flower</h1>
    </div>
    <h2>Create Account</h2>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="" method="post" novalidate>
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email (@gmail.com only)" required />
      <input type="date" name="dob" required />
      <select name="gender" required>
        <option value="" disabled selected>Select Gender</option>
        <option value="female">Female</option>
        <option value="male">Male</option>
      </select>
      <input type="password" id="password" name="password" placeholder="Password" required />
      <div id="password-strength-text" class="password-strength"></div>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
      <label class="show-password"><input type="checkbox" id="toggle-password"> Show Password</label>
      <button type="submit">Register</button>
      <p class="login-link">Already have an account? <a href="loginpro.php">Login</a></p>
    </form>
  </div>
</main>

<footer>
  &copy; 2025 Lily Flower Inventory
</footer>

<script>
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm_password');
  const strengthText = document.getElementById('password-strength-text');
  const togglePassword = document.getElementById('toggle-password');

  passwordInput.addEventListener('input', () => {
    const val = passwordInput.value;
    let strength = 0;

    if (val.length >= 8) strength++;
    if (/[a-z]/.test(val)) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/\d/.test(val)) strength++;
    if (/[\W]/.test(val)) strength++;

    if (val.length === 0) {
      strengthText.textContent = '';
      strengthText.className = 'password-strength';
    } else if (strength < 3) {
      strengthText.textContent = 'Weak';
      strengthText.className = 'password-strength weak';
    } else if (strength < 5) {
      strengthText.textContent = 'Medium';
      strengthText.className = 'password-strength medium';
    } else {
      strengthText.textContent = 'Strong';
      strengthText.className = 'password-strength strong';
    }
  });

  togglePassword.addEventListener('change', () => {
    const type = togglePassword.checked ? 'text' : 'password';
    passwordInput.type = type;
    confirmPasswordInput.type = type;
  });
</script>

</body>
</html>
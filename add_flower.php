<?php
//
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lfdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flower_name = trim($_POST['flower_name']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $description = trim($_POST['description']);

    if (!empty($flower_name) && $quantity >= 0 && $price >= 0) {
        $stmt = $conn->prepare("INSERT INTO inventory (flower_name, quantity, price, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sids", $flower_name, $quantity, $price, $description);

        if ($stmt->execute()) {
            $message = "Flower added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Please fill in all required fields correctly.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Flower - Lily Flower</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    header {
        background-color: #FF69B4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        position: sticky;
        top: 0;
        z-index: 999;
    }
    .brand {
        display: flex;
        align-items: center;
    }
    .brand img {
        height: 50px;
        margin-right: 10px;
    }
    .logo {
        font-family: "Satisfy", cursive;
        font-size: 2rem;
        color: white;
    }
    nav {
        display: flex;
        gap: 20px;
    }
    nav a {
        color: white;
        text-decoration: none;
        font-size: 16px;
    }
    nav a:hover {
        text-decoration: underline;
    }

    /* Body */
    body {
        font-family: 'Quicksand', sans-serif;
        background-color: #FFF0F5;
        margin: 0;
        padding: 20px;
        color: #4B0082;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    h1 {
        text-align: center;
        color: #FF69B4;
        margin-bottom: 30px;
        font-size: 2.2rem;
        font-weight: bold;
    }

    form {
        max-width: 600px;
        margin: 0 auto 60px;
        background: #fff;
        padding: 30px 35px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(255, 105, 180, 0.2);
        transition: box-shadow 0.3s ease;
    }
    form:hover {
        box-shadow: 0 15px 40px rgba(255, 105, 180, 0.35);
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #FF1493;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 14px 18px;
        margin-bottom: 25px;
        border: 2px solid #FFB6C1;
        border-radius: 12px;
        font-size: 1rem;
        color: #4B0082;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus,
    textarea:focus {
        border-color: #FF1493;
        outline: none;
        box-shadow: 0 0 8px #FF1493;
        background-color: #fff0f5;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    button {
        background-color: #FF69B4;
        border: none;
        padding: 14px 30px;
        color: white;
        font-size: 1.15rem;
        font-weight: bold;
        border-radius: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        width: 100%;
        box-shadow: 0 6px 12px rgba(255, 105, 180, 0.4);
    }

    button:hover {
        background-color: #FF1493;
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(255, 20, 147, 0.7);
    }

    .message {
        text-align: center;
        font-weight: bold;
        margin-bottom: 25px;
        font-size: 1.15rem;
    }

    .button-group {
        max-width: 600px;
        margin: 0 auto 60px;
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .button-group a.button-link {
        width: 48%;
        text-align: center;
        text-decoration: none;
        background-color: #FF69B4;
        color: white;
        font-size: 1.15rem;
        font-weight: bold;
        border-radius: 14px;
        padding: 14px 0;
        box-shadow: 0 6px 12px rgba(255, 105, 180, 0.4);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button-group a.button-link:hover {
        background-color: #FF1493;
        transform: scale(1.05);
    }

    footer {
        background-color: #FF69B4;
        color: white;
        text-align: center;
        padding: 15px 0;
        margin-top: auto;
        font-size: 1rem;
    }
  </style>
</head>
<body>

<header>
  <div class="brand">
    <img src="images/lily.svg" alt="Lily Flower Logo" />
    <div class="logo">Lily Flower</div>
  </div>
  <nav>
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
    <a href="boarddash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </nav>
</header>

<h1>Add New Flower</h1>

<?php if (!empty($message)): ?>
  <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="post" action="add_flower.php" autocomplete="off" novalidate>
  <label for="flower_name">Flower Name:</label>
  <input type="text" id="flower_name" name="flower_name" placeholder="Enter flower name" required />

  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity" min="0" placeholder="Enter quantity" required />

  <label for="price">Price (RM):</label>
  <input type="number" id="price" name="price" step="0.01" min="0" placeholder="Enter price" required />

  <label for="description">Description:</label>
  <textarea id="description" name="description" placeholder="Enter description (optional)" rows="4"></textarea>

  <button type="submit"><i class="fas fa-plus-circle"></i> Add Flower</button>
</form>

<div class="button-group">
  <a href="inventory.php" class="button-link"><i class="fas fa-boxes"></i> View Inventory</a>
  <a href="index.php" class="button-link"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<footer>
  &copy; <?= date("Y") ?> Lily Flower. All rights reserved.
</footer>

</body>
</html>

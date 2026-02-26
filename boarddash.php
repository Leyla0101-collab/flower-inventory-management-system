<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lfdb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$total_items_sql = "SELECT COUNT(*) AS total_items FROM inventory";
$total_items_result = $conn->query($total_items_sql);
$total_items = $total_items_result ? $total_items_result->fetch_assoc()['total_items'] : 0;


$total_quantity_sql = "SELECT SUM(quantity) AS total_quantity FROM inventory";
$total_quantity_result = $conn->query($total_quantity_sql);
$total_quantity = $total_quantity_result ? $total_quantity_result->fetch_assoc()['total_quantity'] : 0;
$total_quantity = $total_quantity ?? 0;


$total_value_sql = "SELECT SUM(quantity * price) AS total_value FROM inventory";
$total_value_result = $conn->query($total_value_sql);
$total_value = $total_value_result ? $total_value_result->fetch_assoc()['total_value'] : 0;
$total_value = $total_value ?? 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lily Flower Dashboard</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/uiverse@latest/dist/uiverse.min.css" />

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background-color: #FFF0F5;
      margin: 0;
      padding: 0;
      color: #4B0082;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #FF69B4;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
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
    main {
      flex: 1;
      padding: 30px;
      text-align: center;
    }
    h1 {
      color: #FF69B4;
      margin-bottom: 30px;
    }
    .stats {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
    }
    .card {
      background-color: white;
      padding: 25px 30px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(255,105,180,0.3);
      width: 250px;
      text-align: center;
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 20px rgba(255,105,180,0.5);
    }
    .card img {
      width: 60px;
      height: 60px;
      margin-bottom: 10px;
    }
    .card h2 {
      margin: 0 0 10px;
      color: #FF69B4;
      font-size: 1.4rem;
    }
    .card p {
      font-size: 1.3rem;
      color: #4B0082;
      font-weight: bold;
    }
    footer {
      background-color: #FF69B4;
      color: white;
      text-align: center;
      padding: 15px 0;
      font-size: 1rem;
      flex-shrink: 0;
    }
    @media (max-width: 700px) {
      .stats {
        flex-direction: column;
        align-items: center;
      }
    }

    .btn-17,
    .btn-17 * {
      border: 0 solid;
      box-sizing: border-box;
    }
    .btn-17 {
      background-color: #000;
      color: #fff;
      cursor: pointer;
      font-family: ui-sans-serif, system-ui, sans-serif;
      font-size: 100%;
      font-weight: 900;
      text-transform: uppercase;
      padding: 0.8rem 3rem;
      border-radius: 99rem;
      overflow: hidden;
      position: relative;
      margin-top: 40px;
      transition: background-color 0.3s ease;
    }
    .btn-17:hover {
      background-color: #FF69B4;
      color: #fff;
    }
    .btn-17 .text-container {
      display: block;
      mix-blend-mode: difference;
      overflow: hidden;
      position: relative;
    }
    .btn-17 .text {
      display: block;
      position: relative;
    }
    .btn-17:hover .text {
      animation: move-up-alternate 0.3s forwards;
    }
    @keyframes move-up-alternate {
      0% { transform: translateY(0); }
      50% { transform: translateY(80%); }
      51% { transform: translateY(-80%); }
      100% { transform: translateY(0); }
    }
    .back-container {
      margin-top: 40px;
      text-align: center;
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

<main>
  <h1>Inventory Dashboard</h1>

  <div class="stats">
    <div class="card uiverse-float">
      <img src="images/icon flower.svg" alt="Total Flowers Icon" />
      <h2>Total Flowers</h2>
      <p><?= htmlspecialchars($total_items) ?></p>
    </div>
    <div class="card uiverse-float">
      <img src="images/icon items.svg" alt="Quantity Icon" />
      <h2>Total Quantity</h2>
      <p><?= htmlspecialchars($total_quantity) ?></p>
    </div>
    <div class="card uiverse-float">
      <img src="images/icon money.svg" alt="Total Value Icon" />
      <h2>Total Value (RM)</h2>
      <p><?= number_format($total_value, 2) ?></p>
    </div>
  </div>

  <div class="back-container">
    <a href="inventory.php" aria-label="Go to Inventory">
      <button class="btn-17 uiverse-pulse" type="button">
        <span class="text-container">
          <span class="text">View Inventory</span>
        </span>
      </button>
    </a>
  </div>

  <div class="back-container">
    <a href="index.php" aria-label="Back to Home">
      <button class="btn-17 uiverse-pulse" type="button">
        <span class="text-container">
          <span class="text">Back</span>
        </span>
      </button>
    </a>
  </div>
</main>

<footer>
  <p>© 2025 Lily Flower. All rights reserved.</p>
</footer>

</body>
</html>

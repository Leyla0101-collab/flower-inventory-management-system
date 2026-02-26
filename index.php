<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lily Flower Inventory</title>

  <!-- Fonts and Styles -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/common.css">

  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Quicksand', sans-serif;
      background-color: #ffc0cb;
    }

    body {
      color: #333;
      overflow-x: hidden;
    }

    header {
      background-color: #FF69B4;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      position: sticky;
      top: 0;
      z-index: 10;
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
      font-weight: 400;
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

    .hero {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }

    .welcome-box {
      background-color: rgba(255, 182, 193, 0.85);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      max-width: 600px;
    }

    .welcome-box h1,
    .welcome-box p {
      color: white;
    }

    .hero h1 {
      font-size: 3rem;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }

    .hero button {
      background-color: #FF69B4;
      border: none;
      color: white;
      padding: 12px 25px;
      font-size: 1rem;
      border-radius: 25px;
      cursor: pointer;
      transition: 0.3s;
    }

    .hero button:hover {
      background-color: #FF1493;
      transform: scale(1.05);
    }

    .section {
      padding-top: 40px;
      text-align: center;
      background-color: rgba(255,255,255,0.95);
      position: relative;
      z-index: 1;
    }

    .section h2 {
      color: #FF69B4;
      font-size: 2rem;
    }

    .cards {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
      gap: 20px;
      margin-top: 20px;
      padding: 10px 20px;
    }

    .card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 280px;
      padding: 20px;
      flex-shrink: 0;
    }

    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }

    .card h3 {
      color: #ec407a;
      margin: 10px 0;
    }

    footer {
      background-color: #FFB6C1;
      color: white;
      width: 80vw;
      max-width: 1200px;
      height: 20vh;
      padding: 20px;
      text-align: center;
      font-size: 14px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin: 30px auto;
      border-radius: 15px;
    }

    footer .features {
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<header>
  <div class="brand">
    <img src="images/lily.svg" alt="Lily Flower Logo" title="Lily Flower Logo">
    <div class="logo">Lily Flower</div>
  </div>
  <nav>
    <a href="boarddash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </nav>
</header>

<div class="hero">
  <div class="welcome-box">
    <h1>Welcome to Lily Flower</h1>
    <p>Your beautiful flower, made with love</p>
    <button onclick="window.location.href='add_flower.php'">Start Managing</button>
  </div>
</div>

<div class="section">
  <h2>Featured Categories</h2>
  <div class="cards">
    <div class="card">
      <img src="images/Roses.jpeg" alt="Roses">
      <h3>Roses</h3>
      <p>Track your red, white, and pink roses inventory with ease.</p>
    </div>
    <div class="card">
      <img src="images/Tulips.jpeg" alt="Tulips">
      <h3>Tulips</h3>
      <p>Monitor and update your tulip inventory effortlessly.</p>
    </div>
    <div class="card">
      <img src="images/Orchids.jpeg" alt="Orchids">
      <h3>Orchids</h3>
      <p>Organize your exotic orchid varieties with precision.</p>
    </div>
    <div class="card">
      <img src="images/Daises.jpeg" alt="Daisies">
      <h3>Daisies</h3>
      <p>Keep track of your fresh and cheerful daisy inventory.</p>
    </div>
    <div class="card">
      <img src="images/Lavenders.jpeg" alt="Lavenders">
      <h3>Lavenders</h3>
      <p>Track your soothing and fragrant lavender stock.</p>
    </div>
    <div class="card">
      <img src="images/Lilies.jpeg" alt="Lilies">
      <h3>Lilies</h3>
      <p>Keep track of your graceful and elegant lily blooms.</p>
    </div>
    <div class="card">
      <img src="images/Cherry blossoms.jpeg" alt="Cherry Blossoms">
      <h3>Cherry Blossoms</h3>
      <p>Monitor your delicate and dreamy cherry blooms.</p>
    </div>
    <div class="card">
      <img src="images/Hydrageas.jpeg" alt="Hydrangeas">
      <h3>Hydrangeas</h3>
      <p>Stay in bloom with your soft and elegant hydrangea stock.</p>
    </div>
    <div class="card">
      <img src="images/Sunflowers.jpeg" alt="Sunflowers">
      <h3>Sunflowers</h3>
      <p>Brighten your day with vibrant and cheerful sunflower stock.</p>
    </div>
    <div class="card">
      <img src="images/Delphinium.jpeg" alt="Delphinium">
      <h3>Delphinium</h3>
      <p>Tall spikes of bright blue flowers, perfect for striking floral displays.</p>
    </div>
  </div>
</div>

<footer>
  <div class="features">Flower Inventory Management</div>
  &copy; 2025 Lily Flower. All rights reserved.
</footer>

</body>
</html>
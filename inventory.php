<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lfdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM inventory ORDER BY flower_name ASC";
$result = $conn->query($sql);
?>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
  <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lily Flower Inventory</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/common.css">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #FFF0F5;
            margin: 0;
            padding: 20px;
            color: #4B0082;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            color: #FF69B4;
            margin-bottom: 30px;
        }

        header {
            background-color: #FF69B4;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            font-family: 'Satisfy', cursive;
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
            font-size: 1rem;
        }

        nav a:hover {
            text-decoration: underline;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(255,105,180,0.3);
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #FFB6C1;
            text-align: left;
        }

        th {
            background-color: #FF69B4;
            color: white;
            font-size: 1.1rem;
        }

        tr:hover {
            background-color: #FFE4F1;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background-color: #FF69B4;
        }

        .btn-edit:hover {
            background-color: #FF1493;
        }

        .btn-delete {
            background-color: #DC143C;
        }

        .btn-delete:hover {
            background-color: #B22222;
        }

        @media (max-width: 700px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                background: white;
                box-shadow: 0 4px 8px rgba(255,105,180,0.2);
                border-radius: 10px;
                padding: 10px;
            }

            td {
                position: relative;
                padding-left: 50%;
                border: none;
                border-bottom: 1px solid #FFB6C1;
            }

            td:before {
                position: absolute;
                top: 10px;
                left: 15px;
                content: attr(data-label);
                font-weight: bold;
                color: #FF69B4;
            }

            .btn {
                width: 100%;
                justify-content: center;
                margin-bottom: 5px;
            }
        }

        .back-container {
            text-align: center;
            margin-top: 30px;
        }

        .btn-back {
            background-color: #FF69B4;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-family: 'Quicksand', sans-serif;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(255, 105, 180, 0.4);
            margin: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #FF1493;
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(255, 20, 147, 0.7);
        }

        footer {
            margin-top: auto;
            background-color: #FF69B4;
            text-align: center;
            padding: 15px;
            color: white;
        }
    </style>

    <script>
        function confirmDelete(flowerName) {
            return confirm(`Are you sure you want to delete the flower: "${flowerName}"?`);
        }
    </script>
</head>
<body>

<header>
    <div class="brand">
        <img src="images/lily.svg" alt="Lily Flower Logo">
        <div class="logo">Lily Flower</div>
    </div>
    <nav>
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="boarddash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
</header>

<h1>Flower Inventory</h1>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Flower Name</th>
                <th>Quantity</th>
                <th>Price (RM)</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="Flower Name"><?= htmlspecialchars($row['flower_name']) ?></td>
                    <td data-label="Quantity"><?= (int)$row['quantity'] ?></td>
                    <td data-label="Price"><?= number_format($row['price'], 2) ?></td>
                    <td data-label="Description"><?= htmlspecialchars($row['description']) ?></td>
                    <td data-label="Actions" class="actions">
                        <a class="btn btn-edit" href="edit.php?id=<?= urlencode($row['id']) ?>">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a class="btn btn-delete" href="delete.php?id=<?= urlencode($row['id']) ?>" onclick="return confirmDelete('<?= htmlspecialchars(addslashes($row['flower_name'])) ?>')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align:center; font-size:1.2rem; color:#FF69B4;">No flowers found in the inventory.</p>
<?php endif; ?>

<div class="back-container">
    <a href="add_flower.php" class="btn-back"><i class="fas fa-plus"></i> Add Flower</a>
    <a href="index.php" class="btn-back"><i class="fas fa-home"></i> Back to Home</a>
</div>

<footer>
    &copy; 2025 Lily Flower Inventory
</footer>

</body>
</html>

<?php
$conn->close();
?>

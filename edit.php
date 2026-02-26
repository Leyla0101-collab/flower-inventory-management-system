<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lfdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$flower = null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM inventory WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $flower = $result->fetch_assoc();
} else {
    die("Flower not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flower_name = $conn->real_escape_string($_POST['flower_name']);
    $quantity = (int) $_POST['quantity'];
    $price = (float) $_POST['price'];
    $description = $conn->real_escape_string($_POST['description']);

    $update_sql = "UPDATE inventory SET 
        flower_name='$flower_name', 
        quantity=$quantity, 
        price=$price, 
        description='$description' 
        WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: inventory.php?updated=1");
        exit;
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Flower</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #FFF0F5;
            margin: 0; padding: 20px;
            color: #4B0082;
        }
        h1 {
            color: #FF69B4;
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px 30px 30px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255,105,180,0.3);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #FF1493;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #FFB6C1;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        button {
            background-color: #FF69B4;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }
        button:hover {
            background-color: #FF1493;
        }
        .error {
            background: #ffcdd2;
            color: #b71c1c;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .back-button {
            display: block;
            text-align: center;
            background-color: #FFB6C1;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            text-decoration: none;
            margin: 20px auto 0;
            max-width: 400px;
            transition: 0.3s;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #FF69B4;
        }

        .form-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
            border-bottom: 1px solid #FFB6C1;
            padding-bottom: 15px;
        }
        .form-header img {
            height: 50px;
        }
        .form-header h2 {
            font-family: 'Satisfy', cursive;
            font-size: 2rem;
            color: #FF69B4;
            margin: 0;
            user-select: none;
        }
    </style>
</head>
<body>

<h1>Edit Flower</h1>

<?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-header">
        <img src="images/lily.svg" alt="Lily Flower Logo" />
        <h2>Lily Flower</h2>
    </div>

    <label for="flower_name">Flower Name</label>
    <input type="text" id="flower_name" name="flower_name" value="<?= htmlspecialchars($flower['flower_name']) ?>" required>

    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity" value="<?= (int)$flower['quantity'] ?>" min="0" required>

    <label for="price">Price (RM)</label>
    <input type="number" step="0.01" id="price" name="price" value="<?= number_format($flower['price'], 2, '.', '') ?>" min="0" required>

    <label for="description">Description</label>
    <textarea id="description" name="description"><?= htmlspecialchars($flower['description']) ?></textarea>

    <button type="submit">Update Flower</button>
</form>

<a class="back-button" href="inventory.php">&larr; Back to Inventory</a>

</body>
</html>

<?php
$conn->close();
?>

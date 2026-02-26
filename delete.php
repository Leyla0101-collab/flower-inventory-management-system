<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lfdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing ID.");
}

$id = (int) $_GET['id'];

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'Yes') {
     
        $conn->begin_transaction();

        try {
           
            $stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                throw new Exception("Flower not found.");
            }

            $flower = $result->fetch_assoc();

            $stmt_insert = $conn->prepare("INSERT INTO deleted_history (flower_id, flower_name, deleted_at) VALUES (?, ?, NOW())");
            $stmt_insert->bind_param("is", $flower['id'], $flower['flower_name']);
            $stmt_insert->execute();

            $stmt_delete = $conn->prepare("DELETE FROM inventory WHERE id = ?");
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();

            $conn->commit();

            header("Location: inventory.php");
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            $error = $e->getMessage();
        }
    } else {
        header("Location: inventory.php");
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Flower not found.");
}

$flower = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Delete Flower</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #FFF0F5;
            color: #4B0082;
            padding: 30px;
            margin: 0;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 25px 30px 30px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255,105,180,0.3);
            text-align: center;
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
        h1 {
            color: #FF69B4;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        button {
            background-color: #FF69B4;
            color: white;
            border: none;
            padding: 12px 25px;
            margin: 0 10px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #FF1493;
        }
        .cancel-btn {
            background-color: #ccc;
            color: #333;
        }
        .cancel-btn:hover {
            background-color: #999;
        }
        .error {
            background: #ffcdd2;
            color: #b71c1c;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        a.back-link {
            color: #FF69B4;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 15px;
            transition: color 0.3s;
        }
        a.back-link:hover {
            color: #FF1493;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="form-header">
        <img src="images/lily.svg" alt="Lily Flower Logo" />
        <h2>Lily Flower</h2>
    </div>

    <h1>Delete Flower</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <p>Are you sure you want to delete this flower?</p>
    <p><strong><?= htmlspecialchars($flower['flower_name']) ?></strong></p>

    <form method="POST" action="">
        <button type="submit" name="confirm" value="Yes">Yes, Delete</button>
        <button type="submit" name="confirm" value="No" class="cancel-btn">Cancel</button>
    </form>

    <a href="inventory.php" class="back-link">&larr; Back to Inventory</a>
</div>

</body>
</html>

<?php
$conn->close();
?>

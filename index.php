<?php
$host = "sql311.infinityfree.com";
$user = "if0_43478772";
$pass = "YOUR_PASSWORD";
$db   = "if0_43478772_Task";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name']) && isset($_POST['age'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $age  = (int)$_POST['age'];
    $conn->query("INSERT INTO users (name, age, status) VALUES ('$name', $age, 0)");
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-box {
            margin-bottom: 20px;
        }
        .inputs-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="text"], input[type="number"] {
            padding: 5px;
            border: 1px solid #aaa;
        }
        input[type="number"] {
            width: 75px;
        }
        .submit-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 8px;
        }
        button {
            padding: 5px 12px;
            cursor: pointer;
        }
        table {
            border-collapse: collapse;
            width: 450px;
            text-align: center;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <form method="POST" action="">
            <div class="inputs-row">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="age">Age</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="submit-row">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['age'] ?></td>
                <td id="status-<?= $row['id'] ?>"><?= $row['status'] ?></td>
                <td><button type="button" onclick="toggleStatus(<?= $row['id'] ?>)">Toggle</button></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        function toggleStatus(id) {
            fetch("toggle.php?id=" + id)
                .then(res => res.text())
                .then(val => {
                    document.getElementById("status-" + id).innerText = val.trim();
                });
        }
    </script>
</body>
</html>

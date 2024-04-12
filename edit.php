<?php

$host = 'localhost';
$db   = 'users';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users_data WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE users_data SET username = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $email, $id]);
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit User</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
<form action="edit.php" method="post" class="needs-validation" novalidate>
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        <div class="invalid-feedback">
            Per favore inserisci un username.
        </div>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        <div class="invalid-feedback">
            Per favore inserisci un'email valida.
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">UPDATE</button>
</form>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

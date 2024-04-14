<?php

include __DIR__ . '/includes/db.php';

$stmt = $pdo->prepare("SELECT * FROM users_data WHERE username LIKE ?");
$stmt->execute([
    "%$search%"
]);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt_delete = $pdo->prepare("DELETE FROM users_data WHERE id = ?");
    $stmt_delete->execute([$id]);
    header("Location: index.php");
};

include __DIR__ . '/includes/html.php'; ?>

<form class="row g-3 my-3">
    <div class="col">
        <input type="text" name="search" class="form-control" placeholder="Cerca un utente">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Cerca</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>E-Mail</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($stmt as $row) {
            echo '<tr>';
            echo "<td>$row[id]</td>";
            echo "<td>$row[username]</td>";
            echo "<td>$row[email]</td>";
            echo "<td><a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a></td>";
            echo "<td><a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete user with ID: " . $row["id"] . "?\")'>Delete</a></td>";
            echo '</tr>';
        } ?>
    </tbody>
</table>
<div class="button-container">
    <a href="adduser.php" class="btn btn-primary">Add New User</a>
</div>

<?php

include __DIR__ . '/includes/end.php';

<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from users table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
// Fetch the records so we can display them in our template.
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Users</h2>
    <!-- To hide the "Create User" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $users variable is empty or not.-->
    <?php if ($_SESSION["idcargo"] == 1): ?>
	<a href="create.php" class="create-users">Create User</a>
    <?php endif; ?>
	<table class = "table">
        <thead>
            <tr>
                <td>User ID</td>
                <td>Username</td>
                <td>User Type</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['idcargo']?></td>
                <?php if ($_SESSION["idcargo"] == 1 && $_SESSION["id"] != $user["id"]): ?>
                <td class="actions">
                    <a href="delete.php?id=<?=$user['id']?>"><button class = "b"> delete</button></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>
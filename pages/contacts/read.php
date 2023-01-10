<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare("SELECT * FROM contacts");
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Contacts</h2>
    <?php if ($_SESSION["idcargo"] == 1): ?>
	<a href="create.php" class="create-language">Create Contact</a>
    <?php endif; ?>
	<table class = "table">
        <thead>
            <tr>
                <td>User ID</td>
                <td>Contact ID</td>
                <td>Contact</td>
                <td>Icon</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['userId']?></td>
                <td><?=$contact['contactoId']?></td>
                <td><?=$contact['nome']?></td>
                <td><?=$contact['icon']?></td>
                <?php if ($_SESSION["idcargo"] == 1): ?>
                <td class="actions">
                    <a href="update.php?contactoId=<?=$contact['contactoId']?>" ><button class = "b">edit</button></a>
                    <a href="delete.php?contactoId=<?=$contact['contactoId']?>" ><button class = "b">delete</button></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
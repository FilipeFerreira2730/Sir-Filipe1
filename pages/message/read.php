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
$stmt = $pdo->prepare("SELECT * FROM message");
$stmt->execute();
// Fetch the records so we can display them in our template.
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_messages = $pdo->query('SELECT COUNT(*) FROM message')->fetchColumn();

// Check if form was submitted
if (isset($_POST['save_contact'])) {
    // Sanitize POST array
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // Get checkbox value
    $seen = isset($_POST['seen']) ? 1 : 0;
    // Update contact request
    $stmt = $pdo->prepare('UPDATE message SET seen = ? WHERE mensagemId= ?');
    $stmt->execute([$seen, $_POST['mensagemId']]);
    // Set the text of the seen field based on the value of the $seen variable
    if ($seen) {
        $seenText = "seen";
        } else {
        $seenText = "not seen";
        }
            
        echo $seenText;
    header('Location: read.php');
    exit;
}

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Message</h2>
    <?php if ($_SESSION["idcargo"] == 1): ?>
	<a href="create.php" class="create-language">Create Message</a>
    <?php endif; ?>
	<table class = "table">
        <thead>
            <tr>
                <td>User ID</td>
                <td>Message ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Message</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $mes): ?>
            <tr>
                <td><?=$mes['userId']?></td>
                <td><?=$mes['mensagemId']?></td>
                <td><?=$mes['nome']?></td>
                <td><?=$mes['email']?></td>
                <td><?=$mes['mensagem']?></td>
                <?php if ($_SESSION["idcargo"] == 1): ?>
                <td class="actions">
                    <a href="update.php?mensagemId=<?=$mes['mensagemId']?>" ><button class = "b">edit</button></a>
                    <a href="delete.php?mensagemId=<?=$mes['mensagemId']?>" ><button class = "b">delete</button></a>
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
		<?php if ($page*$records_per_page < $num_messages): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
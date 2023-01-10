<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the certification ID exists
if (isset($_GET['contactoId'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE contactoId = ?');
    $stmt->execute([$_GET['contactoId']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('contact does not exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE contactoId = ?');
            $stmt->execute([$_GET['contactoId']]);
            header('Location: read.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete contact #<?=$contact['contactoId']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete contact #<?=$contact['contactoId']?>?</p>
    <div class="yesno">
        <a href="delete.php?contactoId=<?=$contact['contactoId']?>&confirm=yes"><button class = "b">Yes</button></a>
        <a href="delete.php?contactoId=<?=$contact['contactoId']?>&confirm=no"><button class = "b">No</button></a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
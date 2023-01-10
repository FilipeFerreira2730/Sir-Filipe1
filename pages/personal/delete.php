<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['pessoalId'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM personal WHERE pessoalId = ?');
    $stmt->execute([$_GET['pessoalId']]);
    $personal = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$personal) {
        exit('personal does not exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM personal WHERE pessoalId = ?');
            $stmt->execute([$_GET['pessoalId']]);
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
	<h2>Delete personal #<?=$personal['pessoalId']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete personal #<?=$personal['pessoalId']?>?</p>
    <div class="yesno">
        <a href="delete.php?pessoalId=<?=$personal['pessoalId']?>&confirm=yes"><button class = "b">Yes</button></a>
        <a href="delete.php?pessoalId=<?=$personal['pessoalId']?>&confirm=no"><button class = "b">No</button></a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
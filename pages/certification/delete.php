<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the certification ID exists
if (isset($_GET['certificacaoId'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM certifications WHERE certificacaoId = ?');
    $stmt->execute([$_GET['certificacaoId']]);
    $certification = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$certification) {
        exit('certification doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM certifications WHERE certificacaoId = ?');
            $stmt->execute([$_GET['certificacaoId']]);
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
	<h2>Delete certification #<?=$certification['certificacaoId']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete certification #<?=$certification['certificacaoId']?>?</p>
    <div class="yesno">
        <a href="delete.php?certificacaoId=<?=$certification['certificacaoId']?>&confirm=yes"><button class = "b">Yes</button></a>
        <a href="delete.php?certificacaoId=<?=$certification['certificacaoId']?>&confirm=no"><button class = "b">No</button></a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
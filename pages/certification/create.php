<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $certificacaoId = isset($_POST['certificacaoId']) && !empty($_POST['certificacaoId']) && $_POST['certificacaoId'] != 'auto' ? $_POST['certificacaoId'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    
    // Insert new record into the certifications table
    $stmt = $pdo->prepare('INSERT INTO certifications VALUES (?, ?, ?)');
    $stmt->execute([$certificacaoId, $nome, $_SESSION["id"]]);
    header('Location: read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Certification</h2>
    <form action="create.php" method="post">

        <label class = "table" for="nome">Certification Name</label>
        <input type="text" name="nome" placeholder="Nome" id="nome">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>



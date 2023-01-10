<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $skillId = isset($_POST['skillId']) && !empty($_POST['skillId']) && $_POST['skillId'] != 'auto' ? $_POST['skillId'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $percentagem = isset($_POST['percentagem']) ? $_POST['percentagem'] : '';
    
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO skills VALUES (?, ?, ?, ?)');
    $stmt->execute([$skillId, $nome, $percentagem, $_SESSION["id"]]);
    header('Location: read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Skill</h2>
    <form action="create.php" method="post">
    
        <label class = "table" for="nome">Skill Name</label>
        <input type="text" name="nome" placeholder="Nome" id="nome">
        
        <label class = "table" for="percentagem">Percentage</label>
        <input type="text" name="percentagem" placeholder="Percentagem" id="percentagem">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
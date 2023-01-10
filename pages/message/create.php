<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $mensagemId = isset($_POST['mensagemId']) && !empty($_POST['mensagemId']) && $_POST['mensagemId'] != 'auto' ? $_POST['mensagemId'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';
    
    // Insert new record into the certifications table
    $stmt = $pdo->prepare('INSERT INTO message VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$mensagemId, $email, $mensagem, $_SESSION["id"], $nome]);
    header('Location: read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Message</h2>
    <form action="create.php" method="post">

        <label class = "table" for="nome">Name</label>
        <input type="text" name="nome" placeholder="Nome" id="nome">
        <label class = "table"for="email">Email</label>
        <input type="text" name="email" placeholder="email" id="email">
        <label class = "table"for="mensagem">Message</label>
        <input type="text" name="mensagem" placeholder="mensagem" id="mensagem">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
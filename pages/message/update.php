<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['mensagemId'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $nome = $_POST['nome'];
        $email =$_POST['email'];
        $mensagem = $_POST['mensagem'];
        // Change the line below to your timezone!
        date_default_timezone_set('Europe/London');
        $created = date('m/d/Y h:i:s a', time());
        // Update the record
        $stmt = $pdo->prepare('UPDATE message SET nome = ?, email = ?, mensagem = ? WHERE mensagemId = ?');
        $stmt->execute([$email, $mensagem, $nome, $_GET['mensagemId']]);
        header('Location: read.php');
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM message WHERE mensagemId = ?');
    $stmt->execute([$_GET['mensagemId']]);
    $mensagens = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$mensagens) {
        exit('message does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update message #<?=$mensagens['mensagemId']?></h2>
    <form action="update.php?mensagemId=<?=$mensagens['mensagemId']?>" method="post">

        <label class = "table" for="nome">Name</label>
        <input type="text" name="nome" placeholder="nome" value="<?=$mensagens['nome']?>" id="nome">
        <label class = "table" for="email">Email</label>
        <input type="text" name="email" placeholder="Email" value="<?=$mensagens['email']?>" id="email">
        <label class = "table" for="mensagem">Message</label>
        <input type="text" name="mensagem" placeholder="mensagem" value="<?=$mensagens['mensagem']?>" id="mensagem">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
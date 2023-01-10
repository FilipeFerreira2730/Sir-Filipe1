<?php

require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../assets/img/';
    $imagem = $path . $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem'] ['tmp_name'], $imagem);
    $newPath = '/my-profile-master/assets/img/';
    $imagem = $newPath . $_FILES['imagem']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $pessoalId = isset($_POST['pessoalId']) && !empty($_POST['pessoalId']) && $_POST['pessoalId'] != 'auto' ? $_POST['pessoalId'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $morada = isset($_POST['morada']) ? $_POST['morada'] : '';
    $idade = isset($_POST['idade']) ? $_POST['idade'] : '';
    // Insert new record into the education table
    $stmt = $pdo->prepare('INSERT INTO personal VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$pessoalId, $nome, $idade, $morada, $imagem, $_SESSION["id"]]);
    header('Location: read.php');

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Personal</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label class = "table" for="nome">Name</label>
        <input type="text" name="nome" placeholder="nome" id="nome">
        <label class = "table" for="morada">Address</label>
        <input type="text" name="morada" placeholder="morada" id="morada">
        <label class = "table"for="idade">Age</label>
        <input type="text" name="idade" placeholder="idade" id="idade">
        <label class = "table" for="imagem">Photo</label>
        <input type="file" name="imagem" value="" id=imagem/>
    
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
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
    $educacaoId = isset($_POST['educacaoId']) && !empty($_POST['educacaoId']) && $_POST['educacaoId'] != 'auto' ? $_POST['educacaoId'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $escola = isset($_POST['escola']) ? $_POST['escola'] : '';
    // Insert new record into the education table
    $stmt = $pdo->prepare('INSERT INTO education VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$educacaoId, $imagem, $escola, $descricao, $_SESSION["id"]]);
    header('Location: read.php');

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Education</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label class = "table" for="escola">School Name</label>
        <input type="text" name="escola" placeholder="escola" id="escola">
        <label class = "table" for="descricao">Descripton</label>
        <input type="text" name="descricao" placeholder="descricao" id="descricao">
        <label class = "table" for="imagem">School Photo</label>
        <input type="file" name="imagem" value="" id=imagem/>
    
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
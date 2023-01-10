<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['educacaoId'])) {
    if (!empty($_POST)) {
        $path = '../../assets/img/';
        $location = $path . $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], $location);
        $newPath = '/my-profile-master/assets/img/';
        $imagem = $newPath . $_FILES['imagem']['name'];
        $description = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $escola = isset($_POST['escola']) ? $_POST['escola'] : '';
        $stmt = $pdo->prepare('UPDATE education SET descricao = ?, imagem = ?, escola = ? WHERE educacaoId = ?');
        $stmt->execute([$description, $imagem, $escola, $_GET['educacaoId']]);
        header('Location: read.php');
    }
    // Get the fields from the introduction table
    $stmt = $pdo->prepare('SELECT * FROM education WHERE educacaoId = ?');
    $stmt->execute([$_GET['educacaoId']]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$education) {
        exit('introduction does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update education #<?=$education['educacaoId']?></h2>
    <form action="update.php?educacaoId=<?=$education['educacaoId']?>" method="post" enctype="multipart/form-data">


        <label class = "table" for="escola">School Name</label>
        <input type="text" name="escola" placeholder="escola" value="<?=$education['escola']?>" id="escola">
        <label class = "table" for="descricao">Description</label>
        <input type="text" name="descricao" placeholder="Descricao" value="<?=$education['descricao']?>" id="descricao">
        <label class = "table" for="imagem">School Photo</label>
        <input type="file" name="imagem" value="<?=$education['imagem']?>" id="imagem">
        
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
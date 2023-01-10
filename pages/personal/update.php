<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['pessoalId'])) {
    if (!empty($_POST)) {
        $path = '../../assets/img/';
        $location = $path . $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], $location);
        $newPath = '/my-profile-master/assets/img/';
        $imagem = $newPath . $_FILES['imagem']['name'];
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $morada = isset($_POST['morada']) ? $_POST['morada'] : '';
        $idade = isset($_POST['idade']) ? $_POST['idade'] : '';
        $stmt = $pdo->prepare('UPDATE personal SET nome = ?, imagem = ?, idade = ?, morada = ? WHERE pessoalId = ?');
        $stmt->execute([$nome, $imagem, $idade, $morada, $_GET['pessoalId']]);
        header('Location: read.php');
    }
    // Get the fields from the introduction table
    $stmt = $pdo->prepare('SELECT * FROM personal WHERE pessoalId = ?');
    $stmt->execute([$_GET['pessoalId']]);
    $personal = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$personal) {
        exit('personal does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update personal #<?=$personal['pessoalId']?></h2>
    <form action="update.php?pessoalId=<?=$personal['pessoalId']?>" method="post" enctype="multipart/form-data">


        <label class = "table" for="nome">Name</label>
        <input type="text" name="nome" placeholder="nome" value="<?=$personal['nome']?>" id="nome">
        <label class = "table" for="morada">Address</label>
        <input type="text" name="morada" placeholder="morada" value="<?=$personal['morada']?>" id="morada">
        <label class = "table" for="idade">Age</label>
        <input type="text" name="idade" placeholder="idade" value="<?=$personal['idade']?>" id="idade">
        <label class = "table" for="imagem">Photo</label>
        <input type="file" name="imagem" value="<?=$personal['imagem']?>" id="imagem">
        
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the certification id exists, for example update.php?id=1 will get the certification with the id of 1
if (isset($_GET['certificacaoId'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        //$certification_name = isset($_POST['certification_name']) ? $_POST['certification_name'] : '';
        $certificacao_name = $_POST['certification_name'];
        // Update the record
        $stmt = $pdo->prepare('UPDATE certifications SET nome = ? WHERE certificacaoId = ?');
        $stmt->execute([$certificacao_name, $_GET['certificacaoId']]);
        header('Location: read.php');
    }
    // Get the certification from the certifications table
    $stmt = $pdo->prepare('SELECT * FROM certifications WHERE certificacaoId = ?');
    $stmt->execute([$_GET['certificacaoId']]);
    $certification = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$certification) {
        exit('certification does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update certification #<?=$certification['certificacaoId']?></h2>
    <form action="update.php?certificacaoId=<?=$certification['certificacaoId']?>" method="post" enctype="multipart/form-data">

        <label class = "table" for="certification_name">Certification Name</label>
        <input type="text" name="certification_name" placeholder="Certification Name" value="<?=$certification['nome']?>" id="certification_name">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
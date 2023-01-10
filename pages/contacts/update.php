<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the certification id exists, for example update.php?id=1 will get the certification with the id of 1
if (isset($_GET['contactoId'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        //$certification_name = isset($_POST['certification_name']) ? $_POST['certification_name'] : '';
        $nome = $_POST['nome'];
        $icon = $_POST['icon'];
        $tipocontacto = $_POST['tipocontacto'];
        // Update the record
        $stmt = $pdo->prepare('UPDATE contacts SET nome = ?, idtipo = ?, icon = ? WHERE contactoId = ?');
        $stmt->execute([$nome, $icon, $tipocontacto, $_GET['contactoId']]);
        header('Location: read.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE contactoId = ?');
    $stmt->execute([$_GET['contactoId']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('contact does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update contact #<?=$contact['contactoId']?></h2>
    <form action="update.php?contactoId=<?=$contact['contactoId']?>" method="post" enctype="multipart/form-data">

        <label class = "table" for="contact_name">Nome</label>
        <input type="text" name="contact_name" placeholder="Contact Name" value="<?=$contact['nome']?>" id="contact_name">
        <label class = "table" for="contact_tipo">Contact Type</label>
        <input type="text" name="contact_tipo" placeholder="Contact Type" value="<?=$contact['idtipo']?>" id="contact_tipo">
        <label class = "table" for="contact_icon">Icon</label>
        <input type="text" name="contact_icon" placeholder="Contact Icon" value="<?=$contact['icon']?>" id="contact_icon">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
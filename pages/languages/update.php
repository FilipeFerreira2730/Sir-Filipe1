<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the certification id exists, for example update.php?id=1 will get the certification with the id of 1
if (isset($_GET['linguaId'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        //$certification_name = isset($_POST['certification_name']) ? $_POST['certification_name'] : '';
        $language_name = $_POST['language_name'];
        $language_percentage = $_POST['language_percentage'];
       
        // Update the record
        $stmt = $pdo->prepare('UPDATE languages SET nome = ?, percentagem = ? WHERE linguaId = ?');
        $stmt->execute([$language_name, $language_percentage, $_GET['linguaId']]);
        header('Location: read.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE linguaId = ?');
    $stmt->execute([$_GET['linguaId']]);
    $language = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$language) {
        exit('language does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update language #<?=$language['linguaId']?></h2>
    <form action="update.php?linguaId=<?=$language['linguaId']?>" method="post" enctype="multipart/form-data">

        <label class = "table" for="language_name">Language</label>
        <input type="text" name="language_name" placeholder="Language Name" value="<?=$language['nome']?>" id="language_name">
        <label class = "table"for="language_percentage">Language Percentage</label>
        <input type="text" name="language_percentage" placeholder="Language Percentage" value="<?=$language['percentagem']?>" id="language_percentage">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
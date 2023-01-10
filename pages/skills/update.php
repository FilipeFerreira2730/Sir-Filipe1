<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the certification id exists, for example update.php?id=1 will get the certification with the id of 1
if (isset($_GET['skillId'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        //$certification_name = isset($_POST['certification_name']) ? $_POST['certification_name'] : '';
        $skill_name = $_POST['skill_name'];
        $skill_percentage = $_POST['skill_percentage'];
       
        // Update the record
        $stmt = $pdo->prepare('UPDATE skills SET nome = ?, percentagem = ? WHERE skillId = ?');
        $stmt->execute([$skill_name, $skill_percentage, $_GET['skillId']]);
        header('Location: read.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM skills WHERE skillId = ?');
    $stmt->execute([$_GET['skillId']]);
    $skill = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$skill) {
        exit('skill does not exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update skill #<?=$skill['skillId']?></h2>
    <form action="update.php?skillId=<?=$skill['skillId']?>" method="post" enctype="multipart/form-data">

        <label class = "table" for="skill_name">Skill</label>
        <input type="text" name="skill_name" placeholder="Skill Name" value="<?=$skill['nome']?>" id="skill_name">
        <label class = "table" for="skill_percentage">Skill Percentage</label>
        <input type="text" name="skill_percentage" placeholder="Skill Percentage" value="<?=$skill['percentagem']?>" id="skill_percentage">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
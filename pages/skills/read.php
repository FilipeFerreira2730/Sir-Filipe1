<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare("SELECT * FROM skills");
$stmt->execute();
// Fetch the records so we can display them in our template.
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_skills = $pdo->query('SELECT COUNT(*) FROM skills')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Skills</h2>
    <?php if ($_SESSION["idcargo"] == 1): ?>
	<a href="create.php" class="create-skill">Create Skill</a>
    <?php endif; ?>
	<table class = "table">
        <thead>
            <tr>
                <td>Skill ID</td>
                <td>Skill Name</td>
                <td>Percentage</td>
                <td>User ID</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($skills as $skill): ?>
            <tr>
                <td><?=$skill['skillId']?></td>
                <td><?=$skill['nome']?></td>
                <td><?=$skill['percentagem']?></td>
                <td><?=$skill['userId']?></td>
                <?php if ($_SESSION["idcargo"] == 1): ?>
                <td class="actions">
                    <a href="update.php?skillId=<?=$skill['skillId']?>" class="update"><button class = "b">edit</button></a>
                    <a href="delete.php?skillId=<?=$skill['skillId']?>" class="delete"><button class = "b">delete</button></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        <div class="pagination">
		    <?php if ($page > 1): ?>
		        <a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		    <?php endif; ?>
		    <?php if ($page*$records_per_page < $num_skills): ?>
		        <a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		    <?php endif; ?>
	    </div>
</div>
<?=template_footer()?>
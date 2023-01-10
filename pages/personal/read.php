<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from education table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM personal");
$stmt->execute();
// Fetch the records so we can display them in our template.
$personal = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of education, this is so we can determine whether there should be a next and previous button
$num_personal = $pdo->query('SELECT COUNT(*) FROM personal')->fetchColumn();

?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Personal</h2>
    <!-- To hide the "Create About me" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $education variable is empty or not.-->
    <?php if ($_SESSION["idcargo"] == 1): ?>
	<a href="create.php" class="create-personal">Create Personal</a>
    <?php endif; ?>
	<table class = "table">
        <thead>
            <tr>
                <td>User ID</td>
                <td>Personal ID</td>
                <td>Name</td>
                <td>Address</td>
                <td>Age</td>
                <td>Photo</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($personal as $per): ?>
            <tr>
                <td><?=$per['userId']?></td>
                <td><?=$per['pessoalId']?></td>
                <td><?=$per['nome']?></td>
                <td><?=$per['morada']?></td>
                <td><?=$per['idade']?></td>
                <td>
                <img witdh="100" height="100" src="<?php echo $per['imagem']; ?>">
                </td>
                <?php if ($_SESSION["idcargo"] == 1): ?>
                <td class="actions">
                    <a href="update.php?pessoalId=<?=$per['pessoalId']?>" ><button class = "b">edit </button></a>
                    <a href="delete.php?pessoalId=<?=$per['pessoalId']?>" ><button class = "b">delete </button> </a>
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
		<?php if ($page*$records_per_page < $num_personal): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
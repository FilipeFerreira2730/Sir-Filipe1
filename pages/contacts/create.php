<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $contactoId = isset($_POST['contactoId']) && !empty($_POST['contactoId']) && $_POST['contactoId'] != 'auto' ? $_POST['contactoId'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $icon = $_POST['icon'];
    $tipocontacto = isset($_POST['idtipo']) ? $_POST['idtipo'] : '';
    echo $tipocontacto;
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$contactoId, $icon, $nome, $tipocontacto, $_SESSION["id"]]);
    header('Location: read.php');
}
?>



<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">

        <label class = "table" for="nome">Icon</label>
        <input type="text" name="icon" placeholder="Icon" id="icon">
        <label class = "table" for="nome">Contact</label>
        <input type="text" name="nome" placeholder="Nome" id="nome">
        <label class = "table">Select a type</label>
        <select for="idtipo" name="idtipo">
            <?php
                
                $output="";
                $stmt = $pdo->prepare("SELECT * FROM tipocontacto");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $tipocontacto = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($tipocontacto as $row) {
                    $type = $row['tipoId'];
                    $typename = $row['nome'];
                
                $output .= "<option value='$type'>$typename</option>";     
                }    
                $output .="";
                echo $output;
        ?>
        </select>
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
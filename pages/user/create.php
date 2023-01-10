<?php 
    require "../../utils/functions.php";
    require "../../db/connection.php";
    $username = $_SESSION["username"];
    $cargo = $_SESSION["id"];

    $pdo = pdo_connect_mysql();
    $msg = '';


    // Check if POST data is not empty
if (!empty($_POST)) {    
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $userId = isset($_POST['userId']) && !empty($_POST['userId']) && $_POST['userId'] != 'auto' ? $_POST['userId'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $tipo = isset($_POST['idcargo']) ? $_POST['idcargo'] : '';
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    // Insert new record into the about_me table
    $sql = "INSERT INTO users (username, password, idcargo) VALUES (:username, :password, :idcargo)";

    if($stmt = $pdo->prepare($sql)){
        $param_username = $username;
        $param_tipo= $tipo;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":idcargo", $param_tipo, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        
        if($stmt->execute()){
            header("location: read.php");
        } 
        else{
            var_dump($pdo);
            echo "Ups! Try again please.";
        }

        unset($stmt);
    }

    header('Location: read.php');

}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create User</h2>
    <form action="create.php" method="post">
        <label class = "table">Select a role</label>
        <select for="idcargo" name="idcargo">
            <?php
                
                $output="";
                $stmt = $pdo->prepare("SELECT * FROM roles");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($roles as $row) {
                    $role = $row['cargoId'];
                    $rolename = $row['cargo'];
                
                $output .= "<option value='$role'>$rolename</option>";     
                }    
                $output .="";
                echo $output;
        ?>
        </select>

        <label class = "table" for="username">Username</label>
        <input type="text" name="username" placeholder="Username" userId="username">
        <label class = "table" for="password">Password</label>
        <input type="password" name="password" placeholder="Password" userId="password">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>


<?=template_footer()?>
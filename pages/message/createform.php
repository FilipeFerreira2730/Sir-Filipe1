<?php

#require "../../utils/header.php";
require "../../db/connection.php";
#$username = $_SESSION["username"];
#$userRole = $_SESSION["idcargo"];

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {    
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $mensagemId = isset($_POST['mensagemId']) && !empty($_POST['mensagemId']) && $_POST['mensagemId'] != 'auto' ? $_POST['mensagemId'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';
    $seen = isset($_POST['seen']) == 'true' ? 1 : 0;
    if ($seen) {
        // Update the value of seen_at only if seen is true
        $seen_at = date('m/d/Y h:i:s a', time());
    } else {
        $seen_at = "not seen yet";
    }
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    $created = date('m/d/Y h:i:s a', time());
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO message VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$mensagemId, $email, $mensagem, $nome, $created, $seen, $seen_at]);
    header('Location: ../../../index.php');
}
?>

<h2>Message Info</h2>
Your message was sent with success!</h3>
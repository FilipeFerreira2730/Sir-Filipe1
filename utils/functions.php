<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /Sir-Filipe/auth/login.php");
    exit;
}

function create_menu() {
    $userRole = $_SESSION["idcargo"];

        echo '<a href="/Sir-Filipe">Frontoffice</a>';
        echo '<a href="/Sir-Filipe/pages/user/read.php">Users</a>';
        echo '<a href="/Sir-Filipe/pages/personal/read.php">Personal</a>';
		echo '<a href="/Sir-Filipe/pages/contacts/read.php">Contacts</a>';
		echo '<a href="/Sir-Filipe/pages/languages/read.php">Languages</a>';
        echo '<a href="/Sir-Filipe/pages/skills/read.php">Skills</a>';
        echo '<a href="/Sir-Filipe/pages/certification/read.php">Certifications</a>';
        echo '<a href="/Sir-Filipe/pages/education/read.php">Education</a>';
        echo '<a href="/Sir-Filipe/pages/message/read.php">Message</a>';
		echo '<a href="/Sir-Filipe/pages/salary/salary.php">Salary</a>';
}

function template_header($title) {
	$username  = $_SESSION["username"];
	$userID  = $_SESSION["id"];
	$cargo = $_SESSION["idcargo"];

echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My CMS</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="/Sir-Filipe/assets/css/main.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<nav class="navtop">
		<div>
			<h1>Hello, $username </h1>
EOT;
create_menu();
echo <<<EOT
			<a href="/Sir-Filipe/auth/logout.php">Logout</a>
		</div>
	</nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
<?php
include "./db/connection.php";
$pdo = pdo_connect_mysql();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css" integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css" integrity="sha512-+oRH6u1nDGSm3hH8poU85YFIVTdSnS2f+texdPGrURaJh8hzmhMiZrQth6l56P4ZQmxeZzd2DqVEMqQoJ8J89A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/solid.min.css" integrity="sha512-uj2QCZdpo8PSbRGL/g5mXek6HM/APd7k/B5Hx/rkVFPNOxAQMXD+t+bG4Zv8OAdUpydZTU3UHmyjjiHv2Ww0PA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>Professional Profile</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg  sticky-top">
    <a class="navbar-brand" href="#profile"><strong>Profile</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <i id="menu" class="fa-solid fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#personal"><strong>Personal</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contacts"><strong>Contacts</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#languages"><strong>Languages</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#skills"><strong>Skills</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#certifications"><strong>Certifications</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#education"><strong>Education</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contactame"><strong>Contact me</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./pages/salary/salary.php"><strong>Salary</strong></a>
        </li>
      </ul>
    </div>
    <button class="nav-item">
          <a class="nav-link" href="./pages/personal/read.php"><strong>Edit</strong></a>
        </button>
    <button class="nav-item">
          <a class="nav-link" href="./auth/logout.php"><strong>LogOut</strong></a>
        </button>
        
  </nav>
<div class="linha">
  <section id="profile" class="container my-lg-5 p-5">
    <h1 id="professional" class="text-center mb-5">Professional Profile</h1>
    <hr></hr>
  </section>
</div>
<div class="linha">
  <section id="personal" class="container my-lg-5 p-5"> 
  <h2 class='text-center mb-5'>Personal Presentation</h2>
  <div class='col pb-5 text-center'>
  <div>
  <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM personal");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $per = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($per as $row) {
                $nome = $row['nome'];
                $idade = $row['idade'];
                $morada = $row['morada'];
                $imagem = $row['imagem'];

                $output .= "
                                  <div class='col pb-5'>
                                    <div class='imagem'>
                                        <img src='$imagem' class='img-fluid'>
                                    </div>
                                </div>
                                <div class='col'>
                                  <p><strong>Name:</strong> $nome</p>
                                  <p><strong>Age:</strong> $idade</p>
                                  <p><strong>Address:</strong> $morada</p>
                                </div>
                            </div>";
            }
            $output .= "";
            echo $output;
      ?>
  </div>
</section>
  <hr></hr>
</div>
<div class="linha">
  <section id="contacts" class="container my-lg-5 p-5">
    <div>
    <h2 class='text-center mb-5'>Contacts</h2>
    <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM contacts");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $per = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($per as $row) {
                $nome = $row['nome'];
                $icon = $row['icon'];
                $tipo = $row['idtipo'];

                $output .= "<div class='row row-cols-1 row-cols-md-3'>
                              <div class='col mb-5'>
                                <div class='card text-center flex-fill'>
                                  <div class='card-body'>
                                    <div class='card-title h1'><i class='$icon'></i></div>
                                      <p class'card-text'>
                                        <a href='$tipo'target='_blank' title=''>$nome</a>
                                      </p>
                                    </div>
                                 </a>
                                </div>
                             </div>
                            </div>";
            }
            $output .= "";
            echo $output;
            ?>
    </section>
 <div class="linha">
  <section id="languages" class="container my-lg-5 p-5">
    <div>
      <h2 class="text-center mb-5">Languages</h2>
      <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM languages");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $per = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($per as $row) {
                $nome = $row['nome'];
                $percentagem = $row['percentagem'];

                $output .= "<div class='col pb-5 text-center'>
                <p>$nome</p>
                <p><div class='progress'>
                  <div class='progress-bar' role='progressbar' aria-label='Basic example' style='width: $percentagem%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='10'></div>
                </div></p>
                </div>";
            }
            $output .= "";
            echo $output;
            ?>
      <hr></hr>
    </section>
 </div>  
 <div class="linha">
  <section id="skills" class="container my-lg-5 p-5">
    <div>
      <h2 class="text-center mb-5">Skills</h2>
      <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM skills");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $per = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($per as $row) {
                $nome = $row['nome'];
                $percentagem = $row['percentagem'];

                $output .= "<div class='col pb-5 text-center'>
                <p>$nome</p>
                <p><div class='progress'>
                  <div class='progress-bar' role='progressbar' aria-label='Basic example' style='width: $percentagem%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='10'></div>
                </div></p>
                </div>";
            }
            $output .= "";
            echo $output;
            ?>
  </section>  
    <hr></hr> 
 </div> 
 <div class="linha">
  <section id="certifications" class="container my-lg-5 p-5">
    <div>
      <h2 class="text-center mb-5">Certifications</h2>
      <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM certifications");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $per = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($per as $row) {
                $nome = $row['nome'];

                $output .= "<div class='col'>
                <p><i class='fa-solid fa-check'></i> $nome</p>
                </div>";
            }
            $output .= "";
            echo $output;
            ?>
  </section>
    <hr></hr>
 </div>
 <div class="linha">
  <section id="education"class="container my-lg-5 p-5">
    <div>
      <h2 class="text-center mb-5">Education</h2>
      <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM education");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $per = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($per as $row) {
                $imagem = $row['imagem'];
                $escola = $row['escola'];
                $descricao = $row['descricao'];

                $output .= "<div class='row row-cols-1 row-cols-md-2 g-4'>
                <div class='col'>
                <div class='card'>
                  <img src='$imagem' class='card-img-top img-fluid w-10' alt='...'>
                  <div class='card-body'>
                    <h5 class='card-title'>$escola</h5>
                    <p class='card-text text-dark'>$descricao</p>
                  </div>
                </div>
              </div>
              </div>";
            }
            $output .= "";
            echo $output;
            ?>
  </section>
 </div>  
  <section id="contactame" class="container my-lg-5 p-5">
    <h2 class="text-center mb-5">Contacta-me</h2>
  
    <form autocomplete="off" role="form" action="/Sir-Filipe/pages/message/createForm.php" method="post">
                <div class="form-group mb-3">
                    <label class=text-white for="nome">Name</label>
                    <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nameHelp" placeholder="Your name.." required>
                </div>

                <div class="form-group mb-3">
                    <label class=text-white for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" aria-describedby="nameHelp" placeholder="Your email.." required>
                </div>

                <div class="form-group mb-3">
                    <label class=text-white for="mensagem">Subject</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" placeholder="Message ..." rows="3"></textarea>
                </div>
              <div class="button">
                <button class = "b" type="submit" id="form-submit" class="btn.text-white">Submit</button>
                <button class = "b" type="reset" id="form-reset" class="btn.text-white"> Reset</button>
                </div>
            </form>
  </section>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
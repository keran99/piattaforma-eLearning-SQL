<!-- Page that allows teachers to select a database to view it -->
<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
 } else {
   $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['DBname']);
     if ($link === false) {
         die("ERROR:Could not connect. " . mysqli_connect_error());
     }
   $username = $_SESSION['username'];
   $sql = "SELECT TipoAccesso FROM UTENTE WHERE Username = '$username'";
   $result = mysqli_query($link, $sql);
    if(!$riga = mysqli_fetch_array($result)){
      header('location: index.php');
    } else {
      if ($riga['TipoAccesso'] != "Libero"){
        header('location: index.php');
      }
    }
 }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href="img/logo.png"/>
    <title> Basi di Dati - SQL </title>
  </head>
  <body>
    <!-- caricamento del navbar -->
    <?php require_once("navbarDocente.php") ?>

    <div class="container">
      <div class="row justify-content-around">
          <?php $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['DBname']);
            if ($link === false) {
                die("ERROR:Could not connect. " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM INFO_DATABASE ";
            $result = mysqli_query($link, $sql);
            while ($riga = mysqli_fetch_array(($result))) {
              echo "<div class='col-md-auto card mt-5 ml-3 mr-3' style='width: 18rem;'>
                    <img class='card-img-top mt-3' src='img/" . $riga['Immagine'] .  "' alt='Card image cap'>
                      <div class='card-body'>
                        <h5 class='card-title'>" . $riga['NomeDatabase']  . "</h5>
                        <p class='card-text'>" . $riga['Descrizione'] . "</p>
                          <form action='visualizzaDatabaseDocente.php' method='post'>
                          <input type='hidden' name='nomeDatabaseSelezionato' value='" . $riga['NomeDatabase'] . "'>
                          <button type='submit' name='selezionaDomandaButton' class='btn btn-primary'> Entra </button>
                        </form>
                      </div>
                    </div>";
            }
          ?>
      </div>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

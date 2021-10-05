<!-- Page that populates the database from code -->
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
  $codice = $_POST['inputCodice']
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

    <?php
    $mysqli = new mysqli($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['nomeDatabaseSelezionato']);
    if ($mysqli->connect_error) {
      die('Errore di connessione (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }
      $checkInserimento = true;
      $codiceSplited = explode(";", $codice);
      foreach ($codiceSplited as $codiceSelected) {
        if (!trim($codiceSelected)==null ){
          if (!$mysqli->query($codiceSelected)) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    Si è verificato un errore durante l'inserimento " . $codiceSelected ." - ". $mysqli->error ."
                  </div>";
            $checkInserimento=false;
          }
        }
      }

      if($checkInserimento==true){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                L'inserimento è avvenuta con successo
              </div>";
      }
    ?>

    <div class="container">
      <form action="popolaDatabaseCodice2.php" method="post">
        <div class="form-group mt-3">
          <textarea class="form-control" type="text" rows="15" name="inputCodice" placeholder="Inserire il codice per popolare il database" required></textarea>
        </div>
        <center><button type='submit' class='btn btn-primary'> ESEGUI </button></center>
      </form>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

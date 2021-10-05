<!-- Teacher homepage -->
<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
 } else {
   $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],   $_SESSION['DBname']);
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

        <div class="card mt-4" style="width: 18rem;">
          <img class="card-img-top" src="img/creaDatabase.png" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Creazione il database</h5>
            <p class="card-text">Accedendo in tale sezione è possibile creare un nuovo database</p>
            <center><a href="creaDatabase.php" class="btn btn-primary">VIA</a></center>
          </div>
        </div>

        <div class="card mt-4" style="width: 18rem;">
          <img class="card-img-top" src="img/creaDatabase.png" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Popolazione delle tabelle</h5>
            <p class="card-text">Accedendo in tale sezione è possibile popolare un database</p>
            <center><a href="selezionaDatabase.php" class="btn btn-primary">VIA</a></center>
          </div>
        </div>

        <div class="card mt-4" style="width: 18rem;">
          <img class="card-img-top" src="img/creaDatabase.png" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Inserimento di una domanda/ risposta</h5>
            <p class="card-text">Accedendo in tale sezione è possibile popolare un database</p>
            <center><a href="selezionaDatabaseInserimentoDomandaRisposta.php" class="btn btn-primary">VIA</a></center>
          </div>
        </div>

        <div class="card mt-4" style="width: 18rem;">
          <img class="card-img-top" src="img/creaDatabase.png" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Visualizzazione di un database</h5>
            <p class="card-text">Accedendo in tale sezione è possibile visualizzare il contenuto di un database</p>
            <center><a href="selezionaDatabaseVisualizzazione.php" class="btn btn-primary">VIA</a></center>
          </div>
        </div>

        <div class="card mt-4" style="width: 18rem;">
          <img class="card-img-top" src="img/creaDatabase.png" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Esecuzione di query</h5>
            <p class="card-text">Accedendo in tale sezione è possibile eseguire delle query</p>
            <center><a href="selezionaDatabaseQuery.php" class="btn btn-primary">VIA</a></center>
          </div>
        </div>

        <div class="card mt-4" style="width: 18rem;">
          <img class="card-img-top" src="img/creaDatabase.png" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Elimina un database</h5>
            <p class="card-text">Accedendo in tale sezione è possibile eliminare un database</p>
            <center><a href="selezionaDatabaseEliminazione.php" class="btn btn-primary">VIA</a></center>
          </div>
        </div>

      </div>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

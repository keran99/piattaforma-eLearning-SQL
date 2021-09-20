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
  $nomeDatabase = $_POST['nomeDatabase'];
  $codiceCreaTabelle = $_POST['codiceCreaTabelle'];
  $descrizione = $_POST['descrizione'];
  $immagine = $_POST['immagine'];
?>
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
      $check=true;
      $checkCreazione=true;
      if($nomeDatabase==null){
        echo "<div class='alert alert-warning alert-dismissible fade show mb-0' role='alert'>
                Inserire il nome del database
              </div>";
        $check=false;
      }

      if($codiceCreaTabelle==null){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                Non è stato inserito il codice per la creazione della tabella
              </div>";
        $check=false;
      }

      if ($check=true){
        $mysqli = new mysqli('localhost', 'root', '');
        if ($mysqli->connect_error) {
        	die('Errore di connessione (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
        }
        // Crea il database
        if (!$mysqli->query("CREATE DATABASE " . $nomeDatabase)) {
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  Si è verificato un errore durante la creazione del database - ". $mysqli->error ."
                </div>";
          $checkCreazione=false;
        }
        // Seleziono il database
        if (!$mysqli->query("USE " . $nomeDatabase)) {
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  Si è verificato un errore durante la selezione del database - ". $mysqli->error ."
                </div>";
          $checkCreazione=false;
        }

        // Crea Tabelle
        $codiceCreaTabelleSplited = explode(";", $codiceCreaTabelle);
        foreach ($codiceCreaTabelleSplited as $codiceCreaTabellaSelected) {
          if (!trim($codiceCreaTabellaSelected)==null ){
            if (!$mysqli->query($codiceCreaTabellaSelected)) {
              echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                      Si è verificato un errore durante la creazione della tabella " . $codiceCreaTabellaSelected ." - ". $mysqli->error ."
                    </div>";
              $checkCreazione=false;
            }
          }
        }

        if($checkCreazione==true){
          $link2 = mysqli_connect("localhost", "root", "", "ESERCIZI_SQL");
          if ($link2 === false) {
              die("ERROR:Could not connect. " . mysqli_connect_error());
          };

          $sqlCreazione = "INSERT INTO info_database (NomeDatabase, Descrizione, Immagine) VALUES ('" .$nomeDatabase . "','" . $descrizione . "','" . $immagine . "')";
          if(!$result = mysqli_query($link2, $sqlCreazione)){
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    Si è verificato un errore
                  </div>";
          } else {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    La creazione del database è avvenuta con successo
                  </div>";
          }
        }
      }
    ?>


    <div class="container">
      <div class="row justify-content-around mt-2">
        <h3 class="mt-2"> CREA IL DATABASE </h3>
      </div>

      <form action='creaDatabase2.php' method='post'>
        <div class="row justify-content-around mt-2">
          <input class="form-control" name="nomeDatabase" placeholder="Inserire il nome del database" required>
        </div>

        <div class="row justify-content-around mt-2">
          <textarea class="form-control" cols="70" rows="10" name="codiceCreaTabelle" placeholder="Inserisci il codice per la creazione delle tabelle"></textarea>
        </div>

        <div class="row justify-content-around mt-2">
          <input class="form-control" name="descrizione" placeholder="Inserire una descrizione del database">
        </div>

        <div class="row justify-content-around mt-2">
          <input type="file" class="form-control-file " name="immagine" >
        </div>

        <div class="row justify-content-around mt-2">
          <button type="submit" class="btn btn-primary"> Crea il database </button>
        </div>
      </form>

    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

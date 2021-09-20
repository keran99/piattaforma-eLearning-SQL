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
  $_SESSION['nomeDatabaseSelezionato'] = $_POST['nomeDatabaseSelezionato']
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
    <?php require_once("navbarDocente.php") ?>
    <form action='queryLiberiDocente2.php' method='post'>
      <div class="row justify-content-around mt-4">
        <?php echo $_SESSION['nomeDatabaseSelezionato'] ?>
      </div>
      <div class="row justify-content-around mt-4">
        <div class="form-group">
            <textarea class="form-control" cols="70" rows="15" name="queryLiberaUtente" required></textarea>
        </div>
      </div>
      <div class="row justify-content-around mt-4">
        <button type="submit" class="btn btn-primary" name="InviaQuaryLibera"> Visualizza il risulatato della query </button>
      </div>
    </form>
    <?php require_once("footer.php") ?>
  </body>
</html>

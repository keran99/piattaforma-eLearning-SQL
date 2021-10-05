<!-- Page that allows teachers to modify the question and / or correct answer -->

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
  $numero = $_POST['NumeroModifica'];
  $domanda = $_POST['DomandaModifica'];
  $risposta = $_POST['RispostaModifica']
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
        <?php
          $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['DBname']);
          if ($link === false) {
              die("ERROR:Could not connect. " . mysqli_connect_error());
          }

          $sql = "SELECT * FROM DOMANDA WHERE NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "' AND Numero = '" . $numero . "'";
          $result = mysqli_query($link, $sql);
          while($riga = mysqli_fetch_array($result)){;
            $domanda =  $riga['Domanda'];
            $risposta = $riga['Risposta'];
          }
        ?>

        <form action="postModificaDomandaRisposta.php" method="post">
          <div class="row justify-content-around mt-4">
            <div class="form-group m-1">
                <textarea class="form-control" cols="70" rows="14" name="domandaModificata"> <?php echo $domanda ?> </textarea>
            </div>
            <div class="form-group m-1">
                <textarea class="form-control" cols="70" rows="14" name="rispostaModificata"><?php echo $risposta ?> </textarea>
            </div>
          </div>

          <div class="row justify-content-around mt-4">
            <input type='hidden' name='NumeroModifica' value=' <?php echo $numero ?> '>
            <button type="submit" class="btn btn-primary" name="operazione" value=1> Salva </button>
            <button type="submit" class="btn btn-primary" name="operazione" value=2> Elimina </button>
          </div>
        </form>
      </div>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

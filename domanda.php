<!-- Page that allows students to view the questions associated with a particular database -->
<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
  }
  $_SESSION['DomandaSelezionata'] = $_POST['DomandaSelezionata']
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
    <?php require_once("navbarStudente.php") ?>

    <div class="container">
      <div class="row justify-content-around">
        <?php
          // DB connection
          $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],   $_SESSION['DBname']);
          if ($link === false) {
              die("ERROR:Could not connect. " . mysqli_connect_error());
          }

          // Extraction and viewing questions associated with the selected database
          $sql = "SELECT * FROM DOMANDA WHERE (Numero = '" . $_SESSION['DomandaSelezionata'] . "' AND NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "')";
          $result = mysqli_query($link, $sql);
          $riga = mysqli_fetch_array(($result));
          echo "<h5>" . $riga['Domanda'] . "</h5>";
        ?>
      </div>

      <form action='domanda2.php' method='post'>
        <div class="row justify-content-around">
          <div class="form-group">
              <textarea class="form-control" cols="70" rows="7" name="queryUtente" placeholder="Scrivi qui la tua query"></textarea>
          </div>
        </div>
        <div class="row justify-content-around">
          <div class="form-group">
            <?php
              if ($riga['Risposta']!= null){
                echo "<textarea class='form-control' cols='70' rows='7' readonly placeholder='Qui potrai visualizzare la soluzione'></textarea>";
              }
            ?>
          </div>
        </div>

        <!-- Previous question buttons -->
        <div class="row justify-content-around">
          <?php
            $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['DBname']);
            if ($link === false) {
                die("ERROR:Could not connect. " . mysqli_connect_error());
            }
            $checkDomandaPrecedente = $_SESSION['DomandaSelezionata']-1;
            $sql = "SELECT Risposta FROM DOMANDA WHERE (Numero = '" . $checkDomandaPrecedente . "' AND NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "')";
            $result = mysqli_query($link, $sql);
            $checkEsistenzaDomandaPrecedente = mysqli_fetch_array(($result));
            if (!empty($checkEsistenzaDomandaPrecedente)){
              echo "<button type='submit' class='btn btn-primary' name='tipoOperazioneRichiesta' value='1'> Domanda precedente </button>";
            }
          ?>

          <!-- Button to see the result of query -->
          <button type="submit" class="btn btn-primary" name="tipoOperazioneRichiesta" value="2"> Visualizza il risulatato della query </button>

          <?php
            // Botton that show correct answer
            if ($riga['Risposta']!= null){
              echo "<button type='submit' class='btn btn-primary' name='tipoOperazioneRichiesta' value='3'>  Visualizza la risposta corretta </button>";
            }
          ?>

          <!-- Button to send the query to the teacher -->
          <button type="submit" class="btn btn-primary" name="tipoOperazioneRichiesta" value="5"> Invia la risposta al Docente </button>

          <!-- Next question button -->
          <?php
            $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],   $_SESSION['DBname']);
            if ($link === false) {
                die("ERROR:Could not connect. " . mysqli_connect_error());
            }
            $checkDomandaSuccessiva = $_SESSION['DomandaSelezionata']+1;
            $sql = "SELECT Risposta FROM DOMANDA WHERE (Numero = '" . $checkDomandaSuccessiva . "' AND NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "')";
            $result = mysqli_query($link, $sql);
            $checkEsistenzaDomandaPrecedente = mysqli_fetch_array(($result));
            if (!empty($checkEsistenzaDomandaPrecedente)){
              echo "<button type='submit' class='btn btn-primary' name='tipoOperazioneRichiesta' value='4'> Domanda successiva </button>";
            }
          ?>
        </div>
      </form>
    </div>

    <?php require_once("footer.php") ?>
  </body>
</html>

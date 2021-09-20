<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
  }
  $queryUtente = $_POST['queryUtente'];
  $tipoOperazione = $_POST['tipoOperazioneRichiesta']
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
    <?php require_once("navbarStudente.php") ?>

    <?php
      if ($tipoOperazione==5 && trim($queryUtente) != null){
        $link = mysqli_connect($_SESSION['servername'], "studenteInsert", $_SESSION['psw'], $_SESSION['DBname']);
        if ($link === false) {
            die("ERROR:Could not connect. " . mysqli_connect_error());
        }

        $username = $_SESSION['username'];
        $domanda = $_SESSION['DomandaSelezionata'];
        $nomeDB = $_SESSION['nomeDatabaseSelezionato'];
        $queryInserimento = "INSERT INTO RISPOSTE_ALUNNI (Username, Risposta, Domanda, NomeDB) VALUES ('" . $username . "','" . $queryUtente . "','" . $domanda . "','" . $nomeDB . "')";
        if ($result = mysqli_query($link, $queryInserimento)){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  Risposta inviata al docente
                </div>";
        } else {
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  Si è verificato un errore durante l'invio
                </div>";
        }
      } else if ($tipoOperazione==5){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                Impossibile inviare la risposta al docente
              </div>";
      }

    ?>

    <div class="container">
      <div class="row justify-content-around">
        <?php

          if ($tipoOperazione==1){
            $_SESSION['DomandaSelezionata'] = $_SESSION['DomandaSelezionata']-1;
          }
          if ($tipoOperazione==4){
            $_SESSION['DomandaSelezionata'] = $_SESSION['DomandaSelezionata']+1;
          }

          $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],   $_SESSION['DBname']);
          if ($link === false) {
              die("ERROR:Could not connect. " . mysqli_connect_error());
          }
          $sql = "SELECT * FROM DOMANDA WHERE (Numero = '" . $_SESSION['DomandaSelezionata'] . "' AND NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "')";
          $result = mysqli_query($link, $sql);
          $riga = mysqli_fetch_array(($result));
          echo "<h5>" . $riga['Domanda'] . "</h5>";
        ?>
      </div>

      <form action='domanda2.php' method='post'>
        <div class="row justify-content-around">
          <div class="form-group">
              <textarea class="form-control" cols="70" rows="7" name="queryUtente"> <?php if (($tipoOperazione==2) || ($tipoOperazione==3)) {echo trim($queryUtente);} ?> </textarea>
          </div>
          <div class="form-group">
              <!--<textarea class="form-control" cols="70" rows="7" readonly> -->
                <?php
                  if ( ( $queryUtente!= null && $tipoOperazione==2 ) || ( $queryUtente!= null && $tipoOperazione==3) ) {
                    $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['nomeDatabaseSelezionato']);
                    if ($link === false) {
                        die("ERROR:Could not connect. " . mysqli_connect_error());
                    }
                    $sql = $queryUtente;
                    if (!$result = mysqli_query($link, $sql)){
                      echo "Forma della query errata o operazione non consetita";
                    } else {
                    if (mysqli_num_rows($result)<1) {
                      echo "La query non ha generato nessun risultato";
                    } else {
                      $rigaRisultato = mysqli_fetch_assoc($result);
                      echo "<table border='1'>";
                      echo "<tr>";
                      echo "<th>".join("</th><th>",array_keys($rigaRisultato))."</th>";
                      echo "</tr>";
                      while ($rigaRisultato) {
                        echo "<tr>";
                         echo "<td>".join("</td><td>",$rigaRisultato)."</td>";
                         echo "</tr>";
                         $rigaRisultato = mysqli_fetch_assoc($result);
                      };
                      echo "</table>";
                    }
                  }
                }
                ?>
              <!-- </textarea> -->
          </div>
        </div>
        <div class="row justify-content-around">
          <div class="form-group">

            <?php
            if ($riga['Risposta']!= null){
              echo "<textarea class='form-control' cols='70' rows='7' readonly placeholder='Qui potrai visualizzare la soluzione'>";
            }
            if ($tipoOperazione==3){
              $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],   $_SESSION['DBname']);
              if ($link === false) {
                  die("ERROR:Could not connect. " . mysqli_connect_error());
              }
              $sql = "SELECT Risposta FROM DOMANDA WHERE (Numero = '" . $_SESSION['DomandaSelezionata'] . "' AND NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "')";
              $result = mysqli_query($link, $sql);
              $soluzione = mysqli_fetch_array(($result));
              echo $soluzione['Risposta'];
            }
            if ($riga['Risposta']!= null){
              echo "</textarea>";
            }
          ?>

          </div>
          <div class="form-group">
              <!--<textarea class="form-control" cols="70" rows="7" readonly>-->
                  <?php
                    if ($tipoOperazione==3){
                      $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['nomeDatabaseSelezionato']);
                      if ($link === false) {
                          die("ERROR:Could not connect. " . mysqli_connect_error());
                      }
                      $sql = $soluzione['Risposta'];

                      if (!$result = mysqli_query($link, $sql)){
                        echo "Forma della query errata";
                      } else {
                      if (mysqli_num_rows($result)<1) {
                        echo "La query non ha generato nessun risultato";
                      } else {
                        $rigaSoluzione = mysqli_fetch_assoc($result);
                        echo "<table border='1'>";
                        echo "<tr>";
                        echo "<th>".join("</th><th>",array_keys($rigaSoluzione))."</th>";
                        echo "</tr>";
                        while ($rigaSoluzione) {
                          echo "<tr>";
                           echo "<td>".join("</td><td>",$rigaSoluzione)."</td>";
                           echo "</tr>";
                           $rigaSoluzione = mysqli_fetch_assoc($result);
                        };
                        echo "</table>";
                      }
                    }
                  }
                ?>
              <!--</textarea>-->
          </div>
        </div>

        <div class="row justify-content-around">
          <?php
            $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],$_SESSION['DBname']);
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


          <button type="submit" class="btn btn-primary" name="tipoOperazioneRichiesta" value="2"> Visualizza il risulatato della query </button>

          <?php
            if ($riga['Risposta']!= null){
              echo "<button type='submit' class='btn btn-primary' name='tipoOperazioneRichiesta' value='3'>  Visualizza la risposta corretta </button>";
            }
          ?>

          <button type="submit" class="btn btn-primary" name="tipoOperazioneRichiesta" value="5"> Invia la risposta al Docente </button>

          <?php
            $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['DBname']);
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

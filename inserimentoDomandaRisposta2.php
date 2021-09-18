<?php
  session_start();if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
  } else {
   $link = mysqli_connect("localhost", "root", "", "ESERCIZI_SQL");
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
  $numero = $_POST['numero'];
  $domanda = $_POST['domanda'];
  $risposta = $_POST['risposta'];
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
      if (trim($domanda)==null){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                ERRORE: Inserire la domanda
              </div>";
      } else {
        $link = mysqli_connect("localhost", "root", "", "ESERCIZI_SQL");
        if ($link === false) {
            die("ERROR:Could not connect. " . mysqli_connect_error());
        }

        $query = "INSERT INTO domanda(Numero, NomeDatabase, Domanda, Risposta) VALUES ('" . $numero . "','" . $_SESSION['nomeDatabaseSelezionato'] ."','" . $domanda . "','" . $risposta ."')";
        if (!$result = mysqli_query($link, $query)){
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  Si è verificato un errore durante l'inserimento;
                </div>";
        };
      }
    ?>

    <div class="container">
      <div class="row justify-content-around">
        <table class='table table-striped'>
          <thead>
            <tr>
              <th scope='col'> Numero </th>
              <th scope='col'> Domanda </th>
              <th scope='col'> Risposta </th>
            </tr>
          </thead>
          <tbody>

          <?php $link = mysqli_connect("localhost", "root", "", "ESERCIZI_SQL");
            if ($link === false) {
                die("ERROR:Could not connect. " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM DOMANDA WHERE NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "'";
            $result = mysqli_query($link, $sql);
            while ($riga = mysqli_fetch_array(($result))) {
              $num = $riga['Numero'];
              echo "<tr>
                      <td>" . $riga['Numero'] . "</th>
                      <td>" . $riga['Domanda'] . "</td>
                      <td>" . $riga['Risposta'] . "</td>
                      <td>
                      <form action='modificaDomandaRisposta.php' method='post'>
                        <input type='hidden' name='NumeroModifica' value='" . $riga['Numero'] . "'>
                        <input type='hidden' name='DomandaModifica' value='" . $riga['Domanda'] . "'>
                        <input type='hidden' name='RispostaModifica' value='" . $riga['Risposta'] . "'>
                        <button type='submit'  class='btn btn-primary'> MODIFICA </button>
                      </form>
                      </td>
                    </tr>";
            };
            $num = $num +1;
            echo "<tr>
                    <form action='inserimentoDomandaRisposta2.php' method='post'>
                      <td> <input class='form-control mb-2' type='hidden' name='numero' value= '$num'>" . $num . "</input></th>
                      <td> <input class='form-control mb-2' type='text' name='domanda' placeholder='Inserire la domanda' required/> </td>
                      <td> <input class='form-control mb-2' type='text' name='risposta' placeholder='Inserire la risposta'/> </td>
                      <td> <button type='submit'  class='btn btn-primary'> INSERISCI </button>
                    </form>"
          ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

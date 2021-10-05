<!-- Page that allows teachers to view all queries sent by students -->
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
        <table class='table table-striped'>
              <thead>
                <tr>
                  <th scope='col'> Username </th>
                  <th scope='col'> Domanda </th>
                  <th scope='col'> Risposta </th>
                </tr>
              </thead>
              <tbody>

        <?php
          $sql = "SELECT * FROM RISPOSTE_ALUNNI ORDER BY id DESC";
          $result = mysqli_query($link, $sql);
          while ($riga = mysqli_fetch_array($result)) {
            $nomeDB = $riga['NomeDB'];
            $numero = $riga['Domanda'];
            $sql2 = "SELECT Domanda FROM DOMANDA WHERE NomeDatabase = '" . $nomeDB . "' AND Numero = " . $numero . "";
            $result2 = mysqli_query($link, $sql2);
            $riga2 = mysqli_fetch_array($result2);
            $risposta = $riga['Risposta'];
            $domanda = $riga2['Domanda'];
            echo "<tr>
                    <form action='visualizzaRisposteAlunni2.php' method='post'>
                      <td>" . $riga['Username'] . "</th>
                      <td>" . $domanda . "</td>
                      <td>" . $risposta . "</td>
                      <input type='hidden' name='risposta' value='$risposta'>
                      <input type='hidden' name='domanda' value='$domanda'>
                      <input type='hidden' name='nomeDB' value='$nomeDB'>
                      <td> <button type='submit' name='selezionaDomandaButton' class='btn btn-primary'> VAI </button> </td>
                    </form>
                  </tr>";
          }
          ?>
          </tbody>
        </table>
        </div>
      </div>

    <?php require_once("footer.php") ?>
  </body>
</html>

<?php
  session_start();

  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
 }

  $_SESSION['nomeDatabaseSelezionato'] = $_POST['nomeDatabaseSelezionato'];
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
    <div class="container">
      <div class="row justify-content-around">
        <table class='table table-striped'>
              <thead>
                <tr>
                  <th scope='col'> Numero </th>
                  <th scope='col'> Domanda </th>
                </tr>
              </thead>
              <tbody>

        <?php $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['DBname']);
          if ($link === false) {
              die("ERROR:Could not connect. " . mysqli_connect_error());
          }
          $sql = "SELECT * FROM DOMANDA WHERE NomeDatabase = '" . $_SESSION['nomeDatabaseSelezionato'] . "'";
          $result = mysqli_query($link, $sql);
          while ($riga = mysqli_fetch_array(($result))) {
            echo "<tr>
                      <td>" . $riga['Numero'] . "</th>
                      <td>" . $riga['Domanda'] . "</td>
                      <td>
                        <form action='domanda.php' method='post'>
                          <input type='hidden' name='DomandaSelezionata' value='" . $riga['Numero'] . "'>
                           <input type='hidden' name='nomeDatabaseSelezionato' value='" . $_SESSION['nomeDatabaseSelezionato'] . "'>
                           <button type='submit'  class='btn btn-primary'> VAI </button>
                        </form>
                    </tr>";
          }
          ?>
          </tbody>
        </table>
        </div>
        <div class="row justify-content-around">
          <button type="submit" class="btn btn-primary" onclick="location.href='queryLiberi.php'"> Query liberi</button>
          <button type="submit" class="btn btn-primary" onclick="location.href='visualizzaDatabase.php'"> Visualizza il database </button>
        </div>
      </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

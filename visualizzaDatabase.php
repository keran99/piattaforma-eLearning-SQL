<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
 }
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
        <?php
          $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'], $_SESSION['nomeDatabaseSelezionato']);
          if ($link === false) {
              die("ERROR:Could not connect. " . mysqli_connect_error());
          }


          $sqlNomeTabelle = "SHOW TABLES FROM " . $_SESSION['nomeDatabaseSelezionato'];

          if (!$nomeTabelle = mysqli_query($link, $sqlNomeTabelle)){
            echo "si è verificato un errore Tabella";
          } else {
          $nomeTabelle = mysqli_query($link, $sqlNomeTabelle);
          while ($row = mysqli_fetch_array($nomeTabelle)){
            $sql = "SELECT * FROM " .$row[0];
            if (!$result = mysqli_query($link, $sql)){
              echo "si è verificato un errore";
            } else {
              if (mysqli_num_rows($result)<1) {
                echo "La query non ha generato nessun risultato";
              } else {
                echo "<div><center><h5>" . $row[0] . "</h5></center>";
                $riga = mysqli_fetch_assoc($result);
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>".join("</th><th>",array_keys($riga))."</th>";
                echo "</tr>";
                while ($riga) {
                  echo "<tr>";
                   echo "<td>".join("</td><td>",$riga)."</td>";
                   echo "</tr>";
                   $riga = mysqli_fetch_assoc($result);
                };
                echo "</table></div>";
              }
            }
          }
        }

          ?>
      </div>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

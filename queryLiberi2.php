<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
  }
  $queryInserita = $_POST['queryLiberaUtente'];
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
    <form action='queryLiberi2.php' method='post'>
      <div class="row justify-content-around mt-4">
        <div class="form-group">
            <textarea class="form-control" cols="70" rows="15" name="queryLiberaUtente"> <?php echo $queryInserita ?></textarea>
        </div>
        <div>
          <?php
            $link = mysqli_connect("localhost", "studente", "", $_SESSION['nomeDatabaseSelezionato']);
            if ($link === false) {
                die("ERROR:Could not connect. " . mysqli_connect_error());
            }
            $sql = $queryInserita;

            if (!$result = mysqli_query($link, $sql)){
              echo "Forma della query errata o operazione non consentita";
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
          ?>
        </div>
      </div>
      <div class="row justify-content-around mt-4">
        <button type="submit" class="btn btn-primary" name="InviaQuaryLibera" required> Visualizza il risulatato della query </button>
      </div>
    </form>
    <?php require_once("footer.php") ?>
  </body>
</html>

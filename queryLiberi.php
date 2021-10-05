<!-- Page that allows students to write a query -->

<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
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
    <?php require_once("navbarStudente.php") ?>
    <form action='queryLiberi2.php' method='post'>
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

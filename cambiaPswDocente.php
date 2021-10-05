<!-- Page that allows teachers to change their password -->
<?php
  session_start();
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
   header('location: index.php');
 }
  $link = mysqli_connect($_SESSION['servername'], $_SESSION['usertype'], $_SESSION['psw'],   $_SESSION['DBname']);
  // Check connection
  if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  $username = $_SESSION['username'];
  $sql = "SELECT * FROM UTENTE WHERE Username = '$username'";
  $result = mysqli_query($link, $sql);
  $riga = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title> Basi di Dati - SQL </title>
    <link rel="icon" href="img/logo.png"/>
  </head>
  <body>
    <!-- caricamento del navbar -->
    <?php require_once("navbarDocente.php") ?>

    <?php
      $username = $_SESSION['username'];
      $vecchiaPsw = $_POST['psw'];
      $nuovaPsw = $_POST['nuovaPsw'];
      $confermaNuovaPsw = $_POST['confermaNuovaPsw'];

      // New password and new password confirmation do not match
      if ($nuovaPsw != $confermaNuovaPsw){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                ERRORE: password e conferma password non corrispondono
              </div>";
      }
      // New password and curren password are the same
      else if ($vecchiaPsw == $nuovaPsw){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                ERRORE: la password attuale e la nuova password sono uguali
              </div>";
      } else {
        $link = mysqli_connect("localhost", "studenteInsert", "", "ESERCIZI_SQL");
        if ($link === false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Checking the correctness of the current password
        $queryCheckPsw = "SELECT * FROM UTENTE WHERE Username = '$username'";
        $result = mysqli_query($link, $queryCheckPsw);
        $riga = mysqli_fetch_array($result);
        if ($riga['Password'] == hash_hmac('sha512', 'salt' . $vecchiaPsw, '3')) {
          $pswCriptato =  hash_hmac('sha512', 'salt' . $nuovaPsw, '3');
          $queryUpdatePsw = "UPDATE Utente SET Password ='" . $pswCriptato . "' WHERE username ='" . $username . "'";
          // An error occurred during the password change
          if(!$result2 = mysqli_query($link, $queryUpdatePsw)){
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    ERRORE: Si è verificato un errore durante la modifica della password
                  </div>";
          }
          // Password changed successfully
          else {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Modifica avvenuta con succcesso
                  </div>";
          }
        }
        // Incorrect current password
        else {
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  ERRORE: la password attuale errate
                </div>";
        }
      }
    ?>

    <!-- Form where you can view: name, surname, username. And you can change the password.-->
    <div class="container">
      <div class="row justify-content-around">
        <div class="col-6 border border-primary mt-3">
          <div class="form-group">
            <center><label class="mt-3">Nome</label></center>
            <input type="text" class="form-control" name="nome" placeholder="<?php echo $riga['Nome'] ?>" readonly>
          </div>
          <div class="form-group">
            <center><label>Cognome</label></center>
            <input type="text" class="form-control" name="cognome" placeholder="<?php echo $riga['Cognome'] ?>" readonly>
          </div>
          <div class="form-group">
            <center><label>Username</label></center>
            <input type="text" class="form-control" name="username" placeholder="<?php echo $username ?>" readonly>
          </div>
        </div>

        <div class="col-6 border border-primary mt-3">
          <center><h5 class ="text-primary"> Cambia la Password </h5></center>
          <form action='cambiaPswDocente.php' method='post'>
            <div class="form-group">
              <center><label>Password</label></center>
              <input type="password" class="form-control" name="psw" placeholder="Inserire la password" required>
            </div>
            <div class="form-group">
              <center><label>Nuova Password</label></center>
              <input type="password" class="form-control" name="nuovaPsw" placeholder="Inserire la nuova password" required>
            </div>
            <div class="form-group">
              <center><label>Conferma la nuova password</label></center>
              <input type="password" class="form-control" name="confermaNuovaPsw" placeholder="Confermare la nuova password" required>
            </div>
            <div class="d-flex justify-content-around">
              <button type="submit" class="btn btn-primary mb-2">Modifica Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php require_once("footer.php") ?>
  </body>
</html>

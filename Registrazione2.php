<!-- Registration page -->
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
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">

      <a class="navbar-brand">Basi di Dati - SQL</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>

    <?php
      session_start();
      $link = mysqli_connect("localhost", "root", "", "ESERCIZI_SQL");
      if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      $nome = $_POST['nome'];
      $cognome = $_POST['cognome'];
      $username = $_POST['username'];
      $password = $_POST['psw'];
      $confermaPassword = $_POST['confermaPsw'];

      $queryCheckUsername = "SELECT * FROM Utente WHERE Username = '" . $username . "'";
      $resultCheckUsername = mysqli_query($link, $queryCheckUsername);
      $num = mysqli_num_rows($resultCheckUsername);
      if ($num == 0){
        if ($password ==$confermaPassword){
          $pswCriptato = hash_hmac('sha512', 'salt' . $password, '3');
          $queryInserimento = "INSERT INTO UTENTE (Username, Password, Nome, Cognome, TipoAccesso) VALUES ('" . $username . "','" . $pswCriptato . "','" . $nome . "','" . $cognome . "','Limitato')";
          echo $queryInserimento;
          if(!$resultInserimento = mysqli_query($link, $queryInserimento)){
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    ERRORE: si è verificato un errore durante la registrazione
                  </div>";
          } else {
            $_SESSION['username'] = $username;
            header('location: homepageStudente.php');
          }
        } else {
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  ERRORE: password e conferma password non corrispondono
                </div>";
        }
      } else {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
          ERRORE: Username non disponibile
        </div>";
      }
    ?>


    <div class="container">
      <div class="row justify-content-center">

        <div class="col-6 border border-primary mt-3">
          <form  action='#' method='post'>
            <div class="form-group">
              <center><label class="mt-3">Nome</label></center>
              <input type="text" class="form-control" name="nome" placeholder="Inserire il nome">
            </div>
            <div class="form-group">
              <center><label>Cognome</label></center>
              <input type="text" class="form-control" name="cognome" placeholder="Inserire il congome">
            </div>
            <div class="form-group">
              <center><label>Username</label></center>
              <input type="text" class="form-control" name="username" placeholder="Inserire lo username">
            </div>
            <div class="form-group">
              <center><label>Password</label></center>
              <input type="password" class="form-control" name="psw" placeholder="Inserire la password">
            </div>
            <div class="form-group">
              <center><label>Conferma password</label></center>
              <input type="password" class="form-control" name="confermaPsw" placeholder="Confermare la password">
            </div>
            <div class="d-flex justify-content-around">
              <button type="submit" class="btn btn-primary mb-2">Registra</button>
            </div>
            <div class="d-flex justify-content-around">
              <a class="mb-2" href="index.php">Pagina di Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

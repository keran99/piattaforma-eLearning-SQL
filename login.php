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
    <?php
    session_start();
    $link = mysqli_connect("localhost", "studente", "", "ESERCIZI_SQL");
    // Check connection
    if ($link === false) {
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $username = $_POST['username'];
    $psw = $_POST['psw'];
    $sql = "SELECT * FROM UTENTE WHERE Username = '$username'";
    $result = mysqli_query($link, $sql);

    if(!$riga = mysqli_fetch_array($result)){
      echo "<nav class='navbar navbar-expand-lg navbar navbar-dark bg-primary'>
        <a class='navbar-brand'>Basi di Dati - SQL</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
          <span class='navbar-toggler-icon'></span>
        </button>
      </nav>
      <div class='container'>
        <div class='row justify-content-center'>
          <div class='col-6 border border-primary mt-3'>
            <form action='login.php' method='post'>
              <div class='form-group'>
                <label class='mt-3'>Username</label>
                <input type='text' class='form-control' name='username' placeholder='Inserire username' required>
              </div>
              <div class='form-group'>
                <label>Password</label>
                <input type='password' class='form-control' name='psw' placeholder='Inserire la password' required>
              </div>
              <center><button type='submit' class='btn btn-primary'>Login</button></center>
              <div class='d-flex justify-content-around'>
                <a class='mt-2' href='registrazione.php'>Crea un account</a>
              </div>
            </form>
            <div class='row justify-content-center'>
              <label class='text-danger'> L'username o la password errata</label>
            </div>
          </div>
        </div>
      </div>";
    } else {
    if ($riga['Password'] == hash_hmac('sha512', 'salt' . $psw, '3')) {
      $_SESSION['username'] = $username;
      $_SESSION['servername']="localhost";
      $_SESSION['psw']="";
      $_SESSION['DBname']="ESERCIZI_SQL";
      //echo "logged";
      if ($riga['TipoAccesso']=="Limitato"){
        header('location: homepageStudente.php');
          $_SESSION['usertype']="studente";
      }
      if ($riga['TipoAccesso'] =="Libero"){
        header('location: homepageDocente.php');
          $_SESSION['usertype']="root";
      }
     } else {
      echo "<nav class='navbar navbar-expand-lg navbar navbar-dark bg-primary'>
        <a class='navbar-brand'>Basi di Dati - SQL</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
          <span class='navbar-toggler-icon'></span>
        </button>
      </nav>
      <div class='container'>
        <div class='row justify-content-center'>
          <div class='col-6 border border-primary mt-3'>
            <form action='login.php' method='post'>
              <div class='form-group'>
                <label class='mt-3'>Username</label>
                <input type='text' class='form-control' name='username' placeholder='Inserire username' required>
              </div>
              <div class='form-group'>
                <label>Password</label>
                <input type='password' class='form-control' name='psw' placeholder='Inserire la password' required>
              </div>
              <center><button type='submit' class='btn btn-primary'>Login</button></center>
              <div class='d-flex justify-content-around'>
                <a class='mt-2' href='registrazione.php'>Crea un account</a>
              </div>
            </form>
            <div class='row justify-content-center'>
              <label class='text-danger'> L'username o la password errata</label>
            </div>
          </div>
        </div>
      </div>";

  }
}
  ?>

  </body>
</html>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href="img/logo.png" />
    <title> Basi di Dati - SQL </title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">

      <a class="navbar-brand">Basi di Dati - SQL</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6 border border-primary mt-3">
          <form action='login.php' method='post'>
            <div class="form-group">
              <label class="mt-3">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Inserire username" required>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="psw" placeholder="Inserire la password" required>
            </div>
            <center><button type="submit" class="btn btn-primary">Login</button></center>
            <div class="d-flex justify-content-around">
              <a class="m-2" href="registrazione.php">Crea un account</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

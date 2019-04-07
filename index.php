<?php
session_start();
$info = "Welcome !";
if (isset($_POST["dbname"])) {
  $_SESSION['dbname'] = $_POST['dbname'];
  $_SESSION['user'] = $_POST['user'];
  $_SESSION['password'] = $_POST['password'];
  header("Location: /views/tables.php");
}
if (isset($_GET["logout"])) {
  session_destroy();
  $info = "You've been logged out";
}
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Codmoa: login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
  </head>

  <body>
    <div class="container">
      <div class="columns is-multiline">
        <div class="column is-three-fifths is-offset-one-fifth">
          <h2 class="title"><?= $info ?></h2>
          <form action="/login" method="POST">
            <label class="label">Postgres credentials</label>
            <div id="row" class="field is-horizontal">
              <div class="field-body">
                <div class="field">
                  <input class="input" placeholder="database" type="text" name="dbname" required />
                </div>
                <div class="field">
                  <input class="input" placeholder="username" type="text" name="user" required />
                </div>
                <div class="field">
                  <input class="input" placeholder="password" type="password" name="password" required />
                </div>
              </div>
            </div>
            <div class="field">
              <button class="button is-link">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>

</html>
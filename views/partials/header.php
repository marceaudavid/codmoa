<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
    <link rel="stylesheet" href="/codmoa/assets/css/main.css">
  </head>

  <body>
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
      <div class="navbar-start">
        <a class="navbar-item" href="/codmoa/views/schemas.php">
          Schemas
        </a>
        <a class="navbar-item" href="/codmoa/views/tables.php">
          Tables
        </a>
        <a class="navbar-item" href="/codmoa/views/users.php">
          Users
        </a>
      </div>
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a href="/codmoa/index.php?logout" class="button is-primary">
              <strong>Logout</strong>
            </a>
          </div>
        </div>
      </div>
    </nav>
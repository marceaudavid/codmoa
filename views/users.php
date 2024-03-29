<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$title = "Codmoa: users";
$res = $db->query("SELECT * FROM pg_catalog.pg_user");
if (isset($_POST["username"])) {
  $createdb = $_POST['db'] === "CREATEDB" ? "CREATEDB" : "";
  $createuser = $_POST['user'] === "CREATEUSER" ? "CREATEUSER" : "";
  $query = "CREATE USER " . $_POST["username"] . " WITH ENCRYPTED PASSWORD '" . $_POST["password"] . "' " . $createdb . "  " . $createuser;
  $db->query($query);
}
?>
<?php require "partials/header.php"; ?>
<div class="container">
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Users</h1>
    </div>
  </div>
  <?php foreach ($res as $row): ?>
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <a href="/codmoa/views/user.php?id=<?= $row["usename"] ?>">
        <div class="box">
          <span><?= $row["usename"] ?></span>
          <span class="icon is-small">
            <i class="fas fa-chevron-right"></i>
          </span>
        </div>
      </a>
    </div>
  </div>
  <?php endforeach; ?>
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Create new User</h1>
      <form action="/codmoa/views/users.php" method="POST">
        <div id="form">
          <div class="field">
            <input class="input" type="text" placeholder="User Name" name="username" required>
          </div>
          <div class="field">
            <input class="input" type="password" placeholder="User Password" name="password" required>
          </div>
          <div id="row" class="field is-horizontal">
            <div class="field-body">
              <div class="field">
                <label class="label">Options</label>
                <div class="select">
                  <select name="db" required>
                    <option>NOCREATEDB</option>
                    <option>CREATEDB</option>
                  </select>
                </div>
                <div class="select">
                  <select name="user" required>
                    <option>NOCREATEROLE</option>
                    <option>CREATEROLE</option>
                  </select>
                </div>
              </div>
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
<?php require "partials/footer.php"; ?>
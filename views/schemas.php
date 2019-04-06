<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$res = $db->query("SELECT schema_name,catalog_name,schema_owner FROM information_schema.schemata");

if (isset($_POST["schema"])) {
  var_dump($_POST);
  $schema = htmlentities($_POST["schema"]);
  $query = "CREATE SCHEMA IF NOT EXISTS " . $schema . " AUTHORIZATION " . $_SESSION["user"];
  var_dump($query);
  // $db->query($query);
}
?>
<?php require "partials/header.php"; ?>
<div class="container">
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Schemas</h1>
    </div>
  </div><?php foreach ($res as $row): ?>
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <a href="/views/schema.php?id=<?= $row["schema_name"] ?>">
        <div class="box">
          <span><?= $row["schema_name"] ?></span>
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
      <h1 class="title">Create new Schema</h1>
      <form action="/views/schemas.php" method="POST">
        <div id="form">
          <div class="field">
            <input class="input" type="text" placeholder="Schema Name" name="schema" required>
          </div>
          <div class="field">
            <button class="button is-link">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>
<?php require "partials/footer.php"; ?>
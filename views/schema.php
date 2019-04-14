<?php
session_start();
if (!isset($_SESSION['dbname']) && !isset($_SESSION['user']) && !isset($_SESSION['password'])) {
  header('Location: /');
}

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$id = $_GET['id'];
$title = "Codmoa: schema $id";
$res = $db->query("SELECT schema_name,catalog_name,schema_owner FROM information_schema.schemata WHERE schema_name='$id'");
?>
<?php require "partials/header.php"; ?>
<div class="container">
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Schema - <?= $id ?></h1>
      <table class="table is-narrow is-bordered">
        <tbody>
          <tr>
            <th>Name</th>
            <th>Database</th>
            <th>Owner</th>
          </tr>
          <?php foreach ($res as $row): ?>
          <tr>
            <td><?= $row["schema_name"] ?></td>
            <td><?= $row["catalog_name"] ?></td>
            <td><?= $row["schema_owner"] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require "partials/footer.php"; ?>
<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$id = $_GET['id'];
$schema = $_GET['schema'];
$title = "Codmoa: table $id";
$res = $db->query("SELECT * FROM $schema.$id");
$columns = $db->getColumnsName("SELECT * FROM $schema.$id");
?>
<?php require "partials/header.php"; ?>
<div style="overflow: auto">
  <table class="table is-narrow is-bordered is-hoverable">
    <tbody>
      <?php if ($res): ?>
      <tr>
        <?php foreach ($columns as $col): ?>
        <th><?= $col ?></th>
        <?php endforeach; ?>
      </tr>
      <?php foreach ($res as $row): ?>
      <tr>
        <?php foreach ($columns as $col): ?>
        <td><?= $row[$col] ?></td>
        <?php endforeach; ?>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div><?php require "partials/footer.php"; ?>
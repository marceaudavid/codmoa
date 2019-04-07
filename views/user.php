<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$id = $_GET['id'];
$title = "Codmoa: user $id";
$res = $db->query("SELECT grantee,table_catalog,table_schema,table_name,privilege_type FROM information_schema.role_table_grants WHERE grantee='$id'");
?>
<?php require "partials/header.php"; ?>
<?php foreach ($res as $row): ?>
<pre><?php print_r($row); ?></pre>
<?php endforeach; ?>
<?php require "partials/footer.php"; ?>
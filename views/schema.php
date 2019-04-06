<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$id = $_GET['id'];
$res = $db->query("SELECT schema_name,catalog_name,schema_owner FROM information_schema.schemata WHERE schema_name='$id'");
?>
<?php require "partials/header.php"; ?>
<pre><?php var_dump($res); ?></pre>
<?php require "partials/footer.php"; ?>
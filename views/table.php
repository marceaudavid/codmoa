<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$id = $_GET['id'];
$res = $db->query("SELECT * FROM $id");
?>
<?php require "partials/header.php"; ?>
<pre><?php var_dump($res); ?></pre>
<?php require "partials/footer.php"; ?>
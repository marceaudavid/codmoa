<?php
session_start();
if (isset($_POST["dbname"])) {
  $_SESSION['dbname'] = $_POST['dbname'];
  $_SESSION['user'] = $_POST['user'];
  $_SESSION['password'] = $_POST['password'];
  header("Location: /views/tables.php");
}
?>
<?php require "./views/partials/header.php"; ?>

<form action="/login" method="POST">
  <input class="input" placeholder="database" type="text" name="dbname" required />
  <input class="input" placeholder="username" type="text" name="user" required />
  <input class="input" placeholder="password" type="password" name="password" required />
  <input type="submit" value="Submit">
</form>

<?php require "./views/partials/footer.php"; ?>
<?php
session_start();

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$id = $_GET['id'];
$title = "Codmoa: user $id";
$tables = $db->query("SELECT table_name, table_schema FROM information_schema.tables WHERE table_schema!='information_schema' AND table_schema!='pg_catalog'");
$schemas = $db->query("SELECT schema_name FROM information_schema.schemata WHERE NOT schema_name='information_schema' AND NOT schema_name LIKE 'pg%'");
$databases = $db->query("SELECT datname FROM pg_database WHERE NOT datname = 'postgres' AND datistemplate = false");
$databaseModel = [
  "CREATE" => false,
  "CONNECT" => false
];
$schemaModel = [
  "USAGE" => false,
  "CREATE" => false
];
$tableModel = [
  "SELECT" => false,
  "INSERT" => false,
  "UPDATE" => false,
  "DELETE" => false,
  "TRUNCATE" => false
];

if (isset($_POST[$tables[0]['table_name']])) {
  $query = [];
  foreach ($_POST as $postTable => $postArray) {
    foreach ($postArray as $postRight => $postValue) {
      $schemaRequest = $db->query("SELECT table_schema FROM information_schema.tables WHERE table_name='$postTable'");
      $schema = $schemaRequest[0]['table_schema'];
      $query[] = "$postValue $postRight ON TABLE $schema." . "$postTable TO $id;";
    }
  }

  if (!empty($query)) {
    foreach ($query as $statement) {
      $db->query($statement);
    }
  }
}

if (isset($_POST[$schemas[0]['schema_name']])) {
  $query = [];
  foreach ($_POST as $postSchema => $postArray) {
    foreach ($postArray as $postRight => $postValue) {
      $query[] = "$postValue $postRight ON SCHEMA $postSchema TO $id;";
    }
  }

  if (!empty($query)) {
    foreach ($query as $statement) {
      $db->query($statement);
    }
  }
}

if (isset($_POST[$databases[0]['datname']])) {
  $query = [];
  foreach ($_POST as $postDb => $postArray) {
    foreach ($postArray as $postRight => $postValue) {
      $query[] = "$postValue $postRight ON DATABASE $postDb TO $id;";
    }
  }

  if (!empty($query)) {
    foreach ($query as $statement) {
      $db->query($statement);
    }
  }
}
?>
<?php require "partials/header.php"; ?>
<div class="container">
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Database</h1>
      <form action=<?php echo "/codmoa/views/user.php?id=$id"; ?> method="POST">
        <table class="table is-narrow is-bordered">
          <tbody>
            <tr>
              <th>Name</th>
              <th>CREATE</th>
              <th>CONNECT</th>
            </tr>
            <?php foreach ($databases as $database): ?>
            <tr>
              <td><?= $database["datname"] ?></td>
              <?php foreach ($databaseModel as $right => $value): ?>
              <td>
                <div class="field">
                  <div class="select">
                    <select name=<?php echo $database["datname"] . "[" . "$right" . "]"; ?> required>
                      <option>GRANT</option>
                      <option>REVOKE</option>
                    </select>
                  </div>
                </div>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="field">
          <button class="button is-link">Update</button>
        </div>
      </form>
      <h1 class="title">Schemas</h1>
      <form action=<?php echo "/codmoa/views/user.php?id=$id"; ?> method="POST">
        <table class="table is-narrow is-bordered">
          <tbody>
            <tr>
              <th>Name</th>
              <th>CREATE</th>
              <th>USAGE</th>
            </tr>
            <?php foreach ($schemas as $schema): ?>
            <tr>
              <td><?= $schema["schema_name"] ?></td>
              <?php foreach ($schemaModel as $right => $value): ?>
              <td>
                <div class="field">
                  <div class="select">
                    <select name=<?php echo $schema["schema_name"] . "[" . "$right" . "]"; ?> required>
                      <option>GRANT</option>
                      <option>REVOKE</option>
                    </select>
                  </div>
                </div>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="field">
          <button class="button is-link">Update</button>
        </div>
      </form>
      <h1 class="title">Tables</h1>
      <form action=<?php echo "/codmoa/views/user.php?id=$id"; ?> method="POST">
        <table class="table is-narrow is-bordered">
          <tbody>
            <tr>
              <th>Name</th>
              <th>SELECT</th>
              <th>INSERT</th>
              <th>UPDATE</th>
              <th>DELETE</th>
              <th>TRUNCATE</th>
            </tr>
            <?php foreach ($tables as $table): ?>
            <tr>
              <td><?= $table["table_name"] ?></td>
              <?php foreach ($tableModel as $right => $value): ?>
              <td>
                <div class="field">
                  <div class="select">
                    <select name=<?php echo $table["table_name"] . "[" . "$right" . "]"; ?> required>
                      <option>GRANT</option>
                      <option>REVOKE</option>
                    </select>
                  </div>
                </div>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="field">
          <button class="button is-link">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require "partials/footer.php"; ?>
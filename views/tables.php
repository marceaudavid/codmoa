<?php
session_start();
if (!isset($_SESSION['dbname']) && !isset($_SESSION['user']) && !isset($_SESSION['password'])) {
  header('Location: /');
}

require __DIR__ . "/../database/Database.php";

$db = new Database($_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
$db->connect();
$title = "Codmoa: tables";
$res = $db->query("SELECT table_catalog,table_name,table_schema,table_type FROM information_schema.tables WHERE table_schema!='information_schema' AND table_schema!='pg_catalog'");

if (isset($_POST["table"])) {
  var_dump($_POST);
  $body = "id serial PRIMARY KEY, ";
  for ($i = 0; $i < sizeof($_POST['columns']); $i++) {
    $comma = $i + 1 === count($_POST['columns']) ? "" : ", ";
    $body = $body . $_POST['columns'][$i] . " " . $_POST['types'][$i] . $comma;
  }
  $query = "CREATE TABLE " . $_POST["table"] . "($body)";
  // $db->query($query);
}

if (isset($_POST["target"])) {
  $path = [
    "from" => $_FILES['upload']['tmp_name'],
    "to" => realpath(__DIR__ . "/../data/") . "/data.csv"
  ];
  move_uploaded_file($path["from"], $path["to"]);
  $query = "COPY " . "base." . $_POST["target"] . " FROM '" . $path["to"] . "' NULL as 'NULL' ESCAPE ''' DELIMITER ';' CSV HEADER";
  $db->query($query);
}
?>
<?php require "partials/header.php"; ?>
<div class="container">
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Tables</h1>
    </div>
  </div>
  <?php foreach ($res as $row): ?>
  <div class="columns is-multiline separator">
    <div class="column is-three-fifths is-offset-one-fifth">
      <a href="/views/table.php?id=<?= $row["table_name"] ?>&schema=<?= $row["table_schema"] ?>">
        <div class="box">
          <span><?= $row["table_name"] ?></span>
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
      <h1 class="title">Create New Table</h1>
      <form action="/codmoa/views/tables.php" method="POST">
        <div id="form">
          <div class="field">
            <input class="input" type="text" placeholder="Table Name" name="table" required>
          </div>
          <a id="add" class="button is-primary">
            <span>Add Column </span>
            <span class="icon is-small">
              <i class="fas fa-plus"></i>
            </span>
          </a>
          <div id="row" class="field is-horizontal">
            <div class="field-body">
              <div class="field">
                <label class="label">Column Name</label>
                <input class="input" type="text" placeholder="Column Name" name="columns[]" required>
              </div>
              <div class="field">
                <label class="label">Data Type</label>
                <div class="select">
                  <select name="types[]" required>
                    <option>smallint</option>
                    <option>integer</option>
                    <option>bigint</option>
                    <option>serial</option>
                    <option>bigserial</option>
                    <option>real</option>
                    <option>double precision</option>
                    <option>money</option>
                    <option>boolean</option>
                    <option>char</option>
                    <option>varchar</option>
                    <option>text</option>
                    <option>date</option>
                    <option>time</option>
                    <option>timestamp</option>
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
  <div class="columns is-multiline">
    <div class="column is-three-fifths is-offset-one-fifth">
      <h1 class="title">Upload Data</h1>
      <form action="/codmoa/views/tables.php" method="POST" enctype="multipart/form-data">
        <div id="form">
          <div id="row" class="field is-horizontal">
            <div class="field-body">
              <div class="field">
                <input class="input" type="text" placeholder="Table Name" name="target" required>
              </div>
              <div class="field">
                <div class="file">
                  <label class="file-label">
                    <input class="file-input" type="file" name="upload" accept="text/csv" required>
                    <span class="file-cta">
                      <span class="file-icon">
                        <i class="fas fa-upload"></i>
                      </span>
                      <span class="file-label">
                        Choose a .csv file
                      </span>
                    </span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <button class="button is-link">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
document.getElementById("add").addEventListener("click", function() {
  const form = document.getElementById("form");
  const row = document.getElementById("row");
  const el = row.cloneNode(true);
  form.append(el);
});
</script>
<?php require "partials/footer.php"; ?>
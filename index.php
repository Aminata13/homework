<?php
    session_start();
    if (!isset($_SESSION['page'])) {
        $_SESSION['page'] = 'exo1';
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Index</title>
    <meta content="text/html; charset=utf-8" />
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #0000ff;
}
</style>
</head>
<body>

<ul>
  <li><a href="index.php?page=exo1">Exercice 1</a></li>
  <li><a href="index.php?page=exo2">Exercice 2</a></li>
  <li><a href="index.php?page=exo3">Exercice 3</a></li>
  <li><a href="index.php?page=exo4">Exercice 4</a></li>
  <li><a href="index.php?page=exo5">Exercice 5</a></li>
  <li><a href="index.php?page=app1">Application 1</a></li>
  <li><a href="index.php?page=app2">Application 2</a></li>
</ul>
<?php
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
if (isset($_GET['page']) && $_GET['page']=="app1") {
    include('appli1/' .$_SESSION['page']. '.php');
} elseif (isset($_GET['page']) && $_GET['page']=='app2'){
    include('appli2/' .$_SESSION['page']. '.php');
} else {
    include('tp4-tableaux/' .$_SESSION['page']. '.php');
}
?>
</body>
</html>

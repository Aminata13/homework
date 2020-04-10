<?php
    require_once('menu.html');
?>
<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$x = $n = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['n']!='0' AND empty($_POST["x"])) {
    $errors['x'] = "Veuillez remplir ce champ";
  } else {
    $x = test_input($_POST["x"]);
    if (!(is_numeric($x))) {
      $errors['x'] = "Ce nombre doit être un entier";
    }
  }
  
  if ($_POST['n']!='0' AND empty($_POST["n"])) {
    $errors['n'] = "Veuillez remplir ce champ";
  } else {
    $n = test_input($_POST["n"]);
    if (!(is_numeric($n))) {
      $errors['n'] = "Ce nombre doit être un entier";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Exercice 4: Calcul de puissance</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Entrer x : <input type="text" name="x" value="<?php echo $x;?>">
  <span class="error">* <?php if(!empty($errors['x'])){echo $errors['x'];} ?></span>
  <br><br>
  Entrer n : <input type="text" name="n" value="<?php echo $n;?>">
  <span class="error">* <?php if(!empty($errors['n'])){echo $errors['n'];} ?></span>
  <br><br>
  <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
  if(empty($errors)){
    $puissance1 = $x**$n;
    $puissance2 = 1;
    echo $x. " à la puissance " .$n. " est égal à " .$puissance1. ".<br/>";
    for ($i=0; $i < $n ; $i++) { 
        $puissance2 = $puissance2*$x;
    }
    echo $x. " à la puissance " .$n. " est égal à " .$puissance2. ".<br/>";
}
}
?>

</body>
</html>
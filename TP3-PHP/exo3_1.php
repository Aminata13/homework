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
$r1 = $r2 = $r3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['r1']!='0' AND empty($_POST["r1"])) {
    $errors['r1'] = "Veuillez remplir ce champ";
  } else {
    $r1 = test_input($_POST["r1"]);
    if (!(is_numeric($r1))) {
      $errors['r1'] = "La résistance doit être un entier";
    }
  }
  
  if ($_POST['r2']!='0' AND empty($_POST["r2"])) {
    $errors['r2'] = "Veuillez remplir ce champ";
  } else {
    $r2 = test_input($_POST["r2"]);
    if (!(is_numeric($r2))) {
      $errors['r2'] = "La résistance doit être un entier";
    }
  }
  if ($_POST['r3']!='0' AND empty($_POST["r3"])) {
    $errors['r3'] = "Veuillez remplir ce champ";
  } else {
    $r3 = test_input($_POST["r3"]);
    if (!(is_numeric($r3))) {
      $errors['r3'] = "La résistance doit être un entier";
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

<h2>Exercice 3: Résistance en série et en parallèle</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Résistance 1 : <input type="text" name="r1" value="<?php echo $r1;?>">
  <span class="error">* <?php if(!empty($errors['r1'])){echo $errors['r1'];} ?></span>
  <br><br>
  Résistance 2 : <input type="text" name="r2" value="<?php echo $r2;?>">
  <span class="error">* <?php if(!empty($errors['r2'])){echo $errors['r2'];} ?></span>
  <br><br>
  Résistance 3 : <input type="text" name="r3" value="<?php echo $r3;?>">
  <span class="error">* <?php if(!empty($errors['r3'])){echo $errors['r3'];} ?></span>
  <br><br>
  <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
  if(empty($errors)){
    $serie = $r1 + $r2 + $r3;
    $parallele = number_format(($r1*$r2*$r3)/(($r1*$r2)+($r2*$r3)+($r1*$r3)),2);
    echo "La résistance en série est " .$serie. ".<br/>";
    echo "La résistance en parallèle est " .$parallele. ".<br/>";
}
}
?>

</body>
</html>
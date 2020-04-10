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
$a = $b = $operateur = " ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['a']!='0' AND empty($_POST["a"])) {
    $errors['a'] = "Veuillez remplir ce champ";
  } else {
    $a = test_input($_POST["a"]);
    if (!(is_numeric($a))) {
      $errors['a'] = "Le nombre doit être un entier";
    } 
  }

  if ($_POST['b']!='0' AND empty($_POST["b"])) {
    $errors['b'] = "Veuillez remplir ce champ";
  } else {
    $b = test_input($_POST["b"]);
    if (!(is_numeric($b))) {
      $errors['b'] = "Le nombre doit être un entier";
    }
  }

  if ($_POST['operateur']!='0' AND empty($_POST["operateur"])) {
    $errors['operateur'] = "Veuillez remplir ce champ";
  } else {
    $operateur = test_input($_POST["operateur"]);
    if ($operateur!='+' AND $operateur!='-' AND $operateur!='*' AND $operateur!='/') {
      $errors['operateur'] = "Veuillez saisir un bon opérateur";
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

<h2>Exercice 11: Opération</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisir deux nombres et un opérateur entre +, -, * et /</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier a : <input type="text" name="a" value="<?php echo $a;?>">
    <span class="error">* <?php if(!empty($errors['a'])){echo $errors['a'];} ?></span>
    <br><br>
    Entier b : <input type="text" name="b" value="<?php echo $b;?>">
    <span class="error">* <?php if(!empty($errors['b'])){echo $errors['b'];} ?></span>
    <br><br>
    Opérateur : <input type="text" name="operateur" value="<?php echo $operateur;?>">
    <span class="error">* <?php if(!empty($errors['operateur'])){echo $errors['operateur'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        if ($operateur == "+") {
            echo $a+$b;
        }
        if ($operateur == "-") {
            echo $a-$b;
        }
        if ($operateur == "*") {
            echo $a*$b;
        }
        if ($operateur == "/") {
            echo $a/$b;
        }
    }
}
?>

</body>
</html>
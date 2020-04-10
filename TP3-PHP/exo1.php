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
$a = $b = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["a"])) {
    $errors['a'] = "Il faut mettre le dividende a";
  } else {
    $a = test_input($_POST["a"]);
    if (!(is_numeric($a))) {
      $errors['a'] = "Le dividende doit être un entier";
    }
  }
  
  if ($_POST['b']!='0' AND empty($_POST["b"])) {
    $errors['b'] = "Il faut mettre le diviseur b";
  } else {
    $b = test_input($_POST["b"]);
    if (!(is_numeric($b))) {
      $errors['b'] = "Le diviseur doit être un entier";
    } else {
        if($b=='0') {
          $errors['b'] = "Le diviseur b doit être différent de 0";
        }
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

<h2>Exercice 1: Calcul de quotient</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Dividende a : <input type="text" name="a" value="<?php echo $a;?>">
  <span class="error">* <?php if(!empty($errors['a'])){echo $errors['a'];} ?></span>
  <br><br>
  Diviseur b : <input type="text" name="b" value="<?php echo $b;?>">
  <span class="error">* <?php if(!empty($errors['b'])){echo $errors['b'];} ?></span>
  <br><br>
  <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
  if(empty($errors)){
      $ratio = number_format($a/$b,2);
      $quotient = (int)$ratio;
      $reste = $a % $b;
      echo "Le quotient de ". $_POST['a']. " par " .$_POST['b']. " est " .$quotient. ".<br/>";
      echo "Le ratio de ". $_POST['a']. " par " .$_POST['b']. " est " .$ratio. ".<br/>";
      echo "Le reste de la division de ". $_POST['a']. " par " .$_POST['b']. " est " .$reste. ".<br/>";
}
}
?>

</body>
</html>
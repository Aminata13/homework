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
$a = $b = $c = "";

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

  if ($_POST['c']!='0' AND empty($_POST["c"])) {
    $errors['c'] = "Veuillez remplir ce champ";
  } else {
    $c = test_input($_POST["c"]);
    if (!(is_numeric($c))) {
      $errors['c'] = "Le nombre doit être un entier";
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

<h2>Exercice 10: Ordre Croissant</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Entrer 3 nombres que vous souhaitez ranger par ordre croissant.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier a : <input type="text" name="a" value="<?php echo $a;?>">
    <span class="error">* <?php if(!empty($errors['a'])){echo $errors['a'];} ?></span>
    <br><br>
    Entier b : <input type="text" name="b" value="<?php echo $b;?>">
    <span class="error">* <?php if(!empty($errors['b'])){echo $errors['b'];} ?></span>
    <br><br>
    Entier c : <input type="text" name="c" value="<?php echo $c;?>">
    <span class="error">* <?php if(!empty($errors['c'])){echo $errors['c'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Valider">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        while (!($a <= $b AND $b<=$c)) {
            if ($a>$b) {
                $temp = $a;
                $a = $b;
                $b = $temp;
            }
            if ($b>$c) {
                $temp = $b;
                $b = $c;
                $c = $temp;
            }
        }
        echo "Les valeurs saisies sont rangées par ordre croissant: " .$a. " " .$b. " " .$c;
    }
}
?>

</body>
</html>
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
  if ($_POST['a']!='0' AND empty($_POST["a"])) {
    $errors['a'] = "Veuillez remplir ce champ";
  } else {
    $a = test_input($_POST["a"]);
    if (!(is_numeric($a))) {
      $errors['a'] = "Le nombre doit être un entier";
    } elseif ($a<=0) {
        $errors['a'] = "Le nombre doit être strictement positif";
    }
  }

  if ($_POST['b']!='0' AND empty($_POST["b"])) {
    $errors['b'] = "Veuillez remplir ce champ";
  } else {
    $b = test_input($_POST["b"]);
    if (!(is_numeric($b))) {
      $errors['b'] = "Le nombre doit être un entier";
    } elseif ($b<=0) {
        $errors['b'] = "Le nombre doit être strictement positif";
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

<h2>Exercice 16: Division</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier a : <input type="text" name="a" value="<?php echo $a;?>">
    <span class="error">* <?php if(!empty($errors['a'])){echo $errors['a'];} ?></span>
    <br><br>
    Entier b : <input type="text" name="b" value="<?php echo $b;?>">
    <span class="error">* <?php if(!empty($errors['b'])){echo $errors['b'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        if ($a<$b) {
            $quotient = 0;
        }
        else {
            $quotient = 0;
            while ($a >= $b) {
                $a = $a-$b;
                $quotient += 1;
            }
        }
    }
    echo "Le quotient entier de la division de " .$a. " par " .$b. " est " .$quotient. ".";
}
?>

</body>
</html>
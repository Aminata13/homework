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
$n = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['n']!='0' AND empty($_POST["n"])) {
    $errors['n'] = "Veuillez remplir ce champ";
  } else {
    $n = test_input($_POST["n"]);
    if (!(is_numeric($n))) {
      $errors['n'] = "Le nombre doit être un entier";
    } elseif ($n<=0) {
        $errors['n'] = "Le nombre doit être strictement positif";
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

<h2>Exercice 13: Décomposition en Produit de Facteurs Premiers</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier n : <input type="text" name="n" value="<?php echo $n;?>">
    <span class="error">* <?php if(!empty($errors['n'])){echo $errors['n'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Valider">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        for ($i=2; $i < $n ; $i++) { 
            while ($n%$i==0) {
                echo $i. "<br>";
                $n = $n/$i;
            }
        }
    }
}
?>

</body>
</html>
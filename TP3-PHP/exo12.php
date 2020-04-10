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

<h2>Exercice 12: Nombre Parfait</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Entrer un nombre pour vérifier si c'est un nombre parfait.</p>
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
        $somme = 0;
        for ($i=1; $i <= $n-1 ; $i++) { 
            if ($n%$i==0) {
                $somme += $i;
            }
        }
        if ($n == $somme) {
            echo "Ce nombre est parfait.";
        } else {
            echo "Ce nombre n'est pas parfait.";
        }
    }
}
?>

</body>
</html>
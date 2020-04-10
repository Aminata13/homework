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
$montant = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['montant']!='0' AND empty($_POST["montant"])) {
    $errors['montant'] = "Veuillez remplir ce champ";
  } else {
    $montant = test_input($_POST["montant"]);
    if (!(is_numeric($montant))) {
      $errors['montant'] = "Le montant doit être un entier";
    } elseif ($montant<=0) {
        $errors['montant'] = "Le montant doit être strictement positif";
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

<h2>Exercice 7: Euros</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Montant : <input type="text" name="montant" value="<?php echo $montant;?>">
    <span class="error">* <?php if(!empty($errors['montant'])){echo $errors['montant'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        if ($montant>=20) {
            $b20 = (int)($montant/20);
            $montant = $montant % 20;
            echo "Le nombre de billets de 20 est: " .$b20. "<br>";
        }
        if ($montant>=10 AND $montant!=0) {
            $b10 = (int)($montant/10);
            $montant = $montant % 10;
            echo "Le nombre de billets de 10 est: " .$b10. "<br>";
        }
        if ($montant>=5 AND $montant!=0) {
            $b5 = (int)($montant/5);
            $montant = $montant % 5;
            echo "Le nombre de billets de 5 est: " .$b5. "<br>";
        }
        if ($montant>=2 AND $montant!=0) {
            $p2 = (int)($montant/2);
            $montant = $montant % 2;
            echo "Le nombre de pièces de 2 euros est: " .$p2. "<br>";
        }
        if ($montant>=1 AND $montant!=0) {
            $p1 = (int)($montant/1);
            $montant = $montant % 1;
            echo "Le nombre de pièces de 1 euros est: " .$p1. "<br>";
        }
    }
}
?>

</body>
</html>
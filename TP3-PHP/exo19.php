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
  if (empty($_POST["montant"])) {
    $errors['montant'] = "Veuillez remplir ce champ";
  } else {
    $montant = test_input($_POST["montant"]);
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Exercice 19: Somme d'Articles</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisissez les prix des différents articles séparés par un espace.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier : <input type="text" name="montant" value="<?php echo $montant;?>">
    <span class="error">* <?php if(!empty($errors['montant'])){echo $errors['montant'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        $somme = 0;
        $nombres = explode(' ', $_POST['montant']);
        for ($i=0; $i < count($nombres) ; $i++) { 
            if (is_numeric($nombres[$i])){
                $somme += $nombres[$i];
            }
        }
        echo "La somme des nombres saisis est: " .$somme;
    }
}
?>

</body>
</html>
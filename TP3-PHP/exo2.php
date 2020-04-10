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
$rayon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['rayon']!='0' AND empty($_POST["rayon"])) {
    $errors['rayon'] = "Il faut mettre le rayon";
  } else {
    $rayon = test_input($_POST["rayon"]);
    if (!(is_numeric($rayon))) {
      $errors['rayon'] = "Le rayon doit être un entier";
    } else {
        if($rayon<=0)
        $errors['rayon'] = "Le rayon doit être strictement supérieur à 0";
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

<h2>Exercice 2: Cercle</h2>
<p><span class="error">* champ obligatoire</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Rayon : <input type="text" name="rayon" value="<?php echo $rayon;?>">
  <span class="error">* <?php if(!empty($errors['rayon'])){echo $errors['rayon'];} ?></span>
  <br><br>
  <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
  if(empty($errors)){
    $perimetre = number_format(($rayon*2)*pi(),2);
    $surface = number_format(($rayon**2)*pi(),2);
    echo "Le périmètre du cercle de rayon ". $rayon. " est " .$perimetre. ".<br/>";
    echo "La surface de ce cercle est " .$surface. ".<br/>";
}
}
?>

</body>
</html>
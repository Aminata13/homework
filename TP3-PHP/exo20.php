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
    // if (!(is_numeric($n))) {
    //   $errors['n'] = "Ce nombre doit être un entier";
    // }
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Exercice 5: Somme</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisissez 10 entiers séparés par un espace</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier n : <input type="text" name="n" value="<?php echo $n;?>">
    <span class="error">* <?php if(!empty($errors['n'])){echo $errors['n'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Calculer">  
</form>

<?php
echo "<h2>Le résultat:</h2>";
if (!empty($_POST)) {
    if(empty($errors)){
        $max = 0;
        $nombres = explode(' ', $_POST['n'], 10);
        for ($i=0; $i < count($nombres) ; $i++) { 
            if (is_numeric($nombres[$i])){
                if($nombres[$i]>$max){
                    $max = $nombres[$i];
                    $rang = $i+1;
                }
            }
        }
        echo "Le maximum des nombres saisis est: " .$max. ".<br>";
        echo "Il se trouve au rang: " .$rang;
    }
}
?>

</body>
</html>
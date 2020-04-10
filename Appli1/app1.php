<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="appli1/app1.css">
    <link href="//db.onlinewebfonts.com/c/3ad749f2a889ece75893f0b207f40f2b?family=M" rel="stylesheet" type="text/css"/>
    <title>Application 1</title>
</head>
<body>
<?php
// define variables and set to empty values
$size = $c1 = $c2 = $position = "";
$colors = array(
    'Bleu' => '#0433e5', 
    'Rouge' => '#ff0000', 
    'Noir' => '#000000', 
    'Vert' => '#008000', 
    'Jaune' => '#d8ac0f'
);
$positions = array('Haut', 'Bas');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["size"])) {
    $errors['size'] = "Veuillez remplir ce champ.";
  } else {
    $size = test_input($_POST["size"]);
    $c1 = test_input($_POST["c1"]);
    $c2 = test_input($_POST["c2"]);
    $position = test_input($_POST["position"]);
    if (!(is_numeric($size))) {
        $errors['size'] = "Erreur: le nombre doit être un entier.";
    }
    if ($c1 == $c2){
        $errors['c1'] = "Erreur: les deux couleurs doivent être différentes.";
    }
  }
  
}
?>
    <div class="content">
        <div class="content-title"> SONATEL ACADEMIE</div>
        <div class="form">
            <form class="form1" method="POST">
                <div class="form-content">
                    <div class="form-title"><label for="matrice">Taille de la matrice carrée</label></div>
                    <div class="form-icon icon1"><img src="icone1.png" alt=""></div>
                    <div class="form-input"><input type="text" name="size" value="<?php echo $size;?>"></div>
                </div>
                <div class="form-content">
                    <div class="form-title"><label for="c1">Select C1</label></div>
                    <div class="form-icon icon2"><img src="icone2_3.png" alt=""></div>
                    <div class="form-input"><select class="select select1" name="c1">
                        <?php foreach ($colors as $color => $symbol) {
                            ?>
                            <option <?php if($color==$c1){echo "selected";}?>
                             value="<?=$color?>"   >
                             <?=$color?> 
                            </option>
                        <?php } ?>
                    </select></div> 
                </div>
                <div class="form-content">
                    <div class="form-title"><label for="c2">Select C2</label></div>
                    <div class="form-icon icon3"><img src="icone2_3.png" alt=""></div>
                    <div class="form-input"><select class="select select2" name="c2">
                        <?php foreach ($colors as $color => $symbol) {
                            ?>
                            <option <?php if($color==$c2){echo "selected";}?>
                             value="<?=$color?>"   >
                             <?=$color?> 
                            </option>
                        <?php } ?>
                    </select></div> 
                </div>
                <div class="form-content">
                    <div class="form-title"><label for="position">Position</label></div>
                    <div class="form-icon icon4"><img src="interrogation.png" alt=""></div>
                    <div class="form-input"><select class="select select3" name="position">
                        <?php foreach ($positions as $side) {
                            ?>
                            <option <?php if($side==$position){echo "selected";}?>
                             value="<?=$side?>"   >
                             <?=$side?> 
                            </option>
                        <?php } ?>
                    </select></div> 
                </div>
                <span class="error">* <?php if(!empty($errors['size'])){echo $errors['size'];} ?></span>
                <span class="error"> <?php if(!empty($errors['c1'])){echo $errors['c1'];} ?></span>
                <div class="buttons">
                    <div class="button1"><input type="submit" name="cancel" value="Annuler"></div>
                    <div class="button2"><input type="submit" name="draw" value="Dessiner"></div>
                </div>
            </form>
        </div>
        <div class="result">
            <?php
                if (!empty($_POST['draw']) && empty($errors)) {
                    echo "<table>";
                    for ($i=0; $i < $size ; $i++) { 
                        echo "<tr>";
                        for ($j=0; $j < $size ; $j++) { 
                            if ($position == 'Bas') {
                                if (($i+$j)==($size-1) || ($i==$j) || ($i>$j)) {
                                    echo '<td bgcolor='.$colors[$c1].'></td>';
                                } else {
                                    echo '<td bgcolor='.$colors[$c2].'></td>';
                                }
                            } elseif ($position == 'Haut') {
                                if (($i+$j)==($size-1) || ($i==$j) || ($i>$j)) {
                                    echo '<td bgcolor='.$colors[$c2].'></td>';
                                } else {
                                    echo '<td bgcolor='.$colors[$c1].'></td>';
                                } 
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </div>
</body>
</html>
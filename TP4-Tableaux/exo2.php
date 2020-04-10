<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
    </style>
    <title>Exercice 2 - Tableaux</title>
</head>
<body>
    <?php
        $choix = " ";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["choix"])) {
              $errors['choix'] = "Veuillez remplir ce champ";
            } else {
              $choix = test_input($_POST["choix"]);
            }  
        }
    ?>

<h2>Exercice 2 - Tableaux</h2>
<p>Choisissez une langue:</p>
<form method="post" action="index.php"> 
    <p><select name="choix" id="">
        <option value="">--Choisissez une option--</option>
        <option value="french">Français</option>
        <option value="english">Anglais</option>
        </select>
    </p>
  <input type="submit" name="submit" value="Envoyer">    
</form>

<?php
if (!empty($_POST) && empty($errors)) {
    $month = array(
        'french'=>array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"), 
        'english'=>array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
    );
    echo "<h2>Le résultat:</h2>";
    calendar($choix, $month);
}
?>

</body>
</html>
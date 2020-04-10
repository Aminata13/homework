<?php
ini_set('max_execution_time', 30);
require_once('functions.php');
if (isset($_SESSION['n']) && !isset($_POST['n'])) {
    $_POST['n'] = $_SESSION['n'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    h2 {
        text-align: center;
    }
    table {
        margin-left: 400px;
        font-family: arial, sans-serif;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 15px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
    </style>
    <style>
    .error {color: #FF0000;}
    </style>
    <title>Exercice 1 - Tableaux</title>
</head>
<body>
    <?php
        $n = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST['n']) && $_POST['n']!='0' ) {
              $errors['n'] = "Veuillez remplir ce champ";
            } else {
                $n = test_input($_POST["n"]);
                if (!(is_numeric($n))) {
                    $errors['n'] = "Le nombre doit être un entier";
                } elseif ($n<=10000) {
                    $errors['n'] = "Le nombre doit être strictement positif supérieur à 10000";
              }
            }  
        }
    ?>

<h1>Exercice 1 - Tableaux</h1>
<p><span class="error">* champ obligatoire</span></p>
<p>Entrer un nombre strictement positif supérieur à 10000.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entier n : <input type="text" name="n" value="<?php if (isset($_POST['n'])) {echo $_POST['n'];} ?>">
    <span class="error">* <?php if(!empty($errors['n'])){echo $errors['n'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Valider">  
</form>

<?php
if (!empty($_POST) && empty($errors)) {
    $_SESSION['n'] = $_POST['n'];
    $_SESSION['T1'] = getPrimeNumbers($_SESSION['n']);
    $moyenne = average($_SESSION['T1']);
    $_SESSION['T'] = array("inferieur"=>array(), "superieur"=>array());
    for ($i=0; $i < countTab($_SESSION['T1']); $i++) { 
        if ($_SESSION['T1'][$i]<$moyenne) {
            $_SESSION['T']['inferieur'][] = $_SESSION['T1'][$i];
        } else {
            $_SESSION['T']['superieur'][] = $_SESSION['T1'][$i];
        }
    }
    echo '<div><h2> Nombres premiers inférieurs à la moyenne:</h2>';
    paginate('index.php', 100, 'pageInf', $_SESSION['T']['inferieur']);

    echo '</div><hr><div><h2> Nombres premiers supérieurs à la moyenne:</h2>';
    paginate('index.php', 100, 'pageSup', $_SESSION['T']['superieur']);
    echo '</div>';
    
}
?>

</body>
</html>
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
    <h2>Exercice 23: Lapins</h2>

<?php
    $n = 4;
    $m = 2;
    for ($i=1; $i <= 10 ; $i++) { 
        $resultat = $n + $m;
        $m = $n;
        $n = $resultat;
    }
    echo "<h3>Le nombre de lapins au bout d'un an est: " .$resultat. ".</h3>";
    $a = 4;
    $b = 2;
    $mois = 0;
    $j = 1;
    while ($resultat<=1000000000) {
        $resultat = $a + $b;
        $b = $a;
        $a = $resultat;
        $j++;
        $mois++;
    }
    echo "<h3>On aura 1 milliard de lapins au bout de: " .$mois. " mois.</h3>";
?>

</body>
</html>
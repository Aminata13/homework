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
    <h2>Exercice 25: For Fun!</h2>

<?php
    for ($i=1; $i <=10; $i++) { 
        for ($j=1; $j <=$i ; $j++) { 
            echo $i. " ";
        }
        echo "<br>";
    }
?>

</body>
</html>
<?php
if (isset($_SESSION['user'])) {
    $player = $_SESSION['user'];
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../../index.php');
}
if (!isset($_SESSION['statut'])){
    header('Location: ../../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des joueurs</title>
</head>
<body>
    <div class="title">LISTE DES JOUEURS PAR SCORE</div>
    <div class="list">
        <div class="list-column">
            <p>Nom</p>
            <div>DIATTA</div>
            <div>NIANG</div> 
            <div>MBAYE</div> 
        </div>
        <div class="list-column">
            <p>Prénom</p>
            <div>Ibou</div>
            <div>Aly</div> 
            <div>Saliou</div> 
        </div>
        <div class="list-column">
            <p>Score</p>
            <div>1022 pts</div>
            <div>963 pts</div> 
            <div>877 pts</div> 
        </div>
    </div>
    <button class="btn-previous">Précédent</button>
    <button class="btn-next">Suivant</button>
</body>
</html>
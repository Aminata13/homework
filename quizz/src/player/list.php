<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des joueurs</title>
</head>
<body>
<?php
    $players = get_players();
?>
    <div class="title">LISTE DES JOUEURS PAR SCORE</div>
    <div class="list">
        <?php
            paginate('index.php?lien=admin&content=players&page=', 13, $players);
        ?>
</body>
</html>
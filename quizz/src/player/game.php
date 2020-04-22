<?php
is_connected();
if (isset($_SESSION['user'])) {
    $player = $_SESSION['user'];
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Game</title>
</head>
<body>
    <header class="game-header">
        <div class="avatar">
            <img src="<?= $player['avatar'] ?>" alt="">
            <div class="user"><?php echo $player['surname']. ' ' .my_to_upper_string($player['firstname']); ?></div>
        </div>

        <div class="title title-player">BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ <br> JOUER ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRALE</div>
        
        <form action="" method="post">
            <input class="button btn-player" type="submit" name="logout" value="Déconnexion">
        </form>
    </header>
   
    <div class="game-content">
        <div class="score">
            <div class="tab">
                <button class="tablink1" onclick="openCity(event, 'London')" id="defaultOpen">Top scores</button>
                <button class="tablink2" onclick="openCity(event, 'Paris')">Mon meilleur score</button>
            </div>

            <div id="London" class="tabcontent">
                <h3>London</h3>
                <p>London is the capital city of England.</p>
            </div>

            <div id="Paris" class="tabcontent">
                <h3>Paris</h3>
                <p>Paris is the capital of France.</p> 
            </div>
        </div>
        <div class="questions"></div>
    </div>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
</script>
</body>
</html>
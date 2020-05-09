<?php
is_connected();
if (isset($_SESSION['user'])) {
    $player = $_SESSION['user'];
}
$players = get_players();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
</head>
<body>
    <header class="player-header">
        <div class="avatar">
            <img src="<?= $player['avatar'] ?>" alt="">
            <div class="user"><?php echo $player['surname']. ' ' .mb_strtoupper($player['firstname']); ?></div>
        </div>

        <div class="title title-player">BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ <br> JOUER ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRALE</div>
        
        <a id="btn-logout" class="button btn-player" href="index.php?statut=logout">Déconnexion</a>
    </header>
   
    <div class="player-content">
        <div class="player-content-container">
            <div class="score">
                <div class="tab">
                    <button class="tablinks tablink1" onclick="openTab(event, 'top-scores')" id="defaultOpen">Top scores</button>
                    <button class="tablinks tablink2" onclick="openTab(event, 'score')">Mon meilleur score</button>
                </div>

                <div id="top-scores" class="tabcontent">
                    <div class="top-player">
                        <?php
                            for ($i=0; $i < 5 ; $i++) { 
                                echo '<div>';
                                echo $players[$i]['surname']. ' ' .mb_strtoupper($players[$i]['firstname']);
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="top-score">
                        <?php
                            for ($i=0; $i < 5 ; $i++) { 
                                echo '<div class="score'.($i+1).'">';
                                echo $players[$i]['score']. ' pts';
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>

                <div id="score" class="tabcontent">
                    <div class="top-player">
                        <div>
                            <?php
                                echo $player['surname']. ' ' .mb_strtoupper($player['firstname']);
                            ?>
                        </div>
                    </div>
                    <div class="top-score">
                        <div class="score1">
                            <?php
                                echo $player['score']. ' pts';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="questions">
                <?php 
                    if(isset($_GET['page']) && $_GET['page']=='end') {
                        require_once('src/player/score.php');
                    } else {
                        require_once('src/player/game.php');
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();

        //log out confirmation box
        document.getElementById('btn-logout').addEventListener('click', function(e) {
            var logout = confirm("Etes-vous sûr de vouloir vous déconnecter? La partie ne sera pas enregistrée.");
            if(!logout){
                e.preventDefault();
                return false;
            }
        })
</script>
</body>
</html>
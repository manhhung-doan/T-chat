<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <!-- Refresh page each 1s -->
        <!-- <meta http-equiv="refresh" content="1"> -->
        <title>T-chat</title>
        <link type="text/css" rel="stylesheet" href="style.css" />
    </head>
    
    <body>

    <!-- New version -->
    <?php
        session_start();

        if(isset($_POST['enter'])){
            if($_POST['nom'] != ""){
                $_SESSION['nom'] = stripslashes(htmlspecialchars($_POST['nom']));
            }
            else{
                echo '<span class="error">Veuillez saisir un nom!</span>';
            }
        }

        if(!isset($_SESSION['nom'])){
            echo'
            <div id="loginform">
            <form action="index.php" method="post">
                <p>Veuillez saisir un nom pour continuer:</p>
                <label for="nom">Nom:</label>
                <input type="text" name="nom" id="nom" />
                <input type="submit" name="enter" id="enter" value="Enter" />
            </form>
            </div>
            ';
        }
        else{
    ?>

    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Bienvenue, <b style="color:white; background-color:green; padding:2px; border-width:1px;border-radius:2px;"><?php echo $_SESSION['nom']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit</a></p>
            <div style="clear:both"></div>

            <?php
                if(isset($_GET['logout'])){ 
                    session_destroy();
                    header("Location: index.php");
                }
            ?>
        </div>
     
        <div id="chatbox">
            <div id="chattext">
                <?php
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;dbname=manhhungdb;charset=utf8', 'manhhung', '123456789');
                    }
                    catch(Exception $e)
                    {
                        die('Erreur : '.$e->getMessage());
                    }

                    $reponse = $bdd->query('SELECT nom, mess FROM tchat ORDER BY ID DESC LIMIT 0, 1000');

                    while ($donnees = $reponse->fetch())
                    {
                        echo '<p><strong>' . htmlspecialchars($donnees['nom']) . '</strong> : ' . htmlspecialchars($donnees['mess']) . '</p>';
                    }

                    $reponse->closeCursor();
                ?>
            </div>
        </div>
     
        <form action="tchat_post.php" method="post">
            <input type="hidden" name="nom" value="<?php echo $_SESSION['nom']; ?>" />
            <input name="usermsg" type="text" id="usermsg" />
            <input name="submitmsg" type="submit"  id="submitmsg" value="Envoyer" />
        </form>
        
    </div>

    <?php
        }
    ?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
	        $("#exit").click(function(){
		        var exit = confirm("Voulez-vous vraiment mettre fin à la session?");
		        if(exit==true){window.location = 'index.php?logout=true';}		
	        });

            setInterval(function(){
                $('#chatbox').load('index.php #chattext');}, 2000)
        });

    </script>

    </body>
</html>
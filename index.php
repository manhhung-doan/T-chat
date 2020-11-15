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
            if($_POST['name'] != ""){
                $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
            }
            else{
                echo '<span class="error">Please type in a name</span>';
            }
        }

        if(!isset($_SESSION['name'])){
            echo'
            <div id="loginform">
            <form action="index.php" method="post">
                <p>Please enter your name to continue:</p>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" />
                <input type="submit" name="enter" id="enter" value="Enter" />
            </form>
            </div>
            ';
        }
        else{
    ?>

    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Welcome, <b style="color:white; background-color:green; padding:2px; border-width:1px;border-radius:2px;"><?php echo $_SESSION['name']; ?></b></p>
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
            <input type="hidden" name="name" value="<?php echo $_SESSION['name']; ?>" />
            <input name="usermsg" type="text" id="usermsg" />
            <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
        </form>
        
    </div>

    <?php
        }
    ?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
        // jQuery Document
        $(document).ready(function(){
	        //If user wants to end session
	        $("#exit").click(function(){
		        var exit = confirm("Are you sure you want to end the session?");
		        if(exit==true){window.location = 'index.php?logout=true';}		
	        });

            // setTimeout(function(){
            //     window.location.reload(1);
            // }, 1000);

            setInterval(function(){
                $('#chatbox').load('index.php #chattext');}, 2000)
            /* time in milliseconds (ie 2 seconds)*/
        });

    </script>

    </body>
</html>
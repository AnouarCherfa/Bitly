<?php

if(!empty($_POST['url'])) {

    ## Variable
    $url = $_POST['url'];

    ## Vérification
    if(!filter_var($url, FILTER_VALIDATE_URL)) {
        ## Pas un lien
        header('location: ../?error=true&message=Adresse url non valide');
        exit();
    }

    ## Shortcut
    $shortcut = crypt($url, time());

    ## Has been already send
    $bdd = new PDO('mysql:host=localhost;dbname=bitly;charset=utf8', 'root', '');
    
    $req = $bdd->prepare('SELECT COUNT(*) AS x FROM links WHERE url = ?');
    $req-> execute(array($url));

    while($result = $req-> fetch()){
        if($result['x'] != 0){
            header('location: ../?error=true&message=adresse déja raccourcie');
            exit();
        }
    }

    ## Sending

    $req = $bdd->prepare('INSERT INTO links(url, shortcut) VALUES(?, ?)');
    $req->execute(array($url, $shortcut));

    header('location: ../?short='.$shortcut);
    exit();


}

?>



                    <!-- Structure de la page en HTML5 -->
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Raccourcisseur d'url express</title>
        <link rel="stylesheet" type="text/css" href="design/default.css">
        <link rel="icon" type="image/png" href="pictures/favico.png">
        
    </head>
    <body>
                <!-- Présentation -->
        <section id="hello">

            <!-- Container -->
            <div class="container">

                <!-- header -->
                <header>
                    <img src="pictures/logo.png" alt="logo" id="logo">
                </header>

                <!-- Titre -->
                <h1>Une url longue ? raccourcissez-là</h1>
                <h2>Largement meilleur et plus court que les autres</h2>

                <!-- form -->
                <form method="POST" action="../">
                    <input type="url" name="url" placeholder="Collez un lien à raccourcire">
                    <input type="submit" value="Raccourcir">
                </form>

                <?php if(isset($_get['error']) && isset($_get['message'])) { ?>
                    <div class="center">
                        <div id="result">
                            <b>
                                <?php echo htmlspecialchars($_GET['message']); ?>
                            </b>
                        </div>
                    </div>
                <?php } ?>

                
            </div>
        
        </section>

        <!-- Brands -->
        <section id="brands">

            <!-- Container -->
            <div class="container">
                <h3>CES MARQUES QUI NOUS FONT CONFIANCE</h3>
                <img src="pictures/1.png" alt="1" class="picture">
                <img src="pictures/2.png" alt="2" class="picture">
                <img src="pictures/3.png" alt="3" class="picture">
                <img src="pictures/4.png" alt="4" class="picture">
            </div>

        </section>

        <!-- Footer -->
        <footer>
            <img src="pictures/logo2.png" alt="logo" id="logo"><br />
            2018 © Bitly <br />
            <a href="#">Contact</a> - <a href="#">A propos</a>

        </footer>
    </body>
</html>
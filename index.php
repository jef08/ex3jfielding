<!DOCTYPE html>
<html>
    <head>
        <title>Stadium lighting</title>
        <link rel = "stylesheet" href = "styles.css">
    </head>
    <body>
        <h1>Lamps</h1>
        <?php
        require_once "autoloader.php";
        $lighting = new Lighting();
        $lighting->getAllLamps();
        $lighting->drawLampsList();
        $lighting->showWattsPerZone();
        ?>
    </body>
</html>
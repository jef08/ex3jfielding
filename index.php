<?php
require_once "autoloader.php"; 
$lighting = new Lighting();

if (isset($_POST['filter'])) { //if form is being submitted//
    $lighting->setFilter($_POST['filter']);
} elseif (isset($_GET['filter'])) { //if page is being refreshed from changestatus.php//   
    $lighting->setFilter($_GET['filter']);
}

$lighting->getAllLamps();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Stadium lighting</title>
        <link rel = "stylesheet" href = "styles.css">
    </head>
    <body>
        <div class = "content">
        <h1>BIG STADIUM - LIGHTING CONTROL PANEL</h1>
        <form action = "index.php" method="POST">
            <select name="filter">
                <?= $lighting->drawZoneOptions()?>
            </select>            
            <input type="submit" value = "Filter by zone">
        </form>
        <p>Total Wattage:</p>
        <?php
        $lighting->showWattsPerZone();
        $lighting->drawLampsList();
        ?>
        </div>
    </body>
</html>
<?php

require_once 'autoloader.php';

if (isset($_GET['id']) && isset($_GET['status'])) { //The get request pulls the id and status from the url that we set up in the a href//
    $id = $_GET['id'];
    $status = $_GET['status'];

    $lighting = new Lighting(); //create new lighting//
    $lighting->changeStatus($id, $status); //Update the database//
}

header('Location: index.php'); //go back to index.php once the update is done//
exit();
?>
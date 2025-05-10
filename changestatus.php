<?php

require_once 'autoloader.php';

if (isset($_GET['id']) && isset($_GET['status'])) { //The get request pulls the id and status from the url that we set up in the a href//
    $id = $_GET['id'];
    $status = $_GET['status'];

    $lighting = new Lighting(); //create new lighting//
    $lighting->changeStatus($id, $status); //Update the database//
    
    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'];  //if filter is set in url then grab it//
    } else {
        $filter = 'all';
    }
}

header('Location: index.php?filter=' . urlencode($filter)); //go back to index.php with correct filter once the update is done//
exit();
?>
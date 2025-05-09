<?php
function autoloader($clase) { //load class by looking at file /clases/
    require_once 'clases/' . $clase . '.php';
}

spl_autoload_register('autoloader'); //tells php to use autoloader function when manifested but not loaded//
?>
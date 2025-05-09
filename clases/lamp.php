<?php

require_once "autoloader.php";

class Lamp {

    private $id;
    private $name;
    private $status;
    private $model;
    private $watts;
    private $zone;

    function __construct($id, $name, $status, $model, $watts, $zone) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->model = $model;
        $this->watts = $watts;
        $this->zone = $zone;
    }

    public function getId() {
        return $this -> id;
    }

    public function getName() {
        return $this -> name;
    }

    public function getStatus() {
        return $this -> status;
    }

    public function getModel() {
        return $this -> model;
    }

    public function getWatts() {
        return $this -> watts;
    }

    public function getZone() {
        return $this -> zone;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}

?>
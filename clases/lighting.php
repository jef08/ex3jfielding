<?php

require_once "autoloader.php";

class Lighting extends Connection {

    private $lamps=[]; //put it outside so it can be used in both functions//
    private $currentFilter = 'all';

    public function setFilter($currentFilter) {
        $this->currentFilter = $currentFilter;
    }

    public function getFilter() {
        return $this->currentFilter;
    }

    public function getAllLamps() {

        $currentFilter = $this->currentFilter; //set "currentFilter" variable//

        $sql = "SELECT lamps.lamp_id, lamps.lamp_name, lamp_on,
                lamp_models.model_part_number,lamp_models.model_wattage,
                zones.zone_name FROM lamps INNER JOIN lamp_models ON
                lamps.lamp_model=lamp_models.model_id INNER JOIN zones ON
                lamps.lamp_zone = zones.zone_id"; //sql query//
        
        //For if we're selecting a specific zone//
        if($currentFilter !== 'all') {
            $sql .= " WHERE zones.zone_name = '$currentFilter'";
        }
        
        $sql .= " ORDER BY lamps.lamp_id;"; //Because "WHERE" clause has to come before "ORDER BY"//
        
        $stmt = $this->conn->prepare($sql); //connect to database//
        $stmt->execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC); //rows is the fetched data//

        //Next, put rows of fetched data into array similar to AP73//

        $this->lamps = [];

        //Use Lamp class to set up info//
        foreach ($rows as $row) { //break down info from $rows into $row and put each $row into $lamps//
            $this->lamps[] = new Lamp(
                $row['lamp_id'], //associative array lamp_id => xyz//
                $row['lamp_name'],
                $row['lamp_on'],
                $row['model_part_number'],
                $row['model_wattage'],
                $row['zone_name']
            );
        }
    }

    public function drawLampsList() { //put the different lamps into divs to be displayed on screen//
        echo '<div class = "lamps-container">'; //create container//

        foreach ($this->lamps as $lamp) { //look at each row in $lamps//
            echo '<div class = "lamp-div">';
            echo '<p>' . $lamp->getName() . '</p>';

            echo '<p>'; 
            if ($lamp->getStatus() === 1) {
                echo '<a href = "changeStatus.php?id=' . $lamp->getID() . '&status=0"><img src = "img/bulb-icon-on.png"></a>'; //Status is zero because we want to change from 1 to 0 with the link//
            } elseif ($lamp->getStatus() === 0) {
                echo '<a href = "changeStatus.php?id=' . $lamp->getID() . '&status=1"><img src = "img/bulb-icon-off.png"></a>';  //Same thing but opposite, we can use the id to change the status of that particular lamp//
            } 
            echo '</p>'; //If lamp is ON = 1 if OFF = 0//

            echo '<p class = "watts">' . $lamp->getWatts() . 'W</p>';
            echo '<p>' . $lamp->getZone() . '</p>';
            echo "</div>";
        }
        echo '</div>';
    }

    public function showWattsPerZone() {
        $sql = "SELECT SUM(lamp_models.model_wattage) as power FROM
                `lamps` INNER JOIN lamp_models on
                lamp_model=lamp_models.model_id WHERE lamp_on = 1 ;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo $result[0]['power'];
    }

    public function changeStatus($id, $status) {
        $sql = "UPDATE lamps SET lamp_on = $status WHERE lamp_id = $id"; //update the status//
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }

    public function drawZoneOptions() {
        $currentFilter = $this->currentFilter;

        $sql = "SELECT zone_name from zones"; //select the zone names from the zone table//
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $zones = $stmt->fetchAll(PDO::FETCH_ASSOC); //zones variable equals output of sql query//

        echo '<option value = "all">All Zones</option>'; //give option for all zones//
        foreach ($zones as $zone) {
            if ($zone['zone_name']===$currentFilter) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            echo '<option value="' . $zone['zone_name'] . '" ' . $selected . '>' . $zone['zone_name'] . '</option>';
        }
    }
    
    
}
?>
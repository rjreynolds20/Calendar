<?php
    include 'helper.php';

    // Gathers form data from webpage,
    // sends data to helper.php addEvent() function to save to backend
    // and populate table with new data.
    
    $eventName = $_POST["eventName"];
    $colorType = $_POST["colorType"];
    $days = $_POST["day"];
    $times = $_POST["time"];

    addEvent($eventName, $colorType, $days, $times);
?>

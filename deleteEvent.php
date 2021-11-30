<?php
    // Includes helper.php, which includes all functions associated
    // with this webpage.
    include 'helper.php';

    // $x and $y are set to the X,Y coordinates of cell being clicked
    // by the user. Sent in from hidden form in the HTML.
    $x = $_POST["x"];
    $y = $_POST["y"];

    // Calls function removeEvent() from helper.php
    // Removes desired cell from schedule table.
    removeEvent($x, $y);
?>
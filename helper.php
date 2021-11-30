<?php

    //PRE: 
    //POST: Creates the main section of the HTML table
    //      instead of hard-coding the table in.
    function setUpPage() {
        $template = fopen("calendar.html", "r") or die("Unable to open file!");
	while(($stringLine = fgets($template)) !== false) {
	    if (strpos($stringLine, "#AUTOMATETABLE") != false ) {
	        setUpTable(10,7);
	    }
	    else {
	        echo $stringLine;
	    }
	}
        fclose($template);
    }

    //PRE: Takes integer of # rows and integer of # columns
    //POST: Sets up table taking the data from the backend XML file and
    //      populates the table on the HTML template.
    function setUpTable($rows, $columns) {
        $xml = simplexml_load_file("busy.xml") or die("Unable to open file!");
	$staticTimes = array("8am", "9am", "10am", "11am", "12pm", "1pm", "2pm",
	"3pm", "4pm", "5pm");
	
	for ($i = 0; $i < $rows; $i++) {
	    echo "<tr>";
	    echo "<th class='tableLeftColumn'>$staticTimes[$i]</th>";
	    for ($j = 0; $j < $columns; $j++) {
	    	$flag = false;
	    	foreach ($xml->children() as $busy) {
		    if ($i == $busy->time) {
		       if ($j == $busy->day) {
		       	  echo "<td id='$i,$j' class='tableCell' style='background-color: $busy->colorType;'>$busy->eventName</td>";
			  $flag = true;
		       }
		    }
		}
		if ($flag != true) {
		    echo "<td class='tableCell'> </td>";
		}
	    }
	    echo "</tr>";
	}
    }

    //PRE: Takes string eventName, string colorType, arrays of integers days, times.
    //POST: Adds user input from form into the XML document (backend).
    //      Then, refreshes the page to show user changes to table.
    function addEvent($eventName, $colorType, $days, $times) {
        $daysSize = count($days);
	$timesSize = count($times);
	
        $xml = new DOMDocument("1.0", "utf-8");
	$xml->preserveWhiteSpace=false;
	$xml->formatOutput=true;
        $xml->load("busy.xml");
	
	$dataTag = $xml->documentElement;
	$busyTag = $dataTag->getElementsByTagName('busy');

	$flag = false;
	for ($i = 0; $i < $timesSize; $i++) {
	    for ($j = 0; $j < $daysSize; $j++) {
	        foreach ($busyTag as $domElement) {
	            if ($times[$i] == $domElement->getElementsByTagName('time')->item(0)->nodeValue) {
	                if ($days[$j] == $domElement->getElementsByTagName('day')->item(0)->nodeValue) {
		            $flag = true;
		        }
	            }
		}
		if ($flag != true) {
		    $newCell = $xml->createElement('busy');
		    $dataTag->appendChild($newCell);
	            $newCell->appendChild($xml->createElement('time', $times[$i]));
	            $newCell->appendChild($xml->createElement('day', $days[$j]));
	            $newCell->appendChild($xml->createElement('eventName', $eventName));
	            $newCell->appendChild($xml->createElement('colorType', $colorType));
		}
	    }
	}

	$xml->save("busy.xml");
	header("Location: calendar.php");
    }

    //PRE: Takes position of event integers x, y.
    //POST: Removes designated cell from backend XML file.
    //      Refreshing page will no longer show that table cell.
    function removeEvent($x, $y) {
        $xml = new DOMDocument("1.0", "utf-8");
        $xml->load("busy.xml");
	$dataTag = $xml->documentElement;
	$busyTag = $dataTag->getElementsByTagName('busy');

	$cell = null;
	foreach ($busyTag as $domElement) {
	    if ($x == $domElement->getElementsByTagName('time')->item(0)->nodeValue) {
	        if ($y == $domElement->getElementsByTagName('day')->item(0)->nodeValue) {
		    $cell = $domElement;
		}
	    }
	}

	if ($cell != null) {
	   $dataTag->removeChild($cell);
	}

	$xml->save("busy.xml");
	header("Location: calendar.php");
    }

?>
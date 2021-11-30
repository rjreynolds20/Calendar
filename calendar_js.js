//PRE: Takes strings eventName, colorType, and arrays days, times,
//     along with row of cells.
//POST: Edits given row of table, adding the user input as directed.
function editRow(eventName, colorType, days, times, rowCells) {
    for (let i = 0; i < days.length; i++) {
	rowCells[days[i]].innerHTML = eventName;
	rowCells[days[i]].style.backgroundColor = colorType;
    }
}

//PRE: Takes strings eventName, colorType, and arrays days, times.
//POST: Adds user input onto table by checking the times array, edits row by row.
function editTable(eventName, colorType, days, times) {
    for (let i = 0; i < times.length; i++) {
	row = document.getElementById(times[i]);
	rowCells = row.getElementsByTagName("td");
	editRow(eventName, colorType, days, times, rowCells);
    }
}

//PRE: User pressing button.
//POST: Displays the user input on the table as directed.
function addEvent() {
    let eventName = document.getElementById("eventName").value;
    let colorSelect = document.getElementById("colorType").selectedIndex;
    
    let markedDays = document.getElementsByName("eventDay");
    let selectedDays = new Array();
    // Gathers the checkbox values that are checked for days.
    for (let i = 0; i < markedDays.length; i++) {
	if (markedDays[i].checked) {
	    selectedDays.push(parseInt(markedDays[i].value)); //gets number value
	}
    }

    // Gathers the checkbox values that are checked for times. 
    let markedTimes = document.getElementsByName("eventTime");
    let selectedTimes = new Array();
    for (let i = 0; i < markedTimes.length; i++) {
	if (markedTimes[i].checked) {
	    selectedTimes.push(parseInt(markedTimes[i].value)); //gets number value
	}
    }
    editTable(eventName, colorType.value, selectedDays, selectedTimes);
}

//PRE: Takes the ID of the cell being reset.
//POST: Resets table cell back to default appearance, erases previous changes.
function resetCell(e) {
    e.innerHTML = " ";
    e.style.backgroundColor = "#1d3854";
    document.getElementById("x").value = e.id[0];
    document.getElementById("y").value = e.id[2];
    document.getElementById('reset').submit();
}

//PRE: Runs upon HTML body being loaded.
//POST: Adds event listeners to each individual table cell (td).
function addOnClick() {
    let tds = document.getElementsByTagName("td");
    for (td of tds) {
	td.addEventListener("click", function() { resetCell(this); } );
    }
}

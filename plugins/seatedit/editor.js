var action="cls1"; // currently selected tool
var bsize=2; // size of one box, in em
var seatelts=[]; // usage: htmlelt = seatelts[y][x]
var rowheadelts=[]; // rowheadelts[y] is the <input type="text">
		    // contained in the rowhead of row y.
var rows=0;
var cols=0;
var clipboard=[]; // usage: {type,number} = clipboard[y][x]
var selection; // the "selection" HTML element
var selectionanchor; // .x and .y attributes gives first corner of selection area
var notselecting = true; // set to false when selecting an area

var mapList = [];
var mapCount = 0;


/* Add n columns at the right of the map */
function addCols(n) {
    for (var y=0;y<rows;y++) {
	addSeats(n,cols,y);
    }
    cols += n;
}

/* Add n rows at the bottom of the map */
function addRows(n) {
    var mapelt = document.getElementById("map");
    for (var i=0;i<n;i++) {
	var rowhead = document.createElement("div");
	rowhead.setAttribute('class','rowhead');
	rowhead.style.top = (i+rows+1)*bsize+"em";
	var rowheadinput = document.createElement("input");
	rowheadinput.setAttribute('type','text');	
	rowheadinput.setAttribute('size','2');
	rowhead.appendChild(rowheadinput);
	mapelt.appendChild(rowhead);
	rowheadelts[rows+i] = rowheadinput;
	
	seatelts[i+rows]=[];
	/* Populate new row with blank seats */
	addSeats(cols,0,rows+i);
    }
    rows += n;
}
/* Add n seats, of coordinates (x,y) to (x+n-1,y) */
function addSeats(n,x,y) {
    var mapelt = document.getElementById("map");
    for (var i=0;i<n;i++) {
	newseat = document.createElement("div");
	newseat.setAttribute('onclick','selectSeat(event)');
	newseat.style.left = (x+i+1)*bsize+"em";
	newseat.style.top = (y+1)*bsize+"em";
	resetSeat(newseat);

	seatelts[y][x+i]=newseat;
	mapelt.appendChild(newseat);
    }
}

function copySelection() {
    clipboard = [];
    /* cx and cy are coordinates in the clipboard, mx and my are map coordinates */
    var cy=0;
    for (var my = getSelection().y;
	 my<getSelection().y+getSelection().h;
	 my++) {
	clipboard[cy] = [];
	var cx=0;
	for (var mx = getSelection().x;
	     mx<(getSelection().x+getSelection().w);
	     mx++) {
	    clipboard[cy][cx] = serialiseSeat(seatelts[my][mx]);
	    cx++;
	}
	cy++;
    }
}

/* Put input fields on all seats. attr: what comes after seat in the
   HTML element's class (contained in each seat) to edit, i.e. Number or Extra */
function edit(attr) {
    document.getElementById("options"+attr).className="";
    for (var y=0;y<rows;y++) {
	for (var x=0;x<cols;x++) {
	    if (seatelts[y][x].className!="blank") {
		var ch = getSeatElt(x,y,attr);
		var field = document.createElement("input");
		field.setAttribute('type','text');	
		field.setAttribute('size','2');
		field.setAttribute('value',ch.innerHTML);
		ch.innerHTML=""; /* Remove value text */
		ch.appendChild(field);
	    } // if non-blank seat
	} // looping seats in row 
    } // looping rows
}

/* Pass a blank or seat from the map (html element), get a record
 with .x and .y giving its coordinates */
function getCoords(elt) {
    return {x:(elt.style.left).substr(0,(elt.style.left).length-2)/bsize-1,
	    y:(elt.style.top).substr(0,(elt.style.top).length-2)/bsize-1};
}

function getSeatElt(x,y,attr) {
    for (ch=seatelts[y][x].firstChild;ch;ch = ch.nextSibling) {
	if (ch.className=="seat"+attr)
	    return ch;
    }
    return null;
}

/* Return the currently selected area, or the entire field if nothing
   is selected */
function getSelection() {
    if (selection)
	return selectionanchor;
    else
	return {x:0,y:0,w:cols,h:rows};
}

function loadMap() {
    var mapNum = document.getElementById("mapList").value; // map id
    var id = mapList[mapNum].id; // theatre id
    var zone = mapList[mapNum].zone;
    var name = mapList[mapNum].name;
    var http = new XMLHttpRequest();

    http.onreadystatechange=function() {
	var response;
	if (http.readyState==4) {
	    /* Response: An array of seats, each with attributes x, y,
	       row, col and extra */
	    var seats=eval('('+http.responseText+')');

	    /* First clear everything */
	    setEverywhere("blank");
	    for (var i=0;i<rows;i++) {
		rowheadelts[i].value = "";
	    }

	    document.getElementById("zoneName").value = zone;
	    document.getElementById("theatreName").value = name;

	    var badcoords=0; // how many seats had invalid coordinates

	    for (var i=0;i<seats.length;i++) {
		if (seats[i].row == -1) continue; // skip unnumbered seats
		/* Make sure we've enough space */
		if (seats[i].x>=cols) addCols(seats[i].x-cols+1);
		if (seats[i].y>=rows) addRows(seats[i].y-rows+1);
		if (seats[i].x<0 || seats[i].y<0) {
		    badcoords++;
		    continue;
		}
		seatelts[seats[i].y][seats[i].x].className = "cls"+seats[i].cls;
		getSeatElt(seats[i].x,seats[i].y,"Number").innerHTML = seats[i].col;
		getSeatElt(seats[i].x,seats[i].y,"Extra").innerHTML = seats[i].extra;
		rowheadelts[seats[i].y].value = seats[i].row;
	    }

	    if (badcoords>0) alert("WARNING, "+badcoords+" seat(s) had negative coordinates and was (were) skipped.");
	}
    };
    http.open("GET","index.php?id="+id+"&zone="+zone,true);
    http.send(null);
}

function saveMap() {
    var http = new XMLHttpRequest();
    http.onreadystatechange=function() {
	if (http.readyState==4) {

	    var response = eval('('+http.responseText+')');
	    if (! response.ok)
		alert(response.msg);
	    /* TODO add an entry into the mapList select *if required* */
	}
    };
    http.open("POST","index.php",true);
    http.setRequestHeader('Content-Type',
			  'application/x-www-form-urlencoded');
    var data = "theatre="+escape(document.getElementById("theatreName").value) +
	"&zone="+escape(document.getElementById("zoneName").value);
    var seat;
    for (var y=0;y<rows;y++) {
	for (var x=0;x<cols;x++) {
	    if (seatelts[y][x].className != "blank") {
		seat = serialiseSeat(seatelts[y][x]);
		data += "&x[]="+x;
		data += "&y[]="+y;
		data += "&cls[]="+seatelts[y][x].className.substr(3);
		data += "&col[]="+escape(seat.number);
		data += "&xtra[]="+escape(seat.extra);
		data += "&row[]="+escape(rowheadelts[y].value);
	    }
	}
    }
    http.send(data);
}

/** Add the corresponding data into the mapList array, and extend the
   mapList SELECT */
function registerMap(id,name,zone) {
    mapList[mapCount] = {id:id, name:name, zone:zone};
    /* Beware, the map identifier mapCount is distinct from the
       theatre identifier id */

    var opt = document.createElement("option");
    opt.setAttribute("value",mapCount);
    opt.innerHTML = name+" / "+zone;
    document.getElementById("mapList").appendChild(opt);
    mapCount++;
}

function renumRows(toptobottom) {
    var rowStyle = document.getElementById("rowStyle").value;
    var formatter;
    if (rowStyle == "upper") {
	formatter = upperRS;
    } else if (rowStyle == "lower") {
	formatter = lowerRS;
    } else if (rowStyle == "roman") {
	formatter = romanRS;
    } else {
	formatter = numericRS;
    }
    rownum=1;

    for (var y=(toptobottom?0:rows-1);
	 toptobottom?y<rows:y>=0;
	 toptobottom?y++:y--) {
	var seatfound=false;
	for (var x=0;x<cols;x++) {
	    if (seatelts[y][x].className != 'blank') {
		seatfound=true;
		break;
	    }
	}
	if (seatfound) {
	    rowheadelts[y].value=formatter(rownum);
	    rownum++;
	} else {
	    rowheadelts[y].value="";
	}
    }
}

function numericRS(i) {
    return i;
}

function upperRS(i) {
    var r = "";
    i--; // more convenient to start from zero
    var unit = (i % 26);
    i = (i-unit)/26;
    var unitLetter = String.fromCharCode(65+unit);
    for (x=0; x<=i; x++) {
	r += unitLetter;
    }
    return r;
}

function lowerRS(i) {
    var r = "";
    i--; // more convenient to start from zero
    var unit = (i % 26);
    i = (i-unit)/26;
    var unitLetter = String.fromCharCode(97+unit);
    for (x=0; x<=i; x++) {
	r += unitLetter;
    }
    return r;
}

function romanRS(i) {
    var r = "";
    /* hundreds (not bothering with D and M we don't have that big
       theatres do we??) */
    while (i >= 100) {
	r += "C";
	i -= 100;
    }
    /* tenths */
    if (i>=90) {
	r += "XC";
	i -= 90;
    } else if (i>=50) {
	r += "L";
	i -= 50;
    } else if (i>=40) {
	r += "XL";
	i -= 40;
    }
    while (i>=10) {
	r += "X";
	i -= 10;
    }
    /* units. */
    if (i>=9) {
	r += "IX";
	i -= 9;
    } else if (i>=5) {
	r += "V";
	i -= 5;
    } else if (i>=4) {
	r += "IV";
	i -= 4;
    }
    while (i>=1) {
	r += "I";
	i -= 1;
    }
    return r; // i is supposed to be zero by now...
}

/* Blank the seat (elt: the corresponding HTML element) */
function resetSeat(elt) {
    elt.setAttribute('class','blank');
    elt.innerHTML="<span class='seatNumber'></span><span class='seatExtra'></span>";
}

/* Based on the contents of the selectionanchor variable resize the HTML selection object */
function resizeSelection() {
    selection.style.width = selectionanchor.w*bsize+"em";
    selection.style.height = selectionanchor.h*bsize+"em";
    selection.style.position = "absolute";
    selection.style.left = (selectionanchor.x+1)*bsize-0.2+"em";
    selection.style.top = (selectionanchor.y+1)*bsize-0.2+"em";
}

/* This gets called when the user clicked on a seat */
function selectSeat(e) {
    var target = e.target;
    /* Move up the hierarchy until reaching the seat DIV (which,
       conveniently, only contains text nodes, SPANs and INPUTs) */
    while (target.nodeName != "DIV") target = target.parentNode;

    if (action=="select") {
	if (notselecting) {
	    unselect();
	    selectionanchor = getCoords(target); // Note: global variable, re-used in the "else"
	    selectionanchor.w = 1;
	    selectionanchor.h = 1;
	    selection = document.createElement("div");
	    selection.className = "select";
	    selection.setAttribute('onclick','unselect()');
	    resizeSelection();
	    document.getElementById("map").appendChild(selection);
	    notselecting = false;
	} else {
	    var c2 = getCoords(target);
	    selectionanchor.w = Math.abs(selectionanchor.x-c2.x)+1;
	    selectionanchor.h = Math.abs(selectionanchor.y-c2.y)+1;
	    selectionanchor.x = Math.min(selectionanchor.x,c2.x);
	    selectionanchor.y = Math.min(selectionanchor.y,c2.y);
	    resizeSelection();
	    notselecting = true;
	}
    } else if (action=="paste") {
	var d = getCoords(target);
	var ch = clipboard.length;
	if (!ch) return;
	var cw = clipboard[0].length;
	for (var cy = 0;cy<ch && cy+d.y<rows; cy++) {
	    for (var cx = 0;cx<cw && cx+d.x<cols; cx++) {
		seatelts[cy+d.y][cx+d.x].setAttribute
		    ('class',clipboard[cy][cx].type);

		var source = clipboard[cy][cx]; // js object
		getSeatElt(cx+d.x, cy+d.y, "Number").innerHTML = source.number;
		getSeatElt(cx+d.x, cy+d.y, "Extra").innerHTML = source.extra;
	    }
	}
    } else if (action=="numbers" || action=="extra") {
	// do nothing, the user is selecting a text field...
    } else {
	if (action=="blank")
	    resetSeat(target);
	else
	    target.className = action;
    }

}

/** Given an HTML element representing a seat, return a structure
   usable in the clipboard */
function serialiseSeat(elt) {
    var r = {type:elt.className};
    for (ch=elt.firstChild;ch;ch = ch.nextSibling) {
	var fields = ch.childNodes;
	var value;
	if (fields.length==1 && fields[0].nodeName=="INPUT") {
	    value=fields[0].value;
	} else {
	    value=ch.innerHTML;
	}
	if (ch.className=="seatNumber")
	    r.number = value;
	else if (ch.className=="seatExtra")
	    r.extra = value;
    }
    return r;
}

function setCurrentTool(e) {
    var mapelt = document.getElementById("map");
    var toolHighlight = document.getElementById("currentTool");
    var prevAction = action;

    action = e.target.className;
    if (action=="select") {
	unselect();
    }
    if (action == prevAction) return;

    toolHighlight.parentNode.removeChild(toolHighlight);
    e.target.appendChild(toolHighlight);

    if (action=="numbers") {
	mapelt.className = "map withNumbers";
	edit("Number");
    } else if (prevAction == "numbers") {
	unedit("Number");
    }

    if (action=="extra") {
	mapelt.className = "map withExtra";
	edit("Extra");
    } else if (prevAction == "extra") {
	unedit("Extra");
    }
}

function setEverywhere(action) {
    if (action == "select") {
    } else if (action == "paste") {
	/* Some day we'll use the clipboard as a pattern to repeat */
    } else {
	// Initial seat number
	var inum=document.getElementById("subset").value=="even"?
	    2:1;
	// Current seat number
	var num=inum;
	// Seat number increment
	var dnum=document.getElementById("subset").value=="all"?
	    1:2;
	var downwards=document.getElementById("vert").value!="btt";
	var rightwards=document.getElementById("horiz").value=="ltr";
	for (var y = downwards?
		 getSelection().y : (getSelection().y+getSelection().h-1);
	     downwards? y<(getSelection().y+getSelection().h) : y>=getSelection().y;
	     downwards? y++ : y--) {

	    if (document.getElementById("vert").value=="indep") num=inum;
	    for (var x = rightwards?
		     getSelection().x : (getSelection().x+getSelection().w-1);
		 rightwards? x<(getSelection().x+getSelection().w) : x>=getSelection().x;
		 rightwards? x++ : x--) {
		if (action=="numbers" || action=="extra") {
		    var attr = (action=="numbers")?"Number":"Extra";
		    var val = (action=="numbers")?num:document.getElementById("defaultExtra").value;
		    if (seatelts[y][x].className != "blank") {
			var ch = getSeatElt(x,y,attr);
			var fields = ch.childNodes;
			if (fields.length==1 && fields[0].nodeName=="INPUT")
			    fields[0].value=val;
			else
			    ch.innerHTML=val;
			num+=dnum; // not needed but harmless for Extra
		    }
		} else {
		    if (action=="blank")
			resetSeat(seatelts[y][x]);
		    else
			seatelts[y][x].setAttribute('class',action);
		}
	    }
	}
    }
}

/* Replace attr-input fields and move their values into innerHTML */
function unedit(attr) {
    document.getElementById("options"+attr).className="options"; // hide options
    for (var y=0;y<rows;y++) {
	for (var x=0;x<cols;x++) {
	    var fields = getSeatElt(x,y,attr).childNodes;
	    if (fields.length==1 && fields[0].nodeName=="INPUT") {
		ch.innerHTML=fields[0].value;
	    }
	}
    }
}

function unselect() {
    if (selection) {
	selection.parentNode.removeChild(selection);
	selection=null;
	notselecting = true;
    }
}

var req;
var isIE;
var completeField;
var completeTable;
var autoRow;

function init() {
    completeField = document.getElementById("complete-field");
    completeTable = document.createElement("table");
    completeTable.setAttribute("class", "popupBox");
    completeTable.style.display = 'none';
    completeTable.style.border = "solid #496007 1px" 
    completeTable.style.position = 'absolute';
    completeTable.style.width = "200px";
    autorow = document.getElementById("auto-row");
    autorow.appendChild(completeTable);
}

function movepopup(){
    completeTable.style.top = getElementY(completeField) + "px";
    completeTable.style.left = getElementX(completeField) + "px";   
}

function clearTable() {
    if (completeTable.getElementsByTagName("tr").length > 0) {
        completeTable.style.display = 'none';
        for (loop = completeTable.childNodes.length -1; loop >= 0 ; loop--) {
            completeTable.removeChild(completeTable.childNodes[loop]);
        }
    }
}

function getElementY(element){
    var y = 0;
    while (element.offsetParent) {
        y += element.offsetTop + 8;
        element = element.offsetParent;
    }
    return y;
}

function getElementX(element){
    var x = 0;
    while (element.offsetParent) {
        x += element.offsetLeft;
        element = element.offsetParent;
    }
    return x;
}

function appendStudent(studentname,studentid) {

    var row;
    var cell;
    var linkElement;

    if (isIE) {
        completeTable.style.display = 'block';
        row = completeTable.insertRow(completeTable.rows.length);
        cell = row.insertCell(0);
    } else {
        completeTable.style.display = 'table';
        row = document.createElement("tr");
        cell = document.createElement("td");
        row.appendChild(cell);
        completeTable.appendChild(row);
    }

    cell.className = "popupCell";

    linkElement = document.createElement("a");
    linkElement.className = "popupItem";
    linkElement.setAttribute("href", "/databook/reports/student.php?studentid=" + studentid);
    linkElement.appendChild(document.createTextNode(studentname));
    cell.appendChild(linkElement);
}

function doCompletion() {
    if (completeField.value.length==0)
    { 
        clearTable();
        return;
    }
    
    completeTable.style.top = getElementY(completeField) + "px";
    completeTable.style.left = getElementX(completeField) + "px";
    
    var url = "/databook/ajax/stusearch.php?id=" + escape(completeField.value);
    req = initRequest();
    req.open("GET", url, true);
    req.onreadystatechange = callback;
    req.send(null);
}

function initRequest() {
    if (window.XMLHttpRequest) {
        if (navigator.userAgent.indexOf('MSIE') != -1) {
            isIE = true;
        }
        return new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        isIE = true;
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function callback() {

    clearTable();

    if (req.readyState == 4) {
        if (req.status == 200) {
            parseMessages(req.responseXML);
        }
    }
}

function parseMessages(responseXML) {

    // no matches returned
    if (responseXML == null) {
        return false;
    } else {

        var students = responseXML.getElementsByTagName("students")[0];

        if (students.childNodes.length > 0) {
            for (loop = 0; loop < students.childNodes.length; loop++) {
                var student = students.childNodes[loop];
                var studentname = student.getElementsByTagName("studentname")[0];
                var studentid = student.getElementsByTagName("studentid")[0];
                appendStudent(studentname.childNodes[0].nodeValue, studentid.childNodes[0].nodeValue);
            }
        }
    }
}

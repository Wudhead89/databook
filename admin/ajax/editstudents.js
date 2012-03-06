function getForms(year)
{
    if (year == "") {
        document.getElementById("selectForm").innerHTML="";
        return;
    } 
                
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("selectForm").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/getforms.php?year="+year,true);
    xmlhttp.send();
}

function formSelected(form)
{
    document.getElementById("selectStudent").innerHTML="";
    document.getElementById("editStudent").innerHTML="";
                
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("selectStudent").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/getstudents.php?form="+form,true);
    xmlhttp.send();
}

function getStuDetails(studentid,year)
{
    document.getElementById("editStudent").innerHTML="";
               
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("editStudent").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/getstudetails.php?studentid="+studentid+"&year="+year,true);
    xmlhttp.send();
}


function editStuGrades(studentid)
{
    document.getElementById("editStudent").innerHTML="";
    
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("editStudent").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/editstugrades.php?studentid="+studentid,true);
    xmlhttp.send();
}

function updateStudent(studentid)
{
    var e;
    
    e = document.getElementById("studentform");
    var form = e.options[e.selectedIndex].value;
    
    e = document.getElementById("studentfsm");
    var fsm = e.options[e.selectedIndex].value;
    
    e = document.getElementById("studentsen");
    var sen = e.options[e.selectedIndex].value;
    
    document.getElementById("updatestudentresponse").innerHTML="";
    
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("updatestudentresponse").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/updatestudetails.php?studentid="+studentid+"&form="+form+"&fsm="+fsm+"&sen="+sen,true);
    xmlhttp.send();    
                
}

function updateStuGrade(resultid, scale, newgrade)
{
    document.getElementById("updatestudentresponse").innerHTML="";
    
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("updatestudentresponse").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/updatestugrade.php?resultid="+resultid+"&scale="+scale+"&newgrade="+newgrade,true);
    xmlhttp.send();     
}

function deleteStudent(studentid)
{
    document.getElementById("updatestudentresponse").innerHTML="";
    
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("updatestudentresponse").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/deletestudent.php?studentid="+studentid,true);
    xmlhttp.send();
}

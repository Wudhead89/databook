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
    if (form == "") {
        document.getElementById("selectStudent").innerHTML="";
        return;
    } 
                
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("selectStudent").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../admin/ajax/getstudents.php?form="+form,true);
    xmlhttp.send();
}
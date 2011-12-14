function showYear(year)
{
    if (year == "") {
        document.getElementById("selectForm").innerHTML="";
        return;
    } 
                
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        //if (xmlhttp.readyState==4 && xmlhttp.status==200)
        //{
            document.getElementById("selectForm").innerHTML=xmlhttp.responseText;
        //}
    }
    xmlhttp.open("GET","../ajax/getforms.php?year="+year,true);
    xmlhttp.send();
}

function formSelected(form)
{
    if (form == "") {
        document.getElementById("formProfile").innerHTML="";
        return;
    } 
    
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("formProfile").innerHTML = xmlhttp.responseText;
    }
    xmlhttp.open("GET","../ajax/getformprofile.php?form="+form,true);
    xmlhttp.send();
}
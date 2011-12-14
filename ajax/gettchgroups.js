function getTchGroups(lectid)
{
    document.getElementById("tchgroupdata").innerHTML="";
    
    if (lectid == "") {
        document.getElementById("selecttchgroup").innerHTML="";
        return;
    } 
                
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        //if (xmlhttp.readyState==4 && xmlhttp.status==200)
        //{
            document.getElementById("selecttchgroup").innerHTML=xmlhttp.responseText;
        //}
    }
    xmlhttp.open("GET","../ajax/gettchgroups.php?lectid="+lectid,true);
    xmlhttp.send();
}

function getGroupData(groupid)
{
    if (groupid == "") {
        document.getElementById("tchgroupdata").innerHTML="";
        return;
    } 
                
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        document.getElementById("tchgroupdata").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","../ajax/getgroupdata.php?groupid="+groupid,true);
    xmlhttp.send();
}

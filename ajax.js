/*******************************************************************************
	Filename		: ajax.js

	Created			: 03 August 2008 (22:25:47)
	Created by		: Douglas Stridsberg

	Last Updated	: 08 August 2008 (14:13:29)
	Updated by		: Douglas Stridsberg

	Comments		: 
*******************************************************************************/	
var xmlHttp

function goPage(str)
{ 
  xmlHttp=GetXmlHttpObject();
  if (xmlHttp==null)
    {
    alert ("Your browser does not support AJAX!");
    return;
    }      	
      	xmlHttp.onreadystatechange=switchPage;
      	xmlHttp.open("GET", str, true);
      	xmlHttp.send(null); 
      }

function placeVote()
{ 
  xmlHttp=GetXmlHttpObject();
  if (xmlHttp==null)
    {
    alert ("Your browser does not support AJAX!");
    return;
    }
      	var id = document.getElementById('id').value;
      	var vote = document.getElementById('vote').value;
      	var queryString = "?id=" + id + "&vote=" + vote;
      	
      	xmlHttp.onreadystatechange=showResult;
      	xmlHttp.open("GET", "vote.php" + queryString, true);
      	xmlHttp.send(null); 
      }

function showResult() 
{ 
  if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
  { 
    document.getElementById("resultDiv").innerHTML=xmlHttp.responseText;
  }
}

function switchPage() 
{ 
  if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
  { 
    document.getElementById("mainDiv").innerHTML=xmlHttp.responseText;
  }
}

function GetXmlHttpObject()
  {
  var xmlHttp=null;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
  return xmlHttp;
  }
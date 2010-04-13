	/*
			dG52 PHP and AJAX Poll software
	
			Author: Douglas Stridsberg
				Email: doggie52@gmail.com
				URL: www.douglasstridsberg.com
	*/
	
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

	for (var i = 0; i < document.vote.voteradio.length; i++){
		if (document.vote.voteradio[i].checked==true)
		var id = i
	}
	var vote = document.getElementById('voteid').value;
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
	} else {
		document.getElementById("resultDiv").innerHTML="<img src=\"images/loading.gif\" />";
	}
}

function switchPage() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById("mainDiv").innerHTML=xmlHttp.responseText;
	} else {
		document.getElementById("resultDiv").innerHTML="<img src=\"images/loading.gif\" />";
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		// Test for Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Test for two different objects for Internet Explorer
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
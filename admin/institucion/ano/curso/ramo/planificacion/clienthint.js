var xmlHttp;
var thedate = new Date( );
var theminute = thedate.getMinutes( );
var thesecond = thedate.getSeconds( ) + 1;

function carga_template(str){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="planis_load.php";
	url=url+"?q="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function stateChanged() {
	if (xmlHttp.readyState==4){
		document.getElementById("disp_template").innerHTML=xmlHttp.responseText;
	}
/*	if (xmlHttp.readyState == 3){
		document.getElementById('disp_template').innerHTML = "Estado 3"; 
	}
	if (xmlHttp.readyState == 2){
		document.getElementById('disp_template').innerHTML = "Estado 2"; 
	}*/
	if (xmlHttp.readyState==1){
		document.getElementById('disp_template').innerHTML = '<img src="../../../../ajax-loading.gif" width="100" height="100" /><br />La informaci&oacute;n se esta procesando, por favor espere<br />'+theminute+" "+thesecond; 
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

var xmlHttp;
var divid;

function enviar_post(url, parameters, div){
		// trick
	divid = div
	// crear objeto
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp==null){
		alert("Utilice un browser más moderno y/o active la ejecución de javascript")
		return;
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open('POST', url, true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", parameters.length);
	xmlHttp.send(parameters);
}

function stateChanged() {
	if (xmlHttp.readyState==4){
		document.getElementById(divid).innerHTML= xmlHttp.responseText;
	}
/*	if (xmlHttp.readyState == 3){
		document.getElementById(divid).innerHTML = "Estado 3"; 
	}
	if (xmlHttp.readyState == 2){
		document.getElementById(divid).innerHTML = "Estado 2"; 
	}*/
	if (xmlHttp.readyState == 1){
		document.getElementById(divid).innerHTML = '<br/>La informaci&oacute;n se esta procesando, por favor espere<br />';
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try	{
  		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function fadeIt(ele,url){
	Spry.Effect.DoFade(ele,{ duration: 200, from: 100, to: 0, finish: function() {
		Spry.Utils.updateContent(ele, url, function() {
			Spry.Effect.DoFade(ele,{ duration: 200, from: 0, to: 100 });
		});
  }
 });
}

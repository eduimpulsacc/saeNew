<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
body {font-family: Geneva, Arial, Helvetica, sans-serif; }

.Tab {
      float:left;
      width:100%;
      background:#99CCFF;
      font-size:93%;
      line-height:normal;
}
.Tab ul {
	margin:0;
	padding:10px 10px 0 50px;
	list-style:none;
}
.Tab li {
      display:inline;
      margin:0;
      padding:0;
}
.Tab a {
      float:left;
      background:url("izq.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 4px;
      text-decoration:none;
}
.Tab a span {
      float:left;
      display:block;
      background:url("der.gif") no-repeat right top;
      padding:5px 15px 4px 6px;
      color:#666;
}
.Tab a span {float:none;}
.Tab a:hover span { color:#000;}
.Tab a:hover {background-position:0% -42px; }
.Tab a:hover span {background-position:100% -42px;}
-->
</style>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
if ( typeof XMLHttpRequest=="undefined")XMLHttpRequest = function(){return new ActiveXObject(navigator.userAgent.indexOf("MSIE 5") >= 0 ?"Microsoft.XMLHTTP" : "Msxml2.XMLHTTP");};
var ajax=new XMLHttpRequest();

function Ajax(contenido)
{
ajax.open("GET","proceso.php?marca="+contenido,true);
ajax.onreadystatechange=function (){if(ajax.readyState==4){var respuesta=ajax.responseText; document.getElementById('mostrar').innerHTML=respuesta}}
ajax.send(null);
}
/*]]>*/
</script>
</head>

<body bgcolor="#99CCFF">
<table width="436" border="0" heigth="400px" cellpadding="0" cellspacing="0" bgcolor="#99CCFF" >
  <tr>
    <td>
        <div class="Tab">
          <ul>
            <li><a href="javascript:Ajax('google');" ><span>Google</span></a></li>
            <li><a href="javascript:Ajax('yahoo');" ><span>Yahoo</span></a></li>
            <li><a href="javascript:Ajax('mozilla');"><span>Mozilla</span></a></li>
            <li><a href="javascript:Ajax('openofice');"><span>Open Oficee</span></a></li>
          </ul>
        </div>
    </td>
   </tr>
  <tr>
    <td bgcolor="#F6F6F6" height="380" id="mostrar">&nbsp;
    Contenido
    </td>
  </tr>
</table>
</body>
</html>

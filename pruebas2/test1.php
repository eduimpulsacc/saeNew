<html>
<head>
<title></title>
</head>
<script language="javascript1.1">
function ajaxFunction() {
var xmlHttp;
try {
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
return xmlHttp;
} catch (e) {
// Internet Explorer
try {
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
return xmlHttp;
} catch (e) {
try {
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
return xmlHttp;
} catch (e) {
alert("Tu navegador no soporta AJAX!");
return false;
}}}
}

function Enviar(valor) {

var ajax;
ajax = ajaxFunction();

ajax.open("POST","test2.php?valor="+valor, true);

ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
ajax.onreadystatechange = function()
{

if (ajax.readyState == 4){
    if (ajax.status==200){
          document.getElementById("contenido").innerHTML = "<input type='text' name='nombre' value='"+ajax.responseText+"' size='40'  />";

}}}
ajax.send(null);
}
</script>
<body>
<form name="form" method="post" action="#">
<table width="500" border="1">
<tr>
  <td>Rut</td>
  <td><input type="text" name="rut" value="" id="rut" size="12" onBlur="Enviar(this.value);" /></td>
 </tr>
 <tr>
  <td>Nombre</td>
  <td><div id="contenido"><input type="text" name="nombre" value="" size="40"  /></div></td>
 </tr>
</table>
</form>
</body>
</html>
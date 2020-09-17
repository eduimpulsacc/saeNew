<html>
<head>
<title>Untitled</title>
<script language="Javascript">
function mostrar(nombreCapa){
document.getElementById(nombreCapa).style.visibility="visible";
}
function ocultar(nombreCapa){
document.getElementById(nombreCapa).style.visibility="hidden";
}
</script>
</head>
<body>
<div id="capa1" style="position:absolute;width:100;height:100;top:100;left:100;background-color:blue" onmouseout="ocultar('capa2')" onmouseover="mostrar('capa2')">
Capa 1
</div>
<div id="capa2" style="position:absolute;width:100;height:100;top:100;left:200;background-color:red;visibility:hidden">
Capa 2
</div>

<img src="ajax-loader(2).gif" alt="imagen" width="65" height="65" border="1">
</body>
</html> 
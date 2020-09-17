<!--
//Funcion de macromedia, excelente desempeño!. Se le pasa objeto y donde buscar (por default el document actual)
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

//Variable para el preload. Suelo usar un gif, pero esto es mas liviano para el ejemplo.
var PreLoader = 'Cargando...';
var Docente = 'Selecciona al Profesor Jefe';

//Esta función es la que procesará un archivo (pagina) y mostrará el resultado en un objeto del document (destino), siempre sera procesando mediante origen (que es el iframe).
function cargarPagina( pagina, destino, origen, posicion ){
	//Primero muestro el preload
	mostrarPreLoader( destino );
	//Y luego le digo al iframe que me procese el php "pagina". Además le paso "destino" así se a donde muestro el resultado.
	frames[origen].location.href = pagina + '&destino=' + destino + '&posicion=' + posicion;
}

//Función que mostrará el preload
function mostrarPreLoader( destino ){
	var objeto = MM_findObj( destino );
	objeto.innerHTML = PreLoader;
}

//Esta funcion es solo para este ejemplo, asi separamos mas las cosas:
function recargarFirma( firma ){
	var codfirma = firma.value;
	cargarPagina('configuracion_reporte2.php?cmbFIRMA=' + codfirma,'divCentral','iframeCentral',1);
	return false;
}
function recargarFirma2( firma ){
	var codfirma = firma.value;
	cargarPagina('procesaFirma.php?cmbFIRMA=' + codfirma,'divCentral2','iframeCentral2',2);
	return false;
}
function recargarFirma3( firma ){
	var codfirma = firma.value;
	cargarPagina('procesaFirma.php?cmbFIRMA=' + codfirma,'divCentral3','iframeCentral3',3);
	return false;
}
function recargarFirma4( firma ){
	var codfirma = firma.value;
	cargarPagina('procesaFirma.php?cmbFIRMA=' + codfirma,'divCentral4','iframeCentral4',4);
	return false;
}
//-->
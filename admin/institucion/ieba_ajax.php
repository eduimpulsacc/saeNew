<?php 
	require('../../util/header.inc');
	require('prueba.php');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	
	$estado = array (
                'pae' =>"disabled",
                'CA' =>"disabled",
                'CP' =>"disabled",
                'WS' =>"disabled",
                'CPA' =>"disabled",
                'EX' =>"disabled"
        );
		
	if ($frmModo == NULL){
	   $frmModo = "mostrar";
	} 
	  	
		
?>	
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<!--link href="estilo_vhs.css" rel="stylesheet" type="text/css"-->
<SCRIPT type=text/javascript>
if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.submenu2{display: none;}\n')
document.write('</style>\n')
}
</SCRIPT>


<script language="javascript" type="text/javascript">
//CRONOMETRO
//Autor: Iván Nieto Pérez
//Este script y otros muchos pueden
//descarse on-line de forma gratuita
//en El Código: www.elcodigo.com
var CronoID = null
var CronoEjecutandose = false
var decimas, segundos, minutos

function DetenerCrono (){
   	if(CronoEjecutandose)
   		clearTimeout(CronoID)
   	CronoEjecutandose = false
}

function InicializarCrono () {
	//inicializa contadores globales
	decimas = 0
	segundos = 0
	minutos = 0
	
	//pone a cero los marcadores
	document.crono.display.value = '00:00:0'
	document.crono.parcial.value = '00:00:0'
}

function MostrarCrono () {
	       
   	//incrementa el crono
   	decimas++
	if ( decimas > 9 ) {
		decimas = 0
		segundos++
		if ( segundos > 59 ) {
			segundos = 0
			minutos++
			if ( minutos > 99 ) {
				alert('Fin de la cuenta')
				DetenerCrono()
				return true
			}
		}
	}

	//configura la salida
	var ValorCrono = ""
	ValorCrono = (minutos < 10) ? "0" + minutos : minutos
	ValorCrono += (segundos < 10) ? ":0" + segundos : ":" + segundos
	ValorCrono += ":" + decimas	
			
  	document.crono.display.value = ValorCrono

  	CronoID = setTimeout("MostrarCrono()", 100)
	CronoEjecutandose = true
	return true
}

function IniciarCrono () {
 	DetenerCrono()
 	InicializarCrono()
	MostrarCrono()
}

function ObtenerParcial() {
	//obtiene cuenta parcial
	document.crono.parcial.value = document.crono.display.value
}




</script>



<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//-->
</script>


<script language = "javascript">



  var XMLHttpRequestObject = false; 

  if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }

  function proceso(divID,form)
  {
    var url = "proceso.php";
    var ano = form.ano.value;
    var mes = form.mes.value;

    if(XMLHttpRequestObject) {
    	
    	
      XMLHttpRequestObject.open("POST", url); 
      XMLHttpRequestObject.setRequestHeader('Content-Type', 
        'application/x-www-form-urlencoded'); 
      var obj = document.getElementById(divID);   

      XMLHttpRequestObject.onreadystatechange = function() 
      { 
        if (XMLHttpRequestObject.readyState == 4 && 
          XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText; 
				ocultar(form,'espera');
        } 
       
        	
        
      } 

      XMLHttpRequestObject.send("ano="+ano+"&mes="+mes); 
      

    }
  }
  
function mostrar(form,nombreCapa){	
	document.getElementById(nombreCapa).style.visibility="visible";
	form.submit.disabled = true;
	document.getElementById('targetDiv').style.visibility="hidden";
	
	
	
}
function ocultar(form,nombreCapa){
	document.getElementById(nombreCapa).style.visibility="hidden";
	form.submit.disabled = false;
	DetenerCrono();
	document.getElementById('targetDiv').style.visibility="visible";
}

function mostrar_reloj(nombreCapa){	
	document.getElementById(nombreCapa).style.visibility="visible";
	IniciarCrono();
}
  
  

</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always ;height:0;line-height:0
 }
 
.Estilo1 {font-size: 12px}
.Estilo3 {	font-size: 12px;
	color: #6699FF;
	font-weight: bold;
	
}
.td_muestra {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	text-decoration: none;
	height: 30px;
	color: #666666;



}
</style>
</head>

<body>
<br>
<br>

<form method="post" action="ieba.php">

<?
	$nombre_xml = " ";
	$qry="SELECT TRIM(nombre_instit) FROM INSTITUCION WHERE RDB=".trim($institucion);
	$result=pg_exec($conn,$qry);
	$num=pg_numrows($result);
	for ($i=0;$i<$num;$i++){
		$row=pg_fetch_array($result);
		$nombre_xml = (string)$row[0];
		 
	}
	

	$query_cat="select * from ano_escolar where id_institucion ='$institucion' order by nro_ano";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);
	
	echo "<table>";
	echo "<tr>";
	echo "<td>A&ntilde;o</td>";
	echo "<td>";
	echo "<select name = ano>";
		echo "<option value=0>Seleccione a&ntilde;o</option>";
	
	for ($i=0;$i<$num_cat;$i++){
		$row_cat=pg_fetch_array($result_cat);
		echo "<option value='$row_cat[id_ano]-$row_cat[nro_ano]'>$row_cat[nro_ano]</option>";
		 
	}
	echo "</select>";
	echo "</td>";
	echo "</tr>";
	 
	echo "<tr>";
	echo "<td>Mes</td>";
	echo "<td>";
	echo "<select name = mes>";
		echo "<option value=0>Seleccione mes</option>";
		echo "<option value=03>Marzo</option>";	
		echo "<option value=04>Abril</option>";	
		echo "<option value=05>Mayo</option>";	
		echo "<option value=06>Junio</option>";	
		echo "<option value=07>Julio</option>";	
		echo "<option value=08>Agosto</option>";	
		echo "<option value=09>Septiembre</option>";	
		echo "<option value=10>Octubre</option>";	
		echo "<option value=11>Noviembre</option>";	
		echo "<option value=12>Diciembre</option>";		
	
	echo "</select>";
	echo "</td>";
	echo "</tr>";	
	
	echo "<tr><td></td></tr>";
	echo "<tr><td colspan = 2 align = center>
	
	<input name=submit type=button  id=generar value=Generar class=botonXX  onclick = \"mostrar(this.form,'espera');proceso('targetDiv',this.form);mostrar_reloj('reloj'); \" >
	</td></tr>";	
	 
	echo "</table>";
	
?>

    <div id="targetDiv" style="visibility:hidden">
      
    </div>
    
    

</form>

<div id = "reloj" style="visibility:hidden" >  
	<form name="crono">  
	Tiempo transcurrido: <input type="text" size="8" name="display" value="00:00:0" disabled> 
	<input type="button" name="Iniciar" value=" Iniciar " onClick="IniciarCrono()" style="visibility:hidden"> 
	<input  type="text" size="8" name="parcial" value="00:00:0" style="visibility:hidden">
	<input type="button" name="Parcial" value="Parcial" onClick="ObtenerParcial()"  style="visibility:hidden">  
	<input type="button" name="Parar" value=" Parar " onClick="DetenerCrono()" style="visibility:hidden">
	<input type="button" name="Cero" value="  Cero  " onClick="DetenerCrono(); InicializarCrono()" style="visibility:hidden">
	</form>  
</div>  
	<div id="espera" style="visibility:hidden">
		
		<center><h1>Estamos procesando su solicitud</h1>
		</center>
		<br>
		<center>
		<img src="ajax-loader(2).gif" alt="imagen" width="65" height="65" border="1">
		</center>
	</div>

</body>
</html>

<? 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript">

$(document).ready(function(){ // Script para cargar al inicio del modulo
inicio();
});

function inicio(){
	var parametros = "funcion=1";
	alert(parametros);

	$.ajax({
		url:'mod/cierre_colegio/cont_cierra.php',
		//url:'cont_doc.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error de Sistema");
			}else{
				$('#proceso_cierre1').html(data);
				//cargardatos();
				

			}
		}
	})	
}
function CicloPlantillas(id){
 var parametros ="funcion=2&id="+id;
 alert(parametros);
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra.php',
		data:parametros,
		type:'POST',
		success:function(data){
		//alert(data);
			if(data==0){
				alert("Error en Cierre Evaluado");
			}else{
				$('#proceso_cierre1').html(data);
			}
		} 
	})
}

function cargardatos(){
 var parametros ="funcion=9";
 alert(parametros);
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				CicloPlantillas(0);
			}
		}
	})
}
function cargardimension(){
 var parametros ="funcion=2";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				CicloPlantillas2(0);
				//ddirector();
			}
		}
	})
}
function CicloPlantillas2(id){
 var parametros ="funcion=2&id="+id;
 alert(parametros);
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
		//alert(data);
			if(data==0){
				alert("Error en Cierre Evaluado");
			}else{
				$('#proceso_cierre1').html(data);
			}
		} 
	})
}
function ddirector(){
 var parametros ="funcion=2";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				dUTP();
			}
		}
	})
}

function dUTP(){
 var parametros ="funcion=3";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				dinspector();
			}
		}
	})
}

function dinspector(){
 var parametros ="funcion=4";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				ddocente();
			}
		}
	})
}

function ddocente(){
 var parametros ="funcion=5";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				dorientador();
			}
		}
	})
}

function dorientador(){
 var parametros ="funcion=6";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				dcapellan();
			}
		}
	})
}

function dcapellan(){
 var parametros ="funcion=7";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				dprofesor();
			}
		}
	})
}

function dprofesor(){
 var parametros ="funcion=8";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
			//	dUTP();
			}
		}
	})
}

function cargarfunsion(id){ 
// funsion cierra funsiones de director
	 var parametros ="funcion=2&id="+id;
	 alert(parametros);
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra2019.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				//fdirector();
			}
		}
	})
}

function fdirector(){ 
// funsion cierra funsiones de director
	 var parametros ="funcion=2";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				futp();
			}
		}
	})
}

function futp(){ 
// funsion cierra funsiones de Jefe UTP
	 var parametros ="funcion=3";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				finspector();
			}
		}
	})
}

function finspector(){ 
// funsion cierra funsiones de Inspector
	 var parametros ="funcion=4";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				fcapellan();
			}
		}
	})
}

function fcapellan(){ 
// funsion cierra funsiones de Capellan
	 var parametros ="funcion=5";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				forientador();
			}
		}
	})
}

function forientador(){ 
// funsion cierra funsiones de Orientador
	 var parametros ="funcion=6";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				fdocente();
			}
		}
	})
}

function fdocente(){ 
// funsion cierra funsiones de Docente
	 var parametros ="funcion=7";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
				fprofesor();
			}
		}
	})
}

function fprofesor(){ 
// funsion cierra funsiones de Profesor Jefe
	 var parametros ="funcion=3";
 	$.ajax({
		url:'mod/cierre_colegio/cont_cierra_funsion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error en Cierre Conceptos");
			}else{
				$('#proceso_cierre1').html(data);
			
			}
		}
	})
}

</script>
<style>
#bloques{ margin:10px; margin-top:40px; margin-left:10%; text-align:left; width:80%; }
</style>
</head>

<body>
<div id="bloques" align="center"  >

<fieldset>
<legend>PROCESO CIERRE DE COLEGIO</legend>
<div id="nombre_bloque">
<table width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr>
    <td width="18%" class="textonegrita">A&ntilde;o Academico</td>
    <td width="82%" class="textosimple"><?=date("Y");?></td>
  </tr>
  <tr>
    <td class="textonegrita">Periodo </td>
    <td class="textosimple">Segundo Ciclo</td>
  </tr>
  <tr>
    <td class="textonegrita">Fecha</td>
    <td class="textosimple">&nbsp;<?=date("d-m-Y");?></td>
  </tr>
</table>	

<div id="bottoncontrol" >
<br>
<input name="creardoc" type="button" onClick="cargardatos()" value="CERRAR PROCESO" class="botonXX"/>
<input name="creardoc" type="button" onClick="cargardimension()" value="CERRAR DIMENSION" class="botonXX"/>
<input name="cierra_funsion" type="button" id="cierra_funsion" value="CERRAR FUNCION"  onclick="cargarfunsion(0)" class="botonXX"/>
</div>

</div>
<br />

<div id="proceso_cierre1">&nbsp;</div>
</fieldset>
</div>
</body>
</html>

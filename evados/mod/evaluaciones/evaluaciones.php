<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../admin/clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js">
<title>Documento sin título</title>
<script language="javascript" type="text/javascript">
$(document).ready(function(){ // Script para cargar al inicio del modulo
cargartabla();
});


function cargartabla(){

	var rdb=<?=$_INSTIT;?>;
	var cargo =$("#cmbCARGO").val();
	var ano = <?=$_ANO;?>;
	var periodo = <?=$_PERIODO;?>;
	var parametros="funcion=1&rdb="+rdb+"&id_cargo="+cargo+"&ano="+ano+"&periodo="+periodo;

	$.ajax({
		url:'mod/evaluaciones/cont_evaluaciones.php',
		data:parametros,
		type:'POST',
		success:function(data){
			
			if(data==0){
				alert("ERROR DE SISTEMA");
			}else{
				$('#buscador').html(data);
			}	
		}
	})
	
}

function Listado(){
	var ano=<?=$_ANO;?>;
	var periodo=<?=$_PERIODO;?>;
	var empleado=$("#cmbEMPLEADO").val();
	
	var parametros = "funcion=2&ano="+ano+"&periodo="+periodo+"&rut="+empleado;
	$.ajax({
		url:'mod/evaluaciones/cont_evaluaciones.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");
			}else{
				$('#tabla').html(data);
			}	
		}
	})
	
}

function elimina(rut_evaluado){
	var ano=<?=$_ANO;?>;
	var periodo=<?=$_PERIODO;?>;
	var empleado=$("#cmbEMPLEADO").val();
	
	var parametros = "funcion=3&ano="+ano+"&periodo="+periodo+"&rut="+empleado+"&rut_evaluado="+rut_evaluado;
	
	$.ajax({
		url:'mod/evaluaciones/cont_evaluaciones.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");
			}else{
				Listado();
				//$('#tabla').html(data);
			}	
		}
	})	
}
</script>
</head>

<body>


<div id="buscador">&nbsp;</div><br />
<br />

<div id="tabla">&nbsp;</div>
</body>
</html>

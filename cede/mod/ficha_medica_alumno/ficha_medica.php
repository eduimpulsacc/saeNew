<?
 session_start();
$_INSTIT;
$ano_cede=$_ANO_CEDE;
$rut_alumno=$_RUT_ALUMNO;
if(!isset($rut_alumno)){
	echo"<script type=\"text/javascript\">alert(\"Debe Seleccionar un Alumno en Ficha Alumno\");</script>"; 
	return false;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>

	 $(document).ready(function() {
		
		 CargaDatosAlumno(<?=$ano_cede;?>,<?=$rut_alumno?>)
		
		 $( "input:submit,input:button", "#mapaConcept" ).button();
 
});

	
	function CargaDatosAlumno(id_ano){
	var funcion = 1;	
	var rut_alumno="<?=$rut_alumno;?>"
	
	var parametros = "funcion="+funcion+"&id_ano="+id_ano+"&rut_alumno="+rut_alumno;  
	//alert(parametros);
		$.ajax({
			url:'mod/ficha_medica_alumno/cont_ficha_medica_alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			 $('#carga_datos_fichaMedAlum').html(data);
		    }
	     }
      })
	}
	
	
	
	
	
	
</script>


<style type="text/css">
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
#select{ margin-left:20%;} 
</style> 


</head>
<body>



<br />
<legend>&nbsp;&nbsp;<strong><?="Ficha M&eacute;dica Alumno";?></strong></legend>
<br />

<div id="nombre_bloque">
<br />
<div id="carga_datos_fichaMedAlum">
<legend>&nbsp;&nbsp;<strong><?="Ficha  M&eacute;dica Alumno";?></strong></legend>
</div>
 
</div>
<div id="carga_datos_fichaMedAlum"></div>
<br>


</body>
</html>

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
			url:'mod/ficha_academica_alumno/cont_ficha_academica_alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			 $('#carga_datos_fichaAcadAlum').html(data);
		    }
	     }
      })
	}
	
	
	function cargaSubsector(x){
		
    var nombres = x.split(",");
  
	var id_ramo=nombres[0];
	var id_conf=nombres[1];
		
		var funcion = 2;
		var parametros = "funcion="+funcion+"&id_ramo="+id_ramo;  
	//alert(parametros);
		$.ajax({
			url:'mod/ficha_academica_alumno/cont_ficha_academica_alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			 $('#nombre_subsector').html(data);
			 cargaTablaDatos();
			 
		    }
	     }
      })
	}
	
	function cargaTablaDatos(){
		
	var valores = $('#cmbCONF').val();	
	
		
	var nombresDatos = valores.split(",");
	var id_ramo=nombresDatos[0];
	var id_conf=nombresDatos[1];
	var id_periodo=nombresDatos[2];
	var nota_inicial=nombresDatos[3];
	var nota_final=nombresDatos[4];
	var nro_ano= $('#nro_ano').val();
	
	/*alert(valores);
	alert(nota_final);*/
	var rut_alumno="<?=$rut_alumno?>"
		
		var funcion = 4;
var parametros = "funcion="+funcion+"&id_conf="+id_conf+"&id_periodo="+id_periodo+"&id_ramo="+id_ramo+"&rut_alumno="+rut_alumno+"&nota_inicial="+nota_inicial+"&nota_final="+nota_final+"&nro_ano="+nro_ano;  
	//alert(parametros);
	
		$.ajax({
			url:'mod/ficha_academica_alumno/cont_ficha_academica_alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			 $('#carga_tabla_Ficha_alumno').html(data);
			 MapaConceptual()
			 
		    }
	     }
      })
	}
	
	function MapaConceptual(){
		
	var valores = $('#cmbCONF').val();	
	var nombresDatos = valores.split(",");
	var id_nivel=nombresDatos[5];
	
	var cod_subsector=$('#cod_subsector').val();
	var id_curso=$('#id_curso').val();
	
	var id_ano="<?=$ano_cede;?>";
	var funcion = 5;
	var parametros = "funcion="+funcion+"&id_curso="+id_curso+"&cod_subsector="+cod_subsector+"&id_ano="+id_ano+"&id_nivel="+id_nivel;  
	//alert(parametros);
	
		$.ajax({
			url:'mod/ficha_academica_alumno/cont_ficha_academica_alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
		//	alert(data);
			if(data==0){
			//alert("No se Encontraron Datos");
			}else{
			 $('#carga_tabla_mapa_conceptual').html(data);
			// MapaConceptual()
			 
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


<div id="mapaConcept"> 
<br />
<legend>&nbsp;&nbsp;<strong><?="Ficha Academica Alumno";?></strong></legend>
<br />

<div id="nombre_bloque">
<br />
<div id="carga_datos_fichaAcadAlum">
<legend>&nbsp;&nbsp;<strong><?="Ficha Academica Alumno";?></strong></legend>
</div>

<div id="guardar" >
<legend>&nbsp;&nbsp;<strong><?="-";?></strong></legend>
<!--<input type="button" name="guardar" id="guardar" value="Guardar">-->
</div>  
</div>
<div id="carga_tabla_Ficha_alumno"></div>
<br>
<div id="carga_tabla_mapa_conceptual"></div>
</div>

</body>
</html>

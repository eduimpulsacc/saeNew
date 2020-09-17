<?

 session_start();
//print_r($_POST);

//echo $_INSTIT;
//echo "A&ntilde;o Actual = ".$_ANO_CEDE;


//echo "A&ntilde;o Actual =". $nro_ano;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>

	 $(document).ready(function() {
		// alert($('#id_ano1').val());
	//	 $( "input:submit,input:button", "#cuerpo_area_cognitiva" ).button();
 // $('#frm').submit();
  CargaAnosAcademicos();
});

	function CargaAnosAcademicos(){
	
	var funcion = 1;	
	var id_instit="<?=$_INSTIT?>";	
	var parametros = "id_instit="+id_instit+"&funcion="+funcion;  
	
	//alert(parametros);
		$.ajax({
			url:'mod/setea_ano/cont_setea_ano.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			 $('#carga_ano_academico').html(data);
		    }
	     }
      })
		}
		
		function CambiaAno(id_ano,nro_ano){
		
		var funcion= 2;
		
		var parametros = "id_ano="+id_ano+"&funcion="+funcion+"&nro_ano="+nro_ano; 
		//alert(parametros);
		if(!confirm("Desea Cambiar el A\u00F1o Actual por "+nro_ano)){ 
		return false;
		}else{
		$.ajax({
			url:'mod/setea_ano/cont_setea_ano.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				actualiza();
				
				alert("A\u00F1o Actual "+nro_ano);
				
			 $('#carga_ano_actual').html(data);
			 $("#capa"+nro_ano+"").addClass("tdfuera");
			 $("#Membrete").load(location.href+" #Membrete>*","");
		    }
			}
	     })
       }
	  }
	
			
			
	 function actualiza(){
    $("#Sub_Contenedor").load("mod/setea_ano/setea_ano.php");
	$("#Sub_Contenedor").load("mod/index.php");
	//setInterval( "actualiza()", 1000 );
  }
  
	
</script>


<style type="text/css">
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }

.tdfuera{ 
border:solid #000000 1pt; 
background-color: #F06C0D; 
color:#FFFFFF; 
font-weight: bold; 
font-family:Verdana,Arial,Helvetica; 
font-size: 10pt; 
cursor:pointer; 
} 

</style> 
</head>

<body>
<div id="carga_ano_actual"></div>
<div id="cuerpo_ano_academico" >
  <fieldset>
<legend><strong><?=htmlentities("Año Academico",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="carga_ano_academico" >
<br>
</div>
</fieldset>

</div>
</body>
</html>

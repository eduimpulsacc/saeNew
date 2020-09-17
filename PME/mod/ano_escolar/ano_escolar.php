<?php
session_start();

     $ano=$_ANO_;
	$rdb = $_INSTIT;
require "../../class/Membrete.class.php";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A&ntilde;o Escolar</title>
<script type="text/javascript">

$(document).ready(function() {
	
	 $("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'mm/dd/yy'
	  });
		$.datepicker.regional['es']	
		
       ano_escolares();
});

function cambiar(id,color){
	//alert(id);
	//alert(color);
      document.getElementById(id).style.backgroundColor=color;
   }


function ano_escolares()
{
	var rdb= "<?=$_INSTIT?>";
	var funcion=1;
	var parametros ='funcion='+funcion+'&rdb='+rdb;	
	//alert(parametros);
	$.ajax({
		url:'mod/ano_escolar/cont_ano_escolar.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				if(data!=0){
					$('#tabla_anos').html(data);
					$('#tabla_ano_actual').hide();
				    $('#tabla_anos').show();
					
				}else{
					alert("Sin Datos");
					}
		}
   })
}

function CambiaAno(nro_ano){
		
		var funcion= 2;
		
		var parametros = "nro_ano="+nro_ano+"&funcion="+funcion; 
		//alert(parametros);
		
		$.ajax({
			url:'mod/ano_escolar/cont_ano_escolar.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				//$("#contenedor").load("mod/index.php");
				actualiza();
				carga_ano_actual(data);
				//location.reload();
				//alert("A\u00F1o Actual "+nro_ano);
			// $('#carga_ano_actual').html(data);
			// $("#capa"+nro_ano+"").addClass("tdfuera");
			$("#cabecera-derecha").load(location.href+" #cabecera-derecha>*","");
		    }
			}
	    }) 
  }	
 function actualiza(){
  $("#contenedor").load("mod/index.php");
  
  }	
  
  
  function carga_ano_actual(nro_ano)
  {
	var rdb= "<?=$_INSTIT?>";
	 var funcion = 3;
	 
	 var parametros = "nro_ano="+nro_ano+"&rdb="+rdb+"&funcion="+funcion;	  
	 
	 $.ajax({
			url:'mod/ano_escolar/cont_ano_escolar.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				$('#tabla_ano_actual').html(data);
				$('#tabla_ano_actual').show();
				$('#tabla_anos').hide();
				
		    }
			}
	    }) 
  }
  
  function volver()
  {
		  $('#tabla_ano_actual').hide();
		  $('#tabla_anos').show();
		  ano_escolares()
  }
</script>
</head>

<body>
<div id="cuerpo_ano">
<div id="tabla_anos"></div>
<div id="tabla_ano_actual"></div>



</div>
</body>
</html>

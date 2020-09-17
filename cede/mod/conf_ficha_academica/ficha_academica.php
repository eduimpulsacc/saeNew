<?

 session_start();
$_INSTIT;
$ano_cede=$_ANO_CEDE;


//echo "A&ntilde;o Actual =". $nro_ano;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>

	 $(document).ready(function() {
		 cargaTabla();
		 cargarselect(<?=$ano_cede;?>,1);
		 CargaAnoAcademico(<?=$ano_cede;?>)
		
		 $( "input:submit,input:button", "#mapaConcept" ).button();
 // $('#frm').submit();
  //CargaAnosAcademicos();
});

	
	  function cargarselect(param,fun){
		
		  if(fun==1){
	       var parametros = "funcion="+fun+"&id_ramo="+param;
		   var selec = "SelectNivel";
		  }	
		  
		  if(fun==2){
	       var parametros = "funcion="+fun+"&id_nivel="+param;
		   var selec = "SelectCurso";
		   
		  }
		  
		  if(fun==3){
		   var ano="<?=$ano_cede;?>";
	       var parametros = "funcion="+fun+"&ano="+ano;
		   var selec = "SelectPeriodo";
		  }
		$.ajax({
		  url:'mod/conf_ficha_academica/cont_ficha_academica.php',
		  
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos en el Curso");
				 // $('#cmb_funcion').html(0);
				   $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
				//limpiatext();
				  }
		        }
		     })
	       } // fin funcion
		   
		 function CargaAnoAcademico(ano_academ){
	
	var funcion = 4;	
	var parametros = "ano_academ="+ano_academ+"&funcion="+funcion;  
	//alert(parametros);
		$.ajax({
			url:'mod/conf_ficha_academica/cont_ficha_academica.php',
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
			   

			   
			   
 function ValidarCombo(){
		
	if ($('#chk_promedio').is(':checked')){
	var chk_promedio=1;
	} else {
	var chk_promedio=0;
	}	
	if(chk_promedio==1){
		$('#cmb_nota_inicial').attr('disabled', true);
		$('#cmb_nota_final').attr('disabled', true);
		 $("#cmb_nota_inicial option[value=0]").attr("selected",true); 
		  $("#cmb_nota_final option[value=0]").attr("selected",true); 
	}else{
		$('#cmb_nota_inicial').attr('disabled', false);
		$('#cmb_nota_final').attr('disabled', false);
		
	
	}
}			   

function enviar(){

   if( $("#cmb_nivel").val()==0){
      alert("Seleccionar nivel");
      return false;
    }
	 if( $("#selectRamo").val()==0){
      alert("Escriba Ramo");
      return false;
    }
	 if( $("#selectPeriodo").val()==0){
      alert("Seleccionar periodo");
      return false;
    }
	 if( $("#txt_nom_conf").val()==""){
      alert("Escriba un Nombre Para la Configuracion");
      return false;
    }
	
	
	
	if ($('#chk_promedio').is(':checked')){
	var chk_promedio=1;
	} else {
	var chk_promedio=0;
	}	
	
	var funcion =6;
	var nota_inicial=$('#cmb_nota_inicial').val();
	var nota_final=$('#cmb_nota_final').val();
	var rdb = "<?=$_INSTIT;?>";
	var ano = "<?=$ano_cede?>"
	
	var parametros = "funcion="+funcion+"&rdb="+rdb+"&ano="+ano+"&id_periodo="+$("#selectPeriodo").val()+"&nota_inicial="+nota_inicial+"&nota_final="+nota_final+"&chk_promedio="+chk_promedio+"&id_nivel="+$("#cmb_nivel").val()+"&id_ramo="+$("#selectRamo").val()+"&nombre_conf="+$("#txt_nom_conf").val();
	
   $.ajax({
			url:'mod/conf_ficha_academica/cont_ficha_academica.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				alert("Datos Guardados");
			 cargaTabla(<?=$_INSTIT;?>);
		    }
	     }
      })
 } 
 
 
 function validarmayor(x){
	 
	
	 
   var notaMayor = parseInt(x); 
   var notaManor= parseInt($('#cmb_nota_inicial').val());
	 
	 if (notaManor >= notaMayor){
	 alert("La nota Final debe ser Mayor a la Inicial");
	 $("#cmb_nota_final option[value=0]").attr("selected",true); 
	 return false;
	 }else{
		 return true;
		 }
}
 
 function cargaTabla(){
	 
	 var funcion = 5;	
	 var rdb = "<?=$_INSTIT;?>";
	var parametros = "funcion="+funcion+"&rdb="+rdb;
	 
	 
	 
	  $.ajax({
			url:'mod/conf_ficha_academica/cont_ficha_academica.php',
			data:parametros,
			type:'POST',
			success:function(data){
		//	alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				
			$('#carga_tabla_Ficha').html(data);
			$("input:submit,input:button", "#mapaConcept" ).button();
		    }
	     }
      })
	 
	 }
	 
	function BuscaFichaCad(id_conf){
				
	var parametros = "funcion=7&id_conf="+id_conf;
	
	
	 $.ajax({
		   url:'mod/conf_ficha_academica/cont_ficha_academica.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data!=0){
                   //alert("Datos Encontrados");
				    $('#muestradatos').html(data);
					
						var id_nivel=$('#_id_nivel').val();
				 		var _id_periodo = $('#_id_periodo').val();
						var _cod_subsector = $('#_cod_subsector').val();
						var _nota_inicial=$('#_nota_inicial').val();
						var _nota_final=$('#_nota_final').val();
						var promedio=$('#_promedio').val();
						var _id_conf=$('#_id_conf').val();
						var ano = "<?=$ano_cede;?>"
						
						$("#selectRamo option[value="+_cod_subsector+"]").attr("selected",true);
						$("#cmb_nivel option[value="+id_nivel+"]").attr("selected",true);
						$("#selectPeriodo option[value="+_id_periodo+"]").attr("selected",true);
						$('#txt_nom_conf').val($('#_nombre_conf').val());
						$("#cmb_nota_inicial option[value="+_nota_inicial+"]").attr("selected",true);
						$("#cmb_nota_final option[value="+_nota_final+"]").attr("selected",true);
						
						if(promedio==1){
							$("#chk_promedio").attr("checked","checked");
							}
							
						$('#cmb_nivel').focus();
						
$('#textboton').html('<br><input name="Modificar" type="button" onClick="modificaFichaAcad('+_id_conf+')" value="Modificar" />');
				  $("input:submit,input:button", "#textboton" ).button();
				  cargarselect(id_nivel,2);
				  cargarselect(ano,3);
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
		}
			   
	function modificaFichaAcad(_id_conf){
			
	if( $("#cmb_nivel").val()==0){
      alert("Seleccionar nivel");
      return false;
    }
	 if( $("#selectRamo").val()==0){
      alert("Seleccione Ramo");
      return false;
    }
	 if( $("#selectPeriodo").val()==0){
      alert("Seleccionar periodo");
      return false;
    }
	if( $("#txt_nom_conf").val()==0){
      alert("Escriba un Nombre para la Configuracion");
      return false;
    }
	
	
	if ($('#chk_promedio').is(':checked')){
	var chk_promedio=1;
	} else {
	var chk_promedio=0;
	}	
	
	var funcion =8;
	var nota_inicial=$('#cmb_nota_inicial').val();
	var nota_final=$('#cmb_nota_final').val();
	
	
	var parametros = "funcion="+funcion+"&_id_conf="+_id_conf+"&id_periodo="+$("#selectPeriodo").val()+"&nota_inicial="+nota_inicial+"&nota_final="+nota_final+"&chk_promedio="+chk_promedio+"&id_nivel="+$("#cmb_nivel").val()+"&id_ramo="+$("#selectRamo").val()+"&nombre_conf="+$("#txt_nom_conf").val();
	
  // alert(parametros);
   
   
   $.ajax({
			url:'mod/conf_ficha_academica/cont_ficha_academica.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				alert("Datos Guardados");
			cargaTabla(<?=$_INSTIT;?>);
		    }
	     }
      })
	}	   
			   
			  
		function EliminarFichaAcad(_id_conf){
	
    var parametros = "funcion=9&_id_conf="+_id_conf;

	//alert(parametros);
	if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
	 $.ajax({
		   url:'mod/conf_ficha_academica/cont_ficha_academica.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                 alert("Datos Eliminados");
				 cargaTabla(<?=$_INSTIT;?>);
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
	   }
	}
	
</script>


<style type="text/css">
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
#select{ margin-left:20%;} 

</style> 


</head>

<body>
<div id="mapaConcept"> 
<fieldset>
<legend><strong><?="Ficha Academica";?></strong></legend>
<div id="nombre_bloque">
<div id="carga_ano_academico">
<label><?=htmlentities("Año Academico:",ENT_QUOTES,'UTF-8')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</label>
</div>
<br>
<div id="SelectNivel">
<label>Seleccionar Nivel:&nbsp;&nbsp;&nbsp;&nbsp;
 <select name="cmb_nivel" id="cmb_nivel">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<div id="SelectCurso">
<label>Seleccionar Asignatura:&nbsp;
  <select name="cmb_subsector" id="cmb_subsector" style=" margin-left:16px;">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<div id="SelectPeriodo">
<label>Seleccionar Periodo:
<select name="cmb_periodo" id="cmb_periodo" style=" margin-left:36px;">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div><br>

<div id="Nombre_Configuracion">
<label>Nombre Confiuraci&oacute;n:
<input type="text" name="txt_nom_conf" id="txt_nom_conf" style=" margin-left:31px;" />
</label>
</div><br>

<div id="SelectNotaInicial">
<label>Seleccionar Nota Inicial:
<select name="cmb_nota_inicial" id="cmb_nota_inicial" style=" margin-left:18px;">
<option value=0 selected="selected" >Selecccionar</option>
<?php
for ($i = 1; $i < 19; ++$i) { ?>
  <option value="<?=$i; ?>"><?="Nota  ".$i; ?></option>
<?php }
?>
</select>
</label>
</div><br>

<div id="SelectNotaInicial">
<label>Seleccionar Nota Final:
<select name="cmb_nota_final" id="cmb_nota_final" onchange="validarmayor(this.value)" style=" margin-left:26px;">
<option value=0 selected="selected" >Selecccionar</option>
<?php
for ($j = 1; $j < 19; ++$j) { ?>
  <option value="<?=$j; ?>"><?="Nota  ".$j; ?></option>
<?php }
?>
</select>
</label>
</div><br>

<div id="chek">
<label><?=htmlentities("Promedio:",ENT_QUOTES,'UTF-8')?>   </label>
<input type="checkbox" name="chk_promedio" id="chk_promedio" value="1" onClick="ValidarCombo(this);" /><br />
</div>

<br><br>  
<div id="textboton">
<input type="button" name="btn_guardar" id="btn_guardar"  value="Guardar" onclick="enviar()"/>

</div>
</div>
</fieldset>
<div id="carga_tabla_Ficha"></div>
<div id="muestradatos"></div>
</div>
</body>
</html>

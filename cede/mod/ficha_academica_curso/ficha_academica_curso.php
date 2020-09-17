<?
 session_start();
$_INSTIT;
$ano_cede=$_ANO_CEDE;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>

	 $(document).ready(function() {
		cargarselect(<?=$ano_cede;?>,1);
		 CargaAnoAcademico(<?=$ano_cede;?>)
		
		 $( "input:submit,input:button", "#mapaConcept" ).button();
 
});

	
	  function cargarselect(param,fun){
		
		  if(fun==1){
	       var parametros = "funcion="+fun+"&id_ano="+param;
		   var selec = "SelectConfiguracion";
		   //alert(parametros);
		  }	
		  if(fun==2){
			  
		 var variables = param.split(",");
		 var id_nivel=variables[0];  
			
		   var ano="<?=$ano_cede;?>";
	       var parametros = "funcion="+fun+"&id_nivel="+id_nivel+"&ano="+ano;
		   var selec = "SelectCurso";
		  // alert(parametros);
		  }
		  if(fun==3){
		   var ano="<?=$ano_cede;?>";
	       var parametros = "funcion="+fun+"&id_curso="+param+"&ano="+ano;
		   var selec = "SelectRamo";
		   //alert(parametros);
		  }
		$.ajax({
		  url:'mod/ficha_academica_curso/cont_ficha_academica_curso.php',
		  
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
			url:'mod/ficha_academica_curso/cont_ficha_academica_curso.php',
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
			   
 function enviar(e){
	
	var notaExt=$("#notaex"+e+"").val();
	if(notaExt.length ==2 || notaExt.length ==0){
	var promedio=$("#promedio"+e+"").val();
	
	var nota01=parseInt($("#promedio"+e+"").val()); 
	var nota02=parseInt($("#notaex"+e+"").val());
	
	
	if(isNaN($("#notaex"+e+"").val())){
		alert("Ingrese solo Numeros");
		$("#notaex"+e+"").val("");
	}
	
	if(nota02 > 70){
		alert("La Nota No Puede ser Mayor a 70");
		$("#notaex"+e+"").val("");
		$("#promediotot"+e+"").val("");
		return false;
		}
	if(nota02 <= -1){
		alert("La Nota No Puede ser Negativa");
		$("#notaex"+e+"").val("");
		$("#promediotot"+e+"").val("");
		return false;
		}	
		
	var suma=(nota01+nota02);
	var promedio=Math.round(suma/2);
	$("#promediotot"+e+"").val(promedio);  
	
	if(isNaN($("#promediotot"+e+"").val(promedio))){
		var nivel = NivelLogro(promedio,e);

	//$("#nivel_logroExt"+e+"").val(nivel);
	}
	
	
	/*var prome =$("#promediotot"+e+"").val(); 
	*/
	
/*	if($("#promediotot"+e+"").val()>=$('#notaminima1').val() && $("#promediotot"+e+"").val()<=$('#notamaxima1').val())
		{
		var nivel="Inicial";
		
	}else if($("#promediotot"+e+"").val()>=$('#notaminima2').val() && $("#promediotot"+e+"").val()<=$('#notamaxima2').val())
		{
		var nivel="Intermedio";
		$("#nivel_logroExt"+e+"").val(nivel);
	}else if($("#promediotot"+e+"").val()>=$('#notaminima3').val() && $("#promediotot"+e+"").val()<=$('#notamaxima3').val())
	{
	    var nivel="Avanzado";
		$("#nivel_logroExt"+e+"").val(nivel);
		
		}*/
		$("#observacion"+e+"").removeAttr('disabled');
		var numdiferencia=parseInt($("#promediotot"+e+"").val() - nota01 );
		$("#diferencia"+e+"").val(numdiferencia);
		if(isNaN($("#promediotot"+e+"").val())){
		$("#promediotot"+e+"").val("");
		$("#nivel_logroExt"+e+"").val("");
		$("#diferencia"+e+"").val("");
		$("#observacion"+e+"").attr('disabled','disabled');
		
	 }
	}
 } 
 
 function cargaTabla(x){
	  
  var nombres = x.split(",");
  
	var id_ramo=nombres[0];
	var nota_inicial=nombres[1];
	var nota_final=nombres[2];
	var id_periodo=nombres[3];
	var promedio = nombres[4];
	var nro_ano=$('#nro_ano').val();
	
	//alert("promedio="+promedio);
	var funcion = 5;	
	var rdb = "<?=$_INSTIT;?>";
	var parametros = "funcion="+funcion+"&rdb="+rdb+"&id_ramo="+id_ramo+"&nota_inicial="+nota_inicial+"&nota_final="+nota_final+"&id_periodo="+id_periodo+"&nro_ano="+nro_ano+"&promedio="+promedio;
	
	//alert(parametros);
	 
	  $.ajax({
			url:'mod/ficha_academica_curso/cont_ficha_academica_curso.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			$('#carga_tabla_Ficha_curso').html(data);
			$("input:submit,input:button", "#mapaConcept" ).button();
		    }
	     }
      })
	 }
	 
	 
	 
  function guardarficha(e){
	 
	  var id_ano="<?=$ano_cede;?>";
   var id_curso=$('#selectCurso').val();
   var valores = $('#selectRamo').val();
   
    var nombresDatos = valores.split(",");
	var id_ramo=nombresDatos[0];
	var id_periodo=nombresDatos[3];
	
	var sacaidconf=$('#cmb_conf').val();
	var separaidconf=sacaidconf.split(",");
	var id_conf = separaidconf[1];
	
 var i;
 var parametros2='';
   var funcion=7;
   var x=0;
   for(i=0;i<e;i++){
   var rut =$("#rut_alu"+i+"").val()
   var parametros="parametros"+i;
    var funcion="funcion"+i;
	
	
	/*if($("#nivel_logroExt"+i+"").val()=="Inicial")
		{
		var id_nivel=1;
		}else if($("#nivel_logroExt"+i+"").val()=="Intermedio")
		{
		var id_nivel=2;
		
		}else if($("#nivel_logroExt"+i+"").val()=="Avanzado")
		{
		var id_nivel=3;
		
	}*/
//	alert($("#idnivelext"+i+"").val());
	var id_nivel =$("#idnivelext"+i+"").val();
	//alert(id_nivel);
		
   		var parametros = "funcion="+funcion+'/'+"cantidad="+e+'/'+$("#rut_alu"+i+"").val()+'/'+$("#promedio"+i+"").val()+'/'+$("#notaex"+i+"").val()+'/'+$("#promediotot"+i+"").val()+'/'+id_nivel+'/'+$("#diferencia"+i+"").val()+'/'+$("#observacion"+i+"").val()+'/'+id_ramo+'/'+id_periodo+'/'+id_curso+'/'+id_ano+'/'+id_conf+'/'+$("#id_nivel"+i+"").val()+'*';
   
	 parametros2= parametros2+parametros;
    }
	
   $.ajax({
			url:'mod/ficha_academica_curso/Proceso_Guardar.php',
			data:parametros2,
			type:'POST',
			success:function(data){
			//alert(data)
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			alert("Datos Guardados");
		    }
	     }
      })
  } 
 

	function NivelLogro(x,e){
		var parametro="funcion=6&promedio="+x;

		 $.ajax({
			url:'mod/ficha_academica_curso/cont_ficha_academica_curso.php',
			data:parametro,
			type:'POST',
			success:function(data){
			if(data==0){
			
			}else{
				var valor =data.split(',');
				$("#nivel_logroExt"+e+"").val(valor[1]);
				$("#idnivelext"+e+"").val(valor[0]);
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

<legend><strong><?="Ficha Academica Curso";?></strong></legend>
<br><br>


<form  id="frm" name="frm" method="post" action="mod/ficha_academica_curso/Proceso_Guardar.php" target="iframeUpload">
<div id="nombre_bloque">

<div id="carga_ano_academico">
<label><?=htmlentities("Año Academico:",ENT_QUOTES,'UTF-8')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</label>
</div>

<div id="SelectConfiguracion">
<label>Seleccionar Configuracion:
<select name="cmb_periodo" id="cmb_periodo" style=" margin-left:22px;">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>

<div id="SelectCurso">
<label>Seleccionar Curso:&nbsp;&nbsp;&nbsp;&nbsp;
 <select name="cmb_curso" id="cmb_curso" style=" margin-left:54px;">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>


<div id="SelectRamo" >
<label>Seleccionar Asignatura:&nbsp;
 <select name="cmb_ramo" id="cmb_ramo" style=" margin-left:37px;" >
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<br>  
</div>
<div id="carga_tabla_Ficha_curso"></div>
<iframe name="iframeUpload" id="iframeUpload" width="100%" height="50%" align="bottom"  marginwidth="10%" scrolling="no" class="autoHeight" frameborder="0" >
</iframe>

</form>
</div>

</body>
</html>

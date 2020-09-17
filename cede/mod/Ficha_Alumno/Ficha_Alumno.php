<?

	session_start();
	
   "rut-->".$rut_alumno=$_RUT_ALUMNO;
   
    $id_ano=$_ANO_CEDE;
    $id_curso=$_ID_CURSO;
	$institucion = $_INSTIT;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Ficha Alumno</title>


<script>

$(function() {
		
	$( "#ficha_alumno" ).tabs();
	
   $( "#ficha_alumno_matriculas" ).tabs();
   //$( "#ficha_alumno_matriculas" ).tabs();
  $( "#accordion" ).accordion({
		    //active: false, 
			autoHeight: false,
			navigation: true,
		});
	
	
  $( "input:submit,input:button,a,button", "#buscardor_alumno" ).button();
		
  
  carga_anios(1);
   
});
	
	
	function carga_anios(){
	
		 var parametros = "funcion=1";
		//alert(parametros);
		
		$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
				success:function(data){
					//alert(data);
					if(data==0){
						alert("Error al Cargar Select");
					}else{ 
						$('#label_anos').html(data);
						
							
							
					  }
				  }
			})
	}
	
	
	function carga_curso(id_ano){
		
	var parametros = "funcion=2&an_escolar="+id_ano; 
	
	$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
				success:function(data){
					if(data==0){
						alert("Error al Cargar Select");
					}else{ 
						$('#label_cursos').html(data);
						
						
					  }
				  }
			})
		CambiaAno(id_ano);
	}
	
	function carga_alumno(id_curso){
	
	var parametros = "funcion=3&id_ano="+$("#select_an_escolar").val()+"&id_curso="+id_curso;
	
		$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
				success:function(data){
					if(data==0){
						alert("Error al Cargar Select");
					}else{ 
						$('#label_alumno').html(data);
						
						
					  }
				  }
			})
	}

	
		
		function Buscar_Ficha_Alumno(ficha,t){
		
				rut_alum=$("#select_alumnos").val();
				ano_es=$("#select_an_escolar").val();
		if(rut_alum!=0 ){	
		var parametros = "ficha="+ficha+"&rut_alumno="+rut_alum+"&select_an_escolar="+ano_es;  
		//alert(parametros);
			$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 //alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$('#contenedor_ficha_alumno').html("");
					if(t==1){$( "#ficha_alumno" ).tabs('select',0);}
				    
					$('#contenedor_ficha_alumno').html(data);
					    
							$( "#accordion2" ).accordion({
								autoHeight: false,
								
						
							});	
					  
					  }
					 
				 }
				
			})
			
			
			 SeteaAlumno(rut_alum);
			 //carga_foto(rut_alum);
		}else{ 
		   //alert("Seleccionar Alumno"); 
		   }
		   
	    }
		
		
		
		
		function Buscar_Ficha_Alumno_Seteado(ficha,t){
			
		var rut_alumno="<?=$rut_alumno?>"
		//alert(rut_alumno);
		var ano_escolar="<?=$id_ano;?>"	
		var rut_al=$('#Rut_Alumno').val();
		if(typeof rut_al == "undefined"){
			var rut_alum=rut_alumno;
			}else{
				var rut_alum=rut_al;
				}
	 
		var ano_es=ano_escolar;
			
		if(rut_alum!=0 ){	
		var parametros = "ficha="+ficha+"&rut_alumno="+rut_alum+"&select_an_escolar="+ano_es;  
		//alert(parametros);
			$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 //alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$('#contenedor_ficha_alumno').html("");
					if(t==1){$( "#ficha_alumno" ).tabs('select',0);}
				    
					$('#contenedor_ficha_alumno').html(data);
					    
							$( "#accordion2" ).accordion({
								autoHeight: false,
								
							});	
					  }
				 }
			})
			//Buscar_Anos_Alumno();	
		}else{ 
		   //alert("Seleccionar Alumno"); 
		   }
	    }

    
   function Buscar_Anos_Alumno(){
	 	
		var rut_alumno="<?=$rut_alumno?>"
		var rut_al=$('#Rut_Alumno').val();
		if(typeof rut_al == "undefined"){
			var rut_alum=rut_alumno;
			}else{
				var rut_alum=rut_al;
				}
	  
	   if(rut_alum!=0){	
		var parametros = "funcion=5&rut_alumno="+rut_alum;
			$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				  //alert(data);
				  
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$( "#años_ficha_alumno_matriculas" ).tabs('destroy');
					
					$('#años_ficha_alumno_matriculas').html("");
					
					$('#años_ficha_alumno_matriculas').html(data);
					$( "#_matriculas" ).tabs('select',0);
					$( "#años_ficha_alumno_matriculas" ).tabs();
					$( "#_matriculas" ).tabs();
	
					  }
				 }
			}) 
		}else{ 
		   alert("Seleccionar Alumno"); 
		   }
	    }
		
		
		 function Buscar_Ficha_Alumno_Seteado_Ano(id_ano,caso,x){
	   
	//	alert(id_ano);	  
	 	//var id_anio=$('#anio').val();
	//	if(typeof id_anio == "undefined"){
		//	var id_ano=id_ano;
		//	}else{
			//	var id_ano=id_anio;
			//	}
		
		//alert(x);
		var rut_alumno="<?=$rut_alumno?>"
		var rut_al=$('#Rut_Alumno').val();
		if(typeof rut_al == "undefined"){
			var rut_alum=rut_alumno;
			}else{
				var rut_alum=rut_al;
				}
	   if(rut_alum!=0){	
		var parametros = "caso="+caso+"&rut_alumno="+rut_alum+"&id_ano="+id_ano;
		//alert(parametros);
			$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 //alert(data);
				  
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$( "#ficha_alumno_matriculas" ).tabs('destroy');
					
					$('#ficha_alumno_matriculas').html("");
					
					$('#ficha_alumno_matriculas').html(data);
					if (x==0){$( "#_matriculas" ).tabs('select',0);}
					$( "#_matriculas" ).tabs();
	
					  }
				 }
			}) 
		}else{ 
		   alert("Seleccionar Alumno"); 
		   }
	    }
		
		
	
	 function Buscar_Ficha_Alumno_Seteado_Ano_pesta(id_ano,caso,x){
	   
		//alert(id_ano);	  
	 	var id_anio=$('#anio').val();
		if(typeof id_anio == "undefined"){
			var id_ano=id_ano;
		}else{
			var id_ano=id_anio;
		}
		
		//alert(x);
		var rut_alumno="<?=$rut_alumno?>"
		var rut_al=$('#Rut_Alumno').val();
		if(typeof rut_al == "undefined"){
			var rut_alum=rut_alumno;
			}else{
				var rut_alum=rut_al;
				}
	   if(rut_alum!=0){	
		var parametros = "caso="+caso+"&rut_alumno="+rut_alum+"&id_ano="+id_ano;
		//alert(parametros);
			$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 //alert(data);
				  
					if(data==0){
						alert("No Hay Datos En Este a\u00F1o");
						$( "#_matriculas" ).tabs('select',0);
					}else{ 
					
					$( "#ficha_alumno_matriculas" ).tabs('destroy');
					
					$('#ficha_alumno_matriculas').html("");
					
					$('#ficha_alumno_matriculas').html(data);
					if (x==0){$( "#ficha_alumno_matriculas" ).tabs('select',0);}
					$( "#_matriculas" ).tabs();
				   // $( "input:submit,input:button", "#ficha_alumno_matriculas" ).button();
					  }
				 }
			}) 
		}else{ 
		   alert("Seleccionar Alumno"); 
		   }
	    }	
		
		
		
   	function SeteaAlumno(rut_alum){
		
		        
		id_cur=$("#select_curso").val();
	
		var parametros ="funcion=6&rut_alumno="+rut_alum+"&id_curso="+id_cur;
		alert("Cambio de alumno Exitoso");
			$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				  	//alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					//alert("Alumno Actual "+$("#select_alumnos").val());
					$("#Membrete").load(location.href+" #Membrete>*","");
					 $('#alumno_seteado').html(data);
					 
					
					  }
				 }
			}) 
		}
		
		
		
		
	function CambiaAno(id_ano){
		
		var funcion= 7;
		
		var parametros = "id_ano="+id_ano+"&funcion="+funcion; 
		//alert(parametros);
		
		$.ajax({
			url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
				actualiza();
				
				//alert("A\u00F1o Actual "+nro_ano);
				
			// $('#carga_ano_actual').html(data);
			// $("#capa"+nro_ano+"").addClass("tdfuera");
			 $("#Membrete").load(location.href+" #Membrete>*","");
		    }
			}
	     }) 
       
	  }	
		
		
		 function actualiza(){
   // $("#Sub_Contenedor").load("mod/setea_ano/setea_ano.php");
	$("#Sub_Contenedor").load("mod/index.php");
	//setInterval( "actualiza()", 1000 );
  }	
  
  
	function dimealgo(x,y,r){
		var j;
		var contador=$('#contador').val()
		//var j=$('#periodohidden').val()
		//alert(contador);
		//alert(x);
		//alert(y);
		//alert(r);
		//alert($('#nro_ano').val());
		
	var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$rut_alumno?>";
	var periodo = y;
	var nro_ano = $('#nro_ano').val();
	var id_ramo= r;
	var parametros = "funcion=8&rut_alumno="+rut_alumno+"&rdb="+rdb+"&periodo="+periodo+"&nro_ano="+nro_ano+"&id_ramo="+id_ramo;
	
	//alert(parametros);
    $.ajax({
	  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  
		  //alert(data);
		$("#carganotas").html(data);
			   $("#carganotas").dialog({
				  modal: true,
				  title: "Notas Parciales",
				  width: 950,
				  minWidth: 400,
				  maxWidth: 500,
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });	
		
		
		
	}
	
	
	/*function carga_foto(){
		
		var rut_alumno = $('#select_alumnos').val();
		var parametros = "funcion=9&rut_alumno="+rut_alumno;
		
		//alert(parametros)
		
		
		$.ajax({
			  url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				  	//alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					//alert("Alumno Actual "+$("#select_alumnos").val());
					
					 $('#foto').html(data);
					 
					
					  }
				 }
			}) 
		}*/
		
		
		function muestra_detalle(x,y,z){
						
			var codtipo=x;
			var codigo_anotacion=y;
			var id_anotacion=z;
			
			var funcion=10;
			
		var parametros = "codtipo="+codtipo+"&codigo_anotacion="+codigo_anotacion+"&anotacion="+id_anotacion+"&funcion="+funcion; 
		//alert(parametros);

		$.ajax({
			url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
				//alert(data);
				if(data==""){
						$("#cargadetalles").html("Sin Detalles");
					}else{
						$("#cargadetalles").html(data);
				}
				
			
			   $("#cargadetalles").dialog({
				  modal: true,
				  title: "Detalle Anotacion",
				  width: 550,
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		    }
	     })
			
			
			
			}

		function muestraAsistencia(x,y,z){
			var mes=x;
			var alumno=y;
			var ano=z;
			
			var funcion=11;
			
		var parametros = "mes="+mes+"&alumno="+alumno+"&ano="+ano+"&funcion="+funcion; 
		//alert(parametros);

		$.ajax({
			url:'mod/Ficha_Alumno/Cont_Ficha_Alumno.php',
			data:parametros,
			type:'POST',
			success:function(data){
				//alert(data);
				if(data==""){
						$("#cargaasistencia").html("Sin Detalles");
					}else{
						$("#cargaasistencia").html(data);
				}
				
			
			   $("#cargaasistencia").dialog({
				  modal: true,
				  title: "Detalle Asistencia",
				  width: 800,
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		    }
	     })	
		}

     
</script>

<style>

	
	
	#div_a {
    width: 250px;
    background-color: #A0C7F1;
    border: #A0C7F1 solid 1px;
    clear: both;
}
	
		
	.curved{
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px; /* IE 8.*/
	border-radius: 10px; /* El estándar.*/
	behavior:url(Class/border-radius.htc);
	}	

	#conenido_fichaalumno{ margin:10px; }
	
	#ficha_alumno{ margin-top:15px; margin-bottom:15px; height:auto; }
	
	#ficha_alumno_matriculas { margin-bottom:15px; }
	
	
	
	select { margin:20px; padding:3px; border-radius:5px; border-color:#79b7e7; }
	
	select option1{
	background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png);
	padding-left:25px; line-height:50px; margin-bottom:2px; }
	
	label span{ margin:20px; float:left; margin-left:40px }
    
	.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
	
	table{
	font: normal 1em/1.4em Arial, Helvetica, sans-serif;
	font-size:12px;
	margin:50px;
	padding:10px;
	border: solid	 1px #069;
	width:80%;
	
	
	}
	
	
	/*.divLeyLoc{
	position: absolute;
	top: 360px;
	width: 215px;
	height: 200px;
	padding-right: 10px;
	margin-right: 10px;
	text-align: left;
	font: bold 10px/14px sans-serif;
	color: #835B21;
	background-color: transparent;
	left: 900px;
}

	.contenedor
{postion:reative;
witch: 100%:
height:500px;}*/
	
	
</style>

</head>
<body>


<div id="conenido_fichaalumno">

<div id="buscardor_alumno">
<fieldset>
<legend>Buscador-Alumno</legend>
<!--<div class="contenedor">
<div class="divLeyLoc" id="foto"><img src="../../../infousuario/images/<?=trim($rut_alumno)?>" width="160" height="180" /></div>
</div>-->

<label id="label_anos"><span><?=htmlentities("Seleccionar Año :",ENT_QUOTES,'UTF-8')?></span>
<select name="select_anos" id="select_anos"  style="margin-left:30px">
<option value="0" selected="selected" >Seleccionar</option>
</select>
</label>
	<br/>
<label id="label_cursos"><span>Seleccionar Curso : </span>
<select name="select_cursos" id="select_cursos" style="margin-left:15px">
<option value="0" selected="selected" >Seleccionar</option>
</select>
</label>
<br/>
<label id="label_alumno"><span>Seleccionar Alumno :</span>
<select name="select_alumnos"  id="select_alumnos" style="margin-left:5px">
<option value="0" selected="selected" >Seleccionar</option>
</select>
</label>
<br/>

</fieldset>
</div>

<div id="alumno_seteado"></div>
<div id="accordion">
	<h3><a href="#">Ficha del Alumno</a></h3>
	<div>
   <div id="ficha_alumno">
   <ul>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(0,0)">Personal</a></li>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(1,0)">Familiar</a></li>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(2,0)">
   <?=htmlentities("Académico",ENT_QUOTES,'UTF-8')?></a></li>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(3,0)">Conducta</a></li>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(4,0)">Becas</a></li>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(5,0)">Grupos</a></li>
   <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(6,0)">Entrevista</a></li>
    <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado(7,0)">Ficha M&eacute;dica</a></li>
   </ul>

   <div id="contenedor_ficha_alumno"></div>
   
   
    </div>
    
 	</div>

	<h3><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Anos_Alumno()" ><?=htmlentities("Informacion por Años",ENT_QUOTES,'UTF-8')?></a></h3>
	<div >
        <!---Ficha  De Matriculas-->
        <div id="años_ficha_alumno_matriculas"></div>
         <div id="_matriculas">
        <ul>
        <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano_pesta(0,0)">Matricula</a></li>
        <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano_pesta(0,1)">Conducta</a></li>
        <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano_pesta(0,2)">Becas</a></li>
         <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano_pesta(0,3)">Notas</a></li>
         <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano_pesta(0,4)">Atrasos</a></li>
          <li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano_pesta(0,5)">Asistencia</a></li>
        </ul>
       <div id="ficha_alumno_matriculas"></div>
       
        </div>
        <div id="carganotas"></div>
        <div id="cargadetalles"></div>
        <div id="cargaasistencia"></div>
         
          
  </div>
        
        
	</div>
  </div>
   

</body>
</html>
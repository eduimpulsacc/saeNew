<? session_start();  
$_NOMBREUSUARIO;

$_USUARIO;

$_CHK_ID;
$_ANO = 1206;
$periodo = 2442;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pauta Evaluacion por Cargo</title>
<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
      
<script type="text/javascript">

//$(document).ready(function(){ // Script para cargar al inicio del modulo
//$(window).scrollTop(300);
//cargarselect(1,1);
//});
	cargardatos(1,1);
	function cargardatos(param,fun){

		if(fun==1){
		  	var rut = "<?=$_NOMBREUSUARIO;?>";
	     	var parametros = "funcion=1&rut_evaluador="+rut;
		  	var selec = "evaluadosporevaluador";
		 
		 }

		$.ajax({
		  url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
                if(data==0){
				  alert("Error de Sistema Nï¿½669");
				  return false;
				}else{
				  $('#'+selec+'').html(data);
				  if(fun==1){
					   $("#flex1").flexigrid({
						width : 770,
						height : 300
						});
					  }
				  }
		        }
		     })
	       } // fin funcion
 
 
 function cargaDatosporCargo(rut_evaluador,id_cargo,cargo_evaluado,id_bloque,n)
 {
	 	
	var cargo = '_nombre_cargo'+''+n+'';
	var nombre_cargo=$('#'+cargo+'').val()
	 
   	 var x = 0;
	 var i = $('#incrementa').val();
	 //alert(i)
	 if(i==""){i=0}
	 var numero = parseInt(x)+parseInt(i);
	 var j=numero++;
	 
	 var id_nacional = "<?=$_NACIONAL?>";
	 var periodo = "<?=$periodo?>";
	 var id_ano = "<?=$_ANO?>";
	 
		 	 
  var parametros = "funcion=2&rut_evaluador="+rut_evaluador+"&id_cargo="+id_cargo+"&cargo_evaluado="+cargo_evaluado+"&id_bloque="+id_bloque+"&id_nacional="+id_nacional+"&numero="+j+"&periodo="+periodo+"&id_ano="+id_ano+"&nombre_cargo="+nombre_cargo;	 
		//alert(parametros);
		$.ajax({
		  url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
			//	alert(data)
                if(data==0){
				if(confirm("Terminar Proceso de Evaluacion para el cargo?")){
					Terminar_proceso(rut_evaluador,id_ano,periodo);	
				  $('#cargatabla').dialog('close');
				  $('#incrementa').val("");
				  $('#nn_nagativo').val("");
				  $('#_rut_evaluado').val("");
				  
				}else{
					return false;
				}
				
				}else{
				 $('#incrementa').val(numero);
				 $('#cargatabla').html(data);
				   $('#cargatabla').dialog({ 
						autoOpen:true,
						width:650,
						height:520,//////////
						modal:true,
						buttons: {
						  'Siguiente': function(){  
						  		   var valida = guardar_evaluacion();	
								  // alert(valida);
								   if(valida!=false){
								   cargaDatosporCargo(rut_evaluador,id_cargo,cargo_evaluado,id_bloque,n);
								   }
							  },
				  'Cerrar': function(){ $(this).dialog('close');  $('#incrementa').val(""); $('#nn_nagativo').val("");}
				  }
			  })
			}
		 }
	 })	 
 }
 
function guardar_evaluacion()
{
	var cont = 0;
	array_campos = $(":radio");	
	for(i=0; i < $(array_campos).length; i++){
		//"+_nombre+"
		var valor = $(array_campos[i]).attr("value");
		var checked = $(array_campos[i]).attr("checked");
		//alert(valor);
		var separa_v = valor.split(',');
	
		if($('#cuenta_negativas').val()>=5 && checked=='checked' && separa_v[0]!=0){
			 $('#nn_nagativo').val(9);
				
			 if(checked=='checked' && separa_v[0]==9){
				 alert(separa_v[1]);
				 
				 if(separa_v[1]==$('#_rut_evaluado_').val()){
					 nombre_del_evaluado()
			         return false;
				 }
				 
				//nombre_del_evaluado()
			     //return false;
				 }else{
			     continue;
		         }
			}
			
		if($('#nn_nagativo').val()==9 && checked=='checked' && separa_v[0]==9 && separa_v[1]==$('#_rut_evaluado').val()){
					 //alert(valor)
				  nombre_del_evaluado();
			     return false;	
				 }	
		if(checked=='checked' && separa_v[0]!=0){
			
		if($("#_id_concepto").val()==separa_v[0]){ 	
		cont++;	
			}
			
	   }else if(separa_v[0]==0 && checked=='checked') {
						alert("Evaluacion Incompleta");
						return false;
						break;
	  }
	}
	
	$.ajax({
				url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
				data: $('#pautaporcargo').serialize(),
				type: 'POST',
				success: function(data){
					//alert(data);
					if(data!=1){
						alert("Recuerde que no puede tener mas del 5% de evaluaciones negativas por Evaluado")
						$('#cuenta_neg').html(data);
					}else
					if(data==1){
					//alert("Datos Guardados");
					//cargardatos(1,1);
					//$('#pautaevaluacion').dialog('close');
					}//else{
						//return false;
						//alert(data);
					  // alert("Error en el Sistema");
					//}
				}
			})
	}
 
 
 function eliminaDatosporCargo(rut_evaluador,id_cargo,cargo_evaluado,id_bloque,n)
 {
      var id_ano = "<?=$_ANO?>";
	  var id_periodo = "<?=$periodo?>";
 	 	
 	  var parametros = "funcion=3&rut_evaluador="+rut_evaluador+"&id_ano="+id_ano+"&id_periodo="+id_periodo;
	  
 	   $.ajax({
		  url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				
				cargaDatosporCargo(rut_evaluador,id_cargo,cargo_evaluado,id_bloque,n);
				
			}
	   })
 }
 
 
 function nombre_del_evaluado()
 {
	// alert($('#_rut_evaluado_').val())
	if($('#_rut_evaluado_').val()!=undefined){
	 var rut_evaluado = $('#_rut_evaluado_').val();
	}else{
	 var rut_evaluado = $('#_rut_evaluado').val();
	}
	 $('#_rut_evaluado').val(rut_evaluado)
	 
	 var parametros =  "funcion=4&rut_evaluado="+rut_evaluado;
	 
	  $.ajax({
		  url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				alert('El Usuario '+data+' a superado el 5% de Evaluaciones Negativas, recuerdelo para no incurrir en errores');
		     }
	   })
 }
 
 
function vistaprevia(rutevador,rutevado,cargo_evaluado,cargo_evaluador,bloqueevaluador){

	  var parametros = "funcion=2&rutevador="+rutevador+"&rutevado="+rutevado+"&cargo_evaluado="+cargo_evaluado+"&cargo_evaluador="+cargo_evaluador+"&bloqueevaluador="+bloqueevaluador;
	  //alert(parametros)
	  $.ajax({
		  url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				if(data==0){
					alert("Error de Sistema");
					}else{
						  $('#pautaevaluacion').html(data);
						  $('#pautaevaluacion').dialog({ 
								autoOpen:true,
								width:1200,
								height:700,
								modal:true,
								buttons: {
								  'Guardar Evaluación': function(){  
								  	       publico_evaluacion();
									  },
								  'Cerrar': function(){ $(this).dialog('close');}
								 }
						   })
						
						$(window).scrollTop(0);
						}
				}
	        })
	  }
	
	
  function Terminar_proceso(rut_evaluador,id_ano,periodo)
 {
	
	
	 var parametros = "funcion=5&rut_evaluador="+rut_evaluador+"&id_ano="+id_ano+"&periodo="+periodo;
	 alert(parametros);
	  $.ajax({
		  url:'mod/evaluacionporcargo/cont_evaluacionporcargo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				alert(data)
				if(data==1){
				alert("Proceso Finalizado Correctamente")	
				}else{
				alert("Error en el Proceso");		
				}
			}
	   })
 }	
	
	
	
	
   function fechafueraderango() {
   	
   	alert("Fecha de Validacion a Caducado Contactar Con el Administrator");
     
   }


</script>
<style>
body{ font:Verdana, Geneva, sans-serif; size:11px;}
#bloques{ margin:10px; margin-top:5px; text-align:left; width:% ; }
#evaluadosporevaluador{  margin:5px; margin-top:5px; padding:3px;  }
#vistaprevia{ font-size:10px; margin:2%;}
#descripcion{ font-size:10px; margin:2%;}
#div_portafolio{font-size:14px; margin:15px; padding:15px;}
#nombre_evaluador{ font-size:16px; margin:2%;}
</style>
</head>
<body>
<div id="bloques" >
<fieldset>
<legend>
<strong>
<?=htmlentities("Listado de Evaluados para  Evaluación",ENT_QUOTES,'UTF-8');?>
</strong>
</legend>
<div id="evaluadosporevaluador"></div>
</fieldset>
</div>

<div title="Pauta de Evaluación" id="pautaevaluacion"></div>
<div title="Portafolio de Evaluaciï¿½n" id="div_portafolio"></div>
<div id="cargatabla"></div>
<input type="hidden" id="incrementa" />
<input type="hidden" id="nn_nagativo" />
<input type="hidden" id="_rut_evaluado" />
</body>
</html>

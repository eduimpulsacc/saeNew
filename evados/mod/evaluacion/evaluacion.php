<? session_start();  

echo $_NOMBREUSUARIO;

$_USUARIO;

$_CHK_ID;

echo "<br>".$periodo = $_PERIODO;

echo "<br>".$_ANO;






?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pauta Evaluacion</title>
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
		  url:'mod/evaluacion/cont_evaluacion.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
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
 
 
function vistaprevia(rutevador,rutevado,cargo_evaluado,cargo_evaluador,bloqueevaluador){

	  var parametros = "funcion=2&rutevador="+rutevador+"&rutevado="+rutevado+"&cargo_evaluado="+cargo_evaluado+"&cargo_evaluador="+cargo_evaluador+"&bloqueevaluador="+bloqueevaluador;
	  //alert(parametros)
	  $.ajax({
		  url:'mod/evaluacion/cont_evaluacion.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				console.log(data);
				//alert(data);
				if(data==0){
					alert("Error de Sistema");
					}else{
						
						  $('#pautaevaluacion').html(data);
						  
						  $('#pautaevaluacion').dialog({ 
								autoOpen:true,
								width:1000,
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
 



function publico_evaluacion(){

	var cont = 0;
	
	array_campos = $(":radio");
	
	//alert($('#conceptos[1]').val())
	//alert($("input[name='conceptos[1]']:checked").val()); 
	//alert($("input[name='conceptos[2]']:checked").val()); 
	//alert($(array_campos).length);
	
	for(i=0; i < $(array_campos).length; i++){
		//"+_nombre+"
		var valor = $(array_campos[i]).attr("value");
		var checked = $(array_campos[i]).attr("checked");
		//alert(valor)
		//alert(checked)					  			 
					 if(checked=='checked' && valor!=0 ){
						
						if($("#id_campo_critico").val()==valor){ 
						//alert(cont)
									cont++;	
								}
								
					  }else if ( valor==0 && checked=='checked') { 
							    
						alert("Evaluacion Incompleta");
						
						return false;
						
						break;
					  }	

			if( $("#cantidad_critica").val() < cont ){
				 alert("No Puede Contestar "+$("#nombre_campo_critico").val()+" + de : "+$("#cantidad_critica").val()+" veces ");
				 return false;   
				}	
		}
		//cargar datos por ajax 
		$.ajax({
				url:'mod/evaluacion/cont_evaluacion.php',
				data: $('#evaluacion_patoc').serialize(),
				type: 'POST',
				success: function(data){
					alert(data);
					if(data==1){
					alert("Datos Guardados");
					cargardatos(1,1);
					$('#pautaevaluacion').dialog('close');
					}else{
						console.log(data);
						//alert(data);
					   alert("Error en el Sistema GUARDAR");
					}
				}
			})
					
		} // fin funcion 
	
	
	/*var nombre_campo = $(array_campos[i]).attr("name");
var tipo = $(array_campos[i]).attr("class");*/

   /*$("#select_comprobar").click(function() {  
        alert("Id: "+$("#sexo option:selected").val()+" | Texto: "+$("#sexo option:selected").text());  
    }); 
	*/
	
        //Recorrer solo los elemenst que necesito comprobar
/*      var oi=0;  //Objeto indicie
        var thisObj;
        var objs = document.getElementById("evaluacion_patoc");
        for (oi=0;oi<objs.length;oi++) {  
            thisObj = objs[oi];  
            if(thisObj.getAttribute('type') == 'select'){
                alert(thisObj.value);
            }
        }*/
		
	
function cargar_portafolios(rutevaluado){
var parametros = "funcion=3&rut_evaluado="+rutevaluado;
	$.ajax({
		  url:'mod/evaluacion/cont_evaluacion.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
               if(data==0){
				  alert("Error de Sistema Nï¿½669");
				  return false;
				}else{
				  $('#div_portafolio').html(data);
				  $('#div_portafolio').dialog({ 
				       autoOpen:true,
				       width:550,
					   height:400,
					   	minheight: 400,
						maxWidth: 550,
					   modal:true, 
					   buttons: {
							'Aceptar': function(){ $(this).dialog('close');},
							'Cancelar': function(){ $(this).dialog('close');}
						  },
					  show: "fold",
					  hide: "scale" 
					   })
				  $("#flex11").flexigrid({
						width : 450,
						height : 200
						});
					  }
				  }
		     })
        }

   function fechafueraderango() {
   	
   	alert("Fecha de Validacion ha Caducado Contactar Con el Administrador");
     
   }
   
   function EliminaRelacion(rut_evaluador,rut_evaluado,cargo_evaluado,cargo_evaluador){
	   
	if(confirm("¿Esta seguro de querer eliminar esta relacion?")){   
	var periodo = <?=$periodo;?>;
	var parametros="funcion=5&rutevaluado="+rut_evaluado+"&rutevaluador="+rut_evaluador+"&cargoevaluado="+cargo_evaluado+"&cargo_evaluador="+cargo_evaluador+"&periodo="+periodo;
	//alert(parametros);
	
	//cargar datos por ajax 
		$.ajax({
				url:'mod/evaluacion/cont_evaluacion.php',
				data: parametros,
				type: 'POST',
				success: function(data){
					//console.log(data);
					//alert(data);
					if(data==11){
						alert("Relacion Eliminada");
						cargardatos(1,1);
					}else{
						//console.log(data);
						//alert(data);
					   alert("Error en el Sistema Eliminar");
					}
				}
			})
	}
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
<strong>INFORMACIÓN IMPORTANTE:</strong><br />
	 Sistema de Evaluación Docente <br />

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
</body>
</html>

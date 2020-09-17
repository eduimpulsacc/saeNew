<? session_start(); 

	if(isset($_ANO_)){
	 $ano=$_ANO_;
	}else{
	 $ano=$_ANO;
	}
	$rdb = $_INSTIT;
require "../../class/Membrete.class.php";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Crear Plan</title>

<script>
$(document).ready(function() {
	 $("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'mm/dd/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']	
		//$('#contenido').hide();
		carga_tabla()
   //$( "input:submit,input:button", "#cuerpo_PerfilMenu" ).button();
   
});

function calendario()
{
	
 $("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'mm/dd/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
}

function correlativo(x)
{
	if(x!=""){
	var nro_ano = parseInt(x);

		if(isNaN(nro_ano)){
			alert("Solo Numeros")
			$('#txt_ano1').focus();
			$('#txt_ano1').val("")
			return false;
			}else{

		var nro_ano2 = nro_ano +1;
		$('#txt_ano2').val(nro_ano2)
		
		var nro_ano3 = nro_ano +2;
		$('#txt_ano3').val(nro_ano3)
		
		var nro_ano4 = nro_ano +3;
		$('#txt_ano4').val(nro_ano4)
		//var suma_nro =
		//var nro_2 =	$('#txt_ano2').val()	
	 }
  }
}


function IngresoDatos(x)
{
	if($('#txt_nom_proyecto').val()==""){
		alert("Ingrese nombre proyecto");
		$('#txt_nom_proyecto').focus();
		return false;
		}
		
	if($('#txt_ano1').val()==""){
		alert("Ingrese año inicio");
		$('#txt_ano1').focus();
		return false;
		}	
	
	if($('#txt_presupuesto').val()==""){
		alert("Ingrese presupuesto");
		$('#txt_presupuesto').focus();
		return false;
		}	
		
	if($('#txt_objetivo').val()==""){
		alert("Ingrese Objetivo");
		$('#txt_objetivo').focus();
		return false;
		}	
		
	if($('#txtFECHA').val()==""){
		alert("Ingrese fecha");
		$('#txtFECHA').focus();
		return false;
		}	
	
	
	var rdb = "<?=$rdb?>";
	var presupuesto = $('#txt_presupuesto').val().replace(/\./g,'')
	
	var id_proyecto = $('#hidden_id_proyecto').val();
	
	var funcion=x;
	var parametros ='funcion='+funcion+'&nombre_proyecto='+$('#txt_nom_proyecto').val()+'&ano_1='+$('#txt_ano1').val()+'&ano_4='+$('#txt_ano4').val()+'&presupuesto='+presupuesto+'&objetivo='+$('#txt_objetivo').val()+'&fecha='+$('#txtFECHA').val()+'&estado='+$("input[name='estado']:checked").val()+'&clasificacion='+$("input[name='clasificacion']:checked").val()+'&id_proyecto='+id_proyecto+'&rdb='+rdb; 
		//alert(parametros);
	$.ajax({
		url:'mod/crear_plan/cont_crear_plan.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				if(data==1){
					limpiar()
					$('#contenido').hide();
					$('#tabla_contenido').show();
					carga_tabla()
					alert("datos Guardados")
					
				}else{
					alert("Error al guardar");
					}
			}
	})
}

function limpiar()
{
		$('#txt_nom_proyecto').val("");
		$('#txt_ano1').val("");
		$('#txt_ano2').val("");
		$('#txt_ano3').val("");
		$('#txt_ano4').val("");
		$('#txt_presupuesto').val("");
		$('#txt_objetivo').val("");
		$('#txtFECHA').val("");
}


function Moneda(input){
var num = input.value.replace(/\./g,"");
if(!isNaN(num)){
num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,"$1.");
num = num.split("").reverse().join("").replace(/^[\.]/,"");
input.value = num;
}else{
input.value = input.value.replace(/[^\d\.]*/g,"");
}
}



function carga_tabla()
{
	var funcion = 3;
	var parametros = "funcion="+funcion;
	$.ajax({
		url:'mod/crear_plan/cont_crear_plan.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				//if(data==1){
					$('#tabla_contenido').html(data)
					
			//	}else{
					//alert("Error al guardar");
				//	}
			}
	})
}

function tabla_ingreso()
{
		var funcion = 2;
	var parametros = "funcion="+funcion;
	$.ajax({
		url:'mod/crear_plan/cont_crear_plan.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				//if(data==1){
					$('#contenido').show();
					$('#contenido').html(data);
					$('#tabla_contenido').hide();
					$('#modifica').hide();
				    $('#agregar').show();
					calendario()
			//	}else{
					//alert("Error al guardar");
				//	}
			}
	})
}

function Modificar(id_proyecto){
	//alert(id_proyecto);
	tabla_ingreso();
	var funcion = 4 ;
	var parametros ='funcion='+funcion+'&id_proyecto='+id_proyecto;	
	//alert(parametros);
	$.ajax({
		url:'mod/crear_plan/cont_crear_plan.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				$('#modifica_datos').html(data);
				$('#modifica').show();
				$('#agregar').hide();
				$('#txt_nom_proyecto').val($('#hidden_nombre_proyecto').val());
				$('#txt_objetivo').val($('#hidden_objetivo').val());
				$('#txt_presupuesto').val($('#hidden_financia').val());
				$('#txtDIREC').val($('#_txtDIREC').val());
				$('#txt_ano1').val($('#hidden_ano_1').val());
				$('#txt_ano4').val($('#hidden_ano_4').val());
				$('#txtFECHA').val($('#hidden_fecha').val());
				$('#etado').val($('#hidden_estado').val());
				$('#clasificacion').val($('#hidden_clasificacion').val());
				
				var nro_ano1 = parseInt($('#hidden_ano_1').val());
				$('#txt_ano2').val(nro_ano1+1)
				$('#txt_ano3').val(nro_ano1+2)
				
			}
	})
}

function Elimina(x)
{
 	
	var funcion = 6;
	var parametros ='funcion='+funcion+'&id_proyecto='+x;	
	if(confirm("Seguro Desea Eliminar")){
	$.ajax({
		url:'mod/crear_plan/cont_crear_plan.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				if(data==1){
					carga_tabla()
					alert("dato Eliminado")
				}else{
					alert("Error al Eliminar");
					}
		}
   })
 }
}


function volver_atras()
{
	$('#contenido').hide();
	$('#tabla_contenido').show();
}
	
</script>


<style type="text/css">
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
#cuerpo_PerfilMenu{ margin:25px; }
#crea_menu{ margin-top:15px; margin-bottom:15px; }

</style>

</head>
<body>

<div id="cuerpo_crear_plan" align="left">	
<br />        
<div id="tabla_datos"></div>       
<div id="contenido"></div>      
   
   
<div id="tabla_contenido"></div>
<div id="modifica_datos"></div>
   <!--</form>-->
</div>
</body>
</html>

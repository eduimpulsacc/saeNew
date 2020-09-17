<?

session_start();
$periodo = $_PERIODO;

 require "../../class/Membrete.class.php";

	$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
	
	$ob_membrete->estilosae($_INSTIT);

	$sql ="SELECT id_ano FROM evados.eva_ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
	
	$rs_ano = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR");
	
	$fila = @pg_fetch_array($rs_ano,0);
	
	$_SESSION['_ANO'] = $fila['id_ano'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Armar Relaciones</title>
		<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
		<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>

		<script type="text/javascript">

			$(document).ready(function(){ // Script para cargar al inicio del modulo

	cargarselectbloque(<?=$_ANO ?>);
	cargartablaevaluadores(0);
	cargarselectcargos(0);
	cargartablaevaluados(0);

	$('#escojetodos').hide(true);
		
	});

	function cargarselectbloque(ano) {
		var parametros = "funcion=3&ano=" + ano;
		$.ajax({
			url : 'mod/relacion_e_e2/contr_relacion_ee.php',
			//url:'contr_relacion_ee.php',
			data : parametros,
			type : 'POST',
			success : function(data) {
				if (data == 0) {
					alert("Error al Cargar");
				} else {

					$('#select_bloque').html(data);
					
					Arreglo_RutevaluadoresCargos = "0";
					$("#Arreglo_RutevaluadoresCargos").val(Arreglo_RutevaluadoresCargos);

					$('radio').attr('checked', false);
					

				}
			}
		})
	}// fin funcion

	function cargarselectcargos() {
		var parametros = "funcion=2";
		$.ajax({
			url : 'mod/relacion_e_e2/contr_relacion_ee.php',
			data : parametros,
			type : 'POST',
			success : function(data) {
				if (data == 0) {
					alert("Error al Cargar");
				} else {
					$('#select_cargos').html(data);
						
				}
			}
		})
	}// fin funcion

	function cargartablaevaluadores(bloque) {

		if (bloque != 0) {
			var parametros = "funcion=6&id_bloque=" + bloque;
				//alert(parametros);
			$.ajax({
				url : 'mod/relacion_e_e2/contr_relacion_ee.php',
				//url:'contr_relacion_ee.php',
				data : parametros,
				type : 'POST',
				success : function(data) {
					if (data == 0) {
						alert("Error al Cargar");
					} else {
						$('#tabla_evaluadores').html(data);
						
						
				
							$("#flex1").flexigrid({
							width : 670,
							height : 150
							});
							
					}
				}
			})
		} else {

			$('#tabla_evaluadores').html(' <label for="listaevaluadores">Tabla Evaluadores</label><table id="flex1" style="display:none" ><thead><tr align="center" ><th width="300" >Nombre Completo</th></tr></thead><tbody><tr align="center" ><td>&nbsp;</td></tr><tbody></table>');

			$("#flex1").flexigrid({
				width : 670,
				height : 150
			});

		}

	}// fin funcion

	function cargartablaevaluados(cargo) {

		if (cargo != 0) {
			var parametros = "funcion=7&id_cargo=" + cargo;

			$.ajax({
				url : 'mod/relacion_e_e2/contr_relacion_ee.php',
				//url:'contr_relacion_ee.php',
				data : parametros,
				type : 'POST',
				success : function(data) {
					if (data == 0) {
						alert("Error al Cargar");
					} else {
						$('#tabla_evaluados').html(data);
						$('#escojetodos').show(true);
						$("#flex2").flexigrid({
							width : 670,
							height : 100
						});
					}
				}
			})
		} else {

			$('#tabla_evaluados').html(' <label for="listaEvaluados">Tabla Evaluados</label><table id="flex2" style="display:none" ><thead><tr align="center" ><th width="300" >Nombre Completo</th></tr></thead><tbody><tr align="center" ><td>&nbsp;</td></tr><tbody></table>');

			$("#flex2").flexigrid({
				width : 670,
				height : 100
			});

		}

	}// fin funcion




	function crea_arreglo()
	{
		var cantidad = $('#contador').val();
		//alert(cantidad);	
	}
	
	function Limpiar(){
		var Arreglo_RutevaluadoresCargos = "0";	
	}
		var Arreglo_RutevaluadoresCargos = "0";
	function insertar_relacion(rutevaluado, cargoevaluado) {
		
		/*if($("#escoje").is(':checked')){
		 var bloque = $('#selectbloque').val();
		 var id_evaluado = $('#cmbCARGO').val();
		 var rut_evaluado = $('#rut_evaluado').val();
		//alert(bloque);
		//alert(id_evaluado);
		//alert(Arreglo_RutevaluadoresCargos);
	
		var parametros = "funcion=12&id_bloque=" + bloque+ "&cargo_evaluado=" + id_evaluado+ "&rut_evaluado=" + rutevaluado;
	
		//alert(parametros);
		
		$.ajax({
				url : 'mod/relacion_e_e2/contr_relacion_ee.php',
				data : parametros,
				type : 'POST',
				success : function(data) {
					console.log(data);
					if (data!=0 ) {
						alert("datos guardados");
					}else{
						alert("error");
						//alert("Error en Relaci\u00f3n");
					}
				}
			});
			
	return false;
		}*/
	var Arreglo_RutevaluadoresCargos = $("#Arreglo_RutevaluadoresCargos").val();

		if (Arreglo_RutevaluadoresCargos != 0) {

			var parametros = "funcion=0&Arreglo_RutevaluadoresCargos=" + Arreglo_RutevaluadoresCargos + "&rut_evaluado=" + rutevaluado + "&cargo_evaluado=" + cargoevaluado;
			//alert(parametros);
			$.ajax({
				url : 'mod/relacion_e_e2/contr_relacion_ee.php',
				data : parametros,
				type : 'POST',
				success : function(data) {
					console.log(data);
					if (data == 1) {
						alert("Relaci\u00f3n Creada");
						$("#Arreglo_RutevaluadoresCargos").val();
						Arreglo_RutevaluadoresCargos=null;
						$("#Arreglo_RutevaluadoresCargos").val(Arreglo_RutevaluadoresCargos);

						$('input[type=checkbox]').attr('checked', false);
						//$("#Arreglo_RutevaluadoresCargos").val(0);

					} else {
						alert("Error en Relaci\u00f3n");
						
						$("#Arreglo_RutevaluadoresCargos").val(0);
						var Arreglo_RutevaluadoresCargos = "0";
						Limpiar();
							$('input[type=checkbox]').attr('checked', false);
						alert(Arreglo_RutevaluadoresCargos);
						alert($("#Arreglo_RutevaluadoresCargos").val());
					}

				}
			});
		} else {
			alert("Seleccionar Evaluadores antes de Insertar");
			return false;
		}

	}// fin funcion cargadatos

	/*+++++++++++++++++++cargar_evaluador*/


var Arreglo_RutevaluadoresCargos =0;
	function cargar_evaluador(e, rut, cargo) {
		
	alert(Arreglo_RutevaluadoresCargos);
		if ($('#cargar_evaluador' + e + '').attr('checked')) {

			Arreglo_RutevaluadoresCargos = Arreglo_RutevaluadoresCargos + '-' + String(rut) + 'C' + String(cargo);

		} else {//eliminar id de la cadena

			var separaarreglo = Arreglo_RutevaluadoresCargos.split("-");

			for (var g = 0; g <= separaarreglo.length; g++) {

				if (separaarreglo[g] == String(rut) + 'C' + String(cargo)) {

					separaarreglo.splice(g, 1);

				}
			}

			Arreglo_RutevaluadoresCargos = separaarreglo.join("-");

		}

		$("#Arreglo_RutevaluadoresCargos").val(Arreglo_RutevaluadoresCargos);
		alert(Arreglo_RutevaluadoresCargos);

	}// fin funcion

	/*++++++++++++++++++++++++++++++++++++++*/
	
	
function cargar_evaluador2() {
var bloque = $("#cmbCARGO").val();
	var res = 0;
	var searchIDs = [];
	
if($('input[name="c_evaluado[]"]:checked').length==0){
	
	$("#Arreglo_RutevaluadoresCargos").val("0");
	}
else{
		$('input[name="c_evaluado[]"]:checked').each(function() {
		//alert($(this).val());
		searchIDs.push($(this).val()+"C"+bloque);		  
		});
		
var cad = searchIDs.toString();		 
		var mystring = cad;
		var res = mystring.replace(/,/g, "-");	
$("#Arreglo_RutevaluadoresCargos").val("0-"+res);
	}
	

}


	var rut_evaluado = "0";

	function buscar_relacion(rut, cargo) {
		var cargo =$("#cmbCARGO").val();
		var parametros = "funcion=8&rut_evaluador=" + rut + "&id_cargo_evaluador=" + cargo;

		rut_evaluado = rut;

		$.ajax({

			url : 'mod/relacion_e_e2/contr_relacion_ee.php',
			type : 'post',
			data : parametros,
			success : function(data) {

				if (data != 0) {

					if (!$('#eval_relacionados').html()) {
						$('#bloques').append('<div id="eval_relacionados" title="Evaluadores Relacionados"></div>');
					}

					$('#eval_relacionados').html(data);

					$("#flex3").flexigrid({
						width : 600,
						height : 300
					});

					$('#eval_relacionados').dialog({
						autoOpen : true,
						width : 700,
						height : 500,
						modal : true,
						buttons : {
							'Aceptar' : function() {
								$(this).dialog('close');
							},
							'Cancelar' : function() {
								$(this).dialog('close');
							}
						}
					});
				} else {
					alert("No Existen Relaciones");
				}
			}
		})

	}

	function eliminar_relacion(rut, cargo, rut_evaluado, cargo_evaluado) {

		var parametros = "funcion=9&rut_evaluador=" + rut + "&id_cargo=" + cargo + "&rut_evaluado=" + rut_evaluado + "&cargo_evaluado=" + cargo_evaluado;

		$.ajax({
			url : 'mod/relacion_e_e2/contr_relacion_ee.php',
			data : parametros,
			type : 'POST',
			success : function(data) {
				if (data != 1) {
					alert("Error de Sistema");
				} else {
					alert("Registro Eliminado");
					$('#eval_relacionados').remove();
					buscar_relacion(rut_evaluado);
				}
			}
		})

	}// fin eliminar

	function MostrarRelacionados() {

		var parametros = "funcion=10";

		$.ajax({
			url : 'mod/relacion_e_e2/contr_relacion_ee.php',
			data : parametros,
			type : 'POST',
			success : function(data) {
			//alert(data)
				$("#mostrar_relacionados").html(data);

				/*$("#mostrar_relacionados").dialog({
				 modal: true,
				 title: "Reporte de Evaluados",
				 width: 1000,
				 height:600,
				 buttons: {

				 "Imprimir": function(){*/

				var ficha = document.getElementById('Reporte_Relacionados');
				var ventimp = window.open(' ', 'popimpr');
				ventimp.document.write(ficha.innerHTML);
				//ventimp.document.close();
				ventimp.print();
				// ventimp.close();

				$("#mostrar_relacionados").html('&nbsp;');

				//$(this).dialog("close");

				/*  },

				"Cerrar": function(){

				$(this).dialog("close");

				}

				},

				show: "fold",
				hide: "scale"
				});*/

				//$(window).scrollTop(200);

			}
		})

	}


	function CopiarRelacionados() {
		var parametros = "funcion=11";
		$.ajax({
			url : 'mod/relacion_e_e2/contr_relacion_ee.php',
			type : 'POST',
			data : parametros,
			success : function(data) {
				if (data == 1) {
					alert('OK Registros Cargados');
				} else {
					alert('Tiene  Registros Cargados este año');
				}
			}
		})
	}



	function checkTodos() {
	
		$('input[type=checkbox]').each( function() {			
			if($("input[name=escoje]:checked").length == 1){
				this.checked = true;
				
				
				var bloque = $("#cmbCARGO").val();
				
				var searchIDs = [];
				$(".revaluado").each(function(){
					searchIDs.push($(this).val()+"C"+bloque);
				  });
				  
				  var cad = searchIDs.toString();
				  
				  //var res = str.replace(",", "-");
				  
				  
				  var mystring = cad;
				 var res = mystring.replace(/,/g, "-");
				  
				  
				 $("#Arreglo_RutevaluadoresCargos").val("0-"+res);
				  
				
			} else {
				this.checked = false;
				 $("#Arreglo_RutevaluadoresCargos").val(0);
			}
		
	});
   			}

   </script>
		
		
		
		<style>
			#bloques {
				margin: 5px;
				margin-top: 5px;
				text-align: left;
				width: %;
			}

			#select_bloque {
				margin-left: 40px;
				margin-top: 33px;
				padding: 10px;
				float: left;
				width: 200px;
			}
			
			#escojetodos {
				margin-left: 5px;
				margin-top: 80px;
				padding: 10px;
				float: left;
				width: 100px;
			}
			

			#Reporte {
				margin: 5px;
				float: right;
			}

			#tabla_evaluadores {
				margin: 30px;
				margin-top: 0px;
				margin-left: 40px;
				padding: 10px;
				float: left;
			}

			#select_cargos {
				margin-left: 40px;
				margin-top: 10px;
				padding: 10px;
				float: left;
				width: 200px;
			}

			#tabla_evaluados {
				margin-left: 40px;
				padding: 10px;
				float: left;
			}

		</style>
	</head>
	<body>

		<div id="bloques" align="center"  >
			<!--<div id="eval_relacionados" title="Evaluadores Relacionados"></div>-->
			<input type="text" id="Arreglo_RutevaluadoresCargos" value="0" size="50"  />
			<fieldset>
				<legend>
					<strong> <?=htmlentities("Relación Evaluadores Evaluados", ENT_QUOTES, 'UTF-8'); ?> </strong>
				</legend>

				<div id="Reporte">
					<input name="Reporte" id="Reporte" type="button" value="Reporte de Relacionados" onclick="MostrarRelacionados()" />
				</div>

				<div id="Reporte">
					<input name="Reporte" id="Reporte" type="button" value="<?=htmlentities("Copiar ultima configuracion", ENT_QUOTES, 'UTF-8'); ?>" onclick="CopiarRelacionados()" />
				</div>
                 <div id="escojetodos">Escoje Todos
                <input type="checkbox" id="escoje" name="escoje" value="0" onclick="checkTodos()" />
                </div>

                <div id="select_cargos">
					select_cargos
				</div>
                
				<div id="tabla_evaluados">
					tabla_evaluados
				</div>

				<div id="select_bloque">
					select_bloque
				</div>
                
               
                 

				<div id="tabla_evaluadores">
					tabla_evaluadores
				</div>

				
               

			</fieldset>
		</div>
		<div id='mostrar_relacionados' >
			&nbsp;
		</div>
             <div id="datos_todos"></div> 
	</body>
</html>

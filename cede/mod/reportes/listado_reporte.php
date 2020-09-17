<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Documento sin título</title>
<script type="text/javascript">

$(document).ready(function(){
	cargarListado();		
}
)

function muestraListado(){
	$("#listado").css("display", "block");	
	$("#motor").css("display", "none");	
}

function muestraMotor(){
	$("#listado").css("display", "none");	
	$("#motor").css("display", "block");	
}
function cargarListado(){
	muestraListado();
	var parametros="funcion=1";
	$.ajax({
	url:'mod/reportes/cont_listado_reporte.php',
	data:parametros,
	type:'POST',
		success:function(data){
			$('#listado').html(data);
		}
	})
}	

function reporte1(url,id){
	muestraMotor();
	var parametros="funcion=2&tipo="+id;
	$.ajax({
	url:'mod/reportes/cont_listado_reporte.php',
	data:parametros,
	type:'POST',
		success:function(data){
			$('#txtURL').val(url);
			$('#motor').html(data);
		}
	})
}



function carga_curso(ano){
	muestraMotor();
	var parametros = "funcion=3&ano="+ano; 
	$.ajax({
		  url:'mod/reportes/cont_listado_reporte.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
				if(data==0){
					alert("Error al Cargar Select");
				}else{ 
					$('#select_cursos').html(data);
					$('#label_boton').css("display", "block");
			    }
				  }
			})
	}
	
function carga_curso2(ano){
	muestraMotor();
	var parametros = "funcion=5&ano="+ano; 
	$.ajax({
		  url:'mod/reportes/cont_listado_reporte.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
				if(data==0){
					alert("Error al Cargar Select");
				}else{ 
					$('#select_cursos').html(data);
					$('#label_boton').css("display", "block");
			    }
				  }
			})
	}
function AbrirReporte(curso){
	var ano = $('#cmbANO').val();
	var url = $('#txtURL').val()+'?ano='+ano+'&curso='+curso;
	window.open(url,'reporte','','');
}

function AbrirReporteBeca(tipo){
	var ano = $('#cmbANO').val();
	var curso = $('#select_cursos').val();
	var url = $('#txtURL').val()+'?ano='+ano+'&curso='+curso+"&tipobeca="+tipo;
	window.open(url,'reporte','','');
}



function AbrirReporteanotaciones(){
	var ano = $('#cmbANO').val();
	var curso = $('#select_cursos').val();
	var alumno = $('#select_alumnos').val();
	var url = $('#txtURL').val()+'?ano='+ano+'&curso='+curso+"&alumno="+alumno;
	window.open(url,'reporte','','');
}

function AbrirReportenotas(){
	var ano = $('#cmbANO').val();
	var curso = $('#select_cursos').val();
	var alumno = $('#select_alumnos').val();
	var url = $('#txtURL').val()+'?ano='+ano+'&curso='+curso+"&alumno="+alumno;
	window.open(url,'reporte','','');
}


function AbrirReporteEntrevista(){
	var ano = $('#cmbANO').val();
	var curso = $('#select_cursos').val();
	var rut = $('#cmb_entre').val();
	var plantilla = $('#idplantilla').val();
	var cmbPlantilla = $('#cmbPlantilla').val();
	var url = $('#txtURL').val()+'?ano='+ano+'&curso='+curso+"&rut="+rut+"&plantilla="+plantilla+"&tipoPlantilla="+cmbPlantilla;
	
	if(rut!=0 && plantilla!=0){
	window.open(url,'reporte','','');
	}else{
	alert("Seleccione todos los campos")
	}
}


function carga_alumno(id_curso){
		var parametros = "funcion=4&id_ano="+$("#cmbANO").val()+"&id_curso="+id_curso;
	
		$.ajax({
			  url:'mod/reportes/cont_listado_reporte.php',
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

function carga_alumno2(id_curso){
		var parametros = "funcion=5&id_ano="+$("#cmbANO").val()+"&id_curso="+id_curso;
		alert(parametros);
		$.ajax({
			  url:'mod/reportes/cont_listado_reporte.php',
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
	
	
	
function carga(){
	$("#cc1").remove();
	$("#cc2").remove();	
	$("#cc3").remove();
	if($('#cmbANO').val()!=0){
	
	var plantilla =$("#cmbPlantilla").val();
	
	if(plantilla !=0){
		$("#cc1").remove();
	$("#cc2").remove();
	$("#cc3").remove();	
		if(plantilla==1){
			traeApoderado();
			$("#select_cursos").val(0);
		}
		else if(plantilla==2){
			$("#cc1").remove();
	$("#cc2").remove();	
	$("#cc3").remove();
			traeCurso();
			$("#select_cursos").val(0);
		}
		else if(plantilla==3){
			$("#cc1").remove();
	        $("#cc2").remove();	
			traeEntrevistador();
		}
		
	}
	}else{
	alert("Seleccione A\u00F1o");
	$("#cmbPlantilla").val(0);
	}
	
	
}

function traeApoderado(){
	//$("#cc1").remove();
	//$("#cc2").remove();	
	var ano = $('#cmbANO').val();
	var funcion=5;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){
				//$("#cc1").remove();
				//$("#cc2").remove();	
				$("#cmb tbody").append(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}


function cargaApo(){
	/*$("#cc1").remove();
	$("#cc2").remove();	*/
	
var ano = $('#cmbANO').val();
var funcion=6;
var curso = $("#select_cursos").val();
var parametros = "ano="+ano+"&funcion="+funcion+"&curso="+curso;
//alert(parametros);
$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){	
				$("#cmb tbody").append(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}

function cargaPlantillaApo(){
var plantilla =$("#cmbPlantilla").val();
var funcion=7;
var curso = $("#select_cursos").val();
var tipo =$("#cmbPlantilla").val();

	if(plantilla !=0){
		var parametros = "plantilla="+plantilla+"&funcion="+funcion+"&curso="+curso+"&tipo="+tipo;
		
		//alert(parametros);
		$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
//console.log(data);
//$("#cc2").remove();
			$("#cmb tbody").append(data);
				}else{
					alert("Sin plantillas asociadas");	
					$("#cc2").remove();
					$("#cc3").remove();
				
			//$("#cmb").append(data);
				
				}
		
	   }
	})
		
	}
}




function traeCurso(){
	
	var ano = $('#cmbANO').val();
	var funcion=22;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//console.log(data);
			if(data!=0){
				$("#cc2").remove();	
				$("#cc3").remove();
				$("#cmb tbody").append(data);
				}else{
				alert("Error al cargar");	
				
				}
	   }
	})
}

function cargaAlu(){
var ano = $('#cmbANO').val();
var funcion=11;
var curso =  $("#select_cursos").val();
var parametros = "ano="+ano+"&funcion="+funcion+"&curso="+curso;
$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){	
				$("#cmb tbody").append(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}


function traeEntrevistador(){
	$("#cc1").remove();
	$("#cc2").remove();	
	$("#cc3").remove();
	var ano = $("#cmb_ano").val();
	var funcion=9;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
				$("#cmb tbody").append(data);
				cargaPlantillaEmp();
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}

function cargaPlantillaEmp(){
var plantilla =$("#cmbPlantilla").val();
var funcion=18;
//var curso = $("#c_curso").val();
var tipo =$("#cmbPlantilla").val();

var parametros = "plantilla="+plantilla+"&funcion="+funcion+"&tipo="+tipo;
//alert(parametros);
		$.ajax({
	  url:'mod/reportes/cont_listado_reporte.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
//console.log(data);

			$("#cmb").append(data);
				}else{
					alert("Sin plantillas asociadas");	
					$("#cc2").remove();
				
				$("#cmb tbody").append(data);
				
				}
		
	   }
	})

}


</script>

</head>

<body>
<input type="hidden" name="txtURL" id="txtURL" value="" />
<div id="listado">

</div>

<div id="motor" >

</div>

</body>
</html>

<? session_start();
require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_DBNAME);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Evaluacion Docente</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>

<script type="text/javascript">
 
/*carga_tabla();
 function carga_tabla(){
	var parametros='frmModo=mostrar';
	$.ajax({
		url:'mod/evaluados/evaluados.php',
		data:parametros,
		type:'POST',
		success:function(data){
			$("#cabecera").html(data);
		}
	});
};*/
//$('#buscar').click(function()) {
//}


listarReporte();


function listarReporte(){
		var parametros ='funcion=1';
		$.ajax({
			url:'mod/estado_evaluadores/cont_estadoevaluadores.php',
			data:parametros,
			type:'POST',
			success:function(data){
				$('#mostrarcargos').html(data);
				$("#flex1").flexigrid({
					width : 480,
					height : 300
				});
			}
		})
   }



function activarevaluadores(id_cargo,modo){
	parametros ='funcion=2&id_cargo='+id_cargo+'&modo='+modo;
	$.ajax({
			url:'mod/estado_evaluadores/cont_estadoevaluadores.php',
			data:parametros,
			type:'POST',
			success:function(data){
				console.log(data);
				//alert(data); 
				
				if(data==1){
					listarReporte();
				}else{
					alert("Error al almacenar");
				}
				
			}
		})
	}


/*function EliminaReporte(reporte,id_perfil,rdb){
	parametros ='frmModo=eliminar&reporte='+reporte+'&rdb='+rdb+'&id_perfil='+id_perfil;
	$.ajax({
			url:'mod/estado_evaluadores/cont_estadoevaluadores.php',
			data:parametros,
			type:'POST',
			success:function(data){
				if(data==1){
					listarReporte();
				}else{
					alert("Error al almacenar");
				}
			}
	})
}*/

 </script>
<style>
#central{ margin-top:40px; margin-left:10%; text-align:left; width:80%; }
#mostrarcargos{ margin-top:30px; margin-left:5%; text-align:left; width:80%; }
</style>
</head>

<body>
<div id="central" >
<fieldset>
<legend><strong>Estado de Evaluadores</strong></legend>

<p><b>Observaciones:</b><br />
1.- Pinchar desactivar elimina el acceso de evaluador del perfil seleccionado.<br />
2.- Pinchar activar agregar acceso de evaluador del perfil seleccionado.<br />
3.- En el caso de tener activado un perfil y agregar un nuevo usuario debe desactivar y volver a activa.
</p>
<div id='mostrarcargos'></div>

</fieldset><br />
<br />

</div>
</body>
</html>


<? 

session_start();
require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Evaluacion Docente</title>
<!--<link type="text/css" href="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<link type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css" rel="stylesheet" />	
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>-->
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

function listarReporte(){
	if($('#cmbPERFIL').val() == 0){
		alert("SELECCIONE PERFIL");
	}else{
		var perfil = $('#cmbPERFIL').val();
		var parametros ='frmModo=mostrar&cmbPERFIL='+perfil;
		//alert(parametros);
		$.ajax({
			url:'mod/conf_reporte/cont_reporte.php',
			//url:'cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				$('#mostrarlista').html(data);
				$("#flex1").flexigrid({
					width : 480,
					height : 200
				});
			}
		})
	}
}
function InsertaReporte(reporte,id_perfil,rdb,id_reporte){
	parametros ='frmModo=insertar&reporte='+reporte+'&rdb='+rdb+'&id_perfil='+id_perfil+'&id_reporte='+id_reporte;
	//alert(parametros);
	$.ajax({
			url:'mod/conf_reporte/cont_reporte.php',
			data:parametros,
			type:'POST',
			success:function(data){
				if(data==1){
					listarReporte();
				}else{
					alert(data);
					alert("Error al almacenar");
				}
			}
		})
}
function EliminaReporte(reporte,id_perfil,rdb){
	parametros ='frmModo=eliminar&reporte='+reporte+'&rdb='+rdb+'&id_perfil='+id_perfil;
	$.ajax({
			url:'mod/conf_reporte/cont_reporte.php',
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
}

 </script>
<style>
#central{ margin-top:40px; margin-left:10%; text-align:left; width:80%; }
#mostrarlista{ margin-top:40px; margin-left:5%; text-align:left; width:80%; }
</style>
</head>





<body>
<div id="central" >
<fieldset>
<legend><strong>Asignaci&oacute;n de Reportes</strong></legend>
<br />
<br />

<table width="80%" border="0" align="center" style="border-collapse:collapse" class="tableIndex">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="%" class="textosimple"><strong>Seleccione Perfil</strong></td>
    <td width="%"><strong>&nbsp;:&nbsp;</strong></td>
    <td width="%"><select name="cmbPERFIL" id="cmbPERFIL" onchange="listarReporte()">
		<option value="0">seleccione</option>
		<? 	$sql="SELECT * FROM perfil WHERE sistema=2 ORDER BY nombre_perfil ASC";
			$rs_cargo = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_cargo);$i++){
			$fila=pg_fetch_array($rs_cargo,$i);?>
		<option value="<?=$fila['id_perfil'];?>"><?=$fila['nombre_perfil'];?></option>
		<? } ?>
		
	</select></td>
  </tr>
</table>

<div id='mostrarlista'>&nbsp;</div>

</fieldset><br />
<br />

</div>
</body>
</html>


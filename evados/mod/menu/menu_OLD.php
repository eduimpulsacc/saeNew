<? 

//$conn=pg_connect("dbname=coi_final host=192.168.100.202 port=1550 user=postgres password=300600");
$conn_eva=pg_connect("dbname=coi_final host=localhost port=1550 user=postgres password=300600");

if(!$conn_eva){
	echo "no conecto";
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Evaluacion Docente</title>
<link type="text/css" href="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<link type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css" rel="stylesheet" />	
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>

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

function listarEvaluados(){
	if($('#cmbCARGO').val() == 0){
		alert("SELECCIONE CARGOS");
	}else{
		var cargos = $('#cmbCARGO').val();
		var parametros ='frmModo=mostrar&cmbCARGO='+cargos;
		//alert(parametros);
		$.ajax({
			url:'mod/evaluador/cont_ingreso_evaluador.php',
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
function InsertaDocente(rut,e){
	var porc = $('#txtPORC'+e+'').val();
	if(porc==""){
		alert("Ingrese Porcentaje de Evaluador");
		$('#txtPORC'+e+'').focus();
		exit;
	}
	parametros ='frmModo=insertar&rut='+rut+'&porcentaje='+porc;
	$.ajax({
			url:'mod/evaluador/cont_ingreso_evaluador.php',
			data:parametros,
			type:'POST',
			success:function(data){
				if(data==1){
					listarEvaluados();
				}else{
					alert(data);
					alert("Error al almacenar");
				}
			}
		})
}
function EliminaDocente(rut){
	parametros='frmModo=eliminar&rut='+rut;
	$.ajax({
			url:'mod/evaluador/cont_ingreso_evaluador.php',
			data:parametros,
			type:'POST',
			success:function(data){
				if(data==1){
					listarEvaluados();
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

body{
color: #333;
font-size: 11px;
font-family: verdana;
}
a{
color: #fff;
text-decoration: none;
}
a:hover{
color: #DFE44F;
}
p{
margin: 0;
padding: 5px;
line-height: 1.5em;
text-align: justify;
border: 1px solid #CCCCCC;
}
#wrapper{
width: 950px;
margin: 0 auto;
}
.box{
background: #fff;
vertical-align:top;
background-position:top;

}
.boxholder{
clear: both;
padding: 3px;
background: #CCCCCC;
vertical-align:top;
}
.tab{
float: left;
height: 32px;
width: 150px;
margin: 0 1px 0 0;
text-align: center;
background: #CCCCCC url(images/greentab.jpg) no-repeat;
}
.tabtxt{
margin: 0;
color: #fff;
font-size: 12px;
font-weight: bold;
padding: 9px 0 0 0;
}

</style>
</head>





<body>
<div id="central" >
<fieldset>
<legend><strong>Asignaci&oacute;n de Personal a Evaluador</strong></legend>
<br />
<br />

<table width="80%" border="0" align="center" style="border-collapse:collapse" class="tableIndex">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="%" class="textosimple"><strong>Seleccione Cargo</strong></td>
    <td width="%"><strong>&nbsp;:&nbsp;</strong></td>
    <td width="%"><select name="cmbCARGO" id="cmbCARGO" onchange="listarEvaluados()">
		<option value="0">seleccione</option>
		<? 	$sql="SELECT * FROM cargos ORDER BY nombre_cargo ASC";
			$rs_cargo = @pg_exec($conn_eva,$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_cargo);$i++){
			$fila=pg_fetch_array($rs_cargo,$i);?>
		<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
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


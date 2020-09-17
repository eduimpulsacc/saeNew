<? 
session_start();
$ano =$_ANO;

require "../../class/Membrete.class.php";	
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);

$nro_ano = $ob_membrete->nro_ano($ano);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript" type="text/javascript">


function carga_tabla(cargo){
	var parametros="funcion=1&cargo="+cargo;
	//alert(parametros);
	$.ajax({
		url:'mod/empleado/cont_empleado.php',
		data:parametros,
		type:'POST',
			success: function(data){
				//alert(data);
				if(data==0){
					alert("ERROR DE LISTADO");
				}else{
					$('#tabla').html(data);
				}
			}
		
	})	
}


function modifica_cargos(rut){
	var parametros="funcion=2&rut="+rut;
	//alert(parametros);
	$.ajax({
		url:'mod/empleado/cont_empleado.php',
		data:parametros,
		type:'POST',
			success: function(data){
				//alert(data);
				if(data==0){
					alert("ERROR DE LISTADO");
				}else{
					$('#tabla').html(data);
				}
			}
		
	})	
}

function guarda_cargos(rut,rdb){
	var cargo1 = $("#cmbCARGO1").val();
	var cargo2 = $("#cmbCARGO2").val();
	var cargo = $("#cmbCARGO").val();
	var parametros = "funcion=3&cargo1="+cargo1+"&cargo2="+cargo2+"&rut_emp="+rut+"&rdb="+rdb;

	$.ajax({
		url:'mod/empleado/cont_empleado.php',
		data:parametros,
		type:'POST',
		success: function(data){
				//alert(data);
				if(data==0){
					alert("ERROR DE LISTADO");
				}else{
					carga_tabla(cargo);
				}
			}
	});
}

function elimina_conf(rut){
	if(!confirm("Se Eliminaran todas las configuracion asociadas al RUT")){
		return false;	
	}
	var cargo = $("#cmbCARGO").val();
	var parametros ="funcion=4&rut_emp="+rut;
//	alert(parametros);
	$.ajax({
		url:'mod/empleado/cont_empleado.php',
		data:parametros,
		type:'POST',
		success: function(data){
			//alert(data);
			//console.log(data);
					if(data==0){
						alert("ERROR DE LISTADO");
					}else{
						carga_tabla(cargo);
					}
		}
	})
}
</script>

</head>

<body>
<div align="arriba">
<table width="100%" border="0">
  <tr>
    <td width="13%" class="textonegrita"><strong><? echo htmlentities( "AÑO ACADEMICO",ENT_QUOTES,'UTF-8');?></strong></td>
    <td width="4%"><strong>:</strong></td>
    <td width="83%" class="textosimple">&nbsp;<?=$nro_ano;?></td>
  </tr>
  <tr>
    <td class="textonegrita"><strong>CARGO</strong></td>
    <td><strong>:</strong></td>
    <td class="textosimple">
	<? 
	$sql="SELECT nombre_cargo, id_cargo FROM cargos ORDER BY 1 ASC";
	$rs_cargo = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR");	
	?>
    <select name="cmbCARGO" id="cmbCARGO" onchange="carga_tabla(this.value);">
    	<option value="0">seleccione...</option>
    <? 
		for($i=0;$i<pg_numrows($rs_cargo);$i++){
			$fila = pg_fetch_array($rs_cargo,$i);
	?>
    	<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
     <? } ?>
    </select>
    
    </td>
  </tr>
</table>
</div>
<div id="tabla">&nbsp;</div>
</body>
</html>

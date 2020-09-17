<? 
session_start();
require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);

$institucion 	= $_INSTIT;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte</title>

<link type="text/css" href="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.css" rel="stylesheet" />
<link type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css" rel="stylesheet" />	
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>


<script type="text/javascript">

function listarPerfil(){
	if($('#cmbPERFIL').val() == 0){
		alert("SELECCIONE PERFIL");
	}else{
		var perfil = $('#cmbPERFIL').val();
		var parametros ='frmModo=mostrar&cmbPERFIL='+perfil;
		//alert(parametros);
		$.ajax({
			url:'mod/perfil_menu/cont_perfil_menu.php',
			//url:'cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				$('#mostrarperfil').html(data);
				
			}
		})
	}
}


function AgregaMenu(menu,institucion,perfil){
	var parametros ='frmModo=agregar&menu='+menu+'&rdb='+institucion+'&cmbPERFIL='+perfil;
	//alert(parametros);
	$.ajax({
		url:'mod/perfil_menu/cont_perfil_menu.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			if(data==1){
				listarPerfil();
			}else{
				alert("Error al almacenar");	

			}

		}
	})
	
}


function EliminaMenu(menu,institucion,perfil){
		var parametros ='frmModo=eliminar&menu='+menu+'&rdb='+institucion+'&cmbPERFIL='+perfil;
		//alert(parametros);
		$.ajax({
			url:'mod/perfil_menu/cont_perfil_menu.php',
			//url:'cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				if(data==1){
					listarPerfil();
				}else{
					alert("Error al almacenar");	
				}
			}
		})
	
}
function AgregaCategoria(categoria,menu,institucion,perfil){

var parametros ='frmModo=agregar_cat&menu='+menu+'&categoria='+categoria+'&rdb='+institucion+'&cmbPERFIL='+perfil;

	//alert(parametros);

	$.ajax({
		url:'mod/perfil_menu/cont_perfil_menu.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==1){
				listarPerfil();
			}else{
				//alert(data);
				alert("Error al almacenar");	
			}

		}
	})
	
}

function EliminaCategoria(categoria,menu,institucion,perfil){
		var parametros ='frmModo=eliminar_cat&menu='+menu+'&categoria='+categoria+'&rdb='+institucion+'&cmbPERFIL='+perfil;
		//alert(parametros);
		$.ajax({
			url:'mod/perfil_menu/cont_perfil_menu.php',
			//url:'cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				if(data==1){
					listarPerfil();
				}else{
					alert("Error al Eliminar");	
				}
			}
		})
	
}

</script>
        


<style>
#bloques{ margin:10px; margin-top:40px; margin-left:10%; text-align:left; width:80%; }
#table_evaluadores{  margin:10px; margin-top:25px; padding:15px;  }
#botton{ margin-top:10px; padding:15px; }
#nombre_bloque{ margin-top:15px; padding:3px; border:solid 1px; margin-bottom:5px; }
</style>

</head>
<body>

<div id="bloques" align="center"  >

<fieldset>
<legend class="textonegrita">Perfil v/s Menu</legend>

<br />
<br />

<table width="650" border="0" align="center" cellpadding="0" cellspacing="5">
	<tr>
		<td width="230"><div align="right" class="textonegrita">Perfil&nbsp;</div></td>
		<td width="150">
        <?  $sql = "SELECT id_perfil,nombre_perfil FROM perfil WHERE sistema=2  ORDER BY nombre_perfil ASC ";
			$rs_perfil = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die($sql);
			?>
			<select name="cmbPERFIL" id="cmbPERFIL" onchange="listarPerfil()">
			<option value="0" selected="selected">seleccione</option>
			<? 	
			for($i=0;$i<@pg_numrows($rs_perfil);$i++){
			$fila_perfil = @pg_fetch_array($rs_perfil,$i);
			if($fila_perfil['id_perfil']==$cmbPERFIL){?>
			<option value="<?=$fila_perfil['id_perfil'];?>" selected="selected"><?=$fila_perfil['nombre_perfil'];?></option>
			<? }else{ ?>
			<option value="<?=$fila_perfil['id_perfil'];?>"><?=$fila_perfil['nombre_perfil'];?></option>
			<? }
			} ?>
			</select>		</td>
		<td width="250"><div align="right"></div></td>
	</tr>
	
</table>
<br />
<div id="mostrarperfil" >

</div>

</fieldset>






</div>




</body>
</html>

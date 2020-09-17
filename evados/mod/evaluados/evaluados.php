<? 
session_start();
require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$periodo = $_PERIODO;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Evaluacion Docente</title>

<link type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css" rel="stylesheet" />	
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>


<script type="text/javascript">

function listarEvaluados(){
	if($('#cmbCARGO').val() == 0){
		alert("SELECCIONE CARGOS");
	}else{
		var cargos = $('#cmbCARGO').val();
		var parametros ='frmModo=mostrar&cmbCARGO='+cargos;
		$.ajax({
			url:'mod/evaluados/cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				$('#mostrarlista').html(data);
				$("#flex1").flexigrid({
					width : 550,
					height : 300
				});
			}
		})
	}
}


function InsertaDocente(rut){
	if($('#cmbCARGO').val() == 0){
		
		alert("SELECCIONE CARGO EVALUADORES");
	
	}else{
	
		if(rut!=""){
			parametros ='frmModo=insertar&rut='+rut+'&id_cargo='+$('#cmbCARGO').val();
		}else{
			parametros ='frmModo=insertar&rut=todos&id_cargo='+$('#cmbCARGO').val();
		  }
	//alert(parametros);
	$.ajax({
			url:'mod/evaluados/cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				//alert(data);
				if(data==1){
					listarEvaluados();
				}
			}
		})
		
	 }
		
}


function EliminaDocente(rut){
	parametros='frmModo=eliminar&rut='+rut+'&id_cargo='+$('#cmbCARGO').val();
	$.ajax({
			url:'mod/evaluados/cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				//alert(data)
				if(data==1){
					listarEvaluados();
				}else{
					alert("Error al almacenar");
				}
			}
	})
}


	function CopiarEvaluados() {
		var parametros = "funcion=11";
		$.ajax({
			url:'mod/evaluados/cont_ingreso_evaluados.php',
			type : 'POST',
			data : parametros,
			success : function(data) {
				alert(data);
				if (data == 1) {
					alert('OK Registros Cargados');
				} else {
					alert('Tiene  Registros Cargados este año');
				}
			}
		})
	}

function MostrarEvaluadores(){
	
	parametros='frmModo=mostrarevaluados';
	
	$.ajax({
			url:'mod/evaluados/cont_ingreso_evaluados.php',
			data:parametros,
			type:'POST',
			success:function(data){
				
				$("#mostrarevaluados").html(data);
				  
	 			 $("#mostrarevaluados").dialog({
				  modal: true,
				  title: "Reporte de Evaluados",
			      width: 900,
				  height:500,
				  buttons: {
			      
			     "Imprimir": function(){
			     
				   var ficha = document.getElementById('reporte_evaluados');
				   var ventimp = window.open(' ', 'popimpr');
				   ventimp.document.write( ficha.innerHTML );
				   ventimp.document.close();
				   ventimp.print( );
				   ventimp.close();
				 
                   $(this).dialog("close");
			     
				  },	
				  
                 "Cerrar": function(){
				 
                     $(this).dialog("close");
			       
				   }
			
                  },
		  
				  show: "fold",
				  hide: "scale"
			   });
			   
		//$(window).scrollTop(200);
				
			}
	
	})
	
	
}



 </script>
<style>
#central{ margin-top:20px; margin-left:10%; text-align:left; width:80%; }
#mostrarlista{ margin-top:40px; margin-left:10%; text-align:left; width:80%; }
</style>
</head>
<body>
<div id="central" align="center" >
<fieldset>
<legend><strong>Asignaci&oacute;n de Personal a Evaluar</strong></legend>
<br />
<br />
<table width="80%" border="0" align="center" style="border-collapse:collapse" class="tableIndex">
  <tr>
    <td colspan="4">&nbsp;
    	
    	<div align="right" style="border:1px; border-color:#00F; ">
  
   		<input name="Reporte" id="Reporte" type="button" value="<?=htmlentities("Copiar ultima configuracion", ENT_QUOTES, 'UTF-8'); ?>" onclick="CopiarEvaluados()" />
  
    </div>
    	
    </td>
  </tr>
  
  <tr>
    <td width="%" class="textosimple"><strong>Seleccione Cargo</strong></td>
    <td width="%"><strong>&nbsp;:&nbsp;</strong></td>
    <td width="%">
    <select name="cmbCARGO" id="cmbCARGO" onchange="listarEvaluados()">
		<option value="0">seleccione</option>
		<? 	$sql="SELECT * FROM cargos ORDER BY nombre_cargo ASC";
			$rs_cargo = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_cargo);$i++){
			$fila=pg_fetch_array($rs_cargo,$i);?>
		<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
		<? } ?>
	</select>
    <input name="cargatodos" id="cargatodos" type="button" value="Seleccionar Todos" onclick="InsertaDocente('')" />
    </td>
    <td width="%">
    <input name="MostrarTodos" id="MostrarTodos" type="button" value="Reporte de Evaluados" onclick="MostrarEvaluadores()" />
    </td>
  </tr>
</table>
<div id='mostrarlista'>&nbsp;</div>
</fieldset><br />
<br />
</div>

<div id='mostrarevaluados' >&nbsp;</div>
</body>
</html>


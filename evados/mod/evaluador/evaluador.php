<? 
session_start();
require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
//echo "PERIODO-->".$_PERIODO;
/*echo $sql ="SELECT id_ano FROM evados.eva_ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
$rs_ano = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR");
$fila = @pg_fetch_array($rs_ano,0);
//echo "<br>".
echo $_SESSION['_ANO'] = $fila['id_ano'];*/
echo $_SESSION['_ANO'];
echo "dos->". $_PERIODO;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Evaluacion Docente</title>
<link type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css" rel="stylesheet" />	
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>


<script type="text/javascript">

function listarEvaluados(id){

 if($("#ente").val()==1){
	if($('#cmbCARGO').val() == 0){
		alert("SELECCIONE CARGOS");
	    return false;	}
	var cargos = $('#cmbCARGO').val();
	var parametros ='frmModo=mostrar&cmbCARGO='+cargos+"&ente="+$("#ente").val();
  }
  
 if($("#ente").val()==2){

	if( $('#cmbCURSO_ALU').val() == 0 ){
		alert("SELECCIONE UN CURSO");
	    return false;	}
		
	var id_curso = $('#cmbCURSO_ALU').val();
	var parametros ='frmModo=mostrar&id_curso='+id_curso+"&ente="+$("#ente").val()+"&cmbCARGO="+100;
  }
  
 if($("#ente").val()==3){
	
	if($('#cmbCURSO_APO').val() == 0){
		alert("SELECCIONE UN CURSO");
	    return false;	}
		
	var id_curso = $('#cmbCURSO_APO').val();
	var parametros ='frmModo=mostrar&id_curso='+id_curso+"&ente="+$("#ente").val()+"&cmbCARGO="+101;
  }
 
		//alert(parametros);
		$.ajax({
			url:'mod/evaluador/cont_ingreso_evaluador.php',
			data:parametros,
			type:'POST',
			success:function(data){
				$('#mostrarlista').html(data);
				$("#flex1").flexigrid({
					width : 550,
					height : 500
				});
			}
		})
	
}


 function InsertaDocente(rut){

	
	if(rut!=""){
	parametros ='frmModo=insertar&rut='+rut+'&porcentaje=1&ente='+$("#ente").val();
	}else{
	parametros ='frmModo=insertar&rut=todos&porcentaje=1&ente='+$("#ente").val();		
		}
	
	
	 if($("#ente").val()==1){
	    var parametros =  parametros+'&cmbCARGO='+$('#cmbCARGO').val(); 
      }
  //alert(parametros);
     if($("#ente").val()==2){
		var id_curso = $('#cmbCURSO_ALU').val();
        var parametros = parametros+"&cmbCARGO="+100+"&id_curso="+id_curso;
      }
  
     if($("#ente").val()==3){
		 var id_curso = $('#cmbCURSO_APO').val();
	    var parametros = parametros+"&cmbCARGO="+101+"&id_curso="+id_curso;
      }

	$.ajax({
		
			url:'mod/evaluador/cont_ingreso_evaluador.php',
			data:parametros,
			type:'POST',
			success:function(data){
				//alert(data);
				console.log(data);
				if(data==1){
					console.log(data);
				  listarEvaluados();
				}else{
					//consulta_cargo(rut);
				 alert("Puede que ya sea Evaluador con Otro Cargo");
				 alert("Imposible Activar Contacte al Administrador Web");
				}
				
			}
			
		})
  
    }


	function EliminaDocente(rut){
		parametros='frmModo=eliminar&rut='+rut;
		
		if($("#ente").val()==1){
			var parametros =  parametros+'&cmbCARGO='+$('#cmbCARGO').val(); 
		  }
	  
		 if($("#ente").val()==2){
			var parametros = parametros+"&cmbCARGO="+100;
		  }
	  
		 if($("#ente").val()==3){
			var parametros = parametros+"&cmbCARGO="+101;
		  }
	
		$.ajax({
				url:'mod/evaluador/cont_ingreso_evaluador.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==1){
						listarEvaluados();
					}else{
						alert("Error al Eliminar"+data);
					}
				}
		})
	}


	function EliminaEvaluador(rut,carg){
		
		parametros='frmModo=eliminar&rut='+rut+'&cmbCARGO='+carg;
		  
			$.ajax({
				url:'mod/evaluador/cont_ingreso_evaluador.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==1){
												
						$("#mostrarevaluadores").dialog("close");
						
						alert("Registro Eliminado");
						
						MostrarEvaluadores();
					
					}else{
						alert("Error al Eliminar"+data);
					}
				 }
			  })
		
		}


$("input:radio").click(function() {
  if($(":checked").val()==1){
     $("#ente").val(1);
	$('#empleado').show();
	$('#alumnos').hide();
	$('#apoderado').hide();
  }else if($(":checked").val()==2){
    $("#ente").val(2);
	$('#empleado').hide();
	$('#alumnos').show();
	$('#apoderado').hide();
  }else if($(":checked").val()==3){
    $("#ente").val(3);
	$('#empleado').hide();
	$('#alumnos').hide();
	$('#apoderado').show();
  }
});


	function CopiarEvaluadores() {
		var parametros = "funcion=11";
		$.ajax({
			url:'mod/evaluador/cont_ingreso_evaluador.php',
			type : 'POST',
			data : parametros,
			success : function(data) {
				//alert(data);
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
			url:'mod/evaluador/cont_ingreso_evaluador.php',
			data:parametros,
			type:'POST',
			success:function(data){
				
				$("#mostrarevaluadores").html(data);
				  
	 			 $("#mostrarevaluadores").dialog({
				  modal: true,
				  title: "Reporte de Evaluadores",
			      width: 900,
				  height:500,
				  buttons: {
			      
			     "Imprimir": function(){
			     
				   var ficha = document.getElementById('reporte_evaluadores');
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



function consulta_cargo(rut){
	var parametros="funcion=15&rut="+rut;
	$.ajax({
		url:'mod/evaluador/cont_ingreso_evaluador.php',
			data:parametros,
			type:'POST',
			success:function(data){
				alert("ERROR: Evaluador configurado como "+data);	
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
<legend><strong>Asignaci&oacute;n de Personal a Evaluador</strong></legend>
<br />
<input type="hidden" id="ente" name="ente" value="0" /> 
				
<table width="80%" border="0" align="center" cellpadding="2">
	
	<tr>
	  	
    <td colspan="2" class="textonegrita">
    
    <div align="right" style="border:1px; border-color:#00F; ">
  
   		<input name="Reporte" id="Reporte" type="button" value="<?=htmlentities("Copiar ultima configuracion", ENT_QUOTES, 'UTF-8'); ?>" onclick="CopiarEvaluadores()" />
  
    </div>
    
    </td>
  </tr>
  
  
  <tr>
    <td colspan="2" class="textonegrita">Seleccionar Tipo de Evaluador
    
    <div align="right" style="border:1px;
    border-color:#00F; ">
    <input type="submit" name="mostrarevaluadores" id="mostrarevaluadores2" value="Reporte de Evaluadores" onclick="MostrarEvaluadores()" />
    </div>
    
    
    </td>
  </tr>
  <tr>
    <td width="7%"><input name="opcion" id="opcion" type="radio" value="1" /></td>
    <td width="93%" class="textosimple">Empleado</td>
  </tr>
  <tr>
    <td><input name="opcion" id="opcion" type="radio" value="2" /></td>
    <td class="textosimple">Alumnos </td>
  </tr>
  <tr>
    <td><input name="opcion" id="opcion" type="radio" value="3"  /></td>
    <td class="textosimple">Apoderado</td>
  </tr>
</table>
<br />
<div id="empleado" style="display:none;">
<table width="80%" border="0" align="center" style="border-collapse:collapse" class="tableIndex">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="%" class="textosimple"><strong>Seleccione Cargo</strong></td>
    <td width="%"><strong>&nbsp;:&nbsp;</strong></td>
    <td width="%"><select name="cmbCARGO" id="cmbCARGO" onchange="listarEvaluados(this.value)">
		<option value="0">Seleccione</option>
		<? 	$sql="SELECT * FROM cargos ORDER BY nombre_cargo ASC";
			$rs_cargo = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_cargo);$i++){
			$fila=pg_fetch_array($rs_cargo,$i);?>
		<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
		<? } ?>
		
	</select>
    <input name="cargatodos" id="cargatodos" type="button" value="Seleccionar Todos" onclick="InsertaDocente('')" />    
    </td>
  </tr>
</table>
</div>
<div id="alumnos" style="display:none;">&nbsp;
<table width="80%" border="0" align="center" style="border-collapse:collapse" class="tableIndex">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="%" class="textosimple"><strong>Seleccione Curso</strong></td>
    <td width="%"><strong>&nbsp;:&nbsp;</strong></td>
    <td width="%">
    <select name="cmbCURSO_ALU" id="cmbCURSO_ALU" onchange="listarEvaluados(this.value)">
		<option value="0">Seleccione</option>
		<? 	ECHO $sql="select id_curso,grado_curso ||'-'|| letra_curso ||' ' || tipo_ensenanza.nombre_tipo as curso
					FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo
					WHERE id_ano=".$_ANO." 
					ORDER BY ensenanza, grado_curso, letra_curso";
			$rs_curso = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_curso);$i++){
			$fila=pg_fetch_array($rs_curso,$i);?>
		<option value="<?=$fila['id_curso'];?>"><?=$fila['curso']?></option>
		<? } ?>
	</select>
   <input name="cargatodos" id="cargatodos" type="button" value="Seleccionar Todos" onclick="InsertaDocente('')" />
    </td>
  </tr>
</table>
</div>
<div id="apoderado" style="display:none;">&nbsp;
<table width="80%" border="0" align="center" style="border-collapse:collapse" class="tableIndex">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="%" class="textosimple"><strong>Seleccione Curso</strong></td>
    <td width="%"><strong>&nbsp;:&nbsp;</strong></td>
    <td width="%"><select name="cmbCURSO_APO" id="cmbCURSO_APO" onchange="listarEvaluados(this.value)">
		<option value="0">Seleccione</option>
		<? 	$sql="select id_curso,grado_curso ||'-'|| letra_curso ||' ' || tipo_ensenanza.nombre_tipo as curso
					FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo
					WHERE id_ano=".$_ANO." 
					ORDER BY ensenanza, grado_curso, letra_curso";
			$rs_curso = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_curso);$i++){
			$fila=pg_fetch_array($rs_curso,$i);?>
		<option value="<?=$fila['id_curso'];?>"><?=$fila['curso']?></option>
		<? } ?>
	</select>
    <input name="cargatodos" id="cargatodos" type="button" value="Seleccionar Todos" onclick="InsertaDocente('')" />    
    </td>
  </tr>
</table>
</div>
<br />
<div id='mostrarlista'>&nbsp;</div>
</fieldset><br />
<br />

</div>

<div id='mostrarevaluadores' >&nbsp;</div>

</body>
</html>


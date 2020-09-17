<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

//require "../class_reporte/class_motor.php";
require "../../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_DBNAME);
$ano=$_ANO;
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>


function carga_pauta(){
	
	var bloque = $('#cmbCARGO').val();
	var parametros ="funcion=pauta&bloque="+bloque;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporte_individual/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#pauta').html(data);
				}
			}
	})
}
function cargar_dimension(pauta,nacional){
	var parametros ='funcion=dimension&nacional='+nacional+'&plantilla='+pauta;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporte_individual/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#dimension').html(data);
				}
			}
	})
}

function cargar_funcion(area,nacional,pauta){
	
	var pauta=$('#cmbPAUTA').val();
	var parametros ='funcion=funciones&nacional='+nacional+'&area='+area+'&plantilla='+pauta;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporte_individual/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#funsion').html(data);
				}
			}
	})
}

function cargar_indicador(subarea,nacional,pauta){
	
	 var pauta=$('#cmbPAUTA').val();
	var area = $("#cmbDIMENSION").val();
	var parametros ='funcion=indicador&nacional='+nacional+'&area='+area+'&subarea='+subarea+'&plantilla='+pauta;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporte_individual/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#indicador').html(data);
				}
			}
	})
}

	function cargar_intitu(num_corp){
	
		var nro_ano=$('#cmbANO').val();
		var nacional = 1;
		var parametros = 'funcion=institu&num_corp='+num_corp+'&nro_ano='+nro_ano;
		//alert(parametros);
		
		$.ajax({
			url:'mod/reportes/reporte_individual/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#intitucion').html(data);
					cargar_cargo(nro_ano);
				}
			}
			})
     	}
		
		
		
		function cargar_cargo(ano){
			
		var nro_ano=$('#cmbANO').val();	
		var inst=$('#cmbINST').val();
		//alert(inst);
		if(inst==0){
		ano=0;	
		}
		var parametros = 'funcion=carga_cargo&inst='+inst;
		//alert(parametros);
		$.ajax({
			url:'mod/reportes/reporte_individual/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#cargo').html(data);
				}
			}
			})
     	}
		
		
		function cargar_evaluado(id_cargo){
		var id_ano_ins=$('#cmbINST').val();
		var num_corp=$('#cmbCORP').val();
		var parametros = 'funcion=carga_evaluado&id_cargo='+id_cargo+'&num_corp='+num_corp+'&id_ano_ins='+id_ano_ins;
		//alert(parametros);
		$.ajax({
			url:'mod/reportes/reporte_individual/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#evaluado').html(data);
					carga_pauta();
				}
			}
			})
     	}
		
		
	  	//DEJA LOS SELECT EN SU VALOR CERO
	function limpia_todo(){  
    
        $("#cmbCORP option[value=0]").attr("selected",true);  
		$("#cmbINST option[value=0]").attr("selected",true); 
		$("#cmbANO option[value=0]").attr("selected",true); 
		$("#cmbCARGO option[value=0]").attr("selected",true); 
		$("#cmbGRUPO option[value=0]").attr("selected",true); 
		$("#cmbPAUTA option[value=0]").attr("selected",true); 
		$("#cmbDIMENSION option[value=0]").attr("selected",true); 
		$("#cmbFUNCION option[value=0]").attr("selected",true); 
		$("#cmbINDICADOR option[value=0]").attr("selected",true); 
  };  
		
	//VALIDACIONES
		function valida(form){
	if($('#cmbANO').val()==0){
	alert("Seleccione Año Academico");
	return false;
	}	
	
	if($('#cmbPAUTA').val()==0){
	alert("Debe Escojer Una Pauta de Evaluación");
	return false;
	}	
	
	form.action = 'mod/reportes/reporte_individual/printReporteIndividual.php';
	form.submit(true);		
	
}

	function verificaInst(id_ano){
		var parametros = 'funcion=verifica_intit&id_ano='+id_ano;
		//alert(parametros);
		
		$.ajax({
			url:'mod/reportes/reporte_individual/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				//alert(data);
				if(data==0){
					alert("Institución sin Evaluación");
					$("#cmbINST option[value=0]").attr("selected",true);
					return false;
				}else{
					cargar_cargo(id_ano);
				}
			}
			})
	}


	function verificaCorp(num_corp){
		
		
		var nro_ano=$('#cmbANO').val();
		var parametros = 'funcion=verifica_corp&num_corp='+num_corp+'&nro_ano='+nro_ano;
		//alert(parametros);
		
		$.ajax({
			url:'mod/reportes/reporte_individual/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				//alert(data);
				if(data==0){
					alert("Corporación sin Evaluación");
					$("#cmbCORP option[value=0]").attr("selected",true);
					$("#cmbINST option[value=0]").attr("selected",true);
					return false;
				}else{
					cargar_intitu(num_corp);
				}
			}
			})
	}


</script>
</head>

<body><br />
<br />
<form name="form" action="" method="post" target="_blank">
<table width="550" height="43" border="1" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse">
	<tr><td>
		<table width="550" height="43" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td width="500" class="cuadro02" align="center">Buscador Avanzado</td>
		  </tr>
		  <tr>
			<td width="500" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="27"><table width="550" border="0" cellspacing="0" cellpadding="3">
            
            
             <tr>
				<td class="textosmediano">Año Academico </td>
				<td colspan="2" class="textosmediano">
				<div id="año_academico">
				<table border="0">
					<tr><td>
				 <select name="cmbANO" id="cmbANO" class="ddlb_x" onchange="carga_pauta(this.value)">
					<option value="0">seleccione</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
					
				  </select>
				  </td></tr></table>
				 </div>
				</td>
			  </tr>
            
             <tr>
				<td width="141" class="textosmediano">Corporaci&oacute;n</td>
				<td width="409" colspan="2"><div align="left"><span class="textosmediano">
				  <select name="cmbCORP" id="cmbCORP" class="ddlb_x" onchange="verificaCorp(this.value)">
					<option value="0">seleccione</option>
					<?
  $sql="select * from corporacion as cor where cor.num_corp 
in (SELECT num_corp from nacional_corp as nac where nac.id_nacional=1)";					
$rs_evaluados = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_evaluados);$i++){
			$fila=pg_fetch_array($rs_evaluados,$i);?>
<option value="<?=$fila['num_corp'];?>"><?=$fila['nombre_corp'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
              
              <tr>
				<td class="textosmediano">Instituci&oacute;n </td>
				<td colspan="2" class="textosmediano">
				<div id="intitucion">
				<table border="0">
					<tr><td>
				  <select name="cmbINST" id="cmbINST" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table> 
				 </div>
				</td>
			  </tr>
              
              <tr>
				<td class="textosmediano">Cargo </td>
				<td colspan="2" class="textosmediano">
				<div id="cargo">
				<table border="0">
					<tr><td>
				  <select name="cmbCARGO" id="cmbCARGO" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table>
				 </div>
				</td>
			  </tr>
              
              
			  <tr>
				<td class="textosmediano">Evaluado </td>
				<td colspan="2" class="textosmediano">
				<div id="evaluado">
				<table border="0">
					<tr><td>
				  <select name="cmbGRUPO" id="cmbGRUPO" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table>
				 </div>
				</td>
			  </tr>
			  <tr>
				<td class="textosmediano">Pauta de Evaluaci&oacute;n </td>
				<td colspan="2" class="textosmediano">
				<div id="pauta">
				<table border="0">
					<tr><td>
				  <select name="cmbPAUTA" id="cmbPAUTA" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table>
				 </div>
				</td>
			  </tr>
			  <tr>
			    <td class="textosmediano">Dimension</td>
			    <td colspan="2" class="textosmediano" >
			      <div id="dimension">
					<table border="0">
						<tr><td>
					  <select name="cmbDIMENSION" id="cmbDIMENSION" class="ddlb_x">
						<option value="0">seleccione</option>
					  </select>
					  </td></tr></table>
				 </div>
			    </td>
		      </tr>
			  <tr>
			    <td class="textosmediano">Funci&oacute;n</td>
			    <td colspan="2">
				<div id="funsion">
					<table border="0">
						<tr><td>
					  <select name="cmbFUNCION" id="cmbFUNCION" class="ddlb_x">
						<option value="0">seleccione</option>
					  </select>
					  </td></tr></table>
				 </div>
				</td>
		      </tr>
			  <tr>
				<td class="textosmediano">Indicador</td>
				<td colspan="2" class="textosmediano">
				<div id="indicador">
					<table border="0">
						<tr><td>
					  <select name="cmbINDICADOR" id="cmbINDICADOR" class="ddlb_x">
						<option value="0">seleccione</option>
					  </select>
					  </td></tr></table>
				 </div>

				</td>
			  </tr>
			  <tr>
				<td class="textosmediano">Datos</td>
				<td colspan="2"><input name="tipo_dato" type="radio" value="1" />
				  Ponderado 
				  <input name="tipo_dato" type="radio" value="2" checked="checked"/>
				  Sin Ponderar </td>
			  </tr>
			  <tr>
				<td colspan="3" class="textosmediano"><div align="right">
				  <input name="cb_ok" class="botonXX" onmouseover="this.style.background='#FFFFD7';this.style.color='#003b85'" onmouseout="this.style.background='#5c6fa9';this.style.color='#FFFFD7'" type="button" value="Buscar" onclick="valida(this.form);" />
				</div></td>
                
                <td colspan="3" class="textosmediano"><div align="right">
				  <input name="limpiar" id="limpiar" class="botonXX" onmouseover="this.style.background='#FFFFD7';this.style.color='#003b85'" onmouseout="this.style.background='#5c6fa9';this.style.color='#FFFFD7'" type="button" value="Limpiar" onclick="limpia_todo()" />
				</div></td>
                
				</tr>
			</table></td>
		  </tr>
		</table>
	</td></tr>
</table>
</form>
<br />
<br />

</body>
</html>

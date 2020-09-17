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

function carga_tabla(curso){
	//alert(curso);
	var parametros="funcion=1&curso="+curso;
	//alert(parametros);
	$.ajax({
		url:'mod/apoderado/cont_apoderado.php',
		data:parametros,
		type:'POST',
			success: function(data){
				if(data==0){
					alert("ERROR DE LISTADO");
				}else{
					$('#tabla').html(data);
				}
			}
		
	})
}

function agregar_apo(alumno){
	//var nombre_alu = $("#alumno").val();
	var parametros="funcion=2&rut_alumno="+alumno;
	$.ajax({
		url:'mod/apoderado/cont_apoderado.php',
		data:parametros,
		type:'POST',
			success: function(data){
				if(data==0){
					alert("ERROR EN APODERADO");
				}else{
					$("#tabla").html(data);		
				}
			}
	})
}

function busca_rut(rut){
	
	var parametros="funcion=3&rut_apo="+rut;

	$.ajax({
		url:'mod/apoderado/cont_apoderado.php',
		data:parametros,
		type:'POST',
			success: function(data){
				if(data!=0){
					$("#oculto").html(data);
					$('#txtDIG').val($('#hdDIG').val());
					$("#txtNOMBRE").val($('#hdNOMBRE').val());
					$("#txtPATERNO").val($('#hdAPEPAT').val());
					$("#txtMATERNO").val($('#hdAPEMAT').val());					
				}	
			}
	})
}

function guardar_apo(){
	if($("#txtRUT").val()==""){
		alert("Debe ingresar RUT de Apoderado");
		$("#txtRUT").focus();
	}
	if($("#txtDIG").val()==""){
		alert("Debe ingresar DIGITO RUT de Apoderado");
		$("#txtDIG").focus();			
	}
	var rut_apo = $("#txtRUT").val();
	var dig 	= $("#txtDIG").val();
	var nombre	= $("#txtNOMBRE").val();
	var paterno = $("#txtPATERNO").val();
	var materno	= $("#txtMATERNO").val();
	var rut_alu = $("#rut_alumno").val();
	var parametros ="funcion=4&rut_apo="+rut_apo+"&dig_rut="+dig+"&nombre_apo="+nombre+"&ape_pat="+paterno+"&ape_mat="+materno+"&rut_alu="+rut_alu;

	$.ajax({
		url:'mod/apoderado/cont_apoderado.php',
		data:parametros,
		type:'POST',
			success: function(data){
				if(data==1){
					var curso = $("#cmbCURSO").val();
					carga_tabla(curso);
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
    <td width="13%" class="textonegrita"><strong><? echo htmlentities( "AÑO",ENT_QUOTES,'UTF-8');?></strong></td>
    <td width="4%"><strong>:</strong></td>
    <td width="83%" class="textosimple">&nbsp;<?=$nro_ano;?></td>
  </tr>
  <tr>
    <td class="textonegrita"><strong>CURSO</strong></td>
    <td><strong>:</strong></td>
    <td class="textosimple">
	<? 
	$sql="SELECT grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo as nombre_curso, ensenanza,id_curso FROM curso c INNER JOIN tipo_ensenanza te ON c.ensenanza=te.cod_tipo WHERE id_ano=".$ano." ORDER BY 2,1";
	$rs_curso = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR");	
	?>
    <select name="cmbCURSO" id="cmbCURSO" onchange="carga_tabla(this.value);">
    	<option value="0">seleccione...</option>
    <? 
		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
	?>
    	<option value="<?=$fila['id_curso'];?>"><?=$fila['nombre_curso'];?></option>
     <? } ?>
    </select>
    
    </td>
  </tr>
</table>
</div>
<br />
<div id="tabla">
&nbsp;
</div>
<div id="oculto">
&nbsp;</div>

<br />

</body>
</html>

<?php 
require("../../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<link  rel="shortcut icon" href="../../../images/icono_sae_33.png">
<link href="../../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../../cabecera_new/css2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../menu_new/css/styles.css">
<link href="../../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script>
$(document).ready(function(){
	cambia_curso();
	
});

function cambia_curso(){
 var ano =$("#cmbANO").val();
 var parametros="funcion=1&ano="+ano;
 
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#curso").html(data);

		  }
	  })		
}

function cambia_ramo(){
 var ano =$("#cmbANO").val();
 var curso = $("#cmbCURSO").val();
 var parametros="funcion=2&ano="+ano+"&curso="+curso;
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 //alert(data);
	    $("#ramo").html(data);

		  }
	  })		
}

function cambia_unidad(){
 var ano =$("#cmbANO").val();
 var curso = $("#cmbCURSO").val();
 var ramo = $("#cmbRAMO").val();
 var parametros="funcion=3&ano="+ano+"&curso="+curso+"&ramo="+ramo;
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		 //alert(data);
	    $("#unidad").html(data);

		  }
	  })		
}


function cls(opt){

if(opt==1){
$("#titcls").html("INCLUYE PLANIF. POR CLASE");
$("#titpun").html(":");
$("#titopt").html('<input type="radio" name="radio2" id="radio21" value="1" /><em>si<input name="radio2" type="radio" id="radio20" value="0"checked="checked" />no</em>');
}
else{
	$("#titcls").html("");
$("#titpun").html("");
$("#titopt").html("");
}
}
</script>
<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">
<table width="1280" border="0" cellpadding="0" cellspacing="0">
  <tr>
   	<td rowspan="3" valign="top" background="../../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
   	<td colspan="2" align="left" valign="top" height="70"><? include("../../../cabecera_new/head_plani_p.php");?></td>
    <td rowspan="3" background="../../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../../menu_new/index.php");?></td>
    <td valign="top" align="center"><br />
    <table width="890" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                          <tr>
                            <td width="5%" colspan="4"><br />
                            <form action="printPlani_Mensual.php" method="post" target="_blank">
                            <table width="90%" border="0" align="center" class="cajaborde">
                              <tr>
                                <td colspan="3" class="tableindexredondo">Buscador Planificaci&oacute;n Anual</td>
                              </tr>
                              <tr>
                                <td colspan="3">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="29%" class="textonegrita">A&Ntilde;O</td>
                                <td width="3%" class="textonegrita">:</td>
                                <td width="68%">
                                <? 	$sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$_INSTIT." ORDER BY nro_ano ASC";
									$rs_ano = pg_exec($conn,$sql);
								?>
                                <div id="ano">
                                <select name="cmbANO" id="cmbANO" onchange="cambia_curso()" class="select_redondo">
                                	<option value="0">seleccione...</option>
                                    <? for($i=0;$i<pg_numrows($rs_ano);$i++){
											$fila=pg_fetch_array($rs_ano,$i);
											if($fila['situacion']==1){
												$estado="(abierto)";
											}else{
												$estado="(cerrado)";
											}
									?>
                                    <option value="<?=$fila['id_ano'];?>" <? if($fila['situacion']==1) echo "selected";?>><?=$fila['nro_ano']." ".$estado;?></option>
                                   	<? } ?>	
                                 </select>
                                 </div>
                                </td>
                              </tr>
                              <tr>
                                <td class="textonegrita">CURSO</td>
                                <td class="textonegrita">:</td>
                                <td>
                                <div id="curso">
                                <select name="cmbCURSO1" id="cmbCURSO1" class="select_redondo">
                                	<option value="0">seleccione...</option>
                               </select>
                                </div>
                                </td>
                              </tr>
                              <tr>
                                <td class="textonegrita">ASIGNATURA</td>
                                <td class="textonegrita">:</td>
                                <td>
                                <div id="ramo">
                                <select name="ramo1" id="ramo1" class="select_redondo">
                                	<option value="0">seleccione...</option>
                                </select>
                                </div>
                                </td>
                              </tr>
                              <tr>
                                <td class="textonegrita">UNIDAD</td>
                                <td class="textonegrita">:</td>
                                <td>
                                <div id="unidad">
                                <select name="cmbUNIDAD1" id="cmbUNIDAD1" class="select_redondo">
                                	<option value="0">seleccione...</option>
                                </select>
                                </div>
                                </td>
                              </tr>
                              <tr>
                                <td class="textonegrita">INCLUYE PLANIF. POR UNIDAD</td>
                                <td class="textonegrita">:</td>
                                <td><input type="radio" name="radio" id="radio1" class="rdo" value="1" onchange="cls(1)" /><em>si<input name="radio" type="radio" id="radio0" value="0" class="rdo" checked="checked" onchange="cls(0)" />no</em></td>
                              </tr>
                              <tr>
                                <td class="textonegrita"><div id="titcls"></div></td>
                                <td class="textonegrita"><div id="titpun"></div></td>
                                <td><div id="titopt"></div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right"><input type="submit" name="BUSCAR" id="BUSCAR" value="BUSCAR" class="botonXX" /> <input type="button" name="VOLVER" id="VOLVER" value="VOLVER" onclick="window.location='../listado_reportes.php'" class="botonXX" /></td>
                              </tr>
                            </table>
                            </form>                            <br />


                            
                            </td>
                          </tr>
                          </table>
                          </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><? include("../../../cabecera_new/footer2.html");?></td>
  </tr>
</table>




</body>

</html>

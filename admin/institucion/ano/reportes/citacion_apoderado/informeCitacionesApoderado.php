<?php require('../../../../../util/header.inc');

//var_dump($_SESSION);

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP			=5;
	$reporte		=$c_reporte;
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die("Select Fallo: ".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<link  rel="shortcut icon" href="../../../../../images/icono_sae_33.png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
<!--<script type="text/javascript" src="../../../../../util/chkform.js"></script>
-->
<script language="javascript">
$(document).ready(function() {
	curso();
	asunto();
 });


function curso(ano){
	var ano =$("#cmbANO").val();
	var parametros ="funcion=1&ano="+ano;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#curso").html(data);	
			}
		}
	})
}



function apoderado(curso){
	var parametros ="funcion=2&curso="+curso;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#apoderado").html(data);	
			}
		}
	})
}




function asunto(){
	var rdb =<?php echo $institucion ?>;
	var parametros ="funcion=12&rdb="+rdb;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#asunto").html(data);	
			}
		}
	})
}


function validaform(){
	
	if($('#select_ano').val()==0){
		alert("Seleccione año");
		return false;
		}
	
	 if(!$("#formato1").is(':checked') && !$("#formato2").is(':checked'))
	{
		alert("Seleccione formato");
		return false;
	}
		
		
		
		 if($("#formato1").is(':checked') ){
			var ruta = "printinformeCitacionesApoderado.php";
		}
		else if($("#formato2").is(':checked')){
			var ruta = "printGraficoCitacionesApoderado.php";
		}
		
		
		
		

	
	form.action=ruta;
	document.form.submit(); 
	//RecargaPagina();
	}


</script>
 <style>
.ui-resizable-se {
bottom: 17px;
}
</style>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr><td>
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="73" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?php $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top">
                                  <!-- inicio codigo antiguo -->
                                  <br />
<form action="printinformeCitacionesApoderado.php" method="post" target="_blank" id="form" name="form"> 
                                  <table width="90%" border="0" align="center" style="border-collapse:collapse">
                                      <tr>
                                        <td class="textonegrita">AÑO</td>
                                        <td class="textosimple">&nbsp;
                                       <?php  if($_PERFIL !=17){?>
                                        
                                        <? $sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$institucion." ORDER BY nro_ano ASC";
		$rs_ano = pg_exec($conn,$sql) or die("ERROR".$sql);
		?>
                                        <select name="cmbANO" id="cmbANO" onchange="curso(this.value);asunto(this.value);">
                                        <? for($i=0;$i<pg_numrows($rs_ano);$i++){
                                                $fila_ano = pg_fetch_array($rs_ano,$i);
                                                if($fila_ano['situacion']==1){
                                        ?>
                                            <option value="<?=$fila_ano['id_ano'];?>" selected="selected"><?=$fila_ano['nro_ano'];?></option>	
                                        <? }else{?>
                                            <option value="<?=$fila_ano['id_ano'];?>" ><?=$fila_ano['nro_ano'];?></option>	
                                        <? } 
                                        }?>
                                        </select>
                                        <?php }else{
											$sa= "SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
		$ra = pg_exec($conn,$sa);
										echo pg_result($ra,0); 
											
											?>
                                        <input name="cmbANO" type="hidden" id="cmbANO" value="<?php echo $ano ?>" />  
                                      
                                        <?php echo $nro_ano; }?>  <input name="c_reporte" type="hidden" value="<?=$reporte;?>">
                                <input name="nombre" type="hidden" value="<?=$nombre;?>">
                                <input name="numero" type="hidden" value="<?=$numero;?>">
                                        </td>
                                      </tr>
                                    <!--  <tr>
                                        <td class="textonegrita">CURSO</td>
                                      
                                        <td class="textosimple"> &nbsp; <?php  if($_PERFIL !=17){?>
                                        <div id="curso">
                                        
                                        <select name="cmbCURSO" id="cmbCURSO">
                                        	<option value="0">seleccione...</option>
                                         </select>
                                        </div>
                                        <?php }else{
											?>
										<input name="cmbCURSO" type="hidden" id="cmbCURSO" value="<?php echo $_CURSO ?>" /> <?php 
										$sc= "SELECT grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_curso=".$_CURSO." ORDER BY ensenanza,curso ASC";
		$rc = pg_exec($conn,$sc);
										echo pg_result($rc,0); ?>
										<?php }?></td>
                                      </tr>-->
                                      <tr>
                                        <td class="textonegrita">ASUNTO</td>
                                        <td><div id="asunto">&nbsp;
                                          <select name="cmbASUNTO" id="cmbASUNTO">
                                            <option value="0">seleccione...</option>
                                          </select>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">FORMATO</td>
                                        <td><input type="radio" name="formato" id="formato1" value="1">
         Reporte 
           <input type="radio" name="formato" id="formato2" value="2">
           Gr&aacute;fico</td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" class="textonegrita">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td colspan="2" class="textonegrita"><input name="cb_ok" type="button" class="botonXX" id="cb_ok" value="Buscar" onClick="validaform()"  >
				  
                    <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='../Menu_Reportes_new2.php'"></td>
                                      </tr>
                                    </table>
                                    </form> 
								 
								  <!-- fin codigo -->
							      </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
      </td>
      </tr></table>
</body>
</html>

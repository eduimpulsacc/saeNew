<?php require('../../../util/header.inc');

$institucion 	=$_INSTIT;
$ano			=$_ANO;
$plantilla		= $_GET['plantilla'];

$_POSP = 4;
$_bot = 7;

//$sql ="SELECT id_concepto,nombre,nota FROM informe_concepto_eval WHERE id_plantilla=".$plantilla." ORDER BY id_concepto ASC";
echo $sql ="SELECT a.id_concepto,nombre,nota, b.nota_minima,b.nota_maxima FROM informe_concepto_eval a LEFT JOIN informe_cuadro_eval b ON a.id_plantilla=b.id_plantilla AND a.id_concepto=b.id_concepto WHERE a.id_plantilla=".$plantilla." ORDER BY id_concepto ASC";
$rs_concepto = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);

/**************************PERIODOS************************/
$sql ="SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano;
$rs_periodo = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);
if(@pg_numrows($rs_periodo)==3){
	$peri	="TR";
}else{
	$peri	="SR";
}

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function valida(form){
	var contador = document.form.elements.length;
	var evaluacion;  
	alert(contador);
	/*for(var i=0; i<document.form.elements.length; i++){
		alert("dentro");
		evaluacion = document.form.elements[i];
		//evaluacion = document.form.evalu[0].value;
		alert(evaluacion);
	
	
	}*/
	form.submit(true);
	
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					     $menu_lateral = 2;
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
							<tr><td class="fondo">Informe de Personalidad</td></tr>
                              <tr><td valign="top">
							  <form method="post" action="procesoConceptos.php" name="form">
							  <input type="hidden" name="plantilla" value="<?=$plantilla;?>">
							  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="right">
								  <input type="button" name="Submit" value="GUARDAR" class="botonXX" onClick="valida(this.form);">
								  <input type="button" name="Submit2" value="VOLVER" class="botonXX" onClick="window.location='ver_informe.php?plantilla=<?=$plantilla;?>'">
                                  </td>
                                </tr>
                              </table>
						
							  <table width="80%" border="0" cellspacing="3" cellpadding="0"  align="center">
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                  </tr>
                                <tr class="ccctableindex">
                                  <td>Conceptos</td>
                                  <td>Evaluaci&oacute;n</td>
                                </tr>
								<? for($i=0;$i<@pg_numrows($rs_concepto);$i++){
										$fila=@pg_fetch_array($rs_concepto,$i);?>
                                <tr>
                                  <td class="textosimple"><?=$fila['nombre'];?></td>
                                  <td align="center"><input type="text" name="evalu[<?=$i;?>]" maxlength="2" size="5" value="<?=$fila['nota'];?>"></td>
                                </tr>
								<input type="hidden" name="concepto[<?=$i;?>]" value="<?=$fila['id_concepto'];?>">
								<? } ?>
								<input type="hidden" name="contador" value="<?=$i;?>">
                              </table>
							  <br>
							  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="3">
								  <tr>
									<td colspan="3">&nbsp;</td>
									</tr>
								  <tr class="ccctableindex">
									<td>Nota Minima </td>
									<td>Nota Maxima </td>
									<td>Concepto</td>
								  </tr>
								  <? for($i=0;$i<@pg_numrows($rs_concepto);$i++){
								  		$fila_n = @pg_fetch_array($rs_concepto,$i);?>
								  		
								  <tr>
									<td align="center"><input type="text" name="nota_minima[<?=$i;?>]" maxlength="2" size="5" value="<?=$fila_n['nota_minima'];?>"></td>
									<td align="center"><input type="text" name="nota_maxima[<?=$i;?>]" maxlength="2" size="5" value="<?=$fila_n['nota_maxima'];?>"></td>
									<td align="center">
									<select name="cmbCONCEPTO[<?=$i;?>]">
										<option value="0">seleccione...</option>
										<? for($j=0;$j<@pg_numrows($rs_concepto);$j++){
												$fila_c=@pg_fetch_array($rs_concepto,$j);
													if($fila_n['id_concepto']==$fila_c['id_concepto']){?>
														<option value="<?=$fila_c['id_concepto'];?>" selected="selected"><?=$fila_c['nombre'];?></option>	
													<? }else{?>
													<option value="<?=$fila_c['id_concepto'];?>"><?=$fila_c['nombre'];?></option>	
										<?				}
										 } ?>
									</select>
									</td>
								  </tr>
								  <? } ?>
								</table>

                              </form></td></tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

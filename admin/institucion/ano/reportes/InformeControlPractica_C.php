<?
require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');
//setlocale("LC_ALL","es_ES");


	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$fin_ano		=$check_ano;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
//-->
</script>
<script language="javascript" type="text/javascript">
function enviapag(form){
	form.action='InformeControlPractica_C.php';
	form.target='_parent';
	form.submit(true);
}

</script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								 

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA --><center>
					<table width="650" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>
					<!-- FIN CUERPO DE LA PAGINA -->
					<!-- INICIO FORMULARIO DE BUSQUEDA -->
					<form action="PrintInformePracticas_New.php" method="post" name="form" target="_blank">
					<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
					<? 
					
					$institucion	=$_INSTIT;
					$ano			=$_ANO;
					
					$ob_motor = new MotorBusqueda();
					$ob_motor ->ano = $ano;
					$resultado_query_cue = $ob_motor ->Ensenanza($conn);
					?>
					<center>
					<table width="686" border="1" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="674">
						<table width="684" height="43" border="1" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="680" class="tableindex">Buscador Avanzado </span></td>
					  </tr>
					  <tr>
						<td height="27">
						<table width="684" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					  <? 	$ob_motor->ano =$ano;
					  		$rs_sector = $ob_motor->SectorEconomico($conn);
						?>
					    <td class="cuadro01">Sector Economico </td>
					    <td><span class="cuadro01">
						<select name="cmbSECTOR" onChange="enviapag(this.form)">
							<option value="0">seleccione</option>
						<?	for($i=0;$i<@pg_numrows($rs_sector);$i++){
								$fila_sector = @pg_fetch_array($rs_sector,$i);
							if($cmbSECTOR==$fila_sector['cod_sector']){
						?>
							<option value="<?=$fila_sector['cod_sector'];?>" selected="selected"><?=$fila_sector['nombre_sector'];?></option>
						<? }else{?>
							<option value="<?=$fila_sector['cod_sector'];?>"><?=$fila_sector['nombre_sector'];?></option>
						<? } 
							}?>
						</select>
						
						</span></td>
					    <td>&nbsp;</td>
					    </tr>
					  <tr>
					  <?  	if($cmbSECTOR!=0){
								$ob_motor->sector = $cmbSECTOR;
								$rs_especialidad = $ob_motor->Especialidad($conn);
							}
						?>
						<td width="124" class="cuadro01"> Especialidad          </td>
						
						<td width="393"><span class="cuadro01">
						  <select name="cmbESPECIALIDAD" class="ddlb_x">
							<?
							 for($i=0 ; $i < @pg_numrows($rs_especialidad) ; $i++){
								 $fila    = @pg_fetch_array($rs_especialidad,$i);
							?>
							<option value="<?=$fila['cod_esp'];?>"><?=$fila['nombre_esp']; ?></option>
							<?  }	?>
						  </select>
						</span></td>
						<td width="167">
						  <div align="center">
							<input name="cb_ok" class="botonXX"  type="submit" value="Buscar">
							<? if($_PERFIL==0){?>		  
							 <input name="cb_exp" type="submit"  class="botonXX"  id="cb_exp" value="Exportar">								
							<? }?>	        
						  </div></td>
					  </tr>
					  <tr>
						<td class="cuadro01">Estado</td>
						<td><span class="cuadro01">
						<? 	
							$rs_estado=$ob_motor ->EstadoPractica($conn);
						?>
						<select name="cmbESTADO">
							<option value="0">seleccione</option>
							<? for($i=0;$i<@pg_numrows($rs_estado);$i++){
									$fila_estado = @pg_fetch_array($rs_estado,$i);?>
								<option value="<?=$fila_estado['cod_estado'];?>"><?=$fila_estado['nombre_estado'];?></option>
							<? } ?>
						</select>
						</span></td>
						<td><div align="center">
						  <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
						  </div></td>
					  </tr>
					  <tr>
						<td class="cuadro01">A&ntilde;o</td>
						<td><span class="cuadro01">
						<? 	$ob_motor ->rdb = $institucion;
							$rs_ano = $ob_motor->Ano($conn);
						?>
						<select name="cmbANO">
							<option value="0">seleccione</option>
							<? for($i=0;$i<@pg_numrows($rs_ano);$i++){
									$fila_ano = @pg_fetch_array($rs_ano,$i);?>
							<option value="<?=$fila_ano['id_ano'];?>"><?=$fila_ano['nro_ano'];?></option>
							<? } ?>
							</select>	
						</span></td>
						<td>&nbsp;</td>
					  </tr>
					</table>
					
						</td>
					  </tr>
					</table>
					
						</td>
					  </tr>
					</table>
					</center>
					</form>
 
 
<!-- FIN FORMULARIO DE BUSQUEDA -->

                                  </td>
                                </tr>
                              </table>
 								  								  
								 
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
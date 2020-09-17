<?php 	require('../../../../util/header.inc');
		include('../../../clases/class_bitacora.php');


	$institucion		=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot  =8;
	if($_PERFIL==25){
		$empleado=$_NOMBREUSUARIO;
	}else{
	echo "EMPLEADO".$empleado		=$_EMPLEADO;
	}
	$fecha_hoy  =date("d-m-Y");
	
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../curso/ramo/planis/scripts/SpryData.css" rel="stylesheet" type="text/css">
<link href="../curso/ramo/planis/scripts/LiteCalendarPopup.css" rel="stylesheet" type="text/css">

	<script src="../curso/ramo/planis/scripts/LiteCalendarPopup.js"></script> 
	<script src="../curso/ramo/planis/scripts/load_calendar.js"></script>
	<script src="../curso/ramo/planis/scripts/utils.js"></script>

<script language="javascript" type="text/javascript" src="../curso/ramo/planis/scripts/SpryData.js"></script>
<script language="javascript" type="text/javascript" src="../curso/ramo/planis/scripts/SpryHTMLDataSet.js"></script>
<script language="javascript" type="text/javascript" src="../curso/ramo/planis/scripts/SpryEffects.js"></script>

<script src="../../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.Estilo1 {color: #0033FF}
-->
</style>
<script language="javascript" type="text/javascript">
function MM_preloadImages() { //v3.0
	  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}
</script>
<script src="../curso/ramo/planis/tiny_mce3/tiny_mce.js" type="text/javascript"></script>
<script src="../curso/ramo/planis/tiny_mce3/tiny_mce_gzip.js" type="text/javascript"></script>
<script src="../curso/ramo/planis/tiny_mce3/load_tiny.js" type="text/javascript"></script>
</head>
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
					
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>					  </td>
					    <?	$ob_empleado =new Bitacora();
							$ob_empleado->institucion=$institucion;
							$ob_empleado->empleado=$empleado;
							$rs=$ob_empleado->Empleado($conn);
							
						
						?>
						 
					  <td width="73%" align="left" valign="top">
					  <table width="585" border="0">
                        <tr>
                          <td width="575">&nbsp;</td>
                        </tr>
                        <tr>
                          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="80" align="left" valign="top" class="textonegrita">&nbsp;</td>
                              <td width="198" align="left" valign="top" class="textonegrita">NOMBRE EMPLEADO </td>
                              <td width="6" align="left" valign="top" class="textonegrita">:</td>
                              <td width="402" align="left" valign="top" class="textosimple"><?=$usuarioensesion?></td>
                            </tr>
                            <tr>
							<?
										$fila_empleado = pg_fetch_array($rs,0);
										$ob_cargo1 =new Bitacora();
										$ob_cargo1->institucion=$institucion;
										$ob_cargo1->cargo=$fila_empleado['cargo'];
										$rs_cargo1=$ob_cargo1->Nomb_cargo($conn);
										$dig_rut = pg_result($rs,1);
								?>		
                              <td align="left" valign="top" class="textonegrita">&nbsp;</td>
                              <td align="left" valign="top" class="textonegrita">RUT</td>
                              <td align="left" valign="top" class="textonegrita">:</td>
                              <td align="left" valign="top" class="textosimple"><?=$empleado?>-<?=$dig_rut?></td>
                            </tr>
                            <!--muestra cargos-->
                            <tr>
							
                              <td align="left" valign="top" class="textonegrita">&nbsp;</td>
                              <td align="left" valign="top" class="textonegrita">CARGO(S)</td>
                              <td align="left" valign="top" class="textonegrita">:</td>
                              <td align="left" valign="top" class="textosimple"><?=pg_result($rs_cargo1,0)?></td>
                              <? 	for($i=1;$i<@pg_numrows($rs);$i++){
									$fila_empleado = pg_fetch_array($rs,$i);
										$ob_cargo =new Bitacora();
										$ob_cargo->institucion=$institucion;
										$ob_cargo->cargo=$fila_empleado['cargo'];
										$rs_cargo=$ob_cargo->Nomb_cargo($conn);
										$fila_cargo = pg_fetch_array($rs_cargo,0);
						  ?>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top" class="textosimple"><?=$fila_cargo['nombre_cargo']?></td>
                            </tr>
                            <? }?>
                            <!--fin muestra cargos-->
                            <tr>
                              <td width="80">&nbsp;</td>
                              <td  height="30" width="198">&nbsp;</td>
							  <td  height="30" width="6">&nbsp;</td>
							  <td  height="30" width="402">
							  <? if($frmModo == "mostrar"){?>
							  <input type="button" name="Submit2" value="AGREGAR TITULO" class="botonXX" onClick="window.location='setea_bitacora.php?caso=2'">
							  <? }?>
							  <? if($frmModo == "modificar"){?>
							  <input type="button" name="Submit2" value="AGREGAR EVENTO" class="botonXX" onClick="window.location='setea_bitacora.php?caso=4'">
							  <? }?>							  </td>
                            </tr>
                            <tr>
                              <td height="43" colspan="4" align="left" valign="top">
							  <? if($frmModo == "ingresar"){?>
                                  <form name="form" method="post" action="procesa_bitacora.php?caso=1">
                                    <table width="579" border="0">
                                      <tr>
                                        <td colspan="6"><div align="center"></div></td>
                                      </tr>
                                      <tr>
                                        <td width="45" class="textonegrita">TITULO</td>
                                        <input name="txt_institucion" type="hidden" value="<?=$institucion?>">
                                        <td width="4">:</td>
                                        <input name="txt_rut" type="hidden" value="<?=$empleado?>">
                                        <td colspan="4"><input type="text" name="txt_titulo">                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="22" colspan="3">&nbsp;</td>
                                        <td width="76" height="22"><input type="submit" name="Submit" value="GUARDAR" class="botonXX"></td>
                                        <td height="22" colspan="2"><input type="button" name="Submit52" value="VOLVER" class="botonXX" onClick="window.location='setea_bitacora.php?caso=1'"></td>
                                      </tr>
                                    </table>
                                  </form>
                                <? }
								if($frmModo == "mostrar"){?>
								<form name="form2" method="post" action="procesa_bitacora.php">
                                  <table width="686" border="0">
                                    <?	$ob_titulos =new Bitacora();
										$ob_titulos->institucion=$_INSTIT;
										$ob_titulos->rut_emp=$empleado;
										$rs=$ob_titulos->Lista_titulos($conn);
								  
								  ?>
                                    <tr>
                                      <td width="680">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td class="tableindex">TITULO</td>
                                      </tr>
                                    <?
										for($i=0;$i<@pg_numrows($rs);$i++){
										$fila_titulos =@pg_fetch_array($rs,$i);
                                    ?>
                                    <tr onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick="window.location='setea_bitacora.php?caso=3&id_titulo=<?=$fila_titulos['id']?>&nomb_titulo=<?=$fila_titulos['titulo']?>'">
                                      <td >
									  <font face="arial, geneva, helvetica" size="1" color="#666666">&nbsp;
									  <? echo trim($fila_titulos['titulo'])?></td>
                                      </tr>
                                    <? }?>
                                  </table>
                                </form>
								<? }
								if($frmModo == "modificar"){?>
								<form name="form3" method="post" action="procesa_bitacora.php">
								<table width="578" border="0">
								  <tr>
								  <? 
								  		$ob_lista_eventos =new Bitacora();
										$ob_lista_eventos->id_titulo=$_ID;
										$rs_eventos=$ob_lista_eventos->Lista_eventos($conn);
								  
								  ?>
									<td width="92" class="textonegrita"><div align="center">TITULO:</div></td>
									<td width="182" class="textonegrita">&nbsp;<?=$_TITULO?></td>
								    <td width="144">&nbsp;</td>
								    <td width="144"><input type="button" name="Submit5" value="VOLVER" class="botonXX" onClick="window.location='setea_bitacora.php?caso=1'"></td>
								  </tr>
								  <tr>
								    <td colspan="4">&nbsp;</td>
								    </tr>
								  <tr>
									<td class="tableindex"><div align="center">FECHA</div></td>
									<td colspan="3" class="tableindex"><div align="center">EVENTO</div></td>
								  </tr>
								  <?
										for($i=0;$i<@pg_numrows($rs_eventos);$i++){
										$fila_eventos =@pg_fetch_array($rs_eventos,$i);
                                  ?>
								  <tr onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick="window.location='setea_bitacora.php?caso=5&fecha=<?=$fila_eventos['fecha'];?>'">
								 	<td><font face="arial, geneva, helvetica" size="1" color="#666666">
									  <div align="center">
									    <?
										$FECHA2 = $fila_eventos['fecha'];
										$AA = substr ("$FECHA2;", 0, -7); 
										$mm = substr ("$FECHA2;", 5, -4);
										$dd = substr ("$FECHA2;", 8, -1);
										/*$dia2 = getdate(mktime(0,0,0,$mm,$dd,$AA));
										//$hoy=$dia2["wday"];
										$dia = $dia2["mday"];
										$fecha_mes = $dia."-".$dia2["mon"];
										echo $FECHA3 = $fecha_mes."-".$dia2["year"];*/
										echo $FECHA3 = $dd."-".$mm."-".$AA;
									?>									
									    </div></td>
									<td colspan="3"><font face="arial, geneva, helvetica" size="1" color="#666666">
									  <div align="center">
									    <?=$fila_eventos['texto']?>
									    </div></td>
								  </tr>
								  <? }?>
								</table>
								 </form>
								<? }
								if($frmModo == "AG_EVENTO"){?>
								<form name="form4" id="form4" method="post" action="procesa_bitacora.php?caso=2">
								<table width="578" border="0">
								  <tr>
									<td width="59" class="textonegrita"><div align="center">TITULO</div></td>
									<td width="10" class="textonegrita">:</td>
									<td width="61" class="textonegrita"><?=$_TITULO?></td>
								    <td width="61" class="textonegrita"><input type="hidden" name="txt_id" value="<?=$_ID?>">
								      <input type="hidden" name="txt_nomb_titulo" value="<?=$_TITULO?>"></td>
								    <td width="367"><input type="button" name="Submit62" value="VOLVER" class="botonXX" onClick="window.location='setea_bitacora.php?caso=3&nomb_titulo=<?=$_TITULO?>&id_titulo=<?=$_ID?>'"></td>
								  </tr>
								  <tr>
									<td><div align="center" class="textonegrita">FECHA</div></td>
									<td class="textonegrita">:</td>
									<td colspan="2">
									  <div align="left">
									    <input type="text" name="txt_fecha_evento" value="<?=$fecha_hoy?>" size="7">
									  </div></td>
								    <td>&nbsp;</td>
								  </tr>
								  <tr>
									<td height="59" class="textonegrita"><div align="center">EVENTO</div></td>
									<td class="textonegrita">:</td>
									<td colspan="2">
										<div id="CollapsiblePanel_Evento" class="CollapsiblePanel">
										<div class="CollapsiblePanelTab">Agregar Evento</div>
										<div class="CollapsiblePanelContent">
										  <textarea name="textarea_evento" id="textarea_evento" cols="40" rows="10" class="mceAdvanced">Escriba Evento.</textarea>
										</div>
										</div>									</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
								    <td height="34">&nbsp;</td>
								    <td>&nbsp;</td>
								    <td colspan="3"><input type="submit" name="Submit3" class="botonXX" value="GUARDAR EVENTO"></td>
								    </tr>
								</table>
								
								</form>
								<script type="text/javascript">
										var CollapsiblePanel_Evento = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Evento");
								</script>						 
								<? }
								if($frmModo == "MOD_EVENTO"){?>
								<form name="form5" method="post" action="procesa_bitacora.php?caso=3">
								<table width="578" border="0">
								  <tr>
									<td width="59" class="textonegrita"><div align="center">TITULO</div></td>
									<td width="10" class="textonegrita">:</td>
									<td width="123" class="textonegrita"><?=$_TITULO?></td>
								    <td width="183">
									<input type="hidden" name="txt_id2" value="<?=$_ID?>">
									<input type="hidden" name="txt_nomb_titulo2" value="<?=$_TITULO?>">									</td>
								    <td width="183"><input type="button" name="Submit6" value="VOLVER" class="botonXX" onClick="window.location='setea_bitacora.php?caso=3&nomb_titulo=<?=$_TITULO?>&id_titulo=<?=$_ID?>'"></td>
								  </tr>
								  <tr>
								  <!--SELECCIONAR EVENTO POR FECHA Y POR ID-->
								  <? 
								  		$ob_seleccion_evento =new Bitacora();
										$ob_seleccion_evento->fecha=$_FECHA_EVENTO;
										$ob_seleccion_evento->id_titulo=$_ID;
										$rs_seleccion_eventos=$ob_seleccion_evento->Seleccion_evento($conn);
										$fila_seleccion_evento =@pg_fetch_array($rs_seleccion_eventos,0);
								  
								  ?>
								  
								  
								  <!--FIN SELECCIONAR EVENTO POR FECHA Y POR ID-->
									<td class="textonegrita"><div align="center">FECHA</div></td>
									<td class="textonegrita">:</td>
									<td colspan="3">
									  <div align="left">
									  <? 
									  	$FECHA3 = $_FECHA_EVENTO;
										$AA = substr ("$FECHA3;", 0, -7); 
										$mm = substr ("$FECHA3;", 5, -4);
										$dd = substr ("$FECHA3;", 8, -1);
										/*$dia2 = getdate(mktime(0,0,0,$mm,$dd,$AA));
										//$hoy=$dia2["wday"];
										if ($dia2["mday"] < 10){
											$dia = "0".$dia2["mday"];
										}else{
											$dia = $dia2["mday"];
										}
										$fecha_mes = $dia."-".$dia2["mon"];
										$FECHA4 = $fecha_mes."-".$dia2["year"];*/
										$FECHA4 = $dd."-".$mm."-".$AA;
										?>
										<input type="hidden" name="txt_fecha_evento21" value="<?=$FECHA4?>">
									    <input type="text" disabled="disabled" name="txt_fecha_evento2" value="<?=$FECHA4?>" size="7">
									      </div></td>
								  </tr>
								  <tr>
									<td height="59" class="textonegrita"><div align="center">EVENTO</div></td>
									<td class="textonegrita">:</td>
									<td colspan="3">
									 	<div id="CollapsiblePanel_Evento2" class="CollapsiblePanel">
										<div class="CollapsiblePanelTab">Agregar Evento</div>
										<div class="CollapsiblePanelContent">
										  <textarea name="textarea_evento2" cols="40" rows="10" class="mceAdvanced"><?=$fila_seleccion_evento['texto']?></textarea>
										</div>
										</div>									</td>
								  </tr>
								  <tr>
								    <td height="34">&nbsp;</td>
								    <td>&nbsp;</td>
								    <td colspan="3"><input type="submit" name="Submit4" class="botonXX" value="GUARDAR EVENTO"></td>
								    </tr>
								</table>
								<script type="text/javascript">
										var CollapsiblePanel_Evento2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Evento2");
								</script>
								 </form>
								<? }?>								</td>
                            </tr>
                            <tr>
                              <td height="395" colspan="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007 </td>
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
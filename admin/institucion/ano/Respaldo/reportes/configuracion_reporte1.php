<?php 	require('../../../../util/header.inc');
		include('../../../clases/class_Membrete.php');
		include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;


	
	

	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->ano=$ano;
	$ob_membrete->institucion($conn);
	$Nombre_Ins = $ob_membrete->ins_pal;
	
	$ob_membrete->AnoEscolar($conn);
	$nro_ano=$ob_membrete->nro_ano;
	
	if($caso==1){
		$ob_reporte = new Reporte();
		$ob_reporte->institucion=$institucion;
		$ob_reporte->cmbREPORTE=$cmbREPORTE;
		$ob_reporte->id_config=$id_config;
		$rs_reporte=$ob_reporte->BuscaReporte($conn);
		$fila_rep = @pg_fetch_array($rs_reporte,0);
		$titulo		=$fila_rep['titulo_tamano'];
		$item		=$fila_rep['item_tamano'];
		$subitem	=$fila_rep['subitem_tamano'];
		$letraT		=$fila_rep['titulo_letra'];
		$letraI 	=$fila_rep['item_letra'];
		$letraS 	=$fila_rep['subitem_letra'];
		$colilla	=$fila_rep['con_colilla'];
		$taller 	=$fila_rep['con_taller'];
		$anotacion 	=$fila_rep['con_anotaciones'];
		$firma1		=$fila_rep['firma1'];
		$firma2		=$fila_rep['firma2'];
		$firma3		=$fila_rep['firma3'];
		$firma4		=$fila_rep['firma4'];
		$grado1		=$fila_rep['grado1'];
		$grado2		=$fila_rep['grado2'];
		$grado3		=$fila_rep['grado3'];
		$grado4		=$fila_rep['grado4'];
		$grado5		=$fila_rep['grado5'];
		$grado6		=$fila_rep['grado6'];
		$grado7		=$fila_rep['grado7'];
		$grado8		=$fila_rep['grado8'];
		$grado9		=$fila_rep['grado9'];
		$grado10	=$fila_rep['grado10'];
		$grado11	=$fila_rep['grado11'];
		$grado12	=$fila_rep['grado12'];	
		$ensenanza	=$fila_rep['tipo_ense'];	
	}
 ?>
 <SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
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


</script>
<script language="javascript">
function enviapag(form){
	if (form.cmbREPORTE.value!=0){
		form.cmbREPORTE.target="self";
		form.action = 'configuracion_reporte.php';
		form.submit(true);
	}	
}

</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php include('../../../../util/rpc.php3');?>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo3 {font-family: Georgia, "Times New Roman", Times, serif}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			  include("../../../../cabecera/menu_superior.php");
			   ?>
              </td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td align="left" valign="top">
					  <!--CUERPO DEL ARCHIVO-->
					  <table width="100%" border="0">
					  <tr>
						<td><table width="457" border="0">
                          <tr>
                            <td width="138" class="textonegrita">INSTITUCI&Oacute;N</td>
                            <td width="10" class="textonegrita">:</td>
                            <td width="295" class="textonegrita">&nbsp;<?=$Nombre_Ins;?></td>
                          </tr>
                          <tr>
                            <td class="textonegrita">A&Ntilde;O ESCOLAR </td>
                            <td class="textonegrita">:</td>
                            <td class="textonegrita">&nbsp;<?=$nro_ano;?></td>
                          </tr>
                        </table></td>
					  </tr>
					  <tr>
					    <td>
						<form name="form" action="procesaReporte.php" method="post">
						<input name="caso" value="<?=$caso;?>" type="hidden">
						<input name="id_config" value="<?=$id_config;?>" type="hidden">
						<table width="100%" border="0">
                          <tr>
                            <td colspan="2"><div align="right">
                              <? if($caso!=1){ ?>
							  <input type="submit" name="guardar" value="GUARDAR" onClick="valida(this.form);" class="botonXX">
							  <? }else{ ?>
                              <input type="submit" name="modificar" value="MODIFICAR" class="botonXX">
							  <input name="eliminar" type="button" class="botonXX" id="eliminar" onClick="window.location='procesaReporte.php?caso=1&eliminar=si&id_config=<?=$id_config;?>&id_item=<?=$cmbREPORTE;?>'" value="ELIMINAR">
							  <? } ?>
                              <input type="button" name="cancelar" value="CANCELAR" onClick="window.location='listaConfiguracionReporte.php'" class="botonXX">
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="cuadro02" ><div align="center">CONFIGURACI&Oacute;N DE REPORTES </div></td>
                          </tr>
                          <tr>
                            <td width="20%" class="textonegrita"><div align="right">REPORTE</div></td>
                            <td  width="80%">
							<? $ob_reporte = new Reporte();
									$result=$ob_reporte->ListaReporte($conn);
							?>
							<select name="cmbREPORTE">
								 <option value=0 selected>Seleccione</option>
								<? 	$cont =1;
									for($i=0;$i<pg_numrows($result);$i++){
										$fila=pg_fetch_array($result,$i);
										if($cmbREPORTE==$fila['id_item']){?>
										   <option value="<?=$fila['id_item'];?>" selected><? echo $cont."--".$fila['nombre'];?></option>
									<?  }else{ ?>
										   <option value="<?=$fila['id_item'];?>"><? echo $cont."--".$fila['nombre'];?></option>
									<?  }
									$cont++;
									}
									
									 ?>
                            </select> 
							</td>
                          </tr>
                          <tr>
                            <td colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" class="cuadro01 Estilo1">TAMA&Ntilde;O DE LETRA </td>
                          </tr>
                          <tr>
                            <td colspan="2"><table width="100%" border="0">
                              <tr>
                                <td class="textonegrita">TITULO</td>
                                <td class="textosimple">
								<input name="rbTITULO" type="radio" value="10" <? if($titulo==10) echo "checked";?>>
								10
								<input name="rbTITULO" type="radio" value="11" <? if($titulo==11) echo "checked";?>>
								11
								<input name="rbTITULO" type="radio" value="12" <? if($titulo==12 || $titulo=="") echo "checked";?>>
								12
								</td>
                                <td>&nbsp;</td>
                                <td colspan="6">&nbsp;</td>
                                </tr>
                              <tr>
                                <td class="textonegrita">ITEM</td>
                                <td class="textosimple">
								<input name="rbITEM" type="radio" value="10" <? if($item==10) echo "checked";?>>
								10
								<input name="rbITEM" type="radio" value="11" <? if($item==11 || $item=="") echo "checked";?>>
								11
								<input name="rbITEM" type="radio" value="12" <? if($item==12) echo "checked";?>>
								12
								</td>
                                <td>&nbsp;</td>
                                <td class="textonegrita">SUBITEM</td>
                                <td colspan="5" class="textosimple">
								<input name="rbSUBITEM" type="radio" value="10" <? if($subitem==10 || $subitem=="") echo "checked";?>>
								10
								<input name="rbSUBITEM" type="radio" value="11" <? if($subitem==11) echo "checked";?>>
								11
								<input name="rbSUBITEM" type="radio" value="12" <? if($subitem==12) echo "checked";?>>
								12
								</td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="cuadro01">TIPO DE LETRA </td>
                          </tr>
                          <tr>
                            <td colspan="2"><table width="100%" border="0">
                              <tr>
                                <td class="textonegrita">TITULO</td>
                                <td class="textosimple">
								<select name="cmbLETRATITULO">
                                  <option value="Arial, Helvetica, sans-serif" <? if($letraT=="Arial, Helvetica, sans-serif") echo "selected";?>>Arial, Helvetica, sans-serif</option>
                                  <option value="Courier New, Courier, mono"  <? if($letraT=="Courier New, Courier, mono") echo "selected";?>>&quot;Courier New&quot;, Courier, mono</option>
                                  <option value="Verdana, Arial, Helvetica, sans-serif" <? if($letraT=="Verdana, Arial, Helvetica, sans-serif") echo "selected";?>>Verdana, Arial, Helvetica, sans-serif</option>
                                  <option value="Times New Roman, Times, serif" <? if($letraT=="Times New Roman, Times, serif") echo "selected";?>>&quot;Times New Roman&quot;, Times, serif</option>
                                </select>                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="textonegrita">ITEM</td>
                                <td class="textosimple"><select name="cmbLETRAITEM">
								 <option value="Arial, Helvetica, sans-serif"  <? if($letraI=="Arial, Helvetica, sans-serif") echo "selected";?>>Arial, Helvetica, sans-serif</option>
                                  <option value="Courier New, Courier, mono" <? if($letraI=="Courier New, Courier, mono") echo "selected";?>>&quot;Courier New&quot;, Courier, mono</option>
                                  <option value="Verdana, Arial, Helvetica, sans-serif" <? if($letraI=="Verdana, Arial, Helvetica, sans-serif") echo "selected";?>>Verdana, Arial, Helvetica, sans-serif</option>
                                  <option value="Times New Roman, Times, serif" <? if($letraI=="Times New Roman, Times, serif") echo "selected";?>>&quot;Times New Roman&quot;, Times, serif</option>
                                </select></td>
                                <td>&nbsp;</td>
                                <td class="textonegrita">SUBITEM</td>
                                <td class="textosimple"><select name="cmbLETRASUBITEM">
								  <option value="Arial, Helvetica, sans-serif" <? if($letraS=="Arial, Helvetica, sans-serif") echo "selected";?>>Arial, Helvetica, sans-serif</option>
                                  <option value="Courier New, Courier, mono" <? if($letraS=="Courier New, Courier, mono") echo "selected";?>>&quot;Courier New&quot;, Courier, mono</option>
                                  <option value="Verdana, Arial, Helvetica, sans-serif" <? if($letraS=="Verdana, Arial, Helvetica, sans-serif") echo "selected";?>>Verdana, Arial, Helvetica, sans-serif</option>
                                  <option value="Times New Roman, Times, serif" <? if($letraS=="Times New Roman, Times, serif") echo "selected";?>>&quot;Times New Roman&quot;, Times, serif</option>
                                </select></td>
                              </tr>
                            </table></td>
                          </tr>
                         <!-- <tr>
                            <td colspan="2" class="cuadro01">OPCIONES</td>
                          </tr>
                          <tr>
                            <td colspan="2"><table width="100%" border="0">
                              <tr>
                                <td class="textosimple"><input type="checkbox" name="ckboxCOLILLA" value="1" <? if($colilla==1) echo "checked";?>>con colilla </td>
                                <td class="textosimple"><input type="checkbox" name="ckboxTALLER" value="1" <? if($taller==1) echo "checked";?>>con taller </td>
                                <td class="textosimple"><input type="checkbox" name="ckboxANOTACION" value="1" <? if($anotacion==1) echo "checked";?>>con anotaciones </td>
                              </tr>
                            </table></td>
                          </tr>-->
                          <tr>
                            <td colspan="2" class="cuadro01">FIRMAS DE REPORTE </td>
                          </tr>
                          <tr>
                            <td colspan="2"><table width="100%" border="0">
                              <tr>
                                <td width="17%"  class="textonegrita">firma 1 </td>
                                <td width="28%"  class="textosimple">
								<select name="cmbFIRMA1">
								<option value="0">Seleccione</option>
								<? 	$result_cargo=$ob_reporte->Cargos($conn);
									for($i=0;$i<@pg_numrows($result_cargo);$i++){
										$fila = @pg_fetch_array($result_cargo,$i);
										if($firma1==$fila['id_cargo']){
								?>
								<option value="<?=$fila['id_cargo'];?>" selected="selected"><?=$fila['nombre_cargo'];?></option>
								<? 		}else{?>
								<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
								<? 		}
									}
								?>
                                </select>
                                </td>
                                <td width="3%">&nbsp;</td>
                                <td width="15%" class="textonegrita">firma 2 </td>
                                <td width="37%" class="textosimple">
								<select name="cmbFIRMA2">
								<option value="0">Seleccione</option>
								<? 	$result_cargo=$ob_reporte->Cargos($conn);
									for($i=0;$i<@pg_numrows($result_cargo);$i++){
										$fila = @pg_fetch_array($result_cargo,$i);
										if($firma2==$fila['id_cargo']){
								?>
								<option value="<?=$fila['id_cargo'];?>" selected="selected"><?=$fila['nombre_cargo'];?></option>
								<? 		}else{?>
								<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
								<? 		}
									}
								?>
                                </select></td>
                              </tr>
                              <tr>
                                <td class="textonegrita">firma 3 </td>
                                <td class="textosimple">
								<select name="cmbFIRMA3">
								<option value="0">Seleccione</option>
								<? 	$result_cargo=$ob_reporte->Cargos($conn);
									for($i=0;$i<@pg_numrows($result_cargo);$i++){
										$fila = @pg_fetch_array($result_cargo,$i);
										if($firma3==$fila['id_cargo']){
								?>
								<option value="<?=$fila['id_cargo'];?>" selected="selected"><?=$fila['nombre_cargo'];?></option>
								<? 		}else{?>
								<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
								<? 		}
									}
								?>
                                </select>
								</td>
                                <td>&nbsp;</td>
                                <td class="textonegrita">firma 4 </td>
                                <td class="textosimple">
								<select name="cmbFIRMA4">
								<option value="0">Seleccione</option>
								<? 	$result_cargo=$ob_reporte->Cargos($conn);
									for($i=0;$i<@pg_numrows($result_cargo);$i++){
										$fila = @pg_fetch_array($result_cargo,$i);
										if($firma4==$fila['id_cargo']){
								?>
								<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
								<? 		}else{?>
								<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
								<?	 	}
									}
								?>
                                </select>
								</td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="cuadro01">GRADOS EN QUE APLICA CONFIGURACI&Oacute;N </td>
                          </tr>
                          <tr>
                            <td colspan="2"><table width="100%" border="0">
                              <tr>
                                <td width="16%" class="textosimple">Tipo Ense&ntilde;anza </td>
                                <td width="48%" class="textosimple">
								<select name="cmbENSENANZA">
									<option value="0">seleccione</option>
									<? 	$ob_reporte->institucion=$institucion;
										$result_ense = $ob_reporte->Ensenanza($conn);
										for($i=0;$i<pg_numrows($result_ense);$i++){
											$fila_ense = pg_fetch_array($result_ense,$i);
											if($ensenanza==$fila_ense['cod_tipo']){
									?>
											<option value="<?=$fila_ense['cod_tipo'];?>" selected="selected"><?=$fila_ense['nombre_tipo'];?></option>
									<? 		}else{?>
											<option value="<?=$fila_ense['cod_tipo'];?>"><?=$fila_ense['nombre_tipo'];?></option>
									<? 		}
										}
									?>
								</select>
								</td>
                                <td width="36%" class="textosimple">
									1<input type="checkbox" name="ckbox1" value="1" <? if($grado1==1) echo "checked";?>>
									2<input type="checkbox" name="ckbox2" value="1" <? if($grado2==1) echo "checked";?>>
									3<input type="checkbox" name="ckbox3" value="1" <? if($grado3==1) echo "checked";?>>
									4<input type="checkbox" name="ckbox4" value="1" <? if($grado4==1) echo "checked";?>>
									5<input type="checkbox" name="ckbox5" value="1" <? if($grado5==1) echo "checked";?>>
									6<input type="checkbox" name="ckbox6" value="1" <? if($grado6==1) echo "checked";?>>
								</td>
                              </tr>
                              <tr>
                                <td colspan="2" class="textosimple">&nbsp;</td>
                                <td class="textosimple">
									7<input type="checkbox" name="ckbox7" value="1" <? if($grado7==1) echo "checked";?>>
									8<input type="checkbox" name="ckbox8" value="1" <? if($grado8==1) echo "checked";?>>
									9<input type="checkbox" name="ckbox9" value="1" <? if($grado9==1) echo "checked";?>>
									10<input type="checkbox" name="ckbox10" value="1" <? if($grado10==1) echo "checked";?>>
									11<input type="checkbox" name="ckbox11" value="1" <? if($grado11==1) echo "checked";?>>
									12<input type="checkbox" name="ckbox12" value="1" <? if($grado12==1) echo "checked";?>>
								</td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
						</form>
						</td>
					    </tr>
					</table>
					<!--FIN CUERPO DE ARCHIVO-->
					&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>
    <td width="53" align="left" valign="top" height="100%" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table> 
<?
pg_close($conn);
?>
</body>
</html>

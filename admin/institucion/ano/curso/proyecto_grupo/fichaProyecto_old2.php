<?	require('../../../../../util/header.inc');


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;

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
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}


$sql = "SELECT * FROM alumno_proyecto WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_proy=".$cmbPROYECTO." AND rut_alumno=".$cmbALUMNO."";
$rs_existe = @pg_exec($conn,$sql);
$fila_alumno = @pg_fetch_array($rs_existe,0);
	
if($cmbALUMNO!=0 && $cmbPROYECTO!=0 && $caso!=2){
	
	if(@pg_numrows($rs_existe)>0){
		$caso=4;
	}else{
		$caso=1;
	}
	
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
function enviapag(form){
	form.action='fichaProyecto.php';
	form.submit(true);
}									
</script>

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
<style type="text/css">
<!--
.Estilo16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.Estilo22 {font-size: 10}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>"></td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../../cabecera/menu_superior.php");
				?></td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../../../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td valign="top"><!-- INCLUYO CODIGO DE LOS BOTONES -->
                              
                            <form id="form" name="form" action="procesaProyecto.php" method="post">
                              <input name="caso" value="<?=$caso;?>" type="hidden">
                                <input name="id_pro" value="<?=$id_pro;?>" type="hidden">
								
                                <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                  <tr>
                                    <td width="289"><span class="Estilo16">Proyecto Intergraci&oacute;n o Grupo Diferencial </span></td>
                                    <td width="3"><strong>:</strong></td>
                                    <td width="328">
									<?  $sql = "SELECT id_proy,nombre,tipo FROM proyecto_grupo WHERE rdb=".$institucion." ORDER BY tipo ASC";
										$rs_proyecto = @pg_exec($conn,$sql);
									?>
									<select name="cmbPROYECTO" onChange="enviapag(this.form)">
										<option value="0">seleccione</option>
										<? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
												$fila_pro = @pg_fetch_array($rs_proyecto,$i);
											if($fila_pro['tipo']==1){
												if($fila_pro['id_proy']==$cmbPROYECTO){?>
													<option value="<?=$fila_pro['id_proy'];?>" selected="selected"><?=$fila_pro['nombre']." (PI)";?></option>
												<? }else{?>
													<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre']." (PI)";?></option>
												<? } ?>
											<? }else{?>
												<? if($cmbPROYECTO==$fila_pro['id_proy']){ ?>
													<option value="<?=$fila_pro['id_proy'];?>" selected="selected"><?=$fila_pro['nombre']." (GD)";?></option>
												<? }else{ ?>
													<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre']." (GD)";?></option>
												<? } ?>
										<? 	   }
										} ?>
									</select>
									&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo16">Alumno</span></td>
                                    <td><strong>:</strong></td>
                                    <td>
									<? $sql = "SELECT   DISTINCT b.rut_alumno,a.id_curso,b.nombre_alu || cast(' ' as varchar) || b.ape_pat || CAST(' ' as varchar ) || ape_mat as nombre FROM matricula a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno WHERE a.id_ano=".$ano." AND b.rut_alumno in (SELECT rut_alumno FROM inscribe_proyecto where id_proy=".$cmbPROYECTO.") ORDER BY nombre ASC";
										$rs_alumno = @pg_exec($conn,$sql);
									?>
									<select name="cmbALUMNO" onChange="enviapag(this.form)">
										<option value="0">seleccione</option>
										<? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
												$fila_alu = @pg_fetch_array($rs_alumno,$i);
											if($fila_alu['rut_alumno']==$cmbALUMNO){?>
												<option value="<?=$fila_alu['rut_alumno'];?>" selected="selected"><?=strtoupper($fila_alu['nombre']);?></option>
											<? }else{ ?>
												<option value="<?=$fila_alu['rut_alumno'];?>"><?=strtoupper($fila_alu['nombre']);?></option>
											<? } ?>
										<? } ?>											
									</select>
									</td>
                                  </tr>
                                </table>
								<br>
								<? if($cmbPROYECTO!=0 && $cmbALUMNO!=0){ ?>
								<table width="650" border="0" align="center">
                                  <tr>
                                    <td><div align="right">
                                      <? if($caso==1 || $caso==2){
									  		if($ingreso==1){?>
									  	<input type="submit" name="Submit" value="GUARDAR" class="botonXX">
										&nbsp;<input type="button" name="button" value="CANCELAR" class="botonXX" onClick="window.location='fichaProyecto.php'">
									<? 		}
										}else{
											if($modifica==1){?>	
										<input type="button" name="modificar" value="MODIFICAR" class="botonXX" onClick="window.location='fichaProyecto.php?caso=2&cmbPROYECTO=<?=$cmbPROYECTO;?>&cmbALUMNO=<?=$cmbALUMNO;?>'">
										<? 	} 
											if($elimina==1){?>
										<input type="button" name="modificar" value="ELIMINAR" class="botonXX" onClick="window.location='procesaProyecto.php?caso=3&cmbPROYECTO=<?=$cmbPROYECTO;?>&cmbALUMNO=<?=$cmbALUMNO;?>'">
									<? 		}
										} ?>
										
										

                                    </div></td>
                                  </tr>
                                </table>
								<br>
								<table width="650" border="0" align="center">
                                  <tr>
                                    <td class="tableindex">
									<? 	$sql = "SELECT * FROM proyecto_grupo WHERE id_proy=".$cmbPROYECTO;
										$rs_pro = @pg_exec($conn,$sql);
										$fila_proy = @pg_fetch_array($rs_pro,0);
										if($fila_proy['tipo']==1){
											echo "PROYECTO DE INTEGRACIÓN";
										}else{
											echo "GRUPO DIFERENCIAL ";
										}
									?>
									
									&nbsp;</td>
                                  </tr>
                                </table>
								<br>
								<table width="650" border="0" align="center" cellpadding="3" cellspacing="5">
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">TRASTORNO</span></td>
                                  </tr>
								
                                  <tr>
                                    <td colspan="6" class="Estilo25"><span class="Estilo21">
                                      <? 	$sql = "SELECT id_dignos,nombre FROM diagnostico WHERE  tipo in(select tipo from proyecto_grupo where id_proy=".$cmbPROYECTO.") ORDER BY nombre ASC";
											$rs_diag = @pg_exec($conn,$sql);
											
											if($caso==1){ ?>
                                      <select name="cmbDIAGNOSTICO">
                                        <option value="0">seleccione</option>
                                        <? for($i=0;$i<@pg_numrows($rs_diag);$i++){
														$fila_dia = @pg_fetch_array($rs_diag,$i); 
														if($cmbDIAGNOSTICO==$fila_dia['id_dignos']){?>
                                        <option value="<?=$fila_dia['id_dignos'];?>" selected="selected">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? 	}else{ ?>
                                        <option value="<?=$fila_dia['id_dignos'];?>">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? }
													}?>
                                      </select>
                                      <? }elseif($caso==2){ ?>
                                      <select name="cmbDIAGNOSTICO">
                                        <option value="0">seleccione</option>
                                        <? for($i=0;$i<@pg_numrows($rs_diag);$i++){
														$fila_dia = @pg_fetch_array($rs_diag,$i); 
														if($fila_alumno['id_dignos']==$fila_dia['id_dignos']){?>
                                        <option value="<?=$fila_dia['id_dignos'];?>" selected="selected">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? 	}else{ ?>
                                        <option value="<?=$fila_dia['id_dignos'];?>">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? }
													}?>
                                      </select>
                                      <? }elseif($caso==4){
												  $sql = "SELECT id_dignos,nombre FROM diagnostico WHERE rdb=".$institucion." AND id_dignos=".$fila_alumno['id_dignos']." ORDER BY nombre ASC";
												 $rs_diag = @pg_exec($conn,$sql);
												 $fila_diag = @pg_fetch_array($rs_diag,0);
											 		echo $fila_diag['nombre'];	
											 } ?>
                                    </span></td>
                                  </tr>
								  
                                  <tr>
                                    <td colspan="6"><span class="Estilo22"></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">AVANCES</span></td>
                                  </tr>
                                  <tr>
                                    <td width="133" class="Estilo25"><span class="Estilo25">Mejora rendimiento<br> 
                                    Lenguaje </span></td>
                                    <td class="Estilo25">
									<? if($caso==1){?>	
										<select name="mejora_leng">
											<option value="1">Mejora rendimiento</option>
											<option value="2">Disminuye rendimiento</option>
											<option value="3">Sin avance</option>
										</select>								
										<!--<input name="mejora_leng" type="checkbox" value="1">-->
									<? }elseif($caso==2){?>	
									<select name="mejora_leng">
											<option value="1" <? echo ($fila_alumno['mejora_lenguaje']==1)?"selected":""?>>Mejora rendimiento</option>
											<option value="2" <? echo ($fila_alumno['mejora_lenguaje']==2)?"selected":""?>>Disminuye rendimiento</option>
											<option value="3" <? echo ($fila_alumno['mejora_lenguaje']==3)?"selected":""?>>Sin avance</option>
										</select>	
										<!--<input name="mejora_leng" type="checkbox" value="1" <? if($fila_alumno['mejora_lenguaje']==1) echo "checked=checked'";?>>-->
									<? }elseif($caso==4){
												if($fila_alumno['mejora_lenguaje']==1){
													echo "Mejora rendimiento";
												}elseif($fila_alumno['mejora_lenguaje']==2){
													echo "Disminuye rendimiento";
												}else{
													echo "Sin avance";
												}
									   		}		
									 	?>									</td>
                                    <td colspan="3" class="Estilo25"><span class="Estilo25">Mejora rendimiento <br>
  Matem&aacute;ticas</span></td>
                                    <td width="44" class="Estilo25">
									  <div align="left">
									    <? if($caso==1){?>	
										<select name="mejora_mat">
											<option value="1">Mejora rendimiento</option>
											<option value="2">Disminuye rendimiento</option>
											<option value="3">Sin avance</option>
										</select>	
									   <!-- <input name="mejora_mat" type="checkbox" value="1">-->
								        <? }elseif($caso==2){?>	
										<select name="mejora_mat">
											<option value="1" <? echo ($fila_alumno['mejora_matematica']==1)?"selected":""?>>Mejora rendimiento</option>
											<option value="2" <? echo ($fila_alumno['mejora_matematica']==2)?"selected":""?>>Disminuye rendimiento</option>
											<option value="3" <? echo ($fila_alumno['mejora_matematica']==3)?"selected":""?>>Sin avance</option>
										</select>	
									   <!-- <input name="mejora_mat" type="checkbox" value="1" <? if($fila_alumno['mejora_matematica']==1) echo "checked=checked'";?>>-->
								        <? }elseif($caso==4){
												if($fila_alumno['mejora_matematica']==1){
													echo "Mejora rendimiento";
												}elseif($fila_alumno['mejora_matematica']==2){
													echo "Disminuye rendimiento";
												}else{
													echo "Sin avance";
												}
									   		}		
								 	?>
							          </div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo22"></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">SITUACI&Oacute;N</span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo25">Aprobado</span></td>
                                    <td class="Estilo25">
									<? if($caso==1){?>	
										<input name="aprobado" type="checkbox" value="1">
									<? }elseif($caso==2){?>		
										<input name="aprobado" type="checkbox" value="1" <? if($fila_alumno['aprobado']==1) echo "checked=checked'";?>>
									<? }elseif($caso==4){
												if($fila_alumno['aprobado']==1)
													echo "SI";
												else
													echo "NO";
									   		}		
								 	?>									</td>
                                    <td width="143" class="Estilo25"><span class="Estilo25">Reprobado</span></td>
                                    <td width="20" class="Estilo25">
									<? if($caso==1){?>
										<input name="reprobado" type="checkbox" value="1">
									<? }elseif($caso==2){?>		
										<input name="reprobado" type="checkbox" value="1" <? if($fila_alumno['reprobado']==1) echo "checked=checked'";?>>
									<? }elseif($caso==4){
												if($fila_alumno['reprobado']==1)
													echo "SI";
												else
													echo "NO";
									   		}		
								 	?>									</td>
                                    <td width="113" class="Estilo25"><span class="Estilo25">Retirado</span></td>
                                    <td class="Estilo25">
									<? if($caso==1){?>
										<input name="retirado" type="checkbox" value="1">
									<? }elseif($caso==2){?>	
										<input name="retirado" type="checkbox" value="1" <? if($fila_alumno['retirado	']==1) echo "checked=checked'";?>>
									<? }elseif($caso==4){
												if($fila_alumno['retirado']==1)
													echo "SI";
												else
													echo "NO";
									   		}		
								 	?>									</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo22"></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">Informe</span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo25">Instituci&oacute;n que emite Informe </span></td>
                                    <td colspan="3"><span class="Estilo25">
                                      <? if($caso==1){?>
                                      <input name="txtINSTIT" type="text">
                                      <? }elseif($caso==2){ ?>
                                      <input name="txtINSTIT" type="text" value="<?=$fila_alumno['institucion'];?>">
                                      <? }elseif($caso==4){
											echo $fila_alumno['institucion'];	
								   		}		
								 	?>
                                    </span></td>
                                    <td colspan="2" class="Estilo25">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo25">Observaciones</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo25">
									<? if($caso==1){?>
										<textarea name="txtOBS" cols="50" rows="15"></textarea>
									<? }elseif($caso==2){ ?>		
										<textarea name="txtOBS" cols="50" rows="15"><?=$fila_alumno['obs'];?></textarea>
									<? }elseif($caso==4){
											echo nl2br($fila_alumno['obs']);	
								   		}		
								 	?>	
									</span></td>
                                  </tr>
                                </table>
								<? } ?>
								<br>
								<br>
                            </form></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema 
                de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
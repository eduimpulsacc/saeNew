<?	require('../../util/header.inc');
	

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 8;

	$caso=1;	
	if($cmbPERFIL!=0){
		$sql = "SELECT * FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL;
		$result = @pg_exec($conn,$sql);
		if(@pg_numrows($result) > 0){
			for($i=0;$i<@pg_numrows($result);$i++){
				$fila = @pg_fetch_array($result,$i);
				$perfil[$i]=$fila['id_item'];
			}
			$caso=2;
		}
	}
	/*$sql="SELECT id_reporte, nombre FROM reporte ORDER BY id_reporte ASC";
	$rs_menu =@pg_exec($conn,$sql);*/
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function enviapag(perfil){
	if(document.form.cmbPERFIL.value!=0){
		form.action='perfil_menu.php';
		form.submit(true);
	}
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
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
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
				<?	include("../../cabecera/menu_superior.php");?>				 				
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
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="left">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
									  <tr> 
										<td width="" height="30" align="center" valign="top"> <? include("../../cabecera/menu_inferior.php");?></td>	  
									  </tr> 
								  </table>
 								  								  
								  <form id="form" name="form" action="procesoMenuPerfil.php" method="post">
								  <input name="caso" type="hidden" value="<?=$caso;?>">
								    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td class="tableindex"><div align="center">PERMISOS PERFIL MEN&Uacute; </div></td>
                                      </tr>
                                    </table><br>
									<table width="650" border="0" align="center" cellpadding="0" cellspacing="5">
									  <tr>
										<td width="230"><div align="right" class="Estilo7">Perfil&nbsp;</div></td>
										<td width="150" class="Estilo10">
										<? 	$sql = "SELECT id_perfil,nombre_perfil FROM perfil WHERE id_perfil=".$cmbPERFIL;
											$rs_perfil = @pg_exec($conn,$sql);
											echo @pg_result($rs_perfil,1);
											
										?>
										&nbsp;</td>
										<td width="250"><div align="right">
										<? if($caso==1){ ?>
											  <input type="submit" name="Submit" value="AGREGAR" class="botonXX">
										<? } ?>
										
										 <? if($caso==2){?>
										  <input type="submit" name="Submit3" value="MODIFICAR" class="botonXX">
										  <input name="PERMISOS" type="button" onClick="window.location='permisosMenu.php'" value="PERMISOS" class="botonXX">
										 <? } ?>
										</div></td>
									  </tr>
									</table>
									<table width="100%" border="1" cellspacing="0" cellpadding="0">
									<? $sql = "SELECT id_menu,nombre FROM menu WHERE nivel=1";
										$rs_menu = @pg_exec($conn,$sql);
										for($i=0;$i<@pg_numrows($rs_menu);$i++){
											$fila_menu = @pg_fetch_array($rs_menu,$i);
											if($caso==2){
												$sql ="SELECT id_menu FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL." AND id_menu=".$fila_menu['id_menu'];
												$rs_existe_menu  = @pg_exec($conn,$sql); 
												if(@pg_numrows($rs_existe_menu)!=0){
													$activo_menu ="checked=checked";
												}else{
													$activo_menu ="&nbsp;";
												}
											}
									?>
                                      <tr>
                                        <td class="textosimple" width="10%">&nbsp;<? echo $i;?><input name="ck_menu<?=$i;?>" type="checkbox" value="<?=$fila_menu['id_menu'];?>" <?=$activo_menu;?>>&nbsp;<?=$fila_menu['nombre'];?></td>
                                        <td width="90%">
											<table width="100%" border="1" cellspacing="0" cellpadding="0">
											<? $sql = "SELECT id_categoria,nombre FROM menu_categoria WHERE id_menu=".$fila_menu['id_menu']." AND nivel=1";
												$rs_categoria =@pg_exec($conn,$sql);
												for($j=0;$j<@pg_numrows($rs_categoria);$j++){
													$fila_cat = @pg_fetch_array($rs_categoria,$j);
													if($caso==2){
														$sql ="SELECT id_menu FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL." AND id_menu=".$fila_menu['id_menu']." AND id_categoria=".$fila_cat['id_categoria'];
														$rs_existe_cat  = @pg_exec($conn,$sql); 
														if(@pg_numrows($rs_existe_cat)!=0){
															$activo_cat ="checked=checked";
														}else{
															$activo_cat ="&nbsp;";
														}
													}
											?>
										 	 <tr>
											 <? $sql ="SELECT id_item,nombre FROM menu_categ_item WHERE id_menu=".$fila_menu['id_menu']." AND id_categoria=".$fila_cat['id_categoria']." AND nivel=1";
												$rs_item = @pg_exec($conn,$sql);
												if(@pg_numrows($rs_item)==0){
													$rw=1;
													$wh="50%";
												}else{
													$rw=0;
													$wh="100%";
												}
											?>
												<td  width="50%%" class="textosimple" colspan="<?=$rw;?>" >&nbsp;<? echo $i."--".$j;?><input name="ck_categoria[<?=$i;?>][<?=$j;?>]" type="checkbox" value="<?=$fila_cat['id_categoria'];?>" <?=$activo_cat;?>>&nbsp;<?=$fila_cat['nombre'];?>
												</td>
												<? if($rw==1){?>
												<td width="<?=$wh;?>">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													  <tr>
														<td class="textosimple">&nbsp;<input name="ck_ingreso" type="checkbox" value="1">&nbsp;I&nbsp;</td>
														<td class="textosimple">&nbsp;<input name="ck_modifica" type="checkbox" value="1">&nbsp;M&nbsp;</td>
														<td class="textosimple">&nbsp;<input name="ck_elimina" type="checkbox" value="1">&nbsp;E&nbsp;</td>
														<td class="textosimple">&nbsp;<input name="ck_ver" type="checkbox" value="1">&nbsp;V&nbsp;</td>
													  </tr>
												  </table>
											   </td>
											<? } 
											   if(@pg_numrows($rs_item)!=0){?>
												<td width="<?=$wh;?>">
												<table width="100%" border="1" cellspacing="0" cellpadding="0">
												<? 
													for($x=0;$x<@pg_numrows($rs_item);$x++){
														$fila_item = @pg_fetch_array($rs_item,$x);
														if($caso==2){
														$sql ="SELECT id_menu FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL." AND id_menu=".$fila_menu['id_menu']." AND id_categoria=".$fila_cat['id_categoria']." AND id_item=".$fila_item['id_item'];
														$rs_existe_item  = @pg_exec($conn,$sql); 
														if(@pg_numrows($rs_existe_item)!=0){
															$activo_item ="checked=checked";
														}else{
															$activo_item ="&nbsp;";
														}
													}
												?>
												  <tr>
													<td  width="50%"class="textosimple">&nbsp;<? echo $i."---".$j."---".$x;?><input name="ck_item[<?=$i;?>][<?=$j;?>][<?=$x;?>]" type="checkbox" value="<?=$fila_item['id_item'];?>" <?=$activo_item;?>>&nbsp;<?=$fila_item['nombre'];?></td>
													<td width="50%">
												<table border="0" cellspacing="0" cellpadding="0" width="100%">
													  <tr>
														<td class="textosimple"><input name="ck_ingreso" type="checkbox" value="1">&nbsp;I&nbsp;</td>
														<td class="textosimple"><input name="ck_modifica" type="checkbox" value="1">&nbsp;M&nbsp;</td>
														<td class="textosimple"><input name="ck_elimina" type="checkbox" value="1">&nbsp;E&nbsp;</td>
														<td class="textosimple"><input name="ck_ver" type="checkbox" value="1">&nbsp;V&nbsp;</td>
													  </tr>
												  </table>
											   </td>
												  </tr>
												 <? }
												  ?>
												  <input name="contador_item[<?=$i;?>][<?=$j;?>]" type="hidden" value="<?=$x;?>">
												</table>

												</td>
												<? } ?>
											  </tr>
											 <? } ?>
											 <input name="contador_categoria<?=$i;?>" type="hidden" value="<?=$j;?>">
											</table>
										</td>
                                      </tr>
									 <? } ?>
									 <input name="contador_menu" type="hidden" value="<?=$i;?>">
                                    </table>
									<br>
									<br>
								 </form>
								  </td>
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
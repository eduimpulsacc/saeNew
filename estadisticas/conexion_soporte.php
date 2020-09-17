<?php 
	require('../util/header.inc');
	
	
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}
	
?>
<script language="javascript" type="text/javascript">
	function Valida(form){
		with (document.form){
			if(rdTIPO[0].checked==true){
				cmbPERFIL.disabled=true;
				rbPERFIL.disabled=true;
			}
			if(rdTIPO[1].checked==true){
				cmbPERFIL.disabled=false;
				rbPERFIL.disabled=false;
			}
			if(rbINSTIT[0].checked==true){
				cmbCORP.disabled=true;
				cmbINSTIT.disabled=false;
			}
			if(rbINSTIT[1].checked==true){
				cmbCORP.disabled=false;
				cmbINSTIT.disabled=true;
			}

		}
	}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="widgets/calendar-brown.css" title="green"/>
<script language="javascript" src="Calendario/javascripts.js"></script>
<script language="JavaScript" src="widgets/calendar.js"></script>
<script language="JavaScript" src="widgets/calendar-setup.js"></script>
<script language="JavaScript" src="widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="estadisticas/js/moodalbox.js"></SCRIPT>
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
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script language="javascript">
function visible(){
	if(document.form.rd_periodo[0].checked==true){
		document.form.cmbMES.style.visibility='visible';
		capa0.style.display='none';
		capa1.style.display='none';
	}else if(document.form.rd_periodo[1].checked==true){
		document.form.cmbMES.style.visibility='hidden';
		capa0.style.display='block';
		capa1.style.display='none';
	}else if(document.form.rd_periodo[2].checked==true){
		document.form.cmbMES.style.visibility='hidden';
		capa0.style.display='none';
		capa1.style.display='block';
	}
}
</script>
<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			include("../cabecera/menu_superior.php");
			?>	
				  
              </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						include("../menus/menu_lateral.php");
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
                                  <td>
								  <!-- INGRESO DE NUEVO CÓDIGO A LA PLANTILLA -->
								  <form name="form" action="InformeConexionSoporte.php" method="post" target="_blank" >
									<table width="650" border="0" align="center" cellpadding="5">
									  <tr>
										<td colspan="2" class="tableindex">BUSCADOR AVANZADO </td>
									  </tr>
									  <tr>
										<td colspan="2"  class="textosimple"><span style="text-decoration:underline;">TIPO INSTITUCION </td>
									  </tr>
									  <tr>
										<td colspan="2"  class="textosimple"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="5%"><input name="rbINSTIT" type="radio" value="1" checked onClick="Valida(this.form)"></td>
                                            <td width="95%"><span class="Estilo5">Particular o Particular Subvencionado </span>
											<select name="cmbINSTIT">
												<option value="0">Todos</option>
												<?	$sql = "SELECT rdb, nombre_instit FROM institucion WHERE rdb not in (SELECT rdb FROM corp_instit) ORDER BY nombre_instit ASC";
													$rs_instit = @pg_exec($conn,$sql);
													for($i=0;$i<@pg_numrows($rs_instit);$i++){
														$fila_instit = @pg_fetch_array($rs_instit,$i);
												?>
													<option value="<?=$fila_instit['rdb'];?>"><?=$fila_instit['nombre_instit'];?></option>
												<? } ?>
											</select>											</td>
                                          </tr>
                                          <tr>
                                            <td><input name="rbINSTIT" type="radio" value="2" onClick="Valida(this.form)"></td>
                                            <td><span class="Estilo5">Corporaci&oacute;n
                                                <select name="cmbCORP" disabled="disabled">
                                                  <? 	$sql = "SELECT num_corp,nombre_corp FROM corporacion ORDER BY nombre_corp ASC";
												$rs_corp = @pg_exec($conn,$sql);
												for($i=0;$i<@pg_numrows($rs_corp);$i++){
													$fila_corp = @pg_fetch_array($rs_corp,$i);
											?>	
                                                  <option value="<?=$fila_corp['num_corp'];?>">
                                                  <?=$fila_corp['nombre_corp'];?>
                                                  </option>
                                                  <? } ?>
                                               </select>
                                            </span></td>
                                          </tr>
                                        </table></td>
									  </tr>
									  <tr>
									    <td colspan="2"  class="textosimple"><span style="text-decoration:underline;">TIPO REPORTE </span></td>
								      </tr>
									  <tr>
									    <td colspan="2"  class="textosimple"><table width="50%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="12%"><input name="rdTIPO" type="radio" value="1" checked onClick="Valida(this.form)"></td>
                                              <td width="88%"><span class="Estilo5">Soporte</span></td>
                                            </tr>
                                            <tr>
                                              <td><input name="rdTIPO" type="radio" value="2"  onClick="Valida(this.form)"></td>
                                              <td><span class="Estilo5">Conexi&oacute;n</span></td>
                                            </tr>
                                          </table></td>
								      </tr>
									  <tr>
									    <td colspan="2"  class="textosimple"><span style="text-decoration:underline;">PERIODO</span></td>
								      </tr>
									  <tr>
									    <td colspan="2"  class="textosimple"><table width="50%" border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td><span class="Estilo5">FECHA DESDE </span></td>
                                            <td><span class="Estilo5">
                                              <label>
                                              <input name="txtMESD" type="text" size="5" maxlength="2">
                                            -
                                            <input name="txtANOD" type="text" size="5" maxlength="4"> 
                                            (mm-aaaa)                                              </label>
                                            </span></td>
                                          </tr>
                                          <tr>
                                            <td><span class="Estilo5">FECHA HASTA </span></td>
                                            <td><span class="Estilo5">
                                            <input name="txtMESH" type="text" size="5" maxlength="2">
                                            -
                                            <input name="txtANOH" type="text" size="5" maxlength="4">
                                            (mm-aaaa) </span></td>
                                          </tr>
                                        </table></td>
								      </tr>
									  <tr>
									    <td colspan="2"  class="textosimple"><span style="text-decoration:underline;">PERFILES</span></td>
								      </tr>
									  <tr>
									    <td colspan="2"  class="textosimple"><table width="50%" border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="12%"><input name="rbPERFIL" type="radio" value="1" checked  disabled="disabled"></td>
                                            <td width="88%"><select name="cmbPERFIL" disabled="disabled">
                                                <?	$sql = "SELECT id_perfil,nombre_perfil FROM perfil ORDER BY nombre_perfil ASC";
												$rs_perfil = @pg_exec($conn,$sql);
												for($i=0;$i < @pg_numrows($rs_perfil);$i++){
													$fila_perfil = @pg_fetch_array($rs_perfil,$i);
											?>
                                                <option value="<?=$fila_perfil['id_perfil'];?>">
                                                  <?=$fila_perfil['nombre_perfil'];?>
                                              </option>
                                                <? } ?>
                                              </select>
                                            </td>
                                          </tr>
                                        </table></td>
								      </tr>
									  <tr>
									    <td colspan="2"  class="textosimple">&nbsp;</td>
								      </tr>
									  <tr>
										<td>&nbsp;</td>
										<td><input type="submit" name="Submit" value="BUSCAR" class="botonXX"></td>
									  </tr>
									</table>
								    </form>
								  
								  <!-- FIN DEL NUEVO CODIGO DE LA PLANTILLA -->                                  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
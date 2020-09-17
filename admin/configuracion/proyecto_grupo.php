<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 2;
	$_bot = 8;
	

	if($caso==2 || $caso==1){
	$sql = "select a.*,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' '  as varchar) || ape_mat as empleado FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$institucion." AND id_proy=".$id_pro."";
	$rs_proy = @pg_exec($conn,$sql);
	$fila = @pg_fetch_array($rs_proy,0);
	}
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		/*if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}*/
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
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
function txt_ciclo(){
	document.form.txt_ciclo.focus();
}
function elimina_curso(id_curso,id_ciclo,ensenanza){
	window.location="procesa_ciclo.php?tipo=3&id_curso="+id_curso+"&id_ciclo="+id_ciclo+"&ensenanza="+ensenanza;
	//form.submit(true);
}
function Show_cursos(id_ciclo){
	var ensenanza = document.form.cmb_ensenanza.value;
	window.location="asignar_ciclo.php?tipo=2&id_ciclo="+id_ciclo+"&cmb_ensenanza="+ensenanza;
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
        <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>"></td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../cabecera/menu_superior.php");
				?></td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td valign="top"><!-- INCLUYO CODIGO DE LOS BOTONES -->
                              <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="" height="30" align="center" valign="top"></td>
                                </tr>
                              </table>
                            <form id="form" name="form" action="procesoProyectoGrupo.php" method="post">
                              <input name="caso" value="<?=$caso;?>" type="hidden">
                                <input name="id_pro" value="<?=$id_pro;?>" type="hidden">
                                <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                  <tr>
                                    <td colspan="3"><div align="right">
                                        <? if($caso==1){
											if($modifica==1){?>
                                        <input type="button" name="MODIFICAR" value="MODIFICAR" class="botonXX" onClick="window.location='proyecto_grupo.php?caso=2&id_pro=<?=$id_pro;?>'">
										<? 	}
											if($elimina==1){?>
                                        <input type="button" name="ELIMINAR" value="ELIMINAR" class="botonXX" onClick="window.location='procesoProyectoGrupo.php?caso=1&id_pro=<?=$id_pro;?>'">
										<? }
											if($modifica==1 || $ingreso==1){ ?>
										<input type="button" name="INSCRIBIR" value="INSCRIBIR" class="botonXX" onClick="window.location='inscribeAlumnosProyecto.php?caso=1&id_pro=<?=$id_pro;?>'">
                                        <? 	}
											} 
											if($caso==2 || $caso==3){?>
                                        <input type="submit" name="Submit" value="GUARDAR" class="botonXX">
                                        <? } ?>
                                        <input name="VOLVER" type="button" value="VOLVER" onClick="window.location='listaProyectoGrupo.php'" class="botonXX">
                                    </div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" class="tableindex">Proyecto de Integraci&oacute;n o grupo Diferencial </td>
                                  </tr>
                                  <tr>
                                    <td colspan="3">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="130"><span class="Estilo7">Nombre </span></td>
                                    <td width="7"><strong>:</strong></td>
                                    <td width="475"><span class="Estilo10">
                                      <? 	if($caso==1){
												echo $fila['nombre'];
										 	} 
										 	if($caso==2){?>
                                      <input name="txtNOMBRE" type="text" size="40" value="<?=$fila['nombre'];?>">
                                      <? } 
											if($caso==3){?>
                                      <input name="txtNOMBRE" type="text" size="40">
                                      <? } ?>
                                    </span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo7">Profesional a Cargo </span></td>
                                    <td><strong>:</strong></td>
                                    <td><span class="Estilo10">
                                      <?  $sql ="SELECT a.rut_emp,a.nombre_emp || CAST(' ' as varchar) || a.ape_pat || CAST(' ' as varchar) || a.ape_mat as nombre  ";
											$sql.="FROM empleado a INNER JOIN trabaja b ON a.rut_emp=b.rut_emp WHERE b.rdb=".$institucion." ORDER BY nombre asc ";
											$rs_empleado = @pg_exec($conn,$sql);
											
											if($caso==1){
												echo $fila['empleado'];
											}
											if($caso==2){											
										?>
                                      <select name="cmbEMPLEADO">
                                        <option value="0">seleccione</option>
                                        <? for($i=0;$i<pg_numrows($rs_empleado);$i++){
											$fila_emp = @pg_fetch_array($rs_empleado,$i); 
											if($fila['rut_emp']==$fila_emp['rut_emp']){?>
                                        <option value="<?=$fila_emp['rut_emp'];?>" selected="selected">
                                        <?=$fila_emp['nombre'];?>
                                        </option>
                                        <? }else{ ?>
                                        <option value="<?=$fila_emp['rut_emp'];?>">
                                        <?=$fila_emp['nombre'];?>
                                        </option>
                                        <? 	}
										} ?>
                                      </select>
                                      <? } 
											if($caso==3){ ?>
                                      <select name="cmbEMPLEADO">
                                        <option value="0">seleccione</option>
                                        <? for($i=0;$i<pg_numrows($rs_empleado);$i++){
											$fila = @pg_fetch_array($rs_empleado,$i); ?>
                                        <option value="<?=$fila['rut_emp'];?>">
                                        <?=$fila['nombre'];?>
                                        </option>
                                        <? } ?>
                                      </select>
                                      <? 	} ?>
                                      &nbsp;</span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo7">Objetivos</span></td>
                                    <td><strong>:</strong></td>
                                    <td><span class="Estilo10">
                                      <? 	if($caso==1){
												echo nl2br($fila['objetivo']);
											}
											if($caso==2){
										?>
                                      <textarea name="txtOBJETIVO" cols="30" rows="10"><?=$fila['objetivo'];?>
											</textarea>
                                      <? } 
											if($caso==3){?>
                                      <textarea name="txtOBJETIVO" cols="30" rows="10"></textarea>
                                      <? } ?>
                                    </span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo7">Tipo</span></td>
                                    <td><strong>:</strong></td>
                                    <td><span class="Estilo10">
                                      <label>
                                      <? if($caso==1){
												if($fila['tipo']==1) echo "PROYECTO DE INTEGRACIÓN"; else echo "GRUPO DIFERENCIAL";
											}
											if($caso==2){
										?>
                                      <select name="cmbTIPO">
                                        <option value="0">Seleccione</option>
                                        <? if($fila['tipo']==1){?>
                                        <option value="1" selected="selected">Proyecto de Integraci&oacute;n</option>
                                        <option value="2">Grupo Diferencial</option>
                                        <? }else{ ?>
                                        <option value="1">Proyecto de Integraci&oacute;n</option>
                                        <option value="2" selected="selected">Grupo Diferencial</option>
                                        <? } ?>
                                      </select>
                                      <? } 
										 	if($caso==3){?>
                                      <select name="cmbTIPO">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Proyecto de Integraci&oacute;n</option>
                                        <option value="2">Grupo Diferencial</option>
                                      </select>
                                      <? } ?>
                                      </label>
                                    </span></td>
                                  </tr>
                                </table>
                            </form></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php");?>SAE Sistema 
                de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
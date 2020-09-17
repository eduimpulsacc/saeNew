<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 5;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt1.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
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
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
                          <p>&nbsp;</p>
                          <table width="798" height="138" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tableindex">
                              
                              <td width="739">Instituci&oacute;n</td>
                            </tr>
                            <tr>
							  
                              <td align="center">  
								  <?  
								  for ($ipos=0;$ipos<=$i;$ipos++){
										//$cmb_insti[$ipos]=$_POST["cmb_insti_".$ipos];
										$cmb_insti=$_POST["cmb_insti".$ipos];
									}
									
									$sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
							  		$resultcorp= @pg_Exec($conn,$sqlcorp);
									$filacorp = @pg_fetch_array($resultcorp,0);
									$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
									$result2= @pg_Exec($conn,$sqlinsti);
									
								?>
							  <select name="cmb_insti" class="ddlb_9_x" onChange="enviapag(this.form);"s> 
							<option value=0 selected>(Seleccione Institucion)</option>
								 <?
								 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila = @pg_fetch_array($result2,$z); 
									
									if (($fila['rdb'] == $_POST["cmb_insti"]) or ($fila['rdb'] == $_POST["cmb_insti"])){
									   echo "<option value=".$fila['rdb']." selected>".$fila['nombre_instit']." </option>";
									}else{	    
									   echo "<option value=".$fila['rdb'].">".$fila['nombre_instit']." </option>";
									}
								 } ?>
                            </select>&nbsp;
		<div align="right">
          
        </div></td>
							
							<?
							$sqlano0="SELECT nro_ano,id_ano from ano_escolar where id_institucion=".$_POST["cmb_insti"]." order by id_ano desc";
							$resultano0= pg_exec($conn,$sqlano0);
							$filano0 = @pg_fetch_array($resultano0,0);
							?>
							</tr>
                                <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br><p><b>Año escolar:</b> <?= $filano0['nro_ano'];?>
                                  <br>
                                  <br>
                                </p></font>
                                  </td>
						    <tr>
							  <td height="36">
							  <table width="404" border="0" align="center" cellpadding="0" cellspacing="0">
							  
                                <tr>
                                  <td width="155" class="tableindex"><center><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Curso Nivel </font></center></td>
                                  <td width="239" height="26" class="tableindex"><center><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Cantidad Postulantes</font> </center></td>
                                </tr>
                                <?
								//echo $sql_curso="select count(*) as cuenta,grado from formulario_postulacion where formulario_postulacion.prefe_1=".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0  and id_ano=".$filano0['id_ano']." group by grado";
							
							$sql_curso="select count(*) as cuenta,grado from formulario_postulacion where formulario_postulacion.prefe_1=".$_POST["cmb_insti"]." and preferencia=1 and (id_estado = 0 Or id_estado =2)  group by grado";
							$resultado_query_cue = pg_exec($conn,$sql_curso);
							for($z=0 ; $z < @pg_numrows($resultado_query_cue) ; $z++){
							   		$fila2 = @pg_fetch_array($resultado_query_cue,$z);
									$grado= $fila2["grado"];
									
								if($grado==1){
									 $prefe1_1= $fila2["cuenta"];
								}
								if($grado==2){
									$prefe1_2= $fila2["cuenta"];
								}
								if($grado==3){
									$prefe1_3= $fila2["cuenta"];
								}
								if($grado==4){
									$prefe1_4= $fila2["cuenta"];
								}
							}
								
							$sql_curso2="select count(*) as cuenta,grado from formulario_postulacion where formulario_postulacion.prefe_2=".$_POST["cmb_insti"]." and preferencia=2 and (id_estado = 0 Or id_estado =2) group by grado";
							$resultado_query_cue = pg_exec($conn,$sql_curso2);
								for($z=0 ; $z < @pg_numrows($resultado_query_cue) ; $z++){
							   		$fila2 = @pg_fetch_array($resultado_query_cue,$z);
									$grado= $fila2["grado"];
									$prefe2= $fila2["cuenta"];
									if($grado==1){
										 $prefe2_1= $fila2["cuenta"];
									}
									if($grado==2){
										$prefe2_2= $fila2["cuenta"];
									}
									if($grado==3){
										$prefe2_3= $fila2["cuenta"];
									}
									if($grado==4){
										$prefe2_4= $fila2["cuenta"];
									}
								}
							$sql_curso3="select count(*) as cuenta,grado from formulario_postulacion where formulario_postulacion.prefe_3=".$_POST["cmb_insti"]." and preferencia=3 and (id_estado = 0 Or id_estado =2)  group by grado";
							$resultado_query_cue = pg_exec($conn,$sql_curso3);
								for($z=0 ; $z < @pg_numrows($resultado_query_cue) ; $z++){
							   		$fila2 = @pg_fetch_array($resultado_query_cue,$z);
									$grado= $fila2["grado"];
									$prefe3= $fila2["cuenta"];
									if($grado==1){
										 $prefe3_1= $fila2["cuenta"];
									}
									if($grado==2){
										$prefe3_2= $fila2["cuenta"];
									}
									if($grado==3){
										$prefe3_3= $fila2["cuenta"];
									}
									if($grado==4){
										$prefe3_4= $fila2["cuenta"];
									}

								}
							$sql_curso4="select count(*) as cuenta,grado from formulario_postulacion where formulario_postulacion.prefe_4=".$_POST["cmb_insti"]." and preferencia=4 and (id_estado = 0 Or id_estado =2) group by grado";
							$resultado_query_cue = pg_exec($conn,$sql_curso4);
								for($z=0 ; $z < @pg_numrows($resultado_query_cue) ; $z++){
							   		$fila2 = @pg_fetch_array($resultado_query_cue,$z);
									$grado= $fila2["grado"];
									$prefe4= $fila2["cuenta"];
									if($grado==1){
										 $prefe3_1= $fila2["cuenta"];
									}
									if($grado==2){
										$prefe4_2= $fila2["cuenta"];
									}
									if($grado==3){
										$prefe4_3= $fila2["cuenta"];
									}
									if($grado==4){
										$prefe4_4= $fila2["cuenta"];
									}
								}
							  ?>
                                <tr>
                                  <td><center>
                                    <font face="Verdana, Arial, Helvetica, sans-serif" size="1">NMI&nbsp;</font>
                                  </center></td>
                                  <td height="26" class="detalle"> <center><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?= $prefe1_1+$prefe2_1+$prefe3_1+$prefe4_1 ?></font></center></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font><center>
                                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">NM2
                                  </font>
                                  </center></td>
                                  <td height="26" class="detalle">&nbsp;<center><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?= $prefe1_2+$prefe2_2+$prefe3_2+$prefe4_2 ?></font></center></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font><center>
                                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">NM3
                                  </font>
                                  </center></td>
                                  <td height="26" class="detalle">&nbsp;<center><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?= $prefe1_3+$prefe2_3+$prefe3_3+$prefe4_3 ?></font></center></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font><center>
                                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">NM4
                                  </font>
                                  </center></td>
                                  <td height="26" class="detalle">&nbsp;<center><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?= $prefe1_4+$prefe2_4+$prefe3_4+$prefe4_4 ?></font></center></td>
                                </tr>
                                <? //} ?>
                              </table></td>
						    </tr>
                            <tr>
                              <td colspan="8">&nbsp;</td>
                            </tr>
							
                          </table>
                          <p>&nbsp;                          </p>
                        </form>&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

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

function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt5.php';
		form.submit(true);
	}	
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt7.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

				<?
				$sql_grado="select * from curso where id_curso=".$_POST["cmb_grado"];
				$resultgrado= @pg_Exec($conn,$sql_grado);
				$filagr = @pg_fetch_array($resultgrado,0);
				$grado=$filagr["grado_curso"];
									
				?>				
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
						
					  </td>
                      <td align="left" valign="top">
					  <form name="form" method="post" action="guardar_postulacion.php">
   <table>
   <tr>
      <td width="70" align="left" >&nbsp;</td>
							  <td width="153" align="left">&nbsp;</td>
                        <td width="149" align="left">&nbsp;</td>
                      </tr>
                                  <tr>
                                    <td colspan="3">
									<table width="700" height="151" cellpadding="0" cellspacing="0">
									<tr class="tableindex" align="center">
									<td colspan="6"><center>
									  TOTAL DE POSTULACIONES DE TODOS LOS ESTABLECIMIENTO
									</center></td>
									</tr>
									
                          <tr>
                            <td height="31" colspan="6" align="left">Institucion Origen 
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="cmb_insti" class="ddlb_9_x" onChange="enviapag(this.form);"s>
                                <? $sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
							  		$resultcorp= @pg_Exec($conn,$sqlcorp);
									$filacorp = @pg_fetch_array($resultcorp,0);
									$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
									$result2= @pg_Exec($conn,$sqlinsti);
									
								?>
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
								 } 
								 ?>
                              </select></td>
                          </tr>
									<tr>
									  <td width="326" height="19">&nbsp;</td>
									  <td colspan="5"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;
								</font>
&nbsp;									  </td>
									  </tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">A&ntilde;o:
									    <? $sql4="select nro_ano from  ano_escolar where id_ano =".$ano;
									$result3= pg_exec($conn,$sql4);
		        					$fila2 = @pg_fetch_array($result3,0); 
									echo $fila2["nro_ano"];
									?>
									  </font></td>
									  <td colspan="5">
									  &nbsp;<font face="Arial, Helvetica, sans-serif" size="2">&nbsp;
									  </font></td>
									  </tr>
									<tr>  
										<td colspan="9">
										</td>
									  </tr>
									<tr>
									  <td colspan="9">									 </td>
									  </tr>
									<tr class="tableindex" >
									  <td>&nbsp;</td>
									  <td colspan="5" align="center"><font face="Arial, Helvetica, sans-serif" size="2">Nivel</font></td>
									  </tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2"><b>Establecimiento Destino</b></font></td>
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>1</b></font></td>
									  <td width="147" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>2</b></font></td>
									  <td width="75" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>3</b></font></td>
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>4</b></font></td>
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>Total</b></font></td>
									</tr>
									<tr>
									<td>&nbsp;</td>
									</tr>
									<? 	$sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
										$resultcorp= @pg_Exec($conn,$sqlcorp);
										$filacorp = @pg_fetch_array($resultcorp,0);
										$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
										$result2= @pg_Exec($conn,$sqlinsti);
										 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
											{  
											$fila = @pg_fetch_array($result2,$z); 
									?>
									 <tr>
									 
									 <td><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<? echo $fila['nombre_instit']?></font></td>
									 <? 	$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=1";
									 		$prefe1= @pg_Exec($conn,$sqlprefe1);
											$filaprefe1_1 = @pg_fetch_array($prefe1,0);
											
											$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=2";
									 		$prefe2= @pg_Exec($conn,$sqlprefe2);
											$filaprefe1_2 = @pg_fetch_array($prefe2,0);
											
											$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=3";
									 		$prefe3= @pg_Exec($conn,$sqlprefe3);
											$filaprefe1_3 = @pg_fetch_array($prefe3,0);
											
											 $sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$fila['rdb']."  and rdb_origen=".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=4";
									 		$prefe4= @pg_Exec($conn,$sqlprefe4);
											$filaprefe1_4 = @pg_fetch_array($prefe4,0);
											
											/*******************************************************************************************************************/
											
											$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=1";
									 		$prefe1= @pg_Exec($conn,$sqlprefe1);
											$filaprefe2_1 = @pg_fetch_array($prefe1,0);
											
											 $sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=2";
									 		$prefe2= @pg_Exec($conn,$sqlprefe2);
											$filaprefe2_2 = @pg_fetch_array($prefe2,0);
											
											$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]."  and preferencia=2 and id_estado=0 and grado=3";
									 		$prefe3= @pg_Exec($conn,$sqlprefe3);
											$filaprefe2_3 = @pg_fetch_array($prefe3,0);
											
											$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=4";
									 		$prefe4= @pg_Exec($conn,$sqlprefe4);
											$filaprefe2_4 = @pg_fetch_array($prefe4,0);
											
											/**************************************************************************************************************
											$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and preferencia=2 and id_estado=0 and grado=1";
									 		$prefe2_1= @pg_Exec($conn,$sqlprefe1);
											$filaprefe1_1 = @pg_fetch_array($prefe2_1,0);
											
											$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and preferencia=2 and id_estado=0 and grado=2";
									 		$prefe2_2= @pg_Exec($conn,$sqlprefe2);
											$filaprefe1_2 = @pg_fetch_array($prefe2_2,0);
											
											$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and preferencia=2 and id_estado=0 and grado=3";
									 		$prefe2_3= @pg_Exec($conn,$sqlprefe3);
											$filaprefe1_3 = @pg_fetch_array($prefe2_3,0);
											
											$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila['rdb']." and preferencia=2 and id_estado=0 and grado=4";
									 		$prefe2_4= @pg_Exec($conn,$sqlprefe4);
											$filaprefe1_4 = @pg_fetch_array($prefe2_4,0);**/
											/**********************************************************************************************************************/
											$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=1";
									 		$prefe3_3= @pg_Exec($conn,$sqlprefe1);
											$filaprefe3_1 = @pg_fetch_array($prefe3_3,0);
											
											$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=2";
									 		$prefe3_3= @pg_Exec($conn,$sqlprefe2);
											$filaprefe3_2 = @pg_fetch_array($prefe3_3,0);
											
											$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=3";
									 		$prefe3_3= @pg_Exec($conn,$sqlprefe3);
											$filaprefe3_3 = @pg_fetch_array($prefe3_3,0);
											
											$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=4";
									 		$prefe3_4= @pg_Exec($conn,$sqlprefe4);
											$filaprefe3_4 = @pg_fetch_array($prefe3_4,0);
											/****************************************************************************************************************/
											$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_4= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=4 and id_estado=0 and grado=1";
									 		$prefe4_1= @pg_Exec($conn,$sqlprefe1);
											$filaprefe4_1 = @pg_fetch_array($prefe4_1,0);
											
											$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_4= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=4 and id_estado=0 and grado=2";
									 		$prefe4_2= @pg_Exec($conn,$sqlprefe2);
											$filaprefe4_2 = @pg_fetch_array($prefe4_2,0);
											
											$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_4= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=4 and id_estado=0 and grado=3";
									 		$prefe4_3= @pg_Exec($conn,$sqlprefe3);
											$filaprefe4_3 = @pg_fetch_array($prefe4_3,0);
											
											$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_4= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=4 and id_estado=0 and grado=4";
									 		$prefe4_4= @pg_Exec($conn,$sqlprefe4);
											$filaprefe4_4 = @pg_fetch_array($prefe4_4,0);
											/**********************************************************************************************************************/
											$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_5= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=5 and id_estado=0 and grado=1";
									 		$prefe5_1= @pg_Exec($conn,$sqlprefe1);
											$filaprefe5_1 = @pg_fetch_array($prefe5_1,0);
											
											$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_5= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=5 and id_estado=0 and grado=2";
									 		$prefe5_2= @pg_Exec($conn,$sqlprefe2);
											$filaprefe5_2 = @pg_fetch_array($prefe5_2,0);
											
											$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_5= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=4 and id_estado=0 and grado=3";
									 		$prefe5_3= @pg_Exec($conn,$sqlprefe3);
											$filaprefe5_3 = @pg_fetch_array($prefe5_3,0);
											
											$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_5= ".$fila['rdb']." and rdb_origen=".$_POST["cmb_insti"]." and preferencia=5 and id_estado=0 and grado=4";
									 		$prefe5_4= @pg_Exec($conn,$sqlprefe4);
											$filaprefe5_4 = @pg_fetch_array($prefe5_4,0);
									  ?>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?=$total1=$filaprefe1_1["cuenta"]+$filaprefe2_1["cuenta"]+$filaprefe3_1["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"]; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?=$total2=$filaprefe1_2["cuenta"]+$filaprefe2_2["cuenta"]+$filaprefe3_2["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"];?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?=$total3=$filaprefe1_3["cuenta"]+$filaprefe2_3["cuenta"]+$filaprefe2_3["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"]; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?=$total4=$filaprefe1_4["cuenta"]+$filaprefe2_4["cuenta"]+$filaprefe2_4["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"]; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?= $total1+$total2+$total3+$total4+$total5?></font></td>
									  
									 <? $totalgrado=$total1;
									 }?> 
									  </tr>
									 <tr>
									   <td>&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
								      </tr>
									 <tr>
									   <td><font face="Arial, Helvetica, sans-serif" size="2"><!--<b>Total Alumno Por curso </b><b>Total</b>--></font></td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
									   <td align="center">&nbsp;</td>
								      </tr>
									
									</table></td>
                                  </tr>
   </table>
                        </form>
					  &nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="24" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

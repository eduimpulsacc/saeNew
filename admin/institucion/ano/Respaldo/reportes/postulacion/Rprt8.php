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
		form.action = 'Rprt5.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
   <table width="894">
   <tr>
      <td width="150" align="left" >&nbsp;</td>
							  <td width="331" align="left">&nbsp;</td>
                              <td width="323" align="left">&nbsp;</td>
                            </tr>
                                  <tr>
                                    <td height="160" colspan="3">
									  <table width="926" height="161" cellpadding="0" cellspacing="0" border="1">
                                        <tr class="tableindex" align="center">
                                          <td colspan="20"><center>
                                              <font face="Arial, Helvetica, sans-serif" size="2"> TOTAL DE POSTULACIONES DE TODOS LOS ESTABLECIMIENTOS</font>
                                          </center></td>
                                        </tr>
                                        <tr class="textosimple">
                                          <td width="274"><font face="Arial, Helvetica, sans-serif" size="2">Año</font>&nbsp;</td>
                                          <td colspan="14"><font face="Arial, Helvetica, sans-serif" size="2">
                                            <? $sql4="select nro_ano from  ano_escolar where id_ano =".$ano;
									$result3= pg_exec($conn,$sql4);
		        					$fila2 = @pg_fetch_array($result3,0); 
									echo $fila2["nro_ano"];
									?>
                                      &nbsp;</font></td>
                                        </tr>
										
                                        <tr>
                                          <td height="19" colspan="3">&nbsp;</td>
                                          <td align="center" colspan="3">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><b>Establecimiento Destino</b></font> </td>
                                          <td colspan="3"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
                                          <!--<td width="186" colspan="3"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>-->
                                        </tr>
                                        <tr>
                                          <td height="29" colspan="3"><font face="Arial, Helvetica, sans-serif" size="2"><b>Establecimiento Origen</b> </font></td>
                                          <td align="center" colspan="3">
										  <table>   
										   <tr>
										   <? $sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
											$resultcorp= @pg_Exec($conn,$sqlcorp);
											$filacorp = @pg_fetch_array($resultcorp,0);
											$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
											$result2= @pg_Exec($conn,$sqlinsti);
											$cols=@pg_numrows($result2);
										 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
											{  
											$fila = @pg_fetch_array($result2,$z); 
											?>
                                          <td width="274" align="center" class="textoxsimple"><?= $fila['nombre_instit']?></td>
                                          <? } ?>
										  </tr>
										  </table>
										   </td>
                                          <td colspan="3"><font face="Arial, Helvetica, sans-serif" size="2"><b>Total Postulaciones </b></font></td>
                                          <!--<td width="186" colspan="3"><font face="Arial, Helvetica, sans-serif" size="2"><b>Total Alumnos que postulan </b></font></td>-->
                                        </tr>
										
										<? $sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
											$resultcorp= @pg_Exec($conn,$sqlcorp);
											$filacorp = @pg_fetch_array($resultcorp,0);
											$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
											$result2= @pg_Exec($conn,$sqlinsti);
											$cols=@pg_numrows($result2);
										 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
											{  
											$fila = @pg_fetch_array($result2,$z); 
											?>
                                        <tr>
                                          <td height="19" colspan="3" class="textosimple"><?= $fila["nombre_instit"] ?>&nbsp;</td>
                                          <td align="center" colspan="3">
										  <table>
										  <tr>
										 <? $i=0;
										 	$sqlinsti2="select * from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
											$result3= @pg_Exec($conn,$sqlinsti2);
										 for($w=0 ; $w < @pg_numrows($result3) ; $w++)
											{  
											$fila2 = @pg_fetch_array($result3,$w);
											 $sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$fila2['rdb']." and rdb_origen=".$fila['rdb']." and preferencia=1 and id_estado=0";
									 		$prefe1= @pg_Exec($conn,$sqlprefe1);
											$filaprefe1 = @pg_fetch_array($prefe1,0);
											
											
											 $sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$fila2['rdb']." and rdb_origen=".$fila['rdb']." and preferencia=2 and id_estado=0";
									 		$prefe2= @pg_Exec($conn,$sqlprefe1);
											$filaprefe2 = @pg_fetch_array($prefe2,0);
											
											
											 $sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$fila2['rdb']." and rdb_origen=".$fila['rdb']." and preferencia=3 and id_estado=0";
									 		$prefe3= @pg_Exec($conn,$sqlprefe1);
											$filaprefe3 = @pg_fetch_array($prefe3,0);
											
											
											 $sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_4= ".$fila2['rdb']." and rdb_origen=".$fila['rdb']." and preferencia=4 and id_estado=0";
									 		$prefe4= @pg_Exec($conn,$sqlprefe1);
											$filaprefe4 = @pg_fetch_array($prefe4,0);
											
											
											 $sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_5= ".$fila2['rdb']." and rdb_origen=".$fila['rdb']." and preferencia=5 and id_estado=0";
									 		$prefe5= @pg_Exec($conn,$sqlprefe1);
											$filaprefe5 = @pg_fetch_array($prefe5,0);
											?>	
											<td width="274" align="center" class="textosimple"><?= $filaprefe1["cuenta"]+$filaprefe2["cuenta"]+$filaprefe3["cuenta"]+$filaprefe4["cuenta"]+$filaprefe5["cuenta"]?>&nbsp;</td>
										 <? }?> 
										  </tr>
										  </table>
										  &nbsp;</td>
										  <? 
										  	 $sqltotalpos="select count (*) as cuenta from formulario_postulacion where rdb_origen=".$fila["rdb"]." and id_estado=0";
                                          	$result5= @pg_Exec($conn,$sqltotalpos);
											$fila5 = @pg_fetch_array($result5,0);?>
										  <td colspan="3" align="center" class="textosimple">&nbsp;
									      <?= $fila5["cuenta"]?></td>
                                          <!---<td colspan="3" align="center" class="textosimple">&nbsp;</td>-->
                                        </tr>  
										  <? } ?>
                                      </table>
                                    </td>
                                  </tr>
   </table>
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
          <td width="16" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

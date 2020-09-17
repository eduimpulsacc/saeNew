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
  <?
				$sql_grado="select * from curso where id_curso=".$_GET["cmb_grado"];
				$resultgrado= @pg_Exec($conn,$sql_grado);
				$filagr = @pg_fetch_array($resultgrado,0);
				$grado=$filagr["grado_curso"];
									
				?>				 
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>2</b></font></td>
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>3</b></font></td>
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>4</b></font></td>
									  <td width="50" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>Total</b></font></td>
									</tr>
									<tr>
									<td>&nbsp;</td>
									</tr>
									<? echo 	$sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
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
									 <? 
									 
									 	$sqlano="select id_ano from ano_escolar where nro_ano=".$fila2["nro_ano"]." and id_institucion=".$fila['rdb'];
										$result3= @pg_Exec($conn,$sqlano);
										$fila3 = @pg_fetch_array($result3,0);
										$sqlnivel="select id_curso,id_nivel from curso where id_ano=".$fila3["id_ano"]." and id_curso in(select id_curso from postulaciones)" ;
										$result4= @pg_Exec($conn,$sqlnivel);
										$count1=0;
										$count2=0;
										$count3=0;
										$count4=0;
										for($w=0 ; $w < @pg_numrows($result4) ; $w++){
											$filanivel = @pg_fetch_array($result4,$w);
										if($filanivel["id_nivel"]=="1"){
											$count1++;
											}
										if($filanivel["id_nivel"]=="2"){
											$count2++;
											}
										
										if($filanivel["id_nivel"]=="3"){
											$count3++;
											}
										if($filanivel["id_nivel"]=="4"){
											$count4++;
											}
										}
									  ?>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?=$count1; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?=$count2; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?=$count3; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?=$count4; ?></font></td>
									  <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<?= $count1+$count2+$count3+$count4;?></font></td>
									 <? }?> 
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
									   <td><font face="Arial, Helvetica, sans-serif" size="2"><b>Total</b></font></td>
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

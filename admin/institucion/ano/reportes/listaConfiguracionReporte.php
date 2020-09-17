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
	
	$ob_reporte = new Reporte();
	$ob_reporte->institucion=$institucion;
	$rs_reporte=$ob_reporte->BuscaReporte($conn);
		

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
					  <!--CUERPO DEL ARCHIVO--><!--FIN CUERPO DE ARCHIVO-->
					<table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0">
                          <tr>
                            <td><table width="457" border="0">
                                <tr>
                                  <td width="138" class="textonegrita">INSTITUCI&Oacute;N</td>
                                  <td width="10" class="textonegrita">:</td>
                                  <td width="295" class="textonegrita">&nbsp;
                                      <?=$Nombre_Ins;?></td>
                                </tr>
                                <tr>
                                  <td class="textonegrita">A&Ntilde;O ESCOLAR </td>
                                  <td class="textonegrita">:</td>
                                  <td class="textonegrita">&nbsp;
                                      <?=$nro_ano;?></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td><form name="form" action="configuracion_reporte.php" method="post">
                                <table width="100%" border="0">
                                  <tr>
                                    <td width="100%"><div align="right">
                                        <input type="button" name="agregar" class="botonXX" value="AGREGAR" onClick="window.location='configuracion_reporte.php'">
										<input name="volver" type="button"  class="botonXX" id="volver" value="VOLVER" onClick="window.location='Menu_Reportes_new2.php'">
                                    </div></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02" ><div align="center">LISTA CONFIGURACI&Oacute;N DE REPORTES </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro01"><table width="100%" border="1" align="center">
                                        <tr class="cuadro01">
                                          <td rowspan="2">REPORTE</td>
                                          <td rowspan="2">TIPO ENSE&Ntilde;ANZA </td>
                                          <td colspan="23"><div align="center">GRADOS EN QUE APLICA </div></td>
                                        </tr>
                                        <tr class="cuadro01">
                                          <td>1</td>
                                          <td>2</td>
                                          <td>3</td>
                                          <td>4</td>
                                          <td>5</td>
                                          <td>6</td>
                                          <td>7</td>
                                          <td>8</td>
                                          <td>9</td>
                                          <td>10</td>
                                          <td>11</td>
                                          <td>12</td>
                                          <td>13</td>
                                          <td>14</td>
                                          <td>15</td>
                                          <td>16</td>
                                          <td>23</td>
                                          <td>24</td>
                                          <td>25</td>
                                          <td>31</td>
                                          <td>32</td>
                                          <td>33</td>
                                          
                                        </tr>
                                        <? for($i=0;$i<pg_numrows($rs_reporte);$i++){
											$fila = pg_fetch_array($rs_reporte,$i);
											$ob_reporte->CambiaDatoReporte($fila);
											$ob_reporte->cod_tipo=$ob_reporte->ensenanza;
											$ob_reporte->TipoEnsenanza($conn);
											$ob_reporte->item_reporte=$fila['id_item'];
											$result =$ob_reporte->ListaReporte($connection);
											$nombre =@pg_result($result,0);
										?>
                                        <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('configuracion_reporte.php?cmbREPORTE=<?php echo $fila["id_item"];?>&id_config=<?=$fila['id_config'];?>&caso=1')>	
                                          <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$nombre;?></font></td>
                                          <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$ob_reporte->nombre;?></font></td>
                                          <td><? if($ob_reporte->grado1==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?>                                          </td>
                                          <td><? if($ob_reporte->grado2==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado3==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado4==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado5==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado6==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado7==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado8==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado9==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado10==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado11==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado12==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado13==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado14==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado15==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado16==0){ echo "&nbsp;"; }else{ ?>
                                              <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado23==0){ echo "&nbsp;"; }else{ ?>
                                            <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado25==0){ echo "&nbsp;"; }else{ ?>
                                            <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado16==0){ echo "&nbsp;"; }else{ ?>
                                            <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado31==0){ echo "&nbsp;"; }else{ ?>
                                            <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado32==0){ echo "&nbsp;"; }else{ ?>
                                            <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          <td><? if($ob_reporte->grado33==0){ echo "&nbsp;"; }else{ ?>
                                            <img src="../../cortes/visto-bueno2.png">
                                            <? }?></td>
                                          </tr>
                                        <? } ?>
                                    </table></td>
                                  </tr>
                                </table>
                            </form></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
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

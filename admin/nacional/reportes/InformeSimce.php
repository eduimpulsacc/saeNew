<?php require('../../../util/header.inc');?>
<?php 
	
	$institucion	=$_INSTIT;
	$_POSP = 3;
	
	$cmbANO = $_POST['cmbANO'];
	$menu = $_GET['menus'];
	
	if ($menu == ''){ $menu =0 ;	}
	
   $_MDINAMICO = 1;	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

function cargarinicio(x){ 
 var id = x;
 cargaContenido(id); 
 
	}

/*function enviapag(form){
			if (form.cmb_ensenanza.value!=0){
				form.cmb_ensenanza.target="self";
				form.action = 'InformeSimce.php';
				form.submit(true);
	
				}	
			}*/
			
function enviapag2(form){
			if (form.cmbANO.value==0){
				alert('Debe Seleccionar AÑO.');
				return false;
			}
			if (form.cmb_ensenanza.value==0){
				alert('Debe Seleccionar ENSEÑANZA.');
				return false;
			}
			if (form.cmb_grado.value==0){
				alert('Debe Seleccionar GRADO.');
				return false;
			}
			
				form.action = 'printResultadosSIMCE.php';
				form.submit(true);
	
				
			}
</script>

		<?php include('../../../util/rpc.php3');?>
	
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="select.js"></script>
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT></head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','file:///C|/Documents and Settings/Eduardo/Mis documento/coi/cortes/b_info_r.jpg','file:///C|/Documents and Settings/Eduardo/Mis documento/coi/cortes/b_mapa_r.jpg','file:///C|/Documents and Settings/Eduardo/Mis documento/coi/cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
	<center>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">
		  <form name="form" method="post">
		  <table width="61%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="3"  class="tableindex">Motor de b&uacute;squeda avanzado </td>
              </tr>
            <tr>
              <td width="33%"  class="cuadro01"> <div align="right">A&Ntilde;O</div></td>
              <td width="33%" class="cuadro01">&nbsp;
                <!--<select name="cmbANO" id="cmbANO">
				<option value="0">selecione...</option>
                <option value="2014" <? if($cmbANO==2014){?> selected="selected" <? }?>>2014</option>
                <option value="2013" <? if($cmbANO==2013){?> selected="selected" <? }?>>2013</option>
                <option value="2012" <? if($cmbANO==2012){?> selected="selected" <? }?>>2012</option>
                <option value="2011" <? if($cmbANO==2011){?> selected="selected" <? }?>>2011</option>
				<option value="2010" <? if($cmbANO==2010){?> selected="selected" <? }?>>2010</option>
                <option value="2009" <? if($cmbANO==2009){?> selected="selected" <? }?>>2009</option>
                <option value="2008" <? if($cmbANO==2008){?> selected="selected" <? }?>>2008</option>
                <option value="2007" <? if($cmbANO==2007){?> selected="selected" <? }?>>2007</option>
				<option value="2006" <? if($cmbANO==2006){?> selected="selected" <? }?>>2006</option>
				
              </select>-->  
               <?  $year = date("Y")-6;
					$year_act = date("Y");
				?>
                <select name="cmbANO">
                <? for($i=$year_act;$i>=$year;$i--){?>
	                <option value="<?=$i;?>"><?=$i;?></option>
             	<? } ?>
 				</select>  
                          </td>
              <td width="34%" class="cuadro01">&nbsp;</td>
            </tr>
            <tr>
              <td  class="cuadro01"><div align="right">ENSE&Ntilde;ANZA</div></td>
             <td class="cuadro01">
			 <? 
			  $sql="SELECT * FROM tipo_ensenanza WHERE cod_tipo IN (SELECT cod_tipo FROM tipo_ense_inst WHERE ";
			  $sql.="rdb = $institucion AND cod_tipo > 10) AND cod_tipo in (110,310) ORDER BY cod_tipo ASC";
			  $rs_ense = @pg_exec($conn,$sql);?>
              <select name="cmb_ensenanza" id="cmb_ensenanza" class="ddlb_9_x" onChange='cargaContenido(this.id)'>
			        <option value="0" selected>(Seleccione tipo enseñanza)</option>
			        <? 				  		  	 
										  for($i=0;$i<pg_numrows($rs_ense);$i++){
												$llenar_combo=pg_fetch_array($rs_ense,$i);
										  if($llenar_combo['cod_tipo']==$cmb_ensenanza){
						?>
			        <option value="<?=$llenar_combo['cod_tipo'];?>" selected="selected">
			          <?=$llenar_combo['nombre_tipo'];?>
			          </option>
			        <? }else{ ?>
			        <option value="<?=$llenar_combo['cod_tipo'];?>">
			          <?=$llenar_combo['nombre_tipo'];?>
			          </option>
			        <? }
								} ?>
			        </select>			 </td>
              <td class="cuadro01">&nbsp;</td>
            </tr>
            <tr>
              <td  class="cuadro01"><div align="right">GRADO</div></td>
              <td class="cuadro01">
			  <select disabled="disabled" name="cmb_grado" id="cmb_grado">									    
				<option value="0">Selecciona opci&oacute;n...</option>
				</select>
			  </td>
              <td class="cuadro01">&nbsp;</td>
            </tr>
            <tr>
              <td  class="cuadro01">&nbsp;</td>
              <td colspan="2" class="cuadro01"><input type="button" name="Submit" value="BUSCAR" class="botonXX" onClick="enviapag2(this.form);">
                &nbsp;&nbsp;                <input name="VOLVER" type="button" value="VOLVER" class="botonXX" onClick="window.location='../reportesCorporativos.php'"></td>
              </tr>
          </table>
		  </form>
		  
		  
		  </td>
        </tr>
      </table>
	</center>
	<!-- FIN DE INGRESO DE CODIGO NUEVO -->								  </td>
							   </tr>
							 </table>							  
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>

<?php require('../../util/header.inc');

$_POSP = 2;
$frmModo = "eliminar";

?>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
	function valida(form){
		if(!chkVacio(form.foto,'Debe seleccionar una foto')){
			return false;				
		};
		if(!chkVacio(form.titulo,'Ingrese título para la noticia del diario mural')){
			return false;
		};
		if(!chkVacio(form.detalle,'Ingrese detalle para la noticia del diario mural')){
			return false;
		};
		return true;
		document.frm.submit();
	}
</SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=5;
						 include("../../menus/menu_lateral.php");
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
                                  <td><br>

								   <!-- INSERTAMOS CODIGO NUEVO -->
							 
							 
							   <center>
<FORM method=post name="frm" action="ProcesoDiario.php" enctype="multipart/form-data">

<? if ($diario>0){?>
<input name="sw" type="hidden" value="1">
<? 

	$sqlDiario = "select * from diario_mural where id_diario = $diario";
	$rsDiario  = @pg_Exec($conn,$sqlDiario);
	$fDiario = @pg_fetch_array($rsDiario,0);	
	$titulo = $fDiario['titulo'];
	$detalle = $fDiario['detalle'];	

} else { ?>
<input name="sw" type="hidden" value="0">
<? } ?>
<input name="id_diario" type="hidden" value="<? echo $diario?>">
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	<INPUT name="submit" TYPE="submit" class="botonXX" id="submit" onClick="return valida(this.form);" value="GUARDAR">
	
	<? if ($diario != 0){ ?>
	     <INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name="btnEliminar" onClick=document.location="ProcesoDiario.php?sw=3&id_diario=<? echo $diario?>">
  	<? } ?>

	<INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnCancelar onClick=document.location="ListadoNoticias.php">	</td>
  </tr>
</table>

<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD align=center colspan=2 class="tableindex">
			Ingreso de Informaci&oacute;n Diario Mural</TD>
	</TR>
</table>
<br>
<table width="650" border="0" cellspacing="7" cellpadding="0">
  <tr>
    <td width="197" align="left" class="cuadro02"> Ingrese Foto</td>
    <td width="294"><input type="file" name="file"></td>
    <td width="93" align="left"><img src="images/<?php echo $fDiario['nom_foto']; ?>" alt="FOTO DIARIO MURAL" width="50" name="foto2"></td>
  </tr>
  
  <tr>
    <td colspan="0" align="left" class="cuadro02">Título</td>         
	<td colspan="2"><input name="titulo" type="text" size="80" maxlength="100" value="<? echo trim($titulo)?>"></td>
  </tr>
  <tr>
    <td colspan="0" align="left" class="cuadro02">Detalle</td>          
	<td colspan="2"><textarea name="detalle" cols="65" rows="10"><? echo strip_tags(trim($detalle))?></textarea></td>	
                                                        
  </tr>
</table>
</form>
</center>  
								  
							 <!-- FIN CODIGO NUEVO -->								</td>
								</tr>
								</table>  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php");?></td>
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

<?php require('../../util/header.inc');
	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$profesor		=$_USUARIO;
	$curso			=$_CURSO;	
	//--------------------------------
	$sqlProfe = "select empleado.* from usuario, empleado where usuario.id_usuario = ".$profesor." and empleado.rut_emp = usuario.nombre_usuario";
	$rsProfe = @pg_Exec($conn,$sqlProfe);
	$fProfe  = @pg_fetch_array($rsProfe,0); 
	$nombre_profe = trim(ucwords(strtolower(trim($fProfe['nombre_emp'])." ".trim($fProfe['ape_pat'])." ".trim($fProfe['ape_mat']))));
	$profesor = $fProfe['rut_emp'];	
	//--------------------------------
	$sqlInformacion = "select * from info_profesor where id_info = ".$id_info;
	$rsInformacion =@pg_Exec($conn,$sqlInformacion);
	$fInformacion  = @pg_fetch_array($rsInformacion,0);
	$fecha = Cfecha2($fInformacion['fecha']);
	$tipo = $fInformacion['tipo'];
	$descripcion = $fInformacion['descripcion'];
	//--------------------------------
?>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
	function valida(form){
		if(!chkSelect(form.tipo,'Debe Seleccionar Tipo de Información')){
				return false;
		};
		if(!chkVacio(form.descripcion,'Ingresar Descripción de la información')){
			return false;
		};
		if(!chkVacio(form.fecha,'Ingresar Fecha de Referencia')){
			return false;
		};
		
		if(!chkFecha(form.fecha,'Fecha de Referencia Inválida')){
			return false;
		};		
		return true;
	}
</SCRIPT>
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
</script>
<link href="../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../estilos.css" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
                 
								  
							     <form action="GrabaInfo.php"  name="info_form"  method="post" enctype="multipart/form-data">
<center>
<input name="rut_profe" type="hidden" value="<? echo $fProfe['rut_emp']?>">
<input type="hidden" name="id_info" value="<? echo $id_info ?>">
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >
	<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"   name=btnGuardar2 onClick=document.location="GrabaInfo.php?borrar=1&id_info=<? echo $fInformacion['id_info']?>" >
	<INPUT class="botonXX"  TYPE="button" value="VOLVER"   name=btnGuardar3 onClick=document.location="infoprofe.php" >	
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
<TR height=20 >
	<TD align="center" colspan=3 class="tableindex">
		INFORMACI&Oacute;N DEL PROFESOR 
	</TD>
<TR height=20 >
  <TD align="center" colspan=3><font face="arial, geneva, helvetica"  color="#000000"><?php echo $nombre_profe;?></font></TD>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>FECHA</strong></font></td>
  </tr>
  <tr>
    <td valign="middle">
	<input name="fecha" type="text" size="10" maxlength="10" value="<? echo $fecha?>">
	<font face="arial, geneva, helvetica" size="1" color="#000000"><strong>DD/MM/AAAA</strong></font>	</td>
  </tr>
  <tr>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>TIPO DE INFORMACI&Oacute;N </strong></font></td>
  </tr>
  <tr>
    <td>
      <select name="tipo">
	  	<option value="0" selected>(Seleccione Tipo)</option>
	  	<option value="1" <? if ($tipo==1){?> selected<? } ?>>Información General</option>
	  	<option value="2" <? if ($tipo==2){?> selected<? } ?>>Fecha de Pruebas</option>				
      </select>
    </td>
  </tr>
  <tr>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>DESCRIPCI&Oacute;N</strong></font></td>
  </tr>
  <tr>
    <td>
      <textarea name="descripcion" cols="50" rows="4" ><? echo strip_tags(trim($descripcion))?></textarea>	</td>
  </tr>
</table>
</center>
</form>	  
								  
								  <!-- fin codigo antiguo --></td>
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
          <td width="53" align="left" valign="top" background="../../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

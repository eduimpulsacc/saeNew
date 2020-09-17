<? 	require('../../../util/header.inc');
$frmModo		=$_FRMMODO;
$soporte		=$_SOPORTE;
$_POSP =3;
$_MDINAMICO = 1;
?>
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
		function valida(form){
			if(!chkVacio(form.nombre,'Ingresar NOMBRE DE CONTACTO.')){
				return false;
			};
			if(!chkVacio(form.mail,'Ingresar E-MAIL DE CONTACTO.')){
				return false;
			};
			if(!isEmail(form.mail,'Formato de E-MAIL erroneo.')){
				return false;
			};
			if(!chkVacio(form.fono,'Ingresar TELEFONO DE CONTACTO.')){
				return false;
			};
			if(!nroOnly(form.fono,'Solo números en TELEFONO DE CONTACTO.')){
				return false;
			};		
			if(!chkSelect(form.cmbPROBLEMA,'Seleccionar TIPO DE PROBLEMA.')){
				return false;
			};
			if(!chkVacio(form.observ,'Ingresar OBSERVACIÓN.')){
				return false;
			};
					
			return true;
		}
			
		function MM_goToURL() { //v3.0
		  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
		  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
		}
									
</script>
<? 
if($frmModo=="modificar"){
	$qry = "";
	$qry = "SELECT soporte.*, tipo_problema.nombre FROM soporte INNER JOIN tipo_problema ON soporte.id_problema=tipo_problema.id_problema WHERE id_soporte=" . $soporte;
	$Rs_Soporte = pg_exec($conn,$qry);
	$filaSop	= pg_fetch_array($Rs_Soporte,0);
}

//--------------- COMBO TIPO DE PROBLEMA------------
$qry ="";
$qry = "SELECT * FROM tipo_problema ";
$Rs_Problema = pg_exec($conn,$qry);

//------------- COMBO PERSONAL DE SOPORTE ----------
$qry = "";
$qry = "SELECT * FROM personal_soporte";
$Rs_Personal = pg_exec($conn,$qry);

//------------- COMBO DE ESTADO --------------------
$qry = "";
$qry = "SELECT * FROM estado ";
$Rs_Estado = pg_exec($conn,$qry);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../Sea/estilos.css" rel="stylesheet" type="text/css">
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
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
							
<form action="../../../procesoSoporte.php3" name="form" method="post">
<input name="soporte" type="hidden" value="<? echo $soporte;?>">
<input name="soporte" type="hidden" value="<? echo $soporte;?>">
<input name="soporte" type="hidden" value="<? echo $soporte;?>">
<table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
  	<td align="right">

	<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" onClick="return valida(this.form);">
	
	</td>
  </tr>
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr class="tableindex"> 
            <td colspan="3"> 
              <div align="center">SOPORTE</div></td>
          </tr>
          <tr> 
            <td colspan="3" align="right">&nbsp; </td>
          </tr>
          <tr> 
            <td><font size="1" face="arial, geneva, helvetica">&nbsp; NOMBRE</font></td>
            <td colspan="2"><font size="1" face="arial, geneva, helvetica">&nbsp; 
              &nbsp; MAIL</font></td>
          </tr>
          <tr> 
            <td><font size="2" face="arial, geneva, helvetica"> &nbsp; 
			<?	if($frmModo=="ingresar"){ ?>
					<input type="text" name="nombre">
			<? }
				if($frmModo=="modificar"){
					echo "<strong>". $filaSop['contacto']."</strong>";
				}
			?>
              </font></td>
            <td colspan="2"><font size="2" face="arial, geneva, helvetica"> &nbsp; 
			<? if($frmModo=="ingresar"){?>
					<input type="text" name="mail">
			<? }
				if($frmModo=="modificar"){
					echo "<strong>".$filaSop['mail']."</strong>";
				}
			?>
              </font><font size="1" face="arial, geneva, helvetica">&nbsp; </font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="2" face="arial, geneva, helvetica">&nbsp;</font></td>
          </tr>
          <tr> 
            <td><font size="1" face="arial, geneva, helvetica">&nbsp;FONO</font></td>
            <td colspan="2"><font size="1" face="arial, geneva, helvetica">TIPO 
              PROBLEMA</font></td>
          </tr>
          <tr> 
            <td><font size="2" face="arial, geneva, helvetica">&nbsp; 
			<? 	if($frmModo=="ingresar"){ ?>
					<input name="fono" type="text" size="15" maxlength="10">
			<? }
				if($frmModo=="modificar"){
					echo "<strong>".$filaSop['fono']."</strong>";
				}
			?>
              </font></td>
            <td colspan="2"><font size="2" face="arial, geneva, helvetica">&nbsp; 
			<? if($frmModo=="ingresar"){ ?>
			   <select name="cmbPROBLEMA">
                <option value=0 selected>Selecione Problema</option>
                <? for($i=0 ; $i < @pg_numrows($Rs_Problema) ; $i++){
					$fila = @pg_fetch_array($Rs_Problema,$i);
						if ($fila["id_problema"]==$cmbPROBLEMA){
							echo  "<option selected value=".$fila["id_problema"]." >".$fila["nombre"]."</option>";
						}else{
							echo  "<option value=".$fila["id_problema"]." >".$fila["nombre"]."</option>";
						}
									
					}
				}
				if($frmModo=="modificar"){
					echo "<strong>". $filaSop['nombre']. "</strong>";
			}
			?>
              </select>
              </font><font size="2" face="arial, geneva, helvetica">&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="2" face="arial, geneva, helvetica">&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1" face="arial, geneva, helvetica">&nbsp;OBSERVACI&Oacute;N</font></td>
          </tr>
          <tr> 
            <td colspan="3">&nbsp; 
			<? 	if($frmModo=="ingresar"){?>
					<textarea name="observ" cols="60" rows="5"></textarea></td>
			<? }
				if($frmModo=="modificar"){
					echo "<strong>". nl2br($filaSop['observacion']). "</strong>";
			 } ?>
          </tr>
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <? if(($frmModo=="modificar")&&($_PERFIL==0)){?>
		  <tr> 
            <td colspan="2"><font size="1" face="arial, geneva, helvetica">&nbsp; ESTADO</font></td>
            <td><font size="1" face="arial, geneva, helvetica">&nbsp; ATENDIDO POR</font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp; <select name="cmbESTADO">
                <option value=0 selected>Selecione Estado </option>
                <? for($i=0 ; $i < @pg_numrows($Rs_Estado) ; $i++){
					$fila = @pg_fetch_array($Rs_Estado,$i);
						if ($fila['id_estado']==$filaSop['id_estado']){
							echo  "<option selected value=".$fila['id_estado']." >".$fila["nombre"]."</option>";
						}else{
							echo  "<option value=".$fila["id_estado"]." >".$fila["nombre"]."</option>";
						}
									
				}
			?>
              </select></td>
            <td>&nbsp; <select name="cmbPERSONAL">
                <option value=0 selected>Selecione Personal </option>
                <? for($i=0 ; $i < @pg_numrows($Rs_Personal) ; $i++){
					$fila = @pg_fetch_array($Rs_Personal,$i);
						if ($fila["id_atendido"]==$filaSop['id_atencion']){
							echo  "<option selected value=".$fila["id_atendido"]." >".$fila["nombre"]."</option>";
						}else{
							echo  "<option value=".$fila["id_atendido"]." >".$fila["nombre"]."</option>";
						}
									
				}
			?>
              </select></td>
          </tr>
		  <? } ?>
        </table>
      </td>
  </tr>
</table>
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
          <td width="53" align="left" valign="top" background="../../../Sea/<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

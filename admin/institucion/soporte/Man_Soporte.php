<? 	require('../../../util/header.inc');
$frmModo		=$_FRMMODO;
$soporte		=$_SOPORTE;
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
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="procesoSoporte.php3" name="form" method="post">
<input name="soporte" type="hidden" value="<? echo $soporte;?>">
<input name="soporte" type="hidden" value="<? echo $soporte;?>">
<input name="soporte" type="hidden" value="<? echo $soporte;?>">
<table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
  	<td align="right">

	<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" onclick="return valida(this.form);">
	
	</td>
  </tr>
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="003b85"> 
            <td colspan="3"> 
              <div align="center"><font color="#FFFFFF"><strong>SOPORTE</strong></font></div></td>
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
              </font><font size="1" face="arial, geneva, helvetica"> &nbsp;</font></td>
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
<br>
<table width="599" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#48d1cc">
  <tr> 
    <td width="599"><ul>
        <li><font size="1" face="arial, geneva, helvetica">Ingrese los datos y 
          personal de soporte se contactar&aacute; con Usted a la brevedad</font></li>
        <li><font size="1" face="arial, geneva, helvetica">Favor ingresar un telef&oacute;no 
          o un mail para contacto</font></li>
      </ul></td>
  </tr>
</table>

</body>
</html>

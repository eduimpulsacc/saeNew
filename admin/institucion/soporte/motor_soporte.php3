<?  require('../../../util/header.inc');
	require('../../../util/LlenarCombo.php3');
	require('../../../util/SeleccionaCombo.inc');

	$institucion	=$_INSTIT;
	$qry = "";
	$qry = "SELECT * FROM estado ";
	$Rs_Soporte = pg_exec($conn,$qry);
			
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
		function valida(form){
			if (form.txtDesde.value!=""){
			
				if(!chkFecha(form.txtDesde,'Fecha Inicio inválida.')){
					return false;
				};
				if(!chkVacio(form.txtHasta,'Ingresar FECHA TERMINO.')){
					return false;
				};
				if(!chkFecha(form.txtHasta,'Fecha Término inválida.')){
					return false;
				};
				if(amd(form.txtDesde.value)>=amd(form.txtHasta.value)){
					alert("Fecha de término no puede ser menor o igual a la Fecha de inicio");
					return false;
				}
				
			}
			if(form.txtHasta.value!=""){
				if(!chkVacio(form.txtDesde,'Ingresar FECHA INICIO.')){
					return false;
				};
				if(!chkFecha(form.txtDesde,'Fecha Inicio inválida.')){
					return false;
				};
				if(!chkFecha(form.txtHasta,'Fecha Término inválida.')){
					return false;
				};
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtDesde.value)>=amd(form.txtHasta.value)){
					alert("Fecha de término no puede ser menor o igual a la Fecha de inicio");
					return false;
				}
			}
			return true;
		}
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<link href="../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../Colegio_restore/util/objeto.css" rel="stylesheet" type="text/css">
<link href="../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<form method "post" action="listadoSoporte.php3" target="mainFrame">
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="701" bgcolor="003b85"><div align="center"><font color="#FFFFFF" size="1" face="arial, geneva, helvetica">Buscador 
                  Avanzado </font></div></td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="80"><font size="1" face="arial, geneva, helvetica">Fecha desde</font></td>
                    <td width="94" class="text_9_x_100"><input name="txtDesde" type="text" size="15" maxlength="10"></td>
                    <td width="19"><font size="1" face="arial, geneva, helvetica">&nbsp;</font></td>
                    <td width="82"><font size="1" face="arial, geneva, helvetica">Fecha Hasta</font></td>
                    <td width="133"><font size="1" face="arial, geneva, helvetica"><input name="txtHasta" type="text" size="15" maxlength="10"></font></td>
                    <td width="43"><font size="1" face="arial, geneva, helvetica">Estado</font></td>
                    <td width="167" >&nbsp; <select name="cmbESTADO">
                        <option value=0 selected>Selecione Estado </option>
                        <? for($i=0 ; $i < @pg_numrows($Rs_Soporte) ; $i++){
							$fila = @pg_fetch_array($Rs_Soporte,$i);
						if ($fila["id_estado"]==$cmbESTADO){
							echo  "<option selected value=".$fila["id_estado"]." >".$fila["nombre"]."</option>";
						}else{
							echo  "<option value=".$fila["id_estado"]." >".$fila["nombre"]."</option>";
						}
									
				}
			?>
                      </select> </td>
                    <td width="83"><div align="right"> 
                        <input name="cb_ok" type="submit" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" value="Buscar" onclick="return valida(this.form);">
					  </div></td>
                  </tr>
                </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
</body>
</html>


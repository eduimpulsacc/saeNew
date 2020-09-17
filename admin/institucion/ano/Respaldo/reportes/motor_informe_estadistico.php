<?  require('../../../../util/header.inc');
	require('../../../../util/LlenarCombo.php3');
	require('../../../../util/SeleccionaCombo.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
  
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_docente.value!=0){
				form.cmb_docente.target="self";
				form.action = 'motor_informe_estadistico.php?cmb_docente=<? echo $cmb_docente;?>';
				form.submit(true);
	
				}	
			}			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
</script>

<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">

<link href="../../../../../coe_prueba/admin/institucion/Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../coe_prueba/admin/institucion/Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-top: 0px;
}
-->
</style></head>

<body>
<form  action="" method="post" >
<?php 
//------------------------------------------------
$sql_docente = "select rut_emp, nombre_emp, ape_pat, ape_mat from empleado where rut_emp in (SELECT DISTINCT (e.rut_emp) FROM empleado as e INNER JOIN dicta as d ON e.rut_emp=d.rut_emp INNER JOIN trabaja as t ON e.rut_emp=t.rut_emp WHERE rdb=".$institucion.") ORDER BY ape_pat, ape_mat, nombre_emp ";
$result_docente = @pg_exec($conn,$sql_docente);

?>
<center>
    <table width="800" height="60" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
    <td width="800" height="76" valign="top">
	<table width="800" height="60" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
    <td height="20" colspan="2" class="titulosMotores">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27" colspan="2">
	<table width="800" border="0" cellspacing="0" cellpadding="0">
                  <tr>
    <td width="69" height="20" class="textosmediano">Docente</td>
    <td width="272" height="20">
	  <div align="left">	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_docente" class="ddlb_9_x" onChange="enviapag(this.form);">
          <option value=0 selected>(Seleccione Docente)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($result_docente) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_docente,$i); 
		  if(trim($fila['rut_emp'])==trim($cmb_docente)){
			echo  "<option  value=".$fila['rut_emp']." selected >".$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp']."</option>";
			}else{
			echo  "<option value=".$fila['rut_emp']." >".$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp']."</option>";
			}
		  ?>
          <? } ?>
        </select>
</font>	  </div>
	</td>
                    <td width="61" height="20" class="textosmediano">Subsector</td>
                    <td width="219" height="20"><font size="1" face="arial, geneva, helvetica">
                      <select name="cmb_subsector" class="ddlb_9_x">
                        <option value=0 selected>(Seleccione Subsector)</option>
                        <?
						//------------------------------------------------
						$sql_subsector = "SELECT DISTINCT s.nombre,s.cod_subsector FROM subsector AS s INNER JOIN ramo AS r ON r.cod_subsector=s.cod_subsector INNER JOIN dicta AS d ON d.id_ramo=r.id_ramo WHERE d.rut_emp='".$cmb_docente."' ";
						$result_subsector = @pg_exec($conn,$sql_subsector);
						//------------------------------------------------

						  for($k=0 ; $k < @pg_numrows($result_subsector) ; $k++)
						  {
						  	$fila2 = @pg_fetch_array($result_subsector,$k); 
							echo "<option  value=".$fila2['cod_subsector']." selected >".$fila2['nombre']."</option>";
							
						  } ?>
                      </select>
                    </font></td>
    <td width="80" height="20"><div align="right">
	  <input name="cb_ok" type="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'mainFrame\']','informe_estadistico.php?docente='+cmb_docente.options[cmb_docente.selectedIndex].value+'&subsector='+cmb_subsector.options[cmb_subsector.selectedIndex].value+'&periodo='+cmb_periodo.options[cmb_periodo.selectedIndex].value);return document.MM_returnValue" value="Buscar"> 
    </div></td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
    <td width="78" height="20" class="textosmediano">Periodo</td>
    <td width="722" height="20" valign="top"><select name="cmb_periodo" class="ddlb_9_x">
      <option value=0 selected>(Seleccione Periodo)</option>
      <?
	  //------------------------------------------------
		$sql_periodo = "select * from periodo where id_ano = ".$ano;
		$result_periodo = @pg_exec($conn,$sql_periodo);
		//------------------------------------------------

		  for($j=0 ; $j < @pg_numrows($result_periodo) ; $j++)
		  {
			  $fila3 = @pg_fetch_array($result_periodo,$j); 
			  echo  "<option  value=".$fila3["id_periodo"]." selected>".$fila3['nombre_periodo']."</option>";
		  } ?>
    </select></td>
  </tr>
</table>	</td>
  </tr>
</table>
</center>
</form>
</body>
</html>


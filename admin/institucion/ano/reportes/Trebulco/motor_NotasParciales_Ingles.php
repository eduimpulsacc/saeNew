<?  require('../../../../../util/header.inc');
	require('../../../../../util/LlenarCombo.php3');
	require('../../../../../util/SeleccionaCombo.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<SCRIPT language="JavaScript">
			function enviapag(form){
				if (form.cmb_curso.value!=0){
					form.cmb_curso.target="self";
					form.action = 'motor_NotasParciales_Ingles.php?institucion=$institucion';
					form.submit(true);
				}	
			}

			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<form method "post" action="">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="53%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%">
	<table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="53%" class="titulosMotores">Search </td>
  </tr>
  <tr>
    <td height="27">
	<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="39" class="textosmediano">Class</td>
    <td width="123">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
          <option value=0 selected>(Select Class)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
				if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option selected value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option selected value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option selected value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		  
  		  }else{
		  		if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		
		  }
          } ?>
        </select>
</font>	  </div></td>
    <td width="51" class="textosmediano">Period</td>
    <td width="125"><select name="cmb_periodos" class="ddlb_9_x">
			<option value=0 selected>(Select Period)</option>
       <?
	   
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
			  $fila = @pg_fetch_array($result_peri,$i); 
				$periodo_nuevo= trim(strtoupper($fila['nombre_periodo'])) ;
				if( !strcasecmp($periodo_nuevo,"PRIMER TRIMESTRE")  ){
					$periodo_nuevo="FIRST TRIMESTER"; }
				if( !strcasecmp($periodo_nuevo,"SEGUNDO TRIMESTRE")  ){
					$periodo_nuevo="SECOND TRIMESTER"; }
				if( !strcasecmp($periodo_nuevo,"TERCER TRIMESTRE")  ){
					$periodo_nuevo="THIRD TRIMESTER"; }
				if( !strcasecmp($periodo_nuevo,"PRIMER SEMESTRE")  ){
					$periodo_nuevo="FIRST SEMESTER"; }
				if( !strcasecmp($periodo_nuevo,"SEGUNDO SEMESTRE")  ){
					$periodo_nuevo="SECOND SEMESTER"; }
	
			  if ($fila['id_periodo']==$cmb_periodos)
				echo  "<option selected value=".$fila["id_periodo"]." >".$periodo_nuevo."</option>";
			  else
				echo  "<option value=".$fila["id_periodo"]." >".$periodo_nuevo."</option>";
			  ?>
	   <? } ?>
    </select></td>
    <td width="199"><div align="right">
      <input name="cb_ok" type="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'mainFrame\']','NotasParciales_Ingles.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Search">
    </div></td>
  </tr>
  <tr>
    <td class="textosmediano">Name</td>
    <td>
	<div align="left">
	  		
      <select name="cmb_alumno" class="ddlb_9_x">
		<option value=0 selected>(All Names)</option>
		<?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
			<option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
			<?
		}
		?>
      </select>
    </div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>

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


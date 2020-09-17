<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$c_periodos;
	$curso			=$c_curso;
	$subsector		=$c_alumno;
	$sw				=0;
	if ($curso>0 and $periodo>0)
		$sw = 1;
	if ($sw == 0)
		exit;
		

//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<form method="post" target="mainFrame">
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="right">
	<div id="capa0">
      <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	 </div>
    </div></td>
  </tr>
</table>
<?
	//------------------- SUBSECTOR ---------------------------------------------------------------------
	if ($subsector==0)
		$sql_sub = "select ramo.id_ramo, subsector.nombre, ramo.modo_eval from subsector, ramo where ramo.id_curso = ".$curso." and ramo.cod_subsector = subsector.cod_subsector";
	else
		$sql_sub = "select ramo.id_ramo, subsector.nombre, ramo.modo_eval from subsector, ramo where ramo.id_ramo = ".$subsector." and ramo.cod_subsector = subsector.cod_subsector";
	
	$result_sub =@pg_Exec($conn,$sql_sub);

$registros = @pg_numrows($result_sub);
for($i=0 ; $i < $registros ; $i++)
{
	$cadena01=""; $cadena02=""; $cadena03="";$cadena04=""; $cadena05="";
	$cadena06=""; $cadena07=""; $cadena08="";$cadena09=""; $cadena10="";
	$cadena11=""; $cadena12=""; $cadena13="";$cadena14=""; $cadena15="";
	$cadena16=""; $cadena17=""; $cadena18="";$cadena19=""; $cadena20="";		
	$fila_sub = @pg_fetch_array($result_sub,$i);	
	$subsector = $fila_sub['id_ramo'];
	$subsector_pal = ucwords(strtoupper(trim($fila_sub['nombre'])));	
	$modo = $fila_sub['modo_eval'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];
	//---------------- ANO ESCOLAR ------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//----------------- PERIODO -----------------------------------------------------------------------
	$sql_per = "select * from periodo where id_periodo = ".$periodo;
	$result_per =@pg_Exec($conn,$sql_per);
	$fila_per = @pg_fetch_array($result_per,0);	
	$nom_per = $fila_per['nombre_periodo'];
	//------------------- CURSO ---------------------------------------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//------------------- PROFESOR RAMO -----------------------------------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((dicta.id_ramo)=".$subsector.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);	
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profesor = ucwords(strtoupper(trim($fila_profe['ape_pat'])." ".trim($fila_profe['ape_mat'])." ".trim($fila_profe['nombre_emp'])));	
	//-----------------------------------------
	  $sql_notas = "select * from notas$nro_ano where id_ramo = ".$subsector." and id_periodo = ".$periodo." order by promedio desc";
      $result_notas = @pg_Exec($conn,$sql_notas);
	
	
	
/*	$sql_alu = "SELECT matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM (matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN tiene3 ON (matricula.id_curso = tiene3.id_curso) AND (matricula.rut_alumno = tiene3.rut_alumno) ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.") AND ((tiene3.id_ramo)=".$subsector.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);*/	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">

							<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></td>
			 </tr>
             </table>
			<? } ?>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><strong>NOTAS POR ASIGNATURA</strong></font></div></td>
        </tr>
      <tr>
        <td colspan="23"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo $nom_per;?> DEL <? echo $nro_ano;?></strong></font></div></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="18">&nbsp;</td>
      </tr>
      <tr>
              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
        <td width="8"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="542" colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal;?></font></td>
        </tr>
      <tr>
		      <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $subsector_pal;?></font></td>
        </tr>
      <tr>
              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a)</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profesor;?></font></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="18">&nbsp;</td>
      </tr>
    </table>
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr bgcolor="003b85"> 
              <td width="17"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><strong>N</strong></font></td>
              <td width="187"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><strong>Nombre 
                del Alumno</strong></font></td>
              <td colspan="20"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><strong>NOTAS</strong></font></div></td>
              <td width="20"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><strong>P</strong></font></div></td>
            </tr>
            <?
  for($e=0 ; $e < @pg_numrows($result_notas) ; $e++)
  {
	  $fila_notas = @pg_fetch_array($result_notas,$e);
      $alumno = $fila_notas['rut_alumno'];
	  //----------
	$sql_alu = "SELECT matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM (matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN tiene$nro_ano ON (matricula.id_curso = tiene$nro_ano.id_curso) AND (matricula.rut_alumno = tiene$nro_ano.rut_alumno) ";
	$sql_alu = $sql_alu . "WHERE (((matricula.rut_alumno)=".$alumno.")) ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	$fila_alu = @pg_fetch_array($result_alu,0);
	$nombre_alum = ucwords(strtolower(trim($fila_alu['ape_pat'])." ".trim($fila_alu['ape_mat'])." ".trim($fila_alu['nombre_alu'])));
	$nombre_alu = substr($nombre_alum ,0,24);
		
  ?>
            <tr> 
              <td height="21"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $e+1?></font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nombre_alu?></font></div></td>
              <td width="17" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota1'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota2'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota3'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota4'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota5'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota6'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota7'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota8'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota9'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota10'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota11'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota12'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota13'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota14'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota15'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota16'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota17'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota18'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota19'],$modo)?>
                  </font></div></td>
              <td width="19" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['nota20'],$modo)?>
                  </font></div></td>
              <td width="40" align="center"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? ValidaNota($fila_notas['promedio'],$modo)?>
                  </font></div></tr>
            <? 
  if ($modo==1)
  {
	$cadena01 = $cadena01 . ";" . $fila_notas['nota1'];
	$cadena02 = $cadena02 . ";" . $fila_notas['nota2'];
	$cadena03 = $cadena03 . ";" . $fila_notas['nota3'];
	$cadena04 = $cadena04 . ";" . $fila_notas['nota4'];
	$cadena05 = $cadena05 . ";" . $fila_notas['nota5'];
	$cadena06 = $cadena06 . ";" . $fila_notas['nota6'];
	$cadena07 = $cadena07 . ";" . $fila_notas['nota7'];
	$cadena08 = $cadena08 . ";" . $fila_notas['nota8'];
	$cadena09 = $cadena09 . ";" . $fila_notas['nota9'];
	$cadena10 = $cadena10 . ";" . $fila_notas['nota10'];
	$cadena11 = $cadena11 . ";" . $fila_notas['nota11'];
	$cadena12 = $cadena12 . ";" . $fila_notas['nota12'];
	$cadena13 = $cadena13 . ";" . $fila_notas['nota13'];
	$cadena14 = $cadena14 . ";" . $fila_notas['nota14'];
	$cadena15 = $cadena15 . ";" . $fila_notas['nota15'];
	$cadena16 = $cadena16 . ";" . $fila_notas['nota16'];
	$cadena17 = $cadena17 . ";" . $fila_notas['nota17'];
	$cadena18 = $cadena18 . ";" . $fila_notas['nota18'];
	$cadena19 = $cadena19 . ";" . $fila_notas['nota19'];
	$cadena20 = $cadena20 . ";" . $fila_notas['nota20'];
	}	
  } 
  ?>
            <tr> 
              <td colspan="23">&nbsp;</td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">% 
                entre --&gt; 00-39 </font></strong></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena01)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena02)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena03)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena04)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena05)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena06)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena07)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena08)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena09)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena10)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena11)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena12)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena13)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena14)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena15)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena16)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena17)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena18)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena19)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje1($cadena20)?>
                  </font></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>% 
                entre --&gt; 40-49 </strong></font></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena01)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena02)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena03)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena04)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena05)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena06)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena07)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena08)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena09)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena10)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena11)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena12)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena13)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena14)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena15)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena16)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena17)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena18)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena19)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje2($cadena20)?>
                  </font></div></td>
              <td><font size="1">&nbsp;</font></td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>% 
                entre --&gt; 50-59 </strong></font></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena01)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena02)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena03)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena04)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena05)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena06)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena07)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena08)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena09)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena10)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena11)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena12)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena13)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena14)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena15)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena16)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena17)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena18)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena19)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje3($cadena20)?>
                  </font></div></td>
              <td><font size="1">&nbsp;</font></td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>% 
                entre --&gt; 60-70 </strong></font></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena01)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena02)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena03)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena04)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena05)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena06)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena07)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena08)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena09)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena10)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena11)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena12)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena13)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena14)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena15)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena16)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena17)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena18)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena19)?>
                  </font></div></td>
              <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                  <? porcentaje4($cadena20)?>
                  </font></div></td>
              <td><font size="1">&nbsp;</font></td>
            </tr>
          </table>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>
<? 
if  (($registros - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
} ?>
</center>
</form>
</body>
</html>
<?
function ValidaNota($nota, $ModoEval)
{
	if ($ModoEval == 1)
	{
		if ($nota>0)
			echo $nota;
		else
			echo "&nbsp;";
	}
	else
	{
		if (trim($nota)=="0")
			echo "&nbsp;";
		else
			echo $nota;
	}
}
function porcentaje1($cadena)
{
	$arreglo= explode(";",$cadena);
	for($o=1 ; $o < 21 ; $o++)
	{
		if ($arreglo[$o]>0 and $arreglo[$o]<39)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje2($cadena)
{
	$arreglo= explode(";",$cadena);
	for($o=1 ; $o < 21 ; $o++)
	{
		if ($arreglo[$o]>39 and $arreglo[$o]<50)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje3($cadena)
{
	$arreglo= explode(";",$cadena);
	for($o=1 ; $o < 21 ; $o++)
	{
		if ($arreglo[$o]>49 and $arreglo[$o]<60)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje4($cadena)
{
	$arreglo= explode(";",$cadena);
	for($o=1 ; $o < 21 ; $o++)
	{
		if ($arreglo[$o]>59 and $arreglo[$o]<71)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
?>
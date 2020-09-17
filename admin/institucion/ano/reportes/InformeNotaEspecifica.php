<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$cadena01		="00";	
	$nota_num		=$cmb_nota;
	if (empty($periodo)) exit;
	if (empty($curso)) exit;	
	$texto_nota = " notas$nro_ano.nota".$nota_num." as promedio";
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'])) . " " . $fila_institu['nro'] . " - " . strtoupper($fila_institu['nom_com']);
	$telefono = $fila_institu['telefono'];
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'] . " DEL " . $nro_ano;
	//------------------------
	// Periodo
	//------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'];
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) ORDER BY ramo.id_ramo; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	//-----------------------------------------		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style>
</head>

<body>
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div>
        </div>
		</td>
      </tr>
      <tr>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></td>
      </tr>
      <tr>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></td>
      </tr>
      <tr>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $telefono;?></strong></font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="3"><div align="center"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong><? echo "INFORME NOTA Nº".$nota_num?> </strong></font></div></td>
        </tr>
      <tr>
        <td colspan="3"><div align="center"><font size="2" face="arial, geneva, helvetica" ><strong><? echo $periodo_pal?> DEL <? echo $ano_escolar?></strong> </font></div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="103"><font size="2" face="arial, geneva, helvetica"><strong>Curso:</strong></font></td>
        <td width="542"><div align="left"><font size="2" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></div></td>
        <td width="5">&nbsp;</td>
      </tr>
      <tr>
        <td><font size="2" face="arial, geneva, helvetica"><strong>Profesor Jefe:</strong></font></td>
        <td><font size="2" face="arial, geneva, helvetica"><? echo $profe_jefe;?></font></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="<? echo $num_subsectores+3 ?>"><div align="center"><font size="2" face="arial, geneva, helvetica"><strong>ASIGNATURAS</strong></font></div></td>
    </tr>
  <tr>
    <td width="18"><font size="1" face="arial, geneva, helvetica"><strong>Nº</strong></font></td>
    <td width="438"><font size="1" face="arial, geneva, helvetica"><strong>Nombre Alumno</strong></font></td>
	<?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
    ?>	
    <td width="143"><div align="center"><font size="1" face="arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso) ?>
</strong></font></div></td>
	<? }?>
    <td width="41"><font size="1" face="arial, geneva, helvetica"><strong>Final</strong></font></td>

  </tr>
    <?	 
	for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	
  <tr>
    <td><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo substr(ucwords(strtolower($nombre_alu)),0,32); ?></font></td>
	<?	 
	$promedio_general = 0;
	$cont_prom_general = 0;
	$promedio = 0;
	$cont_prom = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		//---------------------------------------
		// Notas
		//---------------------------------------
		$sql_notas = "SELECT ".$texto_nota." ";
		$sql_notas = $sql_notas . "FROM notas$nro_ano ";
		$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.rut_alumno)='".$rut_alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		//echo $sql_notas;
		//exit;
		$result_notas =@pg_Exec($conn,$sql_notas);
		$cont_prom = 0;
		for($e=0 ; $e < @pg_numrows($result_notas) ; $e++)
		{
		  $fila_notas = @pg_fetch_array($result_notas,$e);
		  $promedio = $fila_notas['promedio'];
		  if ($promedio>0) 
		  	$cont_prom = $cont_prom + 1;
		}  
		//-------------------------------------
		// Eximidos
		//-------------------------------------
		$sql_inscri = "select count(*) as cantidad ";
		$sql_inscri = $sql_inscri . "from   tiene$nro_ano ";
		$sql_inscri = $sql_inscri . "where rut_alumno = '".$rut_alumno."' and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$result_inscri =@pg_Exec($conn,$sql_inscri);
		$fila_inscri= @pg_fetch_array($result_inscri,0);
		if ($fila_inscri['cantidad'] == 0)
		{
			$promedio = "EX";
		}	
		else
		{
			if ($modo_eval <> 1)
			{
				 if (trim($promedio)<>"0")
					$cont_prom = 1;
				else
					$cont_prom = 0;
			}
		}
		if ($promedio > 0)
		{
			$promedio_general = $promedio_general + $promedio;
			$cont_prom_general = $cont_prom_general + 1;
		}
    ?>	
    <td width="143"><div align="center"><font size="0" face="arial, geneva, helvetica"><? if ($cont_prom>0 ) echo $promedio; else echo "&nbsp;"?></font></div></td>
	<? }
	if ($promedio_general>0)
		$promedio_general= round($promedio_general/$cont_prom_general,0);
	else
		$promedio_general= "&nbsp;";
		
	?>
    <td width="41"><div align="center"><font size="0" face="arial, geneva, helvetica">
	<? 
	echo $promedio_general; 
	if ($promedio_general>0) 
	{
		$cadena01 = $cadena01 . ";" . $promedio_general;
		$prom_prom = prom_prom + $promedio_general;
		$cont_cont = cont_cont + 1;
	}
	?>
	</font></div></td>
  </tr>
  <? }
  $sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
  $sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
  $sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) ORDER BY ramo.id_ramo; ";
  $result_sub =@pg_Exec($conn,$sql_sub );
  ?>
  <tr>
    <td><div align="left">&nbsp;</div></td>
    <td><div align="right"><font size="1" face="arial, geneva, helvetica"><strong>Nota Media</strong></font></div></td>
	<? 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		//---------
		$sql_notas = "SELECT ".$texto_nota." ";
		$sql_notas = $sql_notas . "FROM notas$nro_ano ";
		$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		//echo $sql_notas;
		//exit;
		$result_notas =@pg_Exec($conn,$sql_notas);
		$cont_prom = 0;
		$nota_media = 0;
		$promedio =0;
		$cadena = "";
		for($e=0 ; $e < @pg_numrows($result_notas) ; $e++)
		{
		  $fila_notas = @pg_fetch_array($result_notas,$e);
		  $promedio = trim($fila_notas['promedio']);
		  if ($fila_notas['promedio']>0)
		  { 
		  	$cont_prom = $cont_prom + 1;
			$nota_media = $nota_media + $promedio;
			if (empty($cadena))
				$cadena = $promedio;
			else
				$cadena = $cadena . ";" . $promedio;
		  }
		} 
		$notas_array = explode(";",$cadena);
		sort($notas_array);
		if ($cont_prom>0) 
			$nota_media = round($nota_media/$cont_prom,0);
    ?>	
    <td><div align="center"><font size="0" face="arial, geneva, helvetica"><? if ($cont_prom>0) echo $nota_media; else echo "&nbsp;"?></font></div></td>
	<? }?>
    <td><div align="center"><font size="0" face="arial, geneva, helvetica">
	<?
	if ($cont_cont>0)
		echo round($prom_prom / $cont_cont,2);
	else
		echo "&nbsp";
	?>
	</font></div></td>
  </tr>
  <tr>
    <td><div align="left">&nbsp;</div></td>
	<td><div align="right"><font size="1" face="arial, geneva, helvetica"><strong>Nota Menor</strong></font></div></td>
		<? 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		//---------
		$sql_notas = "SELECT ".$texto_nota." ";
		$sql_notas = $sql_notas . "FROM notas$nro_ano ";
		$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		//echo $sql_notas;
		//exit;
		$result_notas =@pg_Exec($conn,$sql_notas);
		$cont_prom = 0;
		$nota_media = 0;
		$promedio =0;
		$cadena = "";
		for($e=0 ; $e < @pg_numrows($result_notas) ; $e++)
		{
		  $fila_notas = @pg_fetch_array($result_notas,$e);
		  $promedio = trim($fila_notas['promedio']);
		  if ($fila_notas['promedio']>0)
		  { 
		  	$cont_prom = $cont_prom + 1;
			$nota_media = $nota_media + $promedio;
			if (empty($cadena))
				$cadena = $promedio;
			else
				$cadena = $cadena . ";" . $promedio;
		  }
		} 
		$notas_array = explode(";",$cadena);
		sort($notas_array);
		if ($cont_prom>0) 
			$nota_media = round($nota_media/$cont_prom,0);
    ?>	
    <td><div align="center"><font size="1" face="arial, geneva, helvetica"><strong><? if ($notas_array[0]>0) echo $notas_array[0]; else echo "&nbsp";?></strong></font></div></td>
	<? }?>	
	<td><div align="center"><font size="0" face="arial, geneva, helvetica">
	<?
	$promedio_array = explode(";",$cadena01);
	sort($promedio_array);
	if ($promedio_array[1]>0)
		echo $promedio_array[1];
	else
		echo "&nbsp";
	?>
	</font></div></td>
  </tr>
  <tr>
    <td height="21"><div align="left">&nbsp;</div></td>
    <td><div align="right"><font size="1" face="arial, geneva, helvetica"><strong>Nota Mayor</strong></font></div></td>
		<? 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		//---------
		$sql_notas = "SELECT ".$texto_nota." ";
		$sql_notas = $sql_notas . "FROM notas$nro_ano ";
		$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		//echo $sql_notas;
		//exit;
		$result_notas =@pg_Exec($conn,$sql_notas);
		$cont_prom = 0;
		$nota_media = 0;
		$promedio =0;
		$cadena = "";
		for($e=0 ; $e < @pg_numrows($result_notas) ; $e++)
		{
		  $fila_notas = @pg_fetch_array($result_notas,$e);
		  $promedio = trim($fila_notas['promedio']);
		  if ($fila_notas['promedio']>0)
		  { 
		  	$cont_prom = $cont_prom + 1;
			$nota_media = $nota_media + $promedio;
			if (empty($cadena))
				$cadena = $promedio;
			else
				$cadena = $cadena . ";" . $promedio;
		  }
		} 
		$notas_array = explode(";",$cadena);
		sort($notas_array);
		if ($cont_prom>0) 
			$nota_media = round($nota_media/$cont_prom,0);
    ?>	
    <td><div align="center"><font size="1" face="arial, geneva, helvetica"><strong><? if ($notas_array[$cont_prom-1]>0) echo $notas_array[$cont_prom-1]; else echo "&nbsp";?></strong></font></div></td>
	<? }?>
    	<td><div align="center"><font size="0" face="arial, geneva, helvetica">
	<?
	$promedio_array = explode(";",$cadena01);
	rsort($promedio_array);
	if ($promedio_array[0]>0)
		echo $promedio_array[0];
	else
		echo "&nbsp";
	?>
	</font></div></td>
  </tr>
</table>	
</td>
  </tr>


</table>

</center>
</body>
</html>
<?
function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==3 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>
<? pg_close($conn);?>
<? 
require('../../../../../util/header.inc');
setlocale("LC_ALL","es_ES");
?>
<script>
function imprimir() 
{

	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';	
	window.print();
	document.getElementById("capa1").style.display='block';
	document.getElementById("capa0").style.display='block';
}
	</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$periodo		=$c_periodos;
	$sw				=0;

	if ($curso==0) $sw = 1;
	if ($periodo==0) $sw = 1;
	if ($sw == 1) exit;

	$sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by id_periodo" ;
	$result1 =@pg_Exec($conn,$sql);
	if (!$result1) 
	{
	  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	}
	else
	{
		if (pg_numrows($result1)!=0)
	  {
		  $fila1 = @pg_fetch_array($result1,0);	
		  if (!$fila1)
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			  exit();
		  }
	  }
	}
	//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano']
	//-----------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo2 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>
</head>

<body target="mainFrame">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<form method="post" target="mainFrame">
<center>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
	  <div id="capa0">
	    <input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	  </div>
    </div></td>
  </tr>
</table>
<?
	if (empty($alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno =" . $alumno ." and id_ano = " . $ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;

?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="649" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="649"><table width="649" border="0" cellpadding="0" cellspacing="0">
			  <tr>
                <td width="114"><div align="left"><font face="arial, geneva, helvetica" size="2"></font></div></td>
                <td width="9"><font face="arial, geneva, helvetica" size="2">&nbsp;</font></td>
                <td width="361"><div align="left"></div></td>
                <td width="161" rowspan="7" align="center" valign="top" >
				<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
			<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100" >
			<? } ?>
				</td>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>AÑO ESCOLAR</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><? echo trim($fila['nro_ano']) ?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>CURSO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2">
				<? 
				$Curso_pal = CursoPalabra($curso, 0, $conn);
				echo $Curso_pal; 
				?>
				</font></div></td>
                </tr>	
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>ALUMNO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><? echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2">
				<?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result =@pg_Exec($conn,$sql4);
				if (!$result) 
				{
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}
				else
				{
					if (pg_numrows($result)!=0)
					{
						$fila = @pg_fetch_array($result,0);	
						if (!$fila)
						{
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
				}
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				?>
				</font></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  
            </table>
            </td>
      </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#003b85"><div align="center"><font face="arial, geneva, helvetica" size="2" color="#ffffff">
					    <strong>INFORME  DE NOTAS </strong></font></div></td>
      </tr>
      <tr>
        <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($fila1['nombre_periodo'] . "DEL " . $nro_ano))?></strong></font></div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				{
					?><div align="center"><?
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS HÁBILES PARA PERÍODOS </b> <br> Debe <a href="../../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la información requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
				$id_periodo = $fila1['id_periodo'];
				$dias_habiles = $fila1['dias_habiles'];
				$fecha_ini = $fila1['fecha_inicio'];
				$fecha_fin = $fila1['fecha_termino'];
				//--
				$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = " . $alumno . " and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "'";
				$result13 =@pg_Exec($conn,$sql13);
			    if (!$result13) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result13)!=0)
				    {
				  	  $fila13 = @pg_fetch_array($result13,0);	
				  	  if (!$fila13)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				$inasistencia = $fila13['cantidad'];
				$dias_asistidos = $dias_habiles - $fila13['cantidad'];
				//--
				$sql8 = "select count(*) as contador from notas$nro_ano where id_periodo = ". $id_periodo . " and rut_alumno = " . $alumno;
			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result18)!=0)
				    {
				  	  $fila8 = @pg_fetch_array($result18,0);	
				  	  if (!$fila1)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				if ($fila8['contador']>0)
				{
				?>			
				<br><br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n General ) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."')) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			if (0<$cantidad_periodos){ $tri = 1;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1ºTR</strong></font></td>
			<? }?>
			<?			
			if (1<$cantidad_periodos){$tri = 2;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2ºTR</strong></font></td>
			<? }?>			
			<?			
			if (2<$cantidad_periodos){$tri = 3;
			?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3ºTR</strong></font></td>						
            </tr>
			<? }?>			         

		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)=".$alumno.")); ";

//		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
//		  $sql2 = $sql2 . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
//		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.")); ";

          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
    		}
		  else
    		{
    			if (pg_numrows($result)!=0)
			  {
				  $fila = @pg_fetch_array($result,0);	
				  if (!$fila)
				  {
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  $num_subsec = pg_numrows($result);
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";
			$sql3 = $sql3 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";

			$result2 =@pg_Exec($conn,$sql3);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
    			}
			  else
    			{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
			?>
            <td height="25"><div align="left"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota1'])=="0" or empty($fila2['nota1'])){echo "&nbsp;";}else{echo $fila2['nota1'];} ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota2'])=="0" or empty($fila2['nota2'])){echo "&nbsp;";}else{echo $fila2['nota2'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota3'])=="0" or empty($fila2['nota3'])){echo "&nbsp;";}else{echo $fila2['nota3'];} ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota4'])=="0" or empty($fila2['nota4'])){echo "&nbsp;";}else{echo $fila2['nota4'];} ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota5'])=="0" or empty($fila2['nota5'])){echo "&nbsp;";}else{echo $fila2['nota5'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota6'])=="0" or empty($fila2['nota6'])){echo "&nbsp;";}else{echo $fila2['nota6'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota7'])=="0" or empty($fila2['nota7'])){echo "&nbsp;";}else{echo $fila2['nota7'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota8'])=="0" or empty($fila2['nota8'])){echo "&nbsp;";}else{echo $fila2['nota8'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota9'])=="0" or empty($fila2['nota9'])){echo "&nbsp;";}else{echo $fila2['nota9'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota10'])=="0" or empty($fila2['nota10'])){echo "&nbsp;";}else{echo $fila2['nota10'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota11'])=="0" or empty($fila2['nota11'])){echo "&nbsp;";}else{echo $fila2['nota11'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota12'])=="0" or empty($fila2['nota12'])){echo "&nbsp;";}else{echo $fila2['nota12'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota13'])=="0" or empty($fila2['nota13'])){echo "&nbsp;";}else{echo $fila2['nota13'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota14'])=="0" or empty($fila2['nota14'])){echo "&nbsp;";}else{echo $fila2['nota14'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota15'])=="0" or empty($fila2['nota15'])){echo "&nbsp;";}else{echo $fila2['nota15'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota16'])=="0" or empty($fila2['nota16'])){echo "&nbsp;";}else{echo $fila2['nota16'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota17'])=="0" or empty($fila2['nota17'])){echo "&nbsp;";}else{echo $fila2['nota17'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota18'])=="0" or empty($fila2['nota18'])){echo "&nbsp;";}else{echo $fila2['nota18'];} ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota19'])=="0" or empty($fila2['nota19'])){echo "&nbsp;";}else{echo $fila2['nota19'];}  ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['nota20'])=="0" or empty($fila2['nota20'])){echo "&nbsp;";}else{echo $fila2['nota20'];}  ?></font></div></td>
			<? 
			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			}
		  	$sql_peri = "SELECT notas$nro_ano.promedio ";
			$sql_peri = $sql_peri . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_ramo = ".$id_ramo." ) order by id_periodo; ";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$fila_peri = @pg_fetch_array($result_peri,0);
			?>
			<?			
			if (0<$cantidad_periodos){
			?>
            <td align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($fila_peri['promedio']>0) echo $fila_peri['promedio']; else  echo "&nbsp;"; ?></font></td>
			<? } ?>
			<? 			$fila_peri = @pg_fetch_array($result_peri,1);	 ?>
			<?			
			if (1<$cantidad_periodos){
			?>			
            <td align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($fila_peri['promedio']>0) echo $fila_peri['promedio']; else  echo "&nbsp;"; ?></font></td>			
			<? } ?>
			<? 			$fila_peri = @pg_fetch_array($result_peri,2);	 ?>
			<?			
			if (2<$cantidad_periodos){
			?>			
            <td align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($fila_peri['promedio']>0) echo $fila_peri['promedio']; else  echo "&nbsp;"; ?></font></td>			
			<? } ?>			
          </tr>
		  <? } ?>
        </table>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="461">&nbsp;</td>
            <td width="153"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio General <? echo ucwords(strtolower($fila1['nombre_periodo']))?> </font></strong></font></div></td>
            <td width="36"><div align="center"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">
			<? 
			if ($promedio > 0) 
			{
				echo $promedio = round($promedio / $cont_prom,0);
				$promedio_gen = $promedio_gen + $promedio;
				$cont_promgen=$cont_promgen +1;
			}
			else
				echo "&nbsp;";
			
			?></font></strong></font></div></td>
          </tr>
        </table>
		<? } //for?>
		<? } //if?> 
		<HR width="100%" color=#003b85>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			  <? 
					if ($dias_habiles>0)
					{
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
					?>
			</font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			<?
			$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "')";
			$result_atraso =@pg_Exec($conn,$sql_atraso);
			$fila_atraso = @pg_fetch_array($result_atraso,0);
			if (empty($fila_atraso['cantidad']))
				echo "0";
			else
				echo $fila_atraso['cantidad'];
			?>
			</font></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<table width="650" height="38" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="16"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		  <tr>
		    <td height="22"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">
			<? 
				$sql_observa = "select * from observa_informe where rut_alumno = ".$alumno;
				$result_observa =@pg_Exec($conn,$sql_observa);
				$fila_observa = @pg_fetch_array($result_observa,0);	
				if (!empty($fila_observa['observacion']))
					echo $fila_observa['observacion'];
				else
					echo "&nbsp;";
			
			?></font></div></td>
		    </tr>
		</table><br>
			  <div id="capa1">
				<input name="button4" TYPE="button" class="botonX" onClick=window.open("observacion_informe.php?id_curso=<? echo $curso ?>&rut_alumno=<? echo $alumno ?>&id_periodo=<? echo $periodo ?>&curso_aux=<? echo $c_curso?>&alumno_aux=<? echo $c_alumno?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=85,left=140") onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="EDITAR">			  
			  </div>
		        <table width="650" border="0" cellpadding="0" cellspacing="0">
				  <?
				  for($e=0 ; $e < 15-$num_subsec ; $e++)
				  {
				  ?>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  <? }?>
                  <tr> 
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Profesor(a) 
                        Jefe </font></div></td>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Rector(a) 
                        Establecimiento </font></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"><? echo $nombre_profe; ?> 
                        </font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"> 
                        <?
			$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}
			else
			{
				if (pg_numrows($result)!=0)
				{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
			echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
			?>
                        </font></strong></div></td>
                  </tr>
                </table>
              </div>
		</td>
      </tr>
    </table>
	<tr>
	  <td>&nbsp;</td>
    </tr>
	</td>
  </tr>
  <tr>
    <td><div align="justify"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</strong></div>
    </table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="124"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="245">&nbsp;</td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($promedio>0)
		echo $promedio;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Período </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_asistidos) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Atrasos </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <?
	$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = ".$alumno." and tipo = 2 and (fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "')";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);
	if (empty($fila_atraso['cantidad']))
		echo "0";
	else
		echo trim($fila_atraso['cantidad']);
	?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
        <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></div></td>
    <td><div align="left">&nbsp;</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">___________________________</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
 <? if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>
</center>
</form>
</body>
</html>

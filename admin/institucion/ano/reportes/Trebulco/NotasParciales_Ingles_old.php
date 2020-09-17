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
	document.getElementById("capa0").style.display='block';	
	document.getElementById("capa1").style.display='block';	

}
	</script>

<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$periodo		=$c_periodos;
	$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
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
	$sql = "select count(id_periodo) as num_periodos from periodo where id_ano = $ano";
	$resultPeri =@pg_Exec($conn,$sql);	
    $fila1Peri = @pg_fetch_array($resultPeri,0);		
	$num_periodos = $fila1Peri['num_periodos'];
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
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
.style4 {font-family: "Times New Roman", Times, serif}
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

<div id="capa0">
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td><div align="right">
			<input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="PRINT">
		</div></td>
	  </tr>
	</table>
</div>

<?
	if (empty($alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" .$alumno ."' and id_ano = " . $ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$grado_ingles = $fila['grado_curso'];
	$letra_ingles = trim($fila['letra_curso']);
	$ensenanza = $fila['cod_tipo'];
		
	$tipo_ense = $fila['ensenanza'];
	$grado_curso = $fila['grado_curso'];
		

?>		
<center>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		<table width="649" border="0" cellpadding="0" cellspacing="0">
		  <tr>
				<td width="649">
<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{	?>
				<table width="649" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="161" rowspan="7" align="center" valign="top" >


<?
//			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$output= "select lo_export(".$arr['insignia'].",'/opt/www/coeint/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
			<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100" >

					</td>
					<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#000099">Report Card</font></strong></div></td>
              <tr>
                <td>
<? 					if( trim($fila1['nombre_periodo'])=='PRIMER SEMESTRE' )
						$nom_periodo='First Semester'; 
					if( trim($fila1['nombre_periodo'])=='SEGUNDO SEMESTRE' )
						$nom_periodo='Second Semester'; 
					if( trim($fila1['nombre_periodo'])=='PRIMER TRIMESTRE' )
						$nom_periodo='First Trimester'; 
					if( trim($fila1['nombre_periodo'])=='SEGUNDO TRIMESTRE' )
						$nom_periodo='Second Trimester'; 
					if( trim($fila1['nombre_periodo'])=='TERCER TRIMESTRE' )
						$nom_periodo='Third Trimester'; 
					?>
					<div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000099"><? echo ucwords(strtoupper($nom_periodo.", ".$nro_ano))?></font></div>
				</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
            </table>
<?	 	} 
		else{	?>
				<table width="649" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#000099">Report Card</font></strong></div></td>
	              <tr>
                <td>
<? 					if( trim($fila1['nombre_periodo'])=='PRIMER SEMESTRE' )
						$nom_periodo='First Semester'; 
					if( trim($fila1['nombre_periodo'])=='SEGUNDO SEMESTRE' )
						$nom_periodo='Second Semester'; 
					if( trim($fila1['nombre_periodo'])=='PRIMER TRIMESTRE' )
						$nom_periodo='First Trimester'; 
					if( trim($fila1['nombre_periodo'])=='SEGUNDO TRIMESTRE' )
						$nom_periodo='Second Trimester'; 
					if( trim($fila1['nombre_periodo'])=='TERCER TRIMESTRE' )
						$nom_periodo='Third Trimester'; 
					?>
					<div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000099"><? echo ucwords(strtoupper($nom_periodo.", ".$nro_ano))?></font></div>
				</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
            </table>
<?		}	?>

<br>
			<table width="649" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="60"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Name</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="300"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Teacher</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				<?
/*				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")) ";
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
*/
				if($grado_curso==1 && trim($letra_ingles)=='A'){
					$nombre_profe=trim('Tatiana Trapp');
				}
				if($grado_curso==1 && trim($letra_ingles)=='B'){
					$nombre_profe=trim('Vicky Armijo');
				}
				if($grado_curso==2 && trim($letra_ingles)=='A'){
					$nombre_profe=trim('Margareth Trapp');
				}
				if($grado_curso==2 && trim($letra_ingles)=='B'){
					$nombre_profe=trim('Patricia Muxica');
				}
				if($grado_curso==3 && trim($letra_ingles)=='A'){
					$nombre_profe=trim('Carmen Gloria Riffo');
				}
				if($grado_curso==3 && trim($letra_ingles)=='B'){
					$nombre_profe=trim('Pamela Alcalde');
				}
				if($grado_curso==4){
					$nombre_profe=trim('Melissa Terney');
				}
				if($grado_curso==5 ){
					$nombre_profe=trim('Paula Farias');
				}
				if($grado_curso==6){
					$nombre_profe=trim('Macarena Fuenzalida');
				}
				if($grado_curso==7 ){
					$nombre_profe=trim('Paula Becerra ');
				}
				echo $nombre_profe;

				?>
				</font></div></td>
				<td>&nbsp;</td>
				<td width="40"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Class</strong></font></div></td>
				<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
				<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<? 
						if($grado_ingles==5 and $ensenanza==10 and  $letra_ingles=='A'){	
							echo " Kinder Oak";
							}
						 if($grado_ingles==5 and $ensenanza==10 and $letra_ingles=='B'){	
							echo " Kinder Maple";
							}
						 if($grado_ingles==4 and $ensenanza==10 and $letra_ingles=='A'){	
							echo " Pre-Kinder Oak";
							}
						 if($grado_ingles==4 and $ensenanza==10 and $letra_ingles=='B'){	
							echo " Pre-Kinder Maple";
							}
						 if($grado_ingles==3 and $ensenanza==10 and $letra_ingles=='A'){	
							echo " Playgroup";
							}
						 if($grado_ingles==1 and $ensenanza==110 and $letra_ingles=='A'){	
							echo " First Oak";
							}
						 if($grado_ingles==1 and $ensenanza==110 and $letra_ingles=='B'){	
							echo " First Maple";
							}
						 if($grado_ingles==2 and $ensenanza==110 and $letra_ingles=='A'){	
							echo " Second Oak";
							}
						 if($grado_ingles==2 and $ensenanza==110 and $letra_ingles=='B'){	
							echo " Second Maple";
							}
						 if($grado_ingles==3 and $ensenanza==110 and $letra_ingles=='A'){	
							echo " Third Oak";
							}
						 if($grado_ingles==3 and $ensenanza==110 and $letra_ingles=='B'){	
							echo " Third Maple";
							}
						 if($grado_ingles==4 and $ensenanza==110){	
							echo " Fourth Grade";
							}
						 if($grado_ingles==5 and $ensenanza==110){
							echo " Fifth Grade";
							}
						 if($grado_ingles==6 and $ensenanza==110){	
							echo " Sixth Grade";
							}
						 if($grado_ingles==7 and $ensenanza==110){
							echo " Seventh Grade";
							}

   						/*if(($grado_ingles > 4) and ($ensenanza == 110))
						echo "&nbsp;Grade ".$letra_ingles." ";	*/
					?>
					</font></div></td>
                </tr>
            </table> 

        </table>
		</td>
      </tr>
	  <tr>
	  	<td><hr width="100%" color=#003b85></td>
	  </tr>
	  <tr>
	  	<td>&nbsp;</td>
	  </tr>
      <tr>
        <td height="20"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" >
					    <strong>Cognitive Skills </strong></font></div></td>
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
				<br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="186" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subjects </strong></font></div></td>
            <td colspan="19" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Parcial Grades</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$alumno.")) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			?>
            <td width="18" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>OA</strong></font></td>
            <td width="18" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<?			
			$tri = 2;
			?>
            <td width="18" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?			
			if ($num_periodos==3){$tri = 3;
			?>			
            <td width="18" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? }?>			         
            </tr>
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, subsector.cod_subsector ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
//   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."')) order by ramo.id_orden; ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."')) AND subsector.nombre not like '%INGLES%' order by ramo.id_orden; ";
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
				$modo_eval = $fila['modo_eval'];
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
				if ($modo_eval == 1){
					if ($fila2['nota1']>0) $nota1 = $fila2['nota1']; else $nota1 = "&nbsp;";
					if ($fila2['nota2']>0) $nota2 = $fila2['nota2']; else $nota2 = "&nbsp;";
					if ($fila2['nota3']>0) $nota3 = $fila2['nota3']; else $nota3 = "&nbsp;";
					if ($fila2['nota4']>0) $nota4 = $fila2['nota4']; else $nota4 = "&nbsp;";
					if ($fila2['nota5']>0) $nota5 = $fila2['nota5']; else $nota5 = "&nbsp;";
					if ($fila2['nota6']>0) $nota6 = $fila2['nota6']; else $nota6 = "&nbsp;";
					if ($fila2['nota7']>0) $nota7 = $fila2['nota7']; else $nota7 = "&nbsp;";
					if ($fila2['nota8']>0) $nota8 = $fila2['nota8']; else $nota8 = "&nbsp;";
					if ($fila2['nota9']>0) $nota9 = $fila2['nota9']; else $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0 || trim($fila2['nota20'])==MB || trim($fila2['nota20'])==B || trim($fila2['nota20'])==S || trim($fila2['nota20'])==I) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";																																																																																															

					if((trim($fila2['nota20'])>=60 && trim($fila2['nota20'])<=70) || trim($fila2['nota20'])=='MB')	$nota20=VG;	
					if((trim($fila2['nota20'])>=50 && trim($fila2['nota20'])<=59) || trim($fila2['nota20'])=='B')	$nota20=G;	
					if((trim($fila2['nota20'])>=40 && trim($fila2['nota20'])<=49) || trim($fila2['nota20'])=='S')	$nota20=S;	
					if((trim($fila2['nota20'])>0 && trim($fila2['nota20'])<=39) || trim($fila2['nota20'])=='I')		$nota20=NI;	


				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="") $nota1 = "&nbsp;";  else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;"; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;"; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;"; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;"; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;"; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;"; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;"; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;"; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;"; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;"; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;"; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;"; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;"; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;"; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;"; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;"; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;"; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;"; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp;"; else $nota20 = $fila2['nota20'];
				}

/* *********** comparaciones de subsectores  ****************** */

			if( strpos($fila['nombre'],'INGLES')!=0 ){
				$fila['nombre'] ='ENGLISH';
			}
			else if( strpos($fila['nombre'],'LENGUAJE')!=0 || strpos($fila['nombre'],'COMUNICACION')!=0){
				$fila['nombre'] ='SPANISH';
			}
			else if( strpos($fila['nombre'],'MATEMATICA')!=0 ){
				$fila['nombre'] ='MATHEMATICS';
			}
			else if( strpos($fila['nombre'],'NATURAL')!=0 ){
				$fila['nombre'] ='SCIENCE';
			}
			else if( strpos($fila['nombre'],'TECNOLOGICA')!=0 || strpos($fila['nombre'],'TECNOLOGIA')!=0){
				$fila['nombre'] ='TECHNOLOGY';
			}
			else if( strpos($fila['nombre'],'ART')!=0 || strpos($fila['nombre'],'ARTISTICA')!=0 ){
				$fila['nombre'] ='ART';
			}
			else if( strpos($fila['nombre'],'FISICA')!=0 || strpos($fila['nombre'],'GIMNASIA')!=0 ){   // educacion fisica
				$fila['nombre'] ='PHYSICAL EDUCATION';
			}
			else if( strpos($fila['nombre'],'RELIGION')!=0 ){
				$fila['nombre'] ='RELIGION';
			}
			else if( strpos($fila['nombre'],'ORIENTACION')!=0 ){
				$fila['nombre'] ='DIRECTION';
			}
			else if( strpos($fila['nombre'],'SOCIEDAD')!=0 ){
				$fila['nombre'] ='SOCIAL';
			}
			else if( strpos($fila['nombre'],'MUSIC')!=0 ){
				$fila['nombre'] ='MUSIC';
			}
			
			if($fila['cod_subsector']==111){
				$fila['nombre'] ='ART';
			}
			if($fila['cod_subsector']==288){
				$fila['nombre'] ='MUSIC';
			}


if( $tipo_ense==110 && ($grado_curso==1 || $grado_curso==2)){
	if((trim($fila2['nota1'])>=60 && trim($fila2['nota1'])<=70) || trim($fila2['nota1'])=='MB')  $nota1=VG;	
	if((trim($fila2['nota1'])>=50 && trim($fila2['nota1'])<=59) || trim($fila2['nota1'])=='B')	$nota1=G;	
	if((trim($fila2['nota1'])>=40 && trim($fila2['nota1'])<=49) || trim($fila2['nota1'])=='S')	$nota1=S;	
	if((trim($fila2['nota1'])>0 && trim($fila2['nota1'])<=39) || trim($fila2['nota1'])=='I')	$nota1=NI;	

	if((trim($fila2['nota2'])>=60 && trim($fila2['nota2'])<=70) || trim($fila2['nota2'])=='MB')  $nota2=VG;	
	if((trim($fila2['nota2'])>=50 && trim($fila2['nota2'])<=59) || trim($fila2['nota2'])=='B')	$nota2=G;	
	if((trim($fila2['nota2'])>=40 && trim($fila2['nota2'])<=49) || trim($fila2['nota2'])=='S')	$nota2=S;	
	if((trim($fila2['nota2'])>0 && trim($fila2['nota2'])<=39) || trim($fila2['nota2'])=='I')	$nota2=NI;	

	if((trim($fila2['nota3'])>=60 && trim($fila2['nota3'])<=70) || trim($fila2['nota3'])=='MB')  $nota3=VG;	
	if((trim($fila2['nota3'])>=50 && trim($fila2['nota3'])<=59) || trim($fila2['nota3'])=='B')	$nota3=G;	
	if((trim($fila2['nota3'])>=40 && trim($fila2['nota3'])<=49) || trim($fila2['nota3'])=='S')	$nota3=S;	
	if((trim($fila2['nota3'])>0 && trim($fila2['nota3'])<=39) || trim($fila2['nota3'])=='I')	$nota3=NI;	

	if((trim($fila2['nota4'])>=60 && trim($fila2['nota4'])<=70) || trim($fila2['nota4'])=='MB')  $nota4=VG;	
	if((trim($fila2['nota4'])>=50 && trim($fila2['nota4'])<=59) || trim($fila2['nota4'])=='B')	$nota4=G;	
	if((trim($fila2['nota4'])>=40 && trim($fila2['nota4'])<=49) || trim($fila2['nota4'])=='S')	$nota4=S;	
	if((trim($fila2['nota4'])>0 && trim($fila2['nota4'])<=39) || trim($fila2['nota4'])=='I')	$nota4=NI;	

	if((trim($fila2['nota5'])>=60 && trim($fila2['nota5'])<=70) || trim($fila2['nota5'])=='MB')  $nota5=VG;	
	if((trim($fila2['nota5'])>=50 && trim($fila2['nota5'])<=59) || trim($fila2['nota5'])=='B')	$nota5=G;	
	if((trim($fila2['nota5'])>=40 && trim($fila2['nota5'])<=49) || trim($fila2['nota5'])=='S')	$nota5=S;	
	if((trim($fila2['nota5'])>0 && trim($fila2['nota5'])<=39) || trim($fila2['nota5'])=='I')	$nota5=NI;	

	if((trim($fila2['nota6'])>=60 && trim($fila2['nota6'])<=70) || trim($fila2['nota6'])=='MB')  $nota6=VG;	
	if((trim($fila2['nota6'])>=50 && trim($fila2['nota6'])<=59) || trim($fila2['nota6'])=='B')	$nota6=G;	
	if((trim($fila2['nota6'])>=40 && trim($fila2['nota6'])<=49) || trim($fila2['nota6'])=='S')	$nota6=S;	
	if((trim($fila2['nota6'])>0 && trim($fila2['nota6'])<=39) || trim($fila2['nota6'])=='I')	$nota6=NI;	

	if((trim($fila2['nota7'])>=60 && trim($fila2['nota7'])<=70) || trim($fila2['nota7'])=='MB')  $nota7=VG;	
	if((trim($fila2['nota7'])>=50 && trim($fila2['nota7'])<=59) || trim($fila2['nota7'])=='B')	$nota7=G;	
	if((trim($fila2['nota7'])>=40 && trim($fila2['nota7'])<=49) || trim($fila2['nota7'])=='S')	$nota7=S;	
	if((trim($fila2['nota7'])>0 && trim($fila2['nota7'])<=39) || trim($fila2['nota7'])=='I')	$nota7=NI;	

	if((trim($fila2['nota8'])>=60 && trim($fila2['nota8'])<=70) || trim($fila2['nota8'])=='MB')  $nota8=VG;	
	if((trim($fila2['nota8'])>=50 && trim($fila2['nota8'])<=59) || trim($fila2['nota8'])=='B')	$nota8=G;	
	if((trim($fila2['nota8'])>=40 && trim($fila2['nota8'])<=49) || trim($fila2['nota8'])=='S')	$nota8=S;	
	if((trim($fila2['nota8'])>0 && trim($fila2['nota8'])<=39) || trim($fila2['nota8'])=='I')	$nota8=NI;	

	if((trim($fila2['nota9'])>=60 && trim($fila2['nota9'])<=70) || trim($fila2['nota9'])=='MB')  $nota9=VG;	
	if((trim($fila2['nota9'])>=50 && trim($fila2['nota9'])<=59) || trim($fila2['nota9'])=='B')	$nota9=G;	
	if((trim($fila2['nota9'])>=40 && trim($fila2['nota9'])<=49) || trim($fila2['nota9'])=='S')	$nota9=S;	
	if((trim($fila2['nota9'])>0 && trim($fila2['nota9'])<=39) || trim($fila2['nota9'])=='I')	$nota9=NI;	

	if((trim($fila2['nota10'])>=60 && trim($fila2['nota10'])<=70) || trim($fila2['nota10'])=='MB')	$nota10=VG;	
	if((trim($fila2['nota10'])>=50 && trim($fila2['nota10'])<=59) || trim($fila2['nota10'])=='B')	$nota10=G;	
	if((trim($fila2['nota10'])>=40 && trim($fila2['nota10'])<=49) || trim($fila2['nota10'])=='S')	$nota10=S;	
	if((trim($fila2['nota10'])>0 && trim($fila2['nota10'])<=39) || trim($fila2['nota10'])=='I')		$nota10=NI;	

	if((trim($fila2['nota11'])>=60 && trim($fila2['nota11'])<=70) || trim($fila2['nota11'])=='MB')	$nota11=VG;	
	if((trim($fila2['nota11'])>=50 && trim($fila2['nota11'])<=59) || trim($fila2['nota11'])=='B')	$nota11=G;	
	if((trim($fila2['nota11'])>=40 && trim($fila2['nota11'])<=49) || trim($fila2['nota11'])=='S')	$nota11=S;	
	if((trim($fila2['nota11'])>0 && trim($fila2['nota11'])<=39) || trim($fila2['nota11'])=='I')		$nota11=NI;	

	if((trim($fila2['nota12'])>=60 && trim($fila2['nota12'])<=70) || trim($fila2['nota12'])=='MB')	$nota12=VG;	
	if((trim($fila2['nota12'])>=50 && trim($fila2['nota12'])<=59) || trim($fila2['nota12'])=='B')	$nota12=G;	
	if((trim($fila2['nota12'])>=40 && trim($fila2['nota12'])<=49) || trim($fila2['nota12'])=='S')	$nota12=S;	
	if((trim($fila2['nota12'])>0 && trim($fila2['nota12'])<=39) || trim($fila2['nota12'])=='I')		$nota12=NI;	

	if((trim($fila2['nota13'])>=60 && trim($fila2['nota13'])<=70) || trim($fila2['nota13'])=='MB')	$nota13=VG;	
	if((trim($fila2['nota13'])>=50 && trim($fila2['nota13'])<=59) || trim($fila2['nota13'])=='B')	$nota13=G;	
	if((trim($fila2['nota13'])>=40 && trim($fila2['nota13'])<=49) || trim($fila2['nota13'])=='S')	$nota13=S;	
	if((trim($fila2['nota13'])>0 && trim($fila2['nota13'])<=39) || trim($fila2['nota13'])=='I')		$nota13=NI;	

	if((trim($fila2['nota14'])>=60 && trim($fila2['nota14'])<=70) || trim($fila2['nota14'])=='MB')	$nota14=VG;	
	if((trim($fila2['nota14'])>=50 && trim($fila2['nota14'])<=59) || trim($fila2['nota14'])=='B')	$nota14=G;	
	if((trim($fila2['nota14'])>=40 && trim($fila2['nota14'])<=49) || trim($fila2['nota14'])=='S')	$nota14=S;	
	if((trim($fila2['nota14'])>0 && trim($fila2['nota14'])<=39) || trim($fila2['nota14'])=='I')		$nota14=NI;	

	if((trim($fila2['nota15'])>=60 && trim($fila2['nota15'])<=70) || trim($fila2['nota15'])=='MB')	$nota15=VG;	
	if((trim($fila2['nota15'])>=50 && trim($fila2['nota15'])<=59) || trim($fila2['nota15'])=='B')	$nota15=G;	
	if((trim($fila2['nota15'])>=40 && trim($fila2['nota15'])<=49) || trim($fila2['nota15'])=='S')	$nota15=S;	
	if((trim($fila2['nota15'])>0 && trim($fila2['nota15'])<=39) || trim($fila2['nota15'])=='I')		$nota15=NI;	

	if((trim($fila2['nota16'])>=60 && trim($fila2['nota16'])<=70) || trim($fila2['nota16'])=='MB')	$nota16=VG;	
	if((trim($fila2['nota16'])>=50 && trim($fila2['nota16'])<=59) || trim($fila2['nota16'])=='B')	$nota16=G;	
	if((trim($fila2['nota16'])>=40 && trim($fila2['nota16'])<=49) || trim($fila2['nota16'])=='S')	$nota16=S;	
	if((trim($fila2['nota16'])>0 && trim($fila2['nota16'])<=39) || trim($fila2['nota16'])=='I')		$nota16=NI;	

	if((trim($fila2['nota17'])>=60 && trim($fila2['nota17'])<=70) || trim($fila2['nota17'])=='MB')	$nota17=VG;	
	if((trim($fila2['nota17'])>=50 && trim($fila2['nota17'])<=59) || trim($fila2['nota17'])=='B')	$nota17=G;	
	if((trim($fila2['nota17'])>=40 && trim($fila2['nota17'])<=49) || trim($fila2['nota17'])=='S')	$nota17=S;	
	if((trim($fila2['nota17'])>0 && trim($fila2['nota17'])<=39) || trim($fila2['nota17'])=='I')		$nota17=NI;	

	if((trim($fila2['nota18'])>=60 && trim($fila2['nota18'])<=70) || trim($fila2['nota18'])=='MB')	$nota18=VG;	
	if((trim($fila2['nota18'])>=50 && trim($fila2['nota18'])<=59) || trim($fila2['nota18'])=='B')	$nota18=G;	
	if((trim($fila2['nota18'])>=40 && trim($fila2['nota18'])<=49) || trim($fila2['nota18'])=='S')	$nota18=S;	
	if((trim($fila2['nota18'])>0 && trim($fila2['nota18'])<=39) || trim($fila2['nota18'])=='I')		$nota18=NI;	

	if((trim($fila2['nota19'])>=60 && trim($fila2['nota19'])<=70) || trim($fila2['nota19'])=='MB')	$nota19=VG;	
	if((trim($fila2['nota19'])>=50 && trim($fila2['nota19'])<=59) || trim($fila2['nota19'])=='B')	$nota19=G;	
	if((trim($fila2['nota19'])>=40 && trim($fila2['nota19'])<=49) || trim($fila2['nota19'])=='S')	$nota19=S;	
	if((trim($fila2['nota19'])>0 && trim($fila2['nota19'])<=39) || trim($fila2['nota19'])=='I')		$nota19=NI;	

	if((trim($fila2['nota20'])>=60 && trim($fila2['nota20'])<=70) || trim($fila2['nota20'])=='MB')	$nota20=VG;	
	if((trim($fila2['nota20'])>=50 && trim($fila2['nota20'])<=59) || trim($fila2['nota20'])=='B')	$nota20=G;	
	if((trim($fila2['nota20'])>=40 && trim($fila2['nota20'])<=49) || trim($fila2['nota20'])=='S')	$nota20=S;	
	if((trim($fila2['nota20'])>0 && trim($fila2['nota20'])<=39) || trim($fila2['nota20'])=='I')		$nota20=NI;	


}
else{
			if(trim($fila2['nota1'])==MB) $nota1=VG;	if(trim($fila2['nota1'])==B) $nota1=G;	if(trim($fila2['nota1'])==I) $nota1=NI;
			if(trim($fila2['nota2'])==MB) $nota2=VG;	if(trim($fila2['nota2'])==B) $nota2=G;	if(trim($fila2['nota2'])==I) $nota2=NI;
			if(trim($fila2['nota3'])==MB) $nota3=VG;	if(trim($fila2['nota3'])==B) $nota3=G;	if(trim($fila2['nota3'])==I) $nota3=NI;
			if(trim($fila2['nota4'])==MB) $nota4=VG;	if(trim($fila2['nota4'])==B) $nota4=G;	if(trim($fila2['nota4'])==I) $nota4=NI;
			if(trim($fila2['nota5'])==MB) $nota5=VG;	if(trim($fila2['nota5'])==B) $nota5=G;	if(trim($fila2['nota5'])==I) $nota5=NI;
			if(trim($fila2['nota6'])==MB) $nota6=VG;	if(trim($fila2['nota6'])==B) $nota6=G;	if(trim($fila2['nota6'])==I) $nota6=NI;
			if(trim($fila2['nota7'])==MB) $nota7=VG;	if(trim($fila2['nota7'])==B) $nota7=G;	if(trim($fila2['nota7'])==I) $nota7=NI;
			if(trim($fila2['nota8'])==MB) $nota8=VG;	if(trim($fila2['nota8'])==B) $nota8=G;	if(trim($fila2['nota8'])==I) $nota8=NI;
			if(trim($fila2['nota9'])==MB) $nota9=VG;	if(trim($fila2['nota9'])==B) $nota9=G;	if(trim($fila2['nota9'])==I) $nota9=NI;
			if(trim($fila2['nota10'])==MB) $nota10=VG;	if(trim($fila2['nota10'])==B) $nota10=G;	if(trim($fila2['nota10'])==I) $nota10=NI;
			if(trim($fila2['nota11'])==MB) $nota11=VG;	if(trim($fila2['nota11'])==B) $nota11=G;	if(trim($fila2['nota11'])==I) $nota11=NI;
			if(trim($fila2['nota12'])==MB) $nota12=VG;	if(trim($fila2['nota12'])==B) $nota12=G;	if(trim($fila2['nota12'])==I) $nota12=NI;
			if(trim($fila2['nota13'])==MB) $nota13=VG;	if(trim($fila2['nota13'])==B) $nota13=G;	if(trim($fila2['nota13'])==I) $nota13=NI;
			if(trim($fila2['nota14'])==MB) $nota14=VG;	if(trim($fila2['nota14'])==B) $nota14=G;	if(trim($fila2['nota14'])==I) $nota14=NI;
			if(trim($fila2['nota15'])==MB) $nota15=VG;	if(trim($fila2['nota15'])==B) $nota15=G;	if(trim($fila2['nota15'])==I) $nota15=NI;
			if(trim($fila2['nota16'])==MB) $nota16=VG;	if(trim($fila2['nota16'])==B) $nota16=G;	if(trim($fila2['nota16'])==I) $nota16=NI;
			if(trim($fila2['nota17'])==MB) $nota17=VG;	if(trim($fila2['nota17'])==B) $nota17=G;	if(trim($fila2['nota17'])==I) $nota17=NI;
			if(trim($fila2['nota18'])==MB) $nota18=VG;	if(trim($fila2['nota18'])==B) $nota18=G;	if(trim($fila2['nota18'])==I) $nota18=NI;
			if(trim($fila2['nota19'])==MB) $nota19=VG;	if(trim($fila2['nota19'])==B) $nota19=G;	if(trim($fila2['nota19'])==I) $nota19=NI;
			if(trim($fila2['nota20'])==MB) $nota20=VG;	if(trim($fila2['nota20'])==B) $nota20=G;	if(trim($fila2['nota20'])==I) $nota20=NI;
}

//			if($fila['cod_subsector']==100001 || $fila['cod_subsector']==100002 || $fila['cod_subsector']==100003 || $fila['cod_subsector']==100004 || $fila['cod_subsector']==100005 || $fila['cod_subsector']==100006 || $fila['cod_subsector']==100007 || $fila['cod_subsector']==100008 || $fila['cod_subsector']==111 || $fila['cod_subsector']==288 ){	
			if($fila['cod_subsector']==100005 || $fila['cod_subsector']==100006 || $fila['cod_subsector']==100007 || $fila['cod_subsector']==100008 || $fila['cod_subsector']==111 || $fila['cod_subsector']==288 ){	?>
		          <td height="25"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $fila['nombre']; ?></font></div></td>
<?			}else{	?>
		           <td height="25"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
<?			}	?>

			<td width="18"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota1<40 && $nota1>0){ ?><font color="#FF0000"><? echo $nota1;?></font><? } else { echo $nota1; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota2<40 && $nota2>0){ ?><font color="#FF0000"><? echo $nota2;?></font><? } else { echo $nota2; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota3<40 && $nota3>0){ ?><font color="#FF0000"><? echo $nota3;?></font><? } else { echo $nota3; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota4<40 && $nota4>0){ ?><font color="#FF0000"><? echo $nota4;?></font><? } else { echo $nota4; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota5<40 && $nota5>0){ ?><font color="#FF0000"><? echo $nota5;?></font><? } else { echo $nota5; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota6<40 && $nota6>0){ ?><font color="#FF0000"><? echo $nota6;?></font><? } else { echo $nota6; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota7<40 && $nota7>0){ ?><font color="#FF0000"><? echo $nota7;?></font><? } else { echo $nota7; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota8<40 && $nota8>0){ ?><font color="#FF0000"><? echo $nota8;?></font><? } else { echo $nota8; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota9<40 && $nota9>0){ ?><font color="#FF0000"><? echo $nota9;?></font><? } else { echo $nota9; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota10<40 && $nota10>0){ ?><font color="#FF0000"><? echo $nota10;?></font><? } else { echo $nota10; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota11<40 && $nota11>0){ ?><font color="#FF0000"><? echo $nota11;?></font><? } else { echo $nota11; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota12<40 && $nota12>0){ ?><font color="#FF0000"><? echo $nota12;?></font><? } else { echo $nota12; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota13<40 && $nota13>0){ ?><font color="#FF0000"><? echo $nota13;?></font><? } else { echo $nota13; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota14<40 && $nota14>0){ ?><font color="#FF0000"><? echo $nota14;?></font><? } else { echo $nota14; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota15<40 && $nota15>0){ ?><font color="#FF0000"><? echo $nota15;?></font><? } else { echo $nota15; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota16<40 && $nota16>0){ ?><font color="#FF0000"><? echo $nota16;?></font><? } else { echo $nota16; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota17<40 && $nota17>0){ ?><font color="#FF0000"><? echo $nota17;?></font><? } else { echo $nota17; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota18<40 && $nota18>0){ ?><font color="#FF0000"><? echo $nota18;?></font><? } else { echo $nota18; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota19<40 && $nota19>0){ ?><font color="#FF0000"><? echo $nota19;?></font><? } else { echo $nota19; } ?></font></div></td>
			<td width="20"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? if($nota20<40 && $nota20>0){ ?><font color="#FF0000"><? echo $nota20;?></font><? }	if($nota20>=40 && $nota20<=70){	echo $nota20;}	if(trim($nota20)==VG || trim($nota20)==G || trim($nota20)==S || trim($nota20)==NI){ echo $nota20;} if($nota20==0){ echo "&nbsp;";}?></font></div></td>
			<? 
			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				if(trim($fila2['promedio'])==MB) $prom=VG;
				if(trim($fila2['promedio'])==B) $prom=G;
				if(trim($fila2['promedio'])==I) $prom=NI;
			}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  $promedio = ($promedio + $prom);
			} else {
				$ramo_religion = $fila['id_ramo'];
			}
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by id_periodo";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < @pg_numrows($resultPer) ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------
			  	$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_ramo = ".$id_ramo." and id_periodo = ".$periodos." ) order by id_periodo; ";
				$result_peri =@pg_Exec($conn,$sql_peri);
				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
						$prome_1 = "&nbsp;";
					} else {
/*						if ($fila_peri['promedio']>0){
							$prome_1 = round($fila_peri['promedio'],0);					
						} */
						if( $tipo_ense==110 && ($grado_curso==1 || $grado_curso==2) ){

							if(($fila_peri['promedio']>=60 && $fila_peri['promedio']<=70) || $fila_peri['promedio']=='MB')	$prome_1=VG;	
							if(($fila_peri['promedio']>=50 && $fila_peri['promedio']<=59) || $fila_peri['promedio']=='B')	$prome_1=G;	
							if(($fila_peri['promedio']>=40 && $fila_peri['promedio']<=49) || $fila_peri['promedio']=='S')	$prome_1=S;	
							if(($fila_peri['promedio']>0 && $fila_peri['promedio']<=39) || $fila_peri['promedio']=='I')		$prome_1=NI;	
							else {
								if(trim($fila_peri['promedio'])==MB) $prome_1=VG;
								if(trim($fila_peri['promedio'])==B) $prome_1=G;
								if(trim($fila_peri['promedio'])==I) $prome_1=NI;
							}
						} // fin if tipo_ense
						else{
							if ($fila_peri['promedio']>0){
								$prome_1 = round($fila_peri['promedio'],0);					
							} 
							else {
								if(trim($fila_peri['promedio'])==MB) $prome_1=VG;
								if(trim($fila_peri['promedio'])==B) $prome_1=G;
								if(trim($fila_peri['promedio'])==I) $prome_1=NI;
							}
						}
					}
				} else {
					$prome_1 = "&nbsp;";
				}
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099"><? 
					if($prome_1<40 && $prome_1>0){ ?><font color="#FF0000"><? 
						echo $prome_1;?></font><? 
					}
					else { 
						echo $prome_1; 
					} ?></font></td>								
				<?
			}
?>
		  </tr>
 <? } ?>		  
          <tr>
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">FINAL TERM GRADE <? //echo ucwords(strtolower($fila1['nombre_periodo']))?></font></strong></font></td>
			<?
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by id_periodo";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < @pg_numrows($resultPer) ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------
			  	$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano, tiene$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_periodo = ".$periodos." ) and tiene$nro_ano.id_ramo <> ".$ramo_religion." and tiene$nro_ano.rut_alumno = notas$nro_ano.rut_alumno and tiene$nro_ano.id_ramo = notas$nro_ano.id_ramo order by id_periodo; ";
				$result_peri =@pg_Exec($conn,$sql_peri);
				$prome_abajo = 0;
				$cont_abajo = 0;
		        for($pm=0 ; $pm < @pg_numrows($result_peri) ; $pm++)
				{
					$filapm = @pg_fetch_array($result_peri,$pm);							
					if ($filapm['promedio']>0){
						$prome_abajo = $prome_abajo + $filapm['promedio'];
						$cont_abajo = $cont_abajo + 1;
					}
				}
				if ($prome_abajo>0){
					$prome_abajo = round($prome_abajo/$cont_abajo,0);
					$prome_general_pro = $prome_general_pro + $prome_abajo;
					$cont_general_pro = $cont_general_pro + 1;
				}
				if ($periodos<>$periodo)
					 $prome_abajo = 0;
				else
					 $promedio_periodo_aux = $prome_abajo;
					 
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#000099">
					<? 
/*						if($prome_abajo>0){ 
							if($prome_abajo<40 && $nota1>0){ ?><font color="#FF0000"><? 
								echo $prome_abajo;?></font><? 
							} 
							else { 
								echo $prome_abajo; 
							}
						}
						else{ echo "&nbsp;";} ?></font></td>								
						 */
						if( $tipo_ense==110 && ($grado_curso==1 || $grado_curso==2) ){
							if($prome_abajo==0)	echo $prome_abajo='&nbsp;';
							if(($prome_abajo>=60 && $prome_abajo<=70) || $prome_abajo=='MB')	echo $prome_abajo='VG';	
							if(($prome_abajo>=50 && $prome_abajo<=59) || $prome_abajo=='B')		echo $prome_abajo='G';	
							if(($prome_abajo>=40 && $prome_abajo<=49) || $prome_abajo=='S')		echo $prome_abajo='S';	
							if(($prome_abajo>0 && $prome_abajo<=39) || $prome_abajo=='I')		echo $prome_abajo='NI';	
						}	// fin if tipo ense
						else{
							if($prome_abajo>0){ 
								if($prome_abajo<40 && $nota1>0){ ?><font color="#FF0000"><? 
									echo $prome_abajo;?></font><? 
								} 
								else { 
									echo $prome_abajo; 
								}
							}
							else{ 
								echo "&nbsp;";
							} 
						}						
							?></font></td>								
				<?
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			?>
          </tr>
		 

        </table>
		        
		<? } //for?>
		<? } //if?> 
		<? //} // ************************* ?> 

		<br>
		<HR width="100%" color=#003b85>
                <!--    boton editar --->
                <div id="capa1">
				<?	if (pg_numrows($result_alu)==1){ ?>
				<input name="button4" TYPE="button" class="botonX" onClick=window.open("observacion_informe.php?id_curso=<? echo $curso ?>&rut_alumno=<? echo $alumno ?>&id_periodo=<? echo $periodo ?>&curso_aux=<? echo $c_curso?>&alumno_aux=<? echo $c_alumno?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=85,left=140") onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="EDITAR">			  
		 <? } ?>
		  </div>
<!--    fin boton editar --->

		<table width="650" height="38" border="0" cellpadding="0" cellspacing="0"> 
		  <tr>
			<td height="16"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif" color="#000099">Teacher's Comments and Action Plan:</font></strong></font></div></td>
		  </tr>
		</table>

		<table width="650" height="119" border="1" cellpadding="0" cellspacing="0" >
			<tr>
				<td valign="top">
				<?  
					$sql_observa = "select * from observacion_evaluacion where rut_alumno='".$alumno."' AND id_periodo=".$periodo."";
					$result_observa =@pg_Exec($conn,$sql_observa);
					$fila_observa = @pg_fetch_array($result_observa,0);	
					if (!empty($fila_observa['glosa']))
						echo $fila_observa['glosa'];
					else
						echo "&nbsp;";
				
				?>
				</td>
			</tr>
		</table>			   
		        <table width="650" border="0" cellpadding="0" cellspacing="0">
				  <?
				  for($e=0 ; $e < 12-$num_subsec ; $e++)
				  {
				  ?>
                  <tr> 
                    <td width="450">&nbsp;</td>
                    <td width="200">&nbsp;</td>
                  </tr>
				  <? }?>
					<br><p>&nbsp;</p>
					<br><p>&nbsp;</p>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="200"><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">________________________________</font></strong></div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="200"><div align="center"><font face="Arial, Helvetica, sans-serif" size="1">Teacher's Signature </font></div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="200"><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"><? echo $nombre_profe; ?> </font></strong></div></td>
                  </tr>
                </table>
              </div>
		</td>
      </tr>
    </table>
	<br>
	<span class="style4"><font size="1">Note: Final Grade is made up of Parcial Grade and Ongoing Assessment. The Parcial Grade of the subject Religion does not influence in the Final Grade.</font></span>
	<table width="650" border="1" cellpadding="0" cellspacing="0" bordercolor="#000099">
		<tr>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">VG</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Very Good</font></strong></div>
			  <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Muy Bueno</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">G</font></strong></div>
			  <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Good</font></strong></div>
			  <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Bueno</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">S</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Satisfactory</font></strong></div>
			  <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Satisfactorio</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">NI</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Needs Improvements</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Necesita Mejorar</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">OA</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Ongoing Assessment</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Apreciación Personal</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">PG</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Parcial Grades</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Notas Parciales</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">FT</font></strong> </div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Final Term</font></strong></div>
			  <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Promedio Final</font></strong></div></td>
		  <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">FG</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Final Grade</font></strong></div>
		      <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">Promedio Anual</font></strong></div></td>
		  </tr>
	</table>
	
	
	</td>
  </tr>
    </table>
 <? 

 if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina></H1>"; ?>

</center>
		<? }  ?> 
</form>
</body>
</html>

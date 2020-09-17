<?php require('../../../../../util/header.inc');

$fecha = time();
$dd = date(d);
$mm = date(m);
$aa = date(Y);
$fechahoy = "$dd-$mm-$aa";

$institucion	=$_INSTIT;
$frmModo		=$_FRMMODO;
$ano			=$_ANO;
$alumno			=$_ALUMNO;
$curso			=$_CURSO;
$_POSP          =5;
$_bot           = 5;

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=alumno_$fechahoy.xls");


	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="131">			
			<?
			$sql10 = "select id_curso from matricula where rut_alumno = ".trim($alumno)." and id_ano = ".trim($ano);
			$result10 =@pg_Exec($conn,$sql10);
			if (!$result10) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}
			else
			{
				if (pg_numrows($result10)!=0)
				{
					$fila10 = @pg_fetch_array($result10,0);	
					if (!$fila10)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
			
			
			$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit ";
			$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
			
			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>'.$sql);
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
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													$ano_act = trim($fila1['nro_ano']);
												
												}
											}
				

			?>
              <tr>
                <td width="133"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>INSTITUCI&Oacute;N</strong> <? echo "($institucion)" ?></font> </div></td>
                <td width="8"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td width="350"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['nombre_instit']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>AÑO ESCOLAR <? echo "($ano)" ?></strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['nro_ano']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>CURSO <? echo "($curso)" ?></strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['grado_curso']). "-" . trim($fila['letra_curso']) . " " . trim($fila['nombre_tipo']) ?></strong></font></div></td>
              </tr>	
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>ALUMNO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']));?></strong></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>
				<?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result4 =@pg_Exec($conn,$sql4);
				if (!$result4) 
				{
					error('<B> ERROR :</b>Error al acceder a la BD. (100)</B>');
				}
				else
				{
					if (pg_numrows($result4)!=0)
					{
						$fila4 = @pg_fetch_array($result4,0);	
						if (!$fila4)
						{
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
				}
				echo strtoupper(trim($fila4['ape_pat']) . " " . trim($fila4['ape_mat']) . " " . trim($fila4['nombre_emp']));
				$nombre_profe = strtoupper(trim($fila4['ape_pat']) . " " . trim($fila4['ape_mat']) . " " . trim($fila4['nombre_emp']));
				?>
				</strong></font></div></td>
              </tr>
            </table>
			<br></td>
          </tr>
        </table></td>
      </tr>
      <!-- <tr>
        <td height="20" class="tableindex" width="5"><div align="center">NOTAS PARCIALES DEL ALUMNO</div></td>
      </tr> -->
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $sql = "select  * from periodo where id_ano = ".$ano." order by id_periodo" ;
		  $result1 =@pg_Exec($conn,$sql);
		  if (!$result1) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (1000)</B>');
    		}
		  else
    		{
    			if (pg_numrows($result1)!=0)
			  {
				  $fila1 = @pg_fetch_array($result1,0);	
				  if (!$fila1)
				  {
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
				$id_periodo = $fila1['id_periodo'];
				$sql8 = "select count(*) as contador from notas$ano_act where id_periodo = ". $id_periodo . " and rut_alumno = " . $alumno;

			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (10000)</B>');
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
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  
		  
		  <tr>
            <td width="231"><div align="left"></div>
              <strong>
              <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $fila1['nombre_periodo'] ?></font></div></td>
            <td colspan="20"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></div></td>
            <td width="15" ><strong><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</font></strong></td>
			
            </tr>  
         
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = $sql2 . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden; ";

          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (100000)</B>');
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
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$nombre	= $fila['nombre'];
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$ano_act.* ";
			$sql3 = $sql3 . "FROM notas$ano_act WHERE (((notas$ano_act.rut_alumno)='".$alumno."') AND ((notas$ano_act.id_ramo)=".$id_ramo.") AND ((notas$ano_act.id_periodo)=".$id_periodo.")); ";

			$result2 =@pg_Exec($conn,$sql3);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (10020)</B>');
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
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";
					if ($fila2['promedio']>0) $prom = $fila2['promedio']; else $prom = "&nbsp;";																																																																												
				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="") $nota1 = "&nbsp;.";  else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;."; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;."; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;."; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;."; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;."; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;."; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;."; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;."; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;."; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;."; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;."; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;."; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;."; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;."; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;."; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;."; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;."; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;."; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp; ."; else $nota20 = $fila2['nota20'];
					if (chop($fila2['promedio'])=="0" or chop($fila2['promedio'])=="")  $prom = "&nbsp; ."; else $prom = $fila2['promedio'];
				}
			?>
            <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota1<40 && $nota1>0){ ?><font color="#FF0000"><? echo $nota1 ?></font><? } else { echo $nota1; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota2<40 && $nota2>0){ ?><font color="#FF0000"><? echo $nota2 ?></font><? } else { echo $nota2; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota3<40 && $nota3>0){ ?><font color="#FF0000"><? echo $nota3 ?></font><? } else { echo $nota3; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota4<40 && $nota4>0){ ?><font color="#FF0000"><? echo $nota4 ?></font><? } else { echo $nota4; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota5<40 && $nota5>0){ ?><font color="#FF0000"><? echo $nota5 ?></font><? } else { echo $nota5; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota6<40 && $nota6>0){ ?><font color="#FF0000"><? echo $nota6 ?></font><? } else { echo $nota6; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota7<40 && $nota7>0){ ?><font color="#FF0000"><? echo $nota7 ?></font><? } else { echo $nota7; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota8<40 && $nota8>0){ ?><font color="#FF0000"><? echo $nota8 ?></font><? } else { echo $nota8; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota9<40 && $nota9>0){ ?><font color="#FF0000"><? echo $nota9 ?></font><? } else { echo $nota9; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota10<40 && $nota10>0){ ?><font color="#FF0000"><? echo $nota10 ?></font><? } else { echo $nota10; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota11<40 && $nota11>0){ ?><font color="#FF0000"><? echo $nota11 ?></font><? } else { echo $nota11; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota12<40 && $nota12>0){ ?><font color="#FF0000"><? echo $nota12 ?></font><? } else { echo $nota12; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota13<40 && $nota13>0){ ?><font color="#FF0000"><? echo $nota13 ?></font><? } else { echo $nota13; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota14<40 && $nota14>0){ ?><font color="#FF0000"><? echo $nota14 ?></font><? } else { echo $nota14; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota15<40 && $nota15>0){ ?><font color="#FF0000"><? echo $nota15 ?></font><? } else { echo $nota15; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota16<40 && $nota16>0){ ?><font color="#FF0000"><? echo $nota16 ?></font><? } else { echo $nota16; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota17<40 && $nota17>0){ ?><font color="#FF0000"><? echo $nota17 ?></font><? } else { echo $nota17; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota18<40 && $nota18>0){ ?><font color="#FF0000"><? echo $nota18 ?></font><? } else { echo $nota18; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota19<40 && $nota19>0){ ?><font color="#FF0000"><? echo $nota19 ?></font><? } else { echo $nota19; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota20<40 && $nota20>0){ ?><font color="#FF0000"><? echo $nota20 ?></font><? } else { echo $nota20; } ?></font></div></td>
			<? 
			if (($prom <> 0) and ($nombre<>"RELIGION"))
			  {
			  $cont_prom=$cont_prom+1;
			  //echo "Contador ". $cont_prom. "<br>";
			  $promedio = ($promedio + $prom);
			  //echo "Suma" . $promedio ;
			  }
			?>
            <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? 
					if($prom<40 && $prom>0){ ?><font color="#FF0000"><? 
						 echo $prom; ?></font><? 
					}
					else { 
						echo $prom; 
					}?></font></div></td>
          </tr>
		  <? } ?>
        </table>
		
			<? 
			if (($promedio > 0) and ($nombre!='RELIGION')) 
			{
				echo $promedio = round($promedio / $cont_prom,0);
				$promedio_gen = $promedio_gen + $promedio;
				$cont_promgen=$cont_promgen +1;
			}
			else
				echo "&nbsp;";
			
			?>
			
		<? } //for?>
		<? } //if?>
      <? pg_close($conn); ?>  
      </body>
</html>

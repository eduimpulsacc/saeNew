<? include "../Coneccion/conexion.php" ?>
<script>
function imprimir() 
{

	document.getElementById("capa0").style.display='none';
	window.print();

	document.getElementById("capa0").style.display='block';
}
	</script>
<?php 
//		$institucion	=$_INSTIT;
//		$frmModo		=$_FRMMODO;
//		$ano			=$_ANO;
//		$alumno			=$_ALUMNO;
//		$curso			=$_CURSO;
	
	$institucion = $_GET["as_institucion"];
	$alumno = $_GET["as_alumno"];
	$ano = $_GET["ai_ano"];

	
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
	  <div id="capa0">
	    <input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	  </div>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="131"><?php
						$result = @pg_Exec($conexion,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);

						$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conexion,$output);
						
					?><!--img src=../../../../../../../tmp/<?php echo $institucion ?> ALT="NO DISPONIBLE"  width=100 ></td>
            <td width="503"><table width="504" border="0" cellpadding="0" cellspacing="0"-->
			
			<?
			$sql20 = "select id_ano from ano_escolar where nro_ano = " . $ano . " and id_institucion = " . $institucion;
			$result10 =@pg_Exec($conexion,$sql20);
			if (!$result10) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (0)</B>');
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
			$ano = $fila10['id_ano'];
			//---------------------------
			$sql10 = "select id_curso from matricula where rut_alumno = " . $alumno. " and id_ano = " . $ano;
			
			$result10 =@pg_Exec($conexion,$sql10);
			if (!$result10) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (0)</B>');
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
			$curso = $fila10['id_curso'];

			$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit ";
			$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";

			$result =@pg_Exec($conexion,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (La chinga)</B>');
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
			?>
              <tr>
                <td width="133"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="8"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td width="350"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['nombre_instit']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>AÑO ESCOLAR</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['nro_ano']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>CURSO</strong></font></div></td>
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
				$result =@pg_Exec($conexion,$sql4);
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
				echo strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']));
				$nombre_profe = strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']));
				?>
				</strong></font></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" >&nbsp;</td>
      </tr>
      <tr>
        <td height="20" bgcolor="#003b85"><div align="center"><font face="arial, geneva, helvetica" size="2" color="#ffffff">
					    <strong>INFORME  DE NOTAS PARCIALES </strong></font></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $sql = "select  * from periodo where id_ano = ".$ano." order by id_periodo" ;
		  $result1 =@pg_Exec($conexion,$sql);
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
				$result13 =@pg_Exec($conexion,$sql13);
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
				$dias_asistidos = $dias_habiles - $fila13['cantidad'];
				//--
				$sql8 = "select count(*) as contador from notas where id_periodo = ". $id_periodo . " and rut_alumno = " . $alumno;
			    $result18 =@pg_Exec($conexion,$sql8);
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
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231"><div align="left"></div>
              <strong>
              <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $fila1['nombre_periodo'] ?></font></div></td>
            <td colspan="20"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></div></td>
            <td width="33" ><strong><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</font></strong></td>
			
            </tr>
         
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = $sql2 . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.")); ";

          $result =@pg_Exec($conexion,$sql2);
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
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas.nota1, notas.nota2, notas.nota3, notas.nota4, notas.nota5, notas.nota6, notas.nota7, notas.nota8, notas.nota9, notas.nota10, notas.nota11, notas.nota12, notas.nota13, notas.nota14, notas.nota15, notas.nota16, notas.nota17, notas.nota18, notas.nota19, notas.nota20, notas.promedio ";
			$sql3 = $sql3 . "FROM notas WHERE (((notas.rut_alumno)='".$alumno."') AND ((notas.id_ramo)=".$id_ramo.") AND ((notas.id_periodo)=".$id_periodo.")); ";

			$result2 =@pg_Exec($conexion,$sql3);
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
            <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
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
				
			if (number_format($prom) > 0 ) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			}
			?>
            <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){echo "&nbsp;";}else{echo $fila2['promedio'];}  ?></font></div></td>
          </tr>
		  <? } ?>
        </table>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="461">&nbsp;</td>
            <td width="153"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio Per&iacute;odo </font></strong></font></div></td>
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
		  <tr>
            <td>&nbsp;</td>
            <td><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Porcentaje Asistencia</font></strong></font></div></td>
            <td><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? 
			$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
			$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
			$prom_cont_asis = $prom_cont_asis + 1;
			//$promedio_asistencia = 100 - $promedio_asistencia;
			if ($promedio_asistencia ==0){
			     $promedio_asistencia = 100;
			    }	  
			echo $promedio_asistencia . "%" ;
			    
			?>
			</font></strong></font></div></td>
          </tr>
        </table>
		<? } //for?>
		<? } //if?> 
		<table width="650" border="0" cellpadding="0" cellspacing="0">
		  	<HR width="100%" color=#003b85>
			<td width="461">&nbsp;</td>
		    <td width="153"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Promedio General </font></strong></font></div></td>
		    <td width="36"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">
			<? 
			//echo "contador " . $cont_promgen . "<br>" . "suma " . $promedio_gen  ;
			if ($promedio_gen > 0) 
				echo $promedio_gen  = round($promedio_gen  / $cont_promgen,0);
			else
				echo "&nbsp;";
			?>	</font></strong></font></div>			</td>
		  </tr>
		   <tr>
		    <td>&nbsp;</td>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Porcentaje  Asistencia</font></strong></font></div></td>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif"><? 
			$porcentaje_asistencia = round($prom_gen_asis  /  $prom_cont_asis,2);
			if ($porcentaje_asistencia ==0){
			     $porcentaje_asistencia = 100;
			    }	  
			echo $porcentaje_asistencia . "%";
			?>
			</font></strong></font></div></td>
		    </tr>
		  <tr>
		</table>
		
		<div id="capa1">
		<table width="650" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:_______________________________________________________________</font></strong></font></div></td>
		  </tr>
		  <tr>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		  <tr>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		  <tr>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		  <tr>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		</table>
		        <table width="650" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Profesor(a) 
                        Jefe </font></div></td>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Director(a) 
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
			$result =@pg_Exec($conexion,$sql);
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
			echo trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']);
			?>
                        </font></strong></div></td>
                  </tr>
                </table>
		</div>
		</td>
      </tr>
    </table>
	<tr> 
    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></strong></div></td>
    </tr>
	<tr> 
    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></strong></div></td>
    </tr>
	<tr> 
    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
    </tr>
	<tr> 
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Firma Apoderado </font></div></td>
    </tr>
	</td>
  </tr>
</table>
</td>
</tr>
</table>
</center>
</body>
</html>

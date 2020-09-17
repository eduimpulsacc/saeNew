<table width="650" border="0" align="center">
  <tr>
    <td class="tableindex"><div align="center">INFORME DE NOTAS </div></td>
  </tr>
    
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($periodo_pal))?></strong></font></div></td>
      </tr>
  
 
</table>
<br />
<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $prome_semestral_ap=0;
		  
		  for($i=0 ; $i < @pg_numrows($result1) ; $i++) { // INICIO FOR
			
			$fila1 = @pg_fetch_array($result1,$i);
			
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				 {
					echo '<div align="center"><b> DEBE INGRESAR FECHAS Y DIAS HÁBILES PARA PERÍODOS </b> 
					      <br>Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">
					      ir a Periodos</a>  e ingresar la información requerida...<br><br></div>';
				    exit; }	
				
			$id_periodo = $fila1['id_periodo'];

				$sql8 = "select count(*) as contador from notas$nro_ano where id_periodo = ". $id_periodo . " and rut_alumno = '" . $alumno."'";
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
				$ob_reporte ->ano = $ano;
				$resultPer = $ob_reporte ->TotalPeriodo($conn);
				for($m=0;$m<@pg_numrows($resultPer);$m++){
					$fila_per = @pg_fetch_array($resultPer,$m);
					if($m==0){
					$primer_periodo = $fila_per['id_periodo'];
					}
				}
			
			
		} // FIN FOR
			
		
				?>	
				
<!--INICIO DE INFORME DE NOTAS GENERAL-->				
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="279" class="item">Subsector del Aprendizaje <br />
    (Formaci&oacute;n General)</td>
    <td colspan="20" class="subitem"><div align="center">Notas</div></td>
     <? 
	 		if($tipo_rep!=4){
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			
			if($institucion==1914){
				if($primer_periodo==$periodo){
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
					
            <?	}
			}else{?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<? } 
			if($tipo_eval==2){ ?>
				    <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>Aprec &nbsp;1º<? echo $tipo_per ?></strong></font></td>
			<? }
				if($tipo_rep==2){ 
					if($institucion==1914){	
						if($primer_periodo==$periodo){?>					
					    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			<? 			}
					}else{ ?>
					   <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			<?		}	
				}
			}	
			
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
         	<? if($tipo_eval==2){ ?>
				    <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>
				      Aprec &nbsp;2º<? echo $tipo_per ?></strong></font></td>
			        <? }	
				if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
				      Curso</strong></font></td>
		<? 		}
			}
			
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>										            <? if($tipo_eval==2){ ?>
			   <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>
			     Aprec</strong></font></td>
			<? }
			if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			        <? }
             } 
			
			}
			
			} // fin tipo_rep?>
  </tr>
  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion=1;
		  if($ck_alumnos==1){
			  $ob_reporte ->RamoAlumnoEximido($conn);
		  }else{
			  $ob_reporte ->RamoFormacion($conn);
		  }
          $result =$ob_reporte ->result;
		  if (!$result){
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
    	  }else{
    			if (pg_numrows($result)!=0){
				  $fila = @pg_fetch_array($result,0);	
				  if (!$fila){
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  
		  $num_subsec = pg_numrows($result);
		  $prome_semestral = 0;
		  $cuenta_semestral =0;	
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$artistico = $fila['bool_artis']; }
				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = pg_exec($conn,$sql_pocentaje);
			    $pos21=pg_result($resp,0);
			    ////////////////////////FIN PORCENTAJES///////////
				
 ?> <tr> <?
		 
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (99)</B>');
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
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
			?>
<td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">

<? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239))
{ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoción)"; }?>

</font></div>   </td>

<? if($tipo_eval==1){?>
					
<td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos1 = porcentaje($periodo,$fila['id_ramo'],'pos1',$ob_reporte->nota1,$conn,$ano); 	}else{ if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos2 = porcentaje($periodo,$fila['id_ramo'],'pos2',$ob_reporte->nota2,$conn,$ano);	}else{ if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos3 = porcentaje($periodo,$fila['id_ramo'],'pos3',$ob_reporte->nota3,$conn,$ano);	}else{ if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos4 = porcentaje($periodo,$fila['id_ramo'],'pos4',$ob_reporte->nota4,$conn,$ano);	}else{ if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos5 = porcentaje($periodo,$fila['id_ramo'],'pos5',$ob_reporte->nota5,$conn,$ano);	}else{ if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos6 = porcentaje($periodo,$fila['id_ramo'],'pos6',$ob_reporte->nota6,$conn,$ano);	}else{ if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos7 = porcentaje($periodo,$fila['id_ramo'],'pos7',$ob_reporte->nota7,$conn,$ano);	}else{ if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos8 = porcentaje($periodo,$fila['id_ramo'],'pos8',$ob_reporte->nota8,$conn,$ano);	}else{ if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos9 = porcentaje($periodo,$fila['id_ramo'],'pos9',$ob_reporte->nota9,$conn,$ano);	}else{ if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos10 = porcentaje($periodo,$fila['id_ramo'],'pos10',$ob_reporte->nota10,$conn,$ano); }else{ if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos11 = porcentaje($periodo,$fila['id_ramo'],'pos11',$ob_reporte->nota11,$conn,$ano); }else{ if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos12 = porcentaje($periodo,$fila['id_ramo'],'pos12',$ob_reporte->nota12,$conn,$ano); }else{ if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos13 = porcentaje($periodo,$fila['id_ramo'],'pos13',$ob_reporte->nota13,$conn,$ano); }else{ if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos14 = porcentaje($periodo,$fila['id_ramo'],'pos14',$ob_reporte->nota14,$conn,$ano); }else{ if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos15 = porcentaje($periodo,$fila['id_ramo'],'pos15',$ob_reporte->nota15,$conn,$ano); }else{ if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos16 = porcentaje($periodo,$fila['id_ramo'],'pos16',$ob_reporte->nota16,$conn,$ano); }else{ if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos17 = porcentaje($periodo,$fila['id_ramo'],'pos17',$ob_reporte->nota17,$conn,$ano); }else{ if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos18 = porcentaje($periodo,$fila['id_ramo'],'pos18',$ob_reporte->nota18,$conn,$ano); }else{ if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos19 = porcentaje($periodo,$fila['id_ramo'],'pos19',$ob_reporte->nota19,$conn,$ano); }else{ if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos20 = porcentaje($periodo,$fila['id_ramo'],'pos20',$ob_reporte->nota20,$conn,$ano); }else{ if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong><? }?></div></td>
                   
				   <? }else{?>
				   
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1.'</font>'; } else { echo $ob_reporte->nota1; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
<? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
<? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?>
</font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?>
</font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?>
</font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?>
</font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?>
</font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?>
</font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10. '</font>'; } else { echo $ob_reporte->nota10; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong></div></td>
<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong></div></td>
				
				 <? } 
				 
				 
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19+$pos20;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//if($_PERFIL==0) echo "<br>".$periodos;
					$prome_ap=0;	
					$prome_abajo_ap=0;	}
																																																						
					
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;																																													
					$result_peri =$ob_reporte ->Notas($conn);
				
					if (pg_numrows($result_peri)>0){
						$fila_peri = @pg_fetch_array($result_peri,0);
						if($tipo_eval==2){
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
									$prome_ap="&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);
										$prome_ap = round($fila_peri['notaap'],0);										
									} else {
										$prome_1 = $fila_peri['promedio'];
										$prome_ap = $fila_peri['notaap'];										
									}
								}
							}else{
								$prome_1=$fila_peri['promedio'];
								$prome_ap = $fila_peri['notaap'];										
							}
						}else{
	
	if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
								}
								
						}
					} else {
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						if(@pg_numrows($rs_eximido)==0 and $artistico!=1){
							$prome_1="EX";
						}else{
							$prome_1 = "&nbsp;";
						}
						
						//$prome_1="&nbsp;";
						
					}
					
					if($tipo_eval==1){
					  	if($pos21=="100"){
					  		$prome_1 = $prom_pos;
					  	}
					}					
					
					///// acomulo promedio para mostrar al final ///
					if ($prome_1>0){
						
						$prome_semestral = $prome_semestral + $prome_1;
						$cuenta_semestral = $cuenta_semestral + 1;
						$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
						
					}				
					
					if($institucion==1914){
						if($periodos==$periodo){ ?>
					<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000">
					<? echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
					<? 	}
					
					}else{?>
                      
					  <td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0){ ?>
                      <strong><font color="#FF0000"><? echo $prome_1 ?></font><? } 
                      else { echo $prome_1; } ?></strong></td>
					                  
					<? }
					if($tipo_eval==2){
					?>
					<td align="center" bgcolor="#CCCCCC"><font  size="1" face="Arial, Helvetica, sans-serif"><strong><i><?=$prome_ap;?></i></strong></font></td>
					<? } 
					
					
					 if($tipo_rep==2){
					  	/*	$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);
							if($_PERFIL==0) echo $ob_reporte->suma_curso."---".$ob_reporte->contador_curso;*/
	                     $sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador 
	                            FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND promedio NOT IN('0','MB','B','S','I',' ')  ";
							if($periodos!=""){
								$sql.="AND id_periodo=".$periodos."";
							}
							
							$rs_prom_curso = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
							$suma_curso = pg_result($rs_prom_curso,0);
							$contador_curso = pg_result($rs_prom_curso,1);
							
							$prom_curso = intval($suma_curso / $contador_curso);
							
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
							if ($prom_curso>0){
							    $suma_prom_curso = $suma_prom_curso + $prom_curso;
								$cont_prom_curso++;
							}	
							if($institucion==1914){
								if($periodos==$periodo){ ?>
									<td  align="center" class="subitem"><?=$prom_curso;?></td>
							<? 	}
							}else{?>
							  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?		}
						}

//FIN DE NOTAS GENERALES

				} 
				
	
		
				
				?>

</tr>
</table>
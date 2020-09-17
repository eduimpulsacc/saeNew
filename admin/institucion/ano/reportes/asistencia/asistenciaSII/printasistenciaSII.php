
<?php
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');
//print_r($_POST);
	$_POSP = 5;
	$_bot = 8;
	$institucion	= $_INSTIT;
	$ano			= $select_anos;
	$curso			= 1;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$alumno			= $cmb_alumno;	
	$reporte		= $c_reporte;
	$retirado		= $opc_ret;
	



	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Asistencia_".$institucion."_".date("d_m_Y").".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
	
	
	
	

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
 
	
	
	/********** AÑO ESCOLAR CURSO*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	
	
	

		/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
		
	
	
	
	
	
		
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =$retirado;
		//$ob_reporte ->orden =$ck_orden;
		//$result_alu =$ob_reporte ->promocionAsistencia($conn);
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);



?>


        
 		<table width="650"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td><table  width="650" border="1" align="center"  style="border-collapse:collapse">
        <tr class="tableindex">
        <? if($ckRUT==1){?>
          <td align="center">ALUMNO</td>
        <? } 
		if($ckNOMBRE==1){?>
          <td align="center">NOMBRE</td>
        <? }
		if($ckPORCENTAJE==1){?>
          <td align="center">% Asistencia</td>
        <? } ?>
        </tr>
       <?php 
	    for($a=0;$a<pg_numrows($result_alu);$a++){ 
		
		   $fila_alu = pg_fetch_array($result_alu,$a);
		    
			
		   if($fila_alu['asistencia']>0){
			   $asis_porc = $fila_alu['asistencia'];
			  }
			  else{
				//$asis_porc = 655; 
				$ob_reporte->_idcurso=$fila_alu['id_curso'];
				$ob_reporte->_rutalumno=$fila_alu['rut_alumno'];
				$rs_fechas =$ob_reporte->fechasCurso($conn);
				$fila_fechas = pg_fetch_array($rs_fechas,0);
				
				//calculo de asistencia
				$feriados_ano=0;
				$fera=0;
					
				 $curso=$fila_alu['id_curso'];
				 $rut_alumno = $fila_alu['rut_alumno'];
				 $finicio_curso=$fila_fechas['fecha_inicio'];
				 $ftermino_curso=$fila_fechas['fecha_termino'];
				 $fecha_matricula = $fila_fechas['fecha'];
				 $retirado = $fila_fechas['bool_ar'];
				 $fecha_retiro = $fila_fechas['fecha_retiro'];	
				 
				 	//si tengo fechas en el curso
		 if($finicio_curso!= "" && $finicio_curso!= "1111-11-11"){
			//echo "1";
			//*********** habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($fecha_matricula <= $finicio_curso)
				{$fini= $finicio_curso;}
				else
				{$fini= $fecha_matricula;}
				
				
				
				//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
				if($retirado==1){
				 $fter =$fecha_retiro;
				}else{
				 $fter = $ftermino_curso;
				}
				
		
			 
		}
		//si el curso no tiene fechas, se calcula con el inicio del año
		else
		{
			//echo "2";
				if($fecha_matricula <= $fincio_ins)
				{$fini= $fincio_ins;}
				else
				{$fini= $fecha_matricula;}
				
				
				
				//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
				if($retirado==1){
				 $fter =$fecha_retiro;
				}else{
				 $fter = $ftermino_ins;
				}	
			
		} 
		
		 $habiles_ano=hbl($fini,$fter);
		
		//feriados del año 
		 $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);
	
	for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
	 	  $feriados_ano=$fera;
		 
		 //dias reales año
	  $habil_real_ano = $habiles_ano-$feriados_ano;
	//inasistencias
	  $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	
	//justificadas

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
		 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $asis_porc = round((100* $con_total_inano)/$habil_real_ano);
				
		}//fin calculo fechas si no tengo promicion
		
		   ?>
        <tr class="textosimple">
        <? if($ckRUT==1){ ?>
          <td align="left"><?php echo $fila_alu['rut_alumno'] ?>-<?php echo strtoupper($fila_alu['dig_rut']) ?></td>
        <? }
		if($ckNOMBRE==1){?>
	      <td align="left"><?php echo $fila_alu['nombre_alu']." ".$fila_alu['ape_pat']." ".$fila_alu['ape_mat']; ?></td>
        <? }
		if($ckPORCENTAJE==1){?>
          <td align="center"><?php echo $asis_porc ?></td>
        <? } ?>
        </tr>
        <?php  } ?>
        </table>     
		
   </td>
	  </tr>
</table>
</body>

</html>

<? pg_close($conn);?>
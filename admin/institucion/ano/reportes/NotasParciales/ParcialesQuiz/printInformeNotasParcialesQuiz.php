<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
?>
<?
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');
	
	/*if($_PERFIL==0){
		echo "<pre>";
		print_r($_GET);
		echo "<pre>";
		}*/

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;
	$periodo		=$cmb_periodos;
	$taller			=$opc_Taller;
	$estadistica	=$opc_estadistica;
	$obs			=$opc_obs;
	$tipo_rep		=$tipo_rep;
	$anotacion		=$opc_Anotacion;
	$colilla		=$opc_Colilla;
	$muestra_notas	=$Mnotas;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	
	
	/**********periodo quiz activo**********/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->TraePeriodoActivo($conn);
	$peractivo = $ob_reporte->id_periodo;
	
	
	

	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		$fecha = strftime("%d %m %Y");		
}				  


   if ($institucion==770){
	    // DATOS CURSO //
		//--------------------------------------------------------------------------	
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per,curso.truncado, curso.truncado_final ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		$truncado_per = $fila_curso['truncado_per'];
		$truncado_final = $fila_curso['truncado_final'];
		 $truncado = $fila_curso['truncado'];
		//----------------------------------------------------------------------------
	}	

				  

	if($cb_ok!="Buscar"){
		$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Parciales_alumno_$fecha_actual.xls"); 	 
	}


?>

  <?php //promedios quiz
	
	$sql_pquiz ="select * from quiz_periodos where id_ano=".$ano." order by id_periodo";
	$res_pquiz = pg_exec($conn,$sql_pquiz);
	$cont_pquiz = @pg_num_rows($res_pquiz);
	
	?>

<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE NOTAS PARCIALES</title>
<STYLE>
  H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;
 }
.textoverital{writing-mode: tb-rl;filter: flipv fliph;}

.rojo{color:red;}
.azul{color:black;}
</style>
</head>
<!---->
<body onLoad="window.print()">
<div id="capa0">
<!--<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>-->
</div>
<?
	if (empty($alumno)){
	
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$ob_reporte ->orden =$ck_orden;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);

	
	
	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos; $cont_paginas++)
{
	$suma_prom_gral=0;
	$cont_prom_gral=0;
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$suma_prom_curso = 0;
	$cont_prom_curso = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	
	$sum_pgeneral = 0;
	 $cp =0;
	
	/******************** CON ESTADISTICA ******************************/
	
		
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	$ob_reporte ->fecha_termino = $fecha_fin;
	$result13 = $ob_reporte ->Asistencia($conn);
	if (!$result13){
		  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
	}else{
		if (pg_numrows($result13)!=0){
		  $fila13 = @pg_fetch_array($result13,0);	
		  if (!$fila13){
			  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			  exit();
		  }
		}
	}
	$sql = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano." and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."') AND id_curso =".$curso." ORDER BY fecha ASC";
	$rs_justifica = @pg_exec($conn,$sql);
	//if($Just_Asis==1){
	$justifica = @pg_numrows($rs_justifica);
	//}else{
	//	$justifica=0;
	//}
	$cantidad = @pg_numrows($result13);
	if($Just_Asis==1){
	$inasistencia = @pg_numrows($result13) - $justifica;
	}else{
	$inasistencia=	@pg_numrows($result13);
	}
	$dias_asistidos = $dias_habiles - ($cantidad - $justifica);
	//if($_PERFIL==0) echo "dias justif.--> ".$justifica."  dias habiles -->".$dias_habiles."  inasistencia-->".$cantidad."  dias asistidos -->".$dias_asistidos;

	//---------------------------
	 $sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso,tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	//echo $sql;
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$truncado_final = $fila['truncado_final'];
	//echo $truncado = $fila['truncado'];
	
?>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>    </td>
    <? } ?>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left">
      <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
    </div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
    <td class="item"><div align="left"><strong>:</strong></div></td>
    <td class="item"><div align="left">
      <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?>
    </div></td>
  </tr>
  
</table>
<table width="650" border="0" align="center">
  <tr>
    <td class=""><div align="center"><strong>INFORME DE NOTAS</strong> </div></td>
  </tr>
     <?
	  if ($institucion==770){
	      ?>
		  <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación N&ordm; : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas N&ordm; : ".$planes?></strong></font></div></td>
          </tr>
   <? } ?>
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
		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
			
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				{
					?><div align="center"><?
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS HÁBILES PARA PERÍODOS </b> <br> Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la información requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
				
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
				
				?>	
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="279" rowspan="2" class="item"><font size="1" face="Arial, Helvetica, sans-serif">Subsector del Aprendizaje <br />
    (Formaci&oacute;n General)</font></td>
    <td align="center"  class="item" width="1%"><font size="1" face="Arial, Helvetica, sans-serif">PROMEDIO</font></td>
    <td align="center" class="item"><font size="1" face="Arial, Helvetica, sans-serif">EXAMEN</font></td>
    
    
    
  
    
   <?php  for($p=0;$p<$cont_pquiz;$p++){
	   $fil_nquiz = pg_fetch_array($res_pquiz,$p);
	   $nombre_pq = $fil_nquiz['nombre_periodo'];
	   ?>
    <td rowspan="2" align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"> <?php echo $nombre_pq ?></font></td>
    <? 
	 } // fin tipo_rep?>
     <td rowspan="2" align="center"><font size="1" face="Arial, Helvetica, sans-serif">PROMEDIO</font></td>
  </tr>
  <tr>
    <td align="center" class="item"><font size="1" face="Arial, Helvetica, sans-serif">Nota 70%</font></td>
    <td align="center" class="item"><font size="1" face="Arial, Helvetica, sans-serif">Nota 30%</font></td>
  </tr>
  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  
		  $ob_reporte ->nro_ano = $nro_ano;
		   $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion=1;
		 
			  $ob_reporte ->RamoFormacion($conn);
		  
		  
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
				$incide_promo = $fila['bool_ip'];
				$artistico = $fila['bool_artis'];
				$truncado = $fila['truncado'];

				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = @pg_exec($conn,$sql_pocentaje);
			    $pos21=@pg_result($resp,0);
			    ////////////////////////FIN PORCENTAJES///////////
				
			?>
                  <tr>
                    <?
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
				
				//notas examen quiz activo
				  $sql_n_ex = "select examen, promedio from quiz_examen qe,quiz_periodos qp where qe.id_periodo = qp.id_periodo and id_ramo = $id_ramo and qe.id_periodo =$peractivo and rut_alumno = $alumno and periodo_real =$periodo;";
				 $res_n_ex = @pg_exec($conn, $sql_n_ex);
				 $fil_n_ex = @pg_fetch_array($res_n_ex,0);
				 
				 //suma periodos
				 $sum_prom_periodo=0;
				 $count_periodos=0;
				
				
			?>
    <td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoci&oacute;n)"; }?>
                    </font></div></td>
    <td align="center" class="subitem <?php echo (intval($fil_n_ex['promedio'])>=40)?"azul":"rojo" ?>">
	
	<?php  
	if($fil_n_ex['promedio'] || $fil_n_ex['promedio']>0)
	{echo $fil_n_ex['promedio'];} ?>
    
    </td>
    <td align="center" class="subitem <?php echo (intval($fil_n_ex['examen'])>=40)?"azul":"rojo" ?>">
	
    <?php  
	if($fil_n_ex['examen'] || $fil_n_ex['examen']>0)
	{echo $fil_n_ex['examen'];} ?>
    
</td>
     <?php  for($p=0;$p<$cont_pquiz;$p++){
		  $fil_nquiz = pg_fetch_array($res_pquiz,$p);
	   $id_pq = $fil_nquiz['id_periodo'];
		 
		  $sql_promfinalquiz = "select promedio_final from quiz_examen where rut_alumno=$alumno and id_ramo=".$fila['id_ramo']." and id_periodo=$id_pq and periodo_real =$periodo;";
		$rs_promfinalquiz = @pg_exec($conn,$sql_promfinalquiz);
		$fil_promfinalquiz = @pg_fetch_array($rs_promfinalquiz,0);
		
 if(intval($fil_promfinalquiz['promedio_final']) !=0){
		 $sum_prom_periodo =  $sum_prom_periodo+intval($fil_promfinalquiz['promedio_final']);
		 $count_periodos ++;
		 $fil_promfinalquiz['promedio_final'] = $fil_promfinalquiz['promedio_final'];
		 }
		 elseif($fil_promfinalquiz['promedio_final']=="MB" || $fil_promfinalquiz['promedio_final']=="B"|| $fil_promfinalquiz['promedio_final']=="S" || $fil_promfinalquiz['promedio_final']=="i"){
			  $fil_promfinalquiz['promedio_final'] = $fil_promfinalquiz['promedio_final'];
			 }
		 else{
			 $fil_promfinalquiz['promedio_final'] = "";
			}
		 
		 ?>
     
     <td align="center" class="subitem <?php echo (intval($fil_promfinalquiz['promedio_final']>40))?"azul":"rojo" ?>"><?php echo $fil_promfinalquiz['promedio_final'] ?></td>
	<?php }?>
    
    <?php $prom = $sum_prom_periodo/$count_periodos;?>
    <td align="center" class="subitem <?php echo ($prom>40)?"azul":"rojo" ?>">
    <?php 
	
	if(intval($prom)!=0){
		if($truncado==1){
			echo number_format($prom,0,',','.');
		}else{
		echo intval($prom);	
		}
		
		$sum_pgeneral = $sum_pgeneral+ $prom;
		$cp++;
	
	}
	 elseif($fil_promfinalquiz['promedio_final']=="MB" || $fil_promfinalquiz['promedio_final']=="B"|| $fil_promfinalquiz['promedio_final']=="S" || $fil_promfinalquiz['promedio_final']=="i"){
			  $fil_promfinalquiz['promedio_final'] = $fil_promfinalquiz['promedio_final'];
			 }
	//si no hay promedio	
	else{echo "";}
	 ?> 
    
    </td>
   
				<?php }?>
 
  
 
<TR height="25">
	<TD colspan="3" align="right" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"> Promedio General&nbsp;&nbsp;&nbsp;</font></TD>
	<?php  for($p=0;$p<$cont_pquiz;$p++){
		 $fil_nquiz = pg_fetch_array($res_pquiz,$p);
	   $id_pq = $fil_nquiz['id_periodo'];
		 $sq_prom_perparcial ="select sum(promedio_final) as promedio_ramo,count(*) as conteo_notas from quiz_examen where  id_periodo =$id_pq and rut_alumno = $alumno and periodo_real =$periodo and (promedio_final > 0 and promedio_final is not NULL) ;";
		 
	$rs_prom_perparcial= @pg_exec($conn,$sq_prom_perparcial);
		$fil_prom_perparcial = @pg_fetch_array($rs_prom_perparcial,0);
		$prom_periodo= $fil_prom_perparcial['promedio_ramo'];
		$conteo_notas= $fil_prom_perparcial['conteo_notas'];
		
		if(intval($prom_periodo)!=0){
			if($truncado==1){
			$prom_periodo =  number_format($prom_periodo,0,',','.');
			}else{
			$prom_periodo =  intval($prom_periodo);
			}
			
			$count_periodos++;
		}
		else{
		$prom_periodo ="";
		}
		
		?>
     
     <td align="center"  class="subitem <?php echo ($prom_periodo / $conteo_notas>40)?"azul":"rojo" ?>"><?php echo (intval($prom_periodo / $conteo_notas)>0)?intval($prom_periodo / $conteo_notas):""  ?></td>
	<?php }
	// FIN FOR PERIODO DE PROMEDIOS ?>
    <td  align="center" colspan="2" class="subitem <?php echo ($sum_pgeneral/$cp>40)?"azul":"rojo" ?>"><?php echo (intval($sum_pgeneral/$cp)>0)?intval($sum_pgeneral/$cp):""?></td>
</TR>

</table>
<? 	}
  } ?>
<!--  taller -->
<?	



if($estadistica==1){ ?>
	<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td width="175"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
		<td width="206"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
		<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
		<td width="97"><font size="1" face="Arial, Helvetica, sans-serif"><?=$inasistencia ?></font></td>
	  </tr>
	  <tr>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">
		  <? 
				if ($dias_habiles>0){
					$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
					$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
					$prom_cont_asis = $prom_cont_asis + 1;
				}
				echo $promedio_asistencia . "%" ;
		  ?>
			</font>
		</td>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><br>
		<?
				$ob_reporte ->alumno = $alumno;
				$ob_reporte ->tipo =2;
				$ob_reporte ->fecha_inicio = $fecha_ini;
				$ob_reporte ->fecha_termino = $fecha_fin;
				$result_atraso =$ob_reporte ->Anotaciones($conn);
				$fila_atraso = @pg_fetch_array($result_atraso,0);
				echo @pg_numrows($result_atraso);
		?>
		</font></td>
	  </tr>
      <tr>
      <td><font size="1" face="Arial, Helvetica, sans-serif"><strong><? if($det_anot==1) { echo "ANOTACIONES POSITIVAS"; ?></strong></font></td>
      <td><font size="1" face="Arial, Helvetica, sans-serif">
      <?
		 $sql_an="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=1 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_an =pg_exec($conn,$sql_an);
		 $tot_sql_an = @pg_numrows($rs_an);
		 
		  $sql_an1="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='1'
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_an1=pg_exec($conn,$sql_an1)or die("fallo sql");
					$tot_sql_an1 = @pg_numrows($rs_an1);
		 echo $tot_pos = $tot_sql_an+$tot_sql_an1;	
		 
}?>
      </font>
      </td>
      <? if($Just_Asis==0){?>
     	<td><div align="left"><strong><font size="1" face="Arial, Helvetica, sans-serif">INASISTENCIAS JUSTIFICADAS</font></strong></div></td>
    	<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $justifica ?></font></div></td>
     <? }?>
      
      </tr>
      <tr>
        <td><strong><font size="1" face="Arial, Helvetica, sans-serif"><? if($det_anot==1) { ECHO "ANOTACIONES NEGATIVAS"; ?></font></strong></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif">
          <?
		 $sql_anotneg="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=2 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_anotneg =pg_exec($conn,$sql_anotneg);
		 $tot_sql_anotneg = @pg_numrows($rs_anotneg);
		 
		  $sql_anotneg2="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='2'
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_anotnet2=pg_exec($conn,$sql_anotneg2)or die("fallo sql");
					$tot_sql_anotneg2 = @pg_numrows($rs_anotnet2);
		 echo $tot_neg = $tot_sql_anotneg+$tot_sql_anotneg2;	
		 }
	  ?>
        </font>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	</table>
    <BR />
	<? }
	if($obs==1){?>		
		<table width="650"  border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		</table>
		<table width="650" height="72" border="0" cellpadding="0" cellspacing="0" align="center">
		 <? if ($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? } ELSE{ ?>
		  <tr>
			<td height="27"><font size="1" face="Arial, Helvetica, sans-serif"><div align="left"><? echo $fila_alu['obs_reporte'];?></div></font></td>
		  </tr>
		  <? } 
		  for($o=1; $o<=($txtOBS-1) ; $o++){
		  ?>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } ?>
	  </table>
		<? } ?>	 
         <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 
		 include("../../firmas/firmas.php");?>
<? if($chk_apo==1){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td width="25%" class="item"> <div align="center">________________________________
<br>
<?="Apoderado";?>
<br>

</div></td>

  </tr>
  
</table>
<? } ?>
<? if ($_INSTIT!=770){ ?>
	<table width="650" align="center">
	<tr>
	<td>
   <? $fecha = $txtFECHA;?>
	  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($ob_membrete->comuna)).", ". fecha_espanol($fecha) ?></font>
	</td>
	</tr>
	</table>
<? } ?>
<? if($colilla==1){	?>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $ob_reporte->tildeM($nombre_alumno); ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $Curso_pal?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($prome_colilla>0)
		echo $prome_colilla;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Periodo </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Atrasos </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <?
	$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."', 'YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
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
    
    <? if($Just_Asis==0){?>
     <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias Justificadas</font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $justifica ?></font></div></td>
    <? }?>
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
 <?	} // FIN COLILLA
  if($anotacion==1){
 	?>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td class="tableindex"><div align="center"><strong>INFORME DE ATRASOS, ANOTACIONES E INASISTENCIAS</strong></div></td>
      </tr>
      <tr>
</table>
    <br>
    
    <?
	/******* CONSULTA NO FUNCIONA EN OBJETO **************/	
	$sql =" SELECT a.*, b.nombre_emp || CAST(' ' as varchar) || ape_pat || CAST(' ' as varchar) || ape_mat as nombre ";
	$sql.=" FROM anotacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp  WHERE rut_alumno=".$alumno." AND id_periodo=".$periodo." ";
	$sql.=" ORDER BY tipo desc, fecha ";
	$result_anota = @pg_exec($conn,$sql);
	
	
	if (pg_numrows($result_anota)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		if ($fila_anota['tipo_conducta']==1)
			$tipo_conducta = "POSITIVA";
		if ($fila_anota['tipo_conducta']==2)
			$tipo_conducta = "NEGATIVA";							
		if ($fila_anota['tipo']== 1)
			$tipo = $tipo_conducta;
		elseif($fila_anota['tipo']==2)
			$tipo = "ATRASO";
		elseif($fila_anota['tipo']==3)
			$tipo = "INASISTENCIA";
		elseif($fila_anota['tipo']==4)
			$tipo = "ENFERMERIA";
		elseif($fila_anota["codigo_tipo_anotacion"]!=""){
			$cod_ta = $fila_anota["codigo_tipo_anotacion"];
			$q1 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
			$r1 = @pg_Exec($conn,$q1);
			$f1 = @pg_fetch_array($r1,0);
			$codta  = $f1['codtipo'];
			$tipo	= $f1['descripcion'];
		}  
	
		$fecha   = $fila_anota['fecha'];
		$rut_emp = $fila_anota['rut_emp'];
		
		/*$sql_emp = "select * from empleado where rut_emp = '$rut_emp'";
		$res_emp = @pg_Exec($conn,$sql_emp);
		$fil_emp = @pg_fetch_array($res_emp);*/
		
		$profesor_res = strtoupper($fila_anota['nombre']);
		
		
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
		
		$hora = $fila_anota['hora'];
		
		
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <? if($fila_anota['tipo']!=2){?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="156"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Fecha</strong></font></td>
        <td width="7"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="258"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? impF($fecha)?></font></td>
        <td width="77"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo</strong></font></td>
        <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="143"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $tipo?></font></td>
      </tr>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Responsable </strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profesor_res?></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Hora</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $hora?></font></td>
      </tr>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Observaci&oacute;n</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $observacion?></font></td>
      </tr>
      <?	if($fila_anota["sigla"]!=""){	?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector Aprendizaje</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?
			// busco la sigla
			$ob_reporte ->sigla_aux = $fila_anota["sigla"];
			$ob_reporte ->SiglaSubsector($conn);
			echo $ob_reporte->sigla;?> - <? echo $ob_reporte->detalle_sigla; ?> 
			</font>
	    </td>
      </tr>
      <?	}	
   if($fila_anota["codigo_tipo_anotacion"]!=""){?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo de Anotaci&oacute;n</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?php
			$ob_reporte ->institucion = $institucion;
			$ob_reporte ->tipo = $fila_anota["codigo_tipo_anotacion"];
		  	$r1 = $ob_reporte ->TipoAnotaciones($conn);
			$f1 = @pg_fetch_array($r1,0);
			$codta       = $f1['codtipo'];
			$descripcion	= $f1['descripcion'];
		
			echo "$codta - $descripcion";
		
  ?>
        </font> </td>
      </tr>
      <? }	
  if($fila_anota["codigo_anotacion"]!=""){?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Sub - Tipo</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?php 
		  
		  $ob_reporte ->codigo = $fila_anota["codigo_anotacion"];
		  $ob_reporte ->id_tipo = $cod_ta;
		  $r1 = $ob_reporte ->DetalleAnotaciones($conn);
		  $f1 = @pg_fetch_array($r1,0);
		  $detalle = $f1["detalle"];
			echo "$codigo_anotacion - $detalle";
		?>
        </font> </td>
      </tr>
      <?	}	?>
    </table>
    <? }else{ ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Atraso el d&iacute;a </strong></font></td>
        <?	

		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);

	?>
        <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
      </tr>
</table>
    <? } ?>
    <? } ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <?
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$c_curso;
		$result_asis = $ob_reporte ->Asistencia($conn);
		
	if (@pg_numrows($result_asis)==0) 
		echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font><br>";
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];
		
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->fecha = $fecha;
		$res_justifica = $ob_reporte->JustificaAsistencia($conn);	
		
/*	$sql_justifica = "select * from justifica_inasistencia where rut_alumno = '$alumno' and ano = '$ano' and fecha = '$fecha'";
	@pg_Exec($conn,$sql_justifica);*/
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$justifica = $fila_justifica['fecha'];	
	 if($justifica == $fecha){
	 	$justificado = true;
	 }else{
	 	$justificado = false;
	 }
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);
?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Inasistencia el d&iacute;a </strong></font></td>
        <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha;?><strong>
          <? if($justificado==true)echo "&nbsp;&nbsp;&nbsp;(Justificado)";?>
        </strong></font></td>
      </tr>
    </table>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <?
 }
	
 } // FIN ANOTACIONES
	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
	<? //} // FIN FOR ALUMNOS
} ?>
</body>
</html>

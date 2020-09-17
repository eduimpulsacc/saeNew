<?
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');
	
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
	$iniano = $ob_membrete->fecha_inicio;
	$finano = $ob_membrete->fecha_termino;
	
	
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
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per, curso.truncado_final ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		$truncado_per = $fila_curso['truncado_per'];
		$truncado_final = $fila_curso['truncado_final'];
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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }

</style>
</head>
<!--onLoad="window.print()"-->
<body <?php if($_INSTIT!=24985){ ?>onLoad="window.print()" <?php }?>>
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
	$prome_semestral_coef=0;
	$cuenta_semestral_coef=0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	
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
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$truncado_final = $fila['truncado_final'];
	
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
					   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
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
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
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
    <td width="279" class="item">Subsector del Aprendizaje <br />
    (Formaci&oacute;n General)</td>
    <td colspan="20" class="subitem"><div align="center">Notas</div></td>
     <? 
	 		if($tipo_rep!=4){
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			
			if($institucion==1914 OR $institucion==40251){
				if($primer_periodo==$periodo){
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
					
            <?	}
			}else{?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<? } 
			if($chk_coef2==1){?> 
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<br /> C2</strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
                 Final<br />1º<? echo $tipo_per ?></strong></font></td>
			
			<?php }
			if($tipo_eval==2){ ?>
				    <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>Aprec &nbsp;1º<? echo $tipo_per ?></strong></font></td>
			<? }
				if($tipo_rep==2){ 
					if($institucion==1914 OR $institucion==40251){	
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
         	<? if($chk_coef2==1){?> 
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<br /> C2</strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
                 Final<br />2º<? echo $tipo_per ?></strong></font></td>
			
			<?php } if($tipo_eval==2){ ?>
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
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>	
               
               <? if($chk_coef2==1){?> 
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<br /> C2</strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
                 Final<br />2º<? echo $tipo_per ?></strong></font></td>
			
			<?php }
            if($tipo_eval==2){ ?>
			   <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>
			     Aprec</strong></font></td>
			<? }
			if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			        <? }
			if($tipo_rep==5){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Anual</strong></font></td>
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
		  $ob_reporte ->todos = $rdASIGNATURA;
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
				$incide_promo = $fila['bool_ip'];
				$artistico = $fila['bool_artis'];

				
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
			?>
    <td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoción)"; }?>
                    </font></div></td>
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
				   
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0 && $institucion!=5661){ ?>
                      <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
                  
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong></div></td>
				
				 <? } ?>	
				 <?
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
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0; 
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					$rs_notas =0;
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;								 																																					
					$XUXA =$ob_reporte->Notas($conn);
					pg_dbname($conn);
					if (pg_numrows($XUXA)>0){ 
						$fila_peri = @pg_fetch_array($XUXA,0);
						$fila_peri['promedio'];
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
						@pg_numrows($rs_eximido);
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
							
					
					/*if($_PERFIL==0){
						echo "<br> promedios Apreciacion-->".$prome_semestral_ap;
						echo "contador -->".$cuenta_semestral;
					}*/
					if($institucion==1914 OR $institucion==40251){
						if($periodos==$periodo){ ?>
						<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0  && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
					<? 	}
					
					}else{?>
					<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? 
echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
 <? if($chk_coef2==1){
	  $sq_pcoef ="select nota1,promedio from notacoef where rut_alumno=$alumno and id_ramo=$id_ramo and id_periodo=".$filaperi['id_periodo'];
	 $res_reg = pg_exec($conn, $sq_pcoef);
		$notacoef = pg_result($res_reg,0);
		$promcoef = pg_result($res_reg,1);
		
		if(pg_numrows($res_reg)==0){
			$promcoef= $prome_1;	
		}

		if ($promcoef>0){
			
			$prome_semestral_coef= $prome_semestral_coef + $promcoef;
			$cuenta_semestral_coef = $cuenta_semestral_coef + 1;
			//$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
			
		}	


	 ?> 
                   <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $notacoef; ?></strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $promcoef;?></strong></font></td>
                   <?php }?>
					                  
					<? }
					if($tipo_eval==2){
					?>
					<td align="center" bgcolor="#CCCCCC"><font  size="1" face="Arial, Helvetica, sans-serif"><strong><i><?=$prome_ap;?></i></strong></font></td>
					<? } 
					 if($tipo_rep==2){
					  	/*	$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);*/
							
							$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND promedio NOT IN('0','MB','B','S','I',' ','x')  ";
							if($periodos!=""){
								$sql.="AND id_periodo=".$periodos."";
							}
							$rs_prom_curso = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
							$suma_curso = pg_result($rs_prom_curso,0);
							$contador_curso = pg_result($rs_prom_curso,1);
							$prom_curso = intval($suma_curso / $contador_curso);
							//if($_PERFIL==0) echo $suma_curso."---".$contador_curso;
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
							if ($prom_curso>0){
							    $suma_prom_curso = $suma_prom_curso + $prom_curso;
								$cont_prom_curso++;
							}	
							if($institucion==1914 OR $institucion==40251){
								if($periodos==$periodo){ ?>
									<td  align="center" class="subitem"><?=$prom_curso;?></td>
							<? 	}
							}else{?>
							  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?		}
						}
						
					
				} 
				if($tipo_rep==5){
						$sql="SELECT promedio,id_periodo, notaap FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
						
						$rs_prom_anual = pg_exec($conn,$sql);
						$suma_anual = 0;
						$suma_anual1 = 0;
						$cont_anual = 0;
						$cont_conceptual=0;
						for($xx=0;$xx<pg_numrows($rs_prom_anual);$xx++){		
							$fila_anual =pg_fetch_array($rs_prom_anual,$xx);
							if($fila_anual['notaap']!=""){
								$prome_anual = $fila_anual['notaap'];
							}else{
								$prome_anual = $fila_anual['promedio'];
							}
							if($fila_anual['id_periodo'] <= $periodo){
								$suma_anual = $suma_anual + $prome_anual;
								$cont_anual++;
								if($modo_eval==2 || $modo_eval==3){
									$suma_anual1=$suma_anual1 + Conceptual($fila_anual['promedio'],2);
									$cont_conceptual++;
									
								}
							}
							if($modo_eval==2 || $modo_eval==3){
									$prom_anual = Conceptual((round($suma_anual1 / $cont_conceptual)),1);
							}else{
								$prom_anual = round($suma_anual / $cont_anual);
							}
						}
							if($incide_promo==1){ 
								$suma_prom_gral = $suma_prom_gral + $prom_anual;
							
							if($modo_eval==1) $cont_prom_gral++;
							}
						?>
							<td  align="center" class="subitem"><? echo $prom_anual;?></td>
					<? }
						/*if($_PERFIL==0){
							echo "suma-->".$suma_prom_gral;
							echo "<br> contador-->".$cont_prom_gral;
						}*/
						?>
                 
  </tr>
  
  <? }  

	  $ob_reporte ->nro_ano = $nro_ano;
	  $ob_reporte ->alumno = $alumno;
	  $ob_reporte ->curso = $curso;
	  $ob_reporte ->subsector=$rb_subsector; 
	  if($ck_alumnos==1){
		  $ob_reporte ->RamoAlumnoEximidoDiferenciada($conn);
	  }else{
		  $ob_reporte ->RamoFormacionDiferenciada($conn);
	  }
	  
	  if(@pg_numrows($ob_reporte->result)>0){


?>

  <tr>
    <td class="item">Subsector del Aprendizaje <br />
    (Formaci&oacute;n Diferenciada)</td>
    <td colspan="20" class="subitem"><div align="center">Notas</div></td>
     <? 
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			
			if($institucion==1914 OR $institucion==40251){
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
					if($institucion==1914 OR $institucion==40251){	
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
			 
			}?>
  </tr>
   <?

				
		  $cont_prom = 0;
		  $promedio = 0;
		  
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion=2;
		  $ob_reporte ->rdASIGNATURA=$rdASIGNATURA;
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
				$artistico = $fila['bool_artis'];
				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = pg_exec($conn,$sql_pocentaje);
			    $pos21=pg_result($resp,0);
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
			?>
    <td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoción)"; }?>
                    </font></div></td>
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
				   
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                      <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong></div></td>
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
				
				 <? } ?>	
				  <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19+$pos20;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0;
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					
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
						   		
						
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
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
						if(@pg_numrows($rs_eximido)==0 and $fila['bool_artis']!=1){
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
						<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prome_1;?></strong></font></td>
					<? 	}
					
					}else{?>
					<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, 
sans-serif"><?=$prome_1;?></strong></font></td>
					                  
					<? }
					if($tipo_eval==2){
					?>
					<td align="center" bgcolor="#CCCCCC"><font  size="1" face="Arial, Helvetica, sans-serif"><strong><i><?=$prome_ap;?></i></strong></font></td>
					<? } ?>
					  <? if($tipo_rep==2){
					  		$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);
							$prom_curso = intval($ob_reporte->suma / $ob_reporte->contador);
							
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
				} ?>
  </tr>
  <? }
  }  
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion =3;
		  if($ck_alumnos==1){
			  $ob_reporte ->RamoAlumnoEximidoIntrumental($conn);
		  }else{
			  $ob_reporte ->RamoFormacion($conn);
		  }
          $result =$ob_reporte ->result;
		  
		  if(@pg_numrows($result)>0){
  
  ?>
  <tr>
    <td class="item">Subsector del Aprendizaje <br />
    (Formaci&oacute;n Intrumental)</td>
    <td colspan="20" class="subitem"><div align="center">Notas</div></td>
 <? 
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			
			if($institucion==1914 OR $institucion==40251){
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
					if($institucion==1914 OR $institucion==40251){	
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
			 
			 
			
			}?>  </tr>
   <?
		  $cont_prom = 0;
		  $promedio = 0;
		  
		 
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
				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = pg_exec($conn,$sql_pocentaje);
			    $pos21=pg_result($resp,0);
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
			?>
    <td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoción)"; }?>
                    </font></div></td>
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
				   
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                      <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong></div></td>
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
				
				 <? } ?>	
				  <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19+$pos20;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0;
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					
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
						   		
						
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 =$fila_peri['promedio'];					
									}
								}
								
						}
					} else {
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						if(@pg_numrows($rs_eximido)==0){
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
						<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prome_1;?></strong></font></td>
					<? 	}
					
					}else{?>
					<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, 
sans-serif"><?=$prome_1;?></strong></font></td>
					                  
					<? }
					if($tipo_eval==2){
					?>
					<td align="center" bgcolor="#CCCCCC"><font  size="1" face="Arial, Helvetica, sans-serif"><strong><i><?=$prome_ap;?></i></strong></font></td>
					<? } ?>
					  <? if($tipo_rep==2){
					  		$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);
							if($_PERFIL==0){
								$ob_reporte->suma;
							    $ob_reporte->contador;
									}
							$prom_curso = intval($ob_reporte->suma / $ob_reporte->contador);
							
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
							if ($prom_curso>0){
							    $suma_prom_curso = $suma_prom_curso + $prom_curso;
								$cont_prom_curso++;
							}						
							if($institucion==1914 OR $institucion==40251){
								if($periodos==$periodo){ ?>
									<td  align="center" class="subitem"><?=$prom_curso;?></td>
							<? 	}
							}else{?>
							  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?		}
						}
				} ?>
  </tr>
  <? } 
  }
  if($tipo_rep!=3 && $tipo_rep!=4){
  ?>
<TR height="25">
	<TD colspan="21" align="right"v> Promedio&nbsp;&nbsp;&nbsp;</TD>
	<? 
	$ob_reporte ->ano =$ano;
	$resultPer =$ob_reporte ->TotalPeriodo($conn);
	for($per=0 ; $per < $tot_periodo ; $per++){	
		$prome_abajo_ap=0;			
		$filaperi = @pg_fetch_array($resultPer,$per);	
		$periodos = $filaperi['id_periodo'];
		$ob_reporte ->nro_ano 	= $nro_ano;
		$ob_reporte ->periodos 	= $filaperi['id_periodo'];
		$ob_reporte ->alumno 	= $alumno;
		if($rb_subsector==0){
			$ob_reporte ->PromedioAlumno($conn);
		}else{
			$ob_reporte ->PromedioAlumnoSubNoValido($conn);
		}
		//if($_PERFIL==0) echo "<br>".$ob_reporte->sql;
		if($truncado_final==0){
			$prome_abajo = @intval($ob_reporte->suma / $ob_reporte->contador);
			//$prome_abajo = intval($prome_semestral / $cuenta_semestral);
			@$prome_abajo_ap = intval($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}else{
			$prome_abajo = @round($ob_reporte->suma / $ob_reporte->contador,0);
			//$prome_abajo = round($prome_semestral / $cuenta_semestral);
			$prome_abajo_ap = @round($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}
		if($_PERFIL==0) {
			echo $ob_reporte->suma;
			echo "<br>".$ob_reporte->contador;
			//echo "<br>".$ob_reporte->sql;
			}
		/*$ob_reporte->curso=$curso;
		$ob_reporte->suma=$ob_reporte->suma;
		$ob_reporte->contador=$ob_reporte->contador;
		$ob_reporte->tipo=2;
		$ob_reporte->ConfigPromedios($conn);
		$prome_abajo = $ob_reporte->promedio;*/
		$prome_colilla = $prome_abajo;
	
	if($institucion==1914 OR $institucion==40251){
		if($periodos==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>
	<? }
	}else{ ?>
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>	
      <?php if($chk_coef2==1){?>
    <td>&nbsp;</td>
    <td class="subitem" align="center">
    <? 
			echo $prome_final_coef= intval($prome_semestral_coef / $cuenta_semestral_coef);
		?>    
    </td>
    <?php }?>
	<? }
	
		if($tipo_eval==2){
			if($truncado_final==0){
			$prome_abajo_ap = intval($ob_reporte->sumaAP / $ob_reporte->contador );
			}else{
			$prome_abajo_ap = round($ob_reporte->sumaAP / $ob_reporte->contador,0);
			} 
?>
<td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prome_abajo_ap?></font></td>
	<?	} // FIN PROMEDIO DE APRECIACION
	if($tipo_rep==2){
	
	//	$prom_curso = intval($suma_prom_curso/$cont_prom_curso);				
	$sql = "SELECT avg(cast (promedio as INTEGER)) as suma FROM notas$nro_ano WHERE id_ramo in (select id_ramo from ramo where id_curso=".$curso.") AND promedio NOT IN('0','MB','B','S','I',' ','x') AND id_periodo=".$periodos."";
		$rs_prom_curso =@pg_exec($conn,$sql);
		$prom_curso = intval(@pg_result($rs_prom_curso,0));
		if($institucion==1914 OR $institucion==40251){
			if($periodos==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prom_curso?></font></td>					
		<?	}
		}else{?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prom_curso?></font></td>
		<? }?>
		
<? 	}// FIN PROMEDIO CURSO 
	}
	if($tipo_rep==5){ 
			$prom_gral_anual = round($suma_prom_gral / $cont_prom_gral);?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $prom_gral_anual;?></font></td>
	<? 	}
	// FIN FOR PERIODO DE PROMEDIOS ?>
  
</TR>
<? } ?>
</table>
<? 	}
  } ?>
<!--  taller -->
<?	
if($taller==1){
	$ob_reporte->alumno=$alumno;
	$ob_reporte->ano=$ano;
	$ob_reporte->AlumnoTaller($conn);
	$result = $ob_reporte->result;
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

if($num_subsec>0){
?>
		<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td width="231" align="left">
	  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TALLERES / ACADEMIAS </strong></font></div></td>
	<td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
	<? 
		$ob_reporte->ano=$ano;
		$result_p = $ob_reporte->TotalPeriodo($conn);

	$fila_p = pg_num_rows($result_p);
	$p1 = pg_fetch_array($result_p,0);
	$p1=$p1['id_periodo'];
	$p2 = pg_fetch_array($result_p,1);
	$p2 = $p2['id_periodo']; 
	if($fila_p > 2){
		$p3 = pg_fetch_array($result_p,2);
		$p3 = $p3['id_periodo'];			
	}						
	if($p1==$periodo){?>
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
	<? }			
	if($p2==$periodo){?>			
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>			
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
	<?	}		
	if($p3==$periodo){?>
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>			
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>						
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
	<? }?>			         
	</tr>
  <?
  $cont_prom = 0;
  $promedio = 0;


  for($e=0 ; $e < @pg_numrows($result) ; $e++)
	{
		$fila_taller = @pg_fetch_array($result,$e);
		$id_taller = $fila_taller['id_taller'];
		$sql_taller = "select * from taller where id_taller=".$id_taller."";
		$result_taller =@pg_Exec($conn,$sql_taller);
		$fila = @pg_fetch_array($result_taller,0);		  

		$modo_eval = $fila['modo_eval'];
		$nom_taller = $fila['nombre_taller'];
	?>		
  <tr>
  <?

// NOTAS TALLER
	$ob_reporte->alumno=$alumno;
	$ob_reporte->taller=$id_taller;
	$ob_reporte->periodo=$id_periodo;
	$result2 = $ob_reporte->NotasTaller($conn);
	if (!$result2){
		  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		if (pg_numrows($result2)!=0){
		  $fila2 = @pg_fetch_array($result2,0);	
		  if (!$fila2){
				  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				  exit();
		  }
		}
	}
		$fila2 = @pg_fetch_array($result2,$f);
		$ob_reporte->CambiaNota($fila2);
	?>
	<td height="25" class="subitem"><div align="left"><? echo $nom_taller; ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?></font></strong><? } else { echo $ob_reporte->nota2; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?></font></strong><? } else { echo $ob_reporte->nota3; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font></strong><? } else { echo $ob_reporte->nota4; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font></strong><? } else { echo $ob_reporte->nota5; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font></strong><? } else { echo $ob_reporte->nota6; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font></strong><? } else { echo $ob_reporte->nota7; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font></strong><? } else { echo $ob_reporte->nota8; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font></strong><? } else { echo $ob_reporte->nota9; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font></strong><? } else { echo $ob_reporte->nota10; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font></strong><? } else { echo $ob_reporte->nota11; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font></strong><? } else { echo $ob_reporte->nota12; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font></strong><? } else { echo $ob_reporte->nota13; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font></strong><? } else { echo $ob_reporte->nota14; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font></strong><? } else { echo $ob_reporte->nota15; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font></strong><? } else { echo $ob_reporte->nota16; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font></strong><? } else { echo $ob_reporte->nota17; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font></strong><? } else { echo $ob_reporte->nota18; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font></strong><? } else { echo $ob_reporte->nota19; } ?></div></td>
	<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font></strong><? } else { echo $ob_reporte->nota20; } ?></div></td>
	<? 	$ob_reporte ->ano =$ano;
		$resultPer =$ob_reporte ->TotalPeriodo($conn);
		for($per=0 ; $per < $tot_periodo ; $per++){				
			$filaperi = @pg_fetch_array($resultPer,$per);			
			$periodos = $filaperi['id_periodo'];
			//-------
			$ob_reporte ->rut_alumno =$alumno;
			$ob_reporte ->taller = $id_taller;
			$ob_reporte ->periodo = $periodos;
			$result_peri =$ob_reporte ->NotasTaller($conn);
		
			if (pg_numrows($result_peri)>0){
				$fila_peri = @pg_fetch_array($result_peri,0);
				if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
					$prome_1 = "&nbsp;";
				} else {
					if ($fila_peri['promedio']>0){
						$prome_1 = round($fila_peri['promedio'],0);					
					} else {
						$prome_1 = $fila_peri['promedio'];					
					}
				}
			} else {
				$prome_1 = "&nbsp;";
			}
			///// acomulo promedio para mostrar al final ///
			if ($prome_1>0){
				$prome_semestral = $prome_semestral + $prome_1;
				$cuenta_semestral = $cuenta_semestral + 1;
			}
			
			?>
			<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"><? 
				if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
					echo $prome_1;?></font><? 
				} else { 
					echo $prome_1; 
				}?></font></td>								
			<?
		}
	?>
  </tr>
<? } ?>		  
  <tr>
	<td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
	<?
	$ob_reporte ->ano = $ano;
	$resultPer = $ob_reporte ->TotalPeriodo($conn);
	
	$prome_abajo = 0;
	$cont_abajo = 0;
	for($per=0 ; $per < $tot_periodo ; $per++)
	{
		$filaperi = @pg_fetch_array($resultPer,$per);			
		$periodos = $filaperi['id_periodo'];
		
		$ob_reporte ->periodos 	= $periodos;
		$ob_reporte ->alumno 	= $alumno;
		$ob_reporte ->PromedioAlumnoTaller($conn);
		
		if($truncado_final==0){
			$prome_abajo = intval($ob_reporte->suma / $ob_reporte->contador);
		}else{
			$prome_abajo = round($ob_reporte->suma / $ob_reporte->contador,0);
		}
		  $promedio_periodo_aux = $prome_abajo;
		?>
		<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>								
		<?
	}
	if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
		$prome_general_pro = round($prome_general_pro/$cont_general_pro);

	?>
  </tr>
</table>

<?	}	
	} /**** FIN IF TALLER ****/
	
 if($institucion==1672){?>
	<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
      	<td><font size="1" face="Arial, Helvetica, sans-serif"><strong><? 
	echo "NOTA: EL PROMEDIO DE NOTAS PODRIA CAMBIAR SI SU ALUMNO (A) POSEE MENOS DE CUATRO NOTAS PARCIALES EN ALGUN SUBSECTOR";	?>
    </strong></font></td></tr></table>
    <BR />
    <?	
	
}


 ?>
	<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
     <?php  if($chk_totdp==1){?>
		<td width="175"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
		<td width="206"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
       <?php }?>
         <?php  if($chk_totdinas==1){?>
		<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
		<td width="97"><font size="1" face="Arial, Helvetica, sans-serif"><?=$inasistencia ?></font></td>
        <?php }?>
	  </tr>
	  <tr>
        <?php  if($chk_prcas==1){?>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIA PERIODO (%)</strong></font></td>
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
        <?php }?>
         <?php  if($chk_totdat==1){?>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">
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
        <?php }?>
	  </tr>
      <tr>
       <?php  if($chk_anp==1){?>
      <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>
        <? if($det_anot==1) { echo "ANOTACIONES POSITIVAS"; ?>
      </strong></font></td>
      <td><font size="1" face="Arial, Helvetica, sans-serif">
      <?
		 
		 $sql_an="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=1 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_an =pg_exec($conn,$sql_an);
		 $tot_sql_an = @pg_numrows($rs_an);
		 

		 /* $sql_an1="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='1'
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_an1=pg_exec($conn,$sql_an1)or die("fallo sql");*/
					$tot_sql_an1 = @pg_numrows($rs_an1);
		 echo $tot_pos = $tot_sql_an+$tot_sql_an1;	
		 
}?>
      </font>
      </td>
      <?php }?>
      <? if($Just_Asis==0){?>
     	<td><div align="left"><strong><font size="1" face="Arial, Helvetica, sans-serif">INASISTENCIAS JUSTIFICADAS</font></strong></div></td>
    	<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $justifica ?></font></div></td>
     <? }?>
      
      </tr>
      <tr>
       <?php  if($chk_ann==1){?>
        <td><strong><font size="1" face="Arial, Helvetica, sans-serif"><? if($det_anot==1) { ECHO "ANOTACIONES NEGATIVAS"; ?></font></strong></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif">
          <?
		 $sql_anotneg="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=2 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_anotneg =pg_exec($conn,$sql_anotneg);
		 $tot_sql_anotneg = @pg_numrows($rs_anotneg);
		 
		  /*$sql_anotneg2="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='2' and tipo_conducta=2
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_anotnet2=pg_exec($conn,$sql_anotneg2)or die("fallo sql");
					$tot_sql_anotneg2 = @pg_numrows($rs_anotnet2);*/
		 echo $tot_neg = $tot_sql_anotneg+$tot_sql_anotneg2;	
		 }
	  ?>
        </font>
        </td>
        <?php }?>
        <td><?php  if($chk_pasisano==1){?><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIA ANUAL (%)</strong></font><?php }?></td>
        <td><?php  if($chk_pasisano==1){?>
		<?php 
		
		$feriados_ano=0;
		$fera=0;
		
		//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($fila_alu['fecha'] <= $iniano)
		{$fini= $iniano;}
		else
		{$fini= $fila_alu['fecha'];}
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
		if($fila_alu['bool_ar']==1){
		 $fter = $fila_alu['fecha_retiro'];
		}else{
		 $fter = $finano;
		}
		
		
		//conteo dias habiles año (sin feriados)
		 $habiles_ano=hbl($fini,$fter)."-";
		
		//feriados año
		$ob_reporte->fecha_ini2 = $fini;
		$ob_reporte->fecha2 = $fter;
		$rs_feriadosano = $ob_reporte->DiaHabil3($conn);
		//echo "---".pg_numrows($rs_feriadosano);
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
		$ob_reporte->fecha_inicio = $fini;
		$ob_reporte->fecha_termino = $fter;
		$r_asisano= $ob_reporte->Asistencia($conn);
		 $c_inasistenciaAno = pg_numrows($r_asisano);
		
		
		
		//justificaciones
		$ob_reporte->fecha1 = $fini;
		$ob_reporte->fecha2 = $fter;
		$r_justificaano= $ob_reporte->JustificaAsistencia($conn);
		 $justificaano = pg_numrows($r_justificaano);
		
		//resta final
		 $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
		
		
		
		
		//porcentaje anual
		$prc_base = (100* $con_total_inano)/$habil_real_ano;
		
		
		 ?>
        
        
        <font size="1" face="Arial, Helvetica, sans-serif"><?php echo round($prc_base,1) ?></font><?php }?></td>
      </tr>
	</table>
    <BR />
	<? 
	if($rdPSU==1){
		$sql="select s.nombre,ep.puntaje, ep.fecha,ep.id_ramo
from ensayos_psu ep 
INNER JOIN ramo r ON ep.id_ramo=r.id_ramo 
INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector 
WHERE id_ano=".$ano." and rut_alumno=".$alumno;  
		$rs_psu = pg_exec($conn,$sql);
		?>
    <table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr class="item">
    <td>ASIGNTURA</td>
    <td>MARZO</td>
    <td>ABRIL</td>
    <td>MAYO</td>
    <td>JUNIO</td>
    <td>JULIO</td>
    <td>AGOSTO</td>
    <td>SEPT.</td>
    <td>OCT.</td>
    <td>NOV.</td>
    <td >DIC.</td>
    </tr>
    <? for($i=0;$i<pg_numrows($rs_psu);$i++){
		$fila_psu = pg_fetch_array($rs_psu,$i);
	?>
    <tr>
    <td class="subitem">&nbsp;<?=$fila_psu['nombre'];?></td>
    <? for($j=3;$j<13;$j++){
		$sql="select ep.puntaje 
from ensayos_psu ep 
INNER JOIN ramo r ON ep.id_ramo=r.id_ramo 
INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector 
WHERE id_ano=".$ano." and rut_alumno=".$alumno." and date_part('MONTH',fecha)=".$j." AND ep.id_ramo=".$fila_psu['id_ramo'];
		$rs_resultado = pg_exec($conn,$sql);
		$puntaje = pg_result($rs_resultado,0);
	?>	
    <td class="subitem">&nbsp;<?=$puntaje;?></td>
    
    <? } ?>
    </tr>
    <? } ?>
</table>

    <br />

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
<table width="650" border="0" align="center">
<tr>
<?  
	for($mm=1;$mm<$txtESPACIO;$mm++){
		echo "<br>";
	}
	if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='150' height='70'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='150' height='60'><hr align='center' width='150' color='#000000'><div align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='65'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='65'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
		</table>
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
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
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
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Período </font></div></td>
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
	
	
	if (pg_numrows($result_anota)==0) echo "<div align='center'><font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font></div><br>";
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
			//echo $ob_reporte->sigla;?>  <? echo $ob_reporte->detalle_sigla; ?> 
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
			$codta       = $f1['id_tipo'];
			$descripcion	= $f1['descripcion'];
		/*$codta - */
			echo "$descripcion";
		
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
		  $ob_reporte ->id_tipo = $codta;
		  $r1 = $ob_reporte ->DetalleAnotaciones($conn);
		  $f1 = @pg_fetch_array($r1,0);
		  $detalle = $f1["detalle"];
		  /*$codigo_anotacion - */
			echo "$detalle";
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
		echo "<div align='center'><font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font></div><br>";
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

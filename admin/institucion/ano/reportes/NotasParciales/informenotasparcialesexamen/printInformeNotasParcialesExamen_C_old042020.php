<?
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');


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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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

<body >
<div id="capa0">
<!--onLoad="window.print()"<table width="650" align="center">
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
	
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$suma_prom_curso = 0;
	$cont_prom_curso = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	$prom_final_ex =0;
	
	
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
	$justifica = @pg_numrows($rs_justifica);
	
	$cantidad = @pg_numrows($result13);
	$inasistencia = @pg_numrows($result13) - $justifica;
		
	$dias_asistidos = $dias_habiles - ($cantidad - $justifica);
	//if($_PERFIL==0) echo "dias justif.--> ".$justifica."  dias habiles -->".$dias_habiles."  inasistencia-->".$cantidad."  dias asistidos -->".$dias_asistidos;

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza,curso.bool_psemestral  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$bool_psemestral = $fila['bool_psemestral'];
	
	
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
    <td class="item"><div align="left"><? 
	echo $Curso_pal;?></div></td>
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
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tableindex"><div align="center">INFORME DE NOTAS </div></td>
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
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE")){
			?>
           <td align="center">
           <font size="1" face="Arial, Helvetica, sans-serif">
           <strong>1º<? echo $tipo_per ?></strong></font></td>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
           <strong>%<br />Notas</strong></font></td>
           <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
           <strong>Ex.</strong></font></td>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
           <strong>%<br />Ex.</strong></font></td>
             <? } ?>
           <td align="center">
           <font size="1" face="Arial, Helvetica, sans-serif">
           <strong>1&ordm; <? echo $tipo_per ?></strong>
           </font>
           </td>
            <?		 
			}	
			
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
       <td align="center">
       <font size="1" face="Arial, Helvetica, sans-serif">
       <strong>2º<? echo $tipo_per ?>
       </strong></font></td>
        <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
           <strong>%<br />Notas</strong></font></td>
       <td align="center">
       <font size="1" face="Arial, Helvetica, sans-serif">
       <strong>Ex.</strong></font></td>
         <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
           <strong>%<br />Ex.</strong></font></td>
       <td align="center">
       <font size="1" face="Arial, Helvetica, sans-serif">
       <strong>Prom Final</strong></font></td>
              <? 
			}
			
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per?></strong></font></td>
                    <?
			
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
				$artistico = $fila['bool_artis'];
				$bool_pgeneral = $fila['bool_pgeneral'];
				
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
     
	 <? 	if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoción)"; }
	 
		 $pnex = intval($fila['pct_ex_semestral']>0)?(100-$fila['pct_ex_semestral']):0;
		 $nex = $fila['nota_ex_semestral'];
	 ?>
                    </font></div></td>
                    <? if($tipo_eval==1){?>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos1 = porcentaje($periodo,$fila['id_ramo'],'pos1',$ob_reporte->nota1,$conn,$ano);}else{ if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font>
                        <? } else { echo $ob_reporte->nota1; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos2 = porcentaje($periodo,$fila['id_ramo'],'pos2',$ob_reporte->nota2,$conn,$ano);	}else{ if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
                        <? } else { echo $ob_reporte->nota2; } ?>
                        </font></strong><font color="#FF0000">
                        <? }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos3 = porcentaje($periodo,$fila['id_ramo'],'pos3',$ob_reporte->nota3,$conn,$ano);	}else{ if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
                        <? } else { echo $ob_reporte->nota3; } ?>
                        </font></strong><font color="#FF0000">
                        <? }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos4 = porcentaje($periodo,$fila['id_ramo'],'pos4',$ob_reporte->nota4,$conn,$ano);	}else{ if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font>
                        <? } else { echo $ob_reporte->nota4; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos5 = porcentaje($periodo,$fila['id_ramo'],'pos5',$ob_reporte->nota5,$conn,$ano);	}else{ if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font>
                        <? } else { echo $ob_reporte->nota5; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos6 = porcentaje($periodo,$fila['id_ramo'],'pos6',$ob_reporte->nota6,$conn,$ano);	}else{ if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font>
                        <? } else { echo $ob_reporte->nota6; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos7 = porcentaje($periodo,$fila['id_ramo'],'pos7',$ob_reporte->nota7,$conn,$ano);	}else{ if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font>
                        <? } else { echo $ob_reporte->nota7; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos8 = porcentaje($periodo,$fila['id_ramo'],'pos8',$ob_reporte->nota8,$conn,$ano);	}else{ if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font>
                        <? } else { echo $ob_reporte->nota8; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos9 = porcentaje($periodo,$fila['id_ramo'],'pos9',$ob_reporte->nota9,$conn,$ano);	}else{ if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font>
                        <? } else { echo $ob_reporte->nota9; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos10 = porcentaje($periodo,$fila['id_ramo'],'pos10',$ob_reporte->nota10,$conn,$ano); }else{ if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font>
                        <? } else { echo $ob_reporte->nota10; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos11 = porcentaje($periodo,$fila['id_ramo'],'pos11',$ob_reporte->nota11,$conn,$ano); }else{ if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font>
                        <? } else { echo $ob_reporte->nota11; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos12 = porcentaje($periodo,$fila['id_ramo'],'pos12',$ob_reporte->nota12,$conn,$ano); }else{ if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font>
                        <? } else { echo $ob_reporte->nota12; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos13 = porcentaje($periodo,$fila['id_ramo'],'pos13',$ob_reporte->nota13,$conn,$ano); }else{ if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font>
                        <? } else { echo $ob_reporte->nota13; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos14 = porcentaje($periodo,$fila['id_ramo'],'pos14',$ob_reporte->nota14,$conn,$ano); }else{ if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font>
                        <? } else { echo $ob_reporte->nota14; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos15 = porcentaje($periodo,$fila['id_ramo'],'pos15',$ob_reporte->nota15,$conn,$ano); }else{ if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font>
                        <? } else { echo $ob_reporte->nota15; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos16 = porcentaje($periodo,$fila['id_ramo'],'pos16',$ob_reporte->nota16,$conn,$ano); }else{ if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font>
                        <? } else { echo $ob_reporte->nota16; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos17 = porcentaje($periodo,$fila['id_ramo'],'pos17',$ob_reporte->nota17,$conn,$ano); }else{ if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font>
                        <? } else { echo $ob_reporte->nota17; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos18 = porcentaje($periodo,$fila['id_ramo'],'pos18',$ob_reporte->nota18,$conn,$ano); }else{ if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font>
                        <? } else { echo $ob_reporte->nota18; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos19 = porcentaje($periodo,$fila['id_ramo'],'pos19',$ob_reporte->nota19,$conn,$ano); }else{ if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font>
                        <? } else { echo $ob_reporte->nota19; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos20 = porcentaje($periodo,$fila['id_ramo'],'pos20',$ob_reporte->nota20,$conn,$ano); }else{ if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font>
                        <? } else { echo $ob_reporte->nota20; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <? }else{?>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota1; ?></font>
                        <? } else { echo $ob_reporte->nota1; } ?>
                    </strong></div></td>
                    
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
                        <? } else { echo $ob_reporte->nota2; } ?>
                    </font></strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
                        <? } else { echo $ob_reporte->nota3; } ?>
                    </font></strong></div></td>
                   
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font>
                        <? } else { echo $ob_reporte->nota4; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font>
                        <? } else { echo $ob_reporte->nota5; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font>
                        <? } else { echo $ob_reporte->nota6; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font>
                        <? } else { echo $ob_reporte->nota7; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font>
                        <? } else { echo $ob_reporte->nota8; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font>
                        <? } else { echo $ob_reporte->nota9; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font>
                        <? } else { echo $ob_reporte->nota10; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font>
                        <? } else { echo $ob_reporte->nota11; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font>
                        <? } else { echo $ob_reporte->nota12; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font>
                        <? } else { echo $ob_reporte->nota13; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font>
                        <? } else { echo $ob_reporte->nota14; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font>
                        <? } else { echo $ob_reporte->nota15; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font>
                        <? } else { echo $ob_reporte->nota16; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font>
                        <? } else { echo $ob_reporte->nota17; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font>
                        <? } else { echo $ob_reporte->nota18; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font>
                        <? } else { echo $ob_reporte->nota19; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font>
                        <? } else { echo $ob_reporte->nota20; } ?>
                    </strong></div></td>
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
					
					if($tot_periodo>1){
						$XUXA =$ob_reporte->Notas2($conn); //CONSULTA AL REPORTE CLASS LAS NOTAS DE PERIODOS										
					}else{								 																																					
						$XUXA =$ob_reporte->Notas2($conn); //CONSULTA AL REPORTE CLASS LAS NOTAS DE PERIODOS
					}
					
					if (pg_numrows($XUXA)>0){ 
					
						$fila_peri = @pg_fetch_array($XUXA,0);
						
						
						
						if($tipo_eval==2){
							
							
							
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								
							if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim(		
							$fila_peri['promedio'])==""){
							
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
							
							if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim(
							$fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
							
									$prome_1 = "&nbsp;";
							
								} else {																																																										
							
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
							
								}
								
						
						}
					
					}else{
						
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						
						//echo "eximido-->".@pg_numrows($rs_eximido);
						
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
					if($institucion==1914 OR $institucion==40251){
					
					if($periodos==$periodo){ 
					
					?>
                    
                    <td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0){ ?>
                        <strong><font color="#FF0000"><? echo $prome_1 ?></font>
                        <? } else { echo $prome_1; } ?>
                      </strong></td>
                    <? 	}
					
					}else{
						
						?>
                    
                    <td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0){?>
                        <strong><font color="#FF0000"><? 
						if($fila_peri['prom_gral']!=""){
							
							echo "cc".$prome_1=$fila_peri['nota_final'];
							
						}else{ 
							if(substr($periodo_pal,0,7)=='SEGUNDO'){
							 $nota_final=$fila_peri['nota_final'];
							}
							
						if(isset($nota_final)){ 
						
							 if($nota_final>=40 ){ ?>
                        <font color="#000000"><? 
							echo $prome_1=$fila_peri['nota_final'];
							?></font> <? }else{?>
								 <font color="#FF0000"><? 
							echo $prome_1=$fila_peri['nota_final'];
							?></font> <?
								}
						}else{
							echo $prome_1; //problemas
						}
							} 
						
						?></font>
                        <? }else{ 
						
		 $sql2 = "SELECT prom_gral, nota_examen, nota_final FROM situacion_periodo WHERE rut_alumno=".$alumno." AND id_ramo=".$id_ramo." AND  id_periodo=".$periodo.";"; 
 $rs_promedio = @pg_exec($conn,$sql2) or die("SELECT FALLO: ".$sql2);
 $promedio_segundo=pg_result($rs_promedio,0);	
 $nota_final2=pg_result($rs_promedio,2);			
if($_PERFIL==0){
	//echo "periodo-->".$periodo."--- periodos-->".$periodos;	
}	
						if($periodo==$periodos ){
							if($promedio_segundo!=0){
						echo $promedio_segundo;
							}else{
		            $ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;
					
					//if($tot_periodo>1){
					$notactm =$ob_reporte->Notas2($conn); //CONSULTA AL REPORTE CLASS LAS NOTAS DE PERIODOS										
					
					if (pg_numrows($notactm)>0){ 
						$fila_perio = @pg_fetch_array($notactm,0);							
								echo "&nbsp;".$fila_perio['promedio'];
								
					}
							}
					
						}else{
							//nota de situacion periodo
							if(substr($periodo_pal,0,7)=='SEGUNDO'){
								
							$promedioql=$fila_peri['prom_gral'];
							}
							if(pg_numrows($rs_promedio)==0){
								echo $prome_1;	
							}else{
								echo $fila_peri['nota_final'];	
							}
						/*if(!isset($promedioql)){
						echo $prome_1;
						}else{
							echo $prome_1;
						}*///aqui
						
						}
						
						} // PROMEDIOS FINALES PERIODOS ?> 
                      </strong></td>
                      
                    <? }
					
					if($periodos==$periodo){
					/****** SITUACION FINAL****************/
					$nota_examen ="";
					$sql = "SELECT prom_gral, nota_examen, nota_final FROM situacion_periodo WHERE rut_alumno=".$alumno." AND id_ramo=".$id_ramo." AND  id_periodo=".$periodo.";";
					
					$rs_examen = @pg_exec($conn,$sql) or die("SELECT FALLO: ".$sql);
					$nota_examen = @pg_result($rs_examen,1);
					$prom_final_ex = @pg_result($rs_examen,2);
					$prom_final_ex2 = @pg_result($rs_examen,2);
					
					if(@pg_numrows($rs_examen)==0){
						 $prom_final_ex =$prome_1;
					}
					?>
                      <td align="center">
                      <!--nota porcentaje promedio-->
                     <font size="1" face="Arial, Helvetica, sans-serif"><?php  if(intval($fila['pct_ex_semestral'])>0){  ?>                      
                      <?php 
					  //if($nex>$prome_1){ 
					  if($fila['conexper']==1){
						  	$n_not = (intval(($prome_1*$pnex)/100))/10;
							echo $n_not;
					  }else{ echo "--".$pnex;
						  $n_not=($prome_1/10);
						  echo "&nbsp;";
					  } ?>
                      
           <strong>
           <?php  ?>
           </strong></font>
          <?php }else{echo "&nbsp;";}?>
           </td>
                    <td align="center" class="subitem">
					<?php
					// if($nex>$prome_1) {
						if($fila['conexper']==1){?>
					<? if($nota_examen<40 && $nota_examen>0) { ?>
                     
                        <strong><font color="#FF0000"><? echo "&nbsp;".$nota_examen ?></font>
                        <? }
						elseif($fila['nota_ex_semestral']<$prome_1){?>
                        <strong><font color="#000000">EX</font>
                        <?
							
							}
						 else { echo "&nbsp;".$nota_examen; } 
					}
						?>
                      </strong> </td>
                        <td align="center">
                        <!--porcentaje examen-->
                        <?php  if(intval($fila['pct_ex_semestral'])>0 ){ ?>             
                        <font size="1" face="Arial, Helvetica, sans-serif">
           <strong>
           <?php 
		   //if($nex>$prome_1)
			if($fila['conexper']==1){
				
			if($fila['nota_ex_semestral']<$prome_1){
				$n_exm=0;
				}
				else{
		   $n_exm =  (intval(($nota_examen*$fila['pct_ex_semestral'])/100))/10;
			echo $n_exm;}
			}
			
				
			else{
				$n_exm = 0; echo "&nbsp;";
			}?>
           
           </strong></font>
           <?php }
		   
		   else{echo "&nbsp;";}?>
         </td>
                    <td align="center" class="subitem">
					
					
					<? if($prom_final_ex<40 && $prom_final_ex>0){ 
							/*if(intval($fila['pct_ex_semestral'])>0 ){ //ELIMINACION DE CODIGO 06/01/2016 EDUARDO ROJAS
							$prom_final_ex = ($n_not+$n_exm)*10;
							}else{
							$prom_final_ex = $prome1;
							}*/
					?>
                        <strong><font color="#FF0000"><? echo "&nbsp;".$prom_final_ex ?></font>
                    <? } else { echo "&nbsp;".$prom_final_ex;
					if($bool_pgeneral==1 && intval($prom_final_ex)!=0){
						$cuenta[$alumno][]= $prom_final_ex;
						}
					 } ?>
                      </strong> </td>
                    <?
					}
					/***********FIN SITUACION FINAL********************/	
				
					 
				} ?>
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
			
			
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
                    <?
			
				
			}	
			
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
                    <?
				
			}
			
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>
                    <?
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
		  /*if($ck_alumnos==1){
			  $ob_reporte ->RamoAlumnoEximido($conn);
		  }else{*/
			  $ob_reporte ->RamoFormacion($conn);
		  //}
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
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos1 = porcentaje($periodo,$fila['id_ramo'],'pos1',$ob_reporte->nota1,$conn,$ano); 	}else{ if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font>
                        <? } else { echo $ob_reporte->nota1; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos2 = porcentaje($periodo,$fila['id_ramo'],'pos2',$ob_reporte->nota2,$conn,$ano);	}else{ if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
                        <? } else { echo $ob_reporte->nota2; } ?>
                        </font></strong><font color="#FF0000">
                        <? }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos3 = porcentaje($periodo,$fila['id_ramo'],'pos3',$ob_reporte->nota3,$conn,$ano);	}else{ if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
                        <? } else { echo $ob_reporte->nota3; } ?>
                        </font></strong><font color="#FF0000">
                        <? }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos4 = porcentaje($periodo,$fila['id_ramo'],'pos4',$ob_reporte->nota4,$conn,$ano);	}else{ if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font>
                        <? } else { echo $ob_reporte->nota4; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos5 = porcentaje($periodo,$fila['id_ramo'],'pos5',$ob_reporte->nota5,$conn,$ano);	}else{ if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font>
                        <? } else { echo $ob_reporte->nota5; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos6 = porcentaje($periodo,$fila['id_ramo'],'pos6',$ob_reporte->nota6,$conn,$ano);	}else{ if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font>
                        <? } else { echo $ob_reporte->nota6; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos7 = porcentaje($periodo,$fila['id_ramo'],'pos7',$ob_reporte->nota7,$conn,$ano);	}else{ if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font>
                        <? } else { echo $ob_reporte->nota7; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos8 = porcentaje($periodo,$fila['id_ramo'],'pos8',$ob_reporte->nota8,$conn,$ano);	}else{ if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font>
                        <? } else { echo $ob_reporte->nota8; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos9 = porcentaje($periodo,$fila['id_ramo'],'pos9',$ob_reporte->nota9,$conn,$ano);	}else{ if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font>
                        <? } else { echo $ob_reporte->nota9; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos10 = porcentaje($periodo,$fila['id_ramo'],'pos10',$ob_reporte->nota10,$conn,$ano); }else{ if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font>
                        <? } else { echo $ob_reporte->nota10; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos11 = porcentaje($periodo,$fila['id_ramo'],'pos11',$ob_reporte->nota11,$conn,$ano); }else{ if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font>
                        <? } else { echo $ob_reporte->nota11; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos12 = porcentaje($periodo,$fila['id_ramo'],'pos12',$ob_reporte->nota12,$conn,$ano); }else{ if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font>
                        <? } else { echo $ob_reporte->nota12; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos13 = porcentaje($periodo,$fila['id_ramo'],'pos13',$ob_reporte->nota13,$conn,$ano); }else{ if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font>
                        <? } else { echo $ob_reporte->nota13; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos14 = porcentaje($periodo,$fila['id_ramo'],'pos14',$ob_reporte->nota14,$conn,$ano); }else{ if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font>
                        <? } else { echo $ob_reporte->nota14; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos15 = porcentaje($periodo,$fila['id_ramo'],'pos15',$ob_reporte->nota15,$conn,$ano); }else{ if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font>
                        <? } else { echo $ob_reporte->nota15; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos16 = porcentaje($periodo,$fila['id_ramo'],'pos16',$ob_reporte->nota16,$conn,$ano); }else{ if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font>
                        <? } else { echo $ob_reporte->nota16; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos17 = porcentaje($periodo,$fila['id_ramo'],'pos17',$ob_reporte->nota17,$conn,$ano); }else{ if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font>
                        <? } else { echo $ob_reporte->nota17; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos18 = porcentaje($periodo,$fila['id_ramo'],'pos18',$ob_reporte->nota18,$conn,$ano); }else{ if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font>
                        <? } else { echo $ob_reporte->nota18; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos19 = porcentaje($periodo,$fila['id_ramo'],'pos19',$ob_reporte->nota19,$conn,$ano); }else{ if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font>
                        <? } else { echo $ob_reporte->nota19; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos20 = porcentaje($periodo,$fila['id_ramo'],'pos20',$ob_reporte->nota20,$conn,$ano); }else{ if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font>
                        <? } else { echo $ob_reporte->nota20; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <? }else{?>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font>
                        <? } else { echo $ob_reporte->nota1; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
                        <? } else { echo $ob_reporte->nota2; } ?>
                    </font></strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
                        <? } else { echo $ob_reporte->nota3; } ?>
                    </font></strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font>
                        <? } else { echo $ob_reporte->nota4; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font>
                        <? } else { echo $ob_reporte->nota5; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font>
                        <? } else { echo $ob_reporte->nota6; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font>
                        <? } else { echo $ob_reporte->nota7; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font>
                        <? } else { echo $ob_reporte->nota8; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font>
                        <? } else { echo $ob_reporte->nota9; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font>
                        <? } else { echo $ob_reporte->nota10; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font>
                        <? } else { echo $ob_reporte->nota11; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font>
                        <? } else { echo $ob_reporte->nota12; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font>
                        <? } else { echo $ob_reporte->nota13; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font>
                        <? } else { echo $ob_reporte->nota14; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font>
                        <? } else { echo $ob_reporte->nota15; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font>
                        <? } else { echo $ob_reporte->nota16; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font>
                        <? } else { echo $ob_reporte->nota17; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font>
                        <? } else { echo $ob_reporte->nota18; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font>
                        <? } else { echo $ob_reporte->nota19; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font>
                        <? } else { echo $ob_reporte->nota20; } ?>
                    </strong></div></td>
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
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?=$prome_1;?>
                    </font></td>
                    <? 	}
					
					}else{?>
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?=$prome_1;?>
                    </font></td>
                    <? }
				
                   
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
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
                    <?
			}	
			
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
                    <? 
				
			}
			
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>
          <?
             } 
			
			}?>
                  </tr>
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
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos1 = porcentaje($periodo,$fila['id_ramo'],'pos1',$ob_reporte->nota1,$conn,$ano); 	}else{ if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font>
                        <? } else { echo $ob_reporte->nota1; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos2 = porcentaje($periodo,$fila['id_ramo'],'pos2',$ob_reporte->nota2,$conn,$ano);	}else{ if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
                        <? } else { echo $ob_reporte->nota2; } ?>
                        </font></strong><font color="#FF0000">
                        <? }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos3 = porcentaje($periodo,$fila['id_ramo'],'pos3',$ob_reporte->nota3,$conn,$ano);	}else{ if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
                        <? } else { echo $ob_reporte->nota3; } ?>
                        </font></strong><font color="#FF0000">
                        <? }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos4 = porcentaje($periodo,$fila['id_ramo'],'pos4',$ob_reporte->nota4,$conn,$ano);	}else{ if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font>
                        <? } else { echo $ob_reporte->nota4; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos5 = porcentaje($periodo,$fila['id_ramo'],'pos5',$ob_reporte->nota5,$conn,$ano);	}else{ if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font>
                        <? } else { echo $ob_reporte->nota5; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos6 = porcentaje($periodo,$fila['id_ramo'],'pos6',$ob_reporte->nota6,$conn,$ano);	}else{ if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font>
                        <? } else { echo $ob_reporte->nota6; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos7 = porcentaje($periodo,$fila['id_ramo'],'pos7',$ob_reporte->nota7,$conn,$ano);	}else{ if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font>
                        <? } else { echo $ob_reporte->nota7; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos8 = porcentaje($periodo,$fila['id_ramo'],'pos8',$ob_reporte->nota8,$conn,$ano);	}else{ if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font>
                        <? } else { echo $ob_reporte->nota8; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos9 = porcentaje($periodo,$fila['id_ramo'],'pos9',$ob_reporte->nota9,$conn,$ano);	}else{ if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font>
                        <? } else { echo $ob_reporte->nota9; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos10 = porcentaje($periodo,$fila['id_ramo'],'pos10',$ob_reporte->nota10,$conn,$ano); }else{ if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font>
                        <? } else { echo $ob_reporte->nota10; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos11 = porcentaje($periodo,$fila['id_ramo'],'pos11',$ob_reporte->nota11,$conn,$ano); }else{ if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font>
                        <? } else { echo $ob_reporte->nota11; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos12 = porcentaje($periodo,$fila['id_ramo'],'pos12',$ob_reporte->nota12,$conn,$ano); }else{ if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font>
                        <? } else { echo $ob_reporte->nota12; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos13 = porcentaje($periodo,$fila['id_ramo'],'pos13',$ob_reporte->nota13,$conn,$ano); }else{ if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font>
                        <? } else { echo $ob_reporte->nota13; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos14 = porcentaje($periodo,$fila['id_ramo'],'pos14',$ob_reporte->nota14,$conn,$ano); }else{ if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font>
                        <? } else { echo $ob_reporte->nota14; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos15 = porcentaje($periodo,$fila['id_ramo'],'pos15',$ob_reporte->nota15,$conn,$ano); }else{ if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font>
                        <? } else { echo $ob_reporte->nota15; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos16 = porcentaje($periodo,$fila['id_ramo'],'pos16',$ob_reporte->nota16,$conn,$ano); }else{ if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font>
                        <? } else { echo $ob_reporte->nota16; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos17 = porcentaje($periodo,$fila['id_ramo'],'pos17',$ob_reporte->nota17,$conn,$ano); }else{ if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font>
                        <? } else { echo $ob_reporte->nota17; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos18 = porcentaje($periodo,$fila['id_ramo'],'pos18',$ob_reporte->nota18,$conn,$ano); }else{ if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font>
                        <? } else { echo $ob_reporte->nota18; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos19 = porcentaje($periodo,$fila['id_ramo'],'pos19',$ob_reporte->nota19,$conn,$ano); }else{ if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font>
                        <? } else { echo $ob_reporte->nota19; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($pos21=="100"){ echo $pos20 = porcentaje($periodo,$fila['id_ramo'],'pos20',$ob_reporte->nota20,$conn,$ano); }else{ if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font>
                        <? } else { echo $ob_reporte->nota20; } ?>
                        </strong>
                        <? }?>
                    </div></td>
                    <? }else{?>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font>
                        <? } else { echo $ob_reporte->nota1; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?>
                        <? } else { echo $ob_reporte->nota2; } ?>
                    </font></strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?>
                        <? } else { echo $ob_reporte->nota3; } ?>
                    </font></strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font>
                        <? } else { echo $ob_reporte->nota4; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font>
                        <? } else { echo $ob_reporte->nota5; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font>
                        <? } else { echo $ob_reporte->nota6; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font>
                        <? } else { echo $ob_reporte->nota7; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font>
                        <? } else { echo $ob_reporte->nota8; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font>
                        <? } else { echo $ob_reporte->nota9; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font>
                        <? } else { echo $ob_reporte->nota10; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font>
                        <? } else { echo $ob_reporte->nota11; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font>
                        <? } else { echo $ob_reporte->nota12; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font>
                        <? } else { echo $ob_reporte->nota13; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font>
                        <? } else { echo $ob_reporte->nota14; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font>
                        <? } else { echo $ob_reporte->nota15; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font>
                        <? } else { echo $ob_reporte->nota16; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font>
                        <? } else { echo $ob_reporte->nota17; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font>
                        <? } else { echo $ob_reporte->nota18; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font>
                        <? } else { echo $ob_reporte->nota19; } ?>
                    </strong></div></td>
                    <td width="17" class="subitem"><div align="center">
                        <? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?>
                        <strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font>
                        <? } else { echo $ob_reporte->nota20; } ?>
                    </strong></div></td>
                    <? } ?>
                    <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19+$pos20;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					$prome_ap=0;	
					$prome_abajo_ap=0;	
	
					
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
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?=$prome_1;?>
                    </font></td>
                    <? 	}
					
					}else{?>
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?=$prome_1;?>
                    </font></td>
                    <? }


				} ?>
                  </tr>
                  <? } 
  }
  if($tipo_rep!=3 && $tipo_rep!=4){
  ?>
                  <tr height="25">
                    <td colspan="21" align="right" class="subitem"> Promedio &nbsp;&nbsp;&nbsp;</td>
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
		//if($_PERFIL==0) echo "<br>".$filaperi['id_periodo']."-->".$ob_reporte->sumaAP;
		if($truncado_final==0){
			$prome_abajo = @intval($ob_reporte->suma / $ob_reporte->contador);
			//$prome_abajo = intval($prome_semestral / $cuenta_semestral);
			@$prome_abajo_ap = intval($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}else{
			$prome_abajo = @round($ob_reporte->suma / $ob_reporte->contador,0);
			//$prome_abajo = round($prome_semestral / $cuenta_semestral);
			$prome_abajo_ap = @round($ob_reporte->sumaAP / $cuenta_semestral_ap);
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
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?>
                    </font></td>
                    
                    <? }
	}else{ ?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?>
                    </font></td>
                     
                    <? }
					if($periodos==$periodo){
		/**************** PROMEDIO SITUACION FINAL*********************/
		
 $sql="select (sum( case when sp.nota_final is not null then sp.nota_final
else cast(n.promedio as integer) end ) ) as promedio,
 count(*) as contador from notas$nro_ano n
left join situacion_periodo sp on sp.rut_alumno = n.rut_alumno and sp.id_ramo = n.id_ramo
where n.rut_alumno = ".$alumno." and n.id_periodo=".$filaperi['id_periodo']." and n.promedio not in ('MB','B','S','I',' ' ,'0')";
		$resul = pg_Exec($conn,$sql)or die("Fallo : ".$sql);
		for($k=0;$k<@pg_numrows($resul);$k++){
			$fila_nf = @pg_fetch_array($resul,$k);
		/*$sumapromfinal=$fila_nf['promedio'];
		$cantidad=$fila_nf['contador'];*/
		
		$sumapromfinal= array_sum($cuenta[$alumno]);
		$cantidad = count($cuenta[$alumno]);
		
		if($_PERFIL==0){echo "sumapromfinal->".$sumapromfinal." cantidad->$cantidad";}
		
			if($bool_psemestral==0){
				$prom_notafinal=intval($sumapromfinal/$cantidad);
			}else{
				$prom_notafinal=round($sumapromfinal/$cantidad);
			}
		}
		
	
		?>
        <td align="center">&nbsp;</td>
		<td align="center"><?  echo "&nbsp;"; ?></td>
        <td align="center">&nbsp;</td>
		<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
		<?php //if($_PERFIL==0){show($cuenta[$alumno]);}?>
		<? if($prom_notafinal>0) echo $prom_notafinal; else  echo "&nbsp;"; ?></font></td>
		<? }
		/***************** FINAL SITUACION FINAL*****************/
	
	}// FIN FOR PERIODO DE PROMEDIOS ?>
                  </tr>
                  <? } ?>
                </table>
				<? 	}
  } ?>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
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
</table>
	
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
			<td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } 
		  for($o=1; $o<=3; $o++){
		  ?>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } ?>
	  </table>
<table width="650" border="0" align="center">
<tr>
<?  
	for($mm=1;$mm<$txtESPACIO;$mm++){
		echo "<br>";
	}
if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
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
<?

	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
    <? //} // FIN FOR ALUMNOS
} ?>
</body>
</html>

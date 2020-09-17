<?php 
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$mes			=$cmb_meses;
	$sep			=$SEP;
	$reporte		=$c_reporte;
	

	$ob_membrete = new Membrete;
	$ob_reporte = new Reporte;
	
	$ob_membrete->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano =$ob_membrete->nro_ano;
	$fecha_inicio_ano =$ob_membrete->fecha_inicio;
	$fecha_termino_ano = $ob_membrete->fecha_termino;
	$dia_fin = explode("-",$fecha_termino_ano);
	$dia_final = $dia_fin[2];
	
	
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	//buscar periodo
	$ob_config->ano = $ano;
	$rs_peridos = $ob_config->TotalPeriodo($conn);
	$fila_periodo = pg_fetch_array($rs_peridos,0);
	$fecha_inicio_periodo = $fila_periodo['fecha_inicio'];
	$dia_inicio = explode("-",$fecha_inicio_periodo);
	$dia_inicial = $dia_inicio[2];
	
	//dia curso
	 $sq_c = "select fecha_inicio,fecha_termino from curso where id_curso=$curso";
	$rs_c = pg_exec($conn,$sq_c);
	$fecha_inicio_curso = pg_result($rs_c,0);
	$fecha_termino_curso = pg_result($rs_c,1);
	$dia_inicio = explode("-",$fecha_inicio_curso);
	 $dia_inicial = $dia_inicio[2];
	$dia_termino = explode("-",$fecha_termino_curso);
	$dia_final = $dia_termino[2];
	
	
	switch ($mes){
		case 1:
		
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."01";
			break;
		case 2:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."28";
			break;
		case 3:
			$fecha_inicio =$nro_ano."-".$mes."-".$dia_inicial;
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			break;
		case 4:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			break;
		case 5:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			break;
		case 6:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			break;
		case 7:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			break;
		case 8:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			break;
		case 9:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			break;
		case 10:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			break;
		case 11:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			break;
		case 12:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-".$dia_final;
			//$fecha_termino=$nro_ano."-".$mes."-".$dia_final;
			break;
		}
		
		//echo $fecha_inicio;
	
		/*function diashabiles($ano,$mes,$dia_final,$dia_inicial,$fecha_parte,$dia_parte){
			
			

			if($mes==1 || $mes==5 || $mes==7 || $mes==8 || $mes==10){
				$dia=31;
			}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
				$dia=30;
				
			}
			elseif($mes==12){
							
				if($dia_final<10){
				$dia = str_replace("0","",$dia_final);
				}else{
				$dia = $dia_final;
				}
				}
				
			elseif($mes==3){
				if(date("Y")==2016){
				 $dia2 = 31 - ($dia_inicial-2);
				}
				else{
					
				}
				$dia2 = 31;
				$dia = $dia2;
				}
			elseif($mes==2){
				if(intval($ob_membrete->nro_ano)%4!=0){
				$dia=28;
				}
				else{
					$dia=29;
				}
			}
			
			//echo $dia;
			if($dia_parte!=1)
			{$dd=($dia-$dia_parte);}
			else
			{$dd = $dia;}
			
			for($i=$dia_parte;$i<=$dd;$i++){
				$semana=date("l",mktime(0,0,0,$mes,$i,$ano));
				if($semana=="Sunday" OR $semana=="Saturday"){
					$cuentanohabil++;
				}
			}
			echo $diashabiles = $dd-$cuentanohabil;
			//$diashabiles = $cuentanohabil ;
			return($diashabiles);
		}*/
		
if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Asistencia_Alumno_$Fecha.xls"); 
}	



?>

<?php
function cc2_date_diff($start, $end) {
    
        $sdate = strtotime($start);
        $edate = strtotime($end);
        
        if ($edate < $sdate) {
            $sdate_temp = $sdate;
            $sdate = $edate;
            $edate = $sdate_temp;
            
        }
        $time = $edate - $sdate;
        $preday[0] = 0;
        
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);
               
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
               
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);
               
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;
               
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        
		
        return $preday[0]+1;
} 



//dias ihnabiles por rango fijo, sin paradas de mes
function habiles2($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(1,2,3,4,5))) { // DOC: http://www.php.net/manual/es/function.date.php
                        //cuento los dias habiles
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        return count($diashabiles);
}
?>

<script> 
function exportar(){
	//form.target="_blank";
	window.location='printInformeAsistenciaAlumno_C.php?cmb_curso=<?=$curso?>&cmb_meses=<?=$mes?>&SEP=<?=$sep?>&ano=<?=$ano;?>';
	//document.form.submit(true);
	return false;
}
function cerrar(){ 
window.close() 
} 
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
.subitem { font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
}
-->
</style>
</head>

<body>
<div id="capa0">
	<table width="650" align="center">
	  <tr>
	  	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
		<td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
	   <? if($_PERFIL == 0){?>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR" /></td>
	  <? }?>
	  </tr>
	</table>
</div>
<table width="650" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr height="15">
    <td colspan="5"><table border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td align="left" class="item"><strong> INSTITUCION </strong> </td>
        <td> <strong>: </strong></td>
        <td class="subitem">
          <?php  
			  		$ob_membrete->institucion = $institucion;                                   
					$ob_membrete->institucion($conn);
					echo $ob_membrete->ins_pal;
			  ?>
        </td>
      </tr>
      <tr>
        <td align="left" class="item"><strong>A&Ntilde;O ESCOLAR</strong> </td>
        <td> <strong>: </strong></td>
        <td class="subitem"> <?php echo $ob_membrete->nro_ano; ?></td>
      </tr>
      <tr>
        <td align="left" class="item"><strong>CURSO</strong> </td>
        <td> <strong>: </strong></td>
        <td class="subitem">
          <?php 
			  		$ob_membrete->curso =$curso;
					$ob_membrete ->curso($conn);
									
					if (($ob_membrete->cod_decreto==771982) or ($ob_membrete->cod_decreto==461987) or ($ob_membrete->cod_decreto==121987) or ($ob_membrete->cod_decreto==1521989)){
						$ob_membrete->grado =$ob_membrete->grado_curso;
						$ob_membrete->decreto =$ob_membrete->cod_decreto;
						$ob_membrete->CambiaDatoCurso($conn);
						echo $ob_membrete->sigla." - ".$ob_membrete->letra_curso." ".$ob_membrete->nombre_tipo;
						
					}else{
						echo $ob_membrete->grado_curso." - ".$ob_membrete->letra_curso." ".$ob_membrete->ensenanza;
					}
			 ?>
         </td>
      </tr>
      <tr>
        <td align="left" class="item"><strong> PROFESOR JEFE </strong></td>
        <td><strong> :  </strong></td>
        <td class="subitem">
          <?
				$ob_reporte->curso = $curso;
			  	$ob_reporte->ProfeJefe($conn);
				echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
				?>
	</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right"></td>
  </tr>
  <tr>&nbsp;</tr>
  <br />
  <tr height="20">
    <td align="middle" colspan="5" class="tableindex"><div align="center">LISTADO DE ASISTENCIA DEL CURSO<br />
    MES:&nbsp;<? echo strtoupper(envia_mes($mes));?></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="107" align="center" bgcolor="#999999" class="item">Rut</td>
        <td width="283" align="center" bgcolor="#999999" class="item">NOMBRE</td>
        <td width="47" align="center" bgcolor="#999999" class="item">DIAS<br />
          ASIST.</td>
        <td width="63" align="center" bgcolor="#999999" class="item"><p>%<br />
        ASIST.</p>          </td>
        <td width="64" align="center" bgcolor="#999999" class="item">DIAS<br />
          INASIST.</td>
        <td width="64" align="center" bgcolor="#999999" class="item">%<br />
          INASIST.</td>
        </tr>
        

      <?php
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		$ob_reporte->sep = $sep;
		$ob_reporte->retirado=0;
		$ob_reporte->orden=3;
		$result=$ob_reporte->FichaAlumnoTodos($conn);
		
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);
			$ob_reporte ->CambiaDato($fila);
			$fer=0;
			$hab=0;


			$ob_reporte ->alumno =$ob_reporte->alumno;
			$ob_reporte ->cmb_curso = $curso;
			$ob_reporte ->ano = $ano;
			
			//---------------------------------------
			//diferencia de dias habiles entre dias feriados
			if($ob_reporte->mes_matr==$mes){
				 $mesparte = $ob_reporte->dia_matr;
				 $ob_reporte->fecha_ini2=$ob_reporte->fecha_matr;				 
				}
			else{
				$ob_reporte->fecha_ini2=$fecha_inicio;
				$mesparte = 1;
				}
				
			    $ob_reporte->fecha2=$fecha_termino;
				$rs_feriado2=$ob_reporte->DiaHabil2($conn);
				
				if(pg_numrows($rs_feriado2)>0){
					//echo $fecha_inif = pg_result($rs_feriado2,0);
					//echo $fecha_finf = pg_result($rs_feriado2,1);
					
		for($f=0;$f<pg_numrows($rs_feriado2);$f++){
			$filaf=pg_fetch_array($rs_feriado2,$f);
			 $fecha_inif = date($filaf['fecha_inicio']);
			 $fecha_finf = date($filaf['fecha_fin']);
			 
			 
			$fer=$fer+cc2_date_diff($fecha_inif,$fecha_finf);
			
			 $habi=habiles2($fecha_inif,$fecha_finf);
			 $hab = $hab+$habi;
			
		}
		}
		
		  $fext=intval($fer-$hab);
				
				
			//---------------------------------------	
			
			

			$ob_reporte ->fechaMatrAsis($conn);
			// echo $ob_reporte->fecha_matr;

			if($ob_reporte->mes_matr==$mes){
				$ob_reporte->fecha_inicio = $ob_reporte->fecha_matr;
				$ob_reporte->fecha_ini=$ob_reporte->fecha_matr;
				 $mesparte = $ob_reporte->dia_matr;
			}
			else{
				$ob_reporte->fecha_inicio = $fecha_inicio;
				$ob_reporte->fecha_ini=$fecha_inicio;
				$mesparte = 1;	
			}
			
			//$ob_reporte ->fecha_inicio = $fecha_inicio;
			$ob_reporte ->fecha_termino = $fecha_termino;
			$result_asis = $ob_reporte ->Asistencia($conn);
			$cuenta_inasis = @pg_numrows($result_asis);
			$ob_reporte->fecha=$fecha_termino;
			
			$rs_feriado=$ob_reporte->DiaHabil($conn);
			//$feriado = pg_result($rs_feriado,0);
			
			$feriado=$fext;
			
			 //$DiasHabiles = diashabiles($nro_ano,$mes,$dia_final,$dia_inicial,$ob_reporte->fecha_inicio,$mesparte);
			  $DiasHabiles = hbl($fecha_inicio,$fecha_termino);
			 /*if($_PERFIL==0){
				 echo $fecha_inicio;
				 echo $fecha_termino;
					//echo  $DiasHabiles." - ".$cuenta_inasis." - ".$feriado;
			 }*/
			$DiasAsistencia = $DiasHabiles - $cuenta_inasis - $feriado;
			if($DiasAsistencia!=0){
				$PorcAsis = substr(100-((($cuenta_inasis *100)/$DiasHabiles)),0,5);
				if($PorcAsis<0){
					$PorcAsis =$PorcAsis*-1;
				}
			}else{
				$PorcAsis = "&nbsp;";
			}
			
			$PorcInasis = 100 - $PorcAsis;
			if($cuenta_inasis==0) $cuenta_inasis="&nbsp;";
			if($PorcInasis==0) $PorcInasis="&nbsp;";
			?>
        <tr>
        <td align="left" class="subitem" >&nbsp;&nbsp;<?=$ob_reporte->rut_alumno?></td>
        <td align="left" class="subitem" >&nbsp;&nbsp;<?=$ob_reporte->tilde($ob_reporte->ape_nombre_alu);?></td>
        <td align="left" class="subitem" ><div align="center">&nbsp;<?=$DiasAsistencia;?></div></td>
        <td align="left" class="subitem" ><div align="right">&nbsp;<?=$PorcAsis;?></div></td>
        <td align="left" class="subitem" ><div align="center">&nbsp;<?=$cuenta_inasis;?></div></td>
        <td align="left" class="subitem" ><div align="right">&nbsp;<?=$PorcInasis;?></div></td>
        </tr>
      <?php
		}
			?>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><hr width="100%" color="#003b85" />
    </td>
  </tr>
</table>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>
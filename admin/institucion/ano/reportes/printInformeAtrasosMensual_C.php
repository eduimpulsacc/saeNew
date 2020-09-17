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
	@$ob_membrete ->AnoEscolar($conn);
	$nro_ano =$ob_membrete->nro_ano;
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if ($mes<9){
		$mes="0".$mes;
		}else{
		$mes;	
		}
	
	switch ($mes){
		case 1:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		case 2:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."28-".$nro_ano;
			break;
		case 3:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		case 4:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."30-".$nro_ano;
			break;
		case 5:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		case 6:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."30-".$nro_ano;
			break;
		case 7:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		case 8:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		case 9:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."30-".$nro_ano;
			break;
		case 10:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		case 11:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."30-".$nro_ano;
			break;
		case 12:
			$fecha_inicio =$mes."-"."01-".$nro_ano;
			$fecha_termino=$mes."-"."31-".$nro_ano;
			break;
		}
		function diashabiles($ano,$mes){
			if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
				$dia=31;
			}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
				$dia=30;
			}else{
				$dia=28;
			}
			
			for($i=1;$i<=$dia;$i++){
				$semana=date("l",mktime(0,0,0,$mes,$i,$ano));
				if($semana=="Sunday" OR $semana=="Saturday"){
					$cuentanohabil++;
				}
			}
			$diashabiles = $dia - $cuentanohabil;
			return($diashabiles);
		}
		
if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Asistencia_Alumno_$Fecha.xls"); 
}	

?>
<script> 
function exportar(){
					//form.target="_blank";
					window.location='printInformeAsistenciaAlumno_C.php?cmb_curso=<?=$curso?>&cmb_mes=<?=$mes?>&SEP=<?=$sep?>';
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
    <td align="middle" colspan="5" class="tableindex"><div align="center">LISTADO DE ATRASOS DEL CURSO<br />
    MES:&nbsp;<? echo strtoupper(envia_mes($mes));?></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="107" align="center" bgcolor="#999999" class="item">Rut</td>
        <td width="283" align="center" bgcolor="#999999" class="item">NOMBRE</td>
        <td width="47" align="center" bgcolor="#999999" class="item">DIAS<br />
          ATRAS.</td>
      <!--  <td width="63" align="center" bgcolor="#999999" class="item"><p>%<br />
        ASIST.</p>          </td>-->
        
        </tr>
      <?php
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		$ob_reporte->sep = $sep;
		$ob_reporte->retirado=0;
		$ob_reporte->orden=0;
		$result=$ob_reporte->FichaAlumnoTodos($conn);
		
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);
			$ob_reporte ->CambiaDato($fila);

			$ob_reporte ->alumno =$ob_reporte->alumno;
			$ob_reporte ->cmb_curso = $curso;
			$ob_reporte ->ano = $ano;
			$ob_reporte ->fecha_inicio = $fecha_inicio;
			$ob_reporte ->fecha_termino = $fecha_termino;
			$ob_reporte ->tipo = "2";
			$result_atrasos = $ob_reporte ->Atrasosmes($conn);
			$cuenta_Atrasos = @pg_numrows($result_atrasos);
			//echo "atrasos-->".$cuenta_Atrasos;
			//$DiasHabiles = diashabiles($nro_ano,$mes);
			$DiasAtrasos = $cuenta_Atrasos;
			
						
			//$PorcInasis = 100 - $PorcAsis;
			//if($cuenta_inasis==0) $cuenta_inasis="&nbsp;";
			//if($PorcInasis==0) $PorcInasis="&nbsp;";
			?>
        <tr>
        <td align="left" class="subitem" >&nbsp;&nbsp;<?=$ob_reporte->rut_alumno?></td>
        <td align="left" class="subitem" >&nbsp;&nbsp;<?=$ob_reporte->tilde($ob_reporte->nombres);?></td>
        <td align="left" class="subitem" ><div align="center">&nbsp;<?=$DiasAtrasos;?></div></td>
        <!--<td align="left" class="subitem" ><div align="right">&nbsp;<? $PorcAsis;?></div></td>
       
        </tr>-->
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
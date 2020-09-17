<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	//print_r($_POST);
	
	$institucion	=$_INSTIT;
	$ano			=$c_ano;
	$reporte		=$c_reporte;
	$curso			=$c_curso;
	
	
	$_POSP = 4;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte->curso=$curso;
	$rs_profe = $ob_reporte->ProfeJefe($conn);
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$sql="SELECT sum(dias_habiles) FROM periodo WHERE id_ano=".$ano;
	$rs_periodo =pg_exec($conn,$sql);
	$dias_habiles = pg_result($rs_periodo,0);
	
	$ob_reporte->ano=$ano;
	$ob_reporte->nro_ano =$ob_membrete->nro_ano;
	for($i=3;$i<13;$i++){
		$ob_reporte->mes=$i;
		$rs_curso_asis[$i] = $ob_reporte->MatriculaMes2($conn);
	}
	for($i=0;$i<@pg_numrows($rs_curso_asis[3]);$i++){
		$fila = @pg_fetch_array($rs_curso_asis[3],$i);
	}

	$ob_reporte->ano=$ano;
	$ob_reporte->AnoEscolar($conn);
	$ano2=$ob_reporte->nro_ano;
	
		
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Mes_Curso_$Fecha.xls"); 
	}	
	
	function envia_mes2($i){
		switch($i){
			case 1:
				echo "ENERO";
				break;	
			case 2:
				echo "FEBRERO";
				break;	
			case 3:
				echo "MARZO";
				break;
			case 4:
				echo "ABRIL";
				break;		
			case 5:
				echo "MAYO";
				break;	
			case 6:
				echo "JUNIO";
				break;	
			case 7:
				echo "JULIO";
				break;	
			case 8:
				echo "AGOSTO";
				break;	
			case 9:
				echo "SEPT.";
				break;	
			case 10:
				echo "OCT.";
				break;	
			case 11:
				echo "NOV.";
				break;	
			case 12:
				echo "DIC.";
				break;	
			

				
		}
	}
	
	function DiasHabiles($id_ano,$mes_actual,$nro_ano,$conn){
		$habiles=0;
		for($i=1;$i<32;$i++){
			$dia= date("w",mktime(0, 0, 0, $mes_actual, $i, $nro_ano));
			if($dia!=6 && $dia!=0){
				$habiles++;
			}	
		}
		return $habiles;
	}
?>
<script>
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
<link href="../../../../cortes/12086/estilos.css " rel="stylesheet" type="text/css">

<title>COLEGIOINTERACTIVO.COM</title>
</head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
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
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><div align="left"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></div></td>
    <td class="textosesion"><div align="center">(*)Reporte debe imprimirse de manera horizontal</div></td>
    <td><div align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="71%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="834"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
   <? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
	  
   <? } ?>  
	  
	  
	  	</td>
		</tr>
      </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
            <td height="41" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>
<br>	
<table width="71%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">INFORME ANUAL POR ALUMNO																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																						</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ano2)) ;?></strong></span></td>
  </tr>
</table>
<br>
<!--/////////////////////////////////////nueva tabla///////////////////////////////-->
<table width="71%" border="0" align="center">
  <tr>
    <td width="19%" class="textonegrita">Curso</td>
    <td width="3%" class="textonegrita">:</td>
    <td width="78%" class="textosimple">&nbsp;<? echo CursoPalabra($curso,0,$conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">Profesor Jefe</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<?=$ob_reporte->profe_jefe;?></td>
  </tr>
</table>
<br />
<table align="center" width="71%" border="1" cellpadding="0" cellspacing="0">
  <tr class="tablatit2-1">
    <td width="71%" height="27"><div align="center">ALUMNOS</div></td>
	<td width="9%">MATRIC.</td>
    
	<? for($i=2;$i<13;$i++){?>
    <td width="9%"><div align="center"><?=envia_mes2($i);?>.</div></td>
	<? }?>
    <td width="11%"><div align="center">TOTAL</div></td>
    <td width="11%">TOTAL %</td>
  </tr>
  <?
	$ob_cursos = new Reporte();
	$ob_cursos->ano=$ano;
	$ob_cursos->curso=$curso;
	$rs_alumnos=$ob_cursos->TraeTodosAlumnos($conn);
	$num_alumnos=pg_numrows($rs_alumnos);
	$mes = 0;
	for($i=0;$i<$num_alumnos;$i++){
	$fila= pg_fetch_array($rs_alumnos,$i);
	$nombre_alumno=$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_alu'];
	$total_asis_curso =0;
	
	?>
  <tr>
    <td class="textosimple"><? echo strtoupper($nombre_alumno);?></td>
	<td class="textosimple"><div align="right">
	    <?=$cant_matricula;?>
    </div></td>
	<? 
		$total_habiles=0;
		for($e=2;$e<13;$e++){
			
			$ob_reporte->ano=$ano;
			$ob_reporte->curso=$curso;
			$ob_reporte->alumno=$fila['rut_alumno'];
			$ob_reporte->nro_ano=$ob_membrete->nro_ano;
			$ob_reporte->mes=$e;
			$rs_asistencia = $ob_reporte->TotalAsistencia($conn);
			$inasistencia = pg_result($rs_asistencia,0);		
			$habiles = DiasHabiles($ano,$e,$ob_membrete->nro_ano,$conn);
			//$habiles = pg_result($ob_reporte->DiasHabiles($conn),0);
			$asistencia = ($habiles) - $inasistencia;
			$porcentaje = substr(($asistencia * 100)/ $habiles,0,5);
			/*$total_asis_curso = $total_asis_curso + $asistencia ;
			$total_curso[$e] = $total_curso[$e] + $asistencia;
			$total_habiles = $total_habiles + $habiles;*/

			
	?>
    <td class="textosimple">&nbsp;<? echo $asistencia;?></td>
    <? }
		
	?>
    <td class="textosimple"><div align="right">
        <?=number_format($total_asis_curso,'0',',','.');?>
    </div></td>
    <td align="right" class="textosimple"><? echo intval(($total_asis_curso * 100) / ($total_habiles * $cant_matricula))."%";?>&nbsp;</td>
  </tr>
  <? }?>
  <tr>
    <td class="textosimple">TOTALES</td>
	<td class="textosimple"><div align="right">
	    <?=$total_mat;?>
    </div></td>
	<? for($e=3;$e<13;$e++){
		$total_gral = $total_gral + $total_curso[$e];?>
    <td class="textosimple"><div align="right">
        <?=number_format($total_curso[$e],'0',',','.');?>
    </div></td>
    <? }?>
    <td class="textosimple"><div align="right">
        <?=number_format($total_gral,'0',',','.');?>
    </div></td>
    <td align="right" class="textosimple"><? echo intval(($total_gral * 100) / ($total_habiles * $total_mat))."%";?>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
  		  <? if(!$cb_ok=="Buscar"){?>
		  <td>&nbsp;</td>
		  <? }?>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</body>
</html>

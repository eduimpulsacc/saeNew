<?php 
session_start();
require("../../../util/header.php");


require("../clases.php");
//var_dump($_POST);

	$institucion	=$_INSTIT;
	$ano			=$cmbANO;
	$curso			=$cmbCURSO;
	$ramo			=$cmbRAMO;
	$unidad			=$cmbUNIDAD;
	$clase			=$cmbCLASE;
	$periodo		=$cmbPERIODO;
	$arr			=$datos;
$ob_reporte = new Reporte();

//echo $aprox;

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);

$fila_clase = pg_fetch_array($rs_clase,$c);
$fila_ano = $ob_reporte->Ano($conn,$ano);

$nro_ano = $fila_ano['nro_ano'];

$rs_per = $ob_reporte->Periodo($conn,$ano,$periodo);
$fil_per = pg_fetch_array($rs_per,0);

$rs_ramo = $ob_reporte->CodRamoUno($conn,$ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);

$grado = explode("_",$cmbGRADOS);
$rs_ense = $ob_reporte-> EnsenanzaUno($conn,$grado[0]);
$fila_ense = pg_fetch_array($rs_ense,0);

$grd = "GRADO ".$grado[1]." - ".$fila_ense['nombre_tipo']; 

$arr_promedio=array();
$arr_promedio2= array();

?>
<meta charset="latin1">
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<style>
@media all {
   div.saltopagina{
      display: none;
   }
   div.cabecera2{
      display: none;
   }
   
   @media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
   div.cabecera2{ 
      display:block; 
      
   }
    
   }
 .cabecera,.cabecera2 {height: 4em;
/*background-color: #399;
color: #fff;*/
text-align: center;
top:0;

}
</style>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close() 
} 
</script>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="690" align="center">
<tr><td valign="top">
<div class="cabecera"><?php include("../cabecera/cabecera.php"); ?></div><br>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="690" border="0" align="center">
  <tr class="">
    <td width="159" align="center" class="textonegrita" colspan="2" >INFORMACI&Oacute;N NOTAS POR GRADO</td>
  </tr>
  <tr class="">
    <td align="center" class="textonegrita" colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="159" class="textonegrita">A&Ntilde;O</td>
    <td colspan="3" class="textosimple"><? echo $fila_ano['nro_ano'];?></td>
    </tr>
  <tr>
    <td class="textonegrita">PERIODO</td>
    <td colspan="3" class="textosimple"><?php echo $fil_per['nombre_periodo'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita">ASIGNATURA</td>
    <td colspan="3" class="textosimple"><? echo $fila_ramo['nombre']." ".$fila_ramo['cod_subsector'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">GRADO</td>
    <td colspan="3" class="textosimple"><?php echo $grd ?></td>
  </tr>
    
</table>
<br />
<br />
<table width="100%" border="0" class="tablaredonda">
  <tr class="cuadro02">
    <td align="center">CURSO</td>
    <td align="center">DOCENTE</td>
    <td align="center">UNIDAD</td>
    <td align="center">CLASE</td>
    <td width="50" align="center">PROM.<br />CURSO</td>
    <td width="50" align="center">ESCALA</td>
    <td width="50" align="center">NOTA<br />
 MEDIA</td>
    <td width="50" align="center">NOTA<br />
 MODA</td>
	<td width="50" align="center">DESVIACIÓN<br />
 ESTANDAR</td>
   
  </tr>
 <?php  for($c=0;$c<count($arr);$c++){
		 $cad = explode("_",$arr[$c]);
		 $rs_docente = $ob_reporte->DictaRamo($conn,$cad[1]);
		 $fila_docente = pg_fetch_array($rs_docente,0);
		
		 $rs_unidad = $ob_reporte->traeUnidadUno($conn,$cad[2]);
		 $fila_unidad = pg_fetch_array($rs_unidad,0);
		 $prom_curso=0;
		 
		if($cad[3]==0){
			$clase = "TODAS";
		}else{
			$rs_clase = $ob_reporte->traeClaseUno($conn,$cad[3]);
			$fila_clase = pg_fetch_array($rs_clase,0);
			$clase = $fila_clase['nombre'];
			$tipo_clase = $fila_clase['tipo'];
		}
		
		
			if(($c % 2)==0){
				$css="detalleoff";
			}else{
				$css="detalleon";
			}
	
	/**************************AQUI EMPIEZA EL SHOW: SACAR LOS PROMEDIOS DEL CURSO********************************************/
	//($conn,$unidad,$periodo,$ramo,$clase="")
	$rs_pnotas = $ob_reporte->posicionNotas($conn,$cad[2],$periodo,$cad[1],$cad[3]);
	
	$pno="";

for($n=0;$n<pg_numrows($rs_pnotas);$n++){
$fil_pnotas = pg_fetch_array($rs_pnotas,$n);
$pno.="cast(nota".$fil_pnotas['posicion_nota']." as numeric) as nota$n,";

}
   $pno = substr($pno,0,-1);
   
   //me traigo a tooooodo el curso para buscar las notas
   $rs_alu = $ob_reporte->tieneElRamo($conn,$cad[0],$cad[1],$nro_ano,$tipo_clase);
   
   //recorrer el curso
    for($a=0;$a<pg_numrows($rs_alu);$a++){
	$pralu=0;
	$sumnalu=0;
	$contnalu=0;
	
	$fila_alu = pg_fetch_array($rs_alu,$a);
	$alumno = $fila_alu['rut_alumno'];
	
	//me traigo las notas
	$rs_notas_Alu = $ob_reporte->traeNotas($conn,$nro_ano,$pno,$alumno,$cad[1],$periodo);
	$fila_notas = pg_fetch_array($rs_notas_Alu,0);
	
	
	for($n=0;$n<pg_numrows($rs_pnotas);$n++){		
		 if(intval($fila_notas["nota$n"])>0){
			 $sumnalu	= $sumnalu+intval($fila_notas["nota$n"]);
			 $contnalu	= $contnalu+1;	
		 }
		
	}
	//echo "-->".$sumnalu."---".$contnalu;
	$pralu = $sumnalu/$contnalu; 
	$prx = ($aprox==1)?round($pralu):intval($pralu);
	
	if($prx!=0){
			$arr_promedio[$cad[1]][]="$prx";
			$arr_promedio2[$cad[1]][]=$prx;
			}
	
	/*$arr_promedio[$cad[1]][]="$prx";
	$arr_promedio2[$cad[1]][]=$prx;*/
	}
//	echo "---".count($arr_promedio[$cad[1]]);
	
	//calculo promedio del curso
	//array_sum($arr_promedio[$cad[1]]);
	$prom_curso = array_sum($arr_promedio[$cad[1]])/count($arr_promedio[$cad[1]]);
	$prom_curso = ($aprox==1)?round($prom_curso,0):intval($prom_curso);
  	
	//escala de notas
	$rs_escala = $ob_reporte->rangoEscala($conn,$ano,$prom_curso);
	$escala = strtoupper(pg_result($rs_escala,2));
	
	//moda
	$cuenta = array_count_values($arr_promedio[$cad[1]]);
	arsort($cuenta);
	$moda = key($cuenta);

	//varianza
	foreach($arr_promedio[$cad[1]] as $prom_var){
		$dif = $prom_var - $prom_curso;
		$sum_var = $sum_var + pow($dif,2);
		
	}
	$varianza = $sum_var / (count($arr_promedio[$cad[1]]) -1 );

	
	// desviacion estandar
	$desv_star = substr(sqrt($varianza),0,4);
	
//mediana
sort($arr_promedio[$cad[1]]);
$arr_mediana = $arr_promedio[$cad[1]];
$posMediana = (count($arr_mediana) + 1) / 2;
$mediana= $arr_mediana[$posMediana - 1];
	
	 /**************************AQUI TERMINA EL SHOW********************************************/
	 
	// show($arr_promedio[$cad[1]]);
	 ?>
  
  <tr class="<?php echo $css ?>">
    <td><?=CursoPalabra($cad[0], 1, $conn);?></td>
    <td><? echo $fila_docente['ape_pat']." ".$fila_docente['ape_mat']."<br>".$fila_docente['nombre_emp'];?></td>
    <td><span class="textosimple"><?php echo $fila_unidad['nombre'] ?></span></td>
    <td><?php echo $clase; ?></td>
    <td align="center"><?php echo $prom_curso ?></td>
    <td align="center"><?php echo $escala ?></td>
    <td align="center"><?php echo $mediana ?></td>
    <td align="center"><?php echo $moda ?></td>
	<td align="center"><?php echo $desv_star ?></td>
    </tr>
    <?php  } ?>
</table>

</td></tr></table>


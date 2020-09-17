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

$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);

$fila_clase = pg_fetch_array($rs_clase,$c);
$fila_ano = $ob_reporte->Ano($conn,$ano);

$nro_ano = $fila_ano['nro_ano'];

$rs_clase=$ob_reporte->traeClaseUno($conn,$clase);
$tipo_clase = pg_result($rs_clase,6);

$rs_alu = $ob_reporte->tieneElRamo($conn,$curso,$ramo,$nro_ano,$tipo_clase);

$rs_per = $ob_reporte->Periodo($conn,$ano,$periodo);
$fil_per = pg_fetch_array($rs_per,0);

$rs_ramo=$ob_reporte->traeRamo($conn,$curso,$ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);

$rs_pnotas = $ob_reporte->posicionNotas($conn,$unidad,$periodo,$ramo,$clase);

$pno="";
$col="";
for($n=0;$n<pg_numrows($rs_pnotas);$n++){
$fil_pnotas = pg_fetch_array($rs_pnotas,$n);
$pno.="cast(nota".$fil_pnotas['posicion_nota']." as numeric) as nota$n,";
$col.="nota ".$fil_pnotas['posicion_nota'].", ";
}
  $pno = substr($pno,0,-1);
  $col = substr($col,0,-2);
//cast(nota1 as numeric)

$rs_unidad=$ob_reporte->traeUnidadUno($conn,$unidad);

$rs_clase=$ob_reporte->traeClaseUno($conn,$clase);

$arr_curso=array();

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
    <td width="159" align="center" class="textonegrita" colspan="2" >INFORMACI&Oacute;N NOTAS POR ASIGNATURA</td>
  </tr>
  <tr class="">
    <td align="center" class="textonegrita" colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="159" class="textonegrita">A&Ntilde;O</td>
    <td colspan="3" class="textosimple"><? echo $fila_ano['nro_ano'];?></td>
    </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td colspan="3" class="textosimple"><span class="<?=$clase;?>">
      <?=CursoPalabra($curso, 1, $conn);?>
    </span></td>
  </tr>
  <tr>
    <td class="textonegrita">RAMO</td>
    <td colspan="3" class="textosimple"><? echo $fila_ramo['nombre']." ".$fila_ramo['cod_subsector'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">PERIODO</td>
    <td colspan="3" class="textosimple"><?php echo $fil_per['nombre_periodo'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita">UNIDAD</td>
    <td colspan="3" class="textosimple"><?php echo strtoupper(pg_result($rs_unidad,13))?></td>
  </tr>
  <?php if($clase!=0){ ?>
  <tr>
    <td class="textonegrita">CLASE</td>
    <td colspan="3" class="textosimple"><?php echo strtoupper(pg_result($rs_clase,5))?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="textonegrita">COLUMNA NOTAS</td>
    <td colspan="3" class="textosimple"><?php echo $col ?></td>
  </tr>
    
</table>
<br />
<br />

<table width="100%" border="0" class="tablaredonda"> 
<tr class="cuadro01">
    <td width="69%" align="center">ALMUNO</td>
    <td width="10%" align="center">PROM.</td>
    <td width="21%" align="center">ESCALA</td>
  </tr>
<?php for($a=0;$a<pg_numrows($rs_alu);$a++){
	$pralu=0;
	$sumnalu=0;
	$contnalu=0;
	
	$fila_alu = pg_fetch_array($rs_alu,$a);
	$alumno = $fila_alu['rut_alumno'];
	
	if(($a % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
			
			$rs_notas_Alu = $ob_reporte->traeNotas($conn,$nro_ano,$pno,$alumno,$ramo,$periodo);
			$fila_notas = pg_fetch_array($rs_notas_Alu,0);
						
			for($n=0;$n<pg_numrows($rs_pnotas);$n++){		
			 if(intval($fila_notas["nota$n"])>0){
			 
			 $sumnalu=$sumnalu+intval($fila_notas["nota$n"]);
			 $contnalu=$contnalu+1;	
			 }
			 
			}
			$pralu = $sumnalu/$contnalu; 
			$prx = ($aprox==1)?round($pralu):intval($pralu);
			
			$rs_escala = $ob_reporte->rangoEscala($conn,$ano,$prx);
			$escala = strtoupper(pg_result($rs_escala,2));
			if($prx!="0"){
			$arr_curso[]="$prx";
			}
	
	?>
 
  <tr class="<?php echo $clase ?>">
    <td><?php echo strtoupper($fila_alu['ape_pat']." ".$fila_alu['ape_mat'].", ".$fila_alu['nombre_alu']) ?></td>
    <td align="center"><?php echo $prx; ?></td>
    <td align="center"><?php echo $escala ?></td>
  </tr>
<?php }?>
</table>
<br />
<br />
<br />
<?php 
//var_dump($arr_curso);
//moda

$cuenta = array_count_values($arr_curso);
//print_r($cuenta);
arsort($cuenta);
$moda = key($cuenta);

//media
$prom_curso = array_sum($arr_curso)/count($arr_curso);
//echo "..".count($arr_curso);
sort($arr_curso);
//mediana
$posMediana = (count($arr_curso) + 1) / 2;
$mediana= $arr_curso[$posMediana - 1];


?>
<table width="100%" border="0" class="tablaredonda">
  <tr class="cuadro01">
    <td colspan="2">CUADRO ESTAD&Iacute;STICO DEL CURSO</td>
    </tr>
  <tr>
    <td width="29%" class="textonegrita">PROMEDIO DEL CURSO</td>
    <td width="71%" class="textosimple"><?php echo ($aprox==1)?round($prom_curso):intval($prom_curso) ?></td>
  </tr>
  <tr>
    <td class="textonegrita">NOTA MEDIA</td>
    <td class="textosimple"><?php echo $mediana ?></td>
  </tr>
  <tr>
    <td class="textonegrita">NOTA MODA</td>
    <td class="textosimple"><?php echo $moda ?></td>
  </tr>
</table></td></tr></table>
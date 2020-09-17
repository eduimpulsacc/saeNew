<?php 
session_start();
require("../../../util/header.php");


require("../clases.php");
//show ($_POST);


$institucion	=$_INSTIT;
	$ano			=$cmbANO;
	$curso			=$cmbCURSO;
	$ramo			=$cmbRAMO;
	$unidad			=$cmbUNIDAD;
	$conunidad		=$radio;
	$conclase		=$radio2;

$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);

$fila_ano = $ob_reporte->Ano($conn,$ano);
$rs_unidad = $ob_reporte->UnidadAnionEW($conn,$ano,$curso,$ramo);
$fila_unidad = pg_fetch_array($rs_unidad,0);
$rs_ramo = $ob_reporte->traeRamo($conn,$curso,$ramo);
$fila_docente = $ob_reporte->Docente($conn,$fila_unidad['rut_emp']);

$rs_mes = $ob_reporte->horasMes($conn,$ano,$curso,$ramo,$mes);




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
<table width="950"  align="center">
<tr><td>
<div class="cabecera"><?php 
$r=1;
include("../cabecera/cabecera.php"); ?></div>
<p><br>
<table width="100%">
  <tr>
    <td colspan="6" class="textonegrita">DATOS GENERALES</td>
    </tr>
  <tr>
    <td colspan="6" class="textonegrita">&nbsp;</td>
  </tr>
  <tr class="cuadro01 textonegrita">
    <td>ASIGNATURA</td>
   
    <td>CURSO</td>
   
    <td>DOCENTE</td>
      </tr>
  <tr>
    <td><span class="textosimple"><?php echo pg_result($rs_ramo,1); ?></span></td>
    <td><span class="textosimple">
      <?=CursoPalabra($curso, 1, $conn);?>
    </span></td>
    <td><span class="textosimple"><? echo $fila_docente['ape_pat']." ".$fila_docente['ape_mat']." ".$fila_docente['nombre_emp'];?></span></td>
    </tr>
  <tr class="cuadro01 textonegrita">
    <td>CANTIDAD DE HORAS EFECTIVAS MENSUALES</td>
    <td>CANTIDAD HORAS SEMANALES</td>
    <td>FECHA INICIO/<br>
      FECHA T&Eacute;RMINO</td>
    </tr>
  <tr class="textosimple">
    <td><?php echo pg_result($rs_mes,0) ?></td>
    <td><?php echo pg_result($rs_mes,1) ?></td>
    <td><?php echo pg_result($rs_mes,2) ?> / <?php echo pg_result($rs_mes,3) ?></td>
    </tr>
</table></p>
<p>
<table width="1200" border="1" cellspacing="0" cellpadding="0">
  <tr class="cuadro01 textonegrita">
    <td align="center">SEMANA</td>
    <td align="center">CLASE NRO</td>
    <td align="center">ACTIVIDADES</td>
    <td width="350" align="center">OBJETIVOS DE APRENDIZAJE</td>
    <td width="350" align="center">INDICADORES DE EVALUACI&Oacute;N</td>
  </tr>
  <?php $rs_semanas = $ob_reporte->semanasMes($conn,$ano,$curso,$ramo,$mes);
  for($fs=0;$fs<pg_numrows($rs_semanas);$fs++){
	  $fila_sem = pg_fetch_array($rs_semanas,$fs);
	  $rs_objs=$ob_reporte->objClaseSem($conn,$fila_sem['id_clase']);
	  $est=($fs%2==0)?"detalleoff":"detalleon";
	 
  ?>
  <tr class="<?php echo $est ?>">
    <td>&nbsp;<?php echo $fila_sem['ids']; ?></td>
    <td>&nbsp;<?php echo $fila_sem['numclase']; ?></td>
    <td>&nbsp;<?php echo $fila_sem['actividades']; ?></td>
    <td colspan="2" valign="top">
        <table class="<?php echo $est ?>">
        <?php for($os=0;$os<pg_numrows($rs_objs);$os++){
		$fila_os=pg_fetch_array($rs_objs,$os);
		$rs_ind=$ob_reporte->indClaseSem($conn,$fila_sem['id_clase'],$fila_os['id_obj']);
		$esto=($os%2==0)?"detalleoff":"detalleon";
		?>
        <tr class="<?php echo $est ?>">
          <td width="350"><?php echo $fila_os['codigo']."-".$fila_os['texto']; ?>&nbsp;</td>
          <td width="350" valign="top">
          
          <table class="<?php echo $est ?>" border="0" cellpadding="0" cellspacing="0">
          <?php  for($oi=0;$oi<pg_numrows($rs_ind);$oi++){
			  $fila_i= pg_fetch_array($rs_ind,$oi);
			  ?>
           <tr class="<?php echo $est ?>">
              <td><?php echo $fila_i['texto']; ?>&nbsp;</td>
            </tr>
            <?php  } ?>
          </table></td>
          </tr>
        <?php }?>
      </table>
    </td>
    </tr>
  <?php }?>
</table>

</p>

<table width="1200" border="1" cellspacing="0" cellpadding="0">
  <tr class="cuadro01 textonegrita">
    <td width="50%" align="center">CURSOS DIDACTICOS</td>
    <td align="center">EVALUACION</td>
    </tr>
  <tr class="detalleoff">
    <td align="center"><?php echo pg_result($rs_mes,6) ?></td>
    <td align="center"><?php echo pg_result($rs_mes,7) ?></td>
    </tr>
  </table>
</td></tr></table>

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
<tr><td>
<div class="cabecera"><?php 
$r=1;
include("../cabecera/cabecera.php"); ?></div>
<p><br>
<table>
  <tr class="">
    <td colspan="4" align="center" class="textonegrita" >PLANIFICACI&Oacute;N ANUAL</td>
  </tr>
  <tr>
    <td width="118" class="textonegrita">&nbsp;</td>
    <td width="562" colspan="3" class="textosimple">&nbsp;</td>
    </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td colspan="3" class="textosimple"><?=CursoPalabra($curso, 1, $conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">ASIGNATURA</td>
    <td colspan="3" class="textosimple"><?php echo pg_result($rs_ramo,1); ?></td>
    </tr>
  <tr>
    <td class="textonegrita">DOCENTE</td>
    <td colspan="3" class="textosimple"><? echo $fila_docente['ape_pat']." ".$fila_docente['ape_mat']." ".$fila_docente['nombre_emp'];?></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="center">&nbsp;</td>
  </tr></table></p>
<p>
<?php $rs_unidades = $ob_reporte->lisUnidades($conn,$cmbANO,$cmbCURSO,$cmbRAMO)?>
<table width="690"  border="0" class="tablaredonda">
 
   <?php  for($u=0;$u<pg_numrows($rs_unidades);$u++){
	   $filau=pg_fetch_array($rs_unidades,$u);
	   $rs_meses = $ob_reporte->lisMeses($conn,$ano,$curso,$ramo,$filau['num_unidad']);
	   ?>
	    <tr class="cuadro01 textonegrita"> 
    <td colspan="2"><?php echo convertirNum($filau['num_unidad']) ?> UNIDAD</td>
    </tr>
     <tr class="cuadro01">
    <td  class="textonegrita" >MES</td>
    <td  class="textonegrita" >APRENDIZAJES ESPERADOS</td>
    </tr>
    <? 
       for($m=0;$m<pg_numrows($rs_meses);$m++){
		   $fila_m = pg_fetch_array($rs_meses,$m);
		   ?>
  <tr>
    <td class="cuadro01"><?php echo envia_mes2($fila_m['num_mes']); ?></td>
    <td class="detalleoff">
    <?php // $rs_obj = $ob_reporte->lisObjAN($conn,$ano,$curso,$ramo,$filau['num_unidad'],$fila_m['num_mes']);?>
    <?php $rs_semana = $ob_reporte->lisSemana($conn,$ano,$curso,$ramo,$filau['num_unidad'],$fila_m['num_mes']);
	for($s=0;$s<pg_numrows($rs_semana);$s++){
		$fila_sem=pg_fetch_array($rs_semana,$s);
		$rs_obj = $ob_reporte->lisObjAN($conn,$ano,$curso,$ramo,$filau['num_unidad'],$fila_m['num_mes'],$fila_sem['id_semana']);
	?>
    <table >
  <tr>
    <td class="cuadro01">Semana <?php echo $fila_sem['id_semana'] ?></td>
    <td><table >
    <?php for($o=0;$o<pg_numrows($rs_obj);$o++){
		$fila_obj = pg_fetch_array($rs_obj,$o);
		$cs = ($o%2==0)?"detalleoff":"detalleon";
		?>
      <tr class="<?php echo $cs ?>">
        <td><?php echo $fila_obj['codigo'] ?> - <?php echo $fila_obj['texto'] ?></td>
      </tr>
      <?php }?>
     
    </table></td>
  </tr>
  </table>

<?php }?>
    </td>
    </tr>
 
 
  <?php }?>
 
    <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <?php }?>
</table>
</p>


</td></tr></table>

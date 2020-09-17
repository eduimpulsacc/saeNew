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
	$conclase		=$radio;
	$clase			=$cmbCLASE;

$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);

$fila_clase = pg_fetch_array($rs_clase,$c);
$fila_ano = $ob_reporte->Ano($conn,$ano);
$rs_unidad = $ob_reporte->Unidad($conn,$ano,$curso,$ramo);
$fila_unidad = pg_fetch_array($rs_unidad,0);
$rs_ramo = $ob_reporte->traeRamo($conn,$curso,$ramo);
$fila_docente = $ob_reporte->Docente($conn,$fila_unidad['rut_emp']);

$rs_unidadDD = $ob_reporte->UnidadIID($conn,$_POST['cmbUNIDAD']);
$filaDD= pg_fetch_array($rs_unidadDD,0);


if($clase!=0){
$rs_clase = $ob_reporte->traeClaseUno($conn,$clase);
}
else{
$rs_clase = $ob_reporte->traeClases($conn,$unidad);
}


$rs_tipo=$ob_reporte->ejesUnidad($conn,$unidad);


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
  <?php 
//$rs_clase = $ob_reporte->traeClases($conn,$unidad);	
	for($c=0;$c<pg_numrows($rs_clase);$c++){
		$fila_clase = pg_fetch_array($rs_clase,$c);
		$clase = $fila_clase['id_clase'];
		$fila_docente_c = $ob_reporte->Docente($conn,$fila_clase['rut_emp']);
		$rs_estado=$ob_reporte->traeEstadoClaseUno($conn,$fila_clase['estado']);
		$rs_tipo=$ob_reporte->tipoClaseUno($conn,$fila_clase['tipo']);
		$rs_recurso=$ob_reporte->listaRecursosClase($conn,$clase);
		$rs_tipo=$ob_reporte->ejesUnidad($conn,$unidad);
		$rs_evaluacion=$ob_reporte->listaEvaluacionClase($conn,$clase);
		
		
	?>
</p>

<div class="cabecera"><?php include("../cabecera/cabecera.php"); ?></div><br>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table width="690" border="0" align="center">
  <tr class="">
    <td colspan="4" align="center" class="textonegrita" >PLANIFICACI&Oacute;N CLASES</td>
  </tr>
  <tr>
    <td width="159" class="textonegrita">T&Iacute;TULO</td>
    <td colspan="3" class="textosimple"><?php echo $fila_clase['nombre'] ?></td>
    </tr>
  <tr>
    <td class="textonegrita">UNIDAD</td>
    <td colspan="3" class="textosimple"><?php echo $filaDD['nombre'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita">DOCENTE</td>
    <td colspan="3" class="textosimple"><? echo $fila_docente_c['ape_pat']." ".$fila_docente_c['ape_mat']." ".$fila_docente_c['nombre_emp'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">TIPO</td>
    <td colspan="3" class="textosimple"><?php echo pg_result($rs_tipo,1); ?></td>
  </tr>
  <tr>
    <td class="textonegrita">ESTADO</td>
    <td colspan="3" class="textosimple"><?php echo pg_result($rs_estado,1); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
    
</td>
    </tr>
  
    <td colspan="4">&nbsp;</td>
    </tr><tr>
      <td colspan="4">
      
   <?php 
			$rs_ejcls = $ob_reporte->tipoEjesClaseInd($conn,$fila_clase['id_clase']);
			for($g=0;$g<pg_numrows($rs_ejcls);$g++){
				$fila_g = pg_fetch_array($rs_ejcls,$g);
		?>
        <table width="100%" border="0" class="tablaredonda">
        
        <tr class="cuadro01">
          <td colspan="2"><?php echo strtoupper($fila_g['nombre']) ?></td>
          <?php $rs_blcl = $ob_reporte->tipoEjesBloqueClaseInd($conn,$fila_clase['id_clase'],$fila_g['id_objetivo']);
		  for($h=0;$h<pg_numrows($rs_blcl);$h++){
			 $fila_h = pg_fetch_array($rs_blcl,$h);
		  ?>
          <tr class="cuadro01">
          <td width="50%"><?php echo strtoupper($fila_h['texto']) ?></td>
          <td width="50%">INDICADORES DE EVALUACI&Oacute;N</td>
       <?php 
		$rs_obji = $ob_reporte->traeObjeclaseInd($conn,$fila_h['id_eje'],$fila_g['id_objetivo'],$fila_clase['id_clase']);
		for($f=0;$f<pg_numrows($rs_obji);$f++){
			 if(($f % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
			
		$fila_f = pg_fetch_array($rs_obji,$f);
		?>
     <tr class="<?php echo $clase ?>">
       <td width="50%" valign="top"><?php echo strtoupper($fila_f['codigo']) ?></b> - <?php echo nl2br($fila_f['texto'])?></td>
       <td width="50%" valign="top"><?php //$rs_indi_u = $ob_reporte->buscaIndicador($conn,$fila_f['id_obj']);
	//echo nl2br(pg_result ($rs_indi_u,4));?>
    
    <?php $rs_indi_u = $ob_reporte->buscaIndicadorC($conn,$fila_f['id_obj'],$fila_clase['id_clase']);
	//echo nl2br(pg_result ($rs_indi_u,4));
	for($idxc=0;$idxc<pg_numrows($rs_indi_u);$idxc++){
		   $fidxc=pg_fetch_array($rs_indi_u,$idxc);
	echo "- ".nl2br($fidxc['texto'])."<br>";
	   }
	?></td>
     </tr>
     <?php }?>
          <?php }?>
        </table><br />
        <?php }?>
    </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4">
  

    <table width="100%" border="0">
      <tr >
        <td width="49%" valign="top" >
          <table width="100%" border="0" class="tablaredonda">
            <tr>
              <td class="cuadro01">INICIO</td>
              </tr>
            <tr>
              <td class="detalleon"><?php echo nl2br($fila_clase['inicio']); ?></td>
              </tr>
  </table>
        </td>
        </tr>
      <tr>
        <td >&nbsp;</td>
        </tr>
      <tr>
        <td ><table width="100%" border="0" class="tablaredonda">
          <tr>
            <td class="cuadro01">DESARROLLO</td>
            </tr>
          <tr>
            <td class="detalleon"><?php echo nl2br($fila_clase['desarrollo']) ?></td>
            </tr>
</table></td>
        </tr>
      <tr>
        <td >&nbsp;</td>
        </tr>
      <tr>
        <td valign="top">
          <table width="100%" border="0" class="tablaredonda">
            <tr>
              <td class="cuadro01">CIERRE</td>
              </tr>
            <tr>
              <td class="detalleon"><?php echo nl2br($fila_clase['cierre']) ?></td>
              </tr>
</table></td>
        </tr>
      
      <tr>
        <td >&nbsp;</td>
        </tr>
      <tr>
        <td ><table width="100%" border="0" class="tablaredonda">
          <tr>
            <td class="cuadro01">EVALUACI&Oacute;N</td>
            </tr>
          <tr>
            <td class="detalleon">
              <?php $eva=""; 
		 for($ev=0;$ev<pg_numrows($rs_evaluacion);$ev++){
	 	 $fila_ev= pg_fetch_array($rs_evaluacion,$ev);
		 $eva.= $fila_ev['nombre'].", ";
		 }
	
	     $eva=substr($eva,0,-2); 
		  echo $eva;
	    ?></td>
            </tr>
</table></td>
        </tr>
      <tr>
        <td >&nbsp;</td>
        </tr>
      <tr >
        <td  valign="top"><table width="100%" border="0" class="tablaredonda">
          <tr>
            <td class="cuadro01">ACTITUDES</td>
            </tr>
          <tr>
            <td class="detalleon"><?php echo nl2br($fila_clase['actitudes']) ?></td>
            </tr>
</table></td>
        </tr>
      <tr>
        <td >&nbsp;</td>
        </tr>
      <tr>
        <td ><table width="100%" border="0" class="tablaredonda">
          <tr>
            <td class="cuadro01">RECURSOS</td>
            </tr>
          <tr>
            <td class="detalleon"><?php $rec=""; 
		 for($r=0;$r<pg_numrows($rs_recurso);$r++){
	 	 $fila_rec= pg_fetch_array($rs_recurso,$r);
		 $rec.= $fila_rec['nombre'].", ";
		 }
	
	     $rec=substr($rec,0,-2); 
		  echo $rec;
	    ?></td>
            </tr>
</table></td>
        </tr>
    </table></td>
  </tr>
 
  <tr>
    <td colspan="4">
    
    </td>
    </tr>
  
</table>
<?php if(($c+1)<pg_numrows($rs_clase)){?>
<div class="saltopagina"></div>
<?php }?>
<?php }?>

</td></tr></table>
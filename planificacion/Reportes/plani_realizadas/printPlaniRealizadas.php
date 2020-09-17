<?php 
session_start();
require("../../../util/header.php");


require("../clases.php");


    $institucion		=$_INSTIT;
	$ano				=$cmbANO;
	$curso				=$cmbCURSO;
	$docente			=$cmbDOCENTE;
	$realizada			=$radio;

$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);
$fila_ano = $ob_reporte->Ano($conn,$ano);
$fila_docente = $ob_reporte->Docente($conn,$docente);

$rs_clas= $ob_reporte->traeClasesRealizadas($conn,$ano,$curso,$docente,$realizada)

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
<body>

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
<div class="cabecera"><?php include("../cabecera/cabecera.php"); ?></div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="690" border="0" align="center">
  <tr class="">
    <td colspan="4" align="center" class="textonegrita" >INFORMACI&Oacute;N CLASES <?php echo ($realizada==1)?"REALIZADAS":"PENDIENTES" ?></td>
  </tr>
  <tr>
    <td width="136" class="textonegrita">A&Ntilde;O</td>
    <td width="544" colspan="3" class="textosimple"><? echo $fila_ano['nro_ano'];?></td>
    </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td colspan="3" class="textosimple"><?=CursoPalabra($curso, 1, $conn);?></td>
  </tr>
 
  <tr>
    <td class="textonegrita">DOCENTE</td>
    <td colspan="3" class="textosimple"><? echo $fila_docente['ape_pat']." ".$fila_docente['ape_mat']." ".$fila_docente['nombre_emp'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
    <?php if(pg_numrows($rs_clas)>0){?>
     <table width="100%" border="0" class="tablaredonda">
    <tr class="cuadro01">
      <td align="center">UNIDAD</td>
      <td align="center">CLASE</td>
      <td align="center">ASIGNATURA</td>
      <td align="center">FEC.<br>
INICIO</td>
      <td align="center">FEC.<br>
T&Eacute;RMINO</td>
      <td align="center">TIPO</td>
    </tr>
    <?php for($c=0;$c<pg_numrows($rs_clas);$c++){
		$fil_cl = pg_fetch_array($rs_clas,$c);
		$rs_ramo = $ob_reporte->traeRamo($conn,$curso,$fil_cl['id_ramo']);
		
		$rs_tipo=$ob_reporte->tipoClaseUno($conn,$fil_cl['tipo']);
		
		if(($c % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
		?>
    <tr class="<?php echo $clase ?>">
      <td><?php echo $fil_cl['nom_unidad'] ?></td>
      <td><?php echo $fil_cl['nombre'] ?></td>
      <td><?php echo pg_result($rs_ramo,1); ?></td>
      <td align="center"><?php echo CambioFD($fil_cl['fecha_inicio']) ?></td>
      <td align="center"><?php echo CambioFD($fil_cl['fecha_termino']) ?></td>
      <td><?php echo pg_result($rs_tipo,1); ?></td>
    </tr>
    <?php }?>
     </table>
     <?php }
	 else{
		 echo '<div align="center" class="textonegrita">SIN INFORMACI&Oacute;N</div>';
		 }?>
     
    </td>
    </tr>
    
</table>
</td>
</tr>
</table>
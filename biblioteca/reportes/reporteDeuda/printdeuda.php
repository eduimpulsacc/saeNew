<?php 
session_start();
require("../../../util/header.php");


require("../clases.php");
//var_dump($_POST);

foreach($_POST as $nombre_campo => $valor){ 
	$asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion); 

	
}

$ob_reporte = new Reporte();

//echo $aprox;

$fila_membrete = $ob_reporte->Membrete($conn,$_INSTIT);
$rs_alu = $ob_reporte->AlumnoUno($conn,$cmb_usuario);
$rs_emp = $ob_reporte->empleadoUno($conn,$_NOMBREUSUARIO);
/*$rs_listado = $ob_reporte->prestamoTitulo($conn,$idLBR,$_ANO,$radiopres);
$il = $ob_reporte->iLibro($conn,$idLBR);


$pen=0;
$rea=0;
$anu=0;*/
$rs_mul = $ob_reporte->buscoMulta($conn,$_ANO,$cmb_usuario);


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
<div class="cabecera"><?php include("../cabecera/cabecera.php"); ?></div>
<br />
<br /><br />

<table width="100%" border="0">
  <tr>
    <td colspan="3" class="textonegrita" align="center">Cerfificado Morosidad</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="3" align="center" class="textosimple">Yo, <span class="textonegrita"><?php echo pg_result($rs_emp,1) ?></span>, certifico que <span class="textonegrita"><?php echo pg_result($rs_alu,1); ?>, </span>alumno de <span class="textonegrita"><?php echo CursoPalabra($cmbCurso,1,$conn); ?>, </span>mantiene el siguiente estado en biblioteca:</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="textosimple">&nbsp;</td>
  </tr> 
   <?php if(pg_numrows($rs_mul)==0){?>
   <tr>
    <td colspan="3" align="center" class="textosimple"><strong>No posee deuda en Biblioteca</strong></td>
  </tr>
  
  <tr>
    <td colspan="3" align="center" class="textosimple">&nbsp;</td>
  </tr>
  
  <?php }else{?>
 <tr>
    <td colspan="3" align="center" class="textosimple"><strong>PR&Eacute;STAMOS EN MORA</strong></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0">
  <tr class="tableindex">
    <td width="4%" align="center">#</td>
    <td width="36%" align="center">T&iacute;tulo</td>
    <td width="20%" align="center">D&iacute;as atraso</td>
    <td width="20%" align="center">Valor Multa($)</td>
  </tr>
  <?php 
  $sum_multa =0;
  for($m=0;$m<pg_numrows($rs_mul);$m++){
	  $fila = pg_fetch_array($rs_mul,$m);
	  $sum_multa=$sum_multa+$fila['monto'];
	  ?>
  <tr class="textosimple">
    <td align="center"><?php echo $m+1 ?></td>
    <td align="center"><?php echo $fila['titulo'] ?> </td>
    <td align="center"><?php echo $fila['dias_atraso'] ?></td>
    <td align="center"><?php echo number_format($fila['monto'],0,',','.') ?></td>
  </tr>
  
  <?php }?>
  <tr class="textosimple">
    <td colspan="3" align="right">Deuda Total: </td>
    <td align="center">$<?php echo number_format($sum_multa,0,',','.') ?></td>
  </tr>
</table>
</td>
  </tr>
  
  <?php }?>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="textonegrita">LIBROS PRESTADOS</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <?php $rs_listaPrestamo = $ob_reporte->listaPrestamoUsuario($conn,$cmb_usuario,$_ANO);?>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <?php if(pg_numrows($rs_listaPrestamo)==0){?>
  <tr>
    <td colspan="3" align="center" class="textosimple"><strong>No posee libros en pr&eacute;stamo</strong></td>
  </tr>
 <?php  }else{?>
  <tr>
    <td colspan="3"><table width="100%" border="0">
  <tr class="tableindex">
    <td width="4%" align="center">#</td>
    <td width="36%" align="center">T&iacute;tulo</td>
    <td width="20%" align="center">Fecha devoluci&oacute;n</td>
    </tr>
  <?php 
  
  for($p=0;$p<pg_numrows($rs_listaPrestamo);$p++){
	  $filap = pg_fetch_array($rs_listaPrestamo,$p);
	  
	  ?>
  <tr class="textosimple">
    <td align="center"><?php echo $p+1 ?></td>
    <td align="center"><?php echo $filap['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($filap['fecha_devolucion']) ?></td>
    </tr>
  
  <?php }
  
 }?>
</table></td>
  </tr>
  </table>

<br />
<br />
<br /><br />
<br />
<br />

<div align="center" class="textosimple">______________________________
<br />FIRMA</div>
<br /><br />
<div  style="width:690px" align="center" class="textosimple">
<?php echo fecha_espanol(date("d-m-Y")); ?>
</div>
<br /></td></tr></table>


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

/*$rs_listado = $ob_reporte->prestamoTitulo($conn,$idLBR,$_ANO,$radiopres);
$il = $ob_reporte->iLibro($conn,$idLBR);


$pen=0;
$rea=0;
$anu=0;*/
//$rs_mul = $ob_reporte->buscoMoraTodos($conn,$_ANO);
$rs_mul = $ob_reporte->patrasados($conn,$_ANO);

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
<div class="cabecera">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<br />
<br /><br />

<table width="100%" border="0">
  <tr>
    <td class="textonegrita" align="center">Informe de Pr&eacute;stamos atrasados</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php if(pg_numrows($rs_mul)==0){?>
  <tr>
    <td align="center" class="textosimple">Sin informacion disponible</td>
  </tr>
  <?php }else{?>
  <tr>
    <td><table width="100%" border="0">
  <tr class="tableindex">
    <td width="4%" align="center">#</td>
    <td width="36%" align="center">T&iacute;tulo</td>
    <td width="36%" align="center">Usuario</td>
    <td width="36%" align="center">CURSO</td>
    <td width="20%" align="center">Fecha Devoluci&oacute;n</td>
    <td width="20%" align="center">p. Multado</td>
    <td width="20%" align="center">Fecha Multa</td>
    <td width="20%" align="center">D&iacute;as atraso</td>
    <td width="20%" align="center">Valor Multa($)</td>
  </tr>
  <?php for($m=0;$m<pg_numrows($rs_mul);$m++){
	  $fila = pg_fetch_array($rs_mul,$m);
	  $fondo=($m%2==0)?"#cccccc":"#ffffff";
	  $dmul = $ob_reporte->pmulta($conn,$fila['id_prestamo']);
	  ?>
  <tr class="textosimple" bgcolor="<?php echo $fondo ?>">
    <td align="center"><?php echo $m+1 ?></td>
    <td align="center"><?php echo $fila['titulo'] ?></td>
    <td align="center"><?php switch($fila['tipo_usuario']){
	   case 1:
	   	$tpu="EMPLEADO";
		$rus = $ob_reporte->empleadoUno($conn,$fila['rut_usuario']);
		echo $us = strtoupper(pg_result($rus,1));
		
		$cc="-";
		
	   break;
	   case 2:
	  	$tpu="APODERADO";
		$rus = $ob_reporte->apoderadoUno($conn,$fila['rut_usuario']);
		echo $us = strtoupper(pg_result($rus,1));
		$rcu = $ob_reporte->cpapo($conn,$_ANO,$fila['rut_usuario']);
		 $cc=CursoPalabra(pg_result($rcu,0),1,$conn);
		
		
	   break;
	   case 3:
	   	$tpu="ALUMNO";
		$rus = $ob_reporte->AlumnoUno($conn,$fila['rut_usuario']);
		echo $us = strtoupper(pg_result($rus,1));
		$rcu=  $ob_reporte->cpal($conn,$_ANO,$fila['rut_usuario']);
		 $cc=CursoPalabra(pg_result($rcu,0),6,$conn);
		
		
	   break;
	   } ?></td>
    <td align="center"><?php echo  $cc ?></td>
    <td align="center"><?php echo CambioFD($fila['fecha_devolucion']) ?></td>
    <td align="center"><?php echo (pg_numrows($dmul)>0)?"SI":"NO"; ?></td>
    <td align="center"><?php echo (pg_numrows($dmul)>0)?CambioFD(pg_result($dmul,8)):"-"; ?></td>
    <td align="center"><?php echo (pg_numrows($dmul)>0)?pg_result($dmul,4):"-"; ?></td>
    <td align="center"><?php echo number_format(pg_result($dmul,5)-pg_result($dmul,6),0,',','.') ?></td>
  </tr>
  <?php }?>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  </table>

<br />
<br /></td></tr></table>


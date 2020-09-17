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

$rs_listado = $ob_reporte->prestamoLibroTodo($conn,$_ANO,$radiopres);

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
<br />

<table width="100%" border="0">
  <tr>
    <td colspan="3" class="textonegrita" align="center">REPORTE PR&Eacute;STAMOS </td>
  </tr>
  <tr>
    <td colspan="3" class="textonegrita" align="center">&nbsp;</td>
  </tr>
    <?php if($cmb_usuario>0){?>
  <tr>
    <td colspan="3" class="textonegrita">
  USUARIO: <?php echo $us;  ?></td>
  </tr>
  <?php }?> 
    <?php if(isset($cmb_curso)){?>
  <tr>
    <td colspan="3" class="textonegrita"> CURSO: <?php echo CursoPalabra($cmb_curso,1,$conn) ?></td>
  </tr>
  
  <?php }?>
  <tr>
    <td colspan="3" class="textonegrita">&nbsp;</td>
  </tr>
 
  <tr>
    <td colspan="3" class="textonegrita" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">  <table width="100%" border="0" align="right" class="tablaredonda">
   
  <tr class="cuadro01">
    <td>#</td>
    <td align="center">TIPO</td>
    <td align="center">CURSO</td>
    <?php if($cmb_usuario==0){?>
    <td align="center">USUARIO</td>
   <?php  }?>
    <td align="center">T&Iacute;TULO</td>
    <td align="center">FECHA PRESTAMO</td>
    <td align="center">FECHA DEVOLUCION <br /></td>
    <td align="center">ESTADO</td>
  </tr>
  <?php if(pg_numrows($rs_listado)>0){
	  for($o=0;$o<pg_numrows($rs_listado);$o++){  
	   $fila_res = pg_fetch_array($rs_listado,$o);
	   
	   switch($fila_res['estado_prestamo']){
	   case 1:
	   	$estado="ACTIVO";
		$pen=$pen+1;
		$fdev = CambioFD($fila_res['fecha_devolucion']);
		$color= "#000000";
	   break;
	   case 2:
	  	$estado="DEVUELTO";
		$rea=$rea+1;
		$fdev = CambioFD($fila_res['fecha_devolucion']);
	   break;
	   case 3:
	   	$estado="ATRASADO";
		$anu=$anu+1;
		$fdev = CambioFD($fila_res['fecha_devolucion']);
		$color= "#FF0000";
	   break;
	   }
	   
	  if(($o % 2)==0){
				$css="detalleoff";
			}else{
				$css="detalleon";
			}
	  ?>
  <tr class="<?php echo $css ?>" >
    <td align="center"><?php echo $o+1; ?></td>
  <td>
 <?php  switch($fila_res['tipo_usuario']){
	   case 1:
	   	$tpu="EMPLEADO";
		$cc="-";
		
		
		
		
	   break;
	   case 2:
	  	$tpu="APODERADO";
		$rcu = $ob_reporte->cpapo($conn,$_ANO,$fila_res['rut_usuario']);
		$cc=CursoPalabra(pg_result($rcu,1),6,$conn);
		
		
		
	   break;
	   case 3:
	   	$tpu="ALUMNO";
		$rcu=  $ob_reporte->cpal($conn,$_ANO,$fila_res['rut_usuario']);
		$cc=CursoPalabra(pg_result($rcu,0),6,$conn);
		
		
		
	   break;
	   }?>
  
  <?php echo $tpu ?></td>
  <td align="center"><?php echo $cc ?></td>
    <?php if($cmb_usuario==0){?>
    <td align="left">&nbsp;<?php echo strtoupper($fila_res['nombre']) ?></td>
    <?php }?>
    <td align="left">&nbsp;<?php echo $fila_res['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fila_res['fecha_prestamo']) ?></td>
    <td align="center"><?php echo $fdev;?></td>
    <td align="center"><font color="<?=$color;?>"><?php echo $estado ?></font></td>
  </tr>
  <?php } //fin for?>
  
  <?php }else{?>
  <tr class="detalleoff">
    <td colspan="8" align="center">SIN INFORMACI&Oacute;N DE PR&Eacute;STAMOS</td>
    </tr>
    <?php }?>
    </table>
     

    </td>
  </tr>
  </table><br />
<br />
<br />

<?php if(pg_numrows($rs_listado)>0){?>
 
<table width="18%" border="0" cellspacing="0" class="tablaredonda">
  <tr class="cuadro01">
    <td colspan="3" align="center">CUADRO ESTAD&Iacute;STICO RESERVAS</td>
    </tr>
  <tr class="detalleoff">
    <td width="40%" >ACTIVO</td>
    <td width="4%">:</td>
    <td width="56%" align="center"><?php echo $pen ?></td>
  </tr>
  <tr class="detalleoff">
    <td>ATRASADO</td>
    <td>:</td>
    <td align="center"><?php echo $anu ?></td>
  </tr>
</table>

<?php  } ?>
</td></tr></table>


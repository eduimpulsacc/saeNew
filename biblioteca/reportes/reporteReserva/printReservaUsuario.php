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

//voy a buscar a los usuarios

//usuario empleado
if($cmb_tipou==1){
	$tp = "PERSONAL ESTABLECIMIENTO";
	// si viene empleado seleccionado
	if($cmb_usuario==0){
		$rs_listado = $ob_reporte->listaReservaEmpleadoTodos($conn,$_INSTIT,$_ANO);
		
	}
	//si no viene empleado seleccionado
	else{
		$rs_listado = $ob_reporte->listaReserva($conn,$cmb_usuario,$_INSTIT,$_ANO);
		$rus = $ob_reporte->empleadoUno($conn,$cmb_usuario);
		$us = strtoupper(pg_result($rus,1));
		
	}
}

//usuario apoderado
if($cmb_tipou==2){
	$tp = "APODERADO ESTABLECIMIENTO";
	// si viene apoderado seleccionado
	if($cmb_usuario==0){
		$rs_listado = $ob_reporte->listaReservaApoderadoTodos($conn,$_INSTIT,$_ANO,$cmb_curso);
	}
	
	//si no viene apoderado seleccionado
	else{
		$rs_listado = $ob_reporte->listaReserva($conn,$cmb_usuario,$_INSTIT,$_ANO,$cmb_curso);
		$rus = $ob_reporte->apoderadoUno($conn,$cmb_usuario);
		$us = strtoupper(pg_result($rus,1));
	}
	
}
//exit;

//usuario alumno
if($cmb_tipou==3){
	$tp = "ALUMNO ESTABLECIMIENTO";

	// si viene alumno seleccionado
	if($cmb_usuario==0){
		$rs_listado = $ob_reporte->listaReservaALumnoTodos($conn,$_INSTIT,$_ANO,$cmb_curso);
	}
	
	//si no viene alumno seleccionado
	else{
		$rs_listado = $ob_reporte->listaReserva($conn,$cmb_usuario,$_INSTIT,$_ANO);
		$rus = $ob_reporte->AlumnoUno($conn,$cmb_usuario);
		$us = strtoupper(pg_result($rus,1));
	}
	
}

$pen=0;
$rea=0;
$anu=0;

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
    <td colspan="3" class="textonegrita" align="center">REPORTE RESERVAS <?php echo $tp ?></td>
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
   
    <?php if($cmb_usuario==0){?>
    <td align="center">USUARIO</td>
   <?php  }?>
    <td align="center">T&Iacute;TULO</td>
    <td align="center">FECHA RESERVA</td>
    <td align="center">ESTADO</td>
  </tr>
  <?php if(pg_numrows($rs_listado)>0){
	  for($o=0;$o<pg_numrows($rs_listado);$o++){  
	   $fila_res = pg_fetch_array($rs_listado,$o);
	   
	   switch($fila_res['estado']){
	   case 1:
	   	$estado="PENDIENTE";
		$pen=$pen+1;
	   break;
	   case 2:
	  	$estado="REALIZADA";
		$rea=$rea+1;
	   break;
	   case 3:
	   	$estado="ANULADA";
		$anu=$anu+1;
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
  
    <?php if($cmb_usuario==0){?>
    <td align="center"><?php echo strtoupper($fila_res['nombre']) ?></td>
    <?php }?>
    <td align="center"><?php echo $fila_res['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fila_res['fecha_reserva']) ?></td>
    <td align="center"><?php echo $estado ?></td>
  </tr>
  <?php } //fin for?>
  
  <?php }else{?>
  <tr class="detalleoff">
    <td colspan="6" align="center">SIN INFORMACI&Oacute;N DE RESERVAS</td>
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
    <td width="40%" >PRENDIENTES</td>
    <td width="4%">:</td>
    <td width="56%" align="center"><?php echo $pen ?></td>
  </tr>
  <tr class="detalleon">
    <td >REALIZADAS</td>
    <td>:</td>
    <td align="center"><?php echo $rea ?></td>
  </tr>
  <tr class="detalleoff">
    <td>ANULADAS</td>
    <td>:</td>
    <td align="center"><?php echo $anu ?></td>
  </tr>
</table>

<?php  } ?>
</td></tr></table>


<?
header( 'Content-type: text/html; charset=latin1' );
session_start();

require "../cierre/mod_cierre.php";

$ob_cierre = new Cierre($_IPDB,$_ID_BASE);

$funcion		= $_POST['funcion'];
$id_nacional	= $_NACIONAL;
$usuario		= $_POST['usuario'];


if($funcion==1){

	$ano =date("Y")-1;
	$fecha = date("m-d-Y");
	$periodo = 2;
	
	$result = $ob_cierre->insertarcierre($fecha,$ano,$periodo,$usuario,$id_nacional);
	if($result){?>
	   <table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textosimple">PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/preloader2.gif' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de General</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Conceptos</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Dimension</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td> Cierre de Funsion</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?
	}else{ 
	   echo 0; 
	}



 } // fin funcion 0

if($funcion==2){
	
	$result = $ob_cierre->insertcierregral($id_nacional);
	if($result){?>
	   <table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td><img src='img/PNG-48/preloader2.gif' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Conceptos</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Dimension</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
     <td>Cierre de Funsion</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?
	}else{ 
	   echo 0; 
	}
}
if($funcion==3){
	
	$result = $ob_cierre->insertcierreconcepto($id_nacional,$_ANO,$_PERIODO);
	if($result){?>
	   <table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td>PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
     <td>Cierre de Conceptos</td>
      <td><img src='img/PNG-48/preloader2.gif' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Dimensiones</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Funciones</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    
  </table>
  <?
	}else{ 
	   echo 0; 
	}
}

if($funcion==4){
	
	$result = $ob_cierre->insertcierredimension($id_nacional);
	if($result){?>
	   <table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td>PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Conceptos</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Dimensiones</td>
      <td><img src='img/PNG-48/preloader2.gif' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
     <td>Cierre de Funciones</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?
	}else{ 
	   echo 0; 
	}
}

if($funcion==5){
	$result = $ob_cierre->insertcierrefunsion($id_nacional);
	if($result){?>
	   <table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td>PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Conceptos</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Dimensiones</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
     <td>Cierre de Funciones </td>
      <td><img src='img/PNG-48/preloader2.gif' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
  </table>
  <?
	}else{ 
	   echo 0; 
	}		
}
if($funcion==6){ ?>
	
	<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td>PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Dimensiones</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Funciones</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
     <td>Cierre de Conceptos</td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
  </table>
  <?
			
}

if($funcion==10){
	
	$result = $ob_cierre->eliminacierre($id_nacional);
	if($result){?>
	   <table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td>PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td><img src='img/PNG-48/Delete.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td><img src='img/PNG-48/Delete.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Conceptos</td>
      <td><img src='img/PNG-48/Delete.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
      <td>Cierre de Dimensiones</td>
      <td><img src='img/PNG-48/Delete.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <tr>
     <td>Cierre de Funciones</td>
      <td><img src='img/PNG-48/Delete.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
  </table>
  <?
	}else{ 
	   echo 0; 
	}
}



?>



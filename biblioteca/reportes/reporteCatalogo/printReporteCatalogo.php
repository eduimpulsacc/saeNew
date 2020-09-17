<?php 
session_start();
require("../../../util/header.php");


require("../clases.php");
//var_dump($_POST);

foreach($_POST as $nombre_campo => $valor){ 
	$asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion); 

//echo "<br>".$asignacion;

	
}

$ob_reporte = new Reporte();

//echo $aprox;

$fila_membrete = $ob_reporte->Membrete($conn,$_INSTIT);

$rs_listado = $ob_reporte->catalogocomp($conn,$cmb_tipo,$cmb_fil,$_INSTIT);



$pen=0;
$rea=0;
$anu=0;

if($cmb_tipo==1){
$nt="CATEGOR&Iacute;A";
$fil_da = $ob_reporte->catego1($conn,$cmb_fil);
}
if($cmb_tipo==2){
$nt="EDITORIAL";
$fil_da = $ob_reporte->editorial1($conn,$cmb_fil);
}
if($cmb_tipo==3){
$nt="AUTOR";
$fil_da = $ob_reporte->autor1($conn,$cmb_fil);
}


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
    <td colspan="3" class="textonegrita" align="center">CAT&Aacute;LOGO DE LIBROS</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <?php if($cmb_tipo>0){?>
  <tr>
    <td colspan="3" class="textonegrita"><?php echo $nt ?>: <?php echo strtoupper(pg_result($fil_da,1)); ?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
     <?php if(pg_numrows($rs_listado)>0){ ?>
    <table width="100%" border="0" align="center" class="tablaredonda">
      <tr  class="cuadro01">
        <td align="center">#</td>
        <td align="center">T&Iacute;TULO</td>
        <td align="center">ISBN</td>
         <?php if($cmb_tipo!=3){?>
        <td align="center">AUTOR</td>
        <?php }?>
       <?php  if($cmb_tipo!=1){?>
        <td align="center">CATEGOR&Iacute;A</td>
       <?php  }?>
        <td align="center">A&Ntilde;O PUBLICACI&Oacute;N</td>
        <td align="center">EDICI&Oacute;N</td>
        <?php if($cmb_tipo!=2){?>
        <td align="center">EDITORIAL</td>
        <?php }?>
        <td align="center">CANT. EJEMPLARES</td>
        <td align="center">EN<br />
          PR&Eacute;STAMO</td>
      </tr>
     <?php  for($o=0;$o<pg_numrows($rs_listado);$o++){  
	   $fila_res = pg_fetch_array($rs_listado,$o);
	   
	   $conejem = $ob_reporte->ejemplares($conn,$fila_res['id_libro']);
       
       if(($o % 2)==0){
				$css="detalleoff";
			}else{
				$css="detalleon";
			}
			
		$prestados = $ob_reporte->cantEjemplaresPrestados($conn,$fila_res['id_libro']);
		
		$autor = $ob_reporte->cantAutores($conn,$fila_res['id_libro']);
		$categorias = $ob_reporte->cantCategorias($conn,$fila_res['id_libro']);	
			?>
      <tr class="<?php echo $css ?>">
        <td align="center"><?php echo $o+1; ?></td>
        <td align="center"><?php echo $fila_res['titulo'] ?></td>
        <td align="center"><?php echo $fila_res['isbn'] ?></td>
         <?php if($cmb_tipo!=3){
			 
			
			 ?>
        <td align="center">
        <?php $nau="";
          for($au=0;$au<pg_numrows($autor);$au++){
				$fila_au = pg_fetch_array($autor,$au);
				 $nau.=$fila_au['nombre'].", ";
				 }
				 echo substr($nau,0,-2);
				 ?></td>
        <?php }?>
        <?php if($cmb_tipo!=1){?>
        <td align="center"><?php 
		$nca="";
          for($ca=0;$ca<pg_numrows($categorias);$ca++){
				$fila_ca = pg_fetch_array($categorias,$ca);
				 $nca.=$fila_ca['nombre'].", ";
				 }
				 echo substr($nca,0,-2);
				 ?></td>
        <?php }?>
        <td align="center"><?php echo $fila_res['ano_publicacion'] ?></td>
        <td align="center"><?php echo $fila_res['edicion'] ?></td>
         <?php if($cmb_tipo!=2){?>
        <td align="center"><?php echo $fila_res['nomeditorial'] ?></td>
        <?php  } ?>
        <td align="center"><?php echo intval(pg_result($conejem,0)); ?></td>
        <td align="center"><?php echo pg_numrows($prestados); ?></td>
      </tr>
     
   
    <?php } //fin for
	?>
	 
	<?php }else{?>
  <tr class="detalleoff">
    <td  align="center">SIN INFORMACI&Oacute;N DE CATALOGO</td>
    </tr>
    <?php }?>
    </table>
    </td>
  </tr> 
 
 
  </table>

<br />
<br />


</td></tr></table>


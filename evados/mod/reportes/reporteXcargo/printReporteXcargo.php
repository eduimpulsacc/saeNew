<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$ano		= $_POST['cmbANO'];
$cargo		= $_POST['cmbCARGO'];
$cmbINS		= $_POST['cmbINS'];
$crp 		= $_POST['crp'];



$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

if($cmbINS!=0){
	
$fila_instit= $ob_reporte->Membrete($cmbINS);
$fila_direc	= $ob_reporte->Director($cmbINS);

$anio = $ano;
	
	}else{

$fila_instit= $ob_reporte->Membrete($_INSTIT);
$fila_direc	= $ob_reporte->Director($_INSTIT);

$rs_anios = $ob_reporte->buscaNroAnio($ano,$crp);

for($j=0;$j<@pg_numrows($rs_anios);$j++){
	$fila=pg_fetch_array($rs_anios,$j);
	$array_anio[] = $fila['id_ano'];
} 

$xx=0;
foreach($array_anio as $d_anio => $val_anio){
	$xx++;
	$anio.= ($xx<count($array_anio))?$val_anio.",":$val_anio;

}



	}

$rs_cargo = $ob_reporte->EvaluacionXCargo2($cmbINS,$anio,$cargo);

$cargo_data	= $ob_reporte->Cargo($cargo);

	
?>
<script> 
function cerrar(){ 
window.close() 
} 

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	
	<? 
	$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_EVADOS_$Fecha.xls"); 
	?>
	
	window.close();
}

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<style>
.cajamenu {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 11px; PADDING-BOTTOM: 5px; TEXT-TRANSFORM: capitalize; COLOR: #333333; PADDING-TOP: 5px; BORDER-BOTTOM: #996633 thin solid; FONT-STYLE: normal; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; LIST-STYLE-TYPE: disc; BACKGROUND-COLOR: #f7f7f7; TEXT-DECORATION: none
}
.cajamenu2 {
	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #996633; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
.textosesion {
	FONT-WEIGHT: normal; FONT-SIZE: 9px; COLOR: #666666; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
.ccctableindex {
	BORDER-RIGHT: #999999 thin solid; PADDING-RIGHT: 5px; BACKGROUND-POSITION: center center; BORDER-TOP: #999999 thin solid; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 10px; PADDING-BOTTOM: 5px; MARGIN: 5px; VERTICAL-ALIGN: middle; BORDER-LEFT: #999999 thin solid; WIDTH: 98%; COLOR: #ffffff; PADDING-TOP: 5px; BORDER-BOTTOM: #999999 thin solid; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 25px; BACKGROUND-COLOR: #006292; TEXT-ALIGN: center; TEXT-DECORATION: none; bgcolor: #006292
}
.tableindex {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ffffff; TEXT-INDENT: 5px; BACKGROUND-REPEAT: repeat-x; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 39px; BACKGROUND-COLOR: #B98702; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.borde {
	BORDER-RIGHT: thin solid #B98702; PADDING-RIGHT: 10px; BORDER-TOP: thin; PADDING-LEFT: 10px; PADDING-BOTTOM: 10px; MARGIN: 10px; BORDER-LEFT: thin solid #B98702; PADDING-TOP: 10px; BORDER-BOTTOM: thin solid #B98702
}
.borde2 {
	BORDER-RIGHT: thin solid #B98702; PADDING-RIGHT: 1px; BORDER-TOP: thin; PADDING-LEFT: 1px; PADDING-BOTTOM: 1px; MARGIN: 1px; BORDER-LEFT: thin solid #B98702; PADDING-TOP: 1px; BORDER-BOTTOM: thin solid #B98702
}
.textolink {
	BORDER-RIGHT: 5px; PADDING-RIGHT: 5px; BORDER-TOP: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 9px; PADDING-BOTTOM: 5px; MARGIN: 5px; BORDER-LEFT: 5px; COLOR: #666666; PADDING-TOP: 5px; BORDER-BOTTOM: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
.piepagina {
	FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #999999; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; FONT-VARIANT: small-caps; TEXT-DECORATION: none
}
.cajaborde {
	BORDER-RIGHT: #cccccc thin solid; BORDER-TOP: #cccccc thin solid; BORDER-LEFT: #cccccc thin solid; BORDER-BOTTOM: #cccccc thin solid
}
.tablatit2 {
	BACKGROUND-POSITION: left center; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 12px; VERTICAL-ALIGN: top; WIDTH: auto; COLOR: #ffffff; PADDING-TOP: 5px; FONT-STYLE: normal; FONT-FAMILY: Arial, Helvetica, sans-serif; HEIGHT: 40px; BACKGROUND-COLOR: #999999; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.tablatit2-1 {
	BACKGROUND-POSITION: left center; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 12px; VERTICAL-ALIGN: top; WIDTH: auto; COLOR: #ffffff; PADDING-TOP: 5px; FONT-STYLE: normal; FONT-FAMILY: Arial, Helvetica, sans-serif; HEIGHT: 10px; BACKGROUND-COLOR: #999999; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.tablatit3 {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 11px; PADDING-BOTTOM: 5px; MARGIN: 5px; WIDTH: 50px; COLOR: #333333; PADDING-TOP: 5px; FONT-STYLE: italic; FONT-FAMILY: Arial, Helvetica, sans-serif; HEIGHT: 15px; BACKGROUND-COLOR: #cccccc; TEXT-DECORATION: none
}
.listadetalleoff {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 10px; PADDING-BOTTOM: 5px; MARGIN: 5px; COLOR: #666666; TEXT-INDENT: 0pt; PADDING-TOP: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 20px; BACKGROUND-COLOR: #ffffff; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.listadetalleon {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 10px; PADDING-BOTTOM: 5px; MARGIN: 5px; COLOR: #666666; TEXT-INDENT: 0pt; PADDING-TOP: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 20px; BACKGROUND-COLOR: #f8e3d4; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.cajatexto {
	BORDER-RIGHT: #999999 thin solid; BORDER-TOP: #999999 thin solid; PADDING-LEFT: 15px; FONT-WEIGHT: normal; FONT-SIZE: 10px; BORDER-LEFT: #999999 thin solid; COLOR: #ffffff; BORDER-BOTTOM: #999999 thin solid; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #ff6600; TEXT-DECORATION: none
}
A:link {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #4C2C15; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:visited {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #848484; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:active {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #333333; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:hover {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #B98702; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
.fondo {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ffffff; TEXT-INDENT: 5px; BACKGROUND-REPEAT: repeat-x; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 39px; BACKGROUND-COLOR: #006292; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.datos {
	FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #666666; BORDER-BOTTOM: #cccccc 1px solid; FONT-STYLE: normal; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 30px; BACKGROUND-COLOR: #ffffff; TEXT-DECORATION: none
}
.datosB {
	FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #666666; BORDER-BOTTOM: #cccccc 1px solid; FONT-STYLE: normal; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 30px; TEXT-DECORATION: none
}
.boton01 {
	BORDER-RIGHT: #cccccc 2px solid; BACKGROUND-POSITION: center center; BORDER-TOP: #cccccc 2px solid; FONT-WEIGHT: bolder; LIST-STYLE-POSITION: inside; FONT-SIZE: 11px; BACKGROUND-IMAGE: url(cortes/bottom.jpg); TEXT-TRANSFORM: none; BORDER-LEFT: #cccccc 2px solid; COLOR: #ffffff; BORDER-BOTTOM: #cccccc 2px solid; FONT-STYLE: normal; FONT-FAMILY: Arial, Helvetica, sans-serif; LIST-STYLE-TYPE: disc; TEXT-ALIGN: center; FONT-VARIANT: normal
}
.boton02 {
	FONT-WEIGHT: bold; FONT-SIZE: 10px; COLOR: #666666; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
.tabla01 {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; VERTICAL-ALIGN: middle; TEXT-TRANSFORM: none; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 20px; BACKGROUND-COLOR: #cc9933; TEXT-ALIGN: center; FONT-VARIANT: normal; TEXT-DECORATION: none
}
.tabla02 {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #996633; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 25px; TEXT-ALIGN: center; FONT-VARIANT: normal; TEXT-DECORATION: none
}
.imput {
	FONT-WEIGHT: bold; LIST-STYLE-POSITION: inside; FONT-SIZE: 12px; COLOR: #ffffff; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; LIST-STYLE-TYPE: disc; BACKGROUND-COLOR: #6699ff; TEXT-DECORATION: none
}
.datosC {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #ff6600; FONT-STYLE: normal; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 25px; TEXT-DECORATION: none
}
.nombre_campo {
	FONT-WEIGHT: bold; COLOR: #6699ff
}
.tabla03 {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; VERTICAL-ALIGN: middle; TEXT-TRANSFORM: none; COLOR: #ffffff; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 20px; BACKGROUND-COLOR: #cccccc; FONT-VARIANT: small-caps; TEXT-DECORATION: none
}
.tabla04 {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #666666; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 20px; FONT-VARIANT: normal; TEXT-DECORATION: none
}
.bot1 {
	BACKGROUND-IMAGE: url(../b_arriba_1.gif); WIDTH: 6px
}
.bot2 {
	FONT-WEIGHT: bold; FONT-SIZE: 11px; BACKGROUND-IMAGE: url(../b_arriba_2.gif); FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.bot3 {
	BACKGROUND-IMAGE: url(../b_arriba_3.gif); WIDTH: 22px
}
.bot4 {
	BACKGROUND-IMAGE: url(../b_arriba_4.gif); WIDTH: 21px
}
.vineta {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #ff6600; TEXT-INDENT: 5px; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 12px; BACKGROUND-COLOR: #dfdede; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.textosimple {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.textonegrita {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.titulo {
	FONT-WEIGHT: bold; FONT-SIZE: 9px; COLOR: #000000; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.detalle {
	FONT-SIZE: 8px; COLOR: #000000; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.Estilo3 {
	FONT-SIZE: 9px
}
.Estilo8 {
	FONT-WEIGHT: bold;
	FONT-SIZE: 9px;
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	background-color: #FFFFCC;
}
.Estilo11 {
	FONT-SIZE: 12px
}
.Estilo12 {
	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #666666; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.Estilo13 {
	FONT-WEIGHT: bold; FONT-SIZE: 20px; COLOR: #006292; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.Estilo14 {
	COLOR: #003366
}
.Estilo15 {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; BACKGROUND: #663300; COLOR: #ffffff; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-ALIGN: center
}
.Estilo17 {
	FONT-SIZE: 12px; COLOR: #524c72
}
.Estilo18 {
	COLOR: #ffffff
}
.Estilo19 {
	FONT-WEIGHT: bold; FONT-SIZE: 16px; VERTICAL-ALIGN: middle; COLOR: #663300; TEXT-INDENT: 5px; BACKGROUND-REPEAT: repeat-x; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 39px; BACKGROUND-COLOR: #FFFFCC; TEXT-ALIGN: center
}
.topcollege {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #996633; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-ALIGN: left
}
.report {
	FONT-WEIGHT: bold; LIST-STYLE-POSITION: inside; FONT-SIZE: 12px; COLOR: #ffffff; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; LIST-STYLE-TYPE: disc; BACKGROUND-COLOR: #cc9933; TEXT-DECORATION: none
}
.tachado {
	BORDER-RIGHT: 5px; PADDING-RIGHT: 5px; BORDER-TOP: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 9px; PADDING-BOTTOM: 5px; MARGIN: 5px; BORDER-LEFT: 5px; COLOR: #666666; PADDING-TOP: 5px; BORDER-BOTTOM: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: line-through
}
.titulos-respaldo {
	BACKGROUND-POSITION: center center; FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #ff6600; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.cuadro01 {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 10px; PADDING-BOTTOM: 5px; MARGIN: 5px; COLOR: #666666; TEXT-INDENT: 0pt; PADDING-TOP: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 20px; BACKGROUND-COLOR: #ffffff; TEXT-ALIGN: left; TEXT-DECORATION: none
}
.cuadro02 {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 10px; PADDING-BOTTOM: 5px; MARGIN: 5px; COLOR: #ffffff; TEXT-INDENT: 0pt; PADDING-TOP: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; HEIGHT: 20px; BACKGROUND-COLOR: #ce9b00; TEXT-ALIGN: left; TEXT-DECORATION: none
}
INPUT {
	FONT-WEIGHT: bold; LIST-STYLE-POSITION: inside; FONT-SIZE: 10px; COLOR: #003366; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; LIST-STYLE-TYPE: disc; BACKGROUND-COLOR: #ffffcc; TEXT-DECORATION: none
}
.botonXX {
	BACKGROUND-POSITION: center 50%; FONT-WEIGHT: bolder; LIST-STYLE-POSITION: inside; FONT-SIZE: 11px; BACKGROUND-IMAGE: url(linea01_2.jpg); TEXT-TRANSFORM: none; COLOR: #ffffff; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; LIST-STYLE-TYPE: disc; TEXT-ALIGN: center; FONT-VARIANT: normal
}
SELECT {
	BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; FONT: 10px Verdana; BORDER-LEFT: #000000 1px solid; COLOR: #003366; BORDER-BOTTOM: #000000 1px solid; BACKGROUND-COLOR: #ffffcc
}

</style>
<title>SISTEMA EVALUACI&Oacute;N DOCENTE</title>

</head>

<body>
<!--<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="button" type="submit" class="report" id="button" value="CERRAR" onClick="cerrar()" /></td>
    <td align="right"><input name="button2" type="submit" class="report" id="button2" value="EXPORTAR A EXCEL"  onClick="imprimir();"/></td>
  </tr>
</table>
</div>-->
<table width="650" border="0" align="center">
  <tr>
    <td width="172" align="center" valign="middle"><img src="http://intranet.colegiointeractivo.cl/sae3.0/evados/insignia.jpg" width="97" height="117" /></td>
    <td width="25" align="center" valign="middle"><hr align="center" width="1" size="100" /></td>
    <td width="439"><table width="100%" border="0">
      <tr>
        <td align="center" class="textonegrita"><? echo strtoupper($fila_instit['nombre_instit']);?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo $fila_instit['direc']." / ".$fila_instit['nom_reg'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"> <? echo "Telef�no ".$fila_instit['telefono'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosesion">www.educacionadventista.cl</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><u>Reporte por Cargos </u></td>
      </tr>
      <tr>
        <td class="textonegrita">Cargo: <?php echo $cargo_data['nombre_cargo'] ?></td>
      </tr>
      <tr>
        <td class="textonegrita">A&ntilde;o: <?php echo $ano ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td> 
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="tabla01">
            <?php if($cmbINS==0){?>
              <td width="19%">INSTITUCION</td>
              <?php }?>
              <td width="42%">NOMBRE</td>
              <td width="42%">% DE EVALUADORES</td>
              <td width="21%">% OBTENIDO</td>
              <td width="18%">RESULTADO</td>
            </tr>
			<? for($i=0;$i<pg_numrows($rs_cargo);$i++){
			  	$fila = pg_fetch_array($rs_cargo,$i);
				
			?>
            <tr class="textosesion" <?php if($i%2==0) echo "bgcolor=\"#E8E4E4\"" ?>>
             <?php if($cmbINS==0){?>
              <td><?php echo $fila['nombre_instit'] ?></td>
             <?php }?>
              <td  <?php if($fila['porcentaje']<90) echo "bgcolor=yellow" ?>><?php echo $fila['ape_pat'] ?> <?php echo $fila['ape_mat'] ?>, <?php echo $fila['nombre_emp'] ?></td>
			  <td <?php if($fila['porcentaje']<90) echo "bgcolor=yellow" ?> ><?php echo $fila['porcentaje'] ?></td>
              <td align="center" <?php if($fila['porcentaje']<90) echo "bgcolor=yellow" ?>><?php echo $fila['valor_final'] ?></td>
              <td <?php if($fila['porcentaje']<90) echo "bgcolor=yellow" ?>><?php echo $fila['evaluacion_final'] ?></td>
            </tr><? } ?>
          </table><BR /></td>
      </tr>
      <tr>
        <td>&nbsp;<? //echo $cmbINS." ".$contador;?></td>
      </tr>
  </table></td>
  </tr>
 
</table>
</body>
</html>
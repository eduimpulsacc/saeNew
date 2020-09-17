<?	require('../../../../../util/header.inc');
	include('../../../../clases/class_MotorBusqueda.php');
	include('../../../../clases/class_Membrete.php');
	include('../../../../clases/class_Reporte.php');

	//print_r($_POST); exit;
	
	$institucion	=$_INSTIT;
	$ano			=$c_ano;
	$reporte		=$c_reporte;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	
	
	$_POSP = 4;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte->curso=$curso;
	$rs_profe = $ob_reporte->ProfeJefe($conn);
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_reporte->ano=$ano;
	$ob_reporte->nro_ano =$ob_membrete->nro_ano;
	
	

	$ob_reporte->ano=$ano;
	$ob_reporte->AnoEscolar($conn);
	$ano2=$ob_reporte->nro_ano;
	
		
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/*if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Alumnos_Tipificados_$Fecha.xls"); 
	}	*/
	
	$sql = "SELECT * FROM DECLARACION_ACCIDENTE WHERE ID_CURSO = $curso order by fecha desc";
$result=@pg_Exec($conn, $sql);
$fila = pg_fetch_array($result);


function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../../../cortes/12086/estilos.css " rel="stylesheet" type="text/css">

<title>COLEGIOINTERACTIVO.COM</title>
</head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }

</style>
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><div align="left"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></div></td>
    <td class="textosesion">&nbsp;</td>
    <td><div align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="834"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
   <? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='../".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='../".$d."menu/imag/logo.gif' >";
		    }?>
	  
   <? } ?>  
	  
	  
	  	</td>
		</tr>
      </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
            <td height="41" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>
<br>	
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">Reporte Accidentes</div></td>
  </tr>
 </table>
<br>
<!--/////////////////////////////////////nueva tabla///////////////////////////////-->

<table width="650" border="0" align="center">
  <tr>
    <td width="19%" class="textonegrita">Curso</td>
    <td width="3%" class="textonegrita">:</td>
    <td width="78%" class="textosimple">&nbsp;<? echo CursoPalabra($curso,0,$conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">Profesor Jefe</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<?=$ob_reporte->profe_jefe;?></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">    
      <tr class="tablatit2-1">
        <td>Fecha</td>
        <td>Alumno</td>
       
        <td>Tipo Accidente</td>
       
      </tr>
     <?php  for($i=0 ; $i < @pg_numrows($result); $i++){
		  $fila = @pg_fetch_array($result,$i);
		  
		  
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$fila['rut_alumno'];
		$result_alumno = $ob_reporte->TraeUnAlumno($conn);
		$fila_alumno = @pg_fetch_array($result_alumno,0);
		$nombre_alumno = ucwords(strtoupper($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " 
		" . $fila_alumno['nombre_alu']));
		
		 ?>
      <tr  class="textosimple">
        <td><?php echo CambioFechaDisplay($fila['fecha']); ?></td>
        <td><?php echo $nombre_alumno; ?></td>
        <td><?php echo ($fila['tipo']==1)?"De Trayecto":"En el establecimiento"; ?></td>
      </tr>
      <?php  } ?>
    </table>
<br />
<br />
<table width="650" border="0" align="center">
  <tr>
  		  <? if(!$cb_ok=="Buscar"){?>
		  <td>&nbsp;</td>
		  <? }?>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</body>
</html>

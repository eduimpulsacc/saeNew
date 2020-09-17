<?php require('../../../../../../util/header.inc');
require('../../../../../clases/class_Reporte.php');
$ob_reporte = new Reporte();

$ob_reporte->id_atencion = $_POST['id_atencion'];
$rs_atencion=$ob_reporte->EnfermeriaAlumnoDetalle($conn);
$fila_atencion=pg_fetch_array($rs_atencion,0);

$_POSP          = 6;

//$ob_reporte->cambiaEstado($conn,$id)


if($fila_atencion['visto']==0 && $_PERFIL==15){
	$ob_reporte->cambiaEstado($conn);
}

?>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<div id="cabecera">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td><TABLE width="98%" height="100%" BORDER=0 CELLPADDING=0 CELLSPACING=1>
						<TR>
							<TD width="17%" class="textonegrita">AÑO</TD>
							<TD width="3%" align="center" class="textonegrita">:</TD>
							<TD width="80%" class="textosimple">
								
									
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$_ANO;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?></TD>
						</TR>
						<TR>
							<TD  class="textonegrita">ALUMNO</TD>
							<TD align="center"  class="textonegrita">:</TD>
							<TD class="textosimple"><?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$fila_atencion['rut_alumno'];
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?></TD>
						</TR>
						<TR>
						  <TD  class="textonegrita">CURSO</TD>
						  <TD align="center"  class="textonegrita">:</TD>
						  <TD class="textosimple">
                          <? 				  $sqlcurso="select * from curso where id_ano=".$_ANO." and id_curso=".$fila_atencion['id_curso'];
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);
											
											?><?php echo $filacurso["grado_curso"]." ".$filacurso["letra_curso"];?>
									</TD>
		  </TR>
					</TABLE></td>
    <td align="center" valign="top"><?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='80' height='80' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }
		}?></td>
  </tr>
</table>
</div><br />
<table border="1" style="border-collapse:collapse" width="100%">
<tr class="tableindex"><td align="center">DETALLE ATENCION ENFERMERIA</td></tr>
</table><br />
<br />


<table width="100%" border="1" style="border-collapse:collapse">
  <tr class="tableindex">
    <td width="100" align="center">Fecha Atenci&oacute;n</td>
    <td width="100" align="center">Hora Ingreso</td>
    <td width="100" align="center">Hora Egreso</td>
  </tr>
  <tr class="textosimple">
    <td align="center"><?php echo CambioFD($fila_atencion['fecha']) ?></td>
    <td align="center"><?php echo $fila_atencion['hora_ingreso'] ?></td>
    <td align="center"><?php echo $fila_atencion['hora_egreso'] ?></td>
  </tr>
</table>
<br>
<table width="100%" border="1" style="border-collapse:collapse">
  <tr>
    <td width="124"  class="tableindex">Motivo Consulta</td>
    <td width="753" class="textosimple" >&nbsp;<?php $ob_reporte->patologia=$fila_atencion['patologia'];
		$rs_datopatologia = $ob_reporte->Patologia($conn);
		echo $patologia = pg_result($rs_datopatologia,1)?></td>
  </tr>
  <tr>
    <td  class="tableindex">Destino</td>
    <td class="textosimple">&nbsp;<?php echo strtoupper($fila_atencion['destino']) ?></td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="1" style="border-collapse:collapse">
 <!-- <tr>
    <td width="101" class="tableindex">Motivo Consulta</td>
    <td width="167" class="textosimple">&nbsp;<?php echo strtoupper($fila_atencion['motivo_consulta']) ?></td>
  </tr>-->
  <tr>
    <td width="124" class="tableindex">Procedimiento</td>
    <td width="86%" class="textosimple">&nbsp;<?php echo strtoupper($fila_atencion['procedimiento']) ?></td>
  </tr>
  <tr>
    <td class="tableindex">Observaciones</td>
    <td class="textosimple">&nbsp;<?php echo strtoupper($fila_atencion['observaciones']) ?></td>
  </tr>
</table>

<?  require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

$institucion= $_INSTIT;
$ano 		= $_ANO;
$ensenanza 	= $tipo_ensenanza;
$mes		= $cmbMES;
$nro_ano	= $cmbANO;

if($mes==4 || $mes==6 ||$mes==9 || $mes==11){
	$dia_final=31;
}else{
	$dia_final=32;
}	

$ob_membrete = new Membrete();
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);

$ob_reporte = new Reporte();
$ob_reporte->ano=$ano;
$ob_reporte->ensenanza=$ensenanza;
$rs_curso = $ob_reporte->CantidadCurso($conn);

$ob_reporte->mes =$mes;
$ob_reporte->nro_ano=$nro_ano;
$ob_reporte->retirado =0;
if($mes==4 || $mes==6 || $mes==9 ||$mes==11){
	$fecha_final = $mes."-30-".$nro_ano;
}else{
	$fecha_final = $mes."-31-".$nro_ano;
}
	$fecha_inicial = $mes."-01-".$nro_ano;

$total_curso=0;
for($i=0;$i<@pg_numrows($rs_curso);$i++){
	$fila = @pg_fetch_array($rs_curso,$i);
	if($fila['grado_curso']==1){
		$grado1=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicio = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;
		$ob_reporte->baja=1;
		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_1 = @pg_result($rs_inicial,0);
		if($inicial_1==0) $inicial_1=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_1 = @pg_result($rs_altas,0);
		if($altas_1==0) $altas_1=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_1 = @pg_result($rs_bajas,0);
		if($bajas_1==0) $bajas_1=0;
		
	}elseif($fila['grado_curso']==2){
		$grado2=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;

		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_2 = @pg_result($rs_inicial,0);
		if($inicial_2==0) $inicial_2=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_2 = @pg_result($rs_altas,0);
		if($altas_2==0) $altas_2=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_2 = @pg_result($rs_bajas,0);
		if($bajas_2==0) $bajas_2=0;
	}elseif($fila['grado_curso']==3){
		$grado3=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;
	
		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_3 = @pg_result($rs_inicial,0);
		if($inicial_3==0) $inicial_3=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_3 = @pg_result($rs_altas,0);
		if($altas_3==0) $altas_3=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_3 = @pg_result($rs_bajas,0);
		if($bajas_3==0) $bajas_3=0;
	}elseif($fila['grado_curso']==4){
		$grado4=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;

		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_4 = @pg_result($rs_inicial,0);
		if($inicial_4==0) $inicial_4=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_4 = @pg_result($rs_altas,0);
		if($altas_4==0) $altas_4=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_4 = @pg_result($rs_bajas,0);
		if($bajas_4==0) $bajas_4=0;
	}elseif($fila['grado_curso']==5){
		$grado5=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;

		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_5 = @pg_result($rs_inicial,0);
		if($inicial_5==0) $inicial_5=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_5 = @pg_result($rs_altas,0);
		if($altas_5==0) $altas_5=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_5 = @pg_result($rs_bajas,0);
		if($bajas_5==0) $bajas_5=0;
	}elseif($fila['grado_curso']==6){
		$grado6=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;

		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_6 = @pg_result($rs_inicial,0);
		if($inicial_6==0) $inicial_6=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_6 = @pg_result($rs_altas,0);
		if($altas_6==0) $altas_6=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_6 = @pg_result($rs_bajas,0);
		if($bajas_6==0) $bajas_6=0;
	}elseif($fila['grado_curso']==7){
		$grado7=$fila['count'];
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;

		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_7 = @pg_result($rs_inicial,0);
		if($inicial_7==0) $inicial_7=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_7 = @pg_result($rs_altas,0);
		if($altas_7==0) $altas_7=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_7 = @pg_result($rs_bajas,0);
		if($bajas_7==0) $bajas_7=0;
	}elseif($fila['grado_curso']==8){
		$grado8=$fila['count'];		
		$ob_reporte->grado = $fila['grado_curso'];
		$ob_reporte->fecha_inicial = $fecha_inicial;
		$ob_reporte->fecha_final =$fecha_final;

		$rs_inicial = $ob_reporte->MatriculaInicial($conn);
		$inicial_8 = @pg_result($rs_inicial,0);
		if($inicial_8==0) $inicial_8=0;
		
		$rs_altas = $ob_reporte->MatriculaAltas($conn);
		$altas_8 = @pg_result($rs_altas,0);
		if($altas_8==0) $altas_8=0;
		
		$rs_bajas = $ob_reporte->MatriculaBajas($conn);
		$bajas_8 = @pg_result($rs_bajas,0);
		if($bajas_8==0) $bajas_8=0;
	}
	if($fila['count'] > 0){
		$total_curso += $fila['count'];
	}

}
$total_inicial = $inicial_1 +  $inicial_2 +  $inicial_3 +  $inicial_4 +  $inicial_5 +  $inicial_6 +  $inicial_7 +  $inicial_8;
$total_altas = $altas_1 + $altas_2 +  $altas_3 + $altas_4 + $altas_5 + $altas_6 + $altas_7 + $altas_8;
$total_bajas = $bajas_1 + $bajas_2 + $bajas_3 + $bajas_4 + $bajas_5 + $bajas_6 + $bajas_7 + $bajas_8;
$total_final = $total_inicial + $total_altas - $total_bajas;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.Celda{
border-collapse:separate;
border-spacing:2px;

}
.tabla{
border-color:#CCCCCC;
border-width:1px;
}
.td{
	border-color:#CCCCCC;
	border-width:1px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
</style>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
</head>

<body>
<div id="capa0">
<table width="1100" align="center">
  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="window.close()" value="CERRAR"></td>
	<td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	   <? if($_PERFIL==0){?>		  
	<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
		<? }?>
	</td>
</tr>
</table>
</div>
<table width="1100" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="Estilo2"><div align="center">GOBIERNO DE CHILE - MINISTERIO DE EDUCACI&Oacute;N - UNIDAD DE SUBVENCIONES </div></td>
      </tr>
      <tr>
        <td class="Estilo1"><div align="center">FORMULARIO ANEXO AL BOLETIN MENSUAL DE SUBVENCIONES CON ASISTENCIAS DIARIAS POR CURSO </div></td>
      </tr>
    </table>
    <br />
    <table width="100%" border="0" cellpadding="0" cellspacing="5" class="Celda">
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><?=$ob_membrete->ins_pal?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" class="td"><div align="center">
              <?=$ob_membrete->letra;?>
            </div></td>
            <td width="15%" class="td"><div align="center">-</div></td>
            <td width="52%" class="td"><div align="center">
              <?=$ob_membrete->numero_inst;?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="19%" class="td"><div align="center">
              <?=$ob_membrete->num_region;?>
            </div></td>
            <td width="13%" class="td"><div align="center"><strong>-</strong></div></td>
            <td width="26%" class="td"><div align="center">
              <?=$ob_membrete->num_ciudad;?>
            </div></td>
            <td width="10%" class="td"><div align="center"><strong>-</strong></div></td>
            <td width="32%" class="td"><div align="center">
              <?=$ob_membrete->num_comuna;?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" class="td"><?=$mes;?></td>
            <td width="13%" class="td"><div align="center"><strong>-</strong></div></td>
            <td width="54%" class="td"><?=$nro_ano;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><?=$ensenanza;?>
              <div align="center"></div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="60%" class="td"><div align="center">
              <?=$institucion;?>
            </div></td>
            <td width="6%" class="td"><div align="center"><strong>-</strong></div></td>
            <td width="34%" class="td"><div align="center">
              <?=$ob_membrete->dig_rdb;?>
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="Estilo2">NOMBRE ESTABLECIMIENTO </td>
        <td class="Estilo2">LETRA Y NUMERO </td>
        <td class="Estilo2">REG PROV COM </td>
        <td class="Estilo2">MES A&Ntilde;O </td>
        <td class="Estilo2">TIPO ENS. </td>
        <td class="Estilo2">D S </td>
        <td class="Estilo2">C.C.</td>
        <td class="Estilo2">ROL BASE DE DATOS </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="5" cellpadding="0" class="Celda">
      <tr>
        <td class="Estilo2">CURSOS</td>
        <td class="Estilo2"><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="Estilo1"><div align="center">1ero.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="Estilo1"><div align="center">2do.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">3ro.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">4to.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">5to.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">6to.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">7mo.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">8avo.</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo1">TOTAL</div></td>
          </tr>
        </table></td>
        <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center" class="Estilo2">Derechos de Escolaridad </div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&iquest;N&ordm; Cursos? </td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td><span class="Estilo2">&iquest;N&ordm; Cursos?</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
      </tr>
      <tr>
        <td class="Estilo2"><strong>NUMERO</strong></td>
        <td class="Estilo2"><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              <?=$grado1;?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado2;?>
              </td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado3;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado4;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado5;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado6;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado7;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$grado8;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;<?=$total_curso;?></td>
          </tr>
        </table></td>
        <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td class="Estilo2">Matric</td>
        <td class="Estilo2">Matr&iacute;cula</td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Matr&iacute;cula</span></td>
        <td><span class="Estilo2">Total Matr&iacute;c</span></td>
        <td><span class="Estilo2">Matr Internos </span></td>
        <td class="Estilo2">Matric</td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Inicial</td>
          </tr>
          <tr>
            <td class="td">Altas</td>
          </tr>
          <tr>
            <td class="td">Bajas</td>
          </tr>
          <tr>
            <td class="td">Final</td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_1;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center"><?=$altas_1;?></div></td>
          </tr>
          <tr>
            <td class="td"><div align="center"><?=$bajas_1;?></div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_1 + $altas_1 - $bajas_1; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_2;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$altas_2;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$bajas_2;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_2 + $altas_2 - $bajas_2; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_3;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$altas_3;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$bajas_3;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_3 + $altas_3 - $bajas_3; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_4;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$altas_4;?>
</div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$bajas_4;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              <?=$inicial_4 + $altas_4 - $bajas_4; ?>
              </div></td>
          </tr>
        </table></td><td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_5;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
             &nbsp; <?=$altas_5;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$bajas_5;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_5 + $altas_5 - $bajas_5; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_6;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$altas_6;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$bajas_6;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_6 + $altas_6 - $bajas_6; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_7;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$altas_7;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$bajas_7;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_7 + $altas_7 - $bajas_7; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_8;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$altas_8;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$bajas_8;?>
            </div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">
              &nbsp;<?=$inicial_8 + $altas_8 - $bajas_8; ?>
            </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">&nbsp;<?=$total_inicial;?></div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">&nbsp;<?=$total_altas;?></div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">&nbsp;<?=$total_bajas;?></div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">&nbsp;<?=$total_final;?></div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
            <td class="td"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Inicial</td>
          </tr>
          <tr>
            <td class="td">Altas</td>
          </tr>
          <tr>
            <td class="td">Bajas</td>
          </tr>
          <tr>
            <td class="td">Final</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">D&iacute;a</div></td>
          </tr>
		  <? for($i=1;$i<$dia_final;$i++){?>
          <tr>
            <td class="td"><div align="center"><?=$i;?></div></td>
          </tr>
		  <? } ?>
          <tr>
            <td class="td"><div align="center">Total</div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
		  <? for($i=1;$i<$dia_final;$i++){
		  		if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=1;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_1 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_1="&nbsp;";
				}
		  ?>
          <tr>
            <td class="td"><div align="center"><?=$total_dia_1;?>
              </div></td>
          </tr>
		  <? 	$final_1 += $total_dia_1;
			  	$final_es[$i] +=$total_dia_1;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_1;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=2;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_2 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_2="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_2;?>
              </div></td>
          </tr>
		  <? 	$final_2 +=$total_dia_2;
		  		$final_es[$i] +=$total_dia_2;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_2;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=3;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_3 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_3="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_3;?>
              </div></td>
          </tr>
		  <? 	$final_3 +=$total_dia_3;
		  		$final_es[$i] +=$total_dia_3;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_3;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=4;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_4 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_4="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_4;?>
              </div></td>
          </tr>
		  <? 	$final_4 +=$total_dia_4;
		  		$final_es[$i] +=$total_dia_4;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_4;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=5;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_5 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_5="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_5;?>
              </div></td>
          </tr>
		  <? 	$final_5 +=$total_dia_5;
		  		$final_es[$i] +=$total_dia_5;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_5;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=6;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_6 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_6="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_6;?>
              </div></td>
          </tr>
		  <? 	$final_6 +=$total_dia_6;
			  	$final_es[$i] +=$total_dia_6;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_6;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=7;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_7 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_7="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_7;?>
              </div></td>
          </tr>
		  <? 	  $final_7 +=$total_dia_7;
				  $final_es[$i] +=$total_dia_7;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_7;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td class="td">Asistencia</td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   if($i<10) $dia = "0".$i; else $dia=$i;
				if($mes<10) $mes1 = "0".$mes; else $mes1 = $mes;
				
				$fechaH = $mes1."-".$dia."-".$nro_ano;
				$fecha_f = mktime(0,0,0,$mes1,$dia,$nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
				
				if($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun"){
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);
					if($habil==1){ // DIA FERIADO
						$total_dia="&nbsp;";
					}else{ // DÍA HABIL Y NO ES FERIADO
						//********* MATRICULADOS ***************/
						$ob_reporte->fecha_dia = $fechaH;
						$ob_reporte->grado=8;
						$rs_matricula = $ob_reporte->MatriculaDia($conn);
						$cant_matricula = @pg_result($rs_matricula,0);
						
						/************* BAJAS *********************/
						$ob_reporte->fecha_inicio =$mes1."-01-".$nro_ano;
						$ob_reporte->fecha_final=$fechaH;
						$ob_reporte->baja=1;
						$rs_bajas = $ob_reporte->MatriculaBajas($conn);
						$cant_bajas = @pg_result($rs_bajas,0);
						
						/*********** ASISTENCIA ****************/
						$ob_reporte->fecha_dia = $fechaH;
						$rs_asistencia = $ob_reporte->AsistenciaDia($conn);
						$cant_asistencia = @pg_result($rs_asistencia,0);
						
						$total_dia_8 = ($cant_matricula - $cant_bajas) - $cant_asistencia;
					}
				}else{
					$total_dia_8="&nbsp;";
				}
		   ?>
          <tr>
            <td class="td"><div align="center">
                <?=$total_dia_8;?>
              </div></td>
          </tr>
		  <? 	$final_8 +=$total_dia_8;
		  		$final_es[$i] +=$total_dia_8;
		  } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$final_8;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Total Matric </td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){
		   		$total_gral +=$final_es[$i];?>
          <tr>
            <td class="td"><div align="center">&nbsp;
                <? if($final_es[$i] > 0) echo $final_es[$i];?>
              </div></td>
          </tr>
		  <? } ?>
		   <tr>
            <td class="td"><div align="center">
                <?=$total_gral;?>
              </div></td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td">Matr. Internos </td>
          </tr>
          <? for($i=1;$i<$dia_final;$i++){?>
          <tr>
            <td class="td">&nbsp;</td>
          </tr>
		  <? } ?>
		   <tr>
            <td class="td">&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td class="td"><div align="center">D&iacute;a</div></td>
          </tr>
           <? for($i=1;$i<$dia_final;$i++){?>
          <tr>
            <td class="td"><div align="center">
              <?=$i;?>
            </div></td>
          </tr>
		  <? } ?>
		   <tr>
            <td class="td">Total</td>
          </tr>
        </table></td>
      </tr>
    </table>
    </td>
    <td width="26%" valign="top"><table width="99%"  border="0" align="center" cellpadding="0" cellspacing="3">
      <tr>
        <td height="14"><div align="center"><span class="Estilo1">ASPECTOS ADMINISTRATIVOS Y CONTROL GENERAL </span></div></td>
      </tr>
      <tr>
        <td height="152"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="Celda"><span class="Estilo2">FECHA ENTREGA</span>_______________________ </td>
          </tr>
          <tr>
            <td>_______________________________________</td>
          </tr>
          <tr>
            <td class="Estilo2">NOMBRE DEL SOSTENEDOR O REP. LEGAL<br />
<br />
<br />
<br /></td>
          </tr>
          <tr>
            <td><div align="center">_____________________________________</div></td>
          </tr>
          <tr>
            <td valign="baseline"><div align="center" class="Estilo2">FIRMA</div></td>
          </tr>
          <tr>
            <td>____________________________________________</td>
          </tr>
        </table></td></tr>
      <tr>
        <td height="45"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="Estilo2">Fecha Recepcion___________________________ </td>
          </tr>
          <tr>
            <td class="Estilo2">&nbsp;</td>
          </tr>
          <tr>
            <td class="Estilo2"><br />
              <br />
              <br /></td>
          </tr>
          <tr>
            <td class="Estilo2">FUNCIONARIO REVISOR DE ANTECEDENTES GENERALES </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="76"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="Estilo2">_________________________________________________________</td>
          </tr>
          <tr>
            <td class="Estilo2">V&ordm;B&ordm; Departamento Provincial </td>
          </tr>
          <tr>
            <td class="Estilo2">&nbsp;</td>
          </tr>
          <tr>
            <td class="Estilo2">&nbsp;</td>
          </tr>
          <tr>
            <td class="Estilo2">&nbsp;</td>
          </tr>
          <tr>
            <td class="Estilo2">&nbsp;</td>
          </tr>
          <tr>
            <td class="Estilo2">FIRMA JEFE DEPARTAMENTO PROVINCIAL DE EDUCACION </td>
          </tr>
          <tr>
            <td class="Estilo2">________________________________________________________<br /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="397" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="5" class="Celda">
          <tr>
            <td colspan="4" class="Estilo1"><div align="center">TOTALES PARA LLENADO BMS. OPTICO </div></td>
            </tr>
          <tr>
            <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" class="td"><div align="center">Fecha Asist. </div></td>
                </tr>
              <tr>
                <td class="td"><div align="center">Mes</div></td>
                <td class="td"><div align="center">A&ntilde;o</div></td>
              </tr>
              <tr>
                <td class="td"><div align="center"><?=$mes;?></div></td>
                <td class="td"><div align="center"><?=$nro_ano;?></div></td>
              </tr>
            </table></td>
            <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td class="td"><div align="center">Rol Base de<br />
                  Datos</div></td>
                <td class="td"><div align="center">D<br />
                  V</div></td>
              </tr>
              <tr>
                <td class="td"><div align="center"><?=$institucion;?> </div></td>
                <td class="td"><div align="center"><?=$ob_membrete->dig_rdb;?></div></td>
              </tr>
            </table></td>
            <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td class="td"><div align="center">C&oacute;digo<br />
                  Ense&ntilde;.</div></td>
                </tr>
              <tr>
                <td class="td"><div align="center">00 </div></td>
                </tr>
            </table></td>
            <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td class="td"><div align="center"><br />
                  D.S.</div></td>
              </tr>
              <tr>
                <td class="Estilo2"><div align="center">00 </div></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
		  	<td colspan="4">&nbsp;</td>
		  </tr>
          <tr>
           <td colspan="4"><table width="95%" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td rowspan="2" class="td"><div align="center">Matric. Final<br />
                  Tipo Educ. </div></td>
                <td colspan="3" class="td"><div align="center">Informe Internado </div></td>
                <td rowspan="2" class="td"><div align="center">C.<br />
                  C.</div></td>
                <td rowspan="2" class="td"><div align="center">Derechos de<br />
                  Escolaridad</div></td>
              </tr>
              <tr>
                <td class="td"><div align="center">Matr. Fin </div></td>
                <td class="td"><div align="center">Asist. Efect. </div></td>
                <td class="td"><div align="center">D&iacute;as</div></td>
                </tr>
              <tr>
                <td class="td">&nbsp;</td>
                <td class="td">&nbsp;</td>
                <td class="td">&nbsp;</td>
                <td class="td">&nbsp;</td>
                <td class="td">&nbsp;</td>
                <td class="td">&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
            </tr>
        </table>
          <table width="95%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td class="td">Grado</td>
              <td class="td">N&ordm;<br />
                Curs</td>
              <td class="td">Matric.<br />
                Inicial</td>
              <td class="td">Altas<br />
                del mes </td>
              <td class="td">Bajas<br />
                del mes </td>
              <td class="td">Asistencia<br />
                Mensual</td>
              <td class="td">N&ordm;<br />
                D&iacute;as</td>
            </tr>
            <tr>
              <td class="td">1&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">2&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">3&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">4&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">5&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">6&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">7&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
            <tr>
              <td class="td">8&ordm;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td">&nbsp;</td>
              <td class="td"><div align="center">&nbsp;</div></td>
              <td class="td"><div align="center">&nbsp;</div></td>
            </tr>
          </table>
          <br /></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="1075" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="Estilo1">UNA OBSEVACION Y ALGUNOS MENSJAES QUE PODR&Iacute;AN APRECER CON LETRA &quot;ROJA&quot; Y QUE SE SUGUIERE SOLUCIONAR: </td>
  </tr>
  <tr>
    <td class="Estilo2">- En d&iacute;as oficialmente sin clases (S&aacute;bados, domingos,festivos,vacaciones escolares &oacute; autorizadas por Deprov), los recuadros de asistencias deben ir en blanco, caso contratio debe ir valor aunque &eacute;ste sea &quot;cero&quot; </td>
  </tr>
  <tr>
    <td class="Estilo2">- N&uacute;meros 1,2,3,4,5,6,7,8 &oacute; 9, que podr&iacute;an aparecer en rojo frente a alguna celda derecha de los recuadros de asistencia significa que ese curso y ese d&iacute;a se habr&iacute;a informado una asistencia mayor que la matricula. </td>
  </tr>
  <tr>
    <td class="Estilo2">- Podr&iacute;an aparecer tambi&eacute;n mensajes en &quot;rojo&quot; cuando: -Se est&eacute; informando un curso combiado y simultaneamente n&uacute;mero de curso por grado, - Cuando no existe el c&oacute;digo de ense&ntilde;anza que est&eacute; indicando. </td>
  </tr>
  <tr>
    <td class="Estilo2">- Cuando estemos informando un curso que no corresponde al nivel de ense&ntilde;anza , - Cuando la matr&iacute;cula excede el maximo permitido, - cuando el derecho de escolaridad informado no se indica un n&uacute;mero entero. </td>
  </tr>
</table>
</body>
</html>

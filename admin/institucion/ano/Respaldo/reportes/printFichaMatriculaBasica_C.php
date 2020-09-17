<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

$institucion= $_INSTIT;
$ano 		= $_ANO;
$curso		= $cmb_curso;
$alumno		= $alumno;

$ob_reporte = new Reporte();
$ob_reporte->curso = $curso;
$ob_reporte->ano = $ano;
$ob_reporte->retirado =0;
if($alumno==0){
	$rs_alumno = $ob_reporte->FichaAlumnoTodos($conn);
}else{
	$ob_reporte->alumno = $alumno;
	$rs_alumno = $ob_reporte->FichaAlumnoUno($conn);
}

$ob_membrete = new Membrete();
$ob_membrete->ano = $ano;
$ob_membrete->AnoEscolar($conn);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script language="javascript1.1" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>

<body>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
        <? if($_PERFIL==0){?>
        <input name="cb_exp" type="button" onclick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" />
        <? }?>
    </td>
  </tr>
</table>
</div>
<? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
		$fila_alu = pg_fetch_array($rs_alumno,$i);
		$ob_reporte->CambiaDato($fila_alu);
		$sql = "SELECT grado_curso,ensenanza,letra_curso FROM curso a INNER JOIN matricula b ON a.id_curso=b.id_curso WHERE rut_alumno=".$fila_alu['rut_alumno']." AND a.id_ano=".$ano;
		$rs_curso =@pg_exec($conn,$sql);
		$grado = @pg_result($rs_curso,0);
		$ensenanza = @pg_result($rs_curso,1);
		$letra = @pg_result($rs_curso,2);
		if($grado < 8 and $ensenanza==110){
			$grado_new  = $grado + 1 ;
			$nivel = "Básico";
		}elseif($grado==8){
			$grado_new = 1;
			$nivel = "Medio ";
		}elseif($grado < 4 and $ensenanza > 110){
			$grado_new = $grado + 1;
			$nivel = "Medio ";
		}elseif($ensenanza==10 and $grado==4){
			$grado_new = "Kinder ";
			$nivel = "Parvulo ";
		}elseif($ensenanza==10 and $grado==5){
			$grado_new = "1 ";
			$nivel = "Básico";
		}
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="3">
	<?
		if($institucion!=""){
			echo "<img src='../../../../tmp/".$institucion."insignia". "' alt='90' width='90' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?>	</td>
    <td width="63%" class="textosimple">&nbsp;</td>
    <td width="17%" class="textosimple">A&ntilde;o Escolar :</td>
    <td width="10%" class="textosimple">&nbsp;
    <?=($ob_membrete->nro_ano + 1);?></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td class="textosimple">N&ordm; Matricula :</td>
    <td class="textosimple"><? if ($institucion!=1914)if ($institucion!=40251){?>;<?=$ob_reporte->num_matricula;?><? } ?></td>
  </tr>
  
  <tr>
    <td><div align="center"><strong>FICHA DE MATRICULA </strong></div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="tabla04">
  <tr>
    <td colspan="4"><div align="center">DATOS DEL ALUMNO  </div></td>
  </tr>
  <tr>
    <td width="8%" class="textosimple">RUT</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->rut_alumno;?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->ape_nombre_alu;?></td>
  </tr>
  <tr>
    <td class="textosimple">CURSO</td>
    <td colspan="3">&nbsp;<?=$grado_new."º ".$letra." ".$nivel;?></td>
  </tr>
  <tr>
    <td class="textosimple">SEXO</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->sexo;?></td>
  </tr>
  <tr>
    <td class="textosimple">FECHA</td>
    <td colspan="3">&nbsp;<? impF($ob_reporte->fecha_nacimiento);?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->direccion_alu;?></td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="40%">&nbsp;<?=$ob_reporte->comuna;?></td>
    <td width="9%" class="textosimple">TELEFONO</td>
    <td width="43%">&nbsp;<?=$ob_reporte->telefono_alu;?></td>
  </tr>
</table>
<br />
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable=1;
	$rs_apoderado = $ob_reporte->Apoderado($conn);
	$fila_apo = pg_fetch_array($rs_apoderado,0);
	$ob_reporte->CambiaDatoApo($fila_apo);
?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="tabla04">
  <tr>
    <td colspan="4"><div align="center">DATOS DEL APODERADO </div></td>
  </tr>
  <tr>
    <td width="162" class="textosimple">RUT</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->rut_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->ape_nombre_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">PROFESION U OFICIO </td>
    <td colspan="3">&nbsp;<?=$ob_reporte->profesion;?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;<?=$ob_reporte->direccion;?></td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="149">&nbsp;<?=$ob_reporte->comuna_apo;?></td>
    <td width="81" class="textosimple">TELEFONO</td>
    <td width="218">&nbsp;<?=$ob_reporte->telefono_apo;?></td>
  </tr>
</table>

<br />
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable = 0;
	$rs_madre = $ob_reporte->Madre($conn);
	$fila_madre = pg_fetch_array($rs_madre,0);
	
?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="tabla04">
  <tr>
    <td colspan="2"><div align="center">DATOS MADRE </div></td>
  </tr>
  <tr>
    <td width="160" class="textosimple">RUT MADRE </td>
    <td width="464">&nbsp;<?=$fila_madre['rut_apo']."-".$fila_madre['dig_rut'];?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE MADRE </td>
    <td>&nbsp;<?=$fila_madre['nombre_apo']." ".$fila_madre['ape_pat']." ".$fila_madre['ape_mat'];?></td>
  </tr>
  <tr>
    <td class="textosimple">TELEFONO MADRE </td>
    <td>&nbsp;<?=$fila_madre['telefono'];?></td>
  </tr>
  <tr>
    <td class="textosimple">ESTUDIOS </td>
    <td>&nbsp;<?=$fila_madre['nivel_edu'];?></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td><div align="right">______________________________</div></td>
  </tr>
  <tr>
    <td><div align="right">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />

<table width="650" border="0" align="center" cellpadding="2" cellspacing="0" class="tabla04">
  <tr>
    <td width="154">FECHA MATRICULA </td>
    <td width="496"><? if ($institucion!=1914)if ($institucion!=40251){?><?=impF($ob_reporte->fecha_matricula);?><? } ?><br />
_______________________________</td>

  </tr>
  <tr>
    <td>FECHA RETIRO </td>
    <td>_______________________________</td>
  </tr>
  <tr>
    <td>MOTIVO RETIRO </td>
    <td>_____________________________________________________________</td>
  </tr>
  
</table>
<br />
<?
echo "<H1 class=SaltoDePagina></H1>";

 } ?>
</body>
</html>

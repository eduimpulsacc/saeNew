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
		
		 $sql2="select c.grado_curso,c.letra_curso,c.ensenanza,p.situacion_final,
		p.rut_alumno
		from promocion as p
		inner join curso as c on p.id_curso=c.id_curso
		where p.rut_alumno=".$fila_alu['rut_alumno']." and p.situacion_final=2";
		$rs_rep=pg_exec($conn,$sql2)or die("fallo");
		$fila_rep=pg_fetch_array($rs_rep,$i);
		$grador=$fila_rep['grado_curso'];
		$ensenanzar=$fila_rep['letra_curso'];
		$letrar=$fila_rep['ensenanza'];
		
		if($grador < 8 and $ensenanzar==110){
			$grado_newr  = $grador + 1 ;
			$nivelr = "Básico";
		}elseif($grador==8){
			$grado_newr = 1;
			$nivelr = "Medio ";
		}elseif($grador < 4 and $ensenanzar > 110){
			$grado_newr = $grador + 1;
			$nivelr = "Medio ";
		}elseif($ensenanzar==10 and $grador==4){
			$grado_newr = "Kinder ";
			$nivelr = "Parvulo ";
		}elseif($ensenanzar==10 and $grador==5){
			$grado_newr = "1 ";
			$nivelr = "Básico";
		}
		
$qry= "select * from matricula where matricula.rut_alumno=".$fila_alu['rut_alumno']." and matricula.id_ano=".$ano;
	$resultado=pg_exec($conn,$qry)or die("algo fallo".$qry);
	$filabeca=pg_fetch_array($resultado,$i);
	$becaJunaeb=$filabeca['bool_baj'];
	$centropadres=$filabeca['bool_cpadre'];
	$seguro=$filabeca['bool_seg'];
	$otras=$filabeca['bool_otros'];
	$bchiles=$filabeca['bool_bchs'];
	$municipio=$filabeca['bool_mun'];
	$sep=$filabeca['ben_sep'];
	$fci=$filabeca['ben_fci'];
	$condicional=$filabeca['condicionalidad'];
	
	if($condicional=="" or $condicional==0){
		  $condicional="-"; 
		  }
	  if($condicional==1){
		  $condicional="Rendimiento"; 
		  }
	  if($condicional==2){
		  $condicional="disciplina"; 
		  }	  
	  if($condicional==3){
		  $condicional="otro"; 
		  }	  
	   if($condicional==4){
		  $condicional="observaciones"; 
		  }	  	  
	
if($becaJunaeb==1){ 
 $becaJunaeb="Beca Junaeb "."SI";
}else{
	$becaJunaeb="";
}
if($centropadres==1){ 
 $centropadres="Centro de Padres "."SI";
}else{
	$centropadres="";
}
if($seguro==1){ 
 $seguro="Seguro "."SI";
}else{
	$seguro="";
}
if($otras==1){ 
 $otras="Otas "."SI";
}else{
	$otras="";
}
if($bchiles==1){ 
 $bchiles="Beca Chile Solidario "."SI";
}else{
	$bchiles="";
}
if($municipio==1){ 
 $municipio="Beca Municipio "."SI";
}else{
	$municipio="";
}
if($sep==1){ 
 $sep="Beca SEP "."SI";
}else{
	$sep="";
}
if($fci==1){ 
 $fci="Financiamiento Compartido "."SI";
}else{
	$fci="";
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
    <td class="textosimple"><? if ($institucion!=1914)if ($institucion!=40251){?><?=$ob_reporte->num_matricula;?><? } ?></td>
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
    <td class="textosimple">NOMBRE</td>
    <td width="45%">&nbsp;<?=$ob_reporte->ape_nombre_alu;?></td>
    <td width="9%" class="textosimple">RUN</td>
    <td width="43%">&nbsp;<?=$ob_reporte->rut_alumno;?></td>
  </tr>
  
  <tr>
    <td class="textosimple">CURSO</td>
    <td width="40%">&nbsp;<?=$grado_new."º ".$letra." ".$nivel;?></td>
    <td width="9%" class="textosimple">SEXO</td>
    <td width="43%">&nbsp;<?=$ob_reporte->sexo;?></td>
  </tr>
  
  <tr>
    <td class="textosimple">RELIGION</td>
    <td width="40%">&nbsp;<?=$ob_reporte->religion;?></td>
    <td width="9%" class="textosimple">SISTEMA&nbsp;SALUD</td>
    <td width="43%">&nbsp;<?=$ob_reporte->salud;?></td>
  </tr>
  
   <tr>
    <td class="textosimple">FECHA</td>
    <td width="40%">&nbsp;<? impF($ob_reporte->fecha_nacimiento);?></td>
    <td width="9%" class="textosimple">DOMICILIO</td>
    <td width="43%">&nbsp;<?=$ob_reporte->direccion_alu;?></td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="40%">&nbsp;<?=$ob_reporte->comuna;?></td>
    <td width="9%" class="textosimple">TELEFONO</td>
    <td width="43%">&nbsp;<?=$ob_reporte->telefono_alu;?></td>
  </tr>
   <tr>
    <td class="textosimple">PROBLEMAS&nbsp;DE&nbsp;SALUD</td>
    <td width="40%">&nbsp;<? echo"-";?></td>
    <td width="9%" class="textosimple">CURSOS&nbsp;REPETIDOS</td>
    <td width="43%">&nbsp;<?=$grado_newr." ".$letrar." ".$nivelr;?></td>
  </tr>
  <tr>
    <td class="textosimple">CONDICIONALIDAD </td>
    <td  colspan="3">&nbsp;<? echo $condicional?></td>
  </tr>
  <tr>
    <td class="textosimple">BECAS </td>
    <td  colspan="3">&nbsp;<?=$becaJunaeb."- ".$centropadres."- ".$seguro."- ".$otras."- ".$bchiles."- ".$municipio."- ".$sep."- ".$fci;?></td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td  colspan="3">&nbsp;</td>
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
    <td width="162" class="textosimple">RUN</td>
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
    <td width="149">&nbsp;<?=$ob_reporte->direccion;?></td>
    <td width="81" class="textosimple">LUGAR&nbsp;DE&nbsp;TRABAJO</td>
    <td width="218">&nbsp;<? echo"-";?></td>
  </tr>
  
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="149">&nbsp;<?=$ob_reporte->comuna_apo;?></td>
    <td width="81" class="textosimple">TELEFONO</td>
    <td width="218">&nbsp;<?=$ob_reporte->telefono_apo;?></td>
  </tr>
  
  <tr>
    <td class="textosimple">APODERADO&nbsp;SUPLENTE</td>
    <td colspan="3">&nbsp;<? echo"-";?></td>
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
    <td colspan="4"><div align="center">DATOS MADRE </div></td>
  </tr>
  <tr>
    <td width="160" class="textosimple">RUN MADRE </td>
    <td width="464" colspan="3">&nbsp;<?=$fila_madre['rut_apo']."-".$fila_madre['dig_rut'];?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE MADRE </td>
    <td colspan="3">&nbsp;<?=$fila_madre['nombre_apo']." ".$fila_madre['ape_pat']." ".$fila_madre['ape_mat'];?></td>
  </tr>
  <tr>
    <td class="textosimple">PROFECION&nbsp;U&nbsp;OFICIO </td>
    <td colspan="3">&nbsp;<?=$fila_madre['profesion
	'];?></td>
  </tr>
  
   <tr>
    <td class="textosimple">DOMICILIO</td>
    <td width="149">&nbsp;<?=$ob_reporte->direccion;?></td>
    <td width="81" class="textosimple">LUGAR&nbsp;DE&nbsp;TRABAJO</td>
    <td width="218">&nbsp;<? echo"-";?></td>
  </tr>
  
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="149">&nbsp;<?=$ob_reporte->comuna_apo;?></td>
    <td width="81" class="textosimple">TELEFONO</td>
    <td width="218">&nbsp;<?=$ob_reporte->telefono_apo;?></td>
  </tr>
  
  <tr>
    <td class="textosimple">APODERADO&nbsp;SUPLENTE</td>
    <td colspan="3">&nbsp;<? echo"-";?></td>
  </tr>
</table>
<br /><? if ($institucion==1756) if ($institucion==1914){?>  
  <table width="650" border="0" align="center" cellpadding="1">
   <tr>
     <td colspan="3"><div align="center">&quot;Problema de salud significativo&quot; </div></td>
   </tr>
   <tr>
     <td colspan="3">Declaro conocer todas las disposiciones   del Reglamento Interno del   Establecimiento y me comprometo a asistir a   reuniones mensuales y a   cualquier citaci&oacute;n que efect&uacute;e el colegio&quot; </td>
   </tr>
   <tr>
     <td width="159">Autoriza   Relig&iacute;on</td>
     <td width="65">SI</td>
     <td width="420">NO</td>
   </tr>
</table>
 <? }?>
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

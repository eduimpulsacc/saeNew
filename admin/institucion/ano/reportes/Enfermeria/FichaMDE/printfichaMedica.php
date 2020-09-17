<?php require('../../../../../../util/header.inc');

include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');



	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	 $reporte		=$c_reporte;
	$fecha_ini=$fecha_ini;
	$fecha_fin = $fecha_fin;
	$alumno = $cmbALUMNO;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
			  


$ob_reporte->ano=$ano;
$ob_reporte->curso = $cmb_curso;

if ($alumno==0){
	
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$ob_reporte ->orden =1;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
		
	}else{
		$ob_reporte ->alumno =$cmbALUMNO;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	
	$cont_alumnos = @pg_numrows($result_alu);


$Curso_pal = CursoPalabra($curso, 0, $conn);

?>
<?
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	
	
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
?>


<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title><?php echo ($institucion==31392)?"Clinical student's file":"Ficha m&eacute;dica" ?></title>
<STYLE>
  H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;
 }
.textoverital{writing-mode: tb-rl;filter: flipv fliph;}

.rojo{color:red;}
.azul{color:black;}
</style>
</head>
<!--onLoad="window.print()"-->
<body >
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
   
  </tr>
</table>
</div>

<br />
<?php for($i=0;$i<$cont_alumnos;$i++){
	$fila = @pg_fetch_array($result_alu,$i);
	$ob_reporte->alumno = $fila['rut_alumno'];
	$rs_ficha = $ob_reporte->fichaMedica($conn);
	$ficha = pg_fetch_array($rs_ficha,0);	
	
	?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center">
				<?	
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
				
					if($institucion!=""){
						echo "<img src='../../../../../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					}else{
						echo "<img src='../../../../../../".$d."menu/imag/logo.gif' >";
					}
				?>
		</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
<br />
<table width="650" border="0" cellpadding="0" align="center" class="textosimple">
  <tr>
    <td colspan="2" class="tableindex" style="text-align:center"><?php echo ($institucion==31392)?"Clinical student's file":"Ficha m&eacute;dica" ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="301">Nombre completo del Alumno(a)</td>
    <td width="341"><strong>
      <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
    </strong></td>
  </tr>
  <tr>
    <td>Curso del alumno(a)</td>
    <td><strong><? echo $Curso_pal; ?></strong></td>
  </tr>
  <tr>
    <td>Fecha de Nacimiento</td>
    <td><strong><? echo CambioFD($fila['fecha_nac']); ?></strong></td>
  </tr>
  <tr>
    <td>Rut del Alumno(a)</td>
    <td><strong>
      <? $rut_alumno = trim($fila['rut_alumno'])."-".trim($fila['dig_rut']);
	  echo $rut_alumno  ?>
    </strong></td>
  </tr>
  <tr>
    <td>Edad del alumno(a)</td>
    <td><strong><? echo edad($fila['fecha_nac']); ?> a&ntilde;os</strong></td>
  </tr>
  <tr>
    <td>Domicilio del alumno(a)</td>
    <td><strong>
      <? $rut_alumno = trim($fila['calle'])." ".trim($fila['nro']);
	  echo $rut_alumno  ?>
    </strong></td>
  </tr>
  <tr>
    <td>Tel&eacute;fonos de contacto en caso de emergencia</td>
    <td><strong><? echo $fila['telefono']; ?></strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <?php 
 $rs_padre=$ob_reporte->Padre($conn);
   
    $fila_padre = @pg_fetch_array($rs_padre,0);
	
		$ob_reporte->CambiaDatoApo($fila_padre);
		
		
		$nombre_padre    = $fila_padre['nombre_apo'];
		$paterno_padre   = $fila_padre['ape_pat'];
		$materno_padre   = $fila_padre['ape_mat'];
		
		  
		
   
   
   ?>
   <?php 
 $rs_madre=$ob_reporte->Madre($conn);
   
    $fila_madre = @pg_fetch_array($rs_madre,0);
	
		$ob_reporte->CambiaDatoApo($fila_madre);
		
		
		$nombre_madre    = $fila_madre['nombre_apo'];
		$paterno_madre   = $fila_madre['ape_pat'];
		$materno_madre   = $fila_madre['ape_mat'];
		
		
		
				
		
		
   
   
   ?>
  <tr>
    <td>Nombre de la mam&aacute; </td>
    <td><strong><?php echo $paterno_madre." ".$materno_madre." ".$nombre_madre ?></strong></td>
  </tr>
  <tr>
    <td>Nombre del pap&aacute;</td>
    <td><strong><?php echo $paterno_padre." ".$materno_padre." ".$nombre_padre ?></strong></td><td width="0"></td>
  </tr>
  <? 	
	$ob_reporte->responsable=0;
	$ob_reporte->suplente=0;
	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable=1;
	$rs_apoderado = $ob_reporte->Apoderado($conn);
	$fila_apo = pg_fetch_array($rs_apoderado,0);
	$ob_reporte->CambiaDatoApo($fila_apo);
?>
  <tr>
    <td>Nombre apoderado</td>
    <td><strong>
      <?=strtoupper($ob_reporte->ape_nombre_apo);?>
    </strong></td>
  </tr>
  <tr>
    <td>Mail del apoderado</td>
    <td><strong>
      <?=$ob_reporte->email_apo;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">El alumno cuenta con seguro escolar. Si fuera as&iacute; mencionar cu&aacute;l</td>
  </tr>
  <tr>
    <td colspan="2"><strong><?php echo $ficha['txt_seguropart'] ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Autoriza a la medici&oacute;n de ANTROPOMETR&Iacute;A (peso, talla) del alumno(a) dos veces al a&ntilde;o </td>
    <td><strong><?php echo ($fila['medicion_antropometrica']==1)?"SI":"NO" ?>&nbsp;</strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>El alumno posee contraindicaciones cl&iacute;nicas para realizar actividad f&iacute;sica en el colegio</td>
    <td><strong><? echo (strlen($fila['fisica'])>0)?"SI":"NO";?></strong></td>
  </tr>
  <tr>
    <td colspan="2">Si fuera as&iacute; mencional cu&aacute;l</td>
  </tr>
  <tr>
    <td colspan="2"><span class="cuadro01"><? echo $fila['fisica'];?></span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
    <td>Grupo sangu&iacute;neo del alumno(a)</td>
    <td><?php echo $ficha['txt_sangre'] ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
    <td>El alumno presenta alguna enfermedad cr&oacute;nica. </td>
    <td><b><? echo (strlen($fila['enfermedad'])>0)?"SI":"NO";?></b></td>
  </tr>
  <tr>
    <td colspan="2">Si fuera as&iacute; mencione cu&aacute;l</td>
  </tr>
  <tr>
    <td colspan="2"><span class="cuadro01"><? echo $fila['enfermedad'];?></span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Familiares con problemas de salud o discapacidad diganosticada</td>
    <td><b><? echo (strlen($fila['bool_famenfermo'])==1)?"SI":"NO";?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
 
  <tr>
    <td>&iquest;El alumno(a) posee alg&uacute;n tipo de alergia?</td>
    <td><b><? echo (strlen($fila['alergia'])>0)?"SI":"NO";?></b></td>
  </tr>
  <tr>
    <td colspan="2">Si fuera as&iacute;, Mencione y cu&aacute;l es su tratamiento</td>
  </tr>
  <tr>
    <td colspan="2"><b><?php echo $fila['alergia'] ?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Cu&aacute;l es la enfermedad m&aacute;s recurrente de su hijo durante el a&ntilde;o escolar, ej: gripe, amigdalitis, etc</td>
  </tr>
  <tr>
    <td colspan="2"><b><?php echo $ficha['enf_recurrente'] ?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Cu&aacute;les son los medicamentos m&aacute;s comunes que toma su hijo(a)</td>
  </tr>
  <tr>
    <td colspan="2"><b><?php echo $ficha['med_recurrente'] ?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Su hijo(a) ha tenido p&eacute;rdida de conciencia por m&aacute;s de tres minutos</td>
    <td><b><?php echo ($ficha['bool_desmayo3m']==1)?"SI":"NO" ?></b></td>
  </tr>
 
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>  
  </table>
  <h1 class="SaltoDePagina"></h1>
<table width="650" border="0" cellpadding="0" align="center" class="textosimple">
  <tr>
    <td width="302">Su hijo sufre alg&uacute;n trastorno del sue&ntilde;o</td>
    <td width="342"><b><?php echo ($ficha['trastorno_sueno']==1)?"SI":"NO" ?></b></td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Su hijo cuenta con todas las vacunas impuestas por el Ministerio de Salud</td>
    <td><strong><? echo (strlen($fila['vacunas_ministeriales'])==1)?"SI":"NO";?></strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
 
  <tr>
    <td colspan="2">Autoriza a que si hijo(a) pueda ser atendido en la unidad de enfermeria del colegio en caso de requerir atenci&oacute;n primacia (solo ciudados b&aacute;sicos) por ca&iacute;da, golpe o dolor que le impida estar en clases, durante su jornada escolar </td>
  </tr>
  <tr>
    <td colspan="2"><? echo (strlen($fila['aut_enfermeria'])==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Informaci&oacute;n que desee agregar</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $ficha['observaciones'] ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="right"><p>&nbsp;</p>
      <p>&nbsp;</p>
    <p>FIRMA APODERADO</p></td>
  </tr>
</table>

<br /><br />

 <?php  
		
		 if($cont_alumnos>1){
 ?>
 <h1 class="SaltoDePagina"></h1>
<?php 
		 }
}?>
</body>
</html>

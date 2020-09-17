<?php 

require('../../../../../../util/header.inc');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Reporte.php');


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
	$reporte		=$c_reporte;
	$curso 			=$c_curso;
	
	
		//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
		$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();	 
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
	$qry="SELECT * FROM institucion WHERE rdb=".$_INSTIT;
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);}
?>
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
<?php
	if($frmModo!="ingresar"){
		 $qry="SELECT alumno.*, curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, matricula.num_mat FROM (tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ON curso.id_curso = matricula.id_curso WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)=".$alumno."))";

		$result =@pg_Exec($conn,$qry) or die($sql);
		if (!$result)
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		else
			if (pg_numrows($result)!=0)
				$fila = @pg_fetch_array($result,0);	
	};
?>

<?

$qryC = "SELECT cod_decreto, grado_curso, letra_curso, nombre_tipo, curso.id_curso FROM ((curso INNER JOIN matricula ON curso.id_curso=matricula.id_curso) INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza) WHERE matricula.rut_alumno=".$fila["rut_alumno"]." and matricula.id_ano=".$ano; 
$resultC =@pg_Exec($conn,$qryC);
$filaC = @pg_fetch_array($resultC,0); 
?>



<HTML>
	<HEAD>
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
		<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
    <style type="text/css">
    .dd {
	text-align: center;
}
    </style>
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
 font-size:<?=$ob_config->tamanoS + 6;?>px;
 }

.Estilo1 {font-family: "Arial Narrow"}
.Estilo2 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.Estilo3 {font-size: 10}
.Estilo4 {font-size: 10px}
.Estilo6{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
	font-style:italic;
	color:#666666;
}
.Estilo5 {
	font-family: "Times New Roman", Times, serif;
	font-size: 36px;
	font-style: italic;
}
</style>
	</HEAD>
<body >
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr align="center">
      <td align="right">
      <div id="capa0">
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
     <input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR">
	  </div></td>
    </tr>
</table>
							<br>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <div align="center">
      <?	
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
			
			if($institucion!=""){
			echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			}else{
			echo "<img src='".$d."menu/imag/logo.gif' >";
			}
			?>
    </div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo ucwords(strtolower($ob_membrete->ins_pal));?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center" class="Estilo6"><? echo $ob_reporte->tilde(ucwords(strtolower($ob_membrete->direccion)));?></div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo "Fono: ".$ob_membrete->telefono;?><? echo($institucion!=1603 && $institucion!=1717)? "   Fax: ".$ob_membrete->fax:"";?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo3"><div align="center"><em><font color="#666666"><? echo "e-mail: ".$ob_membrete->email;?></font></em></div></td>
  </tr>
   <tr>
    <td class="Estilo3"><div align="center"><em><font color="#666666">Rol Base de datos: 
											   <? echo trim($fila1['rdb']);?>- <?php 
											   echo trim($fila1['dig_rdb']);?></font></em></div></td>
  </tr>
  
</table>
<br>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center" class="Estilo5">CERTIFICADO DE MATR&Iacute;CULA</div></td>
  </tr>
</table>
<br>
<br>

<?php
																$qry3="SELECT * from ano_escolar where id_ano=".$_ANO;
																$result3 =@pg_Exec($conn,$qry3);
																$fila3 = @pg_fetch_array($result3,0);	
															?>
															
															<?php
																$qry4="SELECT COUNT(*) from matricula where id_ano=".$_ANO;
																$result4 =@pg_Exec($conn,$qry4);
																$fila4 = @pg_fetch_array($result4,0);	
															?>
<table width="650" border="0" align="center" cellpadding="0" class="subitem" style="font-size:20px;">
  <tr>
    <td ><em>
      <p style="line-height:200%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El presente documento certifica, que el alumno (a) <b><?php
														$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
														$result =@pg_Exec($conn,$qry);
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
														}
													?> </b>se encuentra matriculado en el establecimiento educacional, cursando actualmente  
															<!--<? if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
															$grado="PRIMER NIVEL";
														}else if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==121987) or ($filaC['cod_decreto']==1521989)) ){
															$grado="PRIMER CICLO";
														}else if ( ($filaC['grado_curso']==1) and ($filaC['cod_decreto']==1000)){
															$grado="SALA CUNA";
														}else if ( ($filaC['grado_curso']==2) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
															$grado="SEGUNDO NIVEL";
														}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==121987) ){
															$grado="SEGUNDO CICLO";
														}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==1000)){
															$grado="NIVEL MEDIO MENOR";
														}else if ( ($filaC['grado_curso']==3) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
															$grado="TERCER NIVEL";
														}else if ( ($filaC['grado_curso']==3) and ($filaC['cod_decreto']==1000)){
															$grado="NIVEL MEDIO MAYOR";
														}else if ( ($fila1['grado_curso']==4) and ($filaC['cod_decreto']==1000)){
																  
														}else if ( ($filaC['grado_curso']==5) and ($filaC['cod_decreto']==1000)){
															 
														}else{
															$grado=$filaC['grado_curso'];
														}
														
																												
														if ($filaC['grado_curso']==4 and ($_INSTIT==1230 or $_INSTIT==1593) and ($filaC['cod_decreto']==1000)){
														   $grado = "PRE-KINDER";
														}
														
														if ($filaC['grado_curso']==5 and ($_INSTIT==1230 or $_INSTIT==1593) and ($filaC['cod_decreto']==1000)){
														    $grado = "KINDER";
														}
	
																											
														
														
										if ($_INSTIT==1230 or $_INSTIT==1593 and ($filaC['cod_decreto']==1000)){				
										     imp($grado." de ".$filaC["nombre_tipo"]);
										}else{
										     imp($grado."-".$filaC["letra_curso"]." ".$filaC["nombre_tipo"]);
										}	 
										echo "<input type=hidden name=curso value=".$filaC['id_curso'].">";
										?>--><?php echo CursoPalabra($filaC['id_curso'],4,$conn) ?> del año <?php echo trim($fila3['nro_ano'])?>. </STRONG>
	</p>
      <BR>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se extiende el presente certificado de matricula a petición del interesado para los fines que estime conveniente.</em></td>
  </tr>
</table>
	<br>
<br>
<?php  

		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>																							
<br>
<br>
<table width="600" height="43" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? //  $fecha = $txtFECHA;
	
	$fecha = date("d-m-Y"); 
	$txf = fecha_espanol($fecha);
	 ?>
    <td width="%" align="<?=$opc_fecha;?>"><em><font face="Arial, Helvetica, sans-serif" size="-1"><? echo trim($ob_membrete->comuna) .", ".$txf?></font></em></td>
  </tr>
</table>
<br>															
</BODY>
</HTML>
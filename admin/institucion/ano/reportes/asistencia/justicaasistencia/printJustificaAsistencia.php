<?php 

require_once('../../../../../../util/header.inc');
include('../../../../../clases/class_Membrete.php');
require('../../../../../clases/class_Reporte.php');


$institucion = $_INSTIT;
$reporte = $c_reporte;

$getCurso = $_POST['select_curso'];
$getAno = $_POST['select_anos'];
$mes = $_POST['select_mes'];

$ob_reporte = new Reporte();
$ob_config = new Reporte();


$ob_config->id_item=$reporte;
$ob_config->institucion=$institucion;
$ob_config->curso=$getCurso;
$rs_config = $ob_config->ConfiguraReporte($conn);
$fila_config = @pg_fetch_array($rs_config,0);
$ob_config->CambiaDatoReporte($fila_config);
$fechaNow =$ob_reporte->fecha_actual();


$obj_m = new Membrete();
$obj_m ->institucion=$institucion;
$obj_m ->institucion($conn);




$fecha=getdate();
$diaActual=$fecha["mday"];

				if ($mes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if(($mes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if($mes==1){ 
						$diaFinal=31; 
						$mesDate="01";
					}
					if($mes==2){ 
						$mesDate="02";
					}
					if($mes==3){ 
						$diaFinal=31; 
						$mesDate="03";
					}
					if($mes==4){ 
						$diaFinal=30; 
						$mesDate="04";
					}
					if($mes==5){ 
						$diaFinal=31; 
						$mesDate="05";
					}
					if($mes==6){ 
						$diaFinal=30; 
						$mesDate="06";
					}
					if($mes==7){ 
						$diaFinal=31; 
						$mesDate="07";
					}
					if($mes==8){ 
						$diaFinal=31; 
						$mesDate="08";
					}
					if($mes==9){ 
						$diaFinal=30; 
						$mesDate="09";
					}
					if($mes==10){ 
						$diaFinal=31; 
						$mesDate="10";
					}
					if($mes==11){ 
						$diaFinal=30; 
						$mesDate="11";
					}
					if($mes==12){ 
						$diaFinal=31; 
						$mesDate="12";
					}
					//FIN AJUSTA
				}


	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$getCurso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) ";
	$qry = $qry . "ORDER BY ape_pat,ape_mat,nombre_alu asc";
	$res_alu = pg_Exec($conn, $qry);
	$tot_alum = pg_numrows($res_alu);


	$qry_ano = "select * from ANO_ESCOLAR where id_ano = '$getAno'";
	$res_ano = pg_Exec($conn, $qry_ano);
	$fila_ano = pg_fetch_array($res_ano);
	$fila_ano['nro_ano'];

	
	$fecha_ini = $fila_ano['nro_ano']."-".$mesDate."-"."01";
	$fecha_fin = $fila_ano['nro_ano']."-".$mesDate."-".$diaFinal;



if ($mes == 1) {
	$mes = 'Enero';
}else if ($mes == 2) {
	$mes = 'Febrero';
}else if ($mes == 3) {
	$mes = 'Marzo';
}else if ($mes == 4) {
	$mes = 'Abril';
}else if ($mes == 5) {
	$mes = 'Mayo';
}else if ($mes == 6) {
	$mes = 'Junio';
}else if ($mes == 7) {
	$mes = 'Julio';
}else if ($mes == 8) {
	$mes = 'Agosto';
}else if ($mes == 9) {
	$mes = 'Septiembre';
}else if ($mes == 10) {
	$mes = 'Octubre';
}else if ($mes == 11) {
	$mes = 'Noviembre';
}else if ($mes == 12) {
	$mes = 'Diciembre';
}

$curso = CursoPalabra($getCurso, 1, $conn);



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 #tableIndex{
		FONT-WEIGHT: bold;
    	TEXT-INDENT: 5px;
    	BACKGROUND-REPEAT: repeat-x;
    	HEIGHT: 39px;
    	BACKGROUND-COLOR: #414458;
    	TEXT-ALIGN: center;
    	TEXT-DECORATION: none;
 }
 .titulo
 {
 color: #fff;
 font-family:<?= $ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?= $ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>


<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function exportar(){
		//	window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
}	  
		  
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="">
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">

      </td>
    </tr>
  </table>
</div>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
		    <td width="487" class="item"><strong><? echo strtoupper(trim($obj_m->ins_pal));?></strong></td>
		    <td width="11">&nbsp;</td>
		    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
		      <tr valign="top" >
		        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c&oacute;digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."../../menu/imag/logo.gif' >";
	  }?></td>
	          </tr>
		      </table></td>
	      </tr>
		  <tr>
		    <td class="item"><? echo ucwords(strtolower($obj_m->direccion));?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($obj_m->telefono));?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td height="41">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
  </table>
		<br>
		<table width="650" align="center">
		<tr>
			<td id="tableIndex" width="100%" align="center" class="titulo"><strong>JUSTIFICAR INASISTENCIA<strong></td>
		</tr>
	</table>
	<table width="650" align="center">
		<tr>
			<td width="80%">
				<table width="100%">
					<tr with="100%">
						<td width="5%" class="item">
							Curso:
						</td>
						<td width="65%" class="item">
							<?php echo $curso ?>
						</td>
						<td align="center" width="5%">
							<img src="../../../curso/asistencia/vb.gif">				
						</td>
						<td width="45%" class="item">
							<span>Justificados</span>
						</td>
					</tr>
					<tr>
						<td width="5%" class="item">
							Mes: 
						</td>
						<td width="65%" class="item">
							<?php echo $mes ?>
						</td>
						<td align="center" width="5%">
							<img src="../../../curso/asistencia/b_drop.png">
						</td>
						<td class="item">
							<span>No justificados</span>
						</td>
					</tr>
					<tr>
						<td width="5%" class="item">
							A&ntilde;o:
						</td>
						<td width="20%" class="item">
							<?php echo $fila_ano['nro_ano'] ?>
						</td>
						<td align="center" bgcolor="#cccccc" width="5%">
							N&deg;
						</td>
						<td width="20%" class="item">
							<span>D&iacute;a de la inasistencia</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
<table border="1" width="650" align="center">
<?php  

	$msj = false;

  

	for($xa=0; $xa < $tot_alum; $xa++){
		$alumnos = pg_fetch_array($res_alu);
		$rut_alumno = $alumnos['rut_alumno'];
		 

		$qry2 = "SELECT * FROM asistencia WHERE id_curso = $getCurso AND rut_alumno = '$rut_alumno' AND ano = '$getAno' AND fecha >= '$fecha_ini' AND fecha <= '$fecha_fin' ORDER BY rut_alumno";
		$res2 = @pg_Exec($qry2);		
		if(@pg_numrows($res2)!=0){
		$msj = true; ?>
			<tr>			
				<td class="subitem"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><?=trim($alumnos['ape_pat'])." ".trim($alumnos['ape_mat']).", ".trim($alumnos['nombre_alu'])?> <?=$rut_alumno ?></font></td>
<?php			for($z=0;$z<pg_numrows($res2);$z++){
				$fila_inasistencia = pg_fetch_array($res2,$z);
				$fech_inasist = $fila_inasistencia['fecha'];
				$separa = explode("-",$fech_inasist);

				$qry3 = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = '$rut_alumno' AND ano = '$getAno' AND id_curso = $getCurso AND fecha = '$fech_inasist'";
				$res3 = pg_Exec($qry3);
				 pg_numrows($res3);
				?>
					<td align="center" width="40" bgcolor="#cccccc" class="subitem"><?=$separa[2]?><br>
						<?php if(pg_numrows($res3)==0){?>
							<img src="../../../curso/asistencia/b_drop.png">
						<?php }else{?>
							<img src="../../../curso/asistencia/vb.gif">
						<?php }?>						
					</td>
			
		<?php 		
			} ?>
			</tr>
<?php		}
	}	?>		
</table>

<? if($msj==false){?>
<br><br><br><br>
	<DIV align="center" style="FONT-WEIGHT: bold;
    FONT-SIZE: 11px;
    COLOR: #999999;
    FONT-STYLE: normal;
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    TEXT-DECORATION: none;">NO SE REGISTRAN INASISTENCIAS</DIV>
<? } ?>



<br>
<?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 $concur=0;
		 include("../../firmas/firmas.php");?>
 <table width="650" border="0" align="center">
   <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<div align="center" class="item"><?=$fechaNow;?></div>
</form>
	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	?>
   
</body>
</html>
<? pg_close($conn);?>
 

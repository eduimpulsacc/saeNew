<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	
	$_POSP = 4;
	$_bot = 8;
	
    $institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$alumno			= $c_alumno;	
	$reporte		= $c_reporte;
	$periodo 		= split(",",$cmbPERIODO);

if ($curso>0){
	$Curso_pal = CursoPalabra($curso, 1, $conn);
	$fecha = date("d m Y");
}

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
   /*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
	/*************** AÑO ESCOLAR ******************/
	$ob_membrete ->ano=$ano;
	$ob_membrete ->anoescolar($conn);
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

	$qry_url = "select * from salida where rdb = '$institucion'";
    $result_2 =pg_Exec($conn,$qry_url);
    $fila_1 = @pg_fetch_array($result_2,0);	
	$web = $fila_1['direccion'];


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Carta_apoderados_$fecha_actual.xls"); 	 
}	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
			window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }		  
		  
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 

<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="printCartaApoderado_C.php" target="_blank">
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
										<? }?>
	  
      </td>
    </tr>
  </table>
</div>
<?
if ($alumno==0){
    $ob_reporte ->cmb_curso = $c_curso;
	$rs = $ob_reporte ->TraeTodosAlumnos($conn);
}else{
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$rs = $ob_reporte ->TraeUnAlumno($conn);
}
?>

<?
$ns = @pg_numrows($rs);
$i=0;
while ($i < $ns){
	$fs = @pg_fetch_array($rs,$i);
	$ob_reporte ->CambiaDatoApo($fs);
	$rut_apo =  $fs['rut_apo']; 
	
    ?>	
	<table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
	  <tr>
		<td align="left">
		
		
	<? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
		   
	  }else{
		
		    ?>
	<? } ?>	
		
		
		
		<?
				
		//// aqui tomo los datos del alumno
		if($alumno==0){
			$sql="select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb=$_INSTIT AND id_ano=$ano and id_curso=$curso and bool_ar=0 and rut_alumno in ( select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."'))";
		}else{
			$sql="select * from alumno where rut_alumno=".$alumno;
		//$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno and alumno.rut_alumno = '".trim($cmb_alumno)."'";
		}	
		
		$result= @pg_Exec($conn,$sql);
		$fila =  @pg_fetch_array($result,0);
		$nombre_alumno  = $fila['ape_pat'];
		$nombre_alumno .= $fila['ape_mat'];
		$nombre_alumno .= $fila['nombre_alu'];
		
		/// fin nombre del alumno
	    		
		/// ahora debo tomar los datos de acceso
		$sq1 = "select * from usuario where nombre_usuario = '".trim($rut_apo)."'";
		$rq1 = pg_Exec($connection,$sq1);
		if (@pg_numrows($rq1)>0){
			 $filasq1 = @pg_fetch_array($rq1,0);
			 $usuario_apoderado = $filasq1['nombre_usuario'];
			 $clave_apoderado   = $filasq1['pw'];
		}
		//// fin datos de acceso del apoderado	
	    ?>
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
			echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
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
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo "Fono: ".$ob_membrete->telefono."   Fax: ".$ob_membrete->fax;?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo3"><div align="center"><em><font color="#666666"><? echo "e-mail: ".$ob_membrete->email;?></font></em></div></td>
  </tr>
  <tr>
    <td><hr color="#666666" style="border-collapse:collapse; height:1px"></td>
  </tr>
</table>
		  <br>
		  <br>
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		      <th align="center" scope="col"><strong><em><u>CERTIFICADO DE ASISTENCIA</u></em></strong></th>
	        </tr>
	      </table>
		  <br>
		  <br>
		  <br>
		  <p><em>Certifico que el alumno(a),&nbsp; Don(a)<?=$nombre_alumno ?> asiste al <?=$Curso_pal;?>,&nbsp; y  su </em>		  <em> porcentaje de asistencia  del a&ntilde;o <? echo $nro_ano =$ob_membrete->nro_ano - 1;?> y actual,&nbsp; es la siguiente:</em></p>
		  <p>&nbsp;</p>
		  <table width="50%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		      <th width="56%" align="left" scope="col"><strong>ASISTENCIA <? echo $nro_ano =$ob_membrete->nro_ano - 1;?> :</strong></th>
              <? 	
			  		$nro_ano_ant = $ob_membrete->nro_ano - 1;
			  		$sql="select ae.id_ano,id_curso,rdb from matricula m INNER JOIN ano_escolar ae ON m.id_ano=ae.id_ano WHERE nro_ano=".$nro_ano_ant." AND rut_alumno=".$alumno;
					$result =pg_exec($conn,$sql);
					$ano_ant = pg_result($result,0);
					$curso_ant = pg_result($result,1);
					$rdb = pg_result($result,2);

			  		$ob_reporte->curso=$curso_ant;
			  		$ob_reporte->ano=$ano_ant;
					$ob_reporte->institucion=$rdb;
					$ob_reporte->alumno=$alumno;
					$rs_promocion = $ob_reporte->Promocion($conn);
					$fila_asistencia = pg_fetch_array($rs_promocion,0);
					
				?>
		      <th width="44%" align="center"><? echo $fila_asistencia['asistencia'];?>%&nbsp;</th>
	        </tr>
		    <tr>
		      <td><strong><em><?=$periodo[1];?>:</em></strong></td>
              
              <? 	$ob_reporte->periodo=$periodo[0];
			  		$ob_reporte->Periodo($conn);
					$dias_habiles = $ob_reporte->dias_habiles;
					
					$ob_reporte->ano=$ano;
					$ob_reporte->alumno=$alumno;
					$ob_reporte->fecha_inicio=$ob_reporte->fecha_inicio;
					$ob_reporte->fecha_termino=$ob_reporte->fecha_termino;
					$rs_periodo = $ob_reporte->Asistencia($conn);
					
					$porcentaje_asistencia = round((($dias_habiles - pg_numrows($rs_periodo)) * 100) / $dias_habiles);
			?>
                    
		      <td align="center"><strong><? echo $porcentaje_asistencia;?>%</strong></td>
	        </tr>
	      </table>
		  <p><em>Se extiende el presente  documento a petici&oacute;n de la&nbsp; interesada&nbsp; para realizar la postulaci&oacute;n a las becas del  <? echo ucwords(strtolower($ob_membrete->ins_pal));?></em><br>
		    <br>
		    <br>
          </p></td>
	  </tr>
</table>
  <table width="650" border="0" align="center">
		  <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
		</table>
<table width="650" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div  align="left" class="subitem"><?=fecha_espanol($fecha) ?></div></td>
  </tr>
</table>
</form>
	<?
	
	if  ($ns > 1){ 
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	}
	?>
	
    <?
	$i++;
 } ?>

<br>
</body>
</html>
<? pg_close($conn);?>
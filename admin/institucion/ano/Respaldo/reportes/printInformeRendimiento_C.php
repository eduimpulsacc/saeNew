<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte 		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	if ($periodo==0){
	   ## nada
	}else{
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	//----------------------------------------------------------------------------
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0){
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
	}else{
		$sql_curso = "select * from curso where id_curso = ".$curso;
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	
}	
//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Rendimiento_$Fecha.xls"); 
	}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">

			function enviapag2(form){
						form.target="_blank";
						document.form.action='printInformeRendimiento_C.php?cmb_periodos=<?=$periodo?>&c_reporte=<?=$reporte?>&cmb_curso=<?=$curso?>';
						document.form.submit(true);
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeRendimiento.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
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
function cerrar(){ 
window.close() 
} 
</script>
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso == 0){
   ## nada
}else{
   ?>
<form name="form" action="printInformeRendimiento_C.php" method="post">
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	  </tr></table>
      
      </div></td>
  </tr>
</table>
<?
	$cantidad_cursos = @pg_numrows($result_curso);
	
		$fila_curso = @pg_fetch_array($result_curso,0);
		$curso = $fila_curso['id_curso'];
		$Curso_pal = CursoPalabra($curso, 0, $conn);

?>

<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br>";
  }
?>


<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<table width="650" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ ?>
			<td width="119" rowspan="6">
						<?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
			</td>
			<td width="50">&nbsp;</td>
			<td>
	
				<table>
				  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->ins_pal?></strong></font></div></td>
				  </tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->direccion;?></strong></font></div></td>
					</tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->telefono;?></strong></font></div></td>
					</tr>
				</table>
			</td>


	</tr>
</table>
<? } ?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan=3>&nbsp;</td></tr>
  <tr>
    <td colspan=3 class="tableindex"><div align="center">INFORME RENDIMIENTO ESCOLAR POR CURSO</div></td>
    </tr>
  <tr>
    <td colspan=3><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
    </tr>
  <tr>
    <td width="63">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="571">&nbsp;</td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>Profesor</strong></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td class="subitem"><?=$ob_reporte->profe_jefe;?></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>Curso</strong></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td class="subitem"><? echo $Curso_pal;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="item"><div align="left"><strong>Nombre Asignatura</strong></div></td>
    <td width="171" class="item"><div align="left"><strong>Nombre Profesor</strong></div></td>
    <td colspan="2" class="item"><div align="Center"><strong><1 - 3.9></strong></div></td>
    <td colspan="2" class="item"><div align="Center"><strong><4 - 4.9></strong></div></td>
    <td colspan="2" class="item"><div align="Center"><strong><5 - 5.9></strong></div></td>
    <td colspan="2" class="item"><div align="Center"><strong><6 - 7.0></strong></div></td>
    </tr>
	<?
	//----------------------------------------------------------------
	// SUBSECTORES
	//----------------------------------------------------------------
	$ob_reporte ->curso = $curso;
	$ob_reporte ->modo_eval =2;
	$ob_reporte ->SubsectorRamo($conn);
	$result_sub = $ob_reporte->result;
    $cont_gen1 = 0; $cont_gen2 = 0;
    $cont_gen3 = 0; $cont_gen4 = 0;
	for($e=0 ; $e < @pg_numrows($result_sub) ; $e++)
	{
		/****** DATOS SUBSECTOR ***********/
		$fila_sub = @pg_fetch_array($result_sub,$e);
		$ramo = $fila_sub['id_ramo'];
		$subsector_num = $fila_sub['cod_subsector'];
		$subsector_pal = ucwords(strtolower($fila_sub['nombre']));
		$modo_eval = $fila_sub['modo_eval'];
		
		/***** DATOS PROFESOR SUBSECTOR*********/
		$ob_reporte ->ramo = $ramo;
		$ob_reporte ->ProfeSubsector($conn);
		
		
		/****** ALUMNOS INSCRITOS ************/
		$ob_reporte ->nro_ano =$nro_ano;
		$ob_reporte ->ramo =$ramo;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->institucion = $institucion;
		$ob_reporte ->bool_ar =0;
		$result_tiene = $ob_reporte ->AlumnosTiene($conn);
		$Cuenta = 0;
		$rut = 0;
		$con_gen  = 0;
		$con_1 = 0;		$con_2 = 0;
		$con_3 = 0;		$con_4 = 0;
		$porcentaje1=0; $porcentaje2=0;						
		$porcentaje3=0; $porcentaje4=0;	
		
		for($u=0; $u<@pg_numrows($result_tiene); $u++){
			$fila = @pg_fetch_array($result_tiene,$u);
		// NOTAS //
			$ob_reporte ->nro_ano = $nro_ano;
			$ob_reporte ->ramo = $ramo;
			$ob_reporte ->periodo =$periodo;
			$ob_reporte ->rut_alumno =$fila['rut_alumno'];
			$result_notas = $ob_reporte->Notas($conn);
			$fila_notas = @pg_fetch_array($result_notas,0);
			if($rbOPCION==1){
				$prome_1 = $fila_notas['promedio'];
				
				
				
				// consultar si tiene examen semestral 
				$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$ramo." AND id_ano=".$ano." AND periodo=".$periodo." AND rut_alumno=".$fila['rut_alumno'];
				$rs_nota = @pg_exec($conn,$sql);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					$fils_nota = @pg_fetch_array($rs_nota,$jj);
					$nota_ex = $fils_nota['nota'];
					if(pg_numrows($rs_nota)==0){
						$nota_ex="&nbsp;";
					}
					$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
					$rs_porc = @pg_exec($conn,$sql);
					$porc = @pg_result($rs_porc,0);
					$aprox_ex = @pg_result($rs_porc,1);
					$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
				}
				$Prom_ex = ($prome_1 * (100 - $porc))/100;
					
				if($aprox_ex==1){
					$promedio = round($Prom_ex + $nota_porc);
				}else{
					$promedio = intval($Prom_ex + $nota_porc);
				}
				if(pg_numrows($rs_nota)==0){
					$promedio =$prome_1;
				}
				$Prom_ex =0;
				$nota_porc=0;
				//// fin parte de extamen					
				
				
			}else{
				$promedio = $fila_notas['notaap'];
			}
			$Cuenta ++;
			if ($promedio > 0)				{
				$con_gen = $con_gen +1;
				if ($promedio > 0 and  $promedio < 40)
					$con_1 = $con_1  + 1;
				if ($promedio > 39 and  $promedio < 50)
					$con_2 = $con_2  + 1;
				if ($promedio > 49 and  $promedio < 60)
					$con_3 = $con_3  + 1;										
				if ($promedio > 59 and  $promedio < 71)
					$con_4 = $con_4  + 1;
			}
		}
							
		if ($con_1>0)
			$porcentaje1 = round($con_1*100/$con_gen,0) ."";
		else
			$porcentaje1 = "0";
		if ($con_2>0)
			$porcentaje2 = round($con_2*100/$con_gen,0) ."";
		else
			$porcentaje2 = "0";			
		if ($con_3>0)
			$porcentaje3 = round($con_3*100/$con_gen,0) ."";
		else
			$porcentaje3 = "0";
		if ($con_4>0)
			$porcentaje4 = round($con_4*100/$con_gen,0) ."";
		else
			$porcentaje4 = "0";
	$cont_gen1 = $cont_gen1 + $con_1;
	$cont_por1 = $cont_por1 + $porcentaje1;
	$cont_gen2 = $cont_gen2 + $con_2;
	$cont_por2 = $cont_por2 + $porcentaje2;
	$cont_gen3 = $cont_gen3 + $con_3;
	$cont_por3 = $cont_por3 + $porcentaje3;
	$cont_gen4 = $cont_gen4 + $con_4;
	$cont_por4 = $cont_por4 + $porcentaje4;
	?>
  <tr>
    <td width="28" class="subitem"><div align="left"><? echo $subsector_num;?></div></td>
    <td width="208" class="subitem"><div align="left"><? echo $subsector_pal;?></div></td>
    <td class="subitem"><div align="left"><?=$ob_reporte->nombre_ape;?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $con_1; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $porcentaje1."%"; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $con_2; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $porcentaje2."%"; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $con_3; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $porcentaje3."%"; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $con_4; ?></div></td>
    <td width="27" class="subitem"><div align="center"><? echo $porcentaje4."%"; ?></div></td>
  </tr>
  <? } // FIN FOR E ?>
</table>
<br>
<?
$totalnotas = $cont_gen1 + $cont_gen2 + $cont_gen3 + $cont_gen4;
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><div align="left" class="item"><strong>SUMA DE TOTALES:</strong></div>
       </td>
    <td width="29" class="subitem"><div align="center"><? echo $cont_gen1?></div></td>
    <td width="29" class="subitem"><div align="center">
      <? if ($cont_por1>0)echo round($cont_gen1*100/$totalnotas,0)."%"; else echo "0%"?>
    </div></td>
    <td width="29" class="subitem"><div align="center"><? echo $cont_gen2?></div></td>
    <td width="29" class="subitem"><div align="center">
      <? if ($cont_por2>0)echo round($cont_gen2*100/$totalnotas,0)."%"; else echo "0%"?>
    </div></td>
    <td width="29" class="subitem"><div align="center"><? echo $cont_gen3?></div></td>
    <td width="29" class="subitem"><div align="center">
      <? if ($cont_por3>0)echo round($cont_gen3*100/$totalnotas,0)."%"; else echo "0%"?>
    </div></td>
    <td width="29" class="subitem"><div align="center"><? echo $cont_gen4?></div></td>
    <td width="29" class="subitem"><div align="center">
      <? if ($cont_por4>0)echo round($cont_gen4*100/$totalnotas,0)."%"; else echo "0%"?>
    </div></td>
  </tr>
</table>
<table width="650" border="0" align="center">
  <tr>
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
<hr width="100%" color=#003b85>
    </tr>
</table>  
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>
</center>
</form>
<?
}
?>

<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>
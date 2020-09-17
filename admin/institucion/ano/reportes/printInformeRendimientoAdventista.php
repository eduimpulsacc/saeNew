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
	

//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/*if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Rendimiento_$Fecha.xls"); 
	}	*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../clases/highcharts/js/highcharts2.js"></script>
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
  $arr_por['rango'][]="1 - 3.0";
	$arr_por['rango'][]="3.1 - 5.0";
	$arr_por['rango'][]="5.1 - 7.0";
	
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
    <td colspan="2"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Asignatura</strong></font></div></td>
    <td width="171"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Profesor</strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><1 - 3.0></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><3.1 - 5.0></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><5.1 - 7.0></strong></font></div></td>
    </tr>
	<?
	//----------------------------------------------------------------
	// SUBSECTORES
	//----------------------------------------------------------------
	
	
	$sql_sub = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) AND ramo.modo_eval<>2 ORDER BY subsector.cod_subsector; ";
	
	
	
	
	$result_sub = @pg_Exec($conn, $sql_sub);
    $cont_gen1 = 0; $cont_gen2 = 0;
    $cont_gen3 = 0; $cont_gen4 = 0;
	for($e=0 ; $e < @pg_numrows($result_sub) ; $e++)
	{
		// DATOS SUBSECTOR //
		$fila_sub = @pg_fetch_array($result_sub,$e);
		$ramo = $fila_sub['id_ramo'];
		$subsector_num = $fila_sub['cod_subsector'];
		$subsector_pal = ucwords(strtolower($fila_sub['nombre']));
		$modo_eval = $fila_sub['modo_eval'];
		
		// DATOS PROFESOR SUBSECTOR
		$sql_dicta = "SELECT dicta.id_ramo, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_dicta = $sql_dicta . "FROM dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp ";
		$sql_dicta = $sql_dicta . "WHERE (((dicta.id_ramo)=".$ramo.")); ";
		$result_dicta = @pg_Exec($conn, $sql_dicta);
		$fila_dicta = @pg_fetch_array($result_dicta,0);
		$profe_dicta = ucwords(strtolower($fila_dicta['nombre_emp'] . " " . $fila_dicta['ape_pat'] . " " . $fila_dicta['ape_mat']));
		
		$sql_tiene = "SELECT  rut_alumno FROM tiene$nro_ano WHERE id_ramo=$ramo and rut_alumno in (select rut_alumno from matricula where id_ano=$ano and rdb=$institucion and bool_ar=0)";
		$result_tiene = @pg_exec($conn,$sql_tiene);
		$Cuenta = 0;
		$rut = 0;
		for($a=0;$a<@pg_numrows($result_tiene);$a++){
			$fila_tiene= @pg_fetch_array($result_tiene,$a);
			$rut_alumno[$a] = trim($fila_tiene['rut_alumno']);
			$rut++;
		}
		
		for($u=0;$u<$rut;$u++){
		// NOTAS //
		
		if($periodo!=0){
			$sql_notas = "SELECT notas$nro_ano.promedio, notas$nro_ano.id_ramo, notas$nro_ano.id_periodo ";
			$sql_notas = $sql_notas . "FROM notas$nro_ano  ";
			$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.id_ramo)=".$ramo.") AND ((notas$nro_ano.id_periodo)=".$periodo.")) AND (notas$nro_ano.rut_alumno='" . $rut_alumno[$u]."')";
		}else{
			 $sql_notas="SELECT round(avg(cast(notas2017.promedio as INT))) promedio ,count (notas2017.promedio), 
notas2017.id_ramo,
situacion_final.nota_final,
ramo.conex, ramo.conexper,notas2017.rut_alumno, 
round(avg(situacion_periodo.nota_final)) nota_periodo,count (situacion_periodo.nota_final) 
FROM notas2017 
inner join ramo on notas2017.id_ramo=ramo.id_ramo 
left join situacion_final on notas2017.rut_alumno = situacion_final.rut_alumno and ramo.conex=1
left join situacion_periodo on notas2017.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
WHERE notas$nro_ano.id_ramo=".$ramo."
and notas$nro_ano.promedio not in ('MB','B','S','I','EX','0','')
and notas$nro_ano.rut_alumno='".$rut_alumno[$u]."'
group by 3,4,5,6,7";	
			}
			
			
			
			$result_notas = @pg_Exec($conn, $sql_notas);
			$fila_notas = @pg_fetch_array($result_notas,0);
			if($periodo!=0){
			$promedio[$u] = $fila_notas['promedio'];
			}else{
				$conexper=$fila_notas['conexper'];
			 $conex=$fila_notas['conex'];
			 
			 if($conexper==1){
				 $promedio[$u] = $fila_notas['nota_periodo'];
			 }
			 elseif($conex==1){
				 $promedio[$u] = $fila_notas['nota_final'];
			 }
			 else{
				 $promedio[$u] = $fila_notas['promedio'];
			 }	
				
			}
			$Cuenta ++;
		}
		$con_gen  = 0;
		$con_1 = 0;		$con_2 = 0;
		$con_3 = 0;		//$con_4 = 0;
		$porcentaje1=0; $porcentaje2=0;						
		$porcentaje3=0; //$porcentaje4=0;								
		
		for($o=0 ; $o < $Cuenta ; $o++)
		{
			

				if ($promedio[$o]>0)
				{
					$con_gen = $con_gen +1;
					if ($promedio[$o] > 1 and  $promedio[$o] < 30)
						$con_1 = $con_1  + 1;
					if ($promedio[$o] > 31 and  $promedio[$o] < 50)
						$con_2 = $con_2  + 1;
					if ($promedio[$o] > 51 and  $promedio[$o] < 71)
						$con_3 = $con_3  + 1;										
					/*if ($promedio[$o] > 59 and  $promedio[$o] < 71)
						$con_4 = $con_4  + 1;*/
				}
		}// fin for o
							
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
		/*if ($con_4>0)
			$porcentaje4 = round($con_4*100/$con_gen,0) ."";
		else
			$porcentaje4 = "0";*/
	$cont_gen1 = $cont_gen1 + $con_1;
	$cont_por1 = $cont_por1 + $porcentaje1;
	$cont_gen2 = $cont_gen2 + $con_2;
	$cont_por2 = $cont_por2 + $porcentaje2;
	$cont_gen3 = $cont_gen3 + $con_3;
	$cont_por3 = $cont_por3 + $porcentaje3;
/*	$cont_gen4 = $cont_gen4 + $con_4;
	$cont_por4 = $cont_por4 + $porcentaje4;*/
	?>
  <tr>
    <td width="28"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector_num;?></font></div></td>
    <td width="208"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector_pal;?></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profe_dicta;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_1; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje1."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_2; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje2."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_3; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje3."%"; ?></font></div></td>
    <!--<td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_4; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje4."%"; ?></font></div></td>-->
  </tr>
  <? } // FIN FOR E ?>
</table>
<br>
<?
$totalnotas = $cont_gen1 + $cont_gen2 + $cont_gen3 + $cont_gen4;
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>SUMA DE TOTALES:</strong></font></div>
       </td>
    <td width="29" class="subitem"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $cont_gen1?></font></div></td>
    <td width="29" class="subitem"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1">
     <? 
	$pp1 = ($cont_por1>0)?round($cont_gen1*100/$totalnotas,0):0;
	echo $pp1;
	$arr_por['porc'][]=$pp1;
	
	?>%
    </font></div></td>
    <td width="29" class="subitem"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $cont_gen2?></font></div></td>
    <td width="29" class="subitem"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1">
     <? 
	$pp2 = ($cont_por2>0)?round($cont_gen2*100/$totalnotas,0):0;
	echo $pp2;
	$arr_por['porc'][]=$pp2;
	
	//if ($cont_por2>0)echo round($cont_gen2*100/$totalnotas,0)."%"; else echo "0%"?>%
   </font></div></td>
    <td width="29" class="subitem"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $cont_gen3?></font></div></td>
    <td width="29" class="subitem"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1">
    <? 
	$pp3 = ($cont_por3>0)?round($cont_gen3*100/$totalnotas,0):0;
	echo $pp3;
	$arr_por['porc'][]=$pp3;
	
	//if ($cont_por2>0)echo round($cont_gen2*100/$totalnotas,0)."%"; else echo "0%"?>%
    </font></div></td>
  <!--  <td width="29" class="subitem"><div align="center"><? //echo $cont_gen4?></div></td>
    <td width="29" class="subitem"><div align="center">
      <? //if ($cont_por4>0)echo round($cont_gen4*100/$totalnotas,0)."%"; else echo "0%"?>
    </div></td>-->
  </tr>
</table><br>
<br>
 <?php if(isset($_POST['graf'])){?>
 <div id="container" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>
 <script>
 // Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'pie'
    },
	credits: {
        enabled: false
    },
    title: {
        text: ''
    },
    subtitle: {
        text: 'Promedios generales del curso'
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.0f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}%</b> del curso<br/>'
    },

    series: [
        {
            name: "Promedios del curso",
            colorByPoint: true,
            data: [
			<?php for($g=0;$g<count($arr_por['rango']);$g++){?>
                {
                    name: "<?php echo $arr_por['rango'][$g] ?>",
                    y: <?php echo $arr_por['porc'][$g] ?>,
                    drilldown: "<?php echo $arr_por['rango'][$g] ?>"
                },
			<?php }?>
            ]
        }
    ]
});
 </script>
<?php  }?>
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
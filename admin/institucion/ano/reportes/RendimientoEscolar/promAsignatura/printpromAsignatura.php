<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=1;
	$subsector		=$cmb_subsector;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
	 $finalp=$finalp;
	
	//	show($_POST);
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	

	$ob_membrete ->periodo = $cmb_periodos;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo;
	
	
	//------------------- CURSO -----------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	
	//lista de los cursos
	$ob_reporte ->ano = $ano;
	$ob_reporte ->subsector = $cmbramo;
	$ob_reporte ->ensenanza = $cmbENS;
	$ob_reporte ->nro_ano = $nro_ano;
	$ob_reporte->periodo = $cmb_periodos;
	
	$lis  = $ob_reporte->listaCursosPorAsignatura($conn);
	 
	
	$rs_sub = $ob_reporte->Subs1($conn);
	$sub = pg_result($rs_sub,1);
	
	for($l=0;$l<pg_numrows($lis);$l++){
	$fila = pg_fetch_array($lis,$l);
	
	$cur['curso'][]=$fila['id_curso'];
	 $ob_reporte->ramo = $fila['id_ramo'];
	
	$rded = ($fila['truncado']==1)?"round":"intval";
	//normal
	if($_POST['tipon']==1){
	$ob_reporte->PromedioRamoCurso($conn);
	
	$cur['nota'][]=$rded($ob_reporte->suma_curso/$ob_reporte->contador_curso);
	}
	//examen
	if($_POST['tipon']==2){
		
	 $ob_reporte->promedioExamenPeriodo($conn);
	 $cur['nota'][]=$rded($ob_reporte->suma/$ob_reporte->contador);
	}
	//si apreciacion
	if($_POST['tipon']==3){
	
	 $ob_reporte->PromedioAPRamoCurso($conn);
	 $cur['nota'][]=$rded($ob_reporte->suma/$ob_reporte->contador);
	}
	

	
	//si examen periodo
		
	}
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/highcharts/js/highcharts2.js"></script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
			function enviapag2(form){
					form.target="_blank";
					document.form.action='printInformePrimerosAlumnos.php?&cmb_ano=<?=$ano?>';
					document.form.submit(true);
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'notas_por_asignatura.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
			function imprimir() 
			{
			document.getElementById("capa0").style.display='none';
			window.print();
			document.getElementById("capa0").style.display='block';
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

  <form method="post" name="form" action="../../printInformeNotasporAsignaturaEnOrden.php" target="mainFrame">
    <center>
<div id="capa0">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	  </td>
	 
	
	  </tr></table>

    </td>
  </tr>
</table>
</div>
<br>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?> </strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		
				   

		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
			  <?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' width='120' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>			</td>
			 </tr>
         </table>	</td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>


	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="23" class="textonegrita">AÑO: <?=$nro_ano;?></td>
        </tr>
      <tr>
        <td colspan="23" class="textonegrita">ASIGNATURA: <?php echo $sub ?></td>
      </tr>
      <tr>
        <td colspan="23" class="textonegrita">&nbsp;</td>
      </tr>
    </table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23" class="tableindex"><div align="center">LISTADO PROMEDIOS POR ASIGNATURA</div></td>
        </tr>
      <tr>
        <td colspan="23"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo $periodo_pal;?> </strong></font></div></td>
        </tr>

    </table>

	</td>
  </tr>
</table>
<br>
<?php 
//tabla
if($tipor==1){
?>
	<table width="650" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse"> 
    <tr class="tableindex">
      <td>Curso</td>
      <td align="center">Promedio</td>   
    </tr>
    <?php for($g=0;$g<count($cur['curso']);$g++){?>
   
    <tr class="textosimple"><td><?php echo CursoPalabra($cur['curso'][$g],1,$conn) ?></td>
    <td align="center"><?php echo $cur['nota'][$g] ?></td></tr>
    <?php }?>
    </table>
<?
}
//grafico
else{
?>
<div id="container" style="min-width: 310px; max-width: 600px; height: 550px; margin: 0 auto" align="center"></div>
<script>
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [  <?php for($g=0;$g<count($cur['curso']);$g++){?>
            '<?php echo CursoPalabra($cur['curso'][$g],1,$conn) ?>',
		  <?php }?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 10,
        max: 70,
        title: {
            text: 'Promedios por curso'
        }
    },
    tooltip: {
        valueSuffix: ' '
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    
    credits: {
        enabled: false
    },
    series: [{
        name: 'Promedio',
        data: [ <?php for($g=0;$g<count($cur['nota']);$g++){?>
            <?php echo $cur['nota'][$g] ?>,
		  <?php }?>]
    }]
});</script>

<?
}

?>
</center>
</form>

 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $concur=0;
		 include("../../firmas/firmas.php");?>

<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>
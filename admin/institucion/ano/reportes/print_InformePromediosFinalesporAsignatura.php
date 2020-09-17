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


	//print_r($_GET);
 
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//$periodo		=$cmb_periodos;
	$curso			=$cmb_curso;
	$subsector		=$cmb_subsector;
	$reporte		=$c_reporte;
	$promedio_promedio=$_GET['conexamen'];
	$conexamenperiodo = $_GET['conexamenperiodo'];
	$conapreciacion = $_GET['conapreciacion'];
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
	if ($curso>0 and $periodo>0)
		$sw = 1;
	if ($sw == 0){
	
	}
		
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
	if ($_INSTIT==14629 ){
	    $sql_periodo = "select * from periodo where id_ano = ".$ano . " order by id_periodo Desc";
	}else{	
	    $sql_periodo = "select * from periodo where id_ano = ".$ano . " order by id_periodo";
	}
	
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
		
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 "<br>".$periodo[1];
	 $periodo[2];
	$ob_reporte->curso=$curso;
	$ob_reporte->SubsectorRamo($conn);
	$result_subsector = $ob_reporte->result;

	
	//$ob_membrete ->ano=$ano;
	//$ob_membrete ->periodo=$periodo;
	//$ob_membrete ->periodo($conn);
	//$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
	//------------------- CURSO -----------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Notas_por_Asignatura_$Fecha.xls"); 
	}	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
					document.form.action='printInformeNotasporAsignatura_C.php?cmb_periodos=<?=$periodo?>&cmb_curso=<?=$curso?>&cmb_subsector=<?=$subsector?>';
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
  <form method="post" name="form" action="print_InformePromediosporAsignatura.php" target="mainFrame">
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
	  <? if($_PERFIL == 0){?>
	<td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)" value="EXPORTAR"></td>
	  <? }?>
	  </tr></table>

    </td>
  </tr>
</table>
</div>
<?
	//------------------- SUBSECTOR ---------------------------------------------------------------------
	if ($subsector==0){
		$ob_reporte->curso=$curso;
		$ob_reporte->subsector=0;
		$ob_reporte->NombreSubsector($conn);
		$result_sub = $ob_reporte->result;
	}else{
		$ob_reporte->subsector=$subsector;
		$ob_reporte->NombreSubsector($conn);
		$result_sub = $ob_reporte->result;
	}		
	$registros = @pg_numrows($result_sub);
	
for($i=0 ; $i < $registros ; $i++)
{
	$cadena01=""; $cadena02=""; $cadena03="";$cadena04=""; $cadena05="";
	$cadena06=""; $cadena07=""; $cadena08="";$cadena09=""; $cadena10="";
	$cadena11=""; $cadena12=""; $cadena13="";$cadena14=""; $cadena15="";
	$cadena16=""; $cadena17=""; $cadena18="";$cadena19=""; $cadena20="";
	$cadenaprom="";		
	$fila_sub = @pg_fetch_array($result_sub,$i);	
	$subsector = $fila_sub['id_ramo'];
	$subsector_pal = ucwords(strtoupper(trim($fila_sub['nombre'])));	
	$modo = $fila_sub['modo_eval'];
	
	/**************PROFESOR SUBSECTOR *********************/
	$ob_reporte ->ramo =$subsector;
	$ob_reporte ->ProfeSubsector($conn);
	
	$ob_reporte ->institucion =$institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->ramo =$subsector;
	$ob_reporte ->bool_ar=0;
	$ob_reporte ->curso=$curso;
	$ob_reporte ->nro_ano =$nro_ano;
	$ob_reporte ->orden =$ck_orden;
	$result_alu =$ob_reporte ->AlumnosSubsector($conn);
	//$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	
	
	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
<? if ($institucion!="770"){ ?>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
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
				   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
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
<? } ?>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23" class="tableindex"><div align="center">NOTAS POR ASIGNATURA</div></td>
        </tr>
      <tr>
        <td colspan="23"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo $periodo_pal;?> </strong></font></div></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="18">&nbsp;</td>
      </tr>
      <tr>
              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
        <td width="8"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="542" colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal;?></font></td>
        </tr>
      <tr>
		      <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $subsector_pal;?></font></td>
        </tr>
      <tr>
              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a)</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ob_reporte->tilde($ob_reporte->nombre_ape);?></font></td>
        </tr>
     
    </table>
    
    <?
    	if($cantidad_periodos==3){
	?>
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="47"  class="tablatit2-1">N</td>
              <td  class="tablatit2-1">Nombre del Alumno</td>
              <td colspan="" class="tablatit2-1"><div align="center">1ºTrim</div></td>
              <td colspan="" class="tablatit2-1"><div align="center">2ºTrim</div></td>
              <td colspan="" class="tablatit2-1"><div align="center">3ºTrim</div></td>
              <td class="tablatit2-1"><div align="center">P</div></td>
            </tr>
            <?
  for($e=0 ; $e < @pg_numrows($result_alu) ; $e++)
  {
	  $fila_alu = @pg_fetch_array($result_alu,$e);
	  $alumno = $fila_alu['rut_alumno'];
	  $cont=0;
	
	  
		//$ob_reporte ->periodo = $periodo;
		$ob_reporte ->rut_alumno = $alumno;
		$ob_reporte ->ramo = $subsector;
		$ob_reporte ->curso=$curso;
	    $ob_reporte ->Curso($conn);
	    $truncado_per = $ob_reporte->truncado;
		
		
		$result_p = $ob_reporte ->Promedio1($conn);
		$fila_p = @pg_fetch_array($result_p,0);
		 //echo "Promedio-->".$promedio=$fila_p['promedio'];
		 
		 $result_p2 = $ob_reporte ->Promedio2($conn);
		$fila_p2 = @pg_fetch_array($result_p2,0);
		//echo "Apreciacion-->".$promedio2=$fila_p2['notaapp'];
		 
		 $result_p3 = $ob_reporte ->Promedio3($conn);
		$fila_p3 = @pg_fetch_array($result_p3,0);
		//echo "Apreciacion-->".$promedio2=$fila_p2['notaapp'];
		 
	/***************CON EXAMEN PERIODO PRIMER*************************/					
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			$conexper = $fila_conexper['conexper'];
			if($conapreciacion==1){
				$promedio=$fila_p['notaapp'];
				}else{
			if($conexamenperiodo==1 && $conexper==1){
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			
			"final->".$promedio = $fila_conexper['nota_final'];
			}else{
			"Promedio->".$promedio 	= $fila_p['promedio'];
			}
				}
	/******************FIN CONEXAMEN PRIMER ********************/	
	
	/***************CON EXAMEN PERIODO SEGUNDO *************************/					
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,0);
		$conexper2 = $fila_conexper2['conexper'];
		if($conapreciacion==1){
				$promedio2=$fila_p2['notaapp'];
				}else{

		if($conexamenperiodo==1 && $conexper2==1){
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,0);
		
		  "final->".$promedio2 = $fila_conexper2['nota_final'];
		}else{
		 "Promedio->".$promedio2 	= $fila_p2['promedio'];
		}}
	/******************FIN CONEXAMEN********************/
	
	/***************CON EXAMEN PERIODO TERCER *************************/					
		$result_conexamen3 =$ob_reporte->NotaExamen_periodo3($conn);
		$fila_conexper3 = @pg_fetch_array($result_conexamen3,0);
		$conexper3 = $fila_conexper3['conexper'];
		if($conapreciacion==1){
				$promedio3=$fila_p3['notaapp'];
				}else{

		if($conexamenperiodo==1 && $conexper2==1){
		$result_conexamen3 =$ob_reporte->NotaExamen_periodo3($conn);
		$fila_conexper3 = @pg_fetch_array($result_conexamen3,0);
		
		  "final->".$promedio3 = $fila_conexper3['nota_final'];
		}else{
		 "Promedio->".$promedio3 	= $fila_p3['promedio'];
		}}
	/******************FIN CONEXAMEN********************/
		
	 if($conexamen==1){
		$result_promedio_sub= $ob_reporte ->PromedioSubAlumnos($conn);
		$fila_sub=pg_fetch_array($result_promedio_sub,0);
			if(pg_numrows($result_promedio_sub)==0){
				echo $promedio_promedio=0;
			}else{
				$promedio_promedio=$fila_sub['promedio'];
				
			}
	}else{		
		 	if($promedio!=0){
				  $cont++;
			  }
			  if($promedio2!=0){
				  $cont++;
			  }
		 
		 if($truncado_per==1){
	  	 	$promedio_promedio= round(($promedio+$promedio2) / $cont);
		  }else{
		  	$promedio_promedio= intval(($promedio+$promedio2) / $cont);
		  }
	}
   	
  ?>
      <tr> 
              <td height="17" class="textosimple"><div align="center"><? echo $e+1?></div></td>
              <td width="279" class="textosimple"><div align="left"><?=$ob_reporte->tilde($fila_alu['nombres']);?></div></td>
              <td width="133" align="center" class="textosimple"> <div align="center">
			   <? 
			if ($promedio>0&&$promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio;
				?> </font>	<?		
				}else{echo $promedio;}
			?>
			  
			  </div></td>
              <td width="123" align="center" class="textosimple"> <div align="center">
               <? 
			if ($promedio2>0&&$promedio2<40){
				?><font color="#FF0000"><? 
				echo $promedio2;
				?> </font>	<?		
				}else{echo $promedio2;}
			?>
              </div></td>
              <td width="123" align="center" class="textosimple"> <div align="center">
               <? 
			if ($promedio3>0&&$promedio3<40){
				?><font color="#FF0000"><? 
				echo $promedio3;
				?> </font>	<?		
				}else{echo $promedio3;}
			?>
              </div></td>
            
         
              <td width="56" align="center" class="textosimple"> <div align="center">
			   <? 
			if ($promedio_promedio>0 && $promedio_promedio<40){?>
				<font color="#FF0000"><? echo $promedio_promedio;?> </font>
		<?		
			}else{ 
				echo $promedio_promedio;
			}
			?>
			  </div>
		</tr>
            <? 
			
		
  
	$cadena01 = $cadena01 . ";" . $promedio;
	$cadena02 = $cadena02 . ";" . $promedio2;
	$cadena02 = $cadena02 . ";" . $promedio3;
    $cadenaprom = $cadenaprom . ";" . $promedio_promedio;
		
  
		if($institucion==9071){
			if  ($e==29){ ?>
		  </table>			
<?				echo "<H1 class=SaltoDePagina>&nbsp;</H1>";		?>
			<br><br><br>	
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="17" class="item">N</td>
              <td width="187" class="item">Nombre del Alumno</td>
              <td colspan="20" class="item"><div align="center">NOTAS</div></td>
              <td width="20" class="item"><div align="center">P</div></td>
            </tr>
				
<?			}
		}
	
  } 
  ?>
            
            <tr> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 00-39 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena03)?></div></td>
              <td class="subitem"><? porcentaje1($cadenaprom)?></td>
            </tr>
            <tr> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 40-49 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena03)?></div></td>
              <td class="subitem"><? porcentaje2($cadenaprom)?></td>
            </tr>
            <tr> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 50-59 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena03)?></div></td>
      		  <td class="subitem"><? porcentaje3($cadenaprom)?></td>
            </tr>
            <tr> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 60-70 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena03)?></div></td>
             	<td class="subitem"><? porcentaje4($cadenaprom)?></td>
            </tr>
          </table>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>
<? }

 
    	if($cantidad_periodos==2){
			
	?>
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="47"  class="tablatit2-1">N</td>
              <td  class="tablatit2-1">Nombre del Alumno</td>
              <td colspan="" class="tablatit2-1"><div align="center">1ºSem</div></td>
              <td colspan="" class="tablatit2-1"><div align="center">2ºSem</div></td>
              <td class="tablatit2-1"><div align="center">P</div></td>
            </tr>
            <?
  for($e=0 ; $e < @pg_numrows($result_alu) ; $e++)
  {
	  $fila_alu = @pg_fetch_array($result_alu,$e);
	  $alumno = $fila_alu['rut_alumno'];
	  $cont=0;
	
	  
		//$ob_reporte ->periodo = $periodo;
		$ob_reporte ->rut_alumno = $alumno;
		$ob_reporte ->ramo = $subsector;
		$ob_reporte ->curso=$curso;
	    $ob_reporte ->Curso($conn);
	    $truncado_per = $ob_reporte->truncado;
		
		
		
		
		$result_p = $ob_reporte ->Promedio1($conn);
		$fila_p = @pg_fetch_array($result_p,0);
		$promedio=$fila_p['promedio'];
		
		
		
		 $result_p2 = $ob_reporte ->Promedio2($conn);
		$fila_p2 = @pg_fetch_array($result_p2,0);
		$promedio2=$fila_p2['notaapp'];
		 
		 
	
		 
	/***************CON EXAMEN PERIODO PRIMER SEMESTRE*************************/					
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			$conexper = $fila_conexper['conexper'];
			if($conapreciacion==1){
				$promedio=$fila_p['notaapp'];
				}else{
			if($conexamenperiodo==1 && $conexper==1){
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			
			"final->".$promedio = $fila_conexper['nota_final'];
			}else{
			"Promedio->".$promedio 	= $fila_p['promedio'];
			}
				}
	/******************FIN CONEXAMEN PRIMER SEMESTRE********************/	
	
	/***************CON EXAMEN PERIODO SEGUNDO SEMESTRE*************************/					
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,$f);
		$conexper2 = $fila_conexper2['conexper'];
		if($conapreciacion==1){
				$promedio2=$fila_p2['notaapp'];
				}else{

		if($conexamenperiodo==1 && $conexper2==1){
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,0);
		
		  "final->".$promedio2 = $fila_conexper2['nota_final'];
		}else{
		 "Promedio->".$promedio2 	= $fila_p2['promedio'];
		}}
	/******************FIN CONEXAMEN********************/
	
	
	
			
		$algo=substr($subsector_pal,0,8);	
		if($algo=="RELIGION" or $algo=="ORIENTAC"){
				 $promedio_promed=0;
				 $cuentra=0;
			if (trim($promedio) == "MB")

			{$prom = 65;
			$tipo=1;
			$cuentra++;
			}
		if (trim($promedio) == "B")

			{$prom = 55;			
			$tipo=1;
			$cuentra++;}
		if (trim($promedio) == "S")

		{	$prom = 45;
			$tipo=1;
			$cuentra++;}
		if (trim($promedio) == "I")

			{$prom = 35;						
			$tipo=1;
			$cuentra++;}
			
			if (trim($promedio) == "0" || strlen($promedio) == 0)

			{$prom = 0;						
			$tipo=1;
			$cuentra=$cuentra;
			}
			
		
			
		// $prom;

  if (trim($promedio2) == "MB")

			{$prom2 = 65;
			$tipo=1;
			$cuentra++;
			}
		if (trim($promedio2) == "B")

			{$prom2 = 55;			
			$tipo=1;
			$cuentra++;}
		if (trim($promedio2) == "S")

			{$prom2 = 45;
			$tipo=1;
			$cuentra++;}
		if (trim($promedio2) == "I")

			{$prom2 = 35;						
			$tipo=1;
			$cuentra++;}
		 //$prom2;
		 
		 if (trim($promedio2) == "0" || strlen($promedio2) ==0)

			{$prom2 = 0;						
			$tipo=1;
			$cuentra=$cuentra;
			}
		
			
		 $promedio_promed= round(($prom+$prom2) / $cuentra);
			
			// if($_PERFIL==0){echo "<br>".$alumno."--".$prom."..".$prom2."--".$cuentra."->".$promedio_promed;}
		
		if ($promedio_promed >= 60 and $promedio_promed<=70)

			 $concepto = "MB";

		if ($promedio_promed >= 50 and $promedio_promed<=59)

			$concepto = "B";

		if ($promedio_promed >= 40 and $promedio_promed<=49)

			$concepto = "S";

		if ($promedio_promed >= 0 and $promedio_promed<=39)

			$concepto = "I";
		
		if($promedio_promed==0)
		
			$concepto = "-";
					 
					 
					 
		 $promedio_promedio = $concepto;	 
					 
		}else{
		if($conexamen==1){
		$result_promedio_sub= $ob_reporte ->PromedioSubAlumnos($conn);
		$fila_sub=pg_fetch_array($result_promedio_sub,0);
			if(pg_numrows($result_promedio_sub)==0){
				
				 $promedio_promedio=0;
			}else{
				$promedio_promedio=$fila_sub['promedio'];
			}
		}else{		
			if($promedio!=0){
				$cont++;				
			}
			if($promedio2!=0){
				$cont++;
			}
		  if($truncado_per==1){
	  	 	$promedio_promedio= round(($promedio+$promedio2) / $cont);
		  }else{
		  	$promedio_promedio= intval(($promedio+$promedio2) / $cont);
		  }
		}
		}
		
		
		
  ?>
      <tr> 
              <td height="17" class="textosimple"><div align="center"><? echo $e+1?></div></td>
              <td width="279" class="textosimple"><div align="left"><?=$ob_reporte->tilde($fila_alu['nombres']);?></div></td>
              <td width="133" align="center" class="textosimple"> <div align="center"><? 
			if ($promedio>0&&$promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio;
				?> </font>	<?		
				}else{echo $promedio;}
			?></div>
              </td>
              <td width="123" align="center" class="textosimple"> <div align="center">
              <? 
			if ($promedio2>0&&$promedio2<40){
				?><font color="#FF0000"><? 
				echo $promedio2;
				?> </font>	<?		
				}else{echo $promedio2;}
			?>
              </div></td>
            
         
              <td width="56" align="center" class="textosimple"> <div align="center">
			  <? 
			if ($promedio_promedio>0&&$promedio_promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio_promedio;
				?> </font>	<?		
				}else{echo $promedio_promedio;}
			?>
			  </div>
		</tr>
            <? 
			
		
  
	$cadena01 = $cadena01 . ";" . $promedio;
	$cadena02 = $cadena02 . ";" . $promedio2;
    $cadenaprom = $cadenaprom . ";" . $promedio_promedio;
		
  
		if($institucion==9071){
			if  ($e==29){ ?>
		  </table>			
<?				echo "<H1 class=SaltoDePagina>&nbsp;</H1>";		?>
			<br><br><br>	
	      <table width="650"  border="1" cellspacing="0" cellpadding="0">
            <tr class="textosimple"> 
              <td width="17" class="item">N</td>
              <td width="187" class="item">Nombre del Alumno</td>
              <td colspan="20" class="item"><div align="center">NOTAS</div></td>
              <td width="20" class="item"><div align="center">P</div></td>
            </tr>
				
<?			}
		}
	
  } 
  ?>
            
            <tr class="textosimple" > 
              <td  class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 00-39 </strong></td>
              <td class="subitem"><div align="center"><? porcentaje1($cadena01)?></div></td>
              <td class="subitem"><div align="center"><? porcentaje1($cadena02)?></div></td>
              <td class="subitem" align="center"><? porcentaje1($cadenaprom)?></td>
            </tr>
            <tr class="textosimple"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 40-49 </strong></td>
              <td class="subitem"><div align="center"><? porcentaje2($cadena01)?></div></td>
              <td class="subitem"><div align="center"><? porcentaje2($cadena02)?></div></td>
              <td class="subitem" align="center"><? porcentaje2($cadenaprom)?></td>
            </tr>
            <tr class="textosimple"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 50-59 </strong></td>
              <td class="subitem"><div align="center"><? porcentaje3($cadena01)?></div></td>
              <td class="subitem"><div align="center"><? porcentaje3($cadena02)?></div></td>
      			<td class="subitem"  align="center"><? porcentaje3($cadenaprom)?></td>
            </tr>
            <tr class="textosimple"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 60-70 </strong></td>
              <td class="subitem"><div align="center"><? porcentaje4($cadena01)?></div></td>
              <td class="subitem"><div align="center"><? porcentaje4($cadena02)?></div></td>
             	<td class="subitem" align="center"><? porcentaje4($cadenaprom)?></td>
            </tr>
          </table>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>
<? }

if  (($registros - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
} ?>
</center>
</form>
<?
}
?>
<?
function ValidaNota($nota, $ModoEval)
{
	if ($ModoEval == 1)
	{
		if ($nota<40 && $nota>0){	?>
			<font color="#FF0000"><? echo $nota;?> </font>	<?
		}else if($nota=='' || $nota==0 || $nota==NULL || $nota == ' '){
			echo "&nbsp;";	
		}
		else{
			echo $nota;
		}
	}
	else
	{
		if (trim($nota)=="0")
			echo "&nbsp;";
		else
			echo $nota;
	}
}
function porcentaje1($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>0 and $arreglo[$o]<39)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje2($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>39 and $arreglo[$o]<50)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje3($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>49 and $arreglo[$o]<60)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje4($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>59 and $arreglo[$o]<71)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
?>

<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>
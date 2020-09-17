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
        <td colspan="23" class="tableindex"><div align="center">PROMEDIO NUMERICO CONCEPTUAL</div></td>
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
    
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="47"  class="tablatit2-1">N</td>
              <td  class="tablatit2-1">Nombre del Alumno</td>
              <?
              	$sql_per="select id_periodo,nombre_periodo from periodo where id_ano=$ano"; 
				$rs_per=pg_exec($conn,$sql_per);
				
				for($x=0;$x<pg_numrows($rs_per);$x++){
					
					$fila_per=pg_fetch_array($rs_per,$x);
					?>
					<td class="tablatit2-1"><?=$fila_per['nombre_periodo'];?></td>
					<?
					
					}
			  
			  ?>
              <td class="tablatit2-1"><div align="center">P</div></td>
            </tr>
        <?
        
		 for($e=0 ; $e < @pg_numrows($result_alu) ; $e++)
      {
	    $fila_alu = @pg_fetch_array($result_alu,$e);
	    $alumno = $fila_alu['rut_alumno'];
		
		?>
        
        
        
      <tr> 
              <td height="17" class="textosimple"><div align="center"><? echo $e+1?></div></td>
              <td width="279" class="textosimple"><div align="left"><?=$ob_reporte->tilde($fila_alu['nombres']);?></div></td>
              <?
			  $promedio_total=0;
              for($x=0;$x<pg_numrows($rs_per);$x++){
					
					$fila_per=pg_fetch_array($rs_per,$x);
					?>
					<td align="center">
					<?
					$nota=0;
					for($z=1;$z<=20;$z++){
						
						$notas="nota".$z;
						
						$nota=$notas.','.$nota;
						}
						 $todas_notas=$string = substr ($nota, 0, strlen($nota) - 1);
						
						$ordennormal = explode(",",$todas_notas);
						$ordeninverso = array_reverse($ordennormal);
						$ordeninverso = implode($ordeninverso,",");
						
						
						$notas_todas=substr($ordeninverso,1);
						 $notas_todas;
					
					 $sql_notas="select $notas_todas from notas$nro_ano 
					            where id_ramo=$cmb_subsector and id_periodo=".$fila_per['id_periodo']." and rut_alumno= ".$fila_alu['rut_alumno']." ";
								
							
								$rs_notas=pg_exec($conn,$sql_notas);
								for($j=0;$j<pg_numrows($rs_notas);$j++){
								$fila_notas=pg_fetch_array($rs_notas,0);
								
								}
								//print_r($fila_notas);
								$esto=0;
								$contador=0;
					for($z=1;$z<=20;$z++){
						
						$notas="nota".$z;
						
						if($fila_notas[$notas]>0){
							
							 $esto= $fila_notas[$notas]+$esto;
							 $contador++;
							}else{
								continue;
							}
					}
						$promedio = round($esto/$contador);
						echo $promedio;		
						//$prom[$fila_alu['rut_alumno']]=$prom[$fila_alu['rut_alumno']] + $promedio;
						
					?>
					</td>
					<?
					$promedio_total=$promedio+$promedio_total;
					}
			  ?>
              <td align="center">
               <?
               	
				echo round($promedio_total/2);
			   ?>     
              </td>
             </tr>
            
          <?
          
  }
		  ?>
          </table>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>
<? 

if  (($registros - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
} ?>
</center>
</form>
<?
}
?>

 
<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>
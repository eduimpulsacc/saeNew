<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$cadena01		="00";	
	$_POSP = 6;
	$_bot = 8;
	if (empty($curso)) exit;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_membrete ->institucion =$institucion;
	$ob_membrete ->institucion($conn);
	//------------------------
	// Periodo
	//------------------------
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo($conn);
	
	//------------------------
	// A�o Escolar
	//------------------------
	$ob_membrete ->ano=$ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
	$ob_reporte ->curso = $curso;
	$ob_reporte ->ProfeJefe($conn);
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$ob_reporte ->ano =$ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte ->retirado =0;
	$result_alu = $ob_reporte ->TraeTodosAlumnos($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	//firma
	$ob_reporte->rdb=$institucion;
		$ob_reporte->item= $reporte;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->item= $fils_item['id_item'];
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
				
			
				}
				else{
				$crp = $aut;
				}
			
			$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}else{
		$crp=1;
		}
	
	
	
	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Notas_generales_$fecha_actual.xls"); 	 
}	 	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'PlanillaNotasGeneralesPeriodo.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}	
			
			  
		function exportar(){
			document.getElementById("grafico").style.display='block';
			window.location='printInformeGraficoNotasGeneralesPeriodo_C.php?cmb_curso=<?=$curso?>&cmb_periodos=<?=$periodo?>&xls=1';
			return false;
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
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
<?
if (empty($curso)){
   // exit;
}else{
   ?>   

<center>
<form name="form" method="post" action="../../printInformeGraficoNotasGeneralesPeriodo_C.php" target="_blank">

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		    <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>
        </div>
        </div>
		</td>
      </tr>
    </table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c�digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
	  		</td>
		 </tr>
      </table>
	</td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
	</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex"><div align="center">PROMEDIOS GENERALES </div></td>
      </tr>
      <tr>
         <td align="center" class="item"><strong><? echo $ob_membrete->nombre_periodo?> de&nbsp;<? echo $nro_ano?> </strong></td>
      </tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td width="115" class="item"><strong>Curso</strong></td>
        <td width="10" class="item"><div align="left">:</div></td>
        <td width="531" class="subitem"><? echo $Curso_pal;?></td>
      </tr>
      <tr>
        <td class="item"><strong>Profesor(a) Jefe</strong></td>
        <td class="item"></div>:</td>
        <td class="subitem"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></td>
      </tr>
    </table>
	<br>

<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <td width="30" bgcolor="#999999" class="item">N�</td>
	<td width="100" bgcolor="#999999" class="item">NOMBRE DEL ALUMNO</td>
    <? if($cb_ok=="Buscar"){?>
	<div id="grafico">
	<td width="400" bgcolor="#999999" class="item"><div align="center"></div></td>
	</div>
	<? }?>
	<td width="30" bgcolor="#999999" class="item"><div align="center">Promedio</div></td>
	
    </tr>
  <tr>
    <?	 
	
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	
  <tr>
    <td align="center" class="subitem"><? echo $i+1; ?></td>
    <td class="subitem"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></td>
	<?	 
		//---------------------------------------
		// Notas
		//---------------------------------------
		$ob_reporte ->nro_ano = $nro_ano;
		$ob_reporte ->curso = $curso;
		$ob_reporte->bool_pgeneral=1;
		$ob_reporte->incide=1;
		$ob_reporte ->alumno=$rut_alumno;
		$ob_reporte ->formacion=1;
		
		$rs_ramos = $ob_reporte ->RamoFormacion($conn);
		
		$sum_ramos=0;
		$cont_ramos=0;
		for($ra=0;$ra<pg_numrows($rs_ramos);$ra++){
		$fila_ramo = pg_fetch_array($rs_ramos,$ra);
		$ob_reporte->id_ramo= $fila_ramo['id_ramo'];
		$ob_reporte->periodo= $periodo;
		
		//echo "ramo->".$fila_ramo['id_ramo']."<br>";
		if($fila_ramo['modo_eval']==1 ){
		
		$cont_ramos=$cont_ramos+1;	
			
		if($fila_ramo['conexper']==0 ){
			
			/* $sqlpp="SELECT promedio FROM notas$nro_ano WHERE id_ramo=".$ob_reporte->id_ramo." AND rut_alumno=".$ob_reporte ->alumno." and id_periodo=".$periodo;
			echo $sqlpp;			
			$ramoasumar = pg_exec($conn,$sqlpp);*/
			
			
			$ramoasumar = $ob_reporte ->PromedioRamoAlumnoPeriodo($conn);
			 $promediosuma = pg_result($ramoasumar,0);
			}
		elseif($fila_ramo['conexper']==1 ){
			$ramoasumar =$ob_reporte ->PromedioRamoEXMN($conn);
			$promediosuma = $ob_reporte ->promedioex;
			}
		
		$sum_ramos=$sum_ramos+$promediosuma;
		}
		
		
		/*$ob_reporte ->periodos = $periodo;
		$ob_reporte ->alumno=$rut_alumno;
		$ob_reporte ->PromedioAlumno($conn);*/
		}
		//echo $sum_ramos;
		//echo "/".$cont_ramos;
		@$promedio_alumno = $sum_ramos/ $cont_ramos;
		
		//echo $sum_ramos;
		
		
	if($cb_ok=="Buscar"){
	?>
	<div id="grafico">
	<td class="subitem">
	    <?
			
			
		$promedio_porcentual = @round($promedio_alumno * 100 / 70);
		$anchotabla = ($promedio_porcentual * 4);		
		
		?>
		
		<?
		if ($promedio_alumno!=0){ ?>
	         <table border="2"  cellspacing="0" cellpadding="0" height="13">
			      <tr>
				     <td  width="<?=$anchotabla ?>"></td>
					 <td  width="9"></td>
	              </tr>
			 </table>
	  <? } ?>
	
	</td>
	</div>
	<? }?>
   		
     <?
     	$sql="select truncado_final, bool_psemestral from curso where id_curso=".$curso;
		$rs_tr = @pg_exec($conn,$sql);
		$truncado_f = @pg_result($rs_tr,1);
		$num=2;
		if($truncado_f==0){
			//$promedio_alumno=substr($promedio_alumno, 0, -$num);
			$separanumero=explode(".",$promedio_alumno);
			 $promedio_alumno=$separanumero[0];
			}else{
			$promedio_alumno=round($promedio_alumno);	
			}
	 ?>   
	<td bgcolor="#c8d6fb" class="subitem"><div align="center"><? echo $promedio_alumno; ?></div></td>
  	</tr>

	
  	<? } 
	?>	
 	</table>	
	</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
 <?  ?>
</form>
</center>

<? } ?>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>
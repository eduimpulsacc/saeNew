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
	$periodo		=$cmb_periodos;
	$curso			=$cmb_curso;
	$subsector		=$cmb_subsector;
	$reporte		=$c_reporte;
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
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
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
  <form method="post" name="form" action="printInformeNotasporAsignatura.php" target="mainFrame">
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
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
          <?php if($_POST['ck_lecc']==0){?>
            <tr> 
              <td  class="tablatit2-1">N</td>
              <td  class="tablatit2-1">Nombre del Alumno</td>
              <td colspan="20" class="tablatit2-1"><div align="center">NOTAS</div></td>
              
              <td class="tablatit2-1"><div align="center">P</div></td>
               <?php if($_POST['ck_exm']==1){?>
              <td width="20" class="tablatit2-1">EX.</td>
              <td width="20" class="tablatit2-1">P.F.</td>
              <?php }?>
            </tr>
            <?php }else{?>
            <tr> 
              <td rowspan="2"  class="tablatit2-1">N</td>
              <td rowspan="2"  class="tablatit2-1">Nombre del Alumno</td>
              <td colspan="21" class="tablatit2-1"><div align="center">NOTAS</div></td>
			  
              <td rowspan="2" class="tablatit2-1"><div align="center">P</div></td>
             
             
            </tr>
            <tr>
              <td class="tablatit2-1">1</td>
              <td class="tablatit2-1">2</td>
              <td class="tablatit2-1">3</td>
              <td class="tablatit2-1">4</td>
              <td class="tablatit2-1">5</td>
              <td class="tablatit2-1">6</td>
              <td class="tablatit2-1">7</td>
              <td class="tablatit2-1">8</td>
              <td class="tablatit2-1">9</td>
              <td class="tablatit2-1">10</td>
              <td class="tablatit2-1">11</td>
              <td class="tablatit2-1">12</td>
              <td class="tablatit2-1">13</td>
              <td class="tablatit2-1">14</td>
              <td class="tablatit2-1">15</td>
              <td class="tablatit2-1">16</td>
              <td class="tablatit2-1">17</td>
              <td class="tablatit2-1">18</td>
              <td class="tablatit2-1">19</td>
              <td class="tablatit2-1">20</td>
             
             
            </tr>
            <?php }?>
            <?
  for($e=0 ; $e < @pg_numrows($result_alu) ; $e++)
  {
	  $fila_alu = @pg_fetch_array($result_alu,$e);
	  $alumno = $fila_alu['rut_alumno'];
	  /*$ob_reporte->alumno = $alumno;
	  $ob_reporte->curso = $curso;
	  $result = $ob_reporte->TraeUnAlumno($conn);
	  $fila = @pg_fetch_array($result,0);
	  $ob_reporte->CambiaDato($fila);*/
	  
	  //----------
		$ob_reporte ->periodo = $periodo;
		$ob_reporte ->rut_alumno = $alumno;
		$ob_reporte ->ramo = $subsector;
		$ob_reporte ->prom = $txtPROM;
		$ob_reporte ->opcion = $ck_prom;
		$result_notas = $ob_reporte ->Notas($conn);
		$fila_notas = @pg_fetch_array($result_notas,0);
		
		if(pg_numrows($result_notas)!=0){
  ?>
            <tr class="textosimple"> 
              <td height="17" class="item"><div align="center"><? echo $e+1;//$fila_alu['nro_lista']?></div></td>
              <td width="274" class="item"><div align="left"><?=$ob_reporte->tilde(substr($fila_alu['nombres'],0,25))."...";?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota1'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota2'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota3'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota4'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota5'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota6'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota7'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota8'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota9'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota10'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota11'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota12'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota13'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota14'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota15'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota16'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota17'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota18'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota19'],$modo)?></div></td>
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['nota20'],$modo)?></div></td>
             
              <td width="17" align="center" class="item"> <div align="center"><? ValidaNota($fila_notas['promedio'],$modo)?></div></td>
                <?php if($_POST['ck_exm']==1){
				  
				 $r_exam= $ob_reporte->PromedioEXMANRamo($conn);
				 $f_exam=pg_fetch_array($r_exam,0);
				 $nex=$f_exam['nota_examen'];
				 $nfi=trim($f_exam['nota_final']);
				 
				 if($nex>=10 && $nex <=39){
					 
				}
				 
				  ?>
              <td width="17" align="center" class="item"><font color="<?php echo ($f_exam['nota_examen']<40?"red":"black"); ?>"><?php echo ($fila_sub['conexper']==1 && $fila_notas['promedio']<$fila_sub['nota_ex_semestral'])?$f_exam['nota_examen']:""; ?>
              
              <?php 
	if ($fila_sub['conexper']==1 && $fila_notas['promedio']<$fila_sub['nota_ex_semestral']){
	
	
		
		
			if($f_exam['nota_examen']>=10 && $f_exam['nota_examen']<=39){
			$rex[$subsector][0][]=$f_exam['nota_examen'];
			}	
			
			elseif($f_exam['nota_examen']>=40 && $f_exam['nota_examen']<=49){
			$rex[$subsector][1][]=$f_exam['nota_examen'];
			}
			
			elseif($f_exam['nota_examen']>=50 && $f_exam['nota_examen']<=59){
			$rex[$subsector][2][]=$f_exam['nota_examen'];
			}
			
			elseif($f_exam['nota_examen']>=60){
			$rex[$subsector][3][]=$f_exam['nota_examen'];
			}
	
	
	
	}
	$cont_ex=count($rex[$subsector][0])+count($rex[$subsector][1])+count($rex[$subsector][2])+count($rex[$subsector][3])
	
			  
			  ?>
              
              </font></td>
              <td width="17" align="center" class="item"><font color="<?php echo ($f_exam['nota_final']<40?"red":"black"); ?>"><?php echo $f_exam['nota_final'] ?></font>
              
           <?php 
		   if($f_exam['nota_final']>0){
		   
if($f_exam['nota_final']>=10 && $f_exam['nota_final']<=39){
$rpf[$subsector][0][]=$f_exam['nota_final'];
}	
		
elseif($f_exam['nota_final']>=40 && $f_exam['nota_final']<=49){
$rpf[$subsector][1][]=$f_exam['nota_final'];
}
				 
elseif($f_exam['nota_final']>=50 && $f_exam['nota_final']<=59){
$rpf[$subsector][2][]=$f_exam['nota_final'];
	 }
	 
elseif($f_exam['nota_final']>=60){
$rpf[$subsector][3][]=$f_exam['nota_final'];
	 }
		   }
			  ?>
              </td>
              <?php }?>
		</tr>
            <? }
  if ($modo==1)
  {
	$cadena01 = $cadena01 . ";" . $fila_notas['nota1'];
	$cadena02 = $cadena02 . ";" . $fila_notas['nota2'];
	$cadena03 = $cadena03 . ";" . $fila_notas['nota3'];
	$cadena04 = $cadena04 . ";" . $fila_notas['nota4'];
	$cadena05 = $cadena05 . ";" . $fila_notas['nota5'];
	$cadena06 = $cadena06 . ";" . $fila_notas['nota6'];
	$cadena07 = $cadena07 . ";" . $fila_notas['nota7'];
	$cadena08 = $cadena08 . ";" . $fila_notas['nota8'];
	$cadena09 = $cadena09 . ";" . $fila_notas['nota9'];
	$cadena10 = $cadena10 . ";" . $fila_notas['nota10'];
	$cadena11 = $cadena11 . ";" . $fila_notas['nota11'];
	$cadena12 = $cadena12 . ";" . $fila_notas['nota12'];
	$cadena13 = $cadena13 . ";" . $fila_notas['nota13'];
	$cadena14 = $cadena14 . ";" . $fila_notas['nota14'];
	$cadena15 = $cadena15 . ";" . $fila_notas['nota15'];
	$cadena16 = $cadena16 . ";" . $fila_notas['nota16'];
	$cadena17 = $cadena17 . ";" . $fila_notas['nota17'];
	$cadena18 = $cadena18 . ";" . $fila_notas['nota18'];
	$cadena19 = $cadena19 . ";" . $fila_notas['nota19'];
	$cadena20 = $cadena20 . ";" . $fila_notas['nota20'];
	$cadenaprom = $cadenaprom . ";" . $fila_notas['promedio'];
	}	
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
              <?php if($_POST['ck_exm']==1){?>
              <td class="subitem">&nbsp;</td>
              <td class="subitem">&nbsp;</td>
              <?php }?>
              
            </tr>
				
<?			}
		}
	
  } 
  ?>
            
            <tr class="textonegrita"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 00-39 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena03)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena04)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena05)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena06)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena07)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena08)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena09)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena10)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena11)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena12)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena13)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena14)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena15)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena16)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena17)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena18)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena19)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje1($cadena20)?></div></td>
               
              
              <td class="subitem"><? porcentaje1($cadenaprom)?></td>
              <?php if($_POST['ck_exm']==1){?>
              <td class="subitem"><?php echo  (count($rex[$subsector][0])>0)?round(count($rex[$subsector][0])*100/$cont_ex)."%":"";?>
			   </td>
              <td class="subitem" align="center"><?php echo  (count($rpf[$subsector][0])>0)?round(count($rpf[$subsector][0])*100/@pg_numrows($result_alu))."%":"";?></td>
              <?php }?>
            </tr>
            <tr class="textonegrita"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 40-49 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena03)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena04)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena05)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena06)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena07)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena08)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena09)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena10)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena11)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena12)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena13)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena14)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena15)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena16)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena17)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena18)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena19)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje2($cadena20)?></div></td>
              
              <td class="subitem"><div align="left"><? porcentaje2($cadenaprom)?></div></td>
              <?php if($_POST['ck_exm']==1){?>
              <td class="subitem"><?php echo  (count($rex[$subsector][1])>0)?round(count($rex[$subsector][1])*100/$cont_ex)."%":"";?></td>
              <td class="subitem"><?php echo  (count($rpf[$subsector][1])>0)?round(count($rpf[$subsector][1])*100/@pg_numrows($result_alu))."%":"";?></td>
              <?php }?>
            </tr>
            <tr class="textonegrita"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 50-59 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena03)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena04)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena05)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena06)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena07)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena08)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena09)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena10)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena11)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena12)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena13)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena14)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena15)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena16)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena17)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena18)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena19)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje3($cadena20)?></div></td>
              
              <td class="subitem"><div align="left"><? porcentaje3($cadenaprom)?></div></td>
              <?php if($_POST['ck_exm']==1){?>
              <td class="subitem"><?php echo  (count($rex[$subsector][2])>0)?round(count($rex[$subsector][2])*100/$cont_ex)."%":"";?></td>
              <td class="subitem"><?php echo  (count($rpf[$subsector][2])>0)?round(count($rpf[$subsector][2])*100/@pg_numrows($result_alu))."%":"";?></td>
              <?php }?>
            </tr>
            <tr class="textonegrita"> 
              <td class="subitem">&nbsp;</td>
              <td class="subitem"><strong>% 
                entre --&gt; 60-70 </strong></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena01)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena02)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena03)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena04)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena05)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena06)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena07)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena08)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena09)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena10)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena11)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena12)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena13)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena14)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena15)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena16)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena17)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena18)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena19)?></div></td>
              <td class="subitem"><div align="left"><? porcentaje4($cadena20)?></div></td>
              
              <td class="subitem"><div align="left"><? porcentaje4($cadenaprom)?></div></td>
              <?php if($_POST['ck_exm']==1){?>
              <td class="subitem"><?php echo  (count($rex[$subsector][3])>0)?round(count($rex[$subsector][3])*100/$cont_ex)."%":"";?></td>
              <td class="subitem"><?php echo  (count($rpf[$subsector][3])>0)?round(count($rpf[$subsector][3])*100/@pg_numrows($result_alu))."%":"";?></td>
              <?php }?>
            </tr>
          </table><br>
<br>
<?php if($_POST['ck_lecc']==1 and $_PERFIL==0){?>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr  class="tablatit2-1">
    <td colspan="3">LECCIONARIO</td>
    </tr>
  <tr  class="tablatit2-1">
    <td width="82">NOTA</td>
    <td width="148">TIPO</td>
    <td width="412">DESCRIPCI&Oacute;N</td>
  </tr>
  <?php for($n=1;$n<=20;$n++)
{  
	$ob_reporte->nota = $n;
	$rs_lex=$ob_reporte->getLeccionario($conn);
	if(pg_numrows($rs_lex)>0){
		$fila_lex = pg_fetch_array($rs_lex,0);
?><tr class="item">
    <td><?php echo $fila_lex['nota'] ?></td>
    <td><?php echo $fila_lex['nombre'] ?></td>
    <td><?php echo $fila_lex['descripcion'] ?></td>
  </tr>
  <?php 
	}
  }?>
</table>

<?php }?>

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
		if ($arreglo[$o]>0 and $arreglo[$o]<=39){
			$cont1 = $cont1 + 1;
		}
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
function porcentaje5($cadena)
{
	$arreglo= explode(",",$cadena);
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
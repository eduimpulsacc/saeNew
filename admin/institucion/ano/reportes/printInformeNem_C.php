<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
  
//setlocale("LC_ALL","es_ES");

if($_PERFIL==0){
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
}

if(!isset($nota_nem)){
	
	$nota_nem=0;
	}
	
function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}
	
$institucion	= $_INSTIT;
$ano			= $_ANO;
$curso			= $cmb_curso;
$reporte		= $c_reporte;
$fin_ano		= $check_ano;

	$_POSP = 4;
	$_bot = 8;
	
	
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();

	
	/***************** INSTITUCION *****************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	$ob_reporte ->institucion=$institucion;
	
	
	/************* A�O ESCOLAR ****************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	/********* CURSO *******************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$ob_membrete->curso=$curso;
	$Cursos = $ob_membrete->curso($conn);
	$grado_curso = $ob_membrete->grado_curso;
	$ensenanza_curso = $ob_membrete->cod_ensenanza;
		
	/************* PROFE JEFE *************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
		
	/******* ALUMNOS ************************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte ->orden = $opcion;
	$ob_reporte ->retirado=0;
	$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	
	//echo $curso;
	//if (empty($curso)) //exit;
  
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
		
		
	}
	
	/*if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Notas_Finales_$Fecha.xls"); 
	}	*/

	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
		
	
		 
?>
<?
       //1.- calcular los numeros de ano a�os de las generaciones pasadas
	   $ob_reporte ->parte=$nro_ano;
	   $ob_reporte->limite = 3;
	  $numanos = $ob_reporte ->anosAtrasPHI($conn);
	  //2.- calcular los id de a�o de cada generacion para atras
	  for($a=0;$a<pg_numrows($numanos);$a++){
		$fila_anoant = pg_fetch_array($numanos,$a);
		$nro_ano_ant = $fila_anoant['nro_ano'];
		$id_ano_ant = $fila_anoant['id_ano'];
		
		//3.- tipos de ense�anza de esos a�os
		 $ob_reporte->ano = $id_ano_ant;
		 $rs_enseant = $ob_reporte->getEnsenanzaEgresado($conn);
		 
		 $te="";
		 for($ea=0;$ea<pg_numrows($rs_enseant);$ea++){
			 $fila_ea = pg_fetch_array($rs_enseant,$ea);
			 $te.=$fila_ea['ensenanza'].",";
			 }
		 
		 $ob_reporte->grado_curso=4;
		 $te = substr($te,0,-1);
		 $ob_reporte->cod_tipo=$te;
		
		$rs_aluprom =  $ob_reporte->AlumnosPromovidos($conn);
		
		for($alp=0;$alp<pg_numrows($rs_aluprom);$alp++){
		$fila_alp = pg_fetch_array($rs_aluprom,$alp);
		$rut_alumno_alp = $fila_alp['rut_alumno'];
		//echo "<br>".$id_ano_ant.".".$fila_alp['rut_alumno'];
		//4.- buscar a�os para atras de cada alumno
		$ob_reporte ->limite=4;
		$ob_reporte ->parte=$id_ano_ant;
		$numanosiA = $ob_reporte->anosAtrasPR($conn);	
		pg_numrows($numanosiA);
		
		for($ac=0;$ac<pg_numrows($numanosiA);$ac++){
			$fila_anoi = pg_fetch_array($numanosiA,$ac);
			$nanop=$fila_anoi['nro_ano']; 
			$ianop=$fila_anoi['id_ano']; 
			
			$grados = pg_numrows($numanosiA)-$ac;
			//5.- buscar si hay nota en concentracion en promocion
			$ob_reporte->grado_curso=$grados;
			$ob_reporte->alumno=$rut_alumno_alp;
			$rs_prom = $ob_reporte->getPromConcentracionByAno($conn);
			
			/**/
			
			//echo "<br>".$grados."-".$enses;
			
			if(pg_numrows($rs_prom)>0){
				$probG[$id_ano_ant][$rut_alumno_alp][]=pg_result($rs_prom,0);
				//echo $nota =  pg_result($rs_prom,0);
				
			}
			else{
				$enses = ($grados<3)?310:$ensenanza_curso;
				$ob_reporte->ensenanza = $enses;
				$ob_reporte->id_ano =$ianop;
				
				$rs_curso1 = $ob_reporte->getCursoAlumnoAnt($conn);
			$id_curso1= pg_result($rs_curso1,0);
			
			//buscar datos promocion
			$ob_reporte->ano= $id_ano1;
			$ob_reporte->curso = $id_curso1;
			$ob_reporte->situacion=1;
			$rs_prom = $ob_reporte->Promocion($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$id_ano_ant][$rut_alumno_alp][]=pg_result($rs_prom,4);
			}
			
			
			
			}
			 
		}
		//6.-calcular el promedio de cada alumno de la generacion
		$promTotalGen[$id_ano_ant][]=(array_sum($probG[$id_ano_ant][$rut_alumno_alp])/count($probG[$id_ano_ant][$rut_alumno_alp]));
		
	
		 $ordAlumnos[]=round(array_sum($probG[$id_ano_ant][$rut_alumno_alp])/count($probG[$id_ano_ant][$rut_alumno_alp]));
		
		}
		
		
		//7.- calcular rl promedio de cada generacin
		$generacon[]=array_sum($promTotalGen[$id_ano_ant])/count($promTotalGen[$id_ano_ant]);
	 }
	  
	
	$PMHistorico = max($ordAlumnos);
	$PGHistorico = round(array_sum($generacon)/count($generacon));
			
	$ob_reporte->nota=$PGHistorico;
	$nemHistorico= $ob_reporte->getNemNota($conn);
	$nemHistorico= pg_result($nemHistorico,2);
		
	
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
function exportar(){
			//form.target="_blank";
		window.location='printInformePlanillaNotasFinales_C.php?cmb_curso=<?=$curso?>&check_ano=<?=$fin_ano?>&c_reporte=<?=$c_reporte?>&opcion=<?=$opcion?>';
			//document.form.submit(true);
		return false;
}
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

if (empty($curso)){
     //exit;
}else{
   ?>
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="right">
        <td>
		<div id="capa0">
		<TABLE width="100%" align="center"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </TD>
		 
		    </TR></TABLE>
        </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	
	
	
	
	
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c�digo para tomar la insignia

		  if($institucion!=""){
			  if($institucion==24783){
					  echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
					 }else{
					  echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					 }
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
		  }?>
	  		</td>
		</tr>
    </table>
	</td>
  </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

<? } ?>



<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<td class="tableindex"><div align="center">INFORME PROMEDIOS NEM</div></td>
	</tr>
	<tr>
		<td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>A&Ntilde;O <? echo $nro_ano?></strong> </font></div></td>
	</tr>
</table>
<br>
	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">

            <td width="120"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>

        <td width="526"><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></font></td>
      </tr>
    </table>
	<br>
    <?php //if($_PERFIL==0){?>
<div align="center"> <font size="1" face="arial, geneva, helvetica">(*)Informaci&oacute;n referencial por no tener almacenado el promedio de los  4 a&ntilde;os</font></div><br>
<?php //}?><br>
	<table width="650" border="1" align="center" style="border-collapse:collapse">
	  <tr class="tableindex">
	    <td width="67" rowspan="2" class="subitem">RUT</td>
	    <td width="541" rowspan="2" class="subitem">ALUMNOS</td>
	    <td colspan="2" align="center" class="subitem">1er A&ntilde;o</td>
	    <td colspan="2" align="center" class="subitem">2do A&ntilde;o</td>
	    <td colspan="2" align="center" class="subitem">3er A&ntilde;o</td>
	    <td colspan="2" align="center" class="subitem">4 A&ntilde;o</td>
	    <td colspan="2" align="center" class="subitem">General</td>
     
       <td rowspan="2" align="center" class="subitem">R&aacute;nking</td>
     
      </tr>
	  <tr class="tableindex">
	    <td width="37" class="subitem">Prom.</td>
	    <td width="35" class="subitem">NEM</td>
	    <td width="37" class="subitem">Prom.</td>
	    <td width="35" class="subitem">NEM</td>
	    <td width="37" class="subitem">Prom.</td>
	    <td width="35" class="subitem">NEM</td>
	    <td width="37" class="subitem">Prom.</td>
	    <td width="35" class="subitem">NEM</td>
	    <td width="35" class="subitem">Prom.</td>
	    <td width="35" class="subitem">NEM</td>
         
      </tr>
      <? for($i=0;$i<pg_numrows($result_alu);$i++){
			$fila = pg_fetch_array($result_alu,$i);
			$sum_promg = 0;
			$cont_promg=0; 
			$rut_alumno = $fila['rut_alumno'];
			$ob_reporte->alumno=$fila['rut_alumno']; 
	  ?>
	  <tr class="textosimple">
	    <td class="item" nowrap>&nbsp;<?=$fila['rut_alumno'];?>-<?=$fila['dig_rut'];?></td>
	    <td class="item">&nbsp;<?=$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_alu'];?></td>
	    <td class="item" align="center"><?php 
			//si tengo notas este a&ntilde;o
			
			$sql="SELECT round(AVG(CAST(nt.promedio as integer))) as promedio
					FROM notas$nro_ano nt
					inner join ramo on ramo.id_ramo = nt.id_ramo
					WHERE rut_alumno=".$fila['rut_alumno']." AND promedio<>' ' AND promedio NOT IN  ('EX','x','MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N') and ramo.bool_pgeneral=1" ;	
				//	if($_PERFIL==0)echo $sql;	
				$rs_prom = pg_exec($conn,$sql);
				$promedio = pg_Result($rs_prom,0);
				if(intval($promedio)>0){
					$probG[$rut_alumno][]=$promedio;
					echo $nota= $promedio;
				}
				//si no hay promedio actual
			else{
			
			
			$nota="";
			//ver si existo en 1 medio
			$ob_reporte->grado_curso=1;
			$rs_prom = $ob_reporte->getPromConcentracionByAno($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,0);
				echo $nota =  pg_result($rs_prom,0);
				
			}else{
			//si no existe en concentracion, ir a buscar promocio a a&iuml;&iquest;&frac12;os anteriores
			if($grado_curso==1){
				$ob_reporte->parte= $nro_ano;
			//	echo $ob_reporte->parte;
			}else{
				
			if($grado_curso>1 && $grado_curso<=4){	
			if($grado_curso==4){
			$ob_reporte->parte = $nro_ano-3;
			}
			if($grado_curso==3){
			$ob_reporte->parte = $nro_ano-2;
			}
			if($grado_curso==2){
			$ob_reporte->parte = $nro_ano-1;
			}
			
			
			//echo $ob_reporte->parte;
			
			$ob_reporte->limite=1;
			$rano1 = $ob_reporte->anosAtras($conn);
			$ano1=pg_result($rano1,0); 
			$rs_ida1 =$ob_reporte->idAnosAtras($conn);
			$id_ano1 = pg_result($rs_ida1,0);
			$ob_reporte->id_ano= $id_ano1;
			$ob_reporte->ensenanza = 310;
			$rs_curso1 = $ob_reporte->getCursoAlumnoAnt($conn);
			$id_curso1= pg_result($rs_curso1,0);
			
			//buscar datos promocion
			$ob_reporte->ano= $id_ano1;
			$ob_reporte->curso = $id_curso1;
			$ob_reporte->situacion=1;
			$rs_prom = $ob_reporte->Promocion($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,4);
				echo $nota= pg_result($rs_prom,4);
			}
			
			}
			}
			}
			}
			
			?></td>
	    <td align="center" class="item"><?php
		if(strlen($nota)>0){
			$ob_reporte->nota=$nota;
			$rs_nemnota = $ob_reporte->getNemNota($conn);
			
			
		 echo pg_result($rs_nemnota,2);
		 }?></td>
	    <td class="item" align="center"><?php if($grado_curso>1){?>
	      <?php 
			//si tengo notas este a&ntilde;o
			
			$sql="SELECT round(AVG(CAST(nt.promedio as integer))) as promedio
					FROM notas$nro_ano nt
					inner join ramo on ramo.id_ramo = nt.id_ramo
					WHERE rut_alumno=".$fila['rut_alumno']." AND promedio<>' ' AND promedio NOT IN  ('EX','x','MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N') and ramo.bool_pgeneral=1" ;	
				//	if($_PERFIL==0)echo $sql;	
				$rs_prom = pg_exec($conn,$sql);
				$promedio = pg_Result($rs_prom,0);
				if(intval($promedio)>0){
					$probG[$rut_alumno][]=$promedio;
					echo $nota= $promedio;
				}
				//si no hay promedio actual
			else{
			
			
			$nota="";
			//ver si existo en 1 medio
			$ob_reporte->grado_curso=2;
			$rs_prom = $ob_reporte->getPromConcentracionByAno($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,0);
				echo $nota =  pg_result($rs_prom,0);
				
			}else{
			//si no existe en concentracion, ir a buscar promocio a a&iuml;&iquest;&frac12;os anteriores
			if($grado_curso==2){
				$ob_reporte->parte= $nro_ano;
				//echo $ob_reporte->parte;
			}else{
				
			if($grado_curso>1 && $grado_curso<=4){	
			if($grado_curso==4){
			$ob_reporte->parte = $nro_ano-2;
			}
			if($grado_curso==3){
			$ob_reporte->parte = $nro_ano-1;
			}
			if($grado_curso==1){
			$ob_reporte->parte = $nro_ano-0;
			}
			
			
			//echo $ob_reporte->parte;
			
			$ob_reporte->limite=1;
			$rano1 = $ob_reporte->anosAtras($conn);
			$ano1=pg_result($rano1,0); 
			$rs_ida1 =$ob_reporte->idAnosAtras($conn);
			$id_ano1 = pg_result($rs_ida1,0);
			$ob_reporte->id_ano= $id_ano1;
			$ob_reporte->ensenanza = 310;
			$rs_curso1 = $ob_reporte->getCursoAlumnoAnt($conn);
			$id_curso1= pg_result($rs_curso1,0);
			
			//buscar datos promocion
			$ob_reporte->ano= $id_ano1;
			$ob_reporte->curso = $id_curso1;
			$ob_reporte->situacion=1;
			$rs_prom = $ob_reporte->Promocion($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,4);
				echo $nota= pg_result($rs_prom,4);
			}
			
			}
			}
			}
			}
			
			?>
	      <?php }?></td>
	    <td align="center" class="item"><?php
		if($grado_curso>2){
		if(strlen($nota)>0){
			$ob_reporte->nota=$nota;
			$rs_nemnota = $ob_reporte->getNemNota($conn);
			
			
		 echo pg_result($rs_nemnota,2);
		 }
		}?></td>
	    <td class="item" align="center"><?php if($grado_curso>2){?>
	      <?php 
			//si tengo notas este a&ntilde;o
			
			$sql="SELECT round(AVG(CAST(nt.promedio as integer))) as promedio
					FROM notas$nro_ano nt
					inner join ramo on ramo.id_ramo = nt.id_ramo
					WHERE rut_alumno=".$fila['rut_alumno']." AND promedio<>' ' AND promedio NOT IN  ('EX','x','MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N') and ramo.bool_pgeneral=1" ;	
				//	if($_PERFIL==0)echo $sql;	
				$rs_prom = pg_exec($conn,$sql);
				$promedio = pg_Result($rs_prom,0);
				if(intval($promedio)>0){
					$probG[$rut_alumno][]=$promedio;
					echo $nota= $promedio;
				}
				//si no hay promedio actual
			else{
			
			
			$nota="";
			//ver si existo en 1 medio
			$ob_reporte->grado_curso=2;
			$rs_prom = $ob_reporte->getPromConcentracionByAno($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,0);
				echo $nota =  pg_result($rs_prom,0);
				
			}else{
			//si no existe en concentracion, ir a buscar promocio a a&iuml;&iquest;&frac12;os anteriores
			if($grado_curso==1){
				$ob_reporte->parte= $nro_ano;
			//	echo $ob_reporte->parte;
			}else{
				
			if($grado_curso>1 && $grado_curso<=4){	
			if($grado_curso==4){
			$ob_reporte->parte = $nro_ano-1;
			}
			if($grado_curso==3){
			$ob_reporte->parte = $nro_ano-0;
			}
			if($grado_curso==2){
			$ob_reporte->parte = $nro_ano-2;
			}
			
			
			//echo $ob_reporte->parte;
			
			$ob_reporte->limite=1;
			$rano1 = $ob_reporte->anosAtras($conn);
			$ano1=pg_result($rano1,0); 
			$rs_ida1 =$ob_reporte->idAnosAtras($conn);
			$id_ano1 = pg_result($rs_ida1,0);
			$ob_reporte->id_ano= $id_ano1;
			$ob_reporte->ensenanza = 310;
			$rs_curso1 = $ob_reporte->getCursoAlumnoAnt($conn);
			$id_curso1= pg_result($rs_curso1,0);
			
			//buscar datos promocion
			$ob_reporte->ano= $id_ano1;
			$ob_reporte->curso = $id_curso1;
			$ob_reporte->situacion=1;
			$rs_prom = $ob_reporte->Promocion($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,4);
				echo $nota= pg_result($rs_prom,4);
			}
			
			}
			}
			}
			}
			
			?>
	      <?php }?></td>
	    <td align="center" class="item"><?php if($grado_curso>1){
		if(strlen($nota)>0){
			$ob_reporte->nota=$nota;
			$rs_nemnota = $ob_reporte->getNemNota($conn);
			
			
		 echo pg_result($rs_nemnota,2);
		 }
		}
		 ?></td>
	    <td align="center" class="item"><?php  if($grado_curso==4){?>
	      <?php $ob_reporte->ano= $ano;
			$ob_reporte->curso = $curso;
			$ob_reporte->situacion=1;
			$rs_prom = $ob_reporte->Promocion($conn);
			if(pg_numrows($rs_prom)>0){
				$probG[$rut_alumno][]=pg_result($rs_prom,4);
				echo $nota4= pg_result($rs_prom,4);
			}
			else{
			$sql="SELECT round(AVG(CAST(nt.promedio as integer))) as promedio
					FROM notas$nro_ano nt
					inner join ramo on ramo.id_ramo = nt.id_ramo
					WHERE rut_alumno=".$fila['rut_alumno']." AND promedio<>' ' AND promedio NOT IN  ('EX','x','MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N') and ramo.bool_pgeneral=1" ;	
				//	if($_PERFIL==0)echo $sql;	
				$rs_prom = pg_exec($conn,$sql);
				$promedio = pg_Result($rs_prom,0);
				if(intval($promedio)>0){
					$probG[$rut_alumno][]=$promedio;
					echo $nota4= $promedio;
				}
				
			}
			
			?>
	      <?php }?></td>
	    <td align="center" class="item"><?php if(intval($nota4)>0){
			$ob_reporte->nota=$nota4;
			$rs_nemnota = $ob_reporte->getNemNota($conn);
			echo pg_result($rs_nemnota,2);
			}
		 ?></td>
   
		<td align="center" class="item"><?php 
		echo $nota_acum = round(array_sum($probG[$rut_alumno])/count($probG[$rut_alumno]));
		
		$ob_reporte->nota=$nota_acum;
			$rs_nemnota = $ob_reporte->getNemNota($conn);
		?>
	    </td>
	    <td align="center" class="item">
		
		<?php echo pg_result($rs_nemnota,2);?></td>
       
			 <? //hay que calcular los 4 a�os para atras de los ultimos 3 a�os 
			  ?>
       <td colspan="2" align="center" class="subitem">
       <?php 
	   //calcular puntaje ranking
	  	$PMHistorico; //maximo promedio de todos los a�o
		$PGHistorico; //promedio de las tres generaciones para atras
	  // echo $nota_acum;
	   //si el promedio acumulado es <= a promedio historico
	   if($nota_acum<=$PGHistorico){
			$ob_reporte->nota=$nota_acum;
			$rs_nemnota = $ob_reporte->getNemNota($conn);
			echo pg_result($rs_nemnota,2);  
		  }
		  //si promedio acumulado >= maximo historico
		  else if($nota_acum>=$PMHistorico){
			echo 850;  
		  }
		  //calcular la pinche formula de ranking
		  else{
			  
			 	$ob_reporte->nota=$nota_acum;
				$rs_nemnota = $ob_reporte->getNemNota($conn);
				
				$PrMax= 850; //siempre es 850
				
				//PnHist->convertir el acumulado a puntaje nem
				$PnHist = $nemHistorico;  
				
				$Nhmax = $PMHistorico/10;
				$Nhist = $PGHistorico/10;
				$acum = $nota_acum/10;
				
				//parte 1, calcular puntaje que se resta
				 $m= ($PrMax-$PnHist)/($Nhmax-$Nhist);
				 
				$b = $PrMax-$m*$Nhmax;
				 
				echo $puntajeRanking = round($b+($m*$acum));
				 
			
			  
			  }
		  
		  echo(count($probG[$rut_alumno])!=4)?"*":"";
	   ?>
       
       </td>
       <?php }?>
      </tr>
      <? } ?>
	  </table>
	<br>
<p>
 
  
 
  
</p>


 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>

 <!-- FIN CUERPO DE LA PAGINA -->


<table width="650" border="0" align="center">
  <tr>
    <td><div align="left" class="subitem">
	<font face="verdana,Arial, Helvetica, sans-serif" size="2">
      <? 
	 setlocale(LC_TIME,"spanish");
	 $hoy=strftime("%A %d de %B de %Y");
	 echo ucwords($hoy); 
	 ?>
	 </font>
    </div></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>

<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php
/*if($_PERFIL==0){
	print_r($_POST);
	}*/

require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

if ($institucion==299){
	$whe_ensenanza=" OR (ensenanza = 10)";
   //	OR (curso.grado_curso<5) and (curso.ensenanza<>110)
}


?>
<?php 
  //setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$cmb_alumno;
	$curso			=$cmb_curso;
	$reporte		=$c_reporte;
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
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	
	
	//$sqlEns="select ensenanza from curso where id_curso =".$c_curso;
	$sqlEns="select ensenanza from curso where id_curso =".$curso;
	$resEns=@pg_exec($conn, $sqlEns);
	$ensenanza=@pg_fetch_array($resEns,0);
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);	
	
	$sqlAlu="select (trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat)) as nombre from alumno where rut_alumno=".$alumno;
	$resAlu=@pg_exec($conn, $sqlAlu);
	$nombreAlu=@pg_fetch_array($resAlu);
	
	$sqlAno="select nro_ano from ano_escolar where id_ano=".$_ANO;
	$resAno=@pg_exec($conn, $sqlAno);
	$ano=@pg_fetch_array($resAno,0);
	
	$sqlInsit="SELECT *FROM institucion WHERE rdb=".$_INSTIT;
	$resInstit=@pg_exec($conn, $sqlInsit);
	$filaInstit=@pg_fetch_array($resInstit,0);
	
	$sqlReg="select nom_reg from region where cod_reg=".$filaInstit['region'];
	$resReg=@pg_exec($conn, $sqlReg);
	$region=@pg_fetch_array($resReg,0);
	
	$sqlPro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad'];
	$resPro=@pg_exec($conn, $sqlPro);
	$ciudad=@pg_fetch_array($resPro,0);	
	
	$sqlCom="select nom_com from comuna where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
	$resCom=@pg_exec($conn, $sqlCom);
	$comuna=@pg_fetch_array($resCom,0);	
	
	
	 $sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, trabaja.cargo FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23)";
		
	    /*$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE ( ((trabaja.rdb)=".$institucion.") AND trabaja.cargo='1' OR trabaja.cargo='23');";*/
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
        $cargo_dir    = $fila['cargo'];		
						
    if ($cargo_dir==1){
	    $cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($institucion==9239){
		$cargo_dir  = "Directora";
		$cargo_dir2 = "Directora";
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		

if($cb_ok!="Buscar"){
 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Licencia_enseñanza_media_basica_$fecha_actual.xls"); 	 
}	


	
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'certificadoEBasicaMedia.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
			function exportar(){
			window.location='printCertificadoEBasicaMedia_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
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
 font-size:<?=($ob_config->tamanoS+3);?>px;
 }
.Estilo1 {font-size: 14px; }
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->



<table width="700"  border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><div id="capa0">
<table width="100%">
  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
<td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>  
		  
	    </td></tr></table>
     
      </div></td>
  </tr>
</table>
<?
if ($alumno==0){
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano=$_ANO;
		$ob_reporte ->retirado =0;
		$result_todos =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano=$_ANO;
		$ob_reporte ->curso = $curso;
		$result_todos =$ob_reporte ->TraeUnAlumno($conn);
	}
	
		

for($x=0;$x<pg_numrows($result_todos);$x++){ 
    $fila_todos = pg_fetch_array($result_todos,$x);
    $fila_to2 = $fila_todos['nombre_alu']." &nbsp; ".$fila_todos['ape_pat']." &nbsp; ".$fila_todos['ape_mat'];
	$rut = $fila_todos['rut_alumno']."-".$fila_todos['dig_rut'];
	
	$reg=$fila_todos['num_mat'];
	if($reg==0){
		$reg= "";
		}else{
		$reg;
		}
	
	$sql=" SELECT alumno.rut_alumno FROM alumno INNER JOIN promocion ON alumno.rut_alumno=promocion.rut_alumno INNER JOIN curso ON promocion.id_ano=curso.id_ano AND promocion.id_curso=curso.id_curso left join especialidad ON curso.cod_es=especialidad.cod_esp WHERE situacion_final='1' AND curso.id_ano=".$_ANO."  AND grado_curso = 4 ORDER BY ensenanza,ape_pat, ape_mat, nombre_alu";
	$rs_promocion = @pg_exec($conn,$sql);
	for($r=0;$r<@pg_numrows($rs_promocion);$r++){
		$fils = @pg_fetch_array($rs_promocion,$r);
		if($fils['rut_alumno']==$fila_todos['rut_alumno']){
			$cont=$r+1;
			break;
		}
	}
    ?>
<table width="90%" height="0%" border="3" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
<tr valign="top">
      <td>
	   <?
	   if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
	   }  ?>	
	
	
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>

		<tr> 
          <td colspan="4"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>REPUBLICA 
              DE CHILE</strong></font></div></td>
          <td width="198" rowspan="6" align="center">
          <? if($chkMODELO==0){?>
          <img src="../../../../LOGO_GOB_2.jpg" width="127" height="127">
          <? }else{
          $result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
           } ?>
          </td>
          <td width="69"> <div align="left"></div></td>
          <td width="143"><div align="left"></div>
            <font size="1" face="Arial, Helvetica, sans-serif">REGION</font></td>
          <td width="198"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ob_membrete->region;?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">MINISTERIO 
              DE EDUCACION</font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">PROVINCIA</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ob_membrete->provincia;?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="1">DIVISION 
              DE EDUCACION GENERAL</font></font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">COMUNA</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ob_membrete->comuna;?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="1">SECRETARIA 
              REGIONAL MINISTERIAL DE EDUCACION</font></font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">ROL BASE DE DATOS</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($_INSTIT,0,'','.');?>-<? echo $ob_membrete->dig_rdb;?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4" rowspan="3">&nbsp;</td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O ESCOLAR 
            </font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?PHP echo $ob_membrete->nro_ano;?></font></div></td>
        </tr>
        <tr> 
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">Decreto Cooperador 
            de la Funci&oacute;n</font></td>
          <td><div align="left"></div></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">Educacional del 
            Estado</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaInstit['nu_resolucion']." "; impF($filaInstit['fecha_resolucion']); ?></font></div></td>
        </tr>
        <tr> 
          <td width="235">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 

          <td width="10%">&nbsp;</td>
          <td width="12%">
	        <div align="center">
	          <? if ($chkMODELO==1){ ?>
		      <img src="../../../../tmp/img_religiosa.png" width="127" height="127">
			  
		 <? }else{
			
		
		      ?>  
	          <?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>
	          
              <? } ?>	  
          </div></td>
          <td width="58%"><div align="center"><strong><font size="5" face="Arial, Helvetica, sans-serif"><? if($institucion==1518 or 2163){ echo "LICENCIA "; }else{ echo "CERTIFICADO "; }?>
              DE ENSE&Ntilde;ANZA 
              <?php if ($ensenanza['ensenanza']>110){ 
			  			echo "MEDIA"; 
					}
					if (($ensenanza['ensenanza']<=110) and ($ensenanza['ensenanza']!="") and ($ensenanza['ensenanza']!=10)){
						 echo "BASICA";
				   }
				   if(($ensenanza['ensenanza']==10)){
						 echo "PARVULARIA";
				   }
				   
				   if ($_INSTIT==24300){
				       echo "HUMANÍSTICO - CIENTÍFICA";
				   }				   
				   
					?>
          </font></strong></div></td>
          <td width="20%">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="30%"></td>
          <td width="59%" rowspan="3"><p>&nbsp;</p>
            <p class="Estilo1">Establecimiento 
              : <strong><?php echo  $ob_membrete->ins_pal?></strong></p>
            <p class="Estilo1">CERTIFICO que 
              don(a) : <strong>   <?php  echo $ob_reporte->tildeM($fila_to2); ?></strong></p>
            
			<p class="Estilo1">R.U.T.: <b><?=$rut;?></b>, <? if ($institucion !=1756) echo "número registro $reg";?></p>
			
            <span class="Estilo1">
			  <?php if ($ensenanza['ensenanza']>110){ 
			  			$educacion="Media"; 
					}
					if(($ensenanza['ensenanza']<=110) and ($ensenanza['ensenanza']!="") and ($ensenanza['ensenanza']!=10)){
						 $educacion="General B&aacute;sica y";
				   }
				   	if(($ensenanza['ensenanza']==10)){
						 $educacion="Pre Básica";
				   }
				   if ($_INSTIT==24300){
				        $educacion_2 = "Media Humanístico - Científica";
				   }				   
				   
				   ?>
            </span>
			  <? if($ck_parvulo!=1){?>
		    <pre class="Estilo1" align="justify">ha aprobado todos los cursos correspondiente a la Educaci&oacute;n <?php echo $educacion?>, <? echo $educacion_2; ?> 

por lo tanto, ha dado cumplimiento a la obligatoriedad escolar dispuesta 

en el art&iacute;culo 19, N&ordm; 10 de la Constituci&oacute;n Pol&iacute;tica de la Rep&uacute;blica de Chile<br>

</pre>
			<? }else{?>
		    <pre class="Estilo1" align="justify">Ha cursado satisfactoriamente los niveles correspondiente a la Educación Pre Básica.<br>
y, por lo tanto, ha dado cumplimiento a la obligatoriedad escolar dispuesta 

en el art&iacute;culo 19, N&ordm; 10 de la Constituci&oacute;n Pol&iacute;tica de la Rep&uacute;blica de Chile<br>

</pre>
 
</pre>
			
			
			<? } ?>
		  </td>
          <td width="16%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="30%">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td width="30%">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
       <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
       &nbsp;
	   	 <? 
	  setlocale("LC_ALL","es_ES");
	  echo $dia." de ".$mes." del ".$ano2?></td>
  </tr>
</table>
<? 
    //// salto de página
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";


} ?>
<!-- FIN CUERPO DE LA PAGINA -->


</body>
</html>
<? pg_close($conn);?>
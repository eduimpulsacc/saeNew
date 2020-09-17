
<? 
require('../../../../../../util/header.inc');
//require('../../../../util/LlenarCombo.php3');
//require('../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion=$_INSTIT;
	$ano=$_ANO;
	$curso=$cmb_curso;
	$alumno=$c_alumno;  
	$reporte=$c_reporte;
	$POSP=4;
	$_bot=8;
	
	if($_PERFIL==0){
	//show($_POST);
	//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	if($institucion==1518){
		$Curso_pal = CursoPalabra($curso, 3, $conn);
	}else{
		$Curso_pal = CursoPalabra($curso, 0, $conn);
	}
	if($institucion==4772){
		$Curso_pal;
		strtr($Curso_pal,'-','º');
		$Curso_pal;
		
		}

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

	//--------------------------------
	// CURSO
	//--------------------------------
 	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto,plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
	$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto and plan_estudio.rdb=".$institucion.") INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$num_consulta = @pg_numrows($result_curso);
	
	if ($num_consulta==0){
	      /// el plan es propio, hacer otra cosnulta
		  
		 /* $sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
		  $sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN incluye_propio ON curso.cod_decreto = incluye_propio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		  $sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";*/
		  
		  	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto,plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
			$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 			$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
		  $result_curso =@pg_Exec($conn,$sql_curso);
		  $num_consulta = @pg_numrows($result_curso);
	}else{
	
	    /// nada ya trae informacion
	}
	
	  

	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	//$curso = $fila_curso['id_curso'];
	if($institucion==14860){
		$Curso_pal = CursoPalabra($curso, 4, $conn);
	}else{
		$Curso_pal = CursoPalabra($curso, 0, $conn);
	}
	$grado = $fila_curso['grado_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	if($institucion==5661 || $institucion==4655){
		$ensenanza_pal=str_replace('CIENTÍFICO','CIENTÍFICA',$fila_curso['nombre_tipo']);
	}else{
		$ensenanza_pal = $fila_curso['nombre_tipo'];
	}
	$cod_decreto = $fila_curso['cod_decreto'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	$cod_es = $fila_curso['cod_es'];
	$truncado_per=$fila_curso['truncado_per'];
	//-------------------------
	if ($ensenanza>309 and $grado>=1){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		
		if($institucion==1518){
			$especialidad = ", ESPECIALIDAD DE ".$fila_espe['nombre_esp'];
		}else{
				$especialidad = ", ".$fila_espe['nombre_esp'];
		}
		
	}
	//if($_PERFIL==0) echo "especialidad--".$especialidad;
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	if ($alumno==0){
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$ob_reporte ->retirado=0;
		$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	}else{
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$ob_reporte ->alumno =$alumno;
		$result_alu = $ob_reporte ->FichaAlumnoUno($conn);
	}


	//-------------------------------- 
	
    $q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	//echo "n1 es: $n1 <br>";
	
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
	//echo "c: $cargo <br>";
	
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		if($institucion!=770){
			$cargo_dir2 = "Director(a)";
		}else{
			$cargo_dir2 = "Director";
		}
	}
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}	
	
	if ($institucion ==2278) { 
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
		}
	if($cargo==1 and $_INSTIT==9239){
	    $cargo_dir = "Directora";
	    $cargo_dir2 = "Directora";
	}	
	
/*if($cb_ok!="Buscar"){ 
	$fecha_actual = date('d-m-Y_H:i');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Certificado_Estudios_$fecha_actual.xls"); 	 
}*/
	function rut( $rut ) {
    return number_format( substr ( $rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $rut, strlen($rut) -1 , 1 );
	}
	
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			//echo "aut->".$aut;
			
		
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
		}
		
		else{
		$crp=1;
		}
	
	if($institucion==25478){
			$crp=0;
		}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'CertificadoEstudios.php?institucion=$institucion';
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
function exportar(){
				//form.target="_blank";
				window.location='printInformeCertificadoEstudios_C.php?cmb_alumno=<?=$cmb_alumno?>&c_reporte=<?=$reporte?>&cmb_curso=<?=$cmb_curso?>&dia=<?=$dia?>&mes=<?=$mes?>&ano2<?=$ano2?>&final=<?=$final?>&txtESPACIO=<?=$txtESPACIO?>&filas=<?=$filas?>';
				return false;
	}
function cerrar(){ 
window.close() 
} 
</script>

</head>
<!--<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">--><!-- onLoad="window.print();"-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();">
 <!-- INGRESO DEL CUERPO DE LA PAGINA -->
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

<?

if ($curso != 0){
  ?>
<center> 
	<!--<div id="capa0">	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="left">
	  <td width="1%">
	  <? if($institucion!=1971){?>
	  <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
       <? } ?>
	    <td align="right" >
          <strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2" color="#000099">ESTE REPORTE SE IMPRIME EN HOJA TAMA&Ntilde;O OFICIO </font></strong>		</td>
        <td align="right">
		<? if($institucion!=1971){?>
		<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
      	<? if($_PERFIL == 0){?>
		<td align="right"><input name="button3" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>
      	<? }
		} ?>
	  </tr>
    </table>	
    </div>-->	
   <?
}

?>   


<? 
$cadalu="";
$cont_alumnos = pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)

{
		
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$cadalu.=$alumno.",";
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	if ($firma==0){
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['nombre_alu']) . " " . trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat'])));
	}else{
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	}
	$curso = $fila_alu['id_curso'];
	
	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<? if($institucion != 770){ ?>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="150" rowspan="5" align="left" valign="top">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		$fecha_resolucion = $fila_foto['fecha_resolucion'];
		$ano_solo = substr($fecha_resolucion,0,4);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
		</td>
		<td width="198" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARÍA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
		    </div></td>
 <td width="161" rowspan="5"><? //} ?>
   <?
		//$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		//$arr=@pg_fetch_array($result,0);
		//$fila_foto = @pg_fetch_array($result,0);
		//if 	(!empty($fila_foto['insignia']))
		//{
		//	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
		//	$retrieve_result = @pg_exec($conn,$output);?></td>			
		<td width="90"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="191"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $ob_membrete->region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? 
		//echo $institucion;
		if ($institucion==12838){
		echo "CALAMA";
		}else{
		echo $ob_membrete->provincia;
		}
		?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $ob_membrete->comuna?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_ano?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>
<?  }else{ ?>
		<br><br><br><br><br>
<?  } ?> 
	<table width="650" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="4"><strong>CERTIFICADO LENGUAGE Y MATEM&Aacute;TICAS</strong></font></td>
      </tr>
	  <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="3"><?=$ob_membrete->ins_pal;?></font></td>
      </tr>
	   <tr >
        <td align="center">
		<?
		if ($institucion==770){ ?>
		     <font face="Verdana, Arial, Helvetica, sans-seri" size="2"><? echo $ensenanza_pal; ?></font>
	<?	}else{ ?>		
		     <font face="Verdana, Arial, Helvetica, sans-seri" size="3"><? echo $ensenanza_pal; ?></font>
			 
     <? } ?>	    </td>
	  </tr>
    </table>
                              
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><strong><? if($institucion==770){ echo "AÑO ESCOLAR $nro_ano"; }else{ echo strtoupper($nombre_institu);} ?></strong></font><br><br></td>
	  </tr>	  
	  <tr>
	  <?
	  //if($institucion==11203 or $institucion==287){ //Imprime Todo Seguido
	  if($rd_tipo==2){?>
		<td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"> Reconocido oficialmente por el Ministerio de Educación de la República de Chile según <? if($institucion==12086){ echo "RESOLUCIÓN EXENTA Nº 1379 DE FECHA 16 DE JUNIO DE 1987, MODIFICADA Y AMPLIADA SEGÚN RESOLUCIÓN EXENTA"; }else{ echo "DECRETO ";}?> <br> 
		      <strong>N&ordm; 
		      <? echo $nu_resolucion ?> de  <?=$ano_solo ?></strong> Rol Base de Datos <strong>Nº <? echo $rolbasededatos?></strong> otorga el presente Certificado de Calificaciones  Anuales y Situación Final a 
			   DON(A) <u><strong><? echo $ob_reporte->tildeM($nombre_alu); ?></strong></u>&nbsp;&nbsp;Run <strong><? echo rut($rut_alumno); ?></strong> del <strong><? echo $Curso_pal . $especialidad ?></strong> de acuerdo al plan de estudios aprobados por el Decreto 
			   	<strong>Nº <? 
			   if($institucion==253){
				   	echo "5715 de 2001";
			   }else{				   
				   echo $nombre_decreto;
			   }?></strong> Reglamento de Evaluación y Promoción Escolar Decreto exento de Evaluación <strong>Nº <? echo $nombre_decreto_eval ?></strong>
		  </font></td>
         <?php  }elseif($institucion==6122 && $fila_curso['ensenanza']=110 &&($fila_curso['grado_curso']==7 || $fila_curso['grado_curso']==8)){?>
          <td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1">
              RECONODICO OFICIALMENTE POR EL MINISTERIO DE EDUCACIÓN SEGPUN RES. REC. OFICIAL/DOC. TRASPASO <strong>N&ordm; 3848 DEL AÑO 2015</strong> Rol Base de Datos Nº  
              </font>
              <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><strong><? echo $rolbasededatos?></strong> OTORGA EL PRESENTE CERTFICADO DE CALIFICACIONES ANUALES Y SITUACIÓN FINAL  A DON(A) <strong><? echo $ob_reporte->tildeM($nombre_alu); ?></strong> RUN: <strong><? echo rut($rut_alumno); ?></strong> DEL <strong><? echo $Curso_pal . $especialidad ?></strong> DE ACUERDO AL PLAN Y PROGRAMAS DE ESTUDIO APROBADOS POR DECRETO O RESOL. EXENTA DE EDUCACIÓN <strong>N&ordm; 169 DE 2014</strong> MODIFICADO POR DECRETO <strong>N&deg; 628 DE 2016</strong> Y REGLAMENTO DE EVALUACIÓN Y PROMOCIÓN ESCOLAR DTO. EXENTO <strong>N&ordm; 511 DE 1997</strong></font></td>
		  
		  <?php 
		    }
			//media
			elseif($institucion==6122 && $fila_curso['ensenanza']=310 &&($fila_curso['grado_curso']==1 || $fila_curso['grado_curso']==2)){?>
          <td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1">
              RECONODICO OFICIALMENTE POR EL MINISTERIO DE EDUCACIÓN SEGPUN RES. REC. OFICIAL/DOC. TRASPASO <strong>N&ordm; 3848 DEL AÑO 2015</strong> Rol Base de Datos Nº  
              </font>
              <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><strong><? echo $rolbasededatos?></strong> OTORGA EL PRESENTE CERTFICADO DE CALIFICACIONES ANUALES Y SITUACIÓN FINAL  A DON(A) <strong><? echo $ob_reporte->tildeM($nombre_alu); ?></strong> RUN: <strong><? echo rut($rut_alumno); ?></strong> DE <strong><? echo $Curso_pal . $especialidad ?></strong> DE ACUERDO AL PLAN Y PROGRAMAS DE ESTUDIO APROBADOS POR DECRETO O RESOL. EXENTA DE EDUCACIÓN <strong>N&deg; 1358 DE 2011</strong> MODIFICADO POR DECRETO <strong>1264 DE 2016 </strong> Y REGLAMENTO DE EVALUACI&Oacute;N Y PROMOCI&Oacute;N ESCOLAR DTO. EXENTO <strong>N&deg; 112 DE 1999</strong></font></td>
		  
		  <?php 
		    }
			
			else{ //Imprime el nombre y el rut en una linea aparte
	  ?>
		<td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"> Reconocido oficialmente por el Ministerio de Educación de la República de Chile según <? if($institucion==1590){ echo "Ley Nº12446 DE 1957 y exento Nº 0540 de 1997,";}elseif($institucion==17686){ echo "DECRETO COOPERADOR <strong>".$nu_resolucion ?> de  <?=$ano_solo.",";?> </strong><? }elseif($institucion==9940 and $ensenanza==310) { echo "DECRETO <b>Nº 03016 DE 1977 </b>";}else{ echo "DECRETO ";?>  <strong>N&ordm; 
		      <? echo $nu_resolucion ?> de  <?=$ano_solo;} ?></strong> Rol Base de Datos <strong>Nº <? echo $rolbasededatos?></strong> otorga el presente Certificado de Calificaciones  Anuales y Situación Final a 
			   DON(A) <strong><? echo $ob_reporte->tildeM($nombre_alu) ?></strong>, Run <strong><? echo rut($rut_alumno) ?></strong>  
			   del <strong><? 
			   	if($institucion==12761){
					$Curso_pal=str_replace("-","º",$Curso_pal);	
				}

			   	if($institucion==5661){
					echo $especialidad = str_replace('CIENTÍFICO','CIENTÍFICA',$Curso_pal);				
				}else{
			   	    echo $Curso_pal . $especialidad;
				}	
				 ?></strong> de acuerdo al plan de estudios aprobados por 
                 <? if($institucion==4772 or $institucion==17686){
					 	echo "la resolución exenta ";
				 }else{
                 		echo "el Decreto ";
				 } 
				?>
			   <strong>Nº <?  
			   if ($institucion==25182){
			   		echo "150 de 2007, modifica por Nº 4142 de 2009";
			   }elseif($institucion==565 and $ensenanza==310 and ($grado==3)){
				   $numdec = "y Nº 128 de 2001";
				   echo $nombre_decreto;//.$numdec;
			   }elseif($institucion==565 and $ensenanza==310 and ($grado==4)){
				   $numdec = "y Nº 344 de 2002";
				  echo $nombre_decreto;//.$numdec;
			    }elseif(($institucion==1709 || $institucion==9276) and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
				   $numdec = "y Nº 1363 de 2011";
				  echo $nombre_decreto.$numdec;
				/*}elseif($institucion==253 and $ensenanza==310 and ($grado==1 or $grado==2)){
					echo "5715 de 2001";*/
				
				}elseif( $institucion==9276 and $ensenanza==310 and ($grado==1)){
					 $numdec = "y Nº 1358 de 2011";
					  echo $nombre_decreto;//.$numdec;
					
				}elseif($institucion==1599  and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
					echo "1363  de 2011 ";
				
				}elseif($institucion==1603 and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
					echo "1363  de 2011 ";
					
				/*}elseif($institucion==133 and $ensenanza==310 and ($grado==1 or $grado==2 or $grado==3 or $grado==4)){
					echo "5715  del 2001 ";*/
				}elseif($institucion==326 and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
					echo "256 del 2009 ";			
					
				}else{	
					echo $nombre_decreto;
			  }?></strong> Reglamento de Evaluación y Promoción Escolar Decreto exento de Evaluación <strong>Nº <? echo $nombre_decreto_eval ?></strong>
		  </font></td>
	    <? } ?>
	  </tr>
	</table>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>SUBSECTOR, ASIGNATURA O M&Oacute;DULO </strong></font></td>
		<td colspan="2" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>1&deg;</strong></font></td>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>2&deg;</strong></font></td>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>3&deg;</strong></font></td>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>4&deg;</strong></font></td>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>GENERAL</strong></font></td>
		</tr>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>LENGUAJE</strong></font></td>
	    <td colspan="2" align="center">
        <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
         <? 
		  $ob_reporte->alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano-3;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="14,27,11224";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pl[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}
		
		/* $numano = $ob_reporte->anosAtras($conn);
		 
		 $nano_ant =  pg_result($numano,0);
		 
		 $ob_reporte->nro_ano = $nano_ant;
		
		 $ob_reporte->ramo="14,27,11224";
		 $rs_prom = $ob_reporte->getPromedioHAsig($conn);*/

			
		
		
		?></font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? 
		  $ob_reporte->alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano-2;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="14,27,11224";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pl[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}
		
		/* $numano = $ob_reporte->anosAtras($conn);
		 
		 $nano_ant =  pg_result($numano,0);
		 
		 $ob_reporte->nro_ano = $nano_ant;
		
		 $ob_reporte->ramo="14,27,11224";
		 $rs_prom = $ob_reporte->getPromedioHAsig($conn);*/

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? 
		  $ob_reporte->alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano-1;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="14,27,11224";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pl[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}
		
		

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
        	      <? 
		  $ob_reporte->alumno=$alumno;
		  $ob_reporte->rut_alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		 
		 $sump=0;
					$cump=0;
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="14,27,11224";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pl[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}else{
		
			
			$ob_reporte->ano = $ano;
			$ob_reporte->nro_ano = $nro_ano;
			$ob_reporte->curso = $_POST['cmb_curso'];
			$ob_reporte->ramo="14,27,11224";
			
			$ramoAnt = $ob_reporte->ramosSubAtras($conn);
			$ra = pg_result($ramoAnt,0);
			$ob_reporte->ramo = $ra;
			
			$rs_not = $ob_reporte->Promedio1x($conn);
			
			if(pg_numrows($rs_not)>0){
				for($p=0;$p<pg_numrows($rs_not);$p++){					
				$filap =pg_fetch_array($rs_not,$p);
					$promp = $filap['promedio'];
					
					if($promp>0){
						$sump=$sump + $promp;
						$cump++;
						}
						$prompp=round($sump/$cump);
						$pl[$alumno][]=$prompp;				
					}
					if($prompp>0){
					echo $prompp;
					}
					
					
				/* if(pg_numrows($rs_prom)>0){
					$pl[$alumno][]=$rs_not;
					echo pg_result($rs_prom,0);
				}	*/
			}
		
		}
		
		

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><?php 
		$gpl = round(array_sum($pl[$alumno])/count($pl[$alumno]),0);
		
		echo ($gpl>0)?$gpl:"";
		 ?></font></td>
	    </tr>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>MATEM&Aacute;TICAS</strong></font></td>
	    <td colspan="2" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? 
		  $ob_reporte->alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano-3;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="5";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pm[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}
		
		/* $numano = $ob_reporte->anosAtras($conn);
		 
		 $nano_ant =  pg_result($numano,0);
		 
		 $ob_reporte->nro_ano = $nano_ant;
		
		 $ob_reporte->ramo="14,27,11224";
		 $rs_prom = $ob_reporte->getPromedioHAsig($conn);*/

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? 
		  $ob_reporte->alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano-2;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="5";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pm[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}
		
		/* $numano = $ob_reporte->anosAtras($conn);
		 
		 $nano_ant =  pg_result($numano,0);
		 
		 $ob_reporte->nro_ano = $nano_ant;
		
		 $ob_reporte->ramo="14,27,11224";
		 $rs_prom = $ob_reporte->getPromedioHAsig($conn);*/

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? 
		  $ob_reporte->alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano-1;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="5";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pm[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}
		
		/* $numano = $ob_reporte->anosAtras($conn);
		 
		 $nano_ant =  pg_result($numano,0);
		 
		 $ob_reporte->nro_ano = $nano_ant;
		
		 $ob_reporte->ramo="14,27,11224";
		 $rs_prom = $ob_reporte->getPromedioHAsig($conn);*/

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? 
		  $ob_reporte->alumno=$alumno;
		  $ob_reporte->rut_alumno=$alumno;
		 $ob_reporte->institucion = $institucion;
		 $ob_reporte->parte = $nro_ano;
		 $ob_reporte->limite = 1;
		 $anoAnt = $ob_reporte->idAnosAtras($conn);
		
		 $idanoAnt  =  pg_result($anoAnt,0);
		 
		 $ob_reporte->ano = $idanoAnt;
		 $cuant = $ob_reporte->CursoPromedioSubAlumno($conn);
		 
		 $sump=0;
					$cump=0;
		
		 
		 if(pg_numrows($cuant)>0){
			  $cursoant = pg_result($cuant,0);
		 $ob_reporte->curso = $cursoant;
			 $ob_reporte->ramo="5";
			 
			 $ramoAnt = $ob_reporte->ramosSubAtras($conn);
			  $ra = pg_result($ramoAnt,0);
			  $ob_reporte->ramo = $ra;
			$rs_prom = $ob_reporte->PromedioSubAlumnosIn($conn);
			 
			 if(pg_numrows($rs_prom)>0){
			$pm[$alumno][]=pg_result($rs_prom,0);
			echo pg_result($rs_prom,0);
			}
			
		}else{
		
			
			$ob_reporte->ano = $ano;
			$ob_reporte->nro_ano = $nro_ano;
			$ob_reporte->curso = $_POST['cmb_curso'];
			$ob_reporte->ramo="5";
			
			$ramoAnt = $ob_reporte->ramosSubAtras($conn);
			$ra = pg_result($ramoAnt,0);
			$ob_reporte->ramo = $ra;
			
			$rs_not = $ob_reporte->Promedio1x($conn);
			
			if(pg_numrows($rs_not)>0){
				for($p=0;$p<pg_numrows($rs_not);$p++){					
				$filap =pg_fetch_array($rs_not,$p);
					$promp = $filap['promedio'];
					
					if($promp>0){
						$sump=$sump + $promp;
						$cump++;
						}
						$prompp=round($sump/$cump);
						$pm[$alumno][]=$prompp;				
					}
					if($prompp>0){
					echo $prompp;
					}
					
					
				/* if(pg_numrows($rs_prom)>0){
					$pl[$alumno][]=$rs_not;
					echo pg_result($rs_prom,0);
				}	*/
			}
		
		}
		
		

			
		
		
		?>
	    </font></td>
	    <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><?php 
		$gpm = round(array_sum($pm[$alumno])/count($pm[$alumno]),0);
		
		echo ($gpm>0)?$gpm:"";
		 ?></font></td>
	    </tr>
        </table>
		
	

	
     <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $curso=$cmb_curso;
		 
		 include("../../firmas/firmas.php");?></td>
  </tr>
</table>
<? 
$resultado=$cont_alumnos - $cont_paginas;
if ($resultado!=1){ 
	echo "<H1 class=SaltoDePagina></H1>";
}?>
	<!--[if IE]>
<div style="page-break-before: always;height:0; line-height:0;"></div>
<![endif]-->
<!--<![if !IE]>
<div style="page-break-before: always;"></div>
<![endif]>-->


 <? } ?>
</center>
</body>

</html>

<? pg_close($conn);?>
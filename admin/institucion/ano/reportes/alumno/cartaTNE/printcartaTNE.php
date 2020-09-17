<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;	
	$_POSP = 4;
	$_bot = 8;
	if($periodo == "")
	{
	 $periodo = $cmb_periodo;
	}
	
	

?>		

<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?	

	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);
	
	
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
	$rdb = $ob_membrete->rrdb;
	//--------------- Curso ------------------//
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	//----------------------------------------- PROFE JEFE
	$ob_reporte = new Reporte();
	$ob_reporte -> ano = $ano;
	$ob_reporte -> institucion = $institucion;
	$ob_reporte -> curso = $curso;
	

	$ob_reporte->ProfeJefe($conn);
	$profe_jefe = $ob_reporte->profe_jefe;
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	//------------------FECHAS DE PERIODOS -----------------------
	$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, trabaja.cargo,empleado.rut_emp,empleado.dig_rut FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo='1' OR trabaja.cargo='23')";

	    /*$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";*/
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
        $cargo_dir    = $fila['cargo'];
		
		$rut_dir = 	number_format($fila['rut_emp'], 0, '.', ',')."-".$fila['dig_rut'];
		
		
	if ($cargo_dir==1){
	    $cargo_dir  = "Director(a)";
		$cargo_dir2 = "Director(a)";
		
		if ($institucion==24977){
		     $cargo_dir2 = "Rector(a)";
		}
		if ($institucion==5661){
		     $cargo_dir = "Director(a)";
		}
		
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "Rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		
	
	
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
	
	
	//-----------------------------------------------------------
	
	
	////////////// INICIO RESUMEN CURSO    /////////
  /*  $sql_alumno2 = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno2 = $sql_alumno2 . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno2 = $sql_alumno2 . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.")) order by ape_pat, ape_mat; ";
	
	$contadorcurso_positivas = 0;
	$contadorcurso_negativas = 0;
		
	$result_alumno2 = @pg_Exec($conn, $sql_alumno2);
	$cantidad_alumnos2 = @pg_numrows($result_alumno2);
	*/
	
	/*for($ii=0 ; $ii < @pg_numrows($result_alumno2) ; $ii++)	{
		$fila_alumno2 = @pg_fetch_array($result_alumno2,$ii);
		$alumno2 = $fila_alumno2['rut_alumno'];*/

		/*$sql_anota2 = "select * from anotacion ";
		$sql_anota2 = $sql_anota2 . "where rut_alumno = ".$alumno2." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."')";
		$sql_anota2 = $sql_anota2 . "order by tipo desc, fecha ";*/
		
/*		$sql_anota2 = "select a.*,ta.tipo as conducta
from anotacion a LEFT JOIN tipos_anotacion ta ON cast(a.codigo_tipo_anotacion as integer)=ta.id_tipo
where rut_alumno = ".$alumno2." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."')order by a.tipo desc, fecha ";*/



	$sql_anota2="select a.*,ta.tipo as conducta 
from anotacion a LEFT JOIN tipos_anotacion ta 
ON cast(a.codigo_tipo_anotacion as integer)=ta.id_tipo
where id_periodo=".$periodo." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."')
and rut_alumno in (Select rut_alumno from matricula where id_curso=".$curso.")
order by a.tipo desc, fecha";
	
	//if($_PERFIL==0){ echo $sql_anota2;}
		
		$result_anota2 = @pg_Exec($conn, $sql_anota2);
		for($ee=0 ; $ee < @pg_numrows($result_anota2) ; $ee++){
			$fila_anota2 = @pg_fetch_array($result_anota2,$ee);

							
			if($fila_anota2['tipo']==1 and $fila_anota2['tipo_conducta']==2){
				$conducta=2;
				}	
				
			if($fila_anota2['tipo']==1 and $fila_anota2['tipo_conducta']==1){
				$conducta=1;
				}	
			if($fila_anota2['tipo']==3 and $fila_anota2['tipo_conducta']==0){
				$conducta=3;
				}	
				
			if ($conducta==1){
				$tipo_conducta = "POSITIVA";
				$contadorcurso_positivas++;	
			}	
					
			
			//if ($fila_anota2['tipo_conducta']==2){
			if ($conducta==2){
				$tipo_conducta = "NEGATIVA";
				$contadorcurso_negativas++;
			}	
			if ($conducta==3){
				$tipo_conducta = "RESPONSABILIDAD";
				$contadorcurso_responsabilidad++;
			}	
										
			/*if ($fila_anota2['tipo']== 1){
				//$tipo = $tipo_conducta;
				//$contadorcurso_positivas++;
			}else{*/
				if($fila_anota2['tipo']==2){
					$tipo = "ATRASO";
					//$contadorcurso_negativas++;
				}else{
					 if($fila_anota2['tipo']==3){
						 $tipo = "INASISTENCIA";
						// $contadorcurso_negativas++;
					 }else{
						  if($fila_anota2['tipo']==4){
							  $tipo = "NEGATIVA";
							  $contadorcurso_negativas++;
						  }else{
							   if($fila_anota2["codigo_tipo_anotacion"]!=""){
								   //			$tipo = "AVANZADO";
								   $cod_ta = $fila_anota2["codigo_tipo_anotacion"];
								   $q12 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
								   $r12 = @pg_Exec($conn,$q12);
								   $f1 = @pg_fetch_array($r12,0);
								   $codta   = $f1['codtipo'];
								   $tipo	= $f1['descripcion'];
								   $tipo2	= $f1['tipo'];
								   
								   if ($tipo2==1){
									   //$contadorcurso_positivas++;
								   }
								   if ($tipo2==2){
									  // $contadorcurso_negativas++;
								   }	   	   
								   
							   }
						  }
					 }
				 }	 	  	   	   
			//}
	    }
	//} 
 
  
  ////// FIN RESUMEN CURSO /////////  
	if($cb_ok!="Buscar"){
	$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=InformeAnotaciones$fecha_actual.xls"); 	 
	}	

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script language="javascript" type="text/javascript">

function exportar(){
	window.location='printInformeAnotaciones_C.php?c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&xls=1';
	return false;
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">


           <!-- INSERTO CUERPO DE LA PÁGINA -->
		   
<?
if ($curso != 0){
   ?>
   <form name="form" action="printInformeAnotaciones_C.php" method="post" target="_blank">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	<tablE width="100%">
	  <tr>
	  	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           	<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  	<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
	    </td>
	  </tr>
	</tablE>
     
      </div></td>
     </tr>
   </table>
   <?
}
?>   
<br>
<?
	if ($alumno!="0")
	{
		$ob_reporte -> curso =$curso;
		$ob_reporte -> periodo =$periodo;
		$ob_reporte -> alumno = $alumno;
		$result_alumno = $ob_reporte -> TraeUnAlumno($conn);
	}
	else
	{ 
		$ob_reporte -> curso =$curso;
		$ob_reporte -> periodo =$periodo;
		$ob_reporte -> alumno = $alumno;
		$result_alumno = $ob_reporte -> TraeTodosAlumnos($conn);
	}	
	$cantidad_alumnos = @pg_numrows($result_alumno);
	
	$contadoralumno_positivas = 0;
	$contadoralumno_negativas = 0;
	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$ob_reporte ->CambiaDato($fila_alumno);
		$alumno = $fila_alumno['rut_alumno'];
		$nombre = ucwords(strtoupper($fila_alumno['nombre_alu']))." ".ucwords(strtoupper($fila_alumno['ape_pat'])) . " " . ucwords(strtoupper($fila_alumno['ape_mat']));
	if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>


	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$ob_institucion->ins_pal;?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center"><? echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";	?></td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ob_institucion->direccion;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:<?=$ob_institucion->telefono;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
<? } ?>



<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="titulo"><div align="center"><strong>CERTIFICACI&Oacute;N DE REGULARIDAD Y CONDICI&Oacute;N DE DESMEDRO SOCIOECON&Oacute;MICO DE ESTUDIANTES PARA EL PROCESO DE SOLICITUD O RENOVACI&Oacute;N DE LA TARJETA NACIONAL ESTUDIANTIL (TNE)</strong></div></td>
    </tr>
  <tr>
</table>
<br>
<br>
<br>
<br>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="item">
          <strong style="font-size:12px">
          Señor (a)<br>
Encargado (a) TNE<br>
Dirección Regional JUNAEB<br>
Presente<br>
</strong>
<br>
<br>
<br>
<br>
<p align="justify" style="line-height: 150%; font-size:12px">Yo,
  <?
		if($institucion == 24511){	
			echo "Meza Gotor Marcelo";
		}
		elseif($institucion==8905){
			echo "MARIELA ROSALBA ARAYA IGLESIAS";
			}
		else{
			echo strtoupper($Nombre_Direc);
		}
	?>, C.I. <?php echo $rut_dir ?>, en mi  cargo de <?php if ($institucion==1593){ 
		     echo "Director";
		}
		if ($institucion==31392){ 
		     echo "Rector";
		}
		else if($institucion==8905){
			echo "Director(a) Internino(a)";
			}
		else{
			 
		     if ($institucion==24977){
			      echo $cargo_dir2;
			 }else{
			      echo $cargo_dir;
			 }	}	?>	 
              del establecimiento educacional, 
 <strong> <?=$ob_institucion->ins_pal;?>
  , RBD <?php echo $rdb ?>,</strong> certifico que el estudiante inscrito a  trav&eacute;s del sistema web www.tne.cl, <u><? echo $ob_reporte->tildeM($nombre);?></u>, Rut: 
  <?=$ob_reporte->rut_alumno;?>
  , es alumno (a) regular de  nuestro establecimiento y cumple con la condici&oacute;n de desmedro socioecon&oacute;mico,  para la obtenci&oacute;n del beneficio de la Tarjeta Nacional Estudiantil para el  periodo <?php echo $nro_ano ?>. </p>
<br>
<br>
<br><br>
<br>

<div align="center">
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?><br>
 <br><br>
<br>
<div align="left"><span class="subitem">
					<?php $fecha = date("d-m-Y");  ?>
					<?php echo $ob_membrete->comuna ?>, <?=fecha_espanol($fecha) ?></span></div>
</div>
</td>
        </tr>
  </table>
	 <br>

  <br>
  <?
  
 // }
    $contadoralumno_positivas = 0;
	$contadoralumno_negativas = 0;
 
 if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

}//alumno ?>
</form>
<br>
</center>

</body>
</html>
<? pg_close($conn);?>
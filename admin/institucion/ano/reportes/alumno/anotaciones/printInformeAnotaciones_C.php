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
	//--------------- Curso ------------------//
	$Curso_pal = CursoPalabra($curso, 0, $conn);
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
	$sql="";
	if($periodo==0)
	{
		$sql_peri = "select * from periodo where id_ano = ".$ano." and id_periodo=".$periodo." order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri);
		for($i=0;$i<pg_numrows($result_peri);$i++)
		{
			if($i==0) //primer semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];
				$fecha_termino = $fila_per['fecha_termino'];					
			}
			if($i==1) //segundo semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];
				$fecha_termino = $fila_per['fecha_termino'];
			}
			if($i==2)//tercer semestre en caso q haya
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];
				$fecha_termino = $fila_per['fecha_termino'];
			}
		}
	
	}else{
		$ob_reporte->periodo=$periodo;
		$ob_reporte->Periodo($conn);
		$fecha_inicio =$ob_reporte->fecha_inicio;
		$fecha_termino=$ob_reporte->fecha_termino;
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
		$alumno = $fila_alumno['rut_alumno'];
		$nombre = ucwords(strtoupper($fila_alumno['ape_pat'])) . " " . ucwords(strtoupper($fila_alumno['ape_mat'])) . " " . ucwords(strtoupper($fila_alumno['nombre_alu']));
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
    <td class=""><div align="center"><strong>INFORME DE ATRASOS, ANOTACIONES E INASISTENCIAS</strong></div></td>
    </tr>
  <tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="159" class="item"><strong>Nombre Alumno</strong></td>
          <td width="10"  class="item"><strong>:</strong></td>
          <td width="485" class="subitem"><? echo $ob_reporte->tildeM($nombre);?></font></td>
        </tr>
        <tr>
          <td class="item"><strong>Curso</strong></td>
          <td class="item"><strong>:</strong></td>
          <td class="subitem"><? echo $Curso_pal?></td>
        </tr>
        <tr>
          <td class="item"><strong>Profesor Jefe</strong></td>
          <td class="item"><strong>:</strong></td>
          <td class="subitem"><? echo $ob_reporte->profe_jefe?></td>
        </tr>
  </table>
	 <br>
<?

	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->fecha_inicio=$fecha_inicio;
	$ob_reporte ->fecha_termino=$fecha_termino;
	$result_anota =$ob_reporte->Anotaciones($conn);
	
	if (@pg_numrows($result_anota)==0){?>
	 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	   <tr>
		 <td><hr width="100%" color=#003b85><b>NO REGISTRA ANOTACIONES NI ATRASOS</b></td>
	   </tr>
	 </table>
	 <? }
	 $cont_atrasos=0;
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		/*if($_PERFIL==0) {echo "anotacion-->".$fila_anota['id_anotacion']." tipo-->".$fila_anota['tipo']."  conducta-->".$fila_anota['tipo_conducta'];
		echo "tipo_conducta-->".$fila_anota['tipo_conducta'];
		echo "tipo-->".$fila_anota['tipo'];}*/
		if ($fila_anota['tipo']==1 && $fila_anota['tipo_conducta']==1){
			$tipo_conducta = "POSITIVA";
		   	$contadoralumno_positivas++;	
		}	
					
			
		if ($fila_anota['tipo']==4 && $fila_anota['tipo_conducta']==2){
			$tipo_conducta = "NEGATIVA";
			$contadoralumno_negativas++;
		}	
		
		if ($fila_anota['tipo']==1 && $fila_anota['tipo_conducta']==2){
			$tipo_conducta = "NEGATIVA";
			$contadoralumno_negativas++;
		}	
		if ($fila_anota['tipo']==3 && $fila_anota['tipo_conducta']==0){
			$tipo_conducta = "RESPONSABILIDAD";
			$contadoralumno_responsabilidad++;
		}	
										
		/*if ($fila_anota['tipo']== 1 and $fila_anota['tipo_conducta']==1){
			$tipo = $tipo_conducta;
			$contadoralumno_positivas++;
		}else{*/
		    if($fila_anota['tipo']==2){
			    $tipo = "ATRASO";
				//$contadoralumno_negativas++;
			}else{
			     if($fila_anota['tipo']==3){
			         $tipo = "INASISTENCIA";
					 //$contadoralumno_negativas++;
		         }else{
				      if($fila_anota['tipo']==4){
			              $tipo = "ENFERMERIA";
						  // $contadoralumno_negativas++;
		              }else{
					       if($fila_anota["codigo_tipo_anotacion"]!=""){
							   //$tipo = "AVANZADO";
			                   $cod_ta = $fila_anota["codigo_tipo_anotacion"];
			                   $q1 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
			                   $r1 = @pg_Exec($conn,$q1);
			                   $f1 = @pg_fetch_array($r1,0);
			                   $codta  = $f1['codtipo'];
			                   $tipo	= $f1['descripcion'];
			                   $tipo2	= $f1['tipo'];
							   
							  /* if ($tipo2==1){
							       $contadoralumno_positivas++;
							   }
							   if ($tipo2==2){
							       $contadoralumno_negativas++;
							   }*/	   	   
							   
						   }
					  }
				 }
			 }	 	  	   	   
		//} 

			
		$fecha = $fila_anota['fecha'];
		$rut_emp = $fila_anota['rut_emp'];
		
		$ob_reporte ->rut_emp=$rut_emp;
		$ob_reporte->Profesor($conn);
		$profesor_res = $ob_reporte->profesor;
		
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
			$hora = $fila_anota['hora'];
		
		
?>		 
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
 <? if($fila_anota['tipo']!=2){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156" class="item"><strong>Fecha</strong></td>
    <td width="7" class="item"><strong>:</strong></td>
    <td width="258" class="subitem"><? impF($fecha);?></td>
    <td width="77" class="item"><strong>Tipo</strong></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="143" class="subitem"><? echo $tipo_conducta?></td>
  </tr>
  <tr>
    <td class="item"><strong><? if($ckRESPONSABLE==1) echo "Profesor Responsable"; echo "&nbsp;"; ?></strong></td>
    <td class="item"><strong><? if($ckRESPONSABLE==1) echo ":"; echo "&nbsp;"; ?></strong></td>
    <td class="subitem"><? if($ckRESPONSABLE==1) echo $ob_reporte->tildeM($profesor_res); echo "&nbsp;"; ?></td>
   <? if($institucion!=12086){?>
    <td class="item"><strong>Hora</strong></td>
    <td class="item"><strong>:</strong></td>
    <td class="subitem"><? echo $hora?></td>
    <? } ?>
  </tr>
  <?php if($fila_anota['id_ramo']!=0){?>
  <tr>
    <td class="item"><strong>Asignatura</strong></td>
    <td class="item"><strong>:</strong></td>
    <td colspan="4" class="subitem"> <?php $sql_ra = "select s.nombre 
from subsector s inner join ramo r on s.cod_subsector = r.cod_subsector
where r.id_ramo =". $fila_anota['id_ramo'];
$rs_ra = pg_exec($conn,$sql_ra);
echo pg_result($rs_ra,0);
?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="item"><strong>Observaci&oacute;n</strong></td>
    <td class="item"><strong>:</strong></td>
    <td colspan="4" class="subitem"><? echo $observacion?></td>
    </tr>
  <?	if($fila_anota["sigla"]!="" ){	?>
  <tr>
    <td class="item"><strong>Subsector Aprendizaje</strong></td>
    <td class="item"><strong>:</strong></td>
	<td colspan="4" class="subitem"><?
		// busco la sigla
		$sigla_aux = $fila_anota["sigla"];	
		$ob_reporte->sigla_aux=$sigla_aux;
		$ob_reporte->SiglaSubsector($conn);
		echo $ob_reporte->sigla;?> - <? echo $ob_reporte->detalle_sigla; ?> 
		
	</td>
  </tr> 
 <?	}	
   if($fila_anota["codigo_tipo_anotacion"]!=""){?>
  <tr>
    <td class="item"><strong>Tipo de Anotación</strong></td>
    <td class="item"><strong>:</strong></td>
	<td colspan="4" class="subitem"><?php
	    $cod_ta = $fila_anota["codigo_tipo_anotacion"];
		$ob_reporte->cod_ta=$cod_ta;
		$ob_reporte->TipoAnotacion($conn);
		$codta=$ob_reporte->codta;
		$descripcion=$ob_reporte->descripcion;
		
		if($institucion==9566){
			echo $descripcion;
		}else{
			echo "$codta - $descripcion";
		}
?> 
		 
	</td>
  </tr>  
  <? }	
  if($fila_anota["codigo_anotacion"]!=""){?>
  <tr>
    <td class="item"><strong>Sub - Tipo</strong></td>
    <td class="item"><strong>:</strong></td>
	<td colspan="4" class="subitem"><?php 
		$codigo_anotacion = $fila_anota["codigo_anotacion"];
		$q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$detalle = $f1["detalle"];
		if($institucion==9566){
			echo $detalle;
		}else{
			echo "$codigo_anotacion - $detalle";
		}
		
		?>
		
	</td>
  </tr> 
  <?	}	?>  
	
</table>
<? }else{ ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126" class="item"><strong>Atraso el d&iacute;a </strong></td>
	<?	
		$fecha = $fecha;
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);
	?>
    <td width="524" class="subitem"><? echo $fecha?></td>
  </tr>
</table>
<? $cont_atrasos++;
	} ?>
<? } ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
	$ob_reporte ->alumno=$alumno;
	$ob_reporte ->ano=$ano;
	$ob_reporte ->fecha_inicio=$fecha_inicio;
	$ob_reporte ->fecha_termino=$fecha_termino;
	$result_asis= $ob_reporte ->Asistencia($conn);
	
	if (pg_numrows($result_asis)==0){?> 
	 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	   <tr>
		 <td><hr width="100%" color=#003b85><b>NO REGISTRA INASISTENCIAS</b></td>
	   </tr>
	 </table>
	<?	}
	$cont_inasistencia=0;
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];
		
		$ob_reporte ->alumno=$alumno;
		$ob_reporte ->ano=$ano;
		$ob_reporte ->fecha=$fecha;
		$ob_reporte ->JustificaAsistencia($conn);
		
		 if($ob_reporte->justifica == $fecha){
			$justificado = true;
		 }else{
			$justificado = false;
		 }
		$fecha = fecha_espanol(Cfecha($fecha));	
		$cont_inasistencia++;
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126" class="item"><strong>Inasistencia el d&iacute;a </strong></td>
    <td width="524" class="subitem"><? echo $fecha;?><strong><? if($justificado==true)echo "&nbsp;&nbsp;&nbsp;(Justificado)";?></strong></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
 }//asistencia
 
 
 //////  RESUMEN DE ANOTACIONES POSITIVAS Y NEGATIVAS
   
//  if ($_INSTIT==12086){ 
   
  ?>
 <?php if($ckRESUMEN==1){?>
  <table width="650" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td align="center" colspan="2" height="35" class="titulo"><strong>RESUMEN DE ANOTACIONES </strong></td>
  </tr>
  <tr>
    <td width="50%" align="center" height="30" class="item"><strong>Alumno </strong></td>
   
    <td width="50%" align="center" height="30" class="item"><strong> <? if($institucion!=25269) echo "CURSO"; else ?>&nbsp;</strong></td>
   
  </tr>
     
  <tr>
    <td class="item"><strong>Total anotaciones Positivas&nbsp;&nbsp;&nbsp;: <?=$contadoralumno_positivas; ?></strong></td>
    <td class="item"><strong><? if($institucion!=25269){?>Total anotaciones Positivas&nbsp;&nbsp;&nbsp;:  <?=$contadorcurso_positivas; ?>  <? } ?></strong></td>
  </tr>

  <tr>
    <td class="item"><strong>Total anotaciones Negativas&nbsp;&nbsp;: <?=$contadoralumno_negativas; ?> </strong></td>
    <td class="item"><strong><? if($institucion!=25269){?>Total anotaciones Negativas&nbsp;&nbsp;: <?=$contadorcurso_negativas;} ?></strong></td>
  </tr>
  <tr>
    <td class="item"><strong>Total anotaciones Responsabilidad:<?=intval($contadoralumno_responsabilidad);?></strong></td>
    <td class="item">&nbsp;</td>
  </tr>
  
  <tr>
    <td class="item"><strong>Total atrasos :<?=$cont_atrasos;?></strong></td>
    <td class="item">&nbsp;</td>
  </tr>
  <tr>
    <td class="item"><strong>Total inasistencias: <?=$cont_inasistencia;?></strong></td>
    <td class="item">&nbsp;</td>
  </tr>
  </table>
  <?php }?>
  <br>
  <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
<!--<table width="650" border="0" align="center">
		  <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
			  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp; 
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
		</table>-->
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
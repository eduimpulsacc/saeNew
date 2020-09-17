<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
include('../../../clases/class_Reporte.php');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
/*	
	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_inst=new Reporte();
	$ob_inst->institucion=$institucion;
	$rs_inst=$ob_inst->institucion_obj($conn);
	$fila_ins = @pg_fetch_array($rs_inst,0);	
	echo $ins_pal = $fila_ins['nombre_instit'];
	echo "<br>".$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	echo "<br>".$telefono = $fila_ins['telefono'];	
	exit;*/
	//------------------------
	// Periodo
	//------------------------
	$ob_periodo=new Reporte();
	$ob_periodo->periodo=$periodo;
	$rs_periodo=$ob_periodo->Periodo_1($conn);
	$fila_periodo = @pg_fetch_array($rs_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'];

	
	$ob_periodo2=new Reporte();
	$ob_periodo2->periodo=$periodo;
	$ob_periodo2->ano=$ano;
	$rs_periodo2=$ob_periodo2->Periodo_2($conn);
	$fils_periodo = @pg_fetch_array($rs_periodo2,0);
	$otro_periodo = $fils_periodo['id_periodo'];
	//------------------------
	// Año Escolar
	//------------------------
	
	$ob_ano_escolar=new Reporte();
	$ob_ano_escolar->ano=$ano;
	$ob_ano_escolar->AnoEscolar($conn);
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	
	$ob_insti=new Reporte();
	$ob_insti->institucion=$institucion;
	$rs_insti=$ob_insti->Institucion_2($conn);
	$fila_insti = @pg_fetch_array($rs_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
	
	$ob_profe=new Reporte();
	$ob_profe->curso=$curso;
	$ob_profe->ProfeJefe($conn);
	
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	
	$ob_alumnos=new Reporte();
	$ob_alumnos->curso=$curso;
	$result_alu =$ob_alumnos->Alumnos($conn);
	
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	
	$ob_cantidad_sub=new Reporte();
	$ob_cantidad_sub->curso=$curso;
	$rs_cantidad_sub=$ob_cantidad_sub->CantidadSubsectores($conn);
	$fila_sub = @pg_fetch_array($rs_cantidad_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	
	$ob_sub=new Reporte();
	$ob_sub->curso=$curso;
	$result_sub =$ob_sub->Subsectores_2($conn);
	
	//-----------------------------------------		

	if($valor=="1"){
		if(!$cb_ok =="Buscar"){
			$Fecha= date("d-m-Y_h:i");
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition:inline; filename=Informe_Rendimiento_Critico_$Fecha.xls"); 
		}	
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
function exportar(form){
	form.target="_blank";
	document.form.action='printInformeRendimientoCritico_C.php?cmb_curso=<?=$cmb_curso?>&cmb_periodos=<?=$cmb_periodos?>&valor=1';
	document.form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<form name="form" action="printInformeRendimientoCritico_C.php" method="post">
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
	<div id="capa0">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
        </div>
		</td>
		<? if($_PERFIL == 0){?>
        <td align="right"><input name="button4" type="button" class="botonXX" onClick="exportar(this.form);" value="EXPORTAR"></td>
      	<? }?>
	  </tr>
    </table>
	</div>
	</td>
  </tr>
      <tr>
      <td>
	  <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex"><div align="center">INFORME DE RENDIMIENTO CRITICO</div></td>
      </tr>
      <tr>
            <td align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong><? echo $periodo_pal?> 
              de&nbsp;<? echo $ob_ano_escolar->nro_ano?> </strong></font></td>
      </tr>
      </table>
      <br>
	  <table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
            <td width="115"><font size="1" face="verdana,arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="verdana,arial, geneva, helvetica">:</font></div></td>
        <td width="531"><font size="1" face="verdana,arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><? echo $ob_profe->profe_jefe?></font></td>
      </tr>
	  <tr>
    <td>&nbsp;</td>
  </tr>
	  
	  <tr>
	    <td><table width="25" border="1" cellspacing="0" cellpadding="0" bgcolor="ff6600">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
         </td>
        <td><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica">Alumnos con condición  cr&iacute;tica </font></td>
      </tr>
      </table>
	  <br>
	  
	  
      </table>
	  

      <table width="650" border="1" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	    <td rowspan="2" width="170" class="tablatit2">NOMBRE DEL ALUMNO</td>
        <td colspan="2" class="tablatit2"><div align="center">PROMEDIOS</div></td>
		<td colspan="2" class="tablatit2" width="150"><div align="center">INFORMACIÓN APODERADO</div></td>
      </tr>
      <tr>
      <?	
	  	   
	  for($cont=0 ; $cont < $num_subsectores; $cont++){
		 $fila_sub = @pg_fetch_array($result_sub,$cont);	
		 $subsector_curso = $fila_sub['nombre'];
		 $id_ramo = $fila_sub['id_ramo'];
		 $modo_eval = $fila_sub['modo_eval'];
		 $examen = $fila_sub['conex']; // 1 SI 2 NO
		 
         ?>	
         <!--<td align="center"><font size="1" face="verdana,arial, geneva, helvetica"><strong><? InicialesSubsector($subsector_curso) ?>
	     </strong></font></td>-->
   <? }?>
         <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Gral.</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Subsectores Críticos</strong></font></td>
         <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apoderado</strong></font></td>
	     <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Fono</strong></font></td>
       </tr>

       <?
	  $numero_alumnos = @pg_numrows($result_alu);		  
	  for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
	     $fila_alu = @pg_fetch_array($result_alu,$i);
	     $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	     $rut_alumno = $fila_alu['rut_alumno'];
		 	 
	     ?>	
         <tr>
         <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
         <td><font size="0" face="arial, geneva, helvetica"><? echo substr(ucwords(strtolower($nombre_alu)),0,25); ?></font></td>
	     <?	 
	     $promedio_general = 0;
	     $promedio = 0;
	     $cont_prom = 0;
		 $suma_promedio = 0;
	     $contador_promedios_rojos=0;
	     
	     for($cont=0 ; $cont < $num_subsectores; $cont++){
		    $fila_sub = @pg_fetch_array($result_sub,$cont);	
		    $subsector_curso = $fila_sub['nombre'];
		    $id_ramo = $fila_sub['id_ramo'];
			$porc_ramo = $fila_sub['porc_examen'];
		    //---------------------------------------
		    // Notas
		    //---------------------------------------
		  	$ob_notas=new Reporte();
			$ob_notas->ano=$ob_ano_escolar->nro_ano;
			$ob_notas->rut_alumno=$rut_alumno;
			$ob_notas->ramo=$id_ramo;
			$ob_notas->periodo=$periodo;
			$result_notas =$ob_notas->Notas_2($conn);
		    $fila_notas = @pg_fetch_array($result_notas,0);
		    $promedio = $fila_notas['promedio'];
			
			////// nuevo codigo que incluye la configuracion de notas con porcentaje ///
					if ($porc_ramo > 0){
					        $prom_ex=0;
							$prome_1 = $promedio; 			
					
							$promedio_nota = ($prome_1 * $porc_ramo)/100;
		
													
								$ob_notas_ex=new Reporte();
								$ob_notas_ex->curso=$curso;
								$ob_notas_ex->ano=$ob_ano_escolar->nro_ano;
								$ob_notas_ex->rut_alumno=$rut_alumno;
								$ob_notas_ex->ramo=$id_ramo;
								$ob_notas_ex->periodo=$periodo;
								$rs_examen = $ob_notas_ex->NotasExamen($conn);
								$nota_ex=0;
								for($x=0;$x<pg_numrows($rs_examen);$x++){
									//$promedio_nota=0;
									$fila_ex = @pg_fetch_array($rs_examen,$x);
									$ob_ex=new Reporte();
									$ob_ex->examen=$fila_ex['id_examen'];
									$result_ex = $ob_ex->ExamenSemestral($conn);
									$porc_ex = pg_result($result_ex,0);
									$bool = pg_result($result_ex,1);
									
									$nota_ex = ($fila_ex['nota'] * $porc_ex)/100;
									$prom_ex = $prom_ex + $nota_ex;
									
								}
									//$promedio_nota = ($arr_promedios['promedio'] * $arr_lista['porc_examen'])/100;
									if($bool==1){
										$prom = round($promedio_nota + $prom_ex);
									}else{
										$prom = abs($promedio_nota + $prom_ex);
									}											
							
							$promedio = $prom;
							$porc_ramo = 0;							
					}				
					///// fin proceso 
					
		    if ($promedio>0){ 
			   $suma_promedio = $suma_promedio + $promedio;
		  	   $cont_prom = $cont_prom + 1;
			}  
			
			if (($promedio>0) and ($promedio < 40)){
			   $contador_promedios_rojos++;
			}   
			
			       
		 }	 
		      
			  if ($institucion==1260){  
			     //echo "sp: $suma_promedio <br>";
				 //echo "cont_p: $cont_prom <br>";
			       $promedio_general = @round($suma_promedio/$cont_prom);
			   }else{			
			       $promedio_general = @round($suma_promedio/$cont_prom,0);
			   } 
			  
			  //$promedio_general = @intval($suma_promedio/$cont_prom);
			
			  if ($contador_promedios_rojos>1){
			      $bgcolor = "FF6600";
			  }else{
			      $bgcolor = "f5f5f5";
			  }
		    
		  
	          ?>
              <td bgcolor="<?=$bgcolor ?>"><div align="center"><font size="0" face="arial, geneva, helvetica">
	          <? 
			   if ($contador_promedios_rojos>1){
			      echo "* ";				  
			  }  
			  
			  
	          echo $promedio_general; 
	          		  
	          ?>
	          </font></div></td>
			  			  
			  <td>
			  
			  <table border="1" cellpadding="0" cellspacing="0">
			      <tr>
			      <?
			      for($cont=0 ; $cont < $num_subsectores; $cont++){
		             $fila_sub = @pg_fetch_array($result_sub,$cont);	
		             $subsector_curso = $fila_sub['nombre'];
		             $id_ramo = $fila_sub['id_ramo'];
		    
		          	 $ob_notas=new Reporte();
				 	 $ob_notas->ano=$ob_ano_escolar->nro_ano;
					 $ob_notas->rut_alumno=$rut_alumno;
					 $ob_notas->ramo=$id_ramo;
					 $ob_notas->periodo=$periodo;
					 $result_notas =$ob_notas->Notas_2($conn);
		             $fila_notas = @pg_fetch_array($result_notas,0);
		             $promedio = $fila_notas['promedio'];
					 $porc_ramo = $fila_sub['porc_examen'];
					 
					 ////// nuevo codigo que incluye la configuracion de notas con porcentaje ///
					if ($porc_ramo > 0){
					        $prom_ex=0;
							$prome_1 = $promedio; 			
					
							$promedio_nota = ($prome_1 * $porc_ramo)/100;
		
														
								$ob_notas_ex=new Reporte();
								$ob_notas_ex->curso=$curso;
								$ob_notas_ex->ano=$ob_ano_escolar->nro_ano;
								$ob_notas_ex->rut_alumno=$rut_alumno;
								$ob_notas_ex->ramo=$id_ramo;
								$ob_notas_ex->periodo=$periodo;
								$rs_examen = $ob_notas_ex->NotasExamen($conn);
								$nota_ex=0;
								for($x=0;$x<pg_numrows($rs_examen);$x++){
									//$promedio_nota=0;
									$fila_ex = @pg_fetch_array($rs_examen,$x);
									$ob_ex=new Reporte();
									$ob_ex->examen=$fila_ex['id_examen'];
									$result_ex = $ob_ex->ExamenSemestral($conn);
									$porc_ex = pg_result($result_ex,0);
									$bool = pg_result($result_ex,1);
									
									$nota_ex = ($fila_ex['nota'] * $porc_ex)/100;
									$prom_ex = $prom_ex + $nota_ex;
									
								}
									//$promedio_nota = ($arr_promedios['promedio'] * $arr_lista['porc_examen'])/100;
									if($bool==1){
										$prom = round($promedio_nota + $prom_ex);
									}else{
										$prom = abs($promedio_nota + $prom_ex);
									}											
							
							$promedio = $prom;
							$porc_ramo = 0;							
					}				
					///// fin proceso 
									
		             if (($promedio<40) and ($promedio!='EX') and ($promedio!=NULL) and ($promedio!=0)){ ?>
					     <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#003366"><? InicialesSubsector($subsector_curso) ?></font></td> <?
				     }         
		          }	?>		        
				  </tr>
				  
				  
				  <tr>
			      <?
			      for($cont=0 ; $cont < $num_subsectores; $cont++){
		             $fila_sub = @pg_fetch_array($result_sub,$cont);	
		             $subsector_curso = $fila_sub['nombre'];
		             $id_ramo = $fila_sub['id_ramo'];
					 $porc_ramo = $fila_sub['porc_examen'];
		    
		         	 $ob_notas=new Reporte();
				 	 $ob_notas->ano=$ob_ano_escolar->nro_ano;
					 $ob_notas->rut_alumno=$rut_alumno;
					 $ob_notas->ramo=$id_ramo;
					 $ob_notas->periodo=$periodo;
					 $result_notas =$ob_notas->Notas_2($conn);
		             $fila_notas = @pg_fetch_array($result_notas,0);
		             $promedio = $fila_notas['promedio'];
					 
					 ////// nuevo codigo que incluye la configuracion de notas con porcentaje ///
					if ($porc_ramo > 0){
					        $prom_ex=0;
							$prome_1 = $promedio; 			
					
							$promedio_nota = ($prome_1 * $porc_ramo)/100;
		
							
								$ob_notas_ex=new Reporte();
								$ob_notas_ex->curso=$curso;
								$ob_notas_ex->ano=$ob_ano_escolar->nro_ano;
								$ob_notas_ex->rut_alumno=$rut_alumno;
								$ob_notas_ex->ramo=$id_ramo;
								$ob_notas_ex->periodo=$periodo;
								$rs_examen = $ob_notas_ex->NotasExamen($conn);
								$nota_ex=0;
								for($x=0;$x<pg_numrows($rs_examen);$x++){
									//$promedio_nota=0;
									$fila_ex = @pg_fetch_array($rs_examen,$x);
									$ob_ex=new Reporte();
									$ob_ex->examen=$fila_ex['id_examen'];
									$result_ex = $ob_ex->ExamenSemestral($conn);
									$porc_ex = pg_result($result_ex,0);
									$bool = pg_result($result_ex,1);
									
									$nota_ex = ($fila_ex['nota'] * $porc_ex)/100;
									$prom_ex = $prom_ex + $nota_ex;
									
								}
									//$promedio_nota = ($arr_promedios['promedio'] * $arr_lista['porc_examen'])/100;
									if($bool==1){
										$prom = round($promedio_nota + $prom_ex);
									}else{
										$prom = abs($promedio_nota + $prom_ex);
									}											
							
							$promedio = $prom;
							$porc_ramo = 0;							
					}				
					///// fin proceso 
									
		             if (($promedio<40) and ($promedio!='EX') and ($promedio!=NULL) and ($promedio!=0)){ ?>
					     <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#FF0000"><? echo $promedio ?></font></td> <?
				     }         
		          }	?>		        
				  </tr>
			  
			  
			  </table>
			  </td>
			  		  
			  <?
	          // Aqui saco la informacion del apoderado y su telefono
	          $ob_info_apo=new Reporte();
			  $ob_info_apo->rut_alumno=$rut_alumno;
			  $res_apo = $ob_info_apo->InfoApo($conn);
	          $num_apo = @pg_numrows($res_apo);
	          $fila_apo = @pg_fetch_array($res_apo,0);
	          $nombre_apoderado = $fila_apo['nombre_apo'];
	          $fono_apoderado   = $fila_apo['telefono'];
	         
			
		      ?>	
		      <td><div align="left"><font size="0" face="arial, geneva, helvetica">&nbsp;<? echo $nombre_apoderado; ?></font></div></td>
		      <td><div align="center"><font size="0" face="arial, geneva, helvetica">&nbsp;<? echo $fono_apoderado; ?></font></div></td>
		      </tr>
  	     <?  } ?>
	</table>	
	</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><HR width="100%" color=#003b85 align="center"></td>
  </tr>
</table>
</center>
<?
function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>
<!-- FIN CUERPO DE LA PAGINA -->
</form>
</body>
</html>
<? pg_close($conn);?>
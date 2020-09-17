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
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	
	if (empty($curso)) //exit;
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//------------------------
	// Periodo
	//------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'];

	$sql_periodo1 = "select * from periodo where id_ano=".$ano." and id_periodo<>".$periodo;
	$Rs_Periodo = @pg_exec($conn,$sql_periodo1);
	$fils_periodo = @pg_fetch_array($Rs_Periodo,0);
	$otro_periodo = $fils_periodo['id_periodo'];
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." and cod_subsector < 50000 and bool_ip=1 ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.porc_examen ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and ramo.cod_subsector < 50000 and ramo.bool_ip=1 ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	//-----------------------------------------		
	
	/////////// datos del curso
	$sql_curso = "SELECT * from curso where id_curso = '$curso'";	
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['truncado_per'];
	
	
	$sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
	$rs_examen = @pg_exec($conn,$sql);
	$cuenta_examen = @pg_result($rs_examen,0);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeRendimientoCritico.php?institucion=$institucion';
				form.submit(true);
	
				}	
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso)){
   // exit;
}else{
   ?>   

  <center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeRendimientoCritico.php?cmb_curso=<?=$cmb_curso ?>&cmb_periodos=<?=$cmb_periodos ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
        </div>
		</td>
      </tr>
    </table>
	
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
              de&nbsp;<? echo $ano_escolar?> </strong></font></td>
      </tr>
      </table>
      <br>
	  <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td width="115"><font size="1" face="verdana,arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="verdana,arial, geneva, helvetica">:</font></div></td>
        <td width="531"><font size="1" face="verdana,arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
           <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><? echo $ob_reporte->tildeM($profe_jefe);?></font></td>
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

      <table width="650" border="1" cellspacing="0" cellpadding="0">
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
         <td><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
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
				$sql_notas = "SELECT notas$ano_escolar.promedio ";
				$sql_notas = $sql_notas . "FROM notas$ano_escolar ";
				$sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
				$result_notas =@pg_Exec($conn,$sql_notas);
				$fila_notas = @pg_fetch_array($result_notas,0);
				$promedio = $fila_notas['promedio'];
				
					////// nuevo codigo que incluye la configuracion de notas con porcentaje ///
					if ($porc_ramo > 0){
					        $prom_ex=0;
							$prome_1 = $promedio; 			
					
							$promedio_nota = ($prome_1 * $porc_ramo)/100;
		
							
								$sql = "SELECT id_examen,nota FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno." AND id_ano=".$ano." AND periodo=".$periodo;
								$rs_examen = @pg_exec($conn,$sql);
								$nota_ex=0;
								for($x=0;$x<pg_numrows($rs_examen);$x++){
									//$promedio_nota=0;
									$fila_ex = @pg_fetch_array($rs_examen,$x);
									$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_examen=".$fila_ex['id_examen'];
									$result_ex = @pg_Exec($conn,$sql);
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
									
									if ($prom_ex==0 or $prom_ex==NULL){
									    $prom = $prome_1;
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
              <td bgcolor="<?=$bgcolor ?>">
			  
			  <div align="center"><font size="0" face="arial, geneva, helvetica">
	          <? 
			   if ($contador_promedios_rojos>1){
			      echo "* ";				  
			  }  
			  
			  
	          echo $promedio_general; 
	          		  
	          ?>
	          </font></div>
			  
			  
			  </td>
			  			  
			  <td>
			  
			  <table border="1" cellpadding="0" cellspacing="0">
			      <tr>
			      <?
			      for($cont=0 ; $cont < $num_subsectores; $cont++){
		             $fila_sub = @pg_fetch_array($result_sub,$cont);	
		             $subsector_curso = $fila_sub['nombre'];
		             $id_ramo = $fila_sub['id_ramo'];
		    
		             $sql_notas = "SELECT notas$ano_escolar.promedio ";
		             $sql_notas = $sql_notas . "FROM notas$ano_escolar ";
		             $sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		             $result_notas =@pg_Exec($conn,$sql_notas);
		             $fila_notas = @pg_fetch_array($result_notas,0);
		             $promedio = $fila_notas['promedio'];
					 $porc_ramo = $fila_sub['porc_examen'];
					 
					 ////// nuevo codigo que incluye la configuracion de notas con porcentaje ///
					if ($porc_ramo > 0){
					        $prom_ex=0;
							$prome_1 = $promedio; 			
					
							$promedio_nota = ($prome_1 * $porc_ramo)/100;
		
							
								$sql = "SELECT id_examen,nota FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno." AND id_ano=".$ano." AND periodo=".$periodo;
								$rs_examen = @pg_exec($conn,$sql);
								$nota_ex=0;
								for($x=0;$x<pg_numrows($rs_examen);$x++){
									//$promedio_nota=0;
									$fila_ex = @pg_fetch_array($rs_examen,$x);
									$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_examen=".$fila_ex['id_examen'];
									$result_ex = @pg_Exec($conn,$sql);
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
									
									if ($prom_ex==0 or $prom_ex==NULL){
									    $prom = $prome_1;
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
		    
		             $sql_notas = "SELECT notas$ano_escolar.promedio ";
		             $sql_notas = $sql_notas . "FROM notas$ano_escolar ";
		             $sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		             $result_notas =@pg_Exec($conn,$sql_notas);
		             $fila_notas = @pg_fetch_array($result_notas,0);
		             $promedio = $fila_notas['promedio'];
					 
					 
					 ////// nuevo codigo que incluye la configuracion de notas con porcentaje ///
					if ($porc_ramo > 0){
					        $prom_ex=0;
							$prome_1 = $promedio; 			
					
							$promedio_nota = ($prome_1 * $porc_ramo)/100;
		
							
								$sql = "SELECT id_examen,nota FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno." AND id_ano=".$ano." AND periodo=".$periodo;
								$rs_examen = @pg_exec($conn,$sql);
								$nota_ex=0;
								for($x=0;$x<pg_numrows($rs_examen);$x++){
									//$promedio_nota=0;
									$fila_ex = @pg_fetch_array($rs_examen,$x);
									$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_examen=".$fila_ex['id_examen'];
									$result_ex = @pg_Exec($conn,$sql);
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
									
									if ($prom_ex==0 or $prom_ex==NULL){
									    $prom = $prome_1;
									}	
																				
							
							$promedio = $prom;
							$porc_ramo = 0;							
					}				
					///// fin proceso 					 
									
		             if (($promedio<40) and ($promedio!='EX') and ($promedio!=NULL) and ($promedio!=0)){
					     					    
						 ?>
					     <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#FF0000"><? echo $promedio ?></font></td> <?
				     }         
		          }	?>		        
				  </tr>
			  
			  
			  </table>
			  </td>
			  		  
			  <?
	          // Aqui saco la informacion del apoderado y su telefono
	          $sql_apo = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno = '".trim($rut_alumno)."')";
	          $res_apo = @pg_Exec($conn,$sql_apo);
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
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</center>

<?
}

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

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="InformeRendimientoCritico.php">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto, curso.truncado_per ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
	  <table width="100%" height="43" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="tableindex">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr class="cuadro01">
    <td width="69">Curso</td>
    <td width="272">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso" class="ddlb_x">
		  <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  	$fila = @pg_fetch_array($resultado_query_cue,$i); 
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			if ($fila['id_curso'] == $cmb_curso){
			   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
			}else{
			    echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		    }
		  }
		  ?>
        </select>
	    </font>	  </div></td>
    <td width="61" class="textosmediano">Periodo</span></td>
    <td width="219"><select name="cmb_periodos">
			<option value=0 selected>(Seleccione Periodo)</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  
		  if ($fila['id_periodo'] == $cmb_periodos){
		  	  ?>
              <option value="<? echo $fila['id_periodo']?>" selected><? echo $fila['nombre_periodo']?></option>
	          <?
		  }else{
		      ?>
              <option value="<? echo $fila['id_periodo']?>"><? echo $fila['nombre_periodo']?></option>
	          <?
		  }	  	  
	   
	   
	    } ?>
    </select></td>
    <td width="80" align="center" valign="top">
      <div align="center">
        <input name="cb_ok" class="botonXX"  type= "submit"  value="Buscar">
        <input name="cb_ok2" class="botonXX"  type= "button"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
        </div></td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
 
 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
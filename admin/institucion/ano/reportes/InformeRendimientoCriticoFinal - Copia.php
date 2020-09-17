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
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	$fincio_ins = $fila_ano['fecha_inicio'];
	$ftermino_ins = $fila_ano['fecha_termino'];
	
	//----------fecha curso---------------------------
	 $sql_fcur="select fecha_inicio,fecha_termino,bool_psemestral,truncado_final from curso where id_curso=$curso";
	$rs_fcur=pg_exec($conn,$sql_fcur);
	$fila_fcur = pg_fetch_array($rs_fcur,0);
	$finicio_curso = $fila_fcur['fecha_inicio'];
	$ftermino_curso = $fila_fcur['fecha_termino'];
	$bool_psemestral = $fila_fcur['bool_psemestral'];
	$truncado_final = $fila_fcur['truncado_final'];
	//------------------------------------------s
	
	
	
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
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,matricula.fecha,matricula.fecha_retiro,matricula.bool_ar ";
	$sql_alu .=  "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu .= " WHERE (((matricula.id_curso)=".$curso.")) ";
	if(!isset($ret)){$sql_alu.= " AND matricula.bool_ar=0 ";}
	$sql_alu .=  "ORDER BY nro_lista, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	//if($_PERFIL==0){echo $sql_alu;}
	$result_alu =@pg_Exec($conn,$sql_alu);
	
	
		// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." and cod_subsector < 50000 and bool_ip=1 ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	//-----------------------------------------
	
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval,ramo.conexper ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and ramo.modo_eval =1 ORDER BY ramo.id_orden; ";
	//if($_PERFIL==0)echo $sql_sub;
	$result_sub =@pg_Exec($conn,$sql_sub );
	
	$ob_reporte->curso=$curso;
	$rs_fano = $ob_reporte->feriadoCursoNew($conn);

	//-----------------------------------------	
	
	
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
				form.action = 'InformeRendimientoCriticoFinal_new.php?institucion=$institucion';
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
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeRendimientoCriticoFinal.php?cmb_curso=<?=$cmb_curso ?>&cmb_periodos=<?=$cmb_periodos ?>&ret=<?php echo $ret ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
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
        <td align="center" class="tableindex"><div align="center">INFORME DE RENDIMIENTO CRITICO FINAL </div></td>
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
	    <td><table width="25" border="1" cellspacing="0" cellpadding="0" bgcolor="ff9966">
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
      <?
	  $sql_periodos  = "select * from periodo where id_ano='".$ano."'";
	  $res_periodos  = @pg_exec($conn,$sql_periodos);
	  $num_periodos = @pg_numrows($res_periodos);
	  
	  if ($num_periodos > 2){
		  $tipo = "Trim.";
		  $colspan="5";
	  }else{
	      $tipo = "Sem.";
		  $colspan="4";
	  }	  
	 
	  ?>
      <!--<table width="650" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td rowspan="2" width="20" class="tablatit2-1">N&ordm;</td>
          <td rowspan="2" width="170" class="tablatit2">NOMBRE DEL ALUMNO</td>
          <td colspan="<?=$colspan ?>" class="tablatit2"><div align="center">PROMEDIOS</div></td>
          <td colspan="4" class="tablatit2" width="150"><div align="center">INFORMACI&Oacute;N APODERADO</div></td>
        </tr>
        <tr>
          
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>1&ordm; <?=$tipo ?></strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>2&ordm; <?=$tipo ?></strong></font></td>
		  <?
		  if ($num_periodos > 2){  ?>
              <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>3&ordm; <?=$tipo ?></strong></font></td>
       <? } ?>		  
		  <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final.</strong></font></td>
		  <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>% Asis.</strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Subsectores&nbsp;Criticos.</strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apoderado</strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Fono</strong></font></td>
        </tr>
        <?
		// AQUI DEBO DETERMINAR LOS PERIODOS QUE TIENE LA INSTITUCIÓN
	    for($i=0; $i < @pg_numrows($res_periodos); $i++){
		   $fila_periodos = @pg_fetch_array($res_periodos,$i);
		   $nombre_periodo = $fila_periodos['nombre_periodo'];
		   $id_periodo = $fila_periodos['id_periodo'];   
		   $nombre_periodo = trim($nombre_periodo);
		  		 		   
		   if (($nombre_periodo=="PRIMER TRIMESTRE") OR ($nombre_periodo=="PRIMER SEMESTRE")){
		        $primer_periodo = $fila_periodos['id_periodo'];
		   }
		   if (($nombre_periodo=="SEGUNDO TRIMESTRE") OR ($nombre_periodo=="SEGUNDO SEMESTRE")){
		        $segundo_periodo = $fila_periodos['id_periodo'];
		   }
		   if (($nombre_periodo=="TERCER TRIMESTRE")){
		        $tercer_periodo = $fila_periodos['id_periodo'];
		   }
		  // $nombre_periodo = "";		
		}
		
	  $numero_alumnos = @pg_numrows($result_alu);	  
	  for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
	     $fila_alu = @pg_fetch_array($result_alu,$i);
	     $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	     $rut_alumno = $fila_alu['rut_alumno'];
		 $fecha_matricula = $fila_alu['fecha'];
		 $retirado = $fila_alu['bool_ar'];
		 $fecha_retiro = $fila_alu['fecha_retiro'];
		 
		 
		 
//calculo de asistencia
$feriados_ano=0;
$fera=0;		 
		 
		//si tengo fechas en el curso
		 if($finicio_curso!= "" && $finicio_curso!= "1111-11-11"){
			//echo "1";
			//*********** habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($fecha_matricula <= $finicio_curso)
				{$fini= $finicio_curso;}
				else
				{$fini= $fecha_matricula;}
				
				
				
				//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
				if($retirado==1){
				 $fter =$fecha_retiro;
				}else{
				 $fter = $ftermino_curso;
				}
				
		
			 
		}
		//si el curso no tiene fechas, se calcula con el inicio del año
		else
		{
			//echo "2";
				if($fecha_matricula <= $fincio_ins)
				{$fini= $fincio_ins;}
				else
				{$fini= $fecha_matricula;}
				
				
				
				//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
				if($retirado==1){
				 $fter =$fecha_retiro;
				}else{
				 $fter = $ftermino_ins;
				}	
			
		}
		
		$habiles_ano=hbl($fini,$fter);
		
		//feriados del año 
		if(pg_numrows($rs_fano)>0){
			$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado WHERE id_ano=".$ano." and id_curso =".$curso." AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
		}
		else{
		$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
		}
		
		//if($_PERFIL==0){echo $sql_fano;}
	$rs_feriadosano = @pg_exec($conn,$sql_fano);
	
	for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
	 	 $feriados_ano=$fera;
		 
		 //dias reales año
	 $habil_real_ano = $habiles_ano-$feriados_ano;
	//inasistencias
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	
	//justificadas

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
		 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $prc_asis = round((100* $con_total_inano)/$habil_real_ano);
		 
	     ?>
          <?
    for($cont=0 ; $cont < pg_numrows($result_sub); $cont++){
    $fila_sub = @pg_fetch_array($result_sub,$cont);	
    $subsector_curso = $fila_sub['nombre'];
     $id_ramo = $fila_sub['id_ramo'];
    $conexper = $fila_sub['conexper'];
	$promedio_sub =0;
	$promedios_rojos=0;
    
    $sql_promedio_sub = "SELECT promedio  FROM promedio_sub_alumno
    WHERE rut_alumno='".$rut_alumno."' AND  id_ramo=".$id_ramo;
	
    $result_promSub =@pg_Exec($conn,$sql_promedio_sub)or die("Fallo".$sql_promedio_sub);
    
	if(pg_numrows($result_promSub)==0){
	   $sql_promedio_sub = "select round(AVG(cast(p.promedio as INT))) as promedio from notas$ano_escolar p where rut_alumno='".$rut_alumno."' AND promedio not in(' ','0') and id_ramo=".$id_ramo;
	  @$result_promSub =@pg_Exec($conn,$sql_promedio_sub)or die("Fallo".$sql_promedio_sub);
	}
	
	//if($_PERFIL==0){echo $sql_promedio_sub;}
    $fila_promSub = @pg_fetch_array($result_promSub,0);
    $promedio_sub = $fila_promSub['promedio'];
	
    
    
    if (($promedio_sub<40) and ($promedio_sub!='EX') and ($promedio_sub!=NULL) and ($promedio_sub!=0)){ 
	$arrp[$rut_alumno]['ramo'][]=$fila_sub['nombre'];
	$arrp[$rut_alumno]['promedio'][]=$promedio_sub;
	
	 } }?> 
        <tr>
          <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
          <td><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
          <?	 
	     $promedio_general = 0;
	     $promedio = 0;
	     $cont_prom = 0;
		 $suma_promedio = 0;
		 $contador_promedios_rojos=0;
		 $promedio_rojo=0;
		 $prom_contador=0;
		
	     
	    				
		 /// TOMO EL PROMEDIO DEL PRIMER TRIMESTRE O SEMESTRE
		 
	$sql_primero="SELECT notas$ano_escolar.promedio, situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno
	FROM notas$ano_escolar inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo 
	left join situacion_periodo on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
	WHERE 
	notas$ano_escolar.id_periodo = ".$primer_periodo." and notas$ano_escolar.rut_alumno = '".trim($rut_alumno)."' and ramo.bool_pgeneral=1 "; 		 
	//echo $sql_primero;
		 $res_primero = @pg_Exec($conn,$sql_primero)or die("Fallo Condicion".$sql_primero);
		   $num_primero = @pg_numrows($res_primero);		
		
		 if ($num_primero>0){
		     $suma_promedio = 0;
			 $contador = 0;
		     for ($j=0; $j < $num_primero; $j++){
		 	     $fila_primero =  pg_fetch_array($res_primero,$j);
				 $conexper= $fila_primero['conexper'];
				 if($conexper!=1){
				 $promedio = $fila_primero['promedio'];
				 }else{
				 /*echo "<br>"." - ".$conexper."-->".$ramo."-->".$rut_alumno."-->".*/
				 $promedio = $fila_primero['nota_final'];
				 }
				 
		  	
				 
				 if ($promedio > 0){
				     $suma_promedio = $suma_promedio + $promedio;
					 $contador++;
					 
				 }
		     }
			 
			 $primer_promedio = ($truncado_final==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			
			 
			
			 
		 }
	
			
			
		 /// TOMO EL PROMEDIO DEL SEGUNDO TRIMESTRE O SEMESTRE
		 
		 $sql_segundo="SELECT notas$ano_escolar.promedio, situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno
	FROM notas$ano_escolar inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo 
	left join situacion_periodo on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
	WHERE 
	notas$ano_escolar.id_periodo = ".$segundo_periodo." and notas$ano_escolar.rut_alumno = '".trim($rut_alumno)."' and ramo.bool_pgeneral=1";
		 
		//echo $sql_segundo;
		 $res_segundo = @pg_Exec($conn,$sql_segundo);
		 $num_segundo = @pg_numrows($res_segundo);
		 if ($num_segundo>0){
		     $suma_promedio = 0;
			 $contador = 0;
		     for ($j=0; $j < $num_segundo; $j++){
			     $fila_segundo =  @pg_fetch_array($res_segundo,$j);	
				 $conexper = $fila_segundo['conexper'];
				 if($conexper!=1){
			     $promedio = $fila_segundo['promedio'];
				 }else{
				 $promedio=$fila_segundo['nota_final'];	 
				 }
		// ACA ESTA LA CLAVE DEL EXITOOOOOOOOOO!!!!!!!----------
				 if ($promedio > 0){
				     $suma_promedio = $suma_promedio + $promedio;
					 $contador++;
				 }
				 if ($promedio < 40){
				 	if($promedio!=0){
				 	$prom_contador++;
					}
				 }
			 }
			 $segundo_promedio = ($bool_psemestral==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			// $segundo_promedio = @round($suma_promedio/$contador);
			  if($segundo_promedio<40){
			 	$promedio_rojo++;
			 } 	 
		 }
		 /// TOMO EL PROMEDIO DEL TERCER TRIMESTRE O SEMESTRE
		
		
	//echo "<br>".
	$sql_tercero="SELECT notas$ano_escolar.promedio, situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno
	FROM notas$ano_escolar inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo 
	left join situacion_periodo on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
	WHERE 
	notas$ano_escolar.id_periodo = ".$tercer_periodo." and notas$ano_escolar.rut_alumno = '".trim($rut_alumno)."' and ramo.bool_pgeneral=1";
		 
		 $res_tercero = pg_exec($conn,$sql_tercero);
		 $num_tercero = @pg_numrows($res_tercero);
		// echo "--->".$num_tercero;
		 if ($num_tercero>0){
		     $suma_promedio = 0;
			 $contador = 0;
			 $promedio =0;
		     for ($j=0; $j <=$num_tercero; $j++){
			    $fila_tercero = pg_fetch_array($res_tercero,$j);
				//print_r($fila_tercero);
			 	$conexper=$fila_tercero['conexper'];
				if($conexper!=1){
			   		$promedio = $fila_tercero['promedio'];
				}else{
					$promedio=$fila_tercero['nota_final'];
				}
				if ($promedio > 0){
				     $suma_promedio = $suma_promedio + $promedio;
					 $contador++;
				 }
			 }
			 
			  $tercero_promedio = ($bool_psemestral==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			 //$tercero_promedio = @round($suma_promedio/$contador);
			 if($tercero_promedio<40){
			 	$promedio_rojo++;
			 } 	 
		 } 	
		 
			  if ($primer_promedio<40){
			      $color = "FF0000";
				  $promedios_rojos++;
				  
			  }else{
			      $color = "000000";
			  }	  	  
		    
		      $suma_promedio = 0;
		      $contador = 0;
			  $promedios_rojos = 0;
	          ?>
              <td >
		      <div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
              <?
			  if ($primer_promedio > 0){		  
	             echo $primer_promedio; 
				 $suma_promedio = $suma_promedio + $primer_promedio;
				 $contador++;
			  }else{
			     echo "&nbsp;";
			  }	 
			  if ($segundo_promedio<40){
			      $color = "FF0000";
				  $promedios_rojos++;
				  
			  }else{
			      $color = "000000";
			  }	
	          ?>
              </font></div></td>
              <td ><div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
			  <?		  
	          if ($segundo_promedio > 0){			  
			      echo $segundo_promedio;
				 $suma_promedio = $suma_promedio + $segundo_promedio;
				  $contador++;
			  }else{
			      echo "&nbsp;";
			  }	  	  
			  			  
			  if ($tercero_promedio<40){
			      $color = "FF0000";
				  $promedios_rojos++;
				  
			  }else{
			      $color = "000000";
			  }	 
	          ?></font></div>
		      </td>
              <? if ($num_periodos > 2){ ?>
			  
				  <td ><div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
				  <?
				  if ($tercero_promedio > 0){
					  echo $tercero_promedio;
					  $suma_promedio = $suma_promedio + $tercero_promedio;
					  $contador++;
				  }else{
					  echo "&nbsp;";
				  }	
					
					
				  ?></font></div>
				  </td>
			<? } ?>    
			   <?php  
			 $sumnf=0;
			  $sql_notasn = "select round(avg(cast(notas$ano_escolar.promedio as INT))) as promedio,
situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno,notas$ano_escolar.id_ramo   
FROM notas$ano_escolar  inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo left join situacion_periodo 
on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1 
WHERE   notas$ano_escolar.rut_alumno = '$rut_alumno' AND notas$ano_escolar.promedio 
NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N','-','EX')
group by notas$ano_escolar.rut_alumno ,notas$ano_escolar.id_ramo,situacion_periodo.nota_final,ramo.conexper"; 
$rs_notasn=pg_exec($conn,$sql_notasn);

for($nnf=0;$nnf<pg_numrows($rs_notasn);$nnf++){
$filanf=pg_fetch_array($rs_notasn,$nnf);
$sumnf=$sumnf+$filanf['promedio'];
}
 @$promedio_final = ($truncado_final==1)?@round($sumnf/pg_numrows($rs_notasn)):@intval($sumnf/pg_numrows($rs_notasn));
 
?>
			  <?
			    //@$promedio_final = ($truncado_final==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			  
			  //@$promedio_final = round($suma_promedio/$contador);
			  //echo $promedios_rojos;
			  if ($promedio_final<40){
			      $color = "FF0000";				  
			  }else{
			      $color = "000000";
			  }	
			 /*if($promedios_rojos>1){
			  						
			  				$bg_color = "ff9966";
			 			}else{
					  		
				          $bg_color = "f5f5f5";
				      }*/	
			      /*if ($promedios_rojos >1){
			  	      $bg_color = "ff9966";
			      }else{*/
				  
				   
					 if ($promedio_final < 45){
					     $bg_color = "ff9966";
				      
					  } elseif($promedios_rojos >1){
					  
					  	$bg_color = "ff9966";
					  
					 } elseif($promedio_rojo >0){
					  
					  	$bg_color = "ff9966";
					} elseif($prom_contador >1){
					  $bg_color = "ff9966";
					 }
					
					 else{
					  		
				          $bg_color = "f5f5f5";
				      }	
					   
					   if(count($arrp[$rut_alumno]['ramo'])>=3){
						 $bg_color = "ff9966";
						 }
						 
						 if ($promedio_final >=50  && count($arrp[$rut_alumno]['ramo'])<=2 ){
					     $bg_color = "f5f5f5";
				      
					  }
			      //}
			  //}
			  else{
			      $bg_color = "f5f5f5";
			  }  
			  
			  ?>
              <td bgcolor="<?=$bg_color ?>"><div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
             
            
             
			  <?
			  echo $promedio_final;
			  ?><?php if($_PERFIL==0){echo "-".$promedio_rojo;}  ?>
			  </font></div>	  
			  </td>
              <td bgcolor="#<?=($prc_asis<85)?"ff9966":"f5f5f5" ?>"><div align="center"><font size="0" face="arial, geneva, helvetica" color="#<?=($prc_asis<85)?"ff0000":"000000" ?>"><?php echo $prc_asis ?></font></div></td>
			 
    <td>
  
    
    <table border="1" cellpadding="0" cellspacing="0">
    <tr>
    <?php for($r=0;$r<count($arrp[$rut_alumno]['ramo']);$r++){?>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#003366"><?php echo InicialesSubsector($arrp[$rut_alumno]['ramo'][$r]) ?></font></td>
    <?php }?>
    </tr>
    <tr>
    <?php for($p=0;$p<count($arrp[$rut_alumno]['promedio']);$p++){?>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#FF0000"><?php echo $arrp[$rut_alumno]['promedio'][$p] ?></font></td>
    <?php }?>
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
      </table>-->
      <table width="650" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td rowspan="2" width="20" class="tablatit2-1">N&ordm;</td>
          <td rowspan="2" width="170" class="tablatit2">NOMBRE DEL ALUMNO</td>
          <td colspan="<?=$colspan ?>" class="tablatit2"><div align="center">PROMEDIOS</div></td>
          <td colspan="4" class="tablatit2" width="150"><div align="center">INFORMACI&Oacute;N APODERADO</div></td>
        </tr>
        <tr>
          
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>1&ordm; <?=$tipo ?></strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>2&ordm; <?=$tipo ?></strong></font></td>
		  <?
		  if ($num_periodos > 2){  ?>
              <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>3&ordm; <?=$tipo ?></strong></font></td>
       <? } ?>		  
		  <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final.</strong></font></td>
		  <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>% Asis.</strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Subsectores&nbsp;Criticos.</strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apoderado</strong></font></td>
          <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Fono</strong></font></td>
        </tr>
        <?
		// AQUI DEBO DETERMINAR LOS PERIODOS QUE TIENE LA INSTITUCIÓN
	    for($i=0; $i < @pg_numrows($res_periodos); $i++){
		   $fila_periodos = @pg_fetch_array($res_periodos,$i);
		   $nombre_periodo = $fila_periodos['nombre_periodo'];
		  	   
		   $nombre_periodo = trim($nombre_periodo);
		  		 		   
		   if (($nombre_periodo=="PRIMER TRIMESTRE") OR ($nombre_periodo=="PRIMER SEMESTRE")){
		        $primer_periodo = $fila_periodos['id_periodo'];
		   }
		   if (($nombre_periodo=="SEGUNDO TRIMESTRE") OR ($nombre_periodo=="SEGUNDO SEMESTRE")){
		        $segundo_periodo = $fila_periodos['id_periodo'];
		   }
		   if (($nombre_periodo=="TERCER TRIMESTRE") OR ($nombre_periodo=="TERCER SEMESTRE")){
		        $tercer_periodo = $fila_periodos['id_periodo'];
		   }
		   $nombre_periodo = "";		
		}
		
	  $numero_alumnos = @pg_numrows($result_alu);	  
	  for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
	     $fila_alu = @pg_fetch_array($result_alu,$i);
	     $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	     $rut_alumno = $fila_alu['rut_alumno'];
		 $fecha_matricula = $fila_alu['fecha'];
		 $retirado = $fila_alu['bool_ar'];
		 $fecha_retiro = $fila_alu['fecha_retiro'];
	     ?>
         <?
		 //calculo de asistencia
$feriados_ano=0;
$fera=0;		 
		 
		//si tengo fechas en el curso
		 if($finicio_curso!= "" && $finicio_curso!= "1111-11-11"){
			//echo "1";
			//*********** habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($fecha_matricula <= $finicio_curso)
				{$fini= $finicio_curso;}
				else
				{$fini= $fecha_matricula;}
				
				
				
				//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
				if($retirado==1){
				 $fter =$fecha_retiro;
				}else{
				 $fter = $ftermino_curso;
				}
				
		
			 
		}
		//si el curso no tiene fechas, se calcula con el inicio del año
		else
		{
			//echo "2";
				if($fecha_matricula <= $fincio_ins)
				{$fini= $fincio_ins;}
				else
				{$fini= $fecha_matricula;}
				
				
				
				//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
				if($retirado==1){
				 $fter =$fecha_retiro;
				}else{
				 $fter = $ftermino_ins;
				}	
			
		}
		
		$habiles_ano=hbl($fini,$fter);
		
		//feriados del año 
		//$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
		
		//feriados del año 
		if(pg_numrows($rs_fano)>0){
			$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado WHERE id_ano=".$ano." and id_curso =".$curso." AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
		}
		else{
		$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
		}
		
		//if($_PERFIL==0){echo $sql_fano;}
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);
	
	for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
	 	 $feriados_ano=$fera;
		 
		 //dias reales año
	 $habil_real_ano = $habiles_ano-$feriados_ano;
	//inasistencias
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	
	//justificadas

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
		 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $prc_asis = round((100* $con_total_inano)/$habil_real_ano);
		 

		 ?>
         <?
    for($cont=0 ; $cont < pg_numrows($result_sub); $cont++){
    $fila_sub = @pg_fetch_array($result_sub,$cont);	
    $subsector_curso = $fila_sub['nombre'];
     $id_ramo = $fila_sub['id_ramo'];
    $conexper = $fila_sub['conexper'];
	$promedio_sub =0;
    
    $sql_promedio_sub = "SELECT promedio  FROM promedio_sub_alumno
    WHERE rut_alumno='".$rut_alumno."' AND  id_ramo=".$id_ramo;
	
    $result_promSub =@pg_Exec($conn,$sql_promedio_sub)or die("Fallo".$sql_promedio_sub);
    
	if(pg_numrows($result_promSub)==0){
	   $sql_promedio_sub = "select round(AVG(cast(p.promedio as INT))) as promedio from notas$ano_escolar p where rut_alumno='".$rut_alumno."' AND promedio not in(' ','0') AND  id_ramo=".$id_ramo;
	  $result_promSub =@pg_Exec($conn,$sql_promedio_sub)or die("Fallo".$sql_promedio_sub);
	}
	
	//if($_PERFIL==0){echo $sql_promedio_sub;}
    $fila_promSub = @pg_fetch_array($result_promSub,0);
    $promedio_sub = $fila_promSub['promedio'];
	
    
    
    if (($promedio_sub<40) and ($promedio_sub!='EX') and ($promedio_sub!=NULL) and ($promedio_sub!=0)){ 
	$arrp[$rut_alumno]['ramo'][]=$fila_sub['nombre'];
	$arrp[$rut_alumno]['promedio'][]=$promedio_sub;
	
	 } }?> 

        <tr>
          <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
          <td><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
          <?	 
	     $promedio_general = 0;
	     $promedio = 0;
	     $cont_prom = 0;
		 $suma_promedio = 0;
		 $contador_promedios_rojos=0;
		 $promedio_rojo=0;
		 $prom_contador=0;
	     
	    				
		 /// TOMO EL PROMEDIO DEL PRIMER TRIMESTRE O SEMESTRE
		$sql_primero="SELECT notas$ano_escolar.promedio, situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno
	FROM notas$ano_escolar inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo 
	left join situacion_periodo on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
	WHERE 
	notas$ano_escolar.id_periodo = ".$primer_periodo." and notas$ano_escolar.rut_alumno = '".trim($rut_alumno)."' and ramo.bool_ip=1"; 	
		 //echo $sql_primero;
		 $res_primero = @pg_Exec($conn,$sql_primero);
		 $num_primero = @pg_numrows($res_primero);		
		
		 if ($num_primero>0){
		     $suma_promedio = 0;
			 $contador = 0;
		     for ($j=0; $j < $num_primero; $j++){
		 	     $fila_primero =  @pg_fetch_array($res_primero,$j);
		  	     $conexper= $fila_primero['conexper'];
				 if($conexper!=1){
				 	$promedio = $fila_primero['promedio'];
				 }else{
					$promedio = $fila_primero['nota_final'];
				 }
				 if ($promedio > 0){
				     $suma_promedio = $suma_promedio + $promedio;
					 $contador++;
				 }
		     }
			  /* if($truncado==1){
				 $primer_promedio = @round($suma_promedio/$contador);
			  }else{
				   $primer_promedio = @intval($suma_promedio/$contador);
			  }*/
			   $primer_promedio = ($truncado_final==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			  
			 if($primer_promedio<40){
			 	$promedio_rojo++;
			 } 	 
		 }
			
			
		 /// TOMO EL PROMEDIO DEL SEGUNDO TRIMESTRE O SEMESTRE
		  $sql_segundo="SELECT notas$ano_escolar.promedio, situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno
	FROM notas$ano_escolar inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo 
	left join situacion_periodo on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
	WHERE 
	notas$ano_escolar.id_periodo = ".$segundo_periodo." and notas$ano_escolar.rut_alumno = '".trim($rut_alumno)."' and ramo.bool_ip=1";
		//echo $sql_segundo;
		 $res_segundo = @pg_Exec($conn,$sql_segundo);
		 $num_segundo = @pg_numrows($res_segundo);

		 if ($num_segundo>0){
		     $suma_promedio = 0;
			 $contador = 0;
		     for ($j=0; $j < $num_segundo; $j++){
			     $fila_segundo =  @pg_fetch_array($res_segundo,$j);	
			     $conexper = $fila_segundo['conexper'];
				 if($conexper!=1){
			     $promedio = $fila_segundo['promedio'];
				 }else{
				 $promedio=$fila_segundo['nota_final'];	 
				 }
				 
		// ACA ESTA LA CLAVE DEL EXITOOOOOOOOOO!!!!!!!----------
				 if ($promedio > 0){
				     $suma_promedio = $suma_promedio + $promedio;
					 $contador++;
				 }
				 if ($promedio < 40){
				 	if($promedio!=0){
				 	$prom_contador++;
					}
				 }
			 }
			 /*if($truncado==1){
				 $segundo_promedio = @round($suma_promedio/$contador);
			 }else{
				 $segundo_promedio = @intval($suma_promedio/$contador);
			 }*/
			  $segundo_promedio = ($truncado_final==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			  if($segundo_promedio<40){
			 	$promedio_rojo++;
			 } 	 
		 }
		 /// TOMO EL PROMEDIO DEL TERCER TRIMESTRE O SEMESTRE
		 //$sql_tercero = "select promedio from notas$ano_escolar where rut_alumno = '".trim($rut_alumno)."' and id_periodo = '".$tercer_periodo."'";
		 $sql_tercero="SELECT notas$ano_escolar.promedio, situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno
	FROM notas$ano_escolar inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo 
	left join situacion_periodo on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1
	WHERE 
	notas$ano_escolar.id_periodo = ".$tercer_periodo." and notas$ano_escolar.rut_alumno = '".trim($rut_alumno)."' and ramo.bool_ip=1";
		//echo $sql_segundo;
		 $res_tercero = @pg_Exec($conn,$sql_tercero);
		 $num_tercero = @pg_numrows($res_tercero);
		 if ($num_tercero>0){
		     $suma_promedio = 0;
			 $contador = 0;
		     for ($j=0; $j < $num_tercero; $j++){
			     $fila_tercero =  @pg_fetch_array($res_tercero,$j);	
			     $conexper = $fila_tercero['conexper'];
				 if($conexper!=1){
			     $promedio = $fila_tercero['promedio'];
				 }else{
				 $promedio=$fila_tercero['nota_final'];	 
				 }
				 
		// ACA ESTA LA CLAVE DEL EXITOOOOOOOOOO!!!!!!!----------
				 if ($promedio > 0){
				     $suma_promedio = $suma_promedio + $promedio;
					 $contador++;
				 }
				 if ($promedio < 40){
				 	if($promedio!=0){
				 	$prom_contador++;
					}
				 }
			 }
			  $tercero_promedio = ($bool_psemestral==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			/// $tercero_promedio = @round($suma_promedio/$contador);
			 if($tercero_promedio<40){
			 	$promedio_rojo++;
			 } 	 
		 } 	
		 
			  if ($primer_promedio<40){
			      $color = "FF0000";
				  $promedios_rojos++;
				  
			  }else{
			      $color = "000000";
			  }	  	  
		    
		      $suma_promedio = 0;
		      $contador = 0;
			  $promedios_rojos = 0;
	          ?>
              <td >
		      <div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
              <?
			  if ($primer_promedio > 0){		  
	             echo $primer_promedio; 
				 $suma_promedio = $suma_promedio + $primer_promedio;
				 $contador++;
			  }else{
			     echo "&nbsp;";
			  }	 
			  if ($segundo_promedio<40){
			      $color = "FF0000";
				  $promedios_rojos++;
				  
			  }else{
			      $color = "000000";
			  }	
	          ?>
              </font></div></td>
              <td ><div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
			  <?		  
	          if ($segundo_promedio > 0){			  
			      echo $segundo_promedio;
				 $suma_promedio = $suma_promedio + $segundo_promedio;
				  $contador++;
			  }else{
			      echo "&nbsp;";
			  }	  	  
			  			  
			  if ($tercero_promedio<40){
			      $color = "FF0000";
				  $promedios_rojos++;
				  
			  }else{
			      $color = "000000";
			  }	 
	          ?></font></div>		      </td>
              <? if ($num_periodos > 2){ ?>
			  
				  <td ><div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
				  <?
				  if ($tercero_promedio > 0){
					  echo $tercero_promedio;
					  $suma_promedio = $suma_promedio + $tercero_promedio;
					  $contador++;
				  }else{
					  echo "&nbsp;";
				  }	
					
					
				  ?></font></div>				  </td>
			<? } ?>    
			  
			  <?
			   $promedio_final = ($bool_psemestral==1)?@round($suma_promedio/$contador):@intval($suma_promedio/$contador);
			//  $promedio_final = round($suma_promedio/$contador);
			  //echo $promedios_rojos;
			  if ($promedio_final<40){
			      $color = "FF0000";				  
			  }else{
			      $color = "000000";
			  }	
			 /*if($promedios_rojos>1){
			  						
			  				$bg_color = "ff9966";
			 			}else{
					  		
				          $bg_color = "f5f5f5";
				      }*/	
			      /*if ($promedios_rojos >1){
			  	      $bg_color = "ff9966";
			      }else{*/
					 if ($promedio_final < 45){
					     $bg_color = "ff9966";
				      
					  } elseif($promedios_rojos >1){
					  
					  	$bg_color = "ff9966";
					  
					 } elseif($promedio_rojo >0){
					  
					  	$bg_color = "ff9966";
					} elseif($prom_contador >1){
					  $bg_color = "ff9966";
					 }else{
					  		
				          $bg_color = "f5f5f5";
				      }	
					   if(count($arrp[$rut_alumno]['ramo'])>=3){
						 $bg_color = "ff9966";
						 }
						 
						 if ($promedio_final >=50  && count($arrp[$rut_alumno]['ramo'])<=2){
					     $bg_color = "f5f5f5";
				      
					  }
			      //}
			  /*}else{
			      $bg_color = "f5f5f5";
			  } */ 
			  
			  ?>

              <td bgcolor="<?=$bg_color ?>"><div align="center"><font size="0" face="arial, geneva, helvetica" color="<?=$color ?>">
                <?php  
			 $sumnf=0;
			  $sql_notasn = "select round(avg(cast(notas$ano_escolar.promedio as INT))) as promedio,
situacion_periodo.nota_final,ramo.conexper,notas$ano_escolar.rut_alumno,notas$ano_escolar.id_ramo   
FROM notas$ano_escolar  inner join ramo on notas$ano_escolar.id_ramo=ramo.id_ramo left join situacion_periodo 
on notas$ano_escolar.rut_alumno = situacion_periodo.rut_alumno and ramo.conexper=1 
WHERE   notas$ano_escolar.rut_alumno = '$rut_alumno' AND notas$ano_escolar.promedio 
NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N','-','EX')
group by notas$ano_escolar.rut_alumno ,notas$ano_escolar.id_ramo,situacion_periodo.nota_final,ramo.conexper"; 
$rs_notasn=pg_exec($conn,$sql_notasn);

for($nnf=0;$nnf<pg_numrows($rs_notasn);$nnf++){
$filanf=pg_fetch_array($rs_notasn,$nnf);
$sumnf=$sumnf+$filanf['promedio'];
}
 @$promedio_final = ($truncado_final==1)?@round($sumnf/pg_numrows($rs_notasn)):@intval($sumnf/pg_numrows($rs_notasn));
 
?>
			  <?
			  echo $promedio_final;
			  ?>
			  </font></div>			  </td>
              <td bgcolor="#<?=($prc_asis<85)?"ff9966":"f5f5f5" ?>"><div align="center"><font size="0" face="arial, geneva, helvetica" color="#<?=($prc_asis<85)?"ff0000":"000000" ?>"><?php echo $prc_asis ?></font></div></td>
               <td>
         
    <table border="1" cellpadding="0" cellspacing="0">
    <tr>
    <?php for($r=0;$r<count($arrp[$rut_alumno]['ramo']);$r++){?>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#003366"><?php echo InicialesSubsector($arrp[$rut_alumno]['ramo'][$r]) ?></font></td>
    <?php }?>
    </tr>
    <tr>
    <?php for($p=0;$p<count($arrp[$rut_alumno]['promedio']);$p++){?>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px" color="#FF0000"><?php echo $arrp[$rut_alumno]['promedio'][$p] ?></font></td>
    <?php }?>
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
			  $ape_pat          = $fila_apo['ape_pat'];
	          $fono_apoderado   = $fila_apo['telefono'];
	         
			
		      ?>
          <td><div align="left"><font size="0" face="arial, geneva, helvetica">&nbsp;<? echo $nombre_apoderado." ".$ape_pat; ?></font></div></td>
          <td><div align="center"><font size="0" face="arial, geneva, helvetica"><? echo $fono_apoderado; ?></font></div></td>
        </tr>
        <?  } ?>
      </table>
      <br></td>
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


?>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="InformeRendimientoCriticoFinal.php">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
/*$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";*/
$sql="SELECT * FROM perfil_curso WHERE rdb=".$_INSTIT." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND curso.ensenanza=".pg_result($rs_acceso,3)." AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}
	  	$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$ano.")) ";
		if($_PERFIL==17){
			$sql_curso.= " AND id_curso=".$_CURSO."";	
		}else if(pg_num_rows($rs_acceso)!=0 || $_PERFIL!=0){
			$sql_curso.= $whe_perfil_curso;
		}
		
		$sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
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
    <td width="701"  class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
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
   
    <td width="80"><div align="right">
      <input name="cb_ok" class="botonXX"  type= "submit"  value="Buscar">  
      <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
    </div></td>
  </tr>
  <tr class="cuadro01">
    <td>Alumnos retirados</td>
    <td><input name="ret" type="checkbox" id="ret" value="1" <?php echo ($ret==1)?"checked":"" ?>></td>
    <td>&nbsp;</td>
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
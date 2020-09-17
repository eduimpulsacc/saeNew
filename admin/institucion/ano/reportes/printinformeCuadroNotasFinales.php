
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
include('../../../clases/class_Reporte.php');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
    $ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$retirados		=$retirados;
	$tipo_examen	=$conexamen;
	$sumapromedios	=$sumapromedios;
	$reporte		= $c_reporte;
	 $check_may = $_GET['check_may'];
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_reporte = new Reporte();
	//if (empty($curso)) //exit;
	//-------------- INSTITUCION -------------------------------------------------------------
	 $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE (((institucion.rdb)=".$institucion.")); ";
	
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//------------------------
	// Periodos
	//------------------------
	 $sql_periodo = "select * from periodo where id_ano = ".$ano."order by id_periodo asc";
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	//$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal=(pg_numrows($result_periodo)==2)?"SE":"TR";
	
	/*$periodo_pal = $fila_periodo['nombre_periodo'];
	$periodo_finicio = $fila_periodo['fecha_inicio'];
	$periodo_ftermino = $fila_periodo['fecha_termino'];
	$dias_habiles = $fila_periodo['dias_habiles'];*/
 $sql_fercur ="select * from feriado_curso where id_curso=".$curso;
$rs_fercur = pg_exec($conn,$sql_fercur);
	
	
	//------------------------
	//primer periodo
	//------------------------
	$sql_pperiodo = "select id_periodo from periodo where id_ano=".$ano." order by  id_periodo asc limit 1";
	$result_pperiodo =@pg_Exec($conn,$sql_pperiodo);
	$pperiodo = @pg_result($result_pperiodo,0);
	
	//------------------------
	//periodos anteriores
	//------------------------
	$sql_aperiodo = "select id_periodo from periodo where id_ano=".$ano." and id_periodo < $periodo order by  id_periodo";
	$result_aperiodo =@pg_Exec($conn,$sql_aperiodo);
	//if($_PERFIL==0)echo $sql_aperiodo;
	
	//-----------------
	//total periodos
	//---------------
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	//echo $num_periodos;
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	
	$inicio_ano = $fila_ano['fecha_inicio'];
	$fin_ano = $fila_ano['fecha_termino'];
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

	$sql_curso = "SELECT truncado_per FROM curso WHERE id_curso=".$curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['truncado_per'];
	
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
	
	$ret="and matricula.bool_ar=0 ";
	
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.fecha, matricula.fecha_retiro ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ".$ret;
	if($genero==1){
		$sql_alu.=" AND sexo=1 ";	
	}else if($genero==2){
		$sql_alu.=" AND sexo=2 ";		
	}
	if($orden==0){
		$sql_alu = $sql_alu . "ORDER BY nro_lista ASC ";
	}else{
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ASC";
	}
	// echo $sql_alu ;
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
//	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip, ramo.cod_subsector, ramo.porc_examen, ramo.conexper,ramo.coef2,ramo.bool_pgeneral ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila1 = pg_fetch_array($result_sub);
	$conexper = $fila1['conexper'];
	
	//-----------------------------------------
	
	$sql = "SELECT truncado_per, truncado_final FROM curso WHERE id_curso=".$curso;
	$rs_curso = @pg_exec($conn,$sql);
	$truncado_per = @pg_result($rs_curso,0);
	$truncado_final = @pg_result($rs_curso,1);	
	
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);	
	
	 function dif($ini,$ter){
	return  round(abs(strtotime($ter)-strtotime($ini))/86400);
	 }
	 
	 
	 function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        return count($diashabiles);
}
	 
	$arr_np=array();

if(isset($cb_ex)){
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=PromediosGenerales_".date("Y-m-d").".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php if(isset($cb_ok)){?>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<?php }?>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'PlanillaNotasGeneralesPeriodo.php?institucion=$institucion';
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
//-->
</script>

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<style type="text/css">
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
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
		<TABLE width="100%">
		  <TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD>
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </div>
		</TD></TR></TABLE>
        </div>		</td>
      </tr>
    </table>
	
	
	
	
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
	
	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="100" align="center">
            
	<?
	
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia
if(isset($cb_ok)){
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='100' >";

	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }
	}
	  ?>	  	
      	</td>
		</tr>
     </table>	</td>
  </tr>
  <tr>
    <td align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

    <? } ?></td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex"><div align="center">PROMEDIOS GENERALES POR ASIGNATURA</div></td>
      </tr>
      <tr>
            <td align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>A&Ntilde;O &nbsp;<? echo $ano_escolar?> </strong></font></td>
      </tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td width="140"><font size="1" face="verdana,arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="verdana,arial, geneva, helvetica">:</font></div></td>
        <td width="506"><font size="1" face="verdana,arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td></div><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><? echo $ob_reporte->tildeM($profe_jefe);?></font></td>
      </tr>
      
    </table>
	<br>
	
	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr >
    <td rowspan="3" width="20" class="tablatit2-1">Nº</td>
	<td rowspan="3" width="170" class="tablatit2">NOMBRE DEL ALUMNO</td>
    <td colspan="<?php echo $num_subsectores+($num_subsectores*pg_numrows($result_periodo))+2 ?>" class="tablatit2"><div align="center">ASIGNATURAS</div></td>
    </tr>
  <tr>
    <?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso 	= $fila_sub['nombre'];
		$id_ramo 			= $fila_sub['id_ramo'];
		$cod_subsector 		= $fila_sub['cod_subsector'];
		$modo_eval 			= $fila_sub['modo_eval'];
		$examen 			= $fila_sub['conex']; // 1 SI 2 NO
		$porc_examen 		= $fila_sub['porc_examen'];
		$conexper			= $fila_sub['conexper'];
    
	
	?>	
    
   
    <td align="center" colspan="<?php echo pg_numrows($result_periodo)+1 ?>"><font size="1" face="verdana,arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso) ?>
	</strong></font></td>
	<? }?>
  
    <td rowspan="2" align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final</strong></font></td>
  
     <td rowspan="2" align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>% Asist.</strong></font></td>
    </tr>
  <tr>
 <?php 
 //mostrar periodos
 for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
 for($p=0;$p<pg_numrows($result_periodo)+1;$p++){
	 $pal = (pg_numrows($result_periodo)>$p)?($p+1)." ".$periodo_pal:"PF"; 
	 
	
	 ?>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><strong><?php echo $pal ?></strong></font></td>
    <?php }
	}
	?>
    </tr>
 

    <?
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	  $rut_alumno = $fila_alu['rut_alumno'];
	  
	  $fecha_retiro = $fila_alu['fecha_retiro'];
	$fecha_matricula = $fila_alu['fecha'];
	  
	  $sum_pgeneral=0;
	  
	  $p_final=0;
	  
	  $cont_prom=0;
	  
	  
	  $feriados_ano=0;
		$fera=0;
//=========== calculo % asistencia nuevo =====
	//************ habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($fecha_matricula <= $inicio_ano)
		{$fini= $inicio_ano;}
		else
		{$fini= $fecha_matricula;}
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
		if($retirado==1){
		 $fter =$fecha_retiro;
		}else{
		 $fter = $fin_ano;
		}
		
		//conteo dias habiles año (sin feriados)
		 $habiles_ano=hbl($fini,$fter);
		 
		
	
//***************fin habikes (nuevo)
//******feriados año
if(pg_numrows($rs_fercur)>0){
	$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado  inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado WHERE id_ano=".$ano." and id_curso =".$curso." AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	}
else{
    $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' or feriado.fecha_fin<='".$fter."');";
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


//fin feriados año	
	
	//dias reales año
	 $habil_real_ano = $habiles_ano-$feriados_ano;
	

 //inasistencias
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$rut_alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	
//justificadas

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
 
 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $prc_base = intval((100* $con_total_inano)/$habil_real_ano);
	
//=========== fin calculo % asistencia nuevo =====
	  
	$cuntapfin=0;
	  
	  
	  ?>	
 <tr>
    <td ><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
   <?php for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		
		$id_ramo 			= $fila_sub['id_ramo'];
		$bool_pgeneral 			= $fila_sub['bool_pgeneral'];
		$sum_ramo=0;
	 $cper=0;
		
 for($p=0;$p<pg_numrows($result_periodo);$p++){
		 
	  $fil_p = pg_fetch_array($result_periodo,$p);
	 $id_p=$fil_p['id_periodo'];
	 
	
	
	
	 
	 ?>
    <td align="center">
	<font size="0" face="arial, geneva, helvetica">
	<?php  $ob_reporte->nro_ano=$ano_escolar;
	 $ob_reporte->alumno=$rut_alumno;
	 $ob_reporte->id_ramo=$id_ramo;
	 $ob_reporte->periodo=$id_p;
	 
	 $rs_prom_per = $ob_reporte->PromedioRamoAlumnoPeriodo($conn);
	echo  $prom = pg_result($rs_prom_per,0);
	//$sum_ramo = $sum_ramo+$prom;
	
	if($prom>0 && $bool_pgeneral ==1)
	{
		$sum_ramo = $sum_ramo+$prom;
		$cont_prom++;
		$cper++;
	}
	
	?>
    </font>
    </td>
    <?php }
	
	if($check_ano==0){
	$sum_ramo = $sum_ramo;
	//$p_ran= ($truncado_per==1)?round($sum_ramo/pg_numrows($result_periodo)):intval($sum_ramo/pg_numrows($result_periodo));
	$p_ran= ($truncado_per==1)?round($sum_ramo/$cper):intval($sum_ramo/$cper);
	}
	else{
		
	$ob_reporte->ano=$ano;
	 $ob_reporte->alumno=$rut_alumno;
	 $ob_reporte->ramo=$id_ramo;
	 $ob_reporte->curso=$curso;
	 $rs_ppf = $ob_reporte->PromedioSubAlumno($conn);
		
	$sum_ramo = pg_result($rs_ppf,0);
	
	$p_ran=$sum_ramo;
	}
	
	if($p_ran>0 ){
	$sum_pgeneral= $sum_pgeneral+$p_ran;
	$cuntapfin++;
	}
	
	
	
	?>
     <td align="center"><font size="0" face="arial, geneva, helvetica"><strong><?php echo $p_ran ?></strong></font></td>
    <?php
	}
	if($check_ano==0){
	$p_final=$sum_pgeneral/$cuntapfin;
	}
	else{
		
		$ob_reporte->institucion=$institucion;
		 $ob_reporte->alumno=$rut_alumno;
		 $ob_reporte->ramo=$id_ramo;
		 $ob_reporte->curso=$curso;
		 $rs_final =$ob_reporte->Promocion($conn);
		$p_final = pg_result($rs_final,4);
	}
	?>
    <td align="center" ><font size="0" face="arial, geneva, helvetica"><?php echo ($truncado_final==1)?round($p_final):intval($p_final) ?><strong></strong></td>
    <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong><?php echo $prc_base ?></strong></font></td>
  </tr>
  	<? } 
	?>	
    
  
  </table>   </td>
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
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>
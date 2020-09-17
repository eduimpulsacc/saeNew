<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
include('../../../../../clases/class_Reporte.php');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Membrete.php');

if($_PERFIL==0){
	show($_POST);
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	//exit;
	}

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
    $ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$retirados		=$retirados;
	$tipo_examen	=$conexamen;
	$sumapromedios	=$sumapromedios;
	$reporte		= $c_reporte;
	$check_may 		= $check_may;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	$media	=$nmedia;
	$orden=0;
	
	$aprpg=$_POST['chkAPROXPGENERAL'];
	
	//show($_POST);
	
	/*******INSITUCION *******************/
	$ob_membrete = new Membrete();
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
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
	$periodo_finicio = $fila_periodo['fecha_inicio'];
	$periodo_ftermino = $fila_periodo['fecha_termino'];
	$dias_habiles = $fila_periodo['dias_habiles'];

	$sql_periodo1 = "select * from periodo where id_ano=".$ano." and id_periodo<>".$periodo." ORDER BY id_periodo ASC";
	$Rs_Periodo = @pg_exec($conn,$sql_periodo1);
	$fils_periodo = @pg_fetch_array($Rs_Periodo,0);
	$otro_periodo = $fils_periodo['id_periodo'];
	
	
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

	$sql_curso = "SELECT truncado_per, bool_psemestral FROM curso WHERE id_curso=".$curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['bool_psemestral'];
	
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
	if($retirados==1)
	{$ret="and matricula.bool_ar<>1";}
	
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.fecha as fmat,matricula.nro_lista ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ".$ret;
	if($genero==1){
		$sql_alu.=" AND sexo=1 ";	
	}else if($genero==2){
		$sql_alu.=" AND sexo=2 ";		
	}
	/*if($orden==0){
		$sql_alu = $sql_alu . "ORDER BY nro_lista ASC ";
	}else{
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ASC";
	}*/
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
	$bool_pgeneral = $fila1['bool_pgeneral'];
	//-----------------------------------------
	
	$sql = "SELECT truncado_per, truncado_final, bool_psemestral FROM curso WHERE id_curso=".$curso;
	$rs_curso = @pg_exec($conn,$sql);
	$truncado_per = @pg_result($rs_curso,2);
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
	
	
	

	
	/*nuevo Arreglo para traer los alumnos*/
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	  $rut_alumno = $fila_alu['rut_alumno'];
	  $nro_lista = $fila_alu['nro_lista'];
	  $fmat = $fila_alu['fecha'];
	  $fret = $fila_alu['fecha_retiro'];
	  
	  
	  $_CONTEO=0;
	  $_PROMEDIO=0;
	  $prome_abajo=0;
	  $prome_apreciacion=0;
	  
	  $listaAlu[$rut_alumno]['nombre'][]=sanear_string($nombre_alu);
	  $listaAlu[$rut_alumno]['nro_lista'][]=$nro_lista;
	  $listaAlu[$rut_alumno]['rut'][]=$rut_alumno;
	  $listaAlu[$rut_alumno]['fmat'][]=$rut_alumno;
	  $promedio_general = 0;
	  //armar promedio
	  
		$cont_prom_general = 0;
		$promedio = 0;
		$cont_prom = 0;
		$promedio_general1 = 0;
		$cont_prom_general1 = 0;
		$promedio1 = 0;
		$cont_prom1 = 0;
			for($cont=0 ; $cont < $num_subsectores; $cont++)
				{
				$fila_sub = @pg_fetch_array($result_sub,$cont);	
				$subsector_curso 	= $fila_sub['nombre'];
				$id_ramo 			= $fila_sub['id_ramo'];
				$cod_subsector 		= $fila_sub['cod_subsector'];
				$conexper			= $fila_sub['conexper'];
				$coef2				= $fila_sub['coef2'];
				$bool_pgeneral				= $fila_sub['bool_pgeneral'];
				//---------------------------------------
				// Notas
				//---------------------------------------
				$sumapprom=0;
				$cuentapprom=0;
				
				$sql_notas = "SELECT notas$ano_escolar.promedio,notaap ";
				$sql_notas = $sql_notas . "FROM notas$ano_escolar ";
				$sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".   $id_ramo.") and id_periodo = ".$periodo.") ; ";
				$result_notas =@pg_Exec($conn,$sql_notas);
				$cont_prom = 0;
				$fila_notas = @pg_fetch_array($result_notas,0);
				
				if($ck_opcion==1){
					$promedio = $fila_notas['promedio'];
				}else{		
					$promedio = $fila_notas['notaap'];
					if(!isset($promedio)){
						$promedio = $fila_notas['promedio'];
					}
				}
				if($periodo>$otro_periodo){
					$sql_notas1 = "SELECT notas$ano_escolar.promedio, notaap ";
					$sql_notas1 = $sql_notas1 . "FROM notas$ano_escolar ";
					$sql_notas1 = $sql_notas1 . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$otro_periodo.") ; ";
					$cont_prom1 = 0;
				}
				
				
				
				$result_notas1 =@pg_Exec($conn,$sql_notas1);
				$fila_notas1 = @pg_fetch_array($result_notas1,0);
				
				//if($_PERFIL==0) echo $sql_notas1."--->".$fila_notas1['promedio']."---".$fila_notas1['notaap']."<br>";
				if($ck_opcion==1){
				//  NUEVO CODIGO DE EXAMEN SEMESTRAL
					$sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
					$rs_examen = @pg_exec($conn,$sql);
					$cuenta_examen = @pg_result($rs_examen,0);
					$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$otro_periodo." AND rut_alumno=".$rut_alumno;
					$rs_nota = @pg_exec($conn,$sql);
					$nota_porc = 0;
					for($jj=0;$jj<$cuenta_examen;$jj++){
						$fils_nota = @pg_fetch_array($rs_nota,$jj);
						$prome_abajo=0;
						$nota_ex = $fils_nota['nota'];
						if(@pg_numrows($rs_nota)==0){
							$nota_ex="&nbsp;";
						}
						$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
						$rs_porc = @pg_exec($conn,$sql);
						$porc = @pg_result($rs_porc,0);
						$aprox_ex = @pg_result($rs_porc,1);
						$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
					}
					if($nota_porc==0){
						$promedio1 = $fila_notas1['promedio'];
					}else{
						if($truncado_per==1){
							//echo " ..... promedio -->".($fila_notas1['promedio'] * $porc_examen)/100;					
							$promedio = round($nota_porc + (($fila_notas1['promedio'] * $porc_examen)/100));
						}else{
							$promedio = intval($nota_porc + (($fila_notas1['promedio'] * $porc_examen)/100));
						}
						
					}
					
					// FIN EXAMEN SEMESTRAL
					//$promedio1 = $fila_notas1['promedio'];
				}else{
					$promedio1 = $fila_notas1['notaap'];
					if(!isset($promedio1)){
						$promedio1 = $fila_notas1['promedio'];
					}
				}
				/****************** OPCION DE PROMEDIO FINAL DE SITUACION PERIODO **************************/
				if($conexper==1 && $tipo_examen==1){
					 
					 $sql="select sp.id_periodo,sp.rut_alumno,sp.nota_final,sp.nota_examen,sp.prom_gral, r.conexper from situacion_periodo as sp inner JOIN ramo as r on r.id_ramo = sp.id_ramo where sp.rut_alumno= ".$rut_alumno." and sp.id_periodo = ".$periodo."
					and sp.id_ramo = ".$id_ramo." and r.conexper=1";	
					$result_con =pg_Exec($conn,$sql)or die("Fallo :".$sql);
					$filaconexamen = pg_fetch_array($result_con,0);  
					$promedio = $filaconexamen['nota_final'];
				}	
				///*********************** FIN NUEVO CODDIGO *****************************************/
				
				
				/************************** EXAMEN COEF2 ******************************************/
				
				if($coef2==1){
					$sql="SELECT promedio FROM notacoef WHERE rut_alumno=".$rut_alumno." AND id_periodo=".$periodo." AND id_ramo=".$id_ramo;
					$rs_coef2 = pg_exec($conn,$sql);
					$promedio = pg_result($rs_coef2,0);
				}
				
				
				/************************** FIN EXAMEN COEF2 ******************************************/
				
				if ($promedio>0) 
					$cont_prom = $cont_prom + 1;
				if ($promedio1>0) 
					$cont_prom1 = $cont_prom1 + 1;
				//-------------------------------------
				// Eximidos
				//-------------------------------------
				$sql_inscri = "select count(*) as cantidad ";
				$sql_inscri = $sql_inscri . "from   tiene$ano_escolar ";
				$sql_inscri = $sql_inscri . "where rut_alumno = '".$rut_alumno."' and id_ramo = ".$id_ramo." and id_curso = ".$curso;
				$result_inscri =@pg_Exec($conn,$sql_inscri);
				$fila_inscri= @pg_fetch_array($result_inscri,0);
				if ($fila_inscri['cantidad'] == 0)
				{
					$promedio = "";
					$cont_prom = 1;
				}	
				else
				{
					if ($modo_eval <> 1)
					{
						if (trim($promedio)<>"0")
							{$cont_prom = 1;
							
							}
							
						else
							$cont_prom = 0;
						if (trim($promedio1)<>"0")
							$cont_prom1 = 1;
						else
							$cont_prom1 = 0;
					}
				}
				if ($promedio > 0 && $bool_pgeneral==1)
				{
					
					$promedio_general = $promedio_general + $promedio;
					 $cont_prom_general = $cont_prom_general + 1;
					$notas_arr[$i][$cont] = $promedio;
					
				}
				if ($promedio1 > 0 && $bool_pgeneral==1)
				{
					$promedio_general1 = $promedio_general1 + $promedio1;
					$cont_prom_general1 = $cont_prom_general1 + 1;
					$notas_arr1[$i][$cont] = $promedio1;
				}
			
			
		}
	  $listaAlu[$rut_alumno]['promedio'][]=($truncado_per==1)?round($promedio_general/$cont_prom_general):intval($promedio_general/$cont_prom_general);
	  
	  
	
	
	
	}
	
	if($orden==0){
		$sorted = array_orderby($listaAlu, 'nro_lista', SORT_ASC);
	}
	elseif($orden==1){
		$sorted = array_orderby($listaAlu, 'nombre', SORT_ASC);
	}
	elseif($orden==2){
		$sorted = array_orderby($listaAlu, 'promedio', SORT_DESC);
	}
	elseif($orden==3){
		$sorted = array_orderby($listaAlu, 'promedio', SORT_ASC);
	}
	
	
	
	
	//show($sorted);
	
	if($cb_ok!="Buscar"){
		$xls=1;
	}
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header('Content-Type: application/octet-stream');
	header("Content-Disposition:inline; filename=PlanillaNotasGeneralesPeriodo$fecha_actual.xls");
		 
	}
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php if($cb_ok=="Buscar"){?>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<?php }else{?>

<?php $estilo = file_get_contents('../../../../../../'.$_ESTILO);?>
<style>
<?php echo $estilo;?>
</style>
<? }?>
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso)){
   // exit;
}else{
   ?>
<center>
<div id="capa0">

		<TABLE width="850" align="center">
		  <TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD>
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </div>
		</TD></TR></TABLE>
       		
	 </div>

<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
	
	
	<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
     <?       if($cb_ok=="Buscar"){
	
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }
	  
	 }?>	  		</td>
		</tr>
     </table>	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($telefono));?></font></td>
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
	<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td align="center" class="tableindex"><div align="center">PROMEDIOS GENERALES</div></td>
      </tr>
      <tr>
            <td align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong><? echo $periodo_pal?> 
              de&nbsp;<? echo $ano_escolar?> </strong></font></td>
      </tr>
</table>
<br>
	<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
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
      <tr>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Promedios con examen</strong></font> </td>
        <td>:</td>
        <td>&nbsp;<font size="1" face="verdana,arial, geneva, helvetica"><? echo ($tipo_examen==1)?"SI":"NO";?></font></td>
      </tr>
    </table>
	<br>
	
	<table width="850" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr >
    <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	<td rowspan="2" width="170" class="tablatit2">NOMBRE DEL ALUMNO</td>
    <td colspan="<? echo $num_subsectores+3+pg_numrows($result_aperiodo) ?>" class="tablatit2"><div align="center">ASIGNATURAS</div></td>
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
    <td align="center"><font size="1" face="verdana,arial, geneva, helvetica"><strong>
    <?  if($op_sub==1){
			InicialesSubsector($subsector_curso);
		}else{
			echo $cod_subsector;	
		}
		
	//?>
	</strong></font></td>
	<? }?>
    <? if($sumapromedios==1){?>
     <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Suma Total</strong></font></td>
     <? }?>
    <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final</strong></font></td>
    <?php if($periodo != $pperiodo){
		for($p=1;$p<=pg_numrows($result_aperiodo);$p++){
		?>
    <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final <?php echo $p ?>° <?php echo $tipo_per ?></strong></font></td>
    <?php }
	}?>
     <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>% Asist.</strong></font></td>
    </tr>

    <?
	$numero_alumnos = count($sorted);	 
	
		for($i=0 ; $i < count($sorted) ; $i++)
	{
	  	  
	  $_CONTEO=0;
	  $_PROMEDIO=0;
	  $prome_abajo=0;
	  $prome_apreciacion=0;
	  
	  $rut_alumno = $sorted[$i]['rut'][0];
	  $nombre_alu =  $sorted[$i]['nombre'][0];
	  ?>
      <tr class="textosimple">
      <td><? echo $i+1; ?></td>
      <?  if ($check_may == 1){ ?>
    <td><font size="0" face="arial, geneva, helvetica"><? echo strtoupper($nombre_alu); ?></font></td>
	<?	 }else{ ?>
    
    <td><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
	<?	 } ?>
      <?php 	
	  	$promedio_general = 0;
        $cont_prom_general = 0;
        $promedio = 0;
        $cont_prom = 0;
        $promedio_general1 = 0;
        $cont_prom_general1 = 0;
        $promedio1 = 0;
        $cont_prom1 = 0;
		for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso 	= $fila_sub['nombre'];
		$id_ramo 			= $fila_sub['id_ramo'];
		$cod_subsector 		= $fila_sub['cod_subsector'];
		$conexper			= $fila_sub['conexper'];
		$coef2				= $fila_sub['coef2'];
		$bool_pgeneral				= $fila_sub['bool_pgeneral'];
		//---------------------------------------
		// Notas
		//---------------------------------------
		$sumapprom=0;
	  	$cuentapprom=0;
		
		$sql_notas = "SELECT notas$ano_escolar.promedio,notaap ";
		$sql_notas = $sql_notas . "FROM notas$ano_escolar ";
		$sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".   $id_ramo.") and id_periodo = ".$periodo.") ; ";
		$result_notas =@pg_Exec($conn,$sql_notas);
		$cont_prom = 0;
        $fila_notas = @pg_fetch_array($result_notas,0);
		
		if($ck_opcion==1){
			$promedio = $fila_notas['promedio'];
		}else{		
			$promedio = $fila_notas['notaap'];
			if(!isset($promedio)){
				$promedio = $fila_notas['promedio'];
			}
		}
		if($periodo>$otro_periodo){
			$sql_notas1 = "SELECT notas$ano_escolar.promedio, notaap ";
			$sql_notas1 = $sql_notas1 . "FROM notas$ano_escolar ";
			$sql_notas1 = $sql_notas1 . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$otro_periodo.") ; ";
			$cont_prom1 = 0;
		}
		
		
		
		$result_notas1 =@pg_Exec($conn,$sql_notas1);
		$fila_notas1 = @pg_fetch_array($result_notas1,0);
		
		//if($_PERFIL==0) echo $sql_notas1."--->".$fila_notas1['promedio']."---".$fila_notas1['notaap']."<br>";
		if($ck_opcion==1){
		//  NUEVO CODIGO DE EXAMEN SEMESTRAL
			$sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
			$rs_examen = @pg_exec($conn,$sql);
			$cuenta_examen = @pg_result($rs_examen,0);
			$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$otro_periodo." AND rut_alumno=".$rut_alumno;
			$rs_nota = @pg_exec($conn,$sql);
			$nota_porc = 0;
			for($jj=0;$jj<$cuenta_examen;$jj++){
				$fils_nota = @pg_fetch_array($rs_nota,$jj);
				$prome_abajo=0;
				$nota_ex = $fils_nota['nota'];
				if(@pg_numrows($rs_nota)==0){
					$nota_ex="&nbsp;";
				}
				$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
				$rs_porc = @pg_exec($conn,$sql);
				$porc = @pg_result($rs_porc,0);
				$aprox_ex = @pg_result($rs_porc,1);
				$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
			}
			if($nota_porc==0){
				$promedio1 = $fila_notas1['promedio'];
			}else{
				if($truncado_per==1){
					//echo " ..... promedio -->".($fila_notas1['promedio'] * $porc_examen)/100;					
					$promedio = round($nota_porc + (($fila_notas1['promedio'] * $porc_examen)/100));
				}else{
					$promedio = intval($nota_porc + (($fila_notas1['promedio'] * $porc_examen)/100));
				}
				
			}
			
			// FIN EXAMEN SEMESTRAL
			//$promedio1 = $fila_notas1['promedio'];
		}else{
			$promedio1 = $fila_notas1['notaap'];
			if(!isset($promedio1)){
				$promedio1 = $fila_notas1['promedio'];
			}
		}
		/****************** OPCION DE PROMEDIO FINAL DE SITUACION PERIODO **************************/
		if($conexper==1 && $tipo_examen==1){
			 
			 $sql="select sp.id_periodo,sp.rut_alumno,sp.nota_final,sp.nota_examen,sp.prom_gral, r.conexper from situacion_periodo as sp inner JOIN ramo as r on r.id_ramo = sp.id_ramo where sp.rut_alumno= ".$rut_alumno." and sp.id_periodo = ".$periodo."
			and sp.id_ramo = ".$id_ramo." and r.conexper=1";	
			$result_con =pg_Exec($conn,$sql)or die("Fallo :".$sql);
			$filaconexamen = pg_fetch_array($result_con,0);  
			$promedio = $filaconexamen['nota_final'];
		}	
		///*********************** FIN NUEVO CODDIGO *****************************************/
		
		
		/************************** EXAMEN COEF2 ******************************************/
		
		if($coef2==1){
			$sql="SELECT promedio FROM notacoef WHERE rut_alumno=".$rut_alumno." AND id_periodo=".$periodo." AND id_ramo=".$id_ramo;
			$rs_coef2 = pg_exec($conn,$sql);
			$promedio = pg_result($rs_coef2,0);
		}
		
		
		/************************** FIN EXAMEN COEF2 ******************************************/
		
		if ($promedio>0) 
		  	$cont_prom = $cont_prom + 1;
		if ($promedio1>0) 
		  	$cont_prom1 = $cont_prom1 + 1;
		//-------------------------------------
		// Eximidos
		//-------------------------------------
		$sql_inscri = "select count(*) as cantidad ";
		$sql_inscri = $sql_inscri . "from   tiene$ano_escolar ";
		$sql_inscri = $sql_inscri . "where rut_alumno = '".$rut_alumno."' and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$result_inscri =@pg_Exec($conn,$sql_inscri);
		$fila_inscri= @pg_fetch_array($result_inscri,0);
		if ($fila_inscri['cantidad'] == 0)
		{
			$promedio = "";
			$cont_prom = 1;
		}	
		else
		{
			if ($modo_eval <> 1)
			{
				if (trim($promedio)<>"0")
					{$cont_prom = 1;
					
					}
					
				else
					$cont_prom = 0;
				if (trim($promedio1)<>"0")
					$cont_prom1 = 1;
				else
					$cont_prom1 = 0;
			}
		}
		if ($promedio > 0)
		{
			
			$promedio_general = $promedio_general + $promedio;
			 $cont_prom_general = $cont_prom_general + 1;
			$notas_arr[$i][$cont] = $promedio;
			
		}
		if ($promedio1 > 0)
		{
			$promedio_general1 = $promedio_general1 + $promedio1;
			$cont_prom_general1 = $cont_prom_general1 + 1;
			$notas_arr1[$i][$cont] = $promedio1;
		}
		
		
		
    ?>	
<!--    <td align="center"><font size="0" face="verdana,arial, geneva, helvetica"><? //if ($cont_prom>0 ) echo $promedio; else echo "&nbsp;"?></font></td>	-->

    <td align="center">
	<? $colorN =($promedio<40 && $promedio>0 && $cont_prom>0   )?"ff0000":"000000" ?>
	<font size="0" face="verdana,arial, geneva, helvetica" color="#<?=$colorN?>">
	<? if ($cont_prom>0 ) echo $promedio; else echo "&nbsp;"?>
	<?
	if($promedio>0){
						//echo "++";
						//echo $promedio;
						$arrpc[$id_ramo][]=$promedio;
						if($bool_pgeneral==1){
						$_PROMEDIO=$promedio+$_PROMEDIO;
						$_CONTEO=$_CONTEO+1;
						//echo $promedio;
						}
	}
	?>
	</font>
	
	</td>
    <?
	}if($sumapromedios==1){
	?>
	 <td><div align="center"><font size="0" face="arial, geneva, helvetica">
<?
		if(isset($_PROMEDIO)){
			 echo $_PROMEDIO;
			 unset($_PROMEDIO);
		}
		if(isset($_CONTEO)){
			 echo $_CONTEO;
			 unset($_CONTEO);
		}
	?>
	</font></div></td>
	<?
	 
	}
	 if($sumapromedios==1){
	?>
	 <td><div align="center"><font size="0" face="arial, geneva, helvetica">
<?
		if(isset($_PROMEDIO)){
			 echo $_PROMEDIO;
			 unset($_PROMEDIO);
		}
		if(isset($_CONTEO)){
			 echo $_CONTEO;
			 unset($_CONTEO);
		}
	?>
	</font></div></td>
	<?
	}
	
	if ($promedio_general>0){
			
		$ob_reporte ->nro_ano 	= $ano_escolar;
		$ob_reporte->periodos=$periodo;
		$ob_reporte->alumno=$rut_alumno;
		if($tipo_examen==0){
		$ob_reporte ->PromedioAlumno($conn);
		}
		else{
		$ob_reporte ->PromedioPerEXMNAVG($conn);
		}
		$prome_abajo =0;
		//$_PROMEDIO=0;
		//$_CONTEO=0;
		//echo "<br>".$ob_reporte->sql;
		
		if(!isset($aprpg)){
			
			//$prome_abajo = @intval($ob_reporte->suma / $ob_reporte->contador);
			$prome_abajo =  @intval($_PROMEDIO/$_CONTEO);
			//$prome_abajo = intval($prome_semestral / $cuenta_semestral);
			@$prome_abajo_ap = intval($ob_reporte->sumaAP / $cuenta_semestral_ap);
			$prome_apreciacion = intval($ob_reporte->sumaAP / $ob_reporte->contador);
		}else{
			//$prome_abajo = @round($ob_reporte->suma / $ob_reporte->contador,0);
			$prome_abajo =  @round($_PROMEDIO/$_CONTEO,0);
			//$prome_abajo = round($prome_semestral / $cuenta_semestral);
			$prome_abajo_ap = @round($ob_reporte->sumaAP / $cuenta_semestral_ap);
			$prome_apreciacion = round($ob_reporte->sumaAP / $ob_reporte->contador);
		}
		
		/*if($_PERFIL==0) {
			echo $nombre_alu;
			echo "---".$_PROMEDIO;
			echo "--".$_CONTEO;
			echo "<br>";
			//echo "-->".$prome_abajo;
			}*/
		
		
			
		if($truncado_per==1){
			//ojoooo
			$promedio_general= round($promedio_general/$cont_prom_general,0);
		}else{
			$promedio_general= substr($promedio_general/$cont_prom_general,0,2);
		}	
		//$promedio_general= round($promedio_general/$cont_prom_general,0);
	}else
		$promedio_general= "&nbsp;";
	if ($promedio_general1>0)
		if($truncado_per==1){
			$promedio_general1= round($promedio_general1/$cont_prom_general1,0);
		}else{
			$promedio_general1= substr($promedio_general1/$cont_prom_general1,0,2);
		}	 
		//$promedio_general1= round($promedio_general1/$cont_prom_general1,0);
	else
		$promedio_general1= "&nbsp;";
		
	?>
    <td><div align="center"><font size="0" face="arial, geneva, helvetica"><? 
	
	if($ck_opcion==1){
		echo ($prome_abajo>0)?$prome_abajo:""; 
	}else{
		echo ($prome_apreciacion>0)?$prome_apreciacion:""; ; 
	}
	
	if ($promedio_general>0) 
	{
		$cadena01 = $cadena01 . ";" . $promedio_general;
		$prom_prom = $prom_prom + $promedio_general;
		$cont_cont = $cont_cont + 1;
		$prom_perfinal[]=$promedio_general;
	}
	?>
      </font></div></td>
    <?php 
	
	if($periodo != $pperiodo){
		for($p=0;$p<pg_numrows($result_aperiodo);$p++){
			$fpant=pg_fetch_array($result_aperiodo,$p);
			
			
		?>
	<td><div align="center"><font size="0" face="arial, geneva, helvetica"><?php 
	if($ck_opcion==1){
			 $sql_palu = "select avg(CAST(nt.promedio as integer))
from notas$ano_escolar nt 
inner join ramo on ramo.id_ramo = nt.id_ramo
where rut_alumno=".$rut_alumno."  
and id_periodo=".$fpant['id_periodo']." 
and nt.promedio not in ('MB','B','S','I','0',' ','G','RV','N')
and ramo.modo_eval = 1 and ramo.bool_pgeneral = 1
and ramo.id_ramo in(select id_ramo from tiene$ano_escolar where rut_alumno=$rut_alumno)
";
			}
			else{
			 	 $sql_palu = "select avg(CAST(notaap as integer))
from notas$ano_escolar nt
inner join ramo on ramo.id_ramo = nt.id_ramo
 where rut_alumno=".$rut_alumno."   
and id_periodo=".$fpant['id_periodo']." 
and nt.promedio not in ('MB','B','S','I','0',' ','G','RV','N')
and ramo.modo_eval = 1 and ramo.bool_pgeneral = 1
and ramo.id_ramo in(select id_ramo from tiene$ano_escolar where rut_alumno=$rut_alumno)
";
			}
			
			//if($_PERFIL==0){echo $sql_palu;}
			
			//notas apreciacion
			
			
			$rs_n = pg_exec($conn,$sql_palu);
			$nper =(isset($aprpg))?round(pg_result($rs_n,0)):intval(pg_result($rs_n,0));
			
			if($nper>0)
			{
				$arr_np[$fpant['id_periodo']][]=$nper;
			}
			
			echo ($nper>0)?$nper:"";
			?></font></div></td>
    <?php } }?>
    <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong><?php 
	
	//$fmat= $fila_alu['fmat'];
	
			$ob_reporte ->alumno =$rut_alumno;//$ob_reporte->alumno;
			$ob_reporte ->cmb_curso = $curso;
			$ob_reporte ->ano = $ano;
			
	 if($fmat <= $periodo_finicio)
	 { 
	 // 	 $dias_habiles;
	
	 $ob_reporte->fecha_ini = $periodo_finicio;
	 $ob_reporte->fecha_inicio = $periodo_finicio;
	 $DiasHabiles = $dias_habiles;

	 }
	 else{//echo $dias_habiles-dif($periodo_finicio,$fmat);
	  $ob_reporte->fecha_ini = $fmat;
	   $ob_reporte->fecha_inicio = $fmat;
	 
		 $dh=getDiasHabiles($fmat, $periodo_ftermino);
		 $DiasHabiles = $dh;
	 
	 }
	 
	  $ob_reporte->fecha = $periodo_ftermino;
	  $ob_reporte->fecha_termino = $periodo_ftermino;
	  
	 $result_asis = $ob_reporte ->Asistencia($conn);
	 $cuenta_inasis = @pg_numrows($result_asis);
	 $rs_feriado=$ob_reporte->DiaHabil($conn);
	 $feriado = pg_result($rs_feriado,0);
	 
	$DiasAsistencia = $DiasHabiles - $cuenta_inasis - $feriado;
	if($_PERFIL==0){
		
		//echo "HABILES-->".$DiasHabiles."--INASIS-->".$cuenta_inasis."--FERIADO-->".$feriado."---".$DiasAsistencia."---"; 
	}
	 if($DiasHabiles==0)
	{echo "";
	//$PorcAsis=0;
	}
	else{
		$nalus++;
	 if($DiasAsistencia!=0){
				$PorcAsis = substr(100-((($cuenta_inasis *100)/$DiasHabiles)),0,5);
				if($PorcAsis<0){
					$PorcAsis =$PorcAsis*-1;
				}
			}else{
				$PorcAsis = "100";
			}
	 
	  echo $PorcAsis;
	  $sum_pasis = $sum_pasis+$PorcAsis;
	  ?>%
      <?php }?>
      </strong></font></td>
		
      </tr>
      <?
		} 
	?>	
    
  <tr>
    <td>&nbsp;</td>
    <td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Nota Menor</strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		sort($indice);
		?>
<!--		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? //if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>	-->
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? 
				if($indice[0]<40 && $indice[0]>0) { ?><font color="#FF0000"><?
					echo $indice[0]; ?></font><? 
				}
				else if($indice[0]==''){ 
					echo "&nbsp;"; 
				}
				else{
					echo $indice[0]; 				
				}?></strong></font></td>
    <? }
	$indice = explode(";",$cadena01);
	sort($indice);
	 if($sumapromedios==1){?>
    <td>&nbsp;</td><? }?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[1]>0) echo $indice[1]; else echo "&nbsp;"; ?></strong></font></td>
    <?php if($periodo != $pperiodo){
		for($p=0;$p<=pg_numrows($result_aperiodo);$p++){
				$fpant=pg_fetch_array($result_aperiodo,$p);
		?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<!-- nota menor -->
	<?
	sort($arr_np[$fpant['id_periodo']]);
	
		$min = min($arr_np[$fpant['id_periodo']]);
		echo $min;
			
	?></strong></font></td>
   <?php }}?>
   <?php  if($periodo == $pperiodo){?>
     <td>&nbsp;</td>
     <?php }?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Nota Mayor </strong></font></td>
	<? 	
	$cadena = "0";
	$indice = "0";
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		rsort($indice);
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
    <? }
	$indice = explode(";",$cadena01);
	rsort($indice);
	 if($sumapromedios==1){?>
    <td>&nbsp;</td><? }?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?><strong></font></td>
    <?php if($periodo != $pperiodo){
		for($p=0;$p<pg_numrows($result_aperiodo);$p++){
				$fpant=pg_fetch_array($result_aperiodo,$p);
		?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<!-- promedio final mayor -->
	<?
	/*rsort($prom_final_menor);
	if($prom_final_menor[0]==''){
	    echo $prom_final_menor[1];
	}else{
	    echo $prom_final_menor[0];
	}*/
	$max = max($arr_np[$fpant['id_periodo']]);
		echo $max;
	?></strong></font></td>
    <?php }}?>
     <td align="center" >&nbsp;</td>
  </tr>
  <?php if($media==1){?>
  <tr>
    <td>&nbsp;</td>
    <td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Nota Media </strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		$prom_resu = 0;
		$cont_resu = 0;		
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
				$prom_resu = $prom_resu + $notas_arr[$i][$cont];
				$cont_resu = $cont_resu + 1;
			}
		}
		if ($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></strong></font></td>
    <? }?>

	<?
		$prom_resu = 0;
		$cont_resu = 0;
		$indice = explode(";",$cadena01);
		for($cont=0 ; $cont < $numero_alumnos; $cont++)
		{
			if ($indice[$cont]>0)
			{
				$prom_resu = $prom_resu + $indice[$cont];
				$cont_resu = $cont_resu + 1;
			}

		}
		 if($sumapromedios==1){?>
    <td>&nbsp;</td><? }
		if($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
	?>
    
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?><strong></font></td>
		  <?php if($periodo != $pperiodo){
			  for($p=0;$p<pg_numrows($result_aperiodo);$p++){
				$fpant=pg_fetch_array($result_aperiodo,$p);
			  ?>
          <td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<!-- promedio final medio -->
		<?
		/*@$prom_final_medio = round($prom_prom1 / $cont_cont1);
		echo $prom_final_medio;*/
		 $pos_media = intval(count($arr_np[$fpant['id_periodo']])/2);
		//var_dump($arr_np[$fpant['id_periodo']]);
		echo $arr_np[$fpant['id_periodo']][$pos_media];
		?></strong></font></td>
       <?php }}?>
         <td align="center" >&nbsp;</td>
          
  </tr>
  <?php }?>
  <tr>
    <td>&nbsp;</td>
	<td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Promedio del Curso</strong></font> </td>
	<?
	for($contxx=0 ; $contxx < $num_subsectores; $contxx++){
		$fila_sub = @pg_fetch_array($result_sub,$contxx);	
		$id_ramo = $fila_sub['id_ramo'];
	
	    // consulta para sacar el numero de p`romedios a promediar
	    $sql_prom_cu = "select count(promedio) as cantidad from notas$ano_escolar where id_ramo = '$id_ramo' and id_periodo = '$periodo' and promedio > '0' and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and rut_alumno in (select rut_alumno from tiene$ano_escolar where id_ramo = '$id_ramo')";
	    @$res_prom_cu = pg_Exec($conn,$sql_prom_cu);
	    @$fil_prom_cu = pg_fetch_array($res_prom_cu);
	    $cantidad_notas = $fil_prom_cu['cantidad'];
		
		/// consulta para sacar la sumatoria de los promedios
		$sql_sum_cu = "select promedio from notas$ano_escolar where id_ramo = '$id_ramo' and id_periodo = '$periodo' and promedio > '0' and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and rut_alumno in (select rut_alumno from tiene$ano_escolar where id_ramo = '$id_ramo')";
	    @$res_sum_cu = pg_Exec($conn,$sql_sum_cu);
	    @$num_sum_cu = pg_numrows($res_sum_cu);
		$sum_promedios=0;
		
		for ($xx=0; $xx < $num_sum_cu; $xx++){
	        $fil_sum_cu = pg_fetch_array($res_sum_cu,$xx);
			$promedio_cu = $fil_sum_cu['promedio'];
			$sum_promedios=$sum_promedios+$promedio_cu;
		}		
		if($chkAPROXCURSO==1){
			//$promedio_curso_actual = @round($sum_promedios/$cantidad_notas);
			$promedio_curso_actual=@round(array_sum($arrpc[$id_ramo])/count($arrpc[$id_ramo]));
		}else{
			//$promedio_curso_actual = @intval($sum_promedios/$cantidad_notas);
			$promedio_curso_actual=@intval(array_sum($arrpc[$id_ramo])/count($arrpc[$id_ramo]));
		}
				
	    ?>	
        <td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		 <?
		 if ($promedio_curso_actual>0){
		      echo $promedio_curso_actual;
			  $prom_final_curso=$prom_final_curso+$promedio_curso_actual;
			  $contador_final++;
		 }else{
		      echo "&nbsp; ";
		 }
		 ?>
        
         </strong></font></td><?		
		
	}
	 if($sumapromedios==1){?>
    <td>&nbsp;</td><? }?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<?
	//$prom_final_final = @round($prom_final_curso/$contador_final);
	$prom_final_final = @round(array_sum($prom_perfinal)/count($prom_perfinal));
	
	echo $prom_final_final;
	//if($_PERFIL==0){show($prom_perfinal);}
	?></strong></font></td>
    <?php if($periodo != $pperiodo){
		//--
		for($p=0;$p<pg_numrows($result_aperiodo);$p++){
				$fpant=pg_fetch_array($result_aperiodo,$p);
		?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<!-- promedio final medio -->
		<?
		/*foreach($arr_np[$fpant['id_periodo']] as $pp => $vv){
		$sum_final_medio = $sum_final_medio+$vv;
		
		}*/
		 $sum_final_medio=array_sum($arr_np[$fpant['id_periodo']]); 
		@$prom_final_medio = round($sum_final_medio / count($arr_np[$fpant['id_periodo']]));
		//echo $prom_final_medio;
		echo $prom_final_medio;
		
		?>
		</strong></font></td>
        <?php }}?>
         <td align="center" >
        <?php  //if($_PERFIL==0){echo $sum_pasis."--".$nalus;}?>
         <font size="1" face="verdana,arial, geneva, helvetica"><strong><?php echo round($sum_pasis/$nalus,2); ?></strong></font></td>   
  </tr>  
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
		 $ruta_timbre =6;
		 $ruta_firma =4;
		
		 include("../../firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>
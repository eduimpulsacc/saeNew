<?php 

require('../../../../../util/header.inc');
include('../../../../clases/class_MotorBusqueda.php');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_Reporte.php');
	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $cmb_curso;
	$alumno		= $cmb_alumno;
	$institucion= $_INSTIT;
	$periodo	= $periodo;
	$reporte	= $c_reporte;
	$contador_salto=0;
	 $tipop = $tipo_planilla;
	 $fecha = $txtFECHA;

	/*if($PERFIL==0){
		error_reporting(E_ALL);
		ini_set('display_errors', '1'); 
	}*/

	//$fecha = strftime("%d %m %Y");
	
	
	if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){
$fecha_actual = date('d/m/Y-H:i:s');	 
/*header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Certificado_alumno_regular_$fecha_actual.xls"); 	 */

header('Content-type: application/vnd.ms-word'); 
 header("Content-Disposition: attachment; filename=Informe_educacional_personalidad_$fecha_actual.doc");
 header("Pragma: no-cache");
 header("Expires: 0");	 
}	 
	
	
	
	$_POSP = 5;
	$_bot = 8;
	if ($cmb_ano){
		$ano=$cmb_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
		
	if ($cmb_curso){
		$curso=$cmb_curso;
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		}
	}
	
	//if ($cb_ok){
		$ob_membrete = new Membrete();
		$ob_membrete->institucion = $institucion;
		$rs_instit = $ob_membrete->institucion($conn);
		
		$ob_membrete->ano = $ano;
		$rs_ano = $ob_membrete->AnoEscolar($conn);
		
		$ob_membrete->periodo = $periodo;
		$rs_periodo = $ob_membrete->periodo($conn);
		
		
		
		
		
		$ob_membrete->curso = $curso;
		$rs_curso = $ob_membrete->curso($conn);
	
		
			$Curso_pal = CursoPalabra($curso,1, $conn);
		
		
		
		if($ob_membrete->grado_curso==1) $gr="pa";
		if($ob_membrete->grado_curso==2) $gr="sa";
		if($ob_membrete->grado_curso==3) $gr="ta";
		if($ob_membrete->grado_curso==4) $gr="cu";
		if($ob_membrete->grado_curso==5) $gr="qu";
		if($ob_membrete->grado_curso==6) $gr="sx";
		if($ob_membrete->grado_curso==7) $gr="sp";
		if($ob_membrete->grado_curso==8) $gr="oc";
		if($ob_membrete->grado_curso==9) $gr="nv";
		if($ob_membrete->grado_curso==10) $gr="dc";
		if($ob_membrete->grado_curso==11) $gr="un";
		if($ob_membrete->grado_curso==12) $gr="duo";
		if($ob_membrete->grado_curso==13) $gr="tre";
		if($ob_membrete->grado_curso==14) $gr="cat";
		if($ob_membrete->grado_curso==15) $gr="quince";
		if($ob_membrete->grado_curso==16) $gr="diezseis";
		
		$ob_reporte = new Reporte();
		$ob_reporte->ensenanza = $ob_membrete->cod_ensenanza;
		$ob_reporte->institucion=$institucion;
		$ob_reporte->grado = @$gr;
		$ob_reporte->tipop = @$tipop;
		$resultPlantilla = $ob_reporte->InformePlantilla($conn);
		$filaPlantilla=@pg_fetch_array($resultPlantilla);
		$plantilla=$filaPlantilla[id_plantilla];
		$nuevo_sis=$filaPlantilla[nuevo_sis];
		
//if($_PERFIL==0){		
 $cabe = ($plantilla == 1555 && $_ID_BASE==4)?0:1;
//}
		/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
		
		
		$ob_reporte->periodo = $periodo;
		$ob_reporte->Periodo($conn);
		$dias_habiles = $ob_reporte->dias_habiles;
		$fecha_inicio = $ob_reporte->fecha_inicio;
		$fecha_termino = $ob_reporte->fecha_termino;
	    $fecha_fin = $ob_reporte->fecha_termino;
		$nom_periodo = $ob_reporte->nombre_periodo;
		/*if($_PERFIL==0){
			echo "fecha inicio -->".$fecha_inicio;
			echo "<br> fecha termino-->".$fecha_termino;
			exit;	
		}*/
	//}
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	

// ULTIMO PERIODO PARA HACER COMPARACIONES		
	//---------------------------------
		$ob_reporte->ano = $ano;
		$rs_ultimo= $ob_reporte ->ultimoPeriodo($conn); 
		$id_ulperiodo=pg_result($rs_ultimo,4);
		$fecha_termino_ulperiodo = pg_result($rs_ultimo,1);
	//---------------------------------


		$finicio_curso = $ob_membrete->finicio_curso;
		 $ftermino_curso = $ob_membrete->ftermino_curso;

if($id_ulperiodo==$periodo){
		if($ftermino_curso!=''){
			$fechafin = $ftermino_curso;
		}else{
			$fechafin = $fecha_fin;
		}
		
	
	}else{
	$fechafin = $fecha_fin;
	}
	
//echo "..".$fechafin;


//dias habiles
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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
<!--
function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.action = 'rpt19.php?institucion=$institucion';
		form.submit(true);

		}	
	}
//-->
function guardaImp(alu){
	var ano =<?php echo $cmb_ano ?>;
	var curso =<?php echo $cmb_curso ?>;
	var alumno =alu;
	var reporte =<?php echo $c_reporte ?>;
	var parametros ="ano="+ano+"&curso="+curso+"&alumno="+alumno+"&reporte="+reporte;
	var cuenta=0;
	var cad_cuenta="";
	for(i=0;i<cuenta;i++){
		cad_cuenta = cad_cuenta+"../";
	}
	
	$.ajax({
		url:cad_cuenta+'cuentaRepo/cuentaRepo.php',
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
		}
	})
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

/*function exportar(){
			window.location='printInformePersonalidadPeriodo_C.php?periodo=<?=$periodo;?>&ano=<?=$ano?>&curso=<?=$cmb_curso?>&c_alumno=<?=$cmb_alumno?>&xls=1';
			return false;
		  }
		  */
		 


//-->
</script>
</head>
 <STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
	/* page-break-before: always;*/
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
 .c {
	font-style: italic;
}
 .c {
	font-style: italic;
}
 .c {
	font-style: italic;
}
 </style><!---->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();"> 
<!-- <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">-->
	<!--<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" height="722" align="left" valign="top" bgcolor="f7f7f7"> 
              -->
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		 <!-- <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
              
              <tr align="left" valign="top"> 
                <td height="1038">-->
					<!--<table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                     
                      <td width="73%" align="left" valign="top">-->
                   
					  <table align="center">

<? //if ($cb_ok){?>
	<tr>
		<td>
		
		</td>
	</tr>  
<? //}?>					
<? //if ($cb_ok){
 	if ($c_alumno==0){
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$result_alu= $ob_reporte->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$alumno;
		$result_alu =$ob_reporte->TraeUnAlumno($conn);
	}
	$cont_alumnos = pg_numrows($result_alu);

	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
	{
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$ob_reporte->CambiaDato($fila_alu);
		$alumno = $ob_reporte->alumno;
		$titulo2 = $filaPlantilla['titulo_informe2'];
		?>
	<script>
	guardaImp(<?php echo $alumno ?>);
	</script>
    <?
		
		//%asistencia
		
		
		if($ob_reporte->fecha_matricula > $fecha_inicio){
		 $fecha_ini = $ob_reporte->fecha_matricula;
		
		}
		else{
		 $fecha_ini = $fecha_inicio;
		}
		
		if($ob_reporte->fecha_retiro == null ){
			$fecha_fin = $fecha_termino;
		}
		else
		{
			$fecha_fin = $ob_reporte->fecha_retiro;
		
		}
		
		
		/*
		 if($diash < $dias_habiles){
			$dias_habiles = getDiasHabiles($fecha_ini,$fecha_fin);
			}else{
				$dias_habiles = $dias_habiles;
				}
		
		
			$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
			$result13 =@pg_Exec($conn,$sql13);
			$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
				$result13 =@pg_Exec($conn,$sql13);
				if($_PERFIL==0){
					//echo "consutla-->".$sql13;
				}
			    if (!$result13) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result13)!=0)
				    {
				  	  $fila13 = @pg_fetch_array($result13,0);	
				  	  if (!$fila13)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				$inasistencia = $fila13['cantidad'];
				 $dias_asistidos = $dias_habiles - $fila13['cantidad'];
				
				if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,1);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}*/
			
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	$ob_reporte ->fecha_termino = $fecha_fin;
	$result13 = $ob_reporte ->Asistencia($conn);
	if (!$result13){
		  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
	}else{
		if (pg_numrows($result13)!=0){
		  $fila13 = @pg_fetch_array($result13,0);	
		  if (!$fila13){
			  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			  exit();
		  }
		}
	}
	$sql = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano." and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."') AND id_curso =".$curso." ORDER BY fecha ASC";
	$rs_justifica = @pg_exec($conn,$sql);
	//if($Just_Asis==1){
	$justifica = @pg_numrows($rs_justifica);
	//}else{
	//	$justifica=0;
	//}
	$cantidad = @pg_numrows($result13);
	if($Just_Asis==1){
	$inasistencia = @pg_numrows($result13) - $justifica;
	}else{
	$inasistencia=	@pg_numrows($result13);
	}
	//echo $inasistencia;
	 $dias_asistidos = $dias_habiles - ($cantidad - $justifica);

?>

<tr><td valign="top">
 <?php  //if($_PERFIL==0){
                     if($ob_membrete->cod_ensenanza==10 && $chk_portada==1){
						// echo "aca";
						 include('../informePersonalidad/portadaParvularia.php');
						 ?><br>
<br>
<br>
<br>

                         <H1 class="SaltoDePagina"></H1>
                         <?
                     }
                    //  }
					?>

<?php if($cabe==1 ){
								?>
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
				<table width="190" height="120" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td align="center" height="120"><?
						if($institucion!=""){
							if($institucion==26094 && $ob_membrete->cod_ensenanza==10){
								echo "<img src='".$d."tmp/".$institucion."Kinder.jpg". "' >";
							}else{ 
							   echo "<img src='".$d."tmp/".$institucion."insignia". "'>";
							}
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?>
						</td>
					  </tr>
					
					<tr>
					   <td>
					   <? if($institucion!=24977){?>
						   <table align="center">
							  	<tr><td class="subitem"><?=$ob_membrete->direccion;?></td></tr>
								<tr><td class="subitem">Fono: <?=$ob_membrete->telefono;?></td></tr>
                                <tr><td class="subitem">Fax: <?=$ob_membrete->fax;?></td></tr>
						   </table>
						   <span class="subitem"><?php //echo $Curso_pal; ?></span>
						   <? } ?>
						</td>
					</tr>
				</table>
			
		</td>
		<td valign="top">
		<td><img src='../linea_v.jpg'></td>
		<td valign="top">
			<table width="440" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
				  <td colspan="3" class="titulo" align="center"><strong><? echo $titulo2;?> 
			     
			  </strong></td></tr>
				<tr><td colspan="3"><hr color="#660000"></td></tr>
				<tr>
					<td class="subitem">&nbsp;A&ntilde;o Escolar</td>
                    
					<td class="subitem"><? if ($_INSTIT=="4772" or $_INSTIT=="5265"){ ?> Informe <? }else{ ?><? echo Periodo?><? } ?></td>	
					<td class="subitem">RBD</td>										
				</tr>
				<tr>
					<td class="subitem">&nbsp;<?=$ob_membrete->nro_ano;?></td>
					<td class="subitem"><? if ($_INSTIT=="4772" || ($_INSTIT==1436 && $ob_membrete->cod_ensenanza>10) || $_INSTIT==1339){ ?>Anual <? }else{ ?><?=$ob_membrete->nombre_periodo;?><? } ?></td>
					<td class="subitem"><?php echo $institucion."-".$ob_membrete->dig_rdb;?></td>										
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td class= "subitem" >Nombre Alumno(a)</td>
					<?php if($chk_rut==1){?>
                    <td class= "subitem" >Rut Alumno</td>
                    <?php }?>
                    <?php if($chk_edad==1){?>
					<td class= "subitem" >Edad</td>
                    <?php }?>
				</tr>												
				<tr>
					<td class="subitem">&nbsp;<b><?php echo strtoupper($ob_reporte->tildeM($ob_reporte->nombres));?></b></td>
					<?php if($chk_rut==1){?>
                    <td class= "subitem" ><?php echo $ob_reporte->rut_alumno ?></td>
                    <?php }?>
                    <?php if($chk_edad==1){?>
					<td class= "subitem" ><b><?php echo edad($ob_reporte->fecha_nacimiento)  ?> a&ntilde;os </b></td>
                    <?php }?>
				</tr>
				<tr>
				  <td class="subitem">&nbsp;</td>
				  <td class= "subitem" >&nbsp;</td>
				  <td class= "subitem" >&nbsp;</td>
			  </tr>
				
				<tr>
					<td class="subitem" colspan="3">Curso</td>
				</tr>												
				<tr>
					<td class="subitem" colspan="3"><b><?php echo $Curso_pal; ?></b></td>										
				</tr>
				<tr>
				  <td class="subitem" colspan="3">&nbsp;</td>
			  </tr>
				<?php if($chk_pasis==1){?>
               
				<tr>
				  <td class="subitem" colspan="3">Asistencia: <? 
				if ($dias_habiles>0){
					$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
					$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
					$prom_cont_asis = $prom_cont_asis + 1;
				}
				echo $promedio_asistencia . "%" ;
		  ?> </td>
			  </tr>	
              <?php }?>															
			</table>
            <?php }?>
		</td>		
	</tr>
	<tr>
		<td colspan="4"><br>

	<? if($ckEVALUACION==1 and $ckPOSICION==1){
		
		$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']." AND tipo_eval is null ORDER BY orden ASC";
				$resultConc=@pg_Exec($conn, $sqlConc);?>
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				<tr>
					<td colspan="<?php echo @pg_numrows($resultConc)*3 ?>" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
				</tr>
				<tr>
			<? 	
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					 if($countConc==5){?>
						 </tr>
                         <tr>			 
						
					<? } ?>
					<td class="subitem"><? echo $filaConc['sigla'];?>:</td>
					<td align="left" class="subitem"><? echo $filaConc['nombre'];?></td>
					<td></td>
			<?	}	?>
				</tr>
			</table>
	<? } ?>
		</td>
	</tr>
<!--	<tr>
		<td colspan="4"></td>
	</tr>-->
	<tr>
		<td colspan="4">
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
<!-- desde aki -->

&nbsp;
<?
						$contador=0;
						$ob_informe = new Reporte();
						$ob_informe->nuevo=1;
						$ob_informe->plantilla=$plantilla;
						$result_cat= $ob_informe->InformeAreas($conn);
						$num_cat=pg_numrows($result_cat);
						for ($i=0;$i<$num_cat;$i++){
							$row_cat=pg_fetch_array($result_cat);	?>
                            
                             <? 	$ob_informe->id_padre=$row_cat['id'];
							$ob_informe->nuevo=1;
							$result_sub=$ob_informe->InformeSubarea($conn);
							$num_sub=pg_numrows($result_sub);
							for ($j1=0;$j1<$num_sub;$j1++){
								$row_sub=pg_fetch_array($result_sub,$j1);
								$cuentaunos=0;
								
								
							}?>	

						<table width="630" align="center" border="1" cellpadding="0" cellspacing="0" >
                         <?php if ($row_cat['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                      <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
							<tr class="tabla04">
							  <td align="<?=$cbmAreaAlign;?>" class="titulo" colspan="3"> <? if($CHKAREAN==1){ echo "<strong>"; } if($CHKAREAC==1){ echo "<i>"; } ?><br>
						      <? if ($row_cat['salto_pagina']==1){
								//echo "<H1 class=SaltoDePagina></H1>";  
								} 
							  
							  echo $row_cat['glosa'];?><? if($CHKAREAN==1){ echo "</strong>"; } if($CHKAREAC==1){ echo "</i>"; } ?></td>
							  </tr>
                             <? 	$ob_informe->id_padre=$row_cat['id'];
							$ob_informe->nuevo=1;
							$result_sub=$ob_informe->InformeSubarea($conn);
							$num_sub=pg_numrows($result_sub);
							for ($j=0;$j<$num_sub;$j++){
								$row_sub=pg_fetch_array($result_sub,$j);
								$cuentaunos=0;
								
								
								
								?>	
                                <?php if ($row_sub['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                      <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
                                <?php if ($row_item['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                                  <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
							<tr class="tabla04">
							<td  valign="top" align="<?=$cbmSubAreaAlign;?>" class="subitem">
									<?php ?>
									<? if($CHKSUBN==1){ echo "<strong>"; }  if($CHKSUBC==1){ echo "<i>"; } ?><img src="../../../../cortes/p.gif" width="10" height="1" border="0">
										<? echo $row_sub['glosa'];?><? if($CHKSUBN==1){ echo "</strong>"; }  if($CHKSUBC==1){ echo "</i>"; } ?>
									          <span class="subitem">
									</span></td>
									<td width="50" align="center"><span class="subitem">		  
										Logro
									    </span></td>
							  <td width="50" align="center">%</td>
							  </tr>
							<?	
									// orden de los elementos
									
									if ($plantilla==1322 || $plantilla==1104 || $plantilla==1101  ){
									    $orden_elementos = " order by id";
									}else{
									    $orden_elementos = " ";									
									}
									
									if(($plantilla==1693) && ($row_sub['id']==90741 || $row_sub['id']==90864 || $row_sub['id']==90835)){
										$ors = "orden";
									}else{
										$ors = "id";
									}
									
									
									
									   $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] ORDER BY $ors  ";
										$result_item=pg_exec($conn,$query_item);
										$num_item=pg_numrows($result_item);
										//$contador_salto=0;
										for ($z=0;$z<$num_item;$z++){
											$row_item=pg_fetch_array($result_item,$z);
										//	$cuentaunos=$cuentaunos+1;
											//echo $z;
												?>
                                            
                                            
                                            
                                              <?php if ($row_item['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                                  <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
											<tr>
											  <td width="530"  class="subitem"><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?>
                                              </td>
												<td width="50" align="center" nowrap class="subitem">
												<?	
												
												$ob_informe->ano=$ano;
													$ob_informe->nuevo=1;
													$ob_informe->periodo=$periodo;
													$ob_informe->plantilla=$plantilla;
													$ob_informe->id_item=$row_item[id];
													$ob_informe->alumno=$alumno;
													$result_respuesta=$ob_informe->InformeConcepto($conn);
													$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															if ($row_respuesta[concepto]==1){
																$ob_informe->respuesta=$row_respuesta[respuesta];
																$result_con= $ob_informe->InformeEvaluacion($conn);
																$num_con=pg_numrows($result_con);
																if ($num_con>0){
																	$row_con=pg_fetch_array($result_con);
																 	if($ckCONCEPTO==1){
																	 	echo "&nbsp;".strtoupper($row_con[nombre]);
																	}else{
																		echo "&nbsp;".strtoupper($row_con[sigla]);
																	}
																}
															}else{
																echo "&nbsp;".strtoupper($row_respuesta[respuesta]);
																
															}
															
															//if($row_respuesta['respuesta']==1)$cuentaunos++;
															
														}	
														$contador_salto++;?>
											  </td>
                                             <?php  if($z==0){
												 $cuentaresp=0;	
									// orden de los elementos
									
									if ($plantilla==1322 || $plantilla==1104 || $plantilla==1101  ){
									    $orden_elementos = " order by id";
									}else{
									    $orden_elementos = " ";									
									}
									
									if(($plantilla==1693) && ($row_sub['id']==90741 || $row_sub['id']==90864 || $row_sub['id']==90835)){
										$ors = "orden";
									}else{
										$ors = "id";
									}
									
									
									
									 $query_itemc="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] ORDER BY $ors  ";
										$result_itemc=pg_exec($conn,$query_itemc);
										$num_itemc=pg_numrows($result_itemc);
										//$contador_salto=0;
										
										for ($zc=0;$zc<$num_itemc;$zc++){
											$row_itemc=pg_fetch_array($result_itemc,$zc);
											//echo $row_itemc['id']."<br>";
											
										 $sqlresp ="SELECT * FROM informe_evaluacion2 WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND  id_informe_area_item=".$row_itemc['id']." AND rut_alumno=".$alumno."";											
										$result_respuesta = pg_exec($conn,$sqlresp);
										
										 $num_respuesta=pg_numrows($result_respuesta);
													if ($num_respuesta>0){	
																									
														$row_respuesta=pg_fetch_array($result_respuesta,0);
														strtoupper($row_respuesta[respuesta]);
														if($row_respuesta['respuesta']!=""){
															$cuentaresp++;
														}
														
														if($row_respuesta['respuesta']==1)
														{$cuentaunos++;}
													}
													
										
										}
										$porc_final=round(($cuentaunos*100)/$cuentaresp,0);
										
										if($porc_final<49){
											$fondo="red";	
										}
										elseif($porc_final==50 || $porc_final<=79){
											$fondo="yellow";	
										}
										elseif($porc_final==80 || $porc_final<=100){
											$fondo="#2eea2e";	
										}
												?>
                                            

											 <td width="50" rowspan="<?php echo $num_item ?>" align="center" nowrap class="subitem" bgcolor="<?php echo $fondo ?>"><?php echo $porc_final; ?></td>	
                                              <?php }?> 
                                    </tr>
                          
<?												
											/*	maloooo todos reclaman, nadie sabe cuantas lineas tiene su informe, mala idea

												if(($contador_salto % $txtSALTO)==0){
												?></table><?
													echo "<H1 class=SaltoDePagina></H1>";
												?><table width="630" align="center" border="0" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
													<tr><td></td></tr><?	
												}
											*/
													}?>
                              <?php }?>
                        </table>
						<?	
						}
							?>

							
						<br>
                         <?	if ($ckDESTACA==1){  
										$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
										$ob_reporte ->periodo = $periodo;
										$ob_reporte ->ano =$_ANO;
										$ob_reporte ->alumno = $alumno;
										$resultObs= $ob_reporte ->InformeObservaciones($conn);
					
									 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										  $filaObs=@pg_fetch_array($resultObs, $countObs);
										  $sedestaca = $filaObs['sedestaca'];
									 }
							  ?>							
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td width="20%" class="tabla04"><span class="c"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Se destaca</b><b></b></font></span><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>
<? if($institucion!=14703){ ?> 
<span class="c">en:</span>
<? } ?></b></font></td>
										<td width="80%" class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<?=$sedestaca ?></font></td>
									 </tr>
								   </table>									
							  <? } 
							  
							  ?>  
								  <? if($ckOBS==1){?><br>

									<table width="100%" border="0" cellpadding="0" cellspacing="0">
									  <tr>
										<td><font size="1" face="Arial, Helvetica, sans-serif"><b>&nbsp; <span class="c">Observaciones</span>:</b></font></td>
									  </tr>
									</table>

									
									<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				            		<? 	$ob_informe->pantilla=$plantilla;
										$ob_informe->ano=$ano;
										$ob_informe->alumno=$alumno;
										$resultObs= $ob_informe->InformeObservaciones($conn);
									for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
										<tr>
											<td width="19%"><span class="Estilo2"><font size="1" face="Arial, Helvetica, sans-serif">
		                                         <? if ($_INSTIT=="4772" ){ ?>ANUAL <? }else{ ?><?	echo $filaObs['nombre_periodo']; ?><? } ?>
											</span></td>
											<td class="subitem">
											<?	echo $filaObs['observaciones'];	?></td>
										</tr>
									<?	} ?>
									</table>
									<? } //---------- FIN OBSERVACIONES ******************?>
<br>
			
									
<!-- hasta aki -->	<? /********************** ESCALA DE EVALUACION *******************/
										if($ckEVALUACION==1 and $ckPOSICION==0){?>
											<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
												<tr>
													<td colspan="4" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
												</tr>
												<tr>
											<? 	$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']." ORDER BY orden ASC";
												$resultConc=@pg_Exec($conn, $sqlConc);
												for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
													$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
													<td class="subitem"><? echo $filaConc['sigla'];?>:</td>
													<td align="left" class="subitem"><? echo $filaConc['nombre'];?></td>
													<td></td>
											<?	}	?>
												</tr>
											</table>
									<? } 
									/************************ FIN ESCALA DE EVALUACIO ******************/
									?>
                                     <?php  
									 for($b=0;$b<$txtFIRMA;$b++){
										echo "<br>"; 
									 }
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 include("firmas/firmas.php");?>				
				  </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td>
</tr>
	</table>
      <H1 class="SaltoDePagina"></H1>
<?		}	?>
<?	//}	?>

						
					
                        
					<!--  </td>
					  </tr>
				  </table>-->
			<!--	</td>
			  </tr>
			</table>-->
		 <!-- </td>
		</tr>
	  </table>-->
<!--	</td>
   </tr>
</table>-->

</body>
</html>

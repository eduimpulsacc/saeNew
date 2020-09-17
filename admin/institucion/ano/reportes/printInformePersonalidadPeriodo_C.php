<?php 

require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');
	$c_alumno	= $c_alumno;
	 $ano		= $_ANO;
	$curso		= $_POST['c_curso'];
	$alumno		= $c_alumno;
	$institucion= $_INSTIT;
	$periodo	= $c_periodos;
	$reporte	= $c_reporte;
	$contador_salto=0;
	 $tipop = $tipo_planilla;
	 $fecha = $txtFECHA;
	 
	

	if($PERFIL==0){
	//show($_POST);
	}

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
	if ($c_ano){
		$ano=$c_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
		
	if ($c_curso){
		$curso=$c_curso;
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
		
		
		
		
		
		$ob_membrete->curso = $c_curso;
		$rs_curso = $ob_membrete->curso($conn);
	
		if($institucion==1436 && $ob_membrete->cod_ensenanza==10){
			$Curso_pal = CursoPalabra($c_curso, 5, $conn);		
		}else{
			$Curso_pal = CursoPalabra($c_curso, 4, $conn);
		}
		
		
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
		if($ob_membrete->grado_curso==17) $gr="diecisiete";
		if($ob_membrete->grado_curso==18) $gr="dieciocho";
		if($ob_membrete->grado_curso==19) $gr="diecinueve";
		if($ob_membrete->grado_curso==20) $gr="veinte";
		if($ob_membrete->grado_curso==21) $gr="veintiuno";
		if($ob_membrete->grado_curso==22) $gr="veintidos";
		if($ob_membrete->grado_curso==23) $gr="veintitres";
		if($ob_membrete->grado_curso==24) $gr="veinticuatro";
		if($ob_membrete->grado_curso==25) $gr="veinticinco";
		if($ob_membrete->grado_curso==31) $gr="treintauno";
		if($ob_membrete->grado_curso==32) $gr="treintados";
		
		$ob_reporte = new Reporte();
		$ob_reporte->ensenanza = $ob_membrete->cod_ensenanza;
		$ob_reporte->institucion=$institucion;
		$ob_reporte->grado = @$gr;
		$ob_reporte->tipop = @$tipop;
		$resultPlantilla = $ob_reporte->InformePlantilla($conn);
		$filaPlantilla=@pg_fetch_array($resultPlantilla);
		$plantilla=$filaPlantilla[id_plantilla];
		$nuevo_sis=$filaPlantilla[nuevo_sis];
		
		$ob_reporte->numCorp($connection);
		$corp = $ob_reporte->num_corp;
		
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
<!--
function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.action = 'rpt19.php?institucion=$institucion';
		form.submit(true);

		}	
	}
//-->
function guardaImp(alu){
	var ano =<?php echo $c_ano ?>;
	var curso =<?php echo $c_curso ?>;
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
 </style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" <?php if($_PERFIL!=0){  ?>onLoad="window.print();"<?php }?>><!--"-->

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
						if($corp==14 || $corp==15 || $corp==16 || $corp==17 || $corp==18 || $corp==19 || $corp==20 || $corp==33 || $corp==34){
							
							 include('informePersonalidad/portadaADV.php');
							}
							else{
							
							 include('informePersonalidad/portadaParvularia.php');
							}
							/*if($_PERFIL==0){
								 include('informePersonalidad/portadaADV.php');
								}*/
						
						
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
                                <!--<tr><td class="subitem">Fax: <?=$ob_membrete->fax;?></td></tr>-->
						   </table>
						   <span class="subitem"><?php //echo $Curso_pal; ?></span>
						   <? } ?>
						</td>
					</tr>
				</table>
			
		</td>
		<td valign="top">
		<td><?php if($_INSTIT!=10235){?><img src='linea_v.jpg'><?php }?></td>
		<td valign="top">
			<table width="440" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
				  <td colspan="3" class="titulo" align="center"><strong><? echo $titulo2;?> 
			     
			  </strong></td></tr>
				<tr><td colspan="3"><?php if($_INSTIT!=10235){?><hr color="#660000"><?php }?></td></tr>
				<tr>
					<td class="subitem">&nbsp;A&ntilde;o Escolar</td>
                    
					<td class="subitem"><? if ($_INSTIT=="4772" or $_INSTIT=="5265"){ ?> Informe <? }else{ ?><? echo Periodo?><? } ?></td>	
					<td class="subitem">RBD</td>										
				</tr>
				<tr>
					<td class="subitem">&nbsp;<?=$ob_membrete->nro_ano;?></td>
					<td class="subitem"><? if ($_INSTIT=="4772"  || $_INSTIT==1339){ ?>Anual <? }else{ ?><?=$ob_membrete->nombre_periodo;?><? } ?></td>
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
            <? if(strlen($filaPlantilla['id_plantilla'])==0 && strlen($periodo)=="") { ?> 
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	   <tr>
		 <td><hr width="100%" color=#003b85><b>DATOS INCOMPLETOS, DEBE AVISAR AL ESTABLECIMIENTO.</b></td>
	   </tr>
	 </table>          
<?php 
exit;
} ?>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
	<? if($ckEVALUACION==1 and $ckPOSICION==1){?>
			<table width="630" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				<tr>
					<td colspan="10" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
				</tr>
				<tr>
			<? 	$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']."  ORDER BY orden ASC";
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					 if($countConc==5){?>
						 </tr>
                         <tr>			 
						
					<? } ?>
					<td class="subitem"><? echo $filaConc['sigla'];?>:</td>
					<td align="left" class="subitem"><? echo $filaConc['nombre'];?></td>
					
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
<?					if ($nuevo_sis==1){  ?>
&nbsp;
					<table width="630" align="center" border="0">
                    <tr><td valign="top">
					
						
						<?
						$contador=0;
						$ob_informe = new Reporte();
						$ob_informe->nuevo=1;
						$ob_informe->plantilla=$plantilla;
						$result_cat= $ob_informe->InformeAreas($conn);
						$num_cat=pg_numrows($result_cat);
						for ($i=0;$i<$num_cat;$i++){
							$row_cat=pg_fetch_array($result_cat);	?>
						<table width="630" align="center" border="0" cellpadding="0" cellspacing="0" >
                         <?php if ($row_cat['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                                  <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="0" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
							<tr class="tabla04">
							  <td width="630" colspan="<?php echo ($ckAUTO==1)?3:2; ?>" align="<?=$cbmAreaAlign;?>" class="titulo"> <? if($CHKAREAN==1){ echo "<strong>"; } if($CHKAREAC==1){ echo "<i>"; } ?><br>
						      <? if ($row_cat['salto_pagina']==1){
								//echo "<H1 class=SaltoDePagina></H1>";  
								} 
							  
							  echo $row_cat['glosa'];?><? if($CHKAREAN==1){ echo "</strong>"; } if($CHKAREAC==1){ echo "</i>"; } ?></td>
							</tr>
						</table>
						
						
						<table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">	
                        <? 	$ob_informe->id_padre=$row_cat[id];
							$ob_informe->nuevo=1;
							$result_sub=$ob_informe->InformeSubarea($conn);
							$num_sub=pg_numrows($result_sub);
							for ($j=0;$j<$num_sub;$j++){
								$row_sub=pg_fetch_array($result_sub);
								
								?>	
                                <?php if ($row_sub['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                                  <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
								<tr class="tabla04">
									<td colspan="<?php echo ($ckAUTO==1)?'':2; ?>" valign="top" align="<?=$cbmSubAreaAlign;?>" class="subitem">
									
									<? if($CHKSUBN==1){ echo "<strong>"; }  if($CHKSUBC==1){ echo "<i>"; } ?><img src="../../../../cortes/p.gif" width="10" height="1" border="0">
										<? echo $row_sub['glosa'];?><? if($CHKSUBN==1){ echo "</strong>"; }  if($CHKSUBC==1){ echo "</i>"; } ?>
									          <span class="subitem">
									</span></td>
                                
								  <td><span class="subitem">		  
										<?	$ob_informe->ano=$ano;
											$ob_informe->periodo=$periodo;
											$ob_informe->plantilla=$plantilla;
											$ob_informe->id_item=$row_sub[id];
											$ob_informe->alumno=$alumno;
											$result_respuesta=$ob_informe->InformeConcepto($conn);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo "&nbsp;".$row_con[sigla];
													}
												}else{
													echo "&nbsp;".$row_respuesta[respuesta];
												}
											}		?>
									    </span></td>
                                            <?php if($ckAUTO==1){?><td align="center">Autoev.</td><?php }?>
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
											$row_item=pg_fetch_array($result_item);	?>
                                              <?php if ($row_item['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
                                  <H1 class=SaltoDePagina></H1>
                                  <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
								
                                <?  
								} ?>
											<tr>
											  <td width="530" class="subitem"><img src="../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
												<td width="100" nowrap class="subitem">
												<?	$ob_informe->ano=$ano;
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
														}	
														$contador_salto++;?>
											  </td>
                                                  <?php if($ckAUTO==1){?>
                                                  <td nowrap class="subitem">
                                                  -<?
                                                  	$ob_informe->ano=$ano;
													$ob_informe->periodo=$periodo;
													$ob_informe->plantilla=$plantilla;
													$ob_informe->id_item=$row_item[id];
													$ob_informe->alumno=$alumno;
													$result_respuesta=$ob_informe->InformeConceptoAutoEvaluacion($conn);
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
														}	
														?>
                                                  </td><?php }?>
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
<? 											}?>
<? 										}	// fin if modificar?>

                        </table>					
							
								
									</td>
								</tr>
                                <? if($institucion==10026){?>
                                <TR>
                                <td>
                                <table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">	
                                <tr>
                                	<td width="550" class="subitem">&nbsp;LOGRO PROMEDIO</td>
                                    <td width="80" class="item">&nbsp;
                                    <? 
									$sql="select round(avg(cast(respuesta as integer))) FROM informe_evaluacion2 ie where id_plantilla=".$plantilla." and id_ano=".$ano." and id_periodo=".$periodo." and id_curso=".$curso." and rut_alumno=".$alumno." and respuesta<>''";
									$rs_promedio = pg_exec($conn,$sql);
									echo pg_result($rs_promedio,0)."%";
								   ?>                                   
                                    </td>
                                </tr>
                                </table>
                                </td>
                               </TR>
                           <? } ?>
								<tr>
									<td>
				<? 
				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']."  ORDER BY orden ASC";
				$resultConc=@pg_Exec($conn, $sqlConc);
				if(pg_numrows($resultConc)>0){
				?>	
                <? if($ckEVALUACION==1 and $ckPOSICION==0){?>
				<!--			  <table width="630" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				<tr>
					<td colspan="4" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
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
			</table>-->
            
            <?php }?>
			<? } ?>		
           
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
                                       <?php if($ckAUTO==1){?>
                                <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
					<?					 $sqlTraeObs="select * from informe_observaciones_autoevaluacion inner join periodo on informe_observaciones_autoevaluacion.id_periodo=periodo.id_periodo where informe_observaciones_autoevaluacion.id_periodo=".$periodo." and informe_observaciones_autoevaluacion.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones_autoevaluacion.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
											$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
											<tr>
												<td width="22%"><font size="1" face="Arial, Helvetica, sans-serif">
	                                             	Alumno se compromete a:
												</td>
												<td width="78%"><font size="1" face="Arial, Helvetica, sans-serif">
	<?												echo $filaObs['observaciones'];	?>&nbsp;</font>
												</td>
											</tr>
<?										}	?>
										</table>
                         
                                <?php }?>
									
									<? /********************** ESCALA DE EVALUACION *******************/
										if($ckEVALUACION==1 and $ckPOSICION==0){
											 	$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']."  ORDER BY orden ASC";
				$resultConc=@pg_Exec($conn, $sqlConc);
											?>
                                        <table width="630" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				<tr>
					<td colspan="10" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
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
					
			<?	}	?>
				</tr>
			</table>
											<!--<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
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
											</table>-->
                                            
									<? } 
									/************************ FIN ESCALA DE EVALUACIO ******************/
									?>
                                     <?php  
									 for($b=0;$b<$txtFIRMA;$b++){
										echo "<br>"; 
									 }
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
									</td>
								</tr>
								<tr>
									<td class="subitem"><? echo $ob_membrete->comuna.",".fecha_espanol($fecha);?></td>
								</tr>
					  </table>
                      <? if($institucion==5265 || $institucion==5661 || $institucion==6122 || $institucion==6835 || $institucion==7405 || $institucion==11678 || $institucion==19968 || $institucion==22019){ ?>
                      <table width="100%" border="0">
                          <tr>
                            <td class="item" align="center"><em>&nbsp;&ldquo;&Uacute;nicamente al esforzaros seriamente por tener &eacute;xito, lograr&eacute;is la verdadera felicidad. Son preciosas las oportunidades que se os ofrecen durante el tiempo que pas&aacute;is en la escuela. Haced tan perfecta como sea posible vuestra vida estudiantil. Recorrer&eacute;is ese camino una sola vez.Y de vosotros mismos depende que vuestra tarea sea un &eacute;xito o un fracaso. A medida que teng&aacute;is &eacute;xito en adquirir el conocimiento de la Biblia, estar&eacute;is acumulando tesoros para impartir.&rdquo; (Mensaje para los J&oacute;venes. Elena de White).</em></td>
                          </tr>
                        </table><H1 class=SaltoDePagina></H1>
                        <? } ?>

						
						
						<?	}
						 // fin if nuevo sistema	
							else{	?>
							<table width="630" border=0 cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td>
										<table width="630" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0">
							<?				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
							
											$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
												//trae areas
											$ob_reporte = new Reporte();
											$ob_reporte->nuevo=0;
											$ob_reporte->plantilla=$filaPlantilla['id_plantilla'];
											$resultTraeArea=$ob_reporte->InformeAreas($conn);
										
											for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
												$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
												$nroA=$countArea+1;		?>
												<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>
												<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong><? echo $nroA.".-  ".$filaTraeArea['nombre'];?></strong></font></td>
<?												if($countArea==0){	?>												
													<td><font size=1 face=Arial, Helvetica, sans-serif><strong>EVALUACI&Oacute;N</strong></font></td>												
					<?							}else{	?>
													<td>&nbsp;&nbsp;</td>
<?												}
												//trae subareas para cada area y las imprime
												$ob_reporte->id_area=$filaTraeArea['id_area'];
												$resultTraeSubarea=$ob_reporte->InformeSubarea($conn);

												for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
												$nroS=$countSubarea+1;
												$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	?>
												<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>
												<? echo $nroA.".".$nroS.".-  ".$filaTraeSubarea['nombre'];?></strong></font>
                                                </td></tr>
			<?									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
												$ob_reporte->id_subarea=$filaTraeSubarea['id_subarea'];
												$resultTraeItem=$ob_reporte->InformeItem($conn);
												
												for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
													$countI++;
													$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
													//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
													if($countItem%2==0){
														$color="#CDCDCD";
													}else{
														$color="#B5B5B5";
													}	?>
													<tr><td valign=bottom>
			<?										$nroI=$countItem+1;		?>
													<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;<? echo $nroA.".".$nroS.".".$nroI.".-  ".trim($filaTraeItem['glosa']);?></font>
													</td>
<?													if($filaTraeItem['tipo']==0){
														$sqlP="select * from periodo where id_periodo=".$periodo;
														$resultP=@pg_Exec($conn, $sqlP);
														for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
															$filaP=@pg_fetch_array($resultP,$countEval);
															$ob_reporte->ano=$ano;
															$ob_reporte->periodo=$filaP['id_periodo'];
															$ob_reporte->alumno=$alumno;
															$ob_reporte->id_item=$filaTraeItem['id_item'];
															$resultEval=$ob_reporte->InformeConcepto($conn);
															$filaEval=@pg_fetch_array($resultEval,0);
															$ob_reporte->respuesta=$filaEval['id_concepto'];
															$resultConc=$ob_reporte->InformeEvaluacion($conn);
															$filaConc=@pg_fetch_array($resultConc,0);
															if($ckCONCEPTO==0){	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['sigla']);?></font></td>
	<?														}else{	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['nombre']); ?></font></td>
<?															}
														}
													}else if($filaTraeItem['tipo']==2){
														$ob_reporte->ano=$ano;
														$ob_reporte->periodo=$filaP['id_periodo'];
														$ob_reporte->alumno=$alumno;
														$ob_reporte->id_item=$filaTraeItem['id_item'];
														$resultEvalu=$ob_reporte->InformeConcepto($conn);
													
														for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
															$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);	?>
												  <tr><td valign=bottom>
															<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text'];?></td></tr>
															<tr><td bgcolor="#0099FF" ></td></tr>
<?														}
													}else if($filaTraeItem['tipo']==1){
														$ob_reporte->ano=$ano;
														$ob_reporte->periodo=$filaP['id_periodo'];
														$ob_reporte->alumno=$alumno;
														$ob_reporte->id_item=$filaTraeItem['id_item'];
														$resultEvalua=$ob_reporte->InformeConcepto($conn);
														
														for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
															$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
															if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	?>
																	<tr><td valign=bottom>
																	<font size=1 face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;No</font></td></tr>	
																	<tr><td bgcolor="#0099FF" ></td></tr>
<?															}else if($filaEvalua['radio']==1){	?>
																	<tr><td valign=bottom>
																	<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;Si</font></td></tr>
																	<tr><td bgcolor="#0099FF"></td></tr>
<?															}
														}
													}
												}//fin for($countItem....
											}//fin for($countSubarea....
										}//fin for($countArea....			  ?>
										<input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
										<input name="alumno" type="hidden" value="<?php echo $alumno?>">
                                        </table>
<?										/*if($institucion!=25218  && $institucion!=14629 && $institucion!=24977 && $institucion!=25478 && $institucion!=12086 && $institucion!=24464 && $institucion!=22380 && $institucion!=25768  && $institucion!=9035 && $institucion!=1707 && $institucion!=9276 && $institucion!=8905 && $institucion!=318 ){ 	?>
											<H1 class=SaltoDePagina></H1>
                                            <p></p>
                                              <?										} ?>*/
											  
											if ($ckDESTACA==1){  
										$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
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
										<td width="20%" class="tabla04"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Se destaca en:</font></td>
										<td width="80%" class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<?=$sedestaca ?></font></td>
									 </tr>
								   </table>									
							  <? } ?>  
                              
                             
                                           <!-- <p>&nbsp;</p>-->
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
										  <tr>
											<td><font size="1" face="Arial, Helvetica, sans-serif">Observaciones:</font></td>
										  </tr>
										</table>
										
                                        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
					<?					$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
											$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
											<tr>
												<td width="19%"><font size="1" face="Arial, Helvetica, sans-serif">
	                                             <? if ($_INSTIT=="1436" ){ ?>ANUAL <? }else{ ?><?	echo $filaObs['nombre_periodo']; ?><? } ?>
												</td>
												<td><font size="1" face="Arial, Helvetica, sans-serif">
	<?												echo $filaObs['glosa'];	?>&nbsp;</font>
												</td>
											</tr>
<?										}	?>
										</table>
                         
  
   
										
                                        <table width="100%" border="0">
<?										if($institucion!=25218 && $institucion!=14629 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380 ){?><!--
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td></td>
											</tr>-->
                              <?		}	?>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
												<input type="hidden" name="fecha">
												<input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
												<input type="hidden" name="grado" value="<?php echo $grado ?>">
												</font></td>
											</tr>
										</table>
									<!--AQUI VAN LAS FIRMAS-->
                                     
                                     <?php  
									 
									 for($b=0;$b<$txtFIRMA;$b++){
										echo "<br>"; 
									 }
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
									
								  <tr>
         <td class="subitem"><? echo $ob_membrete->comuna.",".fecha_espanol($fecha);?></td>
      </tr>
                   </table>

							<? }?>
<?php if($ckColilla==1){?>
 
 <table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo strtoupper($ob_reporte->tildeM($ob_reporte->nombres));?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $Curso_pal?></strong></font></div></td>
  </tr>
  <tr>

    <td><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Período </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Atrasos </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <?
	$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."', 'YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);
	if (empty($fila_atraso['cantidad']))
		echo "0";
	else
		echo trim($fila_atraso['cantidad']);
	?>
    </font></div></td>
  </tr>
  <tr>
 <?php  if($_INSTIT!= 9105){?>
    <td><div align="left"></div></td>
    <td><div align="left"></div></td>
    <?php }?>
    
    <? if($Just_Asis==0){?>
     <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias Justificadas</font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $justifica ?></font></div></td>
    <? }?>
  </tr>
  
  <tr>
    <td height="70">&nbsp;</td>
    <td valign="bottom"><div align="center">___________________________</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
	
<?	}?>				
	
							
						
<!-- hasta aki -->					
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

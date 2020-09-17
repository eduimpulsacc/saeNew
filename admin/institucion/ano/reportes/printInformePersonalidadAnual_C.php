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
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');

/*if($_PERFIL==0){
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	}*/

$ano		= $_ANO;
$curso		= $cmb_curso;
$alumno		= $cmb_alumno;
$reporte	= $c_reporte;
$institucion= $_INSTIT;
$contador_salto=0;
$_POSP = 5;
$_bot = 8;
$tipop = $tipo_planilla;

$ruta_timbre =6;
$ruta_firma =4;

if(!isset($chk_asis)){
	$chk_asis=0;
	}
	
if(!isset($hoja_anexa)){
	$hoja_anexa=0;
	}
//echo "_".$chk_asis;

																																																																																																																																																																																																																											
$ob_reporte = new Reporte();
$ob_membrete = new Membrete();


/************************ INSTITUCION ***********************/
$ob_membrete ->institucion=$institucion;
$ob_membrete ->institucion($conn);

/*********************** ANO ESCOLAR ***********************/
$ob_membrete ->ano = $ano;
$ob_membrete ->AnoEscolar($conn);
$nro_ano = $ob_membrete->nro_ano;
$finicio_col = $ob_membrete->fecha_inicio;
 $ftermino_col = $ob_membrete->fecha_termino;

/*******************CURSO ***********************/
if($institucion==1653){
	$Curso_pal = CursoPalabra($curso, 6, $conn);
}else{
	$Curso_pal = CursoPalabra($curso, 1, $conn);
}

/***************** PROFESOR JEFE *******************/
$ob_reporte ->curso =$curso;
$ob_reporte ->ProfeJefe($conn);

/****************** PERIODO ***********************/
$ob_reporte ->ano = $ano;
$resultPeriodo= $ob_reporte ->TotalPeriodo($conn);


//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	$tamañoTiulo = $ob_config->tamanoT + 4;
	
	
	$ob_membrete->curso = $curso;
	$rs_curso = $ob_membrete->curso($conn);
	

	$finicio_curso = $ob_membrete->finicio_curso;
	$ftermino_curso = $ob_membrete->ftermino_curso;
	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_educacional_personalidad_$fecha_actual.xls"); 	 
}	


?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
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

function guardaImp(alu){
	var ano =<?php echo $_ANO ?>;
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
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt18.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
					
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		  
		function exportar(){
			var firma1=document.form.firma1.value;
			var firma2=document.form.firma2.value;
			var firma3=document.form.firma3.value;
			var firma4=document.form.firma4.value;
			window.location='printInformePersonalidadAnual_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&capa=10&xls=1&firma1='+firma1+'&firma2='+firma2+'&firma3='+firma3+'&firma4='+firma4;
			return false;
		  }		  	
									
</script>
</head>
 <STYLE>

  H1.SaltoDePagina {
		 PAGE-BREAK-AFTER: always
		 
	  }
  .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$tamañoTiulo;?>px;
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
  .hidden
 {
 visibility:hidden
 }

  </style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','../../botones/periodo_roll.gif','../../botones/feriados_roll.gif','../../botones/planes_roll.gif','../../botones/tipos_roll.gif','../../botones/cursos_roll.gif','../../botones/matricula_roll.gif','../../botones/informe_roll.gif','../../botones/actas_roll.gif','../../botones/generar_roll.gif')">

  <!-- INSERTO CODIGO SUPERIOR -->     
 
  <? if ($_PERFIL!=16 AND $_PERFIL!=15 ) {
      
		  if ($_INSTIT!=1599){	   
			  ?>
			     
<form method "post" action="printInformePersonalidadAnual_C.php" name="form" target="_blank">
			  <div id="capa0">
			  <table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr> 
					<td>           
					
					  <div align="right">
					    <input 	name="cmdimprimiroriginal" type="button" class="botonXX" id="cmdimprimiroriginal" onClick="imprimir()" 	value="Imprimir">
					    <? if($_PERFIL==0){?>		  
					    <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="Exportar">
						<input name="cmb_curso" value="<?=$curso?>" type="hidden">
						<input name="cmb_alumno" value="<?=$alumno?>" type="hidden">
						<input name="capa" value="10" type="hidden">
						<input name="xls" value="1" type="hidden">
					    <? }?>
				        </div>
					        </td>
				</tr>
			  </table></div>
              <input type="text" id="calu" value="">
			  <?
		  }
     }
  ?>
			  <script type="text/javascript">
document.getElementById("capa4").style.display='block';

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
}

</script>

  <?
 	if ($cmb_alumno==0){
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$curso;
		$ob_reporte ->retirado =$_REQUEST['retirado'];
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$curso;
		$ob_reporte ->alumno=$alumno;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);

$cadalu="";
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){

	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$fecha_retiro = $fila_alu['fecha_retiro'];
	$fecha_matricula = $fila_alu['fecha'];
	$ob_reporte ->CambiaDato($fila_alu);
	$cadalu.=$alumno.",";
	
	
	$ob_reporte ->alumno =$alumno;
	$ob_reporte ->ano =$ano;
	$resultMatri =$ob_reporte ->MatriculaCurso($conn);
	$filaMatri=@pg_fetch_array($resultMatri,0);
	if($filaMatri['grado_curso']==1) $gr="pa";
	if($filaMatri['grado_curso']==2) $gr="sa";
	if($filaMatri['grado_curso']==3) $gr="ta";
	if($filaMatri['grado_curso']==4) $gr="cu";
	if($filaMatri['grado_curso']==5) $gr="qu";
	if($filaMatri['grado_curso']==6) $gr="sx";
	if($filaMatri['grado_curso']==7) $gr="sp";
	if($filaMatri['grado_curso']==8) $gr="oc";
	if($filaMatri['grado_curso']==9) $gr="nv";
	if($filaMatri['grado_curso']==10) $gr="dc";
	if($filaMatri['grado_curso']==11) $gr="un";
	if($filaMatri['grado_curso']==12) $gr="duo";
	if($filaMatri['grado_curso']==13) $gr="tre";
	if($filaMatri['grado_curso']==14) $gr="cat";
	if($filaMatri['grado_curso']==15) $gr="quince";
	if($filaMatri['grado_curso']==16) $gr="diezseis";
	

	$ob_reporte ->ensenanza=$filaMatri['ensenanza'];
	$ob_reporte ->grado= $gr;
	$ob_reporte ->institucion=$institucion;
	$ob_reporte->tipop = @$tipop;
	$resultPlantilla=$ob_reporte ->InformePlantilla($conn);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$titulo1 = $filaPlantilla['titulo_informe1'];
	$nuevo = $filaPlantilla['nuevo_sis'];	

?> 
 <?php  //if($_PERFIL==0){
                     if($filaMatri['ensenanza']==10 && $chk_portada==1){
						// echo "aca";
						 include('informePersonalidad/portadaParvularia.php');
                     }
                    //  }
					?> 
<table width="700" border="0" bordercolor="#FF0000" cellpadding="0" cellspacing="0" align="center">     
<tr>
<td>

<!--<table width="650" border="0" align="left">
  <tr> 
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="30%">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>-->

<?
			$result = pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=pg_fetch_array($result,0);
			$fila_foto = pg_fetch_array($result,0);
			
			if 	(!empty($fila_foto['insignia'])){ ?>
<table width="650" border="0" align="center">
  <tr>
    <td width="113"><?php  if($institucion!=""){
							if($institucion==12086 && $filaMatri['ensenanza']==10){
								echo "<img src='".$d."tmp/".$institucion."insignia2". "' >";
								
							}else{ 
							    
							   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
							}
				  }else{
				      
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?></td>
    <td width="521"><table width="650" border="0" align="center">
					      <tr valign="middle"> 
					        <td width="23%" align="center" class="titulo">
                            <strong>&nbsp;<?php echo $ob_membrete->ins_pal;?><br><? echo "AÑO ESCOLAR ".$nro_ano;?></strong><br>
<strong>Res. 
					          Exta. de Educaci&oacute;n N&ordm; <?php 
							  if($institucion==9940 and  $filaMatri['ensenanza']==310){
							  	echo " 03016 DE 1977 ";
							  }else{
							  echo $ob_membrete->nu_resolucion;?> 
					          de fecha 
					          <?php impF($ob_membrete->fecha_resol); }?>
					          Rol Base de Datos <?php echo $institucion," - ",$ob_membrete->dig_rdb?> 
					          </strong></td>
						  </tr>
    </table></td>
  </tr>
</table>
<?php }
else{
			/*	if($institucion==26094 && $filaMatri['ensenanza']==10 && $filaMatri['grado_curso']==5){
					echo "<img src='".$d."tmp/".$institucion."Kinder.jpg". "'  width='150'>";		
				}elseif($institucion==26094 && $filaMatri['ensenanza']==10 && $filaMatri['grado_curso']==4){
					echo "<img src='".$d."tmp/".$institucion."prekinder.jpg". "'  width='150' height='90'>";	
				}else{
			       echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
				}*/
		
		
		    ?>
    <td width="650"><table width="100%" border="0" align="center">
            <tr> 
              <td align="center" class="titulo"><div align="center"><strong>
                <?					  
						if ($_INSTIT==25269 and $filaMatri['ensenanza']==10){
							 echo "INFORME DE AVANCE PRE-ESCOLAR"; 							
						}else{
							 echo $titulo1;
						}
							
					  ?></strong></div></td>
      </tr>
            </table>
				    
				
				    
					  <table width="650" border="0" align="center">
					    <tr>
					      <td align="center"><?
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
			
				  if($institucion!=""){
							if($institucion==12086 && $filaMatri['ensenanza']==10){
								echo "<img src='".$d."tmp/".$institucion."insignia2". "' >";
								
							}else{ 
							    
							   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
							}
				  }else{
				      
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?></td> 
					      <td align="center" style="padding-right:120px">
                          <strong><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $ob_membrete->ins_pal;?>&nbsp;
                          <? echo "AÑO ESCOLAR ".$nro_ano;?></font></strong><br>
						<?php if($institucion!=14490){ ?><br>
                        <strong>Res. Exta. de Educaci&oacute;n N&ordm; <?php echo $ob_membrete->nu_resolucion?> 
					          de fecha 
					          <?php impF($ob_membrete->fecha_resol)?></strong>
                              <?php }?>
					          <br>
			           <strong> <font size="2" face="Arial, Helvetica, sans-serif">Rol Base de Datos <?php echo $institucion," - ",$ob_membrete->dig_rdb?></font> 
			              </strong></td>
				        </tr>
				    </table>
					    <table width="650" border="0" align="center">
					      <tr valign="middle"> 
					        <td align="center" class="item"></td>
					      </tr>
      </table>
		    <br></td>
				  <td>&nbsp;</td>
	  <? } ?>
  
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="80%" valign="top">
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr></tr>
        <tr> 
          <td width="13%" class="item">Alumno(a)</td>
			    <td width="52%" class="subitem" >: <b> <?php echo strtoupper( $ob_reporte->Tilde($ob_reporte->nombres));?> </b></td>
			       
			        <!--<td width="1%" colspan="4">&nbsp;</td>-->
			    
				  
		      </tr>
               <tr>
                <td width="6%" class="item">RUT</td>			  
			        <td width="21%"  class="item">: <?php echo $ob_reporte->rut_alumno?></td>
               </tr>
        </table>
	    
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr> 
		      <td width="20%" class="item">Curso</td>
			    <td width="80%" class="subitem">: <?php echo $Curso_pal; ?></td>
			  </tr>
		    </table>
	    <?php if($filaMatri['ensenanza']>310 ){?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="20%" class="item">Especialidad</td>
		  <td width="80%" class="subitem">: <?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
										$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
										$filaEsp=@pg_fetch_array($resultEsp,0);
										echo $filaEsp['nombre_esp'];?></font></td>
		      </tr>
        </table>
	    <?php } ?>
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="20%" class="item">Profesor Jefe</td>
            <td width="80%" class="subitem">: <?php echo $ob_reporte->tildeM($ob_reporte->profe_nombre);?></td>
          </tr>
        <tr>
          
          </tr>
        </table>
	   </td>
	   <td width="20%" valign="top">&nbsp;</td>
	  </tr>
  </table>
  <? if($escala==1 && $posicion_escala==1){ ?>
 <table width="650" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr> 
          <td align="left"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></td>
	    </tr>
      </table>
		    
		  <table width="650" cellpadding="0" cellspacing="0" border="0" align="center">	
		    <?php 
			
				$sqlConc="SELECT * FROM  informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']." order by orden asc";
				
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					?>
		    
		    <tr>
		      <td width="37%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo  $filaConc['nombre']; ?> (<? echo $filaConc['sigla']; ?>) </font></td>
					     <td width="4%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8">:</font></td>
					     <td width="59%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo $filaConc['glosa']; ?></font></td>
		    </tr>
		    
		    <? 
			  }	?>
		    
	    </table>
        <? } ?>
          <?

						$plantilla = $filaPlantilla['id_plantilla'];
						// Areas
						$ob_reporte ->nuevo = $nuevo;
						$ob_reporte ->plantilla = $plantilla;
						$result_cat=$ob_reporte ->InformeAreas($conn);
						$num_cat=@pg_numrows($result_cat);
						$jjj = 1;
							
							for ($i=0;$i<$num_cat;$i++)	{
								?>
          <table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
            <?php 
						echo "<tr><td><img src='../../../../cortes/p.gif' width='10' height='1' border='0'></td>";
						$tot_periodos = pg_numrows($resultPeriodo);
						for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $regimen="trimestre";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$per."</font></td>";
						}
						
						echo "</tr>";
							
								$row_cat=pg_fetch_array($result_cat);	?>  
<tr>
								  <td colspan="4" class="item" height="15" align="center"><strong>
									<?
										if ($_INSTIT==770){
											$jjj++;
										} ?>		
									<? if($nuevo==1){
											echo $row_cat['glosa'];
									   }else{
											echo $row_cat['nombre'];
									   }?> 
									  </strong>               
								  </td>                                   
			</tr>
            
  <?            				    // Subareas
								$ob_reporte ->nuevo = $nuevo;
								$ob_reporte ->plantilla = $plantilla;
								$ob_reporte ->id_padre = $row_cat[id];
								$ob_reporte ->id_area = $row_cat[id_area];
								$result_sub=$ob_reporte ->InformeSubArea($conn);
								$num_sub=pg_numrows($result_sub);?>
            <? for ($j=0;$j<$num_sub;$j++){
								      $row_sub=pg_fetch_array($result_sub);	
									  if ($row_sub['glosa']!=1 and $row_sub['glosa']!=2 and $row_sub['glosa']!=3 and $row_sub['glosa']!=4 and $row_sub['glosa']!=5 and $row_sub['glosa']!=6){
										  if($institucion==14703){ $alig = "center"; }else{ $alig = "left";}
									  ?> 
            <tr>
              <td colspan="1" align="<?=$alig;?>" ><span class="item"><strong><img src="../../../../cortes/p.gif" width="10" height="10" border="0">
                
                
                <?
										if($nuevo==1){
											echo $row_sub['glosa'];
										}else{
											echo $row_sub['nombre'];
										}?>
                              </strong> </span></td>		
									   									  
									   <td width="1%" nowrap class="subitem">
									     <img src="../../../../../cortes/p.gif" width="10" height="1" border="0"><? // Conceptos subareas
									   if($nuevo==1){
											if ($_INSTIT==2278){
											     $tabla_informe = 'informe_evaluacion2_new';
												 
											}else{
											     $tabla_informe = 'informe_evaluacion2';											
											}
											
											
											$query_respuesta="select * from $tabla_informe where id_ano='$_ANO' and id_periodo='$id_peri[0]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
									   }
									   if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													
													echo $row_con[sigla];
												}
											}else{
													echo $row_respuesta[respuesta];
											}

									   }else{
									        
											echo "&nbsp;";
									   }
									   
									   ?>			      </td>
									      <td width="1%" nowrap class="subitem">
									        
									        <img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
									        <? // $id_peri[0]; para 1er Semestre
										    if($nuevo==1){
											    if ($_INSTIT==2278){
													 $tabla_informe = 'informe_evaluacion2_new';													
												}else{
													 $tabla_informe = 'informe_evaluacion2';											
												}
											
		   									   	$query_respuesta="select * from $tabla_informe where id_ano='$_ANO' and id_periodo='$id_peri[1]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";										   
												$result_respuesta=pg_exec($conn,$query_respuesta);
												$num_respuesta=pg_numrows($result_respuesta);
											}
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo $row_con[sigla];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}else{
												echo "&nbsp;";
											}
												?>		          </td>
								  <? 	 
									 if($regimen=="trimestre"){
								        
								     	?>
              <td width="1%" nowrap class="subitem"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
              <? // $id_peri[0]; para 1er Semestre
										   if ($_INSTIT==2278){
												 $tabla_informe = 'informe_evaluacion2_new';
												 
											}else{
												 $tabla_informe = 'informe_evaluacion2';											
											}
										
										   $query_respuesta="select * from $tabla_informe where id_ano='$_ANO' and id_periodo='$id_peri[2]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo $row_con[sigla];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}?>	</td>
								  <? }?>																		
            </tr>
            <? } ?>
            <?	// Items
							$ob_reporte ->plantilla = $plantilla;
							$ob_reporte ->id_padre=$row_sub[id];
							$ob_reporte ->id_subarea = $row_sub['id_subarea'];
							$result_item= $ob_reporte->InformeItem($conn);
							$num_item=pg_numrows($result_item);?>
            <? for ($z=0;$z<$num_item;$z++){
					$row_item=pg_fetch_array($result_item);	
					$id_item = $row_item['id_item'];?>
            <tr >
              <td class="subitem" width="600"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;&nbsp;&nbsp;&nbsp;
                <? echo $row_item['glosa'];?>                </td>
				         	  <?	if($nuevo==1){	?>
              <td nowrap class="subitem" width="25"><? 	//Conceptos Items
									$ob_reporte ->nuevo =$nuevo;
									$ob_reporte ->ano = $ano;
									$ob_reporte ->periodo = $id_peri[0];
									$ob_reporte ->plantilla = $plantilla;
									$ob_reporte ->id_item = $row_item[id];
									$ob_reporte ->alumno = $alumno;
									$result_respuesta= $ob_reporte ->InformeConcepto($conn);
									$num_respuesta=pg_numrows($result_respuesta);
									if($num_respuesta>0){
										$row_respuesta=pg_fetch_array($result_respuesta);
										if ($row_respuesta[concepto]==1){
											$ob_reporte ->respuesta = $row_respuesta['respuesta'];
											$result_con =$ob_reporte ->InformeEvaluacion($conn);
											$num_con=pg_numrows($result_con);
											if ($num_con>0){
												$row_con=pg_fetch_array($result_con);
												if ($evaluacion=="1"){												
													 echo $row_con[sigla];
 												}else{												
													 echo $row_con[nombre];
												}
											}
										}else{
											echo $row_respuesta[respuesta];
										}
									}									
									
									?></td>
									  <td width="25" nowrap class="subitem">
									<? 	$ob_reporte ->nuevo =$nuevo;
										$ob_reporte ->ano = $ano;
										$ob_reporte ->periodo = $id_peri[1];
										$ob_reporte ->plantilla = $plantilla;
										$ob_reporte ->id_item = $row_item[id];
										$ob_reporte ->alumno = $alumno;
										$result_respuesta= $ob_reporte ->InformeConcepto($conn);
										$num_respuesta=pg_numrows($result_respuesta);
										if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$ob_reporte ->respuesta = $row_respuesta['respuesta'];
												$result_con =$ob_reporte ->InformeEvaluacion($conn);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													if ($evaluacion=="1"){												
													    echo $row_con[sigla] ;
													}else{												
														echo $row_con[nombre];
													}
												}
											}else{
												echo $row_respuesta[respuesta];
											}
										}
									
									
									?></td>
								  <? 	 
								    
								
								     if(trim($regimen)=="trimestre" or $_INSTIT==770){							  
									 
									 	?>
              <td width="1%" nowrap class="subitem"><? 	$ob_reporte ->nuevo =$nuevo;
											$ob_reporte ->ano = $ano;
											$ob_reporte ->periodo = $id_peri[2];
											$ob_reporte ->plantilla = $plantilla;
											$ob_reporte ->id_item = $row_item[id];
											$ob_reporte ->alumno = $alumno;
											$result_respuesta= $ob_reporte ->InformeConcepto($conn);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$ob_reporte ->respuesta = $row_respuesta['respuesta'];
													$result_con =$ob_reporte ->InformeEvaluacion($conn);;
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														if ($evaluacion=="1"){												
													         echo $row_con[sigla];
														}else{												
															 echo $row_con[nombre];
														}
													}
												}else{
												    echo $row_respuesta[respuesta];
												}
											}
										?></td>
					               <?	}									
							  }else{								
	//Primer Periodo				
									$ob_reporte ->nuevo=0;
									$ob_reporte ->id_item = $id_item;
									$ob_reporte ->ano =$ano;
									$ob_reporte ->periodo = $id_peri[0];				
									$ob_reporte ->alumno = $alumno;
									$resultEval= $ob_reporte ->InformeConcepto($conn);
									
									if(pg_numrows($resultEval)!=0){
										$filaEval=pg_fetch_array($resultEval,0);
										$ob_reporte ->respuesta = $filaEval['id_concepto'];
										$resultConc=$ob_reporte ->InformeEvaluacion($conn);
										$filaConc=pg_fetch_array($resultConc,0);
										$sigla = $filaConc['sigla'];
										$concepto = $filaConc['nombre'];
									}else{
										$sigla = "&nbsp;";
										$concepto = "&nbsp;";
									}?>
              <td class="subitem"><? 	if ($evaluacion=="1"){ 
										echo $sigla;
									}else{ 
										echo $nombre;
									} ?>								</td>
								  
<? 	//Segundo Periodo			
									$ob_reporte ->nuevo=0;
									$ob_reporte ->id_item = $id_item;
									$ob_reporte ->ano =$ano;
									$ob_reporte ->periodo = $id_peri[1];				
									$ob_reporte ->alumno = $alumno;
									$resultEval= $ob_reporte ->InformeConcepto($conn);
									
									if(pg_numrows($resultEval)!=0){
										$filaEval=pg_fetch_array($resultEval,0);
										$ob_reporte ->respuesta = $filaEval['id_concepto'];
										$resultConc=$ob_reporte ->InformeEvaluacion($conn);
										$filaConc=@pg_fetch_array($resultConc,0);
										$sigla = $filaConc['sigla'];
										$concepto = $filaConc['nombre'];
									}else{
										$sigla = "&nbsp;";
										$concepto = "&nbsp;";
									}?>
              
              <td class="subitem"><? 	if ($evaluacion=="1"){ 
										echo $sigla;
									}else{ 
										echo $nombre;
									} ?></td>																						
                                  <?  //tercer Periodo			
								if($tot_periodos==3){
									$ob_reporte ->nuevo=0;
									$ob_reporte ->id_item = $id_item;
									$ob_reporte ->ano =$ano;
									$ob_reporte ->periodo = $id_peri[2];				
									$ob_reporte ->alumno = $alumno;
									$resultEval= $ob_reporte ->InformeConcepto($conn);
									
									 
									if(@pg_numrows($resultEval)!=0){
										$filaEval=@pg_fetch_array($resultEval,0); 
										$ob_reporte ->respuesta = $filaEval['id_concepto'];
										$resultConc=$ob_reporte ->InformeEvaluacion($conn);
										$filaConc=@pg_fetch_array($resultConc,0);
										$sigla = $filaConc['sigla'];
										$concepto = $filaConc['nombre'];
									}else{
										$sigla = "&nbsp;";
										$concepto = "&nbsp;";
									}?>
              <td class="subitem"><? 	if ($evaluacion=="1"){ 
										echo $sigla;
									}else{ 
										echo $nombre;
									} ?></td>																
							  <?	 }
							  }	?>																		
            </tr>
  <?						
  							if((($contador_salto % $txtSALTO)==0) && $contador_salto!=0){
								?></table><?
								//echo "<H1 class='SaltoDePagina'></H1>";?>
  <table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
  
		  <?
							}
							$contador_salto++;
							} //FIN AMBITO
							} //FIN NUCLEO							
							} // FIN DETALLES	

?>
            
		  <br></table>
	    
			<?	if ($destaca==0){ 
					$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
					$ob_reporte ->ano =$filaMatri['id_ano'];
					$ob_reporte ->alumno = $alumno;
					$ob_reporte ->periodo = "";
					$resultObs= $ob_reporte ->InformeObservaciones($conn);
				//for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
					  $filaObs=@pg_fetch_array($resultObs, 0);
					  $sedestaca1 = $filaObs['sedestaca'];
					  $filaObs=@pg_fetch_array($resultObs, 1);
					  $sedestaca2 = $filaObs['sedestaca'];
				//}
				
		  ?>
          <br>
			<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
            
          <? if($chk_asis==1){
			  ?> <tr>
          <td width="15%" class="tabla04" ><font face="Verdana, Arial, Helvetica, sans-serif" size="1">(%) Asistencia:</font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
					  <td class="tablatit2_1" ><span class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					   <?php
														
							/*$ob_reporte ->ano =$ano;
							$ob_reporte->rut_alumno;
							$ob_reporte->curso=$curso;
						    $result_asis=$ob_reporte->AsistenciaAlumno($conn);
						    $contador_asis=@pg_numrows($result_asis);
							 //$contador_asis;
							
							$result_diashabiles=$ob_reporte->DiasHabiles($conn);
							$total_hab=@pg_fetch_array($result_diashabiles);
						    $dias_habiles = $total_hab['dias_habiles'];
							 
							 
							 $por_asis = ($contador_asis*100)/$dias_habiles;*/
							 
							 
							 //=========== calculo % asistencia nuevo =====
	//************ habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
				$habil_real_ano=0;
				$feriados_ano=0;
				$fera=0;
				
				
				if($finicio_curso=="Null" || $finicio_curso=="1111-11-11"){
					if($fecha_matricula <= $finicio_col)
					{$fini= $finicio_col;}
					else
					{$fini= $fecha_matricula;}
				}else{
					$fini= $finicio_curso;
				}
				
		/*if($fecha_matricula <= $finicio_curso)
		{$fini= $finicio_curso;}
		else
		{$fini= $fecha_matricula;}*/
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
		if($retirado==1){
		 $fter =$fecha_retiro;
		}else{
		 
		 
		 if($ftermino_curso=="Null" || $ftermino_curso=="1111-11-11"){
					$fter = $ftermino_col;
				}else{
					$fter = $ftermino_curso;
				}
		 
		}
		
		//conteo dias habiles año (sin feriados)
		 $habiles_ano=hbl($fini,$fter);
		
		
	
//***************fin habikes (nuevo)
//******feriados año
     $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']=='')
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
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	$contador_asis=$c_inasistenciaAno;
	
//justificadas

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
 
 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $prc_base = intval((100* $con_total_inano)/$habil_real_ano);
	
	/*if($_PERFIL==0) {
		echo (100* $con_total_inano); 
		echo "<br> feriados-->".$habil_real_ano;
		echo "<br>rut_alumno-->".$alumno;
		echo "<br> inasistencia--->".$c_inasistenciaAno;
		echo "<br> fecha_retiro-->".$fter;
		echo "<br> justificadas-->".$justificaano;
		echo "<br>-->". $prc_base;
	}*/
//=========== fin calculo % asistencia nuevo =====
	
							 
							 
							 
							 if($institucion!=1593){
							 $texto= "Alumno(a) Presenta un ";
							  echo $texto.($prc_base." %   de Asistencia&nbsp;"." Con un total de ".$contador_asis." Días faltados");
							 }else{
								echo  ($prc_base)." %";
							 }
							 
							?>
					    </font></span></td>
	      </tr>
          <?php }?>
            
        <tr>
          <td width="15%" class="tabla04" ><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Se destaca <? if($institucion!=14703){ echo "en"; } ?>:</font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
					  <td class="tablatit2_1" ><span class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					    <?=$sedestaca1 ?>
					    </font></span></td>
	      </tr>
        <tr>
          <td>&nbsp;</td>
		  <td width="85%" class="tablatit2_1"><span class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
			<?=$sedestaca2 ?>
			</font></span></td>
					  
	      </tr>
        </table>									
		    <? } ?>
      
      
      
      
      <? if($obs==0) {
	   ?>
      <table width="650" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" align="center">
        <tr> 
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;Observaciones:</font></td>
        </tr>
      </table>
			    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
			      <?	
				  for($xxx=0 ; $xxx<@pg_numrows($resultObs) ;$xxx++ ){
					  $filaObs=@pg_fetch_array($resultObs, $xxx);
					  
					  //echo "glosa".$filaObs['observaciones'];
					  if($filaObs['observaciones']!=''){
						$obs = $filaObs['observaciones'];
					  }else{
						$obs = $filaObs['glosa'];
					  }
					  ?>
			      <tr>
			        <td width="20%"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaObs['nombre_periodo']; ?></font></td>
						  <td><font size="1" face="Arial, Helvetica, sans-serif"><?	echo $obs;	echo "&nbsp; ";?></font></td>
				  </tr>
			      <?  } ?>
		      </table>
	    <? 
	  } ?> 
      
      
      <!--MODULO DE FIRMAS CONFIGURABLES-->
  <!--////////////////FIRMAS COLEGIO SAN-JOSE 2278/////////////////////////-->
      
  <!--////////////////FIN FIRMAS COLEGIO SAN-JOSE//////////////////////////-->
      
  <?	echo "<br>";
  			$sql_con =" SELECT * FROM configuracion_reporte WHERE rdb=".$institucion." AND id_item=".$reporte." "; 
		if($curso!=1){
			$sql_con.=" AND tipo_ense in (SELECT ensenanza FROM curso WHERE id_curso=".$curso.") ";
		}
		$sql_con.=" and id_config= ".$fila_config['id_config'];

//echo $sql_con;
		echo ".";

		$resp = @pg_exec($conn,$sql_con);
		$fila_config= pg_fetch_array($resp,0);
		
		
					
		$firma1=$fila_config['firma1'];
		$firma2=$fila_config['firma2'];
		$firma3=$fila_config['firma3'];
		$firma4=$fila_config['firma4'];
		
		?>
      <!--/*<table border="0">
        <tr>
          <td><input type="hidden" name="firma1" value="<?=$firma1?>"></td>
		  <td><input type="hidden" name="firma2" value="<?=$firma2?>"></td>
		  </tr>
        <tr>
          <td><input type="hidden" name="firma3" value="<?=$firma3?>"></td>
		  <td><input type="hidden" name="firma4" value="<?=$firma4?>"></td>
		  </tr>
        <tr>
          <td><input type="hidden" name="cmb_curso" value="<?=$cmb_curso?>"></td>
		  <td><input type="hidden" name="cmb_alumno" value="<?=$cmb_alumno?>"></td>
		  </tr>
        </table>*/-->
		<? for($g=0;$g<$txtFILAS;$g++){
			echo "<br>";
			}

		?>
		 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
	<!--  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	    <tr>
	      <?   
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='60'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <? if($institucion==14490 and $ob_reporte->nombre_cargo=="Rector(a)") echo "Rector"; else echo $ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
	     <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='65'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='60'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='60'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
            
            
            
			  <? if($chk_apo==1){?>
          <td width="25%" class="item"><hr align="center" width="150" color="#000000">
	        <div align="center">
	          <?	$ob_reporte->FirmaApo($conn);
			  		echo $ob_reporte->nombre_apo;?>
	          <br>
	          Apoderado
            </div></td>
			  <? } ?>
         
        </tr>
  </table>-->
  
      <!--/// FECHA DEL INFORME //// -->
      <? 
	  $sql_con ="SELECT * FROM configuracion_reporte WHERE rdb=".$institucion." AND id_item=".$reporte." ";
	
	  $fecha1= date("d-m-Y");
	  $fecha=fecha_espanol($txtFECHA);
	?>
      <table width="650"  border="0" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td >
        <font size="1" face="Arial, Helvetica, sans-serif">
          
          
          <?php echo  $ob_membrete->comuna.",".$fecha; ?> </font></td>
        </tr> 
    </table>
	     
	   
	    
	  	  
	    <?
	  if ($_INSTIT==12829){ ?>
	    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="12"><strong><font size="1" face="Arial, Helvetica, sans-serif">ESCALA DE EVALUACI&Oacute;N:</font></strong></td>
	      </tr>				
        <tr>
  <?				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'] ;
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
          <td width="10" valign="top"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $filaConc['sigla'];?></strong></font>: </td>
					  <td align="left" valign="bottom"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaConc['nombre'];?></font></td>
					  
<?				}	?>
          </tr>
        </table>
	    
	  
     <? }else{ 
   			if($escala==1 && $posicion_escala==2){?>
     <table width="650" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr> 
          <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></td>
	    </tr>
      </table>
		    
		  <table width="650" cellpadding="0" cellspacing="0" border="0" align="center">	
		    <?php 
			
				$sqlConc="SELECT * FROM  informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']." order by orden asc";
				
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					?>
		    
		    <tr>
		      <td width="37%" align=center><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo  $filaConc['nombre']; ?> (<? echo $filaConc['sigla']; ?>) </font></td>
					     <td width="4%" align=center><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8">:</font></td>
					     <td width="59%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo $filaConc['glosa']; ?></font></td>
		    </tr>
		    
		    <? 
			  }	?>
		    
	    </table>
        <? if($institucion==5265 || $institucion==5661 || $institucion==6122 || $institucion==6835 || $institucion==7405 || $institucion==11678 || $institucion==19968 || $institucion==22019){ ?>
                      <table width="650" border="0" align="center">
                          <tr>
                            <td class="item" align="center"><em>&nbsp;“Únicamente al esforzaros seriamente por tener éxito, lograréis la verdadera felicidad. Son preciosas las oportunidades que se os ofrecen durante el tiempo que pasáis en la escuela. Haced tan perfecta como sea posible vuestra vida estudiantil. Recorreréis ese camino una sola vez.Y de vosotros mismos depende que vuestra tarea sea un éxito o un fracaso. A medida que tengáis éxito en adquirir el conocimiento de la Biblia, estaréis acumulando tesoros para impartir.” (Mensaje para los Jóvenes. Elena de Whitte).</em></td>
                          </tr>
                        </table>
                        <? } ?>
        <?php if($hoja_anexa==1){?>
        <H1 class=SaltoDePagina></H1>
         <table width="650" border="0" align="center" bordercolor="#FF0000">
         <tr><td class="titulo" align="center"><b>
         INFORME DE EVALUACION DE APRENDIZAJES <?php echo $filaEns['nombre_tipo'] ?></b>
         </td></tr>
         <tr><td>&nbsp;</td></tr>
          <tr><td>
          <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
  <tr>
    <td class="item" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px; font-weight:bold">ASISTENCIA</font></td>
    
   <?php  for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
	 
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $regimen="trimestre";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							echo " <td align=\"center\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" style=\"font-size:9px; font-weight:bold\">".$per."</font></td>";
							
							//calcular las inasistencias
							$sql_asis ="select count(rut_alumno) as conteo_asis from asistencia where rut_alumno='$alumno' and ano='$ano' and fecha between '".$filaPeriodo['fecha_inicio']."' and '".$filaPeriodo['fecha_termino']."'";
							$result_asis=@pg_Exec($conn, $sql_asis);
							$f_asis = @pg_fetch_array($result_asis);
							
							
							$fila1.="<td class=\"subitem\">".$filaPeriodo['dias_habiles']."</td>";
							$fila2.="<td class=\"subitem\">".$f_asis['conteo_asis']."</td>";
							$fila3.="<td class=\"subitem\">".intval($filaPeriodo['dias_habiles']-$f_asis['conteo_asis'])."</td>";
							
							$fila4.="<td class=\"subitem\">".fecha_espanol($txtFECHA)."</td>";
							$fila5.="<td align=\"center\" width=\"80\" class=\"subitem\"><b>A</b></td><td align=\"center\" width=\"80\" class=\"subitem\"><b>M</b></td>";
							$fila6.="<td align=\"center\" height=\"50\">&nbsp;</td><td align=\"center\">&nbsp;</td>";
							
							
						}?>
      </tr>
  <tr>
    <td class="subitem">D&iacute;as trabajados</td>
    <?php echo $fila1 ?>
  </tr>
  <tr>
    <td class="subitem">D&iacute;as asistidos</td>
    <?php echo $fila3 ?>
  </tr>
  <tr>
    <td class="subitem">Inasistencias</td>
    <?php echo $fila2 ?>
  </tr>
  <tr>
    <td class="subitem">Fecha de Entrega Informe</td>
    <?php echo $fila4 ?>
  </tr>
</table>
</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td>
 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
  <tr>
    <td rowspan="2" valign="top" width="212"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px; font-weight:bold">EDAD<br>
      A la entrega del informe</font></td>
    <?php echo $fila5 ?>
    
  </tr>
  <tr>
  <?php echo $fila6 ?>
  </tr>
</table>
</td></tr>
 <tr><td>&nbsp;</td></tr>
  <tr><td>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
  <tr>
    <td colspan="6"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px; font-weight:bold">LATERALIDAD</font></td>
  </tr>
  <tr>
    <td width="19%" align="center" class="subitem">Zurdo</td>
    <td width="6%" align="center"><table width="80%"cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="29%" align="center" class="subitem">Diestro</td>
    <td width="6%" align="center"><table width="80%"cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="33%" align="center" class="subitem">Ambidiestro</td>
    <td width="7%" align="center"><table width="80%"cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  </td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
    <tr><td colspan="3" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><b>ESCALA DE EVALUACIÓN</b></font></td></tr>
    <tr class="subitem"><td>&nbsp;</td><td><b>CONCEPTO</b></td><td><b>DESCRIPCION</b></td></tr>
    <tr class="subitem"><td>L</td><td>Logrado</td><td>Permanencia y continuidad en la conducta</td></tr>
    <tr class="subitem"><td>ML</td><td>Medianamente Logrado</td><td>Manifiesta la conducta con dificultad(con imperfecci&oacute;n)</td></tr>
    <tr class="subitem"><td>ED</td><td>En Desarrollo</td><td>Conducta en proceso de logro</td></tr>
    <tr class="subitem"><td>NL</td><td>No Logrado</td><td>No manifiesta la conducta</td></tr>
     <tr class="subitem"><td>NE</td><td>No Evaluado</td><td>&nbsp;</td></tr>
  </table>
  </td></tr>
         </table>
        <?php 
		  $fila1="";
	   $fila2="";
	     $fila3="";
	   $fila4="";
	     $fila5="";
	   $fila6="";
	   
		} // fin hoja anexa?>
     <? } // fin if escala
   }?>  
      
      
      <? if ($cont_alumnos > 1){  ?>
      <H1 class=SaltoDePagina></H1>
      <? } ?>  
    </td></tr>
  </table>

 
  </td>
  </tr>
 


</table> 
</form><? 
    $contador_salto=0;
}   /// for inicial de alumnos
?>
<script>
function guardaImp(alu){
	var ano =<?php echo $_ANO ?>;
	var curso =<?php echo $cmb_curso ?>;
	var alumno =<?php echo $cadalu ?>;
	var reporte =<?php echo $c_reporte ?>;
	var parametros ="ano="+ano+"&curso="+curso+"&alumno="+alumno+"&reporte="+reporte;
	var cuenta=0;
	var cad_cuenta="";
	for(i=0;i<cuenta;i++){
		cad_cuenta = cad_cuenta+"../";
	}
	
	$.ajax({
		url:cad_cuenta+'cuentaRepo/cuentaRepo2.php',
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
		}
	})
}
</script>
</body>
</html>

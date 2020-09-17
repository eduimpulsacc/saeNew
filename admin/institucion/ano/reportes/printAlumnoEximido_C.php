<? 	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	; 
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	if($curso!=1){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." LIMIT 1 OFFSET 1";
		$rs_curso = @pg_exec($conn,$sql);
		$curso1 = @pg_result($rs_curso,0);
	}else{
		$curso1 = $curso;
	}	
	$ob_ano = new Reporte();
	$ob_ano->ano=$ano;
	$nro_ano=$ob_ano->AnoEscolar($conn);
	
	/*$ob_reporte = new Reporte();
	$ob_reporte -> ano =$ano;
	$rs_ramo = $ob_reporte ->Ramo($conn);*/
	
	for($i=0;$i<$contador;$i++){
		$subsector = ${"ckSUBSECTOR".$i};
		if($subsector!=""){
			if($cod_subsector==""){
				$cod_subsector=$subsector;
			}else{
				$cod_subsector =$cod_subsector.",".$subsector;
			}
		}
	}
	
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
	
	
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


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Alumnos_retirados_$fecha_actual.xls"); 	 
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

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close();
} 


		  
function exportar(){
			window.location='print_alumnos_retirados_C.php?c_curso=<?=$curso?>&xls=1';
			return false;
		  }		  
		  
		  

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<form name="form" method="post" action="print_alumnos_retirados_C.php" target="_blank">

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr> 
                                  <td>
								  
								
                                  <!-- INICIO CUERPO DE LA PAGINA -->
                                  <?

								  
if($curso!=""){	?>
<center>
<table width="100%">
	<tr>
		<td width="47%" align="right">

    	    <div id="capa0">
	          <div align="left">
	            <input name="cerrar" type="button" id="cerrar" class="botonXX" value="CERRAR" onClick="window.close();">
	            </div>
    	    </div>		</td>
	    <td width="53%" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		 <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
										<? }?>
										</td>
	</tr>
</table>
<?
if ($institucion=="770"){ 
    // no muestro los datos de la institucion
    // por que ellos tienen hojas pre-impresas
   echo "<br><br><br><br><br><br><br><br><br><br><br>";   
}else{?>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td rowspan="6"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></td>
        <td height="0" valign="top"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->ins_pal;?></strong></font></td>
      </tr>
      <tr>
        <td height="0"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->direccion;?></strong></font></td>
      </tr>
      <tr>
        <td height="0"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->telefono;?></strong></font></td>
      </tr>
      <tr>
        <td height="0" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="0" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="0" valign="top">&nbsp;</td>
      </tr>
    </table>
<? } ?>
	<table width="100%" border="1">
		<tr>
			<td align="center" colspan="5"class="tableindex">ALUMNOS EXIMIDOS </td>
		</tr>
		<tr align="center">
			<td class="item">CURSO</td>
			<td class="item">SUBSECTOR</td>
			<td class="item">RUT</td>
			<td class="item">ALUMNO</td>
		</tr>
	<? 	$ob_reporte = new Reporte();
		$ob_reporte->ano = $ano;
		$ob_reporte->cod_subsector=$cod_subsector;
		$ob_reporte->curso = $curso;
		$rs_ramo= $ob_reporte->RamoCurso($conn);
	for($v=0;$v<@pg_numrows($rs_ramo);$v++){
		$fila_ramo = @pg_fetch_array($rs_ramo,$v);
			if(trim($curso)=="1"){
				$ob_alumno = new Reporte();
				$ob_alumno->institucion=$institucion;
				$ob_alumno->ano=$ano;
				$ob_alumno->ramo=$fila_ramo['id_ramo'];
				$ob_alumno->curso=1;
				$ob_alumno->nro_ano=$ob_ano->nro_ano;
				$rs_alumno=$ob_alumno->AlumnoEximido($conn);
			}else{
				$ob_alumno = new Reporte();
				$ob_alumno->institucion=$institucion;
				$ob_alumno->ano=$ano;
				$ob_alumno->ramo=$fila_ramo['id_ramo'];
				$ob_alumno->curso=$curso;
				$ob_alumno->nro_ano=$ob_ano->nro_ano;
				$rs_alumno=$ob_alumno->AlumnoEximido($conn);
			}
			
			
			for($x=0;$x<pg_numrows($rs_alumno);$x++){
				$fila_alu= pg_fetch_array($rs_alumno,$x);
				$curso_palabra = CursoPalabra($fila_ramo['id_curso'], 1, $conn); ?>
					<tr align="left">
						<td class="subitem">&nbsp;<?=$curso_palabra?></td>
						<td class="subitem">&nbsp;<?=$fila_ramo['nombre'];?></td>
						<td class="subitem">&nbsp;<?=$fila_alu['rut_alumno'];?></td>
						<td class="subitem">&nbsp;<?=$ob_reporte->tilde($fila_alu['nombres']);?></td>
					</tr>	
			<?	}	
			}?>
			  </table>
			</center>	
			<?	}
		?>
         <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
<!--<table width="100%" border="0">
		  <tr>
		  	<?  
				if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
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
	
<!-- FIN CUERPO DE LA PAGINA --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>          </td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>
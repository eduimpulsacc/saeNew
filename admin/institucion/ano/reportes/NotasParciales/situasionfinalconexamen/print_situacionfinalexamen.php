<? 
require '../../../../../../util/header.inc' ;
require '../../../../../clases/class_Membrete.php';
require '../../../../../clases/class_Reporte.php';
	
	$institucion = $_INSTIT;
 	$ano = $_ANO;
    $id_curso = $_POST['cmb_curso'];
    $id_ramo = $_POST['cmb_ramos'];

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
			 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$id_curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($id_curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$N_REPORTE;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$id_curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	


	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
		$fecha_actual = date('d/m/Y-H:i:s');
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Situacion_Final_Examen_$fecha_actual.xls"); 	 
      }	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE SITUACION FINAL CON EXAMEN</title>

<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 


function exportar(form){
  window.location='print_situacionfinalexamen.php?cmb_curso=<?=$id_curso?>&cmb_ramos=<?=$id_ramo?>&xls=1'
      }
	   
	   
</script>

<style>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
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
<body onLoad="window.print()" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div id="capa0" align="center">
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <table width="650" align="center">
			<tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
			<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
			 <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>
			</td></tr></table>
	
	</td>
	  </tr>
	</table> 
</div>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0"  >
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="10" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>    </td>
    <? } ?>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
    <tr>
    <td class="item"><div align="left"><strong>ASIGNATURA</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? 
	 
	 $sql = "SELECT ramo.id_ramo,sub.nombre FROM ramo 
                   INNER JOIN subsector sub ON sub.cod_subsector = ramo.cod_subsector
                   WHERE ramo.id_ramo = $id_ramo";
	               $result = @pg_Exec($conn, $sql);
	               $fila = @pg_fetch_array($result,0);
	 
	 echo $ob_reporte->tildeM($fila['nombre']); 
	 
	 ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
  </tr>
   <tr>
    <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
    <td class="item"><div align="left"><strong>:</strong></div></td>
    <td class="item"><div align="left">
      <? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);	?>
    </div></td>
  </tr>
  
</table>
<table width="750" border="0" align="center">
  <tr>
    <td class=""><div align="center" style="padding:1px;"></div></td>
  </tr>
  <tr>
    <td class=""><div align="center"><strong>INFORME DE SITUACION FINAL CON EXAMEN</strong> </div></td>
  </tr>
 </table>
<!--INICIO-->

   <table width="750" align="center" border="1" style="border-collapse:collapse">
   <thead>
   <tr class="tablatit2"> 
   <th>N Lista</th>      
   <th>Nombre del Alumno</th>
   <th>1er Sem</th>
   <th>2do Sem</th>
   <th>Nota presentaci&oacute;n</th>
   <th>Ponderaci&oacute;n</th>
  <th>Nota Examen</th>
  <th>Ponderaci&oacute;n</th>
  <th>Nota Final</th>
  <tr>
  </thead>
  <tbody>
 <?
$sql="SELECT id_periodo FROM periodo WHERE id_ano = ".$ano." order by 1;";
 $result = pg_Exec($conn,$sql) or die ("Error");
 
 if(pg_num_rows($result)!=0){
 for( $w = 0 ; $w < pg_num_rows($result) ; $w++){
         $fila[$w] = @pg_fetch_array($result,$w);	 
	   }
    }
 
$sql = "SELECT ma.nro_lista,al.rut_alumno,UPPER(al.ape_pat) as ape_pat, 
UPPER(al.ape_mat) as ape_mat,UPPER(al.nombre_alu) as nombre_alu, 
ra.id_ramo,sub.nombre,no.promedio as prom1,no1.promedio as prom2,
cu.truncado_final,ra.pct_examen,si.nota_examen,ra.truncado_ex_final, cu.truncado_per
FROM matricula ma
INNER JOIN curso cu ON cu.id_curso = ma.id_curso
INNER JOIN ramo ra ON ra.id_curso = ma.id_curso 
INNER JOIN subsector sub ON sub.cod_subsector = ra.cod_subsector
INNER JOIN periodo pe ON pe.id_ano = ma.id_ano and pe.id_periodo=".$fila[0][0]."
INNER JOIN periodo pe1 ON pe1.id_ano = ma.id_ano and pe1.id_periodo=".$fila[1][0]."
INNER JOIN alumno al ON al.rut_alumno = ma.rut_alumno
LEFT JOIN situacion_final si ON si.rut_alumno = al.rut_alumno AND si.id_ramo = ra.id_ramo
INNER JOIN notas$nro_ano no ON no.rut_alumno = al.rut_alumno AND no.id_ramo = ra.id_ramo AND no.id_periodo = pe.id_periodo
INNER JOIN notas$nro_ano no1 ON no1.rut_alumno = al.rut_alumno AND no1.id_ramo = ra.id_ramo AND no1.id_periodo = pe1.id_periodo
WHERE ma.id_curso=".$id_curso." AND ma.id_ano=".$ano." AND ra.id_ramo=".$id_ramo."
ORDER BY 1,3";
$result = pg_Exec($conn,$sql) or die ("Error");


if(pg_num_rows($result)!=0){
	
 for($w=0;$w<pg_numrows($result);$w++){

         $fila = pg_fetch_array($result,$w);
		
         echo "<tr class='item' > 
					<td align='center' >".$fila['nro_lista']."</td>      
					<td>".($fila['ape_pat']).' '.($fila['ape_mat']).' '.($fila['nombre_alu'])."</td>
					<td align='center' >".$fila['prom1']."</td>
					<td align='center' >".$fila['prom2']."</td>";
					
					if($fila['truncado_per']==1){  // aproxima o no aproxima
						echo "<td align='center' >".$notapresentacion=round(($fila['prom1'] + $fila['prom2'])/2)."</td>";
                    }else{
						echo "<td align='center' >".$notapresentacion=intval(($fila['prom1'] + $fila['prom2'])/2)."</td>";
					}
						
						$ponderacion1 = round($notapresentacion * ((100 - $fila['pct_examen'])/100),2);
						
						if($fila['nota_examen']=="" or $fila['nota_examen']==0 or $fila['nota_examen']==NULL){ 
						        
								$nota_examen = 0;
								$ponderacion2 = 0;
								$suma_poderaciones =0;
								
							}else{
								
								$nota_examen = $fila['nota_examen'];
								$ponderacion2 = round($nota_examen * ($fila['pct_examen']/100),2);
								
								if($fila['truncado_ex_final']==1){
									  $suma_poderaciones = round($ponderacion1 + $ponderacion2);
								}else{ 
								      $suma_poderaciones = intval($ponderacion1 + $ponderacion2); 
									  }
							
							}
						if($nota_examen== 0) $nota_examen = "";
						if($ponderacion2== 0) $ponderacion2 = "";
						if($suma_poderaciones== 0) $suma_poderaciones = "";
					echo "<td align='center' >".$ponderacion1."</td>
					<td align='center' >".$nota_examen."</td> 
					<td align='center' >".$ponderacion2."</td>
					<td align='center' >".$suma_poderaciones."</td>
					<tr>";  		 
	         
			   }
           }
 ?>
 
 </tbody>
 </table>
<!--FIN-->
	
	<? 
	if($obs==1){?>		
		<table width="750"  border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		</table>
		<table width="650" height="72" border="0" cellpadding="0" cellspacing="0" align="center">
		 <? if ($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? } ELSE{ ?>
		  <tr>
			<td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } 
		  for($o=1; $o<=($txtOBS-1) ; $o++){
		  ?>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } ?>
	  </table>
		<? } ?>	 
<table width="101%" border="0">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				echo $rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
    <td width="25%" class="item" height="100"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
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
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
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
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
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
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }}?>
  </tr>
</table>
<? if($chk_apo==1){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td width="25%" class="item"> <div align="center">________________________________
<br>
<?="Apoderado";?>
<br>

</div></td>

  </tr>
  
</table>
<? } ?>
<? if ($_INSTIT!=770){ ?>
	<table width="750" align="center">
	<tr>
	<td>
    <br/><br/><br/>
   <? $fecha = date("d/m/Y");  ?>
	  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($ob_membrete->comuna)).",". 
	  fecha_espanol( $fecha) ?></font>
      
	</td>
	</tr>
	</table>
<? } ?>
<? if($colilla==1){	?>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../situacionfinalconexamen/tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $ob_reporte->tildeM($nombre_alumno); ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $Curso_pal?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($prome_colilla>0)
		echo $prome_colilla;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Per&iacute;odo </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
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
    <td><div align="left">&nbsp;</div></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">___________________________</div></td>
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

 <?	} // FIN COLILLA ?>
</body>
</html>

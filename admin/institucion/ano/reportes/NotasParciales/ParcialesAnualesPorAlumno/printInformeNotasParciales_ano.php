<?

	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;

	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	$fecha_ini = $ob_membrete->fecha_inicio;
	$fecha_fin = $ob_membrete->fecha_termino;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$ano_pal = "Año " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	/*$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;*/
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
    $num_periodos = @pg_numrows($resultPeri);
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		$fecha = strftime("%d %m %Y");		
}				  


   if ($institucion==770){
	    // DATOS CURSO //
		//--------------------------------------------------------------------------	
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per, curso.truncado_final ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		$truncado_per = $fila_curso['truncado_per'];
		$truncado_final = $fila_curso['truncado_final'];
		//----------------------------------------------------------------------------
	}	

				  

	if($cb_ok!="Buscar"){
	//	$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Parciales_alumno_$fecha_actual.xls"); 	 
	}


?>
<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	//window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE NOTAS PARCIALES</title>
<STYLE>
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

<body onLoad="window.print()">
<div id="capa0">
<!--<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>-->
</div>
<?
	if (empty($alumno)){
	
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$ob_reporte ->orden =$ck_orden;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);
	
	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos; $cont_paginas++)
{
	
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$suma_prom_curso = 0;
	$cont_prom_curso = 0;
	//$suma_total_total_promedio_final=0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	
	/******************** CON ESTADISTICA ******************************/
	

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza,curso.fecha_inicio,curso.fecha_termino  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$truncado_final = $fila['truncado_final'];
	$finicio_curso = $fila['fecha_inicio'];
	$ftermino_curso = $fila['fecha_termino'];
	
	
	if($ftermino_curso!=''){
		$fecha_fin = $ftermino_curso;
		}
	else{$fecha_fin=$fecha_fin;}
	
?>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:11">
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
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
    <td class="item"><div align="left"><strong>A&Ntilde;O&nbsp;ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left">
      <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
    </div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>PROFESOR(A)&nbsp;JEFE</strong></div></td>
    <td class="item"><div align="left"><strong>:</strong></div></td>
    <td class="item"><div align="left">
      <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?>
    </div></td>
  </tr>
  
</table>
<table width="650" border="0" align="center">
  <tr>
    <td class=""><div align="center"><strong>INFORME DE NOTAS</strong> </div></td>
  </tr>
     <?
	  if ($institucion==770){
	      ?>
		  <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
          </tr>
   <? } ?>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($ano_pal))?></strong></font></div></td>
      </tr>
  
 
</table>
<br />
<table align="center" width="650">
<tr>
<td>


<TABLE width="650" border="1" style="border-collapse:collapse;font-size:10" >
<tr align="center">
<td>cursos</td>
<?
	for($x=0;$x<$num_periodos;$x++){
	$resultPeri = $ob_reporte->TotalPeriodo($conn);
	
?>
<td width="171">
<?
		$fila_periodos=pg_fetch_array($resultPeri,$x);
		echo $fila_periodos['nombre_periodo'];
?>
</td>
<td width="37">Prom.</td>
<? if($chkAPRECIACION==1){?>
<td width="42">Aprec.</td>

<? } ?>
<?
	}
?>
<? if($chkAPRECIACION==1){?>
<td width="42">Prom.<br /> Aprec.</td>
<? } ?>
<td width="65">Promedio Final</td>
</tr>
<?
$ob_reporte->modo_eval="";
$ob_reporte->curso=$curso;
$ob_reporte->alumno=$alumno;
$ob_reporte->nro_ano=$nro_ano;
//$ob_reporte->SubsectorRamo($conn);

$result=$ob_reporte->AlumnoInscrito3($conn);
$result = $ob_reporte->result;
$suma_total_total_promedio_final=0;
$cuenta_promedio=0;

for($i=0;$i < pg_numrows($result);$i++){
	$fila_r= pg_fetch_array($result,$i);
	$cont_gral_religion=0;
	?>
<tr>
<td style="font-size:10px" width="311">
<?
echo $fila_r['nombre'];
?>
</td>
<?
$prom_gral_religion =0;


	for($j=0;$j < $num_periodos;$j++){
		
	$resultPeri = $ob_reporte->TotalPeriodo($conn);
    $fila_periodo = pg_fetch_array($resultPeri,$j);		
	//print_r($fila_periodo);
	$periodo = $fila_periodo['id_periodo'];
	 //"-->".$alumno; 
	 //"-->".$fila_r['id_ramo']; 
	 $ob_reporte->rut_alumno=$alumno;
	 $ob_reporte->ramo=$fila_r['id_ramo'];
	 $ob_reporte->nro_ano=$nro_ano;
	 $ob_reporte->periodo=$periodo;
	 $rs_notas = $ob_reporte->Notas_ano($conn);
	 $fila_n = pg_fetch_array($rs_notas);
	 
	$contador_notas = pg_numrows($rs_notas);
	 $largo_notas = count($contador_notas);
	?>
<td>
<?
$promedio_religion = 0;
$cont_religion=0;
for($n=0;$n<20;$n++){/*
	if($fila_n['nota'.$n.'']>0){
		echo $fila_n['nota'.$n.''];
		if($fila_r['modo_eval']==3){
			$promedio_religion = $promedio_religion + $fila_n['nota'.$n.''];	
			$cont_religion++;
		}
	}	
*/

	if($fila_n["nota".$n] >0 || ( trim($fila_n["nota".$n])=="MB" || trim($fila_n["nota".$n])=="B") || trim($fila_n["nota".$n])=="S" || trim($fila_n["nota".$n])=="I" ){
		
		echo $fila_n["nota".$n];
				
		if($fila_r['modo_eval']==3){
			$promedio_religion = $promedio_religion + $fila_n['nota'.$n.''];	
			$cont_religion++;
		}
		if($fila_r['modo_eval']==2){
			$promedio_religion = $promedio_religion + Conceptual($fila_n['nota'.$n.''],0);	
			$cont_religion++;
		}
	}	
}
?>
</td>
<td align="center"><? 
if($fila_n['promedio']>0 && $fila_r['modo_eval']==1){
	if($truncado_per==1){
		echo $promedio=round($fila_n['promedio']);
	}else{
		echo $promedio=intval($fila_n['promedio']);	
	}
}elseif($fila_r['modo_eval']==2 || $fila_r['modo_eval']==3){
	echo $fila_n['promedio'];
	if($truncado_per==1){
		$prom_religion=round($promedio_religion / $cont_religion);
		if($prom_religion>0)
		{	$cont_gral_religion++;}
	}else{
		$prom_religion=intval($promedio_religion / $cont_religion);	
		//$cont_gral_religion++;
		if($prom_religion>0)
		{	$cont_gral_religion++;}
	}
	
	$prom_gral_religion = $prom_gral_religion + $prom_religion;
	
}
?>
</td>
<? if($chkAPRECIACION==1){?>
<td align="center"><?=$fila_n['notaap'];?>&nbsp;</td>
<? } ?>

<?
 $id_ramo = $fila_r['id_ramo'];

$rs_prm = $ob_reporte->PromedioRamoAlumnoDetalle($conn,$nro_ano,$alumno,$id_ramo);
$suma_promedio=0;
$suma_promedio_ap =0;
$contador_ap=0;
$suma_promedio_total=0;

for($y=0;$y<pg_numrows($rs_prm);$y++){
	$fila_suma_promedio = pg_fetch_array($rs_prm,$y);
	$suma_promedio = $suma_promedio + $fila_suma_promedio['promedio'];
	$suma_promedio_ap = $suma_promedio_ap + $fila_suma_promedio['notaap'];
	if($fila_suma_promedio['notaap']!=""){
		$contador_ap++;
	}
	
}
$contador = pg_numrows($rs_prm);
   }
?>
<? if($chkAPRECIACION==1){
	if($truncado_final==1){
		$suma_promedio_ap = round($suma_promedio_ap/$contador_ap);
	}else{
		$suma_promedio_ap = intval($suma_promedio_ap/$contador_ap);
	}
	
	?>
<td align="center">&nbsp;<?=$suma_promedio_ap;?></td>
<? } ?>
<td align="center">
<?
//echo $truncado_final;
if($truncado_per==1){
	$suma_promedio_total = round($suma_promedio/$contador);
}else{
	$suma_promedio_total = intval($suma_promedio/$contador);
}
if($suma_promedio_total<=0){
	$suma_promedio_total="";
}
if($fila_r['modo_eval']==1 && $suma_promedio_total>0){
	$cuenta_promedio++;
}else{
	//echo "--".$prom_gral_religion;
	//echo "--".$cont_gral_religion;
	$suma_promedio_total = Conceptual(round($prom_gral_religion / $cont_gral_religion),1) ;	
}
	echo $suma_promedio_total;
	
	
	$suma_total_total_promedio_final= $suma_promedio_total + $suma_total_total_promedio_final;
	
?>

<?
	}
?>

</td>

</tr>

<tr>
<td >Promedio General</td>
<td align="center"><? 

    	

	$ob_reporte->ano=$ano;
	$resultPerio = $ob_reporte->TotalPeriodo($conn);
	for($e=0;$e<pg_numrows($resultPerio);$e++){
	$fila_periodoo = pg_fetch_array($resultPerio,$e);	
	
	?>
    <td align="center"><?
	$ob_reporte->modo_eval="";
	$ob_reporte->curso=$curso;
	$ob_reporte->AlumnoInscrito3($conn);
	$result = $ob_reporte->result;
	$suma_prom_g="";
	$suma_count="";
	$suma_prom_ap="";
	for($i=0;$i < pg_numrows($result);$i++){
	$fila_r= pg_fetch_array($result,$i);
    $id_peri = $fila_periodoo['id_periodo'];	
	 $fila_r['id_ramo'];
	 $ob_reporte->rut_alumno=$alumno;
	 $ob_reporte->ramo=$fila_r['id_ramo'];
	 $ob_reporte->nro_ano=$nro_ano;
	 $ob_reporte->periodo=$id_peri;
	 $rs_notas = $ob_reporte->Notas_ano($conn);
	 $fila_n = pg_fetch_array($rs_notas);
	 $promedio=$fila_n['promedio'];
	 $promedio_ap = $fila_n['notaap'];
	 if($promedio!='MB' and $promedio!='B' and $promedio!='S' and $promedio!='I' and $promedio!='EX' and $promedio!=0){
	   $cont_prom_g = pg_numrows($rs_notas);
	   $suma_count=$cont_prom_g+$suma_count;
	   $suma_prom_g = $promedio+$suma_prom_g;
	   $suma_prom_ap = $promedio_ap + $suma_prom_ap;
	   
	 }
 }
	
   
   $total_prom_gral = $suma_prom_g/$suma_count;
   if($truncado_final==1){
     echo round($total_prom_gral);
   }else{
	 echo intval($total_prom_gral); 
   }
   
   $total_prom_ap = $suma_prom_ap/$suma_count;
    ?></td>
    <? if($chkAPRECIACION==1){?>
    <td align="center"><?
    if($truncado_final==1){
     echo round($total_prom_ap);
   }else{
	 echo intval($total_prom_ap); 
   }
	?></td>
    <? } ?>
    <? if($chkAPRECIACION==1 and $e>0){?>
	   	<td>&nbsp;</td>
	<? } ?>
  <td align="center">
  
  <?
  if($e>0){  
	if($truncado_final==1){
	  echo $prome_final=round($suma_total_total_promedio_final/$cuenta_promedio);
	}else{
	  echo $prome_final=intval($suma_total_total_promedio_final/$cuenta_promedio);
	}
  }else{
	  echo "";
  }
  ?>
  
  
  </td>
 
  
	 <?
     }
     ?>
      
</tr>
</TABLE><br>
<table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-size:10">
  <tr>
    <td width="20%">&nbsp;Anotaciones Positivas :</td>
    <td align="left">&nbsp;
<?     $sql_an="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=1 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	   $rs_an =pg_exec($conn,$sql_an);
	   $tot_sql_an = @pg_numrows($rs_an);
  	   $tot_sql_an1 = @pg_numrows($rs_an1);
	   echo $tot_pos = $tot_sql_an+$tot_sql_an1;	
	?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;Anotaciones Negativas :</td>
    <td align="left">&nbsp;
    
    <?
	$sql_anotneg="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=2 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_anotneg =pg_exec($conn,$sql_anotneg);
		 $tot_sql_anotneg = @pg_numrows($rs_anotneg);
		 echo $tot_neg = $tot_sql_anotneg+$tot_sql_anotneg2;
	?>
    </td>
  </tr>

</table>



</td>
</tr>
</table>



<table width="650" border="0" align="center">


<tr>

<?  
	if($ob_config->firma1!=0){
		
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
</tr>
</table>

<table width="650" border="0" align="center">
  <tr>
  
    <td width="25%" class="item" height="100"><? if($institucion==12761){?>
		
<img src='../../FRAN_FORGUIONE.jpg' width='90' height='90' align="left"/>
      
  <? } ?><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
    <?=$ob_reporte->nombre_cargo;?></div></td>
    <? }} ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
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
<table width="650" align="center">
	<tr>
	<td>
    <?
    $fecha = strftime("%d %m %Y");		
    ?>
<br><br><hr />	  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($ob_membrete->comuna)).", ". fecha_espanol($fecha) ?></font>
	</td>
	</tr>
	</table>
<? if ($chkCOLILLA!=1){ ?>
<br>
<table align="center" width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
    </tr>
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($prome_final>0)
		echo $prome_final;
	else
		echo "&nbsp;";
		
		
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
	
	
	$sql="SELECT sum(dias_habiles) FROM periodo WHERE id_ano=".$ano;
	$rs_habiles = pg_exec($conn,$sql);
	$dias_habiles = pg_result($rs_habiles,0);
	$dias_asistidos = $dias_habiles - ($cantidad - $justifica);
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
      <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos * 100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></td>
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
    <td><div align="left"></div></td>
    <td><div align="left"></div></td>
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
	
<? } 
	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
	<?
	} //} // FIN FOR ALUMNOS
 ?>
</body>
</html>

<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');



	$institucion	=$_INSTIT;
	$ano			=$cmbANO;
	$reporte		=$c_reporte;
	$ensenanza		=$cmbENSENANZA;
	$curso =1;
	
	// si viene año, en caso contrario, no hace nada
	if($ano !=0) {
		
	$sql ="SELECT nro_ano FROM ano_Escolar WHERE id_ano=".$ano;
	$rs_ano =pg_exec($conn,$sql);
	$nro_ano = pg_result($rs_ano,0);
	
	
	$sql="SELECT nombre_tipo FROM tipo_ensenanza WHERE cod_tipo=".$ensenanza;
	$rs_ensenanza =pg_exec($conn,$sql);
	$nombre_tipo = pg_result($rs_ensenanza,0);
	
	
	
	/***********periodos*/
	$sql_periodo = "select * from periodo where id_ano = $ano order by id_periodo";
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	/***********periodos*/
	
	if($ensenanza!=0){
	 $sql = "SELECT * from curso where id_ano= $ano  AND ensenanza = $ensenanza ORDER BY ensenanza, letra_curso, grado_curso ";
	}else{
		$nombre_tipo ="TODOS";
	 $sql = "SELECT c.*, t.nombre_tipo as nombre_ensenanza from curso c join tipo_ensenanza t
				on c.ensenanza = t.cod_tipo
				where id_ano= $ano ORDER BY ensenanza, letra_curso, grado_curso";
	
	}
	
 	$result = pg_exec($conn,$sql);
	$conteo = @pg_numrows($result_periodo);
	
		
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	

	function mes_pal($mes){
	if ($mes == 1) $mes_pal = "Ene";
	    if ($mes == 2) $mes_pal = "Feb";
	    if ($mes == 3) $mes_pal = "Mar";
	    if ($mes == 4) $mes_pal = "Abr";
	    if ($mes == 5) $mes_pal = "May";
	    if ($mes == 6) $mes_pal = "Jun";
	    if ($mes == 7) $mes_pal = "Jul";
	    if ($mes == 8) $mes_pal = "Ago";
	    if ($mes == 9) $mes_pal = "Sep";
	    if ($mes == 10) $mes_pal = "Oct";
	    if ($mes == 11) $mes_pal = "Nov";
	    if ($mes == 12) $mes_pal = "Dic";
		 return $mes_pal;	
	}
	
	function final_mes($ano,$mes){
	  $fin = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
	   
	   $fecha_fin_mes = $ano."-".$mes."-".$fin;
	  
	  return $fecha_fin_mes;
	}
	
	
		function diashabiles($ano,$mes){
		   if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
						   $dia=31;
		   }elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
						   $dia=30;
		   }else{
						   $dia=28;
		   }
		   
		   for($i=1;$i<=$dia;$i++){
						   $semana=date("l",mktime(0,0,0,$mes,$i,$ano));
						   if($semana=="Sunday" OR $semana=="Saturday"){
										  $cuentanohabil++;
						   }
		   }
		   //echo "dia-->".$dia."  habil-->".$cuentanohabil;
		  $diashabiles = $dia - $cuentanohabil;
		   return($diashabiles);
                               }

	
	$conteo = @pg_numrows($result_periodo);

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script>
function exportar(form){
	form.target="_blank";
	document.form.action='printInformeAsistenciaPorcentaje_C.php';
	document.form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<style type="text/css">
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<div id="capa0">
  <table width="950" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
      </div></td>
    </tr>
  </table>
  </div>
  <br>
  <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
      <td width="10">&nbsp;</td>
      <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
		<?	if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="41" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
<table width="950" border="0" align="center" >
  <tr>
    <td class="tableindex" align="center">&nbsp;<div align="center">Informe Detalle Asistencia </div>&nbsp;</td>
  </tr>
</table>
<br>
<table width="950" border="0" align="center">
  <tr>
    <td width="181" class="textonegrita">A&Ntilde;O</td>
    <td width="459" class="textosimple">:&nbsp;<?=$nro_ano;?></td>
  </tr>
  <tr>
    <td class="textonegrita">TIPO DE ENSE&Ntilde;ANZA</td>
    <td class="textosimple">:&nbsp;<?=$nombre_tipo;?></td>
  </tr>
</table>
<table width="950" border="1" style="border-collapse:collapse" align="center">
  <tr class="tablatit2-1">
    <td width="200" align="center">Curso</td>
    <?php 
	for($p=0;$p<@pg_numrows($result_periodo);$p++){
		$periodo = @pg_fetch_array($result_periodo,$p);	
		
		$f_inicio = split("-",$periodo['fecha_inicio']);
		$mes_i =  $f_inicio[1];
		if($mes_i <10)
		 $mes_i = str_replace("0","",$mes_i);
		
		$f_termino = split("-",$periodo['fecha_termino']);
		$mes_t =  $f_termino[1];
		if($mes_t <10)
		$mes_t = str_replace("0","",$mes_t);
		
		
		
		for($m = $mes_i; $m <= $mes_t; $m++){
			
			
			echo "<td align='center' width='100'>".mes_pal($m)."</td>";
			$suma =$suma +1;
		}
		
		$suma = $suma+4;
		?>
        
    <td align="center">TOTAL <?php echo $periodo['nombre_periodo'] ?></td>
   <?php }?>
    <td align="center">TOTAL ANUAL</td>
    </tr>
 
  <? 
  
  for($i=0;$i<@pg_numrows($result);$i++){
	  	$fila = pg_fetch_array($result,$i);
		$suma_anio_curso =0;
		
 ?>
 
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['grado_curso']."º-".$fila['letra_curso']; if($ensenanza==0)echo $fila['nombre_ensenanza'];?></td>
   
   <?php 
  //////////inicio calculo 
   for($p=0;$p<@pg_numrows($result_periodo);$p++){
		$periodo = @pg_fetch_array($result_periodo,$p);	
		$suma_periodo =0;
		
		
		$f_inicio = split("-",$periodo['fecha_inicio']);
		$mes_i =  $f_inicio[1];
		if($mes_i <10)
		 $mes_i = str_replace("0","",$mes_i);
		 $dia_i =  $f_inicio[2];
		
		$f_termino = split("-",$periodo['fecha_termino']);
		$mes_t =  $f_termino[1];
		$dia_t =  $f_termino[2];
		if($mes_t <10)
		$mes_t = str_replace("0","",$mes_t);
		
		$cun=0;
		for($m = $mes_i; $m <= $mes_t; $m++){
			$cun++;
		$dias_habiles = diashabiles($nro_ano,$m);

		$fin_mes =  final_mes($nro_ano,$m);

		if($m==$mes_t) 
		{
			$fecha_inicio = $nro_ano."-".$m."-01"; 
			$fecha_termino = $periodo['fecha_termino'];
		}
		elseif($m==$mes_i){
			$fecha_inicio = $periodo['fecha_inicio']; 
			$fecha_termino = $fin_mes;}
		else
		{
			$fecha_inicio = $nro_ano."-".$m."-01";
			$fecha_termino = $fin_mes;
		}
		
		 
		$sql_mes = "SELECT (((count(*)*$dias_habiles) - (SELECT count(*) as conteo FROM asistencia a 
					WHERE a.ano = $ano and a.fecha BETWEEN '$fecha_inicio' 
					and '$fecha_termino' AND a.id_curso = ".$fila['id_curso']." ))*100)/(SELECT ((count(*))*$dias_habiles)
					as total FROM MATRICULA WHERE (ID_ANO = $ano 
					AND ID_CURSO=".$fila['id_curso']." and fecha <= '$fecha_termino' and ID_CURSO>0) 
					and rut_alumno not in (select rut_alumno 
					from matricula where id_curso = ".$fila['id_curso']." 
					and fecha_retiro <= '$fecha_termino'))
					as total FROM MATRICULA 
					WHERE (ID_ANO = $ano AND ID_CURSO=".$fila['id_curso']." 
					and fecha <= '$fecha_termino' and ID_CURSO>0 ) 
					and rut_alumno not in (select rut_alumno 
					from matricula where id_curso = ".$fila['id_curso']." 
					and fecha_retiro <= '$fecha_termino');"

				
		?>
		<td align="right" class="textosimple" >
		<?php 
		 		
		$rs_mes =pg_exec($conn,$sql_mes);
		$conteo_mes = pg_result($rs_mes,0);
		
		$suma_periodo = $suma_periodo+$conteo_mes;
		
		
		//arreglo sumar columnas
		$arreglo[$p][$m][$i] = $conteo_mes;
		
					
		?>
	  <?php echo  number_format($conteo_mes,0,',','.') ?></td>
		<?php }
		$suma_periodo = $suma_periodo/$cun;
		?>
		<td align="right" class="textosimple" bgcolor="#F4F4F4"><?php echo number_format($suma_periodo,0,',','.');
		$suma_anio_curso = $suma_anio_curso+$suma_periodo;
		 ?></td>
   <? }
   ?>
   <td align="right" class="textosimple" bgcolor="#F4F4F4"><?php echo number_format($suma_anio_curso/@pg_numrows($result_periodo),0,',','.') ?></td>
   </tr>
  
  <? } ?>
  <tr class="tablatit2-1">
    <td class="textosimple">TOTAL </td>
     <?php 
  
		  
		  //echo "<td>xx</td>";
		 foreach($arreglo as $dato_periodo => $valor_periodo){
			$suma_periodo_total=0;
	   foreach($valor_periodo as $dato_mes => $valor_mes){
		   $suma_mes = 0;
		   foreach($valor_mes as $dato_curso => $valor_curso){
		   $suma_mes = $suma_mes+$valor_curso;
		     }
			
			  $suma_mes = $suma_mes/count($valor_mes);
		   echo "<td align='right'>".number_format($suma_mes,0,',','.')."</td>";
		   $suma_periodo_total =$suma_periodo_total+ $suma_mes;
		   }
		   
		  $suma_periodo_total = $suma_periodo_total/count($valor_periodo);
	  		echo "<td align='right'>".number_format($suma_periodo_total,0,',','.')."</td>";
			$suma_total = $suma_total+$suma_periodo_total;
	  
		 }

/////////////fin calculo
	  
   ?>
   <td align="right"><?php echo number_format($suma_total/@pg_numrows($result_periodo),0,',','.')?></td>
  </tr>
</table>
<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
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
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
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

<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td class="textosimple">&nbsp;<? echo $ob_membrete->comuna.", ".date("d-m-Y");?></td>
  </tr>
</table>
</div>
</body>
</html>
<? 
	}//fin ano
pg_close($conn);?>
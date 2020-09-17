<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	//print_r($_POST);
	
	$institucion	=$_INSTIT;
	$ano			=$c_ano;
	$reporte		=$c_reporte;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	
	
	$_POSP = 4;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte->curso=$curso;
	$rs_profe = $ob_reporte->ProfeJefe($conn);
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_reporte->ano=$ano;
	$ob_reporte->nro_ano =$ob_membrete->nro_ano;
	
	

	$ob_reporte->ano=$ano;
	$ob_reporte->AnoEscolar($conn);
	$ano2=$ob_reporte->nro_ano;
	
		
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_reporte = new Reporte();
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Alumnos_Tipificados_$Fecha.xls"); 
	}	
	
	
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
	
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../../cortes/12086/estilos.css " rel="stylesheet" type="text/css">

<title>COLEGIOINTERACTIVO.COM</title>
</head>
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
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><div align="left"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></div></td>
    <td class="textosesion"><div align="center">(*)Reporte debe imprimirse de manera horizontal</div></td>
    <td><div align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="71%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="834"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
   <? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
	  
   <? } ?>  
	  
	  
	  	</td>
		</tr>
      </table>
	</td>
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
<table width="71%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">Reporte Alumnos Tipificados</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ano2)) ;?></strong></span></td>
  </tr>
</table>
<br>
<!--/////////////////////////////////////nueva tabla///////////////////////////////-->
<?php if($curso>0){
	
	$sql_alumnos = "select upper(alumno.ape_pat) as a,upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 and matricula.fecha_retiro > '".$fecha."') or (matricula.bool_ar=0)) and nacionalidad=2";
	$sql_alumnos = $sql_alumnos . "order by numero_reporte, a, alumno.ape_mat, alumno.nombre_alu ";
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos);
	
	
	?>
<table width="71%" border="0" align="center">
  <tr>
    <td width="19%" class="textonegrita">Curso</td>
    <td width="3%" class="textonegrita">:</td>
    <td width="78%" class="textosimple">&nbsp;<? echo CursoPalabra($curso,0,$conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">Profesor Jefe</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<?=$ob_reporte->profe_jefe;?></td>
  </tr>
</table>
<br />
<table align="center" width="71%" border="1" cellpadding="0" cellspacing="0">
  <tr class="tablatit2-1">
    <td width="80%" height="27"><div align="center">ALUMNOS</div></td>
    <td width="5%" align="center">SEP</td>
    <td width="5%" align="center">PIE</td>
    <td width="5%" align="center">CHILE SOLIDARIO</td>
    <td width="5%" align="center">PUENTE</td>

  </tr>
  <?
	$ob_cursos = new Reporte();
	$ob_cursos->ano=$ano;
	$ob_cursos->curso=$curso;
	
	
	$rs_alumnos=$ob_cursos->TraeTodosAlumnos($conn);
	
	$num_alumnos=pg_numrows($rs_alumnos);
	$mes = 0;
	for($i=0;$i<$num_alumnos;$i++){
	$fila= pg_fetch_array($rs_alumnos,$i);
	$nombre_alumno=$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_alu'];
	
	$sql_beca ="select bool_bchs, ben_sep,ben_pie, ben_puente from matricula where rut_alumno = ".$fila['rut_alumno']." and id_curso = ".$curso;
	$result_beca =@pg_exec($conn,$sql_beca) or die ("Select falló (Trae Todos): " .$sql_beca);
	$fila_beca= pg_fetch_array($result_beca,0);
	
	if($fila_beca['ben_sep'] == 0 || $fila_beca['ben_sep'] == null){
	$ben_sep = "NO";	
	$sep = 0;
	}else{
	$ben_sep = "SI";
	$sep = 1;
	}
	
	
	if($fila_beca['ben_pie'] == 0 || $fila_beca['ben_pie'] == null){
	$ben_pie = "NO";	
	$pie=0;
	}else
	{$ben_pie = "SI";
	$pie=1;}
		
	if($fila_beca['ben_puente'] == 0 || $fila_beca['ben_puente'] == null){
	$ben_puente = "NO";	
	$puente=0;
	}else{$ben_puente = "SI";
	$puente=1;
	}
	
	if($fila_beca['bool_bchs'] == 0 || $fila_beca['bool_bchs'] == null){
	$bool_bchs = "NO";	
	$bchs =0;
	}else{$bool_bchs = "SI";
	$bchs =1;
	}
	
	$suma_sep = $suma_sep + $sep;
	$suma_pie = $suma_pie + $pie;
	$suma_bchs = $suma_bchs + $bchs;
	$suma_puente = $suma_puente + $puente;
	
	?>
  <tr>
    <td class="textosimple"><? echo strtoupper($nombre_alumno);?></td>
    <td align="center" class="textosimple"><?php echo $ben_sep ?></td>
    <td align="center" class="textosimple"><?php echo $ben_pie ?></td>
    <td align="center" class="textosimple"><?php echo $bool_bchs ?></td>
    <td align="center" class="textosimple"><?php echo $ben_puente ?></td>
	
		
	
  </tr>
  
  <? 
  
  }?>
 <tr>
    <td class="textosimple"><strong>TOTAL</strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_sep ?></strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_pie ?></strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_bchs ?></strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_puente ?></strong></td>
  </tr>
</table>

<?php }
	//si elegi todos los cursos
	else{
		
	$ob_curso = new MotorBusqueda();
	$ob_curso->ano=$ano;
	$result=$ob_curso->curso($conn);
	
	
	
	?>
<table width="71%" border="1" align="center">
  <tr class="tablatit2-1">
    <td width="30%" valign="middle">Curso</td>
    <td width="30%" valign="middle">Profesor Jefe</td>
    <td width="5%" align="center" valign="middle">SEP</td>
    <td width="5%" align="center" valign="middle">PIE</td>
    <td width="5%" align="center" valign="middle">CHILE SOLIDARIO</td>
    <td width="5%" align="center" valign="middle">PUENTE</td>
    <td width="5%" align="center" valign="middle">TOTAL</td>
  </tr>
<?php   for($i=0;$i<@pg_numrows($result);$i++)
		{
			
		$suma_curso = 0;
		$fila = pg_fetch_array($result,$i);
		$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		$ob_reporte->curso=$fila['id_curso'];
		$rs_profe = $ob_reporte->ProfeJefe($conn);
		
		
	$sql_beca ="select sum(bool_bchs) as bool_bchs, sum(ben_sep) as ben_sep, sum(ben_pie) as ben_pie, sum(ben_puente) as ben_puente from matricula where id_curso = ".$fila['id_curso'].";";
	$result_beca =@pg_exec($conn,$sql_beca) or die ("Select falló (Trae Todos): " .$sql_beca);
	$fila_beca= pg_fetch_array($result_beca,0);
		
	$suma_curso = $fila_beca['ben_sep']+$fila_beca['ben_pie']+$fila_beca['bool_bchs']+$fila_beca['ben_puente'];
	
	$suma_sep = $suma_sep + $fila_beca['ben_sep'];
	$suma_pie = $suma_pie + $fila_beca['ben_pie'];
	$suma_bchs = $suma_bchs + $fila_beca['bool_bchs'];
	$suma_puente = $suma_puente + $fila_beca['ben_puente'];
	
		
		?>
  <tr class="textosimple">
    <td><?=$Curso_pal?></td>
    <td><?=$ob_reporte->profe_jefe;?></td>
    <td align="center"><?php echo intval($fila_beca['ben_sep']) ?></td>
    <td align="center"><?php echo intval($fila_beca['ben_pie']) ?></td>
    <td align="center"><?php echo intval($fila_beca['bool_bchs']) ?></td>
    <td align="center"><?php echo intval($fila_beca['ben_puente']) ?></td>
    <td align="center"><?php echo $suma_curso ?></td>
  </tr>
  <?php }
  
  $total_becas = $suma_sep+$suma_pie+$suma_bchs+$suma_puente;
  
  ?>
  <tr class="textosimple">
    <td colspan="2"><strong>TOTAL</strong></td>
     <td align="center" class="textosimple"><strong><?php echo $suma_sep ?></strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_pie ?></strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_bchs ?></strong></td>
    <td align="center" class="textosimple"><strong><?php echo $suma_puente ?></strong></td>
    <td align="center"><strong><?php echo $total_becas ?></strong></td>
  </tr>
</table>
<p>
  <?php }?>
  <br />
  <br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?></p>
<p>&nbsp;</p>
</body>
</html>

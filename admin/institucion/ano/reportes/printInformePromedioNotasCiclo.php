<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){
	window.close()
}

</script> 

<?

require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	$institucion	= $_INSTIT;
     $ano			= $_ANO;
	//$curso			= $cmb_curso;
	
	$reporte		= $c_reporte;
	$ciclo			= $cmbCICLO;
	$periodo = $cmb_periodo;
	//$ramo 			= $select_ramos;
	$_POSP = 5;
	$_bot = 9;
	

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/************** CICLOS *****************/
	$ob_membrete->ciclo= $ciclo;
	$ob_membrete->Ciclo($conn);
	
	/*************** RAMO ********************/
/*	$ob_membrete->ramo= $ramo;
	$ob_membrete->Asignatura($conn);*/
	
	$sql ="SELECT id_curso FROM ciclos WHERE id_ciclo=".$ciclo;
	$rs_curso = pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);
	
	/***************** PERIODO *****************************/
	$sql ="SELECT id_periodo, nombre_periodo FROM periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
	$rs_perido = pg_exec($conn,$sql);
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
$sum_pc1=0;
$sum_pc2=0;
$sum_pc3=0;
$sum_pc4=0;	
$c_ramo1=0;
$pc1=0;
	$pc2=0;
	$pc3=0;
	$pc4=0;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>Sistema de Evaluacion Docente</title>
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

</head>

<body>
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR" /></td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    </tr>
  </table>
</div>
<br />
<?php  $result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0); ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($fila_foto['nombre_instit']));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top" >
        <td width="125" align="center"><?
		/*$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);*/
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../".$d."menu/imag/logo.gif' >";
	  }?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">REPORTE POR CICLOS</div></td>
  </tr>
  <tr>
    <td align="center" ><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($periodo_pal))?></strong></font></div></td>
  </tr>

</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&Ntilde;O</strong></font></div></td>
    <td width="8"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td width="543"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CICLO</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo strtoupper($ob_membrete->nombre_ciclo)?></font></div></td>
  </tr>
</table>
<br />

<?php 
 $arr_notas = array(); 
 $sql_ramos = "select distinct(su.cod_subsector),su.nombre
from ramo
inner join subsector su on ramo.cod_subsector=su.cod_subsector
inner join ciclos on ciclos.id_curso = ramo.id_curso
where id_ciclo= $ciclo order by su.cod_subsector asc 
";
$rs_ramos = pg_exec($conn,$sql_ramos);
$sum_promedio=0;

//armo arreglo de notas antes de mostrar
for($x=0;$x<pg_numrows($rs_ramos);$x++){
	$fila_arr = pg_fetch_array($rs_ramos,$x);
	
	
	$ob_reporte->nro_ano = $nro_ano; 
	$ob_reporte->periodo=$periodo;
	$ob_reporte->id_ciclo = $ciclo;
	$ob_reporte->cod_subsector =$fila_arr['cod_subsector'];
	$rs_promedios = $ob_reporte->promedioCiclos($conn); 
	
	$arr_notas['conta'][$fila_arr['cod_subsector']]=pg_numrows($rs_promedios);
	
	$sum_promedio= $sum_promedio+pg_numrows($rs_promedios);
	
	for($s=0;$s<pg_numrows($rs_promedios);$s++){
		@$fila_sub = pg_fetch_array($rs_promedios,$s);
		
		$fila_sub['promedio'] = intval($fila_sub['promedio']);
		
		
	
	if($fila_sub['promedio'] >= 10 && $fila_sub['promedio'] <=39 ){
		$arr_notas[$fila_sub['cod_subsector']]['r1'][]=$fila_sub['promedio'];
	}
	else if($fila_sub['promedio'] >= 40 && $fila_sub['promedio'] <=49 ){
		$arr_notas[$fila_sub['cod_subsector']]['r2'][]=$fila_sub['promedio'];
	}
	if($fila_sub['promedio'] >= 50 && $fila_sub['promedio'] <=59 ){
		$arr_notas[$fila_sub['cod_subsector']]['r3'][]=$fila_sub['promedio'];
	}
	if($fila_sub['promedio'] >= 60 && $fila_sub['promedio'] <=70 ){
		$arr_notas[$fila_sub['cod_subsector']]['r4'][]=$fila_sub['promedio'];
	}
	}
}
?>




<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr >
    <td colspan="2" align="center" class="tableindex" >Asignatura</td>
    <td colspan="2" align="center" class="tableindex" style="text-align: center" ><1 - 3.9></td>
    <td colspan="2" align="center" class="tableindex" style="text-align: center"><4 - 4.9></td>
    <td colspan="2" align="center" class="tableindex" style="text-align: center"><5 - 5.9></td>
    <td colspan="2" align="center" class="tableindex" style="text-align: center">&lt;6 - 7.0&gt;</td>
  </tr>
  <?php $sql_ramo = "select distinct(su.cod_subsector),su.nombre
from ramo
inner join subsector su on ramo.cod_subsector=su.cod_subsector
inner join ciclos on ciclos.id_curso = ramo.id_curso
where id_ciclo= $ciclo and ramo.modo_eval=1 order by su.cod_subsector asc 
";
$rs_ramo = pg_exec($conn,$sql_ramo);


for($r=0;$r<pg_numrows($rs_ramo);$r++){
	$fila_ramo = pg_fetch_array($rs_ramo,$r);

?>
  <tr >
    <td width="43" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $fila_ramo['cod_subsector'] ?>&nbsp;</font></td>
    <td width="230" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $fila_ramo['nombre'] ?></font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $cont1=@count($arr_notas[$fila_ramo['cod_subsector']]['r1']);$sum_pc1= $sum_pc1+$cont1; ?></font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php 
	
	echo ($arr_notas['conta'][$fila_ramo['cod_subsector']]>0)?round((100*@count($arr_notas[$fila_ramo['cod_subsector']]['r1']))/@$arr_notas['conta'][$fila_ramo['cod_subsector']],1):0;
	
	?></font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $cont2=@count($arr_notas[$fila_ramo['cod_subsector']]['r2']);$sum_pc2= $sum_pc2+$cont2; ?></font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
      <?php 
	
	echo ($arr_notas['conta'][$fila_ramo['cod_subsector']]>0)?round((100*@count($arr_notas[$fila_ramo['cod_subsector']]['r2']))/@$arr_notas['conta'][$fila_ramo['cod_subsector']],1):0;
	
	?>
    </font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $cont3=@count($arr_notas[$fila_ramo['cod_subsector']]['r3']);$sum_pc3= $sum_pc3+$cont3; ?></font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
      <?php 
	
	echo ($arr_notas['conta'][$fila_ramo['cod_subsector']]>0)?round((100*@count($arr_notas[$fila_ramo['cod_subsector']]['r3']))/@$arr_notas['conta'][$fila_ramo['cod_subsector']],1):0;
	
	?>
    </font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $cont4=@count($arr_notas[$fila_ramo['cod_subsector']]['r4']);$sum_pc4= $sum_pc4+$cont4; ?></font></td>
    <td width="40" align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
      <?php 
	
	echo ($arr_notas['conta'][$fila_ramo['cod_subsector']]>0)?round((100*@count($arr_notas[$fila_ramo['cod_subsector']]['r4']))/@$arr_notas['conta'][$fila_ramo['cod_subsector']],1):0;
	
	?>
    </font></td>
    
    
  </tr>
  <?php }?>
  <tr >
    <td colspan="2" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">TOTALES</font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
    <?php echo number_format($sum_pc1,0,',','.') ?>
    </font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo round((100*$sum_pc1)/$sum_promedio,1); ?></font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo number_format($sum_pc2,0,',','.') ?></font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo round((100*$sum_pc2)/$sum_promedio,1); ?></font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo number_format($sum_pc3,0,',','.') ?></font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo round((100*$sum_pc3)/$sum_promedio,1); ?></font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo number_format($sum_pc4,0,',','.') ?></font></td>
    <td align="right" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo round((100*$sum_pc4)/$sum_promedio,1); ?></font></td>
  </tr>
</table>

<?php  
/*echo "<pre>";
var_dump($arr_notas); 
echo "</pre>";*/
?>
<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 $chk_apo=0;
		 include("firmas/firmas.php");?>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td><div align="left" class="item">
      <? 
	 
		echo $fecha=$ob_reporte->fecha_actual();
//		echo $ob_reporte->date;
	 ?>
    </div></td>
  </tr>
</table>
<p><br />
</p>
</body>
</html>
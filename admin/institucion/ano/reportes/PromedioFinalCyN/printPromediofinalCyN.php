
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

require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');

	$institucion	= $_INSTIT;
   	$ano			= $cmbANO;
	$periodo		= $cmbPERIODO;
	$ciclo	 		= $cmbCICLO;
	$reporte		= $c_reporte;
	$nivel			= $cmbNIVEL;
	$_POSP = 5;
	$_bot = 9;
	$curso=1;
	
	
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/************** CICLOS *****************/
	$ob_membrete->ciclo= $ciclo;
	$ob_membrete->Ciclo($conn);
	
	
	/*************** NIVEL *****************/
	if($opcion==2){
		$ob_membrete->idnivel= $nivel;
		$ob_membrete->nivel($conn);
	}
	
	/************** PERIODO ****************/
	$ob_membrete->ano= $ano;
	$ob_membrete->periodo= $periodo;
	$ob_membrete->periodo($conn);
	

	/***************CURSO NIVEL *************/
	if($opcion==2){
		$sql=" SELECT c.id_curso,c.grado_curso ||'-'|| c.letra_curso ||' '|| te.nombre_tipo as cursos  FROM curso c INNER JOIN tipo_ensenanza te ON c.ensenanza=te.cod_tipo WHERE c.id_ano=".$ano." AND c.id_nivel=".$nivel."   ORDER BY cursos ASC;";
		$rs_curso = pg_exec($conn,$sql);
	}else{ 
		$sql=" SELECT c.id_curso,c.grado_curso ||'-'|| c.letra_curso ||' '|| te.nombre_tipo as cursos  
 FROM curso c INNER JOIN tipo_ensenanza te ON c.ensenanza=te.cod_tipo 
 INNER JOIN ciclos ci ON ci.id_curso=c.id_curso
 WHERE c.id_ano=".$ano." AND ci.id_ciclo=".$ciclo."
 ORDER BY cursos ASC";
 $rs_curso = pg_exec($conn,$sql);
	}
	
	/***************** SUBSECTORES POR NIVEL****************/
	if($opcion==1){
		$sql ="SELECT DISTINCT s.nombre, r.cod_subsector, r.id_orden
 FROM curso c INNER JOIN ramo r ON c.id_curso=r.id_curso
 INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
 INNER JOIN ciclos ci ON ci.id_curso=c.id_curso
 WHERE c.id_ano=".$ano." AND ci.id_ciclo=".$ciclo."
 ORDER BY r.id_orden ASC";
 //if($_PERFIL==0)echo $sql;
 
 		$rs_subsector = pg_exec($conn,$sql);
 		$num_subsectores = pg_numrows($rs_subsector);	
	}else{
		$ob_reporte ->ano=$ano;
		$ob_reporte->nivel=$nivel;
		$rs_subsector = $ob_reporte->SubsectorNivel($conn);
		$num_subsectores = pg_numrows($rs_subsector);	
	}
	
	$sql ="SELECT id_curso FROM ciclos WHERE id_ciclo=".$ciclo;
	$rs_cursos = pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);
	
	
	
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>Sistema de Administracion Escolar</title>
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
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top" >
        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
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
    <td class="tableindex"><div align="center">REPORTE POR <? if($opcion==1) echo "CICLOS"; else echo "NIVELES";?></div></td>
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
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? if($opcion!=2) echo "CICLO"; else echo "NIVEL";?></strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? if($opcion!=2) echo strtoupper($ob_membrete->nombre_ciclo); else echo strtoupper($ob_membrete->nombre_nivel);;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PERIODO</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ob_membrete->nombre_periodo;?></font></div></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="2" width="20" class="tablatit2-1">N&ordm;</td>
    <td width="170" rowspan="2" class="tablatit2-1">CURSOS</td>
    <td colspan="<? echo $num_subsectores+2 ?>" class="tablatit2-1"><div align="center">SUBSECTORES</div></td>
  </tr>
  <tr>
    <?
		 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($rs_subsector,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		if($modo_eval==1) $contador_promedio++;
    ?>
    <td ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>
      <? InicialesSubsector($subsector_curso) ?>
    </strong></font></div></td>
    <? }?>
    <td align="center" ><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Final</strong></font></td>
    
  </tr>
  <? for($i=0;$i<pg_numrows($rs_curso);$i++){
	  		$fila_c = pg_fetch_array($rs_curso,$i);
			$prom_gral=0;
			$contador=0;
	?>
  <tr>
    <td>&nbsp;</td>
    <td class="item"><?=$fila_c['cursos'];?></td>
    <?
   for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($rs_subsector,$cont);	
		$cod_subsector = $fila_sub['cod_subsector'];
		$sql=" SELECT round(avg(cast(promedio as integer))) as prom 
 FROM notas$nro_ano nt INNER JOIN ramo r ON nt.id_ramo=r.id_ramo 
WHERE r.id_curso=".$fila_c['id_curso']." AND r.cod_subsector=".$cod_subsector." AND nt.id_periodo=".$periodo." AND promedio not in ('MB','B','S','I','0',' ')";
		$rs_promedio = pg_exec($conn,$sql);
		$promedio = pg_Result($rs_promedio,0);
		if($cod_subsector!=13 && ($promedio > 0 && $promedio!=0)){
			$prom_gral = $prom_gral + $promedio;
			$contador++;
		}
    ?>
    <td align="center" class="item">&nbsp;<?=$promedio;?></td>
    <? }
	
		$prom_gral = round($prom_gral / $contador,0);
	?>
    <td align="center" class="item">&nbsp;<?=$prom_gral;?></td>
  </tr>
  
  <? } ?>
 
</table>
<br />
<br />
 <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 $concur=0;
		 include("../firmas/firmas.php");?>
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
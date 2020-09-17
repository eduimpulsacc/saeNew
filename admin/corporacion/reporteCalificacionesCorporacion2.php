<?php require('../../util/header.inc');

$corporacion = $_CORPORACION;
$empleado = $_EMPLEADO;
//echo $cantidad;
//echo "<br/>";
//echo $rdb; 
//echo "<br/>";
//echo $ensenanza;
//echo "<br/>";
$sql = "SELECT nombre_corp FROM corporacion WHERE num_corp=".$corporacion;
$rs_corp = @pg_exec($conn,$sql);
$nombre_corp = @pg_result($rs_corp,0);

$sql ="SELECT a.nombre_emp || cast(' ' as varchar) || a.ape_pat || cast(' ' as varchar) || a.ape_mat as nombre FROM empleado a WHERE rut_emp=".$empleado;
$rs_emp = @pg_exec($conn,$sql);
$nombre_emp = @pg_result($rs_emp,0);


/******** TIPO DE ENSENANZA **********************/
$sql = "SELECT DISTINCT a.cod_tipo, b.nombre_tipo FROM tipo_ense_inst a INNER JOIN tipo_ensenanza b ON ";
$sql.="a.cod_tipo=b.cod_tipo WHERE  a.rdb IN (select RDB from corp_instit WHERE num_corp=$_CORPORACION) ";
if($rdb!=0){
	$sql.=" AND a.rdb=".$rdb;
}
if($ensenanza!=0){
	$sql.= " AND a.cod_tipo=".$ensenanza;
}
$rs_ensenanza = @pg_exec($conn,$sql);
//echo $sql;
//echo "tipo ensenanza ".$cuenta_ense = @pg_numrows($rs_ensenanza);
//*************************************************/
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
/*echo "sub".*/$ctasubtotal++;
						
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo6 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo11 {font-size: 10px}
-->
</style>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
</head>

<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="Submit" type="submit" class="boton02" value="CANCELAR" onClick="window.close()" /></td>
    <td><div align="right"><input name="Submit2" type="button" class="boton02" value="IMPRIMIR" onClick="imprimir();"/>
    </div></td>
  </tr>
</table>
</div>
<br />
<table width="800" align="center" border="0" cellpadding="3">
  <tr>
    <td width="155"><span class="Estilo5">Corporacion</span></td>
    <td width="8"><span class="Estilo5">:</span></td>
    <td width="465" ><span class="Estilo9">
      <?=$nombre_corp;?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo5">Sostenedor</span></td>
    <td><span class="Estilo5">:</span></td>
    <td><span class="Estilo9"><?=$nombre_emp;?></span></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="center"><span class="Estilo6">INFORME DE CALIFICACIONES </span></div></td>
  </tr>
</table>
<br />

<? if($rdb!=0 and $ensenanza!=0){?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<?
		$sql = "SELECT nombre_instit FROM institucion INNER JOIN corp_instit ON institucion.rdb=corp_instit.rdb WHERE corp_instit.num_corp=".$corporacion." AND institucion.rdb=".$rdb."";
		$rs_instit = @pg_exec($conn,$sql);
		$instit=pg_result($rs_instit,0);
	?>
	<td width="740">NOMBRE INSTITUCION : <?=$instit;?></td>
    
 </tr> 
</table>
<br/>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<?
		$fila_en=pg_fetch_array($rs_ensenanza,0);
	?>
	<td width="740">TIPO ENSEÑANZA : <?=$fila_en['nombre_tipo'];?></td>
    
 </tr> 
</table>
<br/>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td>Ramos/Cursos</td>
	<? 
	
		for ($j = 0; $j <$cantidad; $j++){ 
		  $valor = strstr($arreglo[$j],"_");
		  $grado_prueba = substr($valor,1);
	//echo  $arreglo[$j];
		  
	 $sql="SELECT DISTINCT d.grado_curso,d.letra_curso FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
 	 $sql.=" INNER JOIN ano_escolar c ON (c.id_institucion=b.rdb) INNER JOIN curso d ON (d.id_ano=c.id_ano) ";
	 $sql.=" WHERE b.num_corp=$corporacion AND d.ensenanza=$ensenanza AND c.id_institucion=$rdb AND d.grado_curso=$grado_prueba ";	         	  
	/* $sql="select distinct grado_curso,letra_curso from curso where ensenanza=$ensenanza and grado_curso=$grado_prueba";  */       
	 $rs_curso=pg_exec($conn,$sql);
		
	for($x=0;$x<pg_numrows($rs_curso);$x++){
		$fila_curso=pg_fetch_array($rs_curso,$x);	 
		
	?>
	<td align="center"><?=$fila_curso['grado_curso']."".$fila_curso['letra_curso']; ?></td>
	<? }
	
	}?>
</tr>
<? for($i=0;$i<$total;$i++){
			$valor=$_POST["chek".$i];
			$subsector_curso= strtok($valor,"_"); //----nombre asignatura
	//echo "<br/>";
			$cod = strstr($valor,"_");	
	 	   $cod_tipo = substr($cod,1);  //----cod asignatura
	// echo "<br/>";
		
				
	/* $sql_curso="SELECT DISTINCT d.grado_curso,letra_curso,ensenanza FROM institucion a INNER JOIN corp_instit b ";
	 $sql_curso.=" ON (a.rdb=b.rdb) INNER JOIN ano_escolar c ON(a.rdb=c.id_institucion) INNER JOIN curso d ";
	 $sql_curso.=" ON (c.id_ano=d.id_ano) INNER JOIN ramo e ON (e.id_curso=d.id_curso) WHERE b.num_corp=$corporacion";
	 $sql_curso.=" AND b.rdb=$rdb AND e.cod_subsector=$cod_tipo AND d.ensenanza=$ensenanza";
	 $resp= pg_exec($conn,$sql_curso);
	 $cursos=pg_fetch_array($resp,$i);*/
		?>
<tr>
    <? if($subsector_curso==NULL){?>
    
    <? }else{?>
	<td><? InicialesSubsector($subsector_curso)?>
    </td>
    
	<? for($e=0;$e<5;$e++){?>
	<td align="center"><?="notas".$e?></td>
	<? }?>
    <? }?>
</tr>
<? }?>
</table>
<? }?>


<? if($rdb!=0 and $ensenanza==0){ ///------------------------REVISAR ESTE CASO-----------------?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<?
		$sql = "SELECT nombre_instit FROM institucion INNER JOIN corp_instit ON institucion.rdb=corp_instit.rdb WHERE corp_instit.num_corp=".$corporacion." AND institucion.rdb=".$rdb."";
		$rs_instit = @pg_exec($conn,$sql);
		$instit=pg_result($rs_instit,0);
	?>
	<td width="740">NOMBRE INSTITUCION : <?=$instit;?></td>
    
 </tr> 
</table>
<br/>
<?   
  for ($k = 0; $k <$cantidad; $k++){ 
		  $var=0;
		  $valor = strtok($arreglo[$k],"_");
	if($var!=$valor){	
	      $var=$valor;  
		  $sql="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo from tipo_ense_inst, tipo_ensenanza ";
		  $sql.=" where tipo_ense_inst.cod_tipo = tipo_ensenanza.cod_tipo and tipo_ense_inst.rdb=$rdb and ";
		  $sql.=" tipo_ense_inst.cod_tipo=$valor";
	  	  $resp=pg_exec($conn,$sql);
		  //echo $arreglo[$k];
		  $fila=pg_fetch_array($resp,$y);
		  $codtipo=$fila['cod_tipo'];
	?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	
	<td width="740">TIPO ENSEÑANZA : <?=$fila['nombre_tipo'];?></td>
    
 </tr> 
</table>

<br/>

<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td>Ramos/Cursos</td>
<? }?>
	<? 
			
	//	for ($j=0;$j<$cantidad;$j++){ 
		    $valor2 = strstr($arreglo[$k],"_");
		    $grado_prueba = substr($valor2,1);
		//echo   $arreglo[$j];
		  
		  
		$sql="SELECT DISTINCT d.grado_curso,d.letra_curso FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
 		$sql.=" INNER JOIN ano_escolar c ON (c.id_institucion=b.rdb) INNER JOIN curso d ON (d.id_ano=c.id_ano) ";
	    $sql.=" WHERE b.num_corp=$corporacion AND d.ensenanza=$codtipo AND c.id_institucion=$rdb AND d.grado_curso=$grado_prueba ";	         
	 	$rs_cur=pg_exec($conn,$sql);
		
	for($xx=0;$xx<pg_numrows($rs_cur);$xx++){
		$filacurso=pg_fetch_array($rs_cur,$xx);	 
		
	?>
	<td align="center"><?="aki".$filacurso['grado_curso']."".$filacurso['letra_curso']; ?></td>
	<? }
	
//	}?>
</tr>
<? for($i=0;$i<$total;$i++){
			$valor=$_POST["chek".$i];
			$subsector_curso= strtok($valor,"_"); //------nombre asig
			$cod = strstr($valor,"_");	
	    	$cod_tipo = substr($cod,1);   		  //-------cod_asig
		
				
	/* $sql_curso="SELECT DISTINCT d.grado_curso,letra_curso,ensenanza FROM institucion a INNER JOIN corp_instit b ";
	 $sql_curso.=" ON (a.rdb=b.rdb) INNER JOIN ano_escolar c ON(a.rdb=c.id_institucion) INNER JOIN curso d ";
	 $sql_curso.=" ON (c.id_ano=d.id_ano) INNER JOIN ramo e ON (e.id_curso=d.id_curso) WHERE b.num_corp=$corporacion";
	 $sql_curso.=" AND b.rdb=$rdb AND e.cod_subsector=$cod_tipo AND d.ensenanza=$ensenanza";
	 $resp= pg_exec($conn,$sql_curso);
	 $cursos=pg_fetch_array($resp,$i);*/
		?>
<tr>
    <? if($subsector_curso==NULL){?>
    
    <? }else{?>
	<td><? InicialesSubsector($subsector_curso)?>
    </td>
    
	<? for($e=0;$e<5;$e++){?>
	<td align="center"><?="notas".$e?></td>
	<? }?>
    <? }?>
</tr>
<? }?>
</table>
<br/>
<?  }?>
<? }?>

<? if($rdb==0 and $ensenanza!=0){?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<?		    
		$nombre=pg_fetch_array($rs_ensenanza,0);
		//$cod=$nombre['cod_tipo'];
	?>
	<td width="740">TIPO ENSEÑANZA : <?=$nombre['nombre_tipo'];?></td>
    
 </tr> 
</table>
<br/>
<?
	$sql="SELECT DISTINCT a.nombre_instit, b.rdb FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
	$sql.=" INNER JOIN ano_escolar c ON (c.id_institucion=b.rdb) INNER JOIN curso d ON (d.id_ano=c.id_ano) ";
	$sql.=" WHERE b.num_corp=$corporacion AND d.ensenanza=$ensenanza ";
	$rs_instit=pg_exec($conn,$sql);
	for($y=0;$y<pg_numrows($rs_instit);$y++){ 
	    $fila=pg_fetch_array($rs_instit,$y);
		$id_instit=$fila['rdb'];
	?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	
	<td width="740">NOMBRE INSTITUCION:	  <?=$fila['nombre_instit'];?></td>
    
 </tr> 
</table>
<br/>

<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td>Ramos/Cursos</td>
	<? 
	
		for ($j=0;$j<$cantidad;$j++){ 
		  $valor2 = strstr($arreglo[$j],"_");
		  $grado_prueba = substr($valor2,1);
		// echo  $arreglo[$j];
		  
	    $sql="SELECT DISTINCT d.grado_curso,d.letra_curso FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
 		$sql.=" INNER JOIN ano_escolar c ON (c.id_institucion=b.rdb) INNER JOIN curso d ON (d.id_ano=c.id_ano) ";
	    $sql.=" WHERE b.num_corp=$corporacion AND d.ensenanza=$ensenanza AND c.id_institucion=$id_instit AND ";
 		$sql.=" d.grado_curso=$grado_prueba ";	         	  
	// $sql="select distinct grado_curso,letra_curso from curso where ensenanza=$ensenanza and grado_curso=$arreglo[$j]";	         
	 	$rs_cur=pg_exec($conn,$sql);
		
	for($xx=0;$xx<pg_numrows($rs_cur);$xx++){
		$filacurso=pg_fetch_array($rs_cur,$xx);	 
		
	?>
	<td align="center"><?=$filacurso['grado_curso']."".$filacurso['letra_curso']; ?></td>
	<? }
	
	}?>
</tr>
<? for($i=0;$i<$total;$i++){
			$valor=$_POST["chek".$i];
			$subsector_curso= strtok($valor,"_"); //-------nombre asig
			$cod = strstr($valor,"_");	
	    	$cod_tipo = substr($cod,1);			 //------cod_asig	
		
				
	/* $sql_curso="SELECT DISTINCT d.grado_curso,letra_curso,ensenanza FROM institucion a INNER JOIN corp_instit b ";
	 $sql_curso.=" ON (a.rdb=b.rdb) INNER JOIN ano_escolar c ON(a.rdb=c.id_institucion) INNER JOIN curso d ";
	 $sql_curso.=" ON (c.id_ano=d.id_ano) INNER JOIN ramo e ON (e.id_curso=d.id_curso) WHERE b.num_corp=$corporacion";
	 $sql_curso.=" AND b.rdb=$rdb AND e.cod_subsector=$cod_tipo AND d.ensenanza=$ensenanza";
	 $resp= pg_exec($conn,$sql_curso);
	 $cursos=pg_fetch_array($resp,$i);*/
		?>
<tr>
    <? if($subsector_curso==NULL){?>
    
    <? }else{?>
	<td><? InicialesSubsector($subsector_curso)?>
    </td>
    
	<? for($e=0;$e<5;$e++){?>
	<td align="center"><?="notas".$e?></td>
	<? }?>
    <? }?>
</tr>
<? }?>
</table>
<br/>
<? }?>
<? }?>

<? if($rdb==0 and $ensenanza==0){ //-------------REVISAR ESTE CASO TAMBIEN-----------?>

<?	
		  $var2=0;
	   for ($k = 0; $k <$cantidad; $k++){ 
	
	echo  $valor1 = strtok($arreglo[$k],"_");
	if($var2!=$valor1){	
	      $var=$valor1;  
		  $sql="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo from tipo_ense_inst, tipo_ensenanza ";
		  $sql.=" where tipo_ense_inst.cod_tipo = tipo_ensenanza.cod_tipo and tipo_ense_inst.cod_tipo=$valor1";
	  	  $resp=pg_exec($conn,$sql);	    
		  $nombre=pg_fetch_array($resp,0);
		  $cod=$nombre['cod_tipo'];
	?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	
	<td width="740">TIPO ENSEÑANZA : <?=$nombre['nombre_tipo'];?></td>
    
 </tr> 
</table>
<br/>
<? }?>
<?
		$id=0;
		$sql="SELECT DISTINCT a.nombre_instit, b.rdb FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
		$sql.=" INNER JOIN ano_escolar c ON (c.id_institucion=b.rdb) INNER JOIN curso d ON (d.id_ano=c.id_ano) ";
		$sql.=" WHERE b.num_corp=$corporacion AND d.ensenanza=$var ";
		$rs_instit=pg_exec($conn,$sql);
	for($y=0;$y<pg_numrows($rs_instit);$y++){ 
	    $fila=pg_fetch_array($rs_instit,$y);
	  if($cole!=$fila['rdb']){
		$id_instit=$fila['rdb'];
		$id=$id_instit;
	?>
<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	
	<td width="740">NOMBRE INSTITUCION:	  <?=$fila['nombre_instit'];?></td>
    
 </tr> 
</table>
<br/>
<? } ?>

<table class="Estilo9" width="800" border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td>Ramos/Cursos</td>
	<? 
		$valor2 = strstr($arreglo[$k],"_");
		$grado_prueba = substr($valor2,1);
		// echo  $arreglo[$j];
		  
	    $sql="SELECT DISTINCT d.grado_curso,d.letra_curso FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
 		$sql.=" INNER JOIN ano_escolar c ON (c.id_institucion=b.rdb) INNER JOIN curso d ON (d.id_ano=c.id_ano) ";
	    $sql.=" WHERE b.num_corp=$corporacion AND d.ensenanza=$var AND c.id_institucion=$id AND ";
  		$sql.=" d.grado_curso=$grado_prueba ";	         	  
	    $resp_curso=pg_exec($conn,$sql);
		
	for($s=0;$s<pg_numrows($resp_curso);$s++){
		$filacurso=pg_fetch_array($resp_curso,$s);	 
		
	?>
	<td align="center"><?=$filacurso['grado_curso']."".$filacurso['letra_curso']; ?></td>
	<? }
	
	}?>
</tr>
<? for($i=0;$i<$total;$i++){
			$valor=$_POST["chek".$i];
			$subsector_curso= strtok($valor,"_"); //-------nombre asig
			$cod = strstr($valor,"_");	
	    	$cod_tipo = substr($cod,1);			 //------cod_asig	
		
				
	/* $sql_curso="SELECT DISTINCT d.grado_curso,letra_curso,ensenanza FROM institucion a INNER JOIN corp_instit b ";
	 $sql_curso.=" ON (a.rdb=b.rdb) INNER JOIN ano_escolar c ON(a.rdb=c.id_institucion) INNER JOIN curso d ";
	 $sql_curso.=" ON (c.id_ano=d.id_ano) INNER JOIN ramo e ON (e.id_curso=d.id_curso) WHERE b.num_corp=$corporacion";
	 $sql_curso.=" AND b.rdb=$rdb AND e.cod_subsector=$cod_tipo AND d.ensenanza=$ensenanza";
	 $resp= pg_exec($conn,$sql_curso);
	 $cursos=pg_fetch_array($resp,$i);*/
		?>
<tr>
    <? if($subsector_curso==NULL){?>
    
    <? }else{?>
	<td><? InicialesSubsector($subsector_curso)?>
    </td>
    
	<? for($e=0;$e<5;$e++){?>
	<td align="center"><?="notas".$e?></td>
	<? }?>
    <? }?>
</tr>
<? }?>
</table>
<br/>
<? // }?>
<? } ?>
<? }?>
</body>
</html>

<? require('../../util/header.inc');

//echo $total;
//echo "<br/>".$cantidad;
//echo $arreglo;
//function array_recibe($url_array) { 
 //   $tmp = stripslashes($url_array); 
 //   $tmp = urldecode($tmp); 
 //   $tmp = unserialize($tmp); 

 //  return $tmp; 
//} 
//$array=$_GET['array']; 
//$array=array_recibe($array); 
//foreach ($array as $indice => $valor){ 
//echo $indice." = ".$valor."<br>"; 
//} 
 

//for($z=1;$z<=$cantidad;$z++){
//$array=$_GET['$arreglo[]'];
//$array=array_recibe['$arreglo[]'];
//$grado_curso= strtok($cursos,"_");
//$cod=strstr($valor,"_");
//$cod_sub=substr($cod,1,-1);
//}


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
<link href="estilos.css" rel="stylesheet" type="text/css" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
<? if($rdb!=0){

	$sql="select nombre_instit from institucion where rdb=$rdb";
	$rs = pg_exec($conn,$sql);
	$inst = pg_result($rs,0);


?>
<table align="center"width="52%" border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>&nbsp;Institucion: <? echo $inst;?></td>
</tr>
</table>
<br />
<? }?>
<? 

 if($ensenanza!=0){
 
    $sql="select nombre_tipo from tipo_ensenanza where cod_tipo=$ensenanza";
	$rs = pg_exec($conn,$sql);
	$ense = pg_result($rs,0);

?>
<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>Tipo Ensenanza: <? echo $ense;?></td>
</tr>
</table>
<br />
<? if($rdb!=0){?>
<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
  <tr>
<?
	
	for($i=0;$i<$total;$i++){
		$valor=$_POST["chek".$i];
		$subsector_curso= strtok($valor,"_");
		$cod=strstr($valor,"_");
		$cod_sub=substr($cod,1,-1);
		//echo "aki";
		echo $cod_sub;
		
		$sql1=" SELECT DISTINCT d.grado_curso,letra_curso,b.rdb,f.promedio FROM institucion a ";
		$sql1.=" INNER JOIN corp_instit b ON (a.rdb=b.rdb) INNER JOIN ano_escolar c ON (a.rdb=c.id_institucion) ";
		$sql1.=" INNER JOIN curso d ON (c.id_ano=d.id_ano) INNER JOIN ramo e ON (e.id_curso=d.id_curso) ";
		$sql1.=" INNER JOIN promedio_subsector f ON (f.id_ramo=e.id_ramo) WHERE b.num_corp=$_CORPORACION AND b.rdb=$rdb ";
		$sql1.=" AND d.ensenanza=$ensenanza AND e.cod_subsector=$cod_sub";
		echo $sql1;
		$rs_sub = pg_exec($conn,$sql1);
		$notas = pg_fetch_array($rs_sub,$i);
	
		
?>
     <td width="12%" rowspan="2" ><div align="center">CURSO</div></td>
     <td width="88%" align="center" >NOTAS</td>
    <? } ?>
  </tr>
  <tr>
    <td ><font size="1" face="verdana, arial, geneva, helvetica"><strong>
      <? InicialesSubsector($subsector_curso)?>
    </strong></font></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
</table>
<? } ?>
<? }?>
<?
if($rdb==0){

	$sql_2="SELECT DISTINCT a.nombre_instit,c.cod_tipo FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb)";
	$sql_2.=" INNER JOIN tipo_ense_inst c ON (b.rdb=c.rdb) WHERE b.num_corp=$_CORPORACION and c.cod_tipo=$ensenanza";
	$resp=pg_exec($conn,$sql_2);
	}

    for($j=0;$j<pg_numrows($resp);$j++){
         $lista=pg_fetch_array($resp,$j);
	
         
?>

<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>Institucion: <? echo $lista['nombre_instit'];?></td>
</tr>
</table>
<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
  <tr>
<?
	
	for($i=0;$i<$total;$i++){
		$valor=$_POST["chek".$i];
		$subsector_curso= strtok($valor,"_");
		
?>
     <td ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso)?>
</strong></font></div></td>
<? } ?>
  </tr>
  <tr>
    <td height="23"  align="center">&nbsp;</td>
  </tr>
 
</table><br /><? }?>

<?
if($rdb==0 and $ensenanza==0){
   $var=0;
   for($y=0;$y<$total;$y++){
		$valor=$_POST["chek".$y];
		$subsector = strstr($valor,"-");
		$subsector_2 = substr($subsector,1);
	/*	if($var!=NULL){
		  $var = $subsector_2;
	        if($var==$subsector_2){
	 
	          }else{
		        $var = $subsector_2;
		        }
		    }else{
			
			
		}*/	
		
		
		
    }
   /*
   $sql_31=" SELECT DISTINCT a.nombre_instit,b.rdb FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
   $sql_31.="INNER JOIN ano_escolar c ON (a.rdb=c.id_institucion) INNER JOIN curso d ON (c.id_ano=d.id_ano) ";
   $sql_31.=" WHERE b.num_corp=$_CORPORACION AND d.ensenanza=$subsector_2";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           */
   
   
   $sql_3 = "SELECT DISTINCT a.nombre_instit,b.rdb FROM institucion a INNER JOIN corp_instit b ON (a.rdb=b.rdb) ";
   $sql_3.= " WHERE b.num_corp=$_CORPORACION";
  // $sql_3;
   $rs_3  = pg_exec($conn,$sql_3);

 
      for($k=0;$k<pg_numrows($rs_3);$k++){
             $lista = pg_fetch_array($rs_3,$k);
			 $id = $lista['rdb'];


?>
<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>Institucion: <? echo $lista['nombre_instit'];?></td>
</tr>
</table>
<br/>

<?			 
	$sql_4 = "SELECT DISTINCT b.nombre_tipo FROM tipo_ense_inst a ";
	$sql_4.= " INNER JOIN tipo_ensenanza b ON (a.cod_tipo=b.cod_tipo) WHERE rdb=$id" ;
	$rs_4  = pg_exec($conn,$sql_4);
	
	     for($x=0;$x<pg_numrows($rs_4);$x++){
		      $ense = pg_fetch_array($rs_4,$x);
?>

<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>Tipo Ensenanza: <? echo $ense['nombre_tipo'];?></td>
</tr>
</table>
<br/>
<table align="center" width="52%" border="1" cellpadding="0" cellspacing="0">
  <tr>
<?
	
	for($i=0;$i<$total;$i++){
		$valor=$_POST["chek".$i];
		$subsector_curso = strtok($valor,"_");
				
?>
     <td ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso)?>
</strong></font></div></td>
<? } ?>
  </tr>
  <tr>
    <td height="23"  align="center">&nbsp;</td>
  </tr>
 
</table><br />
   <? }?>
 <? }?>
<? }?>
<?
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
</body>
</html>

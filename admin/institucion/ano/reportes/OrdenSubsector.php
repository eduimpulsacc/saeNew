<?php 
require('../../../../util/header.inc');

///////////////////
$institucion = $_INSTIT;
$ano		 = $_ANO;





/*$sql="SELECT distinct RAMO.cod_subsector,nombre,os.orden 
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=ramo.id_curso AND c.id_ano=".$ano." AND ensenanza=".$cmb_ensenanza." 
left JOIN orden_subsector os ON ramo.cod_subsector=os.cod_subsector AND c.ensenanza=os.tipo_ensenanza 
os.id_ano=".$ano." AND os.tipo_ensenanza=".$cmb_ensenanza." 
ORDER BY os.orden ASC";*/

$sql="SELECT distinct RAMO.cod_subsector,nombre,os.orden 
FROM ramo 
inner join subsector on ramo.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=ramo.id_curso and c.id_ano=".$ano." AND ensenanza=".$cmb_ensenanza."
left JOIN orden_subsector os ON ramo.cod_subsector=os.cod_subsector AND c.ensenanza=os.tipo_ensenanza 
and os.id_ano=".$ano." AND os.tipo_ensenanza=".$cmb_ensenanza."
ORDER BY os.orden ASC ";
$rs_subsectores = pg_Exec($conn,$sql);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript1.1" type="text/javascript">
function enviapag(form){
      document.form.submit();
}


function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

</script>	
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<body>
<form name="form1" method="post" action="procesoGuardarOrden.php">
<input type="hidden" name="cmb_ensenanza" value="<?=$cmb_ensenanza;?>"> 

<table width="500">
	<tr>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><b>Ordenar Subsectores</b></font></td>
	</tr>
</table>

<table width="500">
	<tr>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Nro.</b></font></td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Nombre</b></font></td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Código</b></font></td>
	</tr>
	<?
	for ($i=0; $i < pg_numrows($rs_subsectores); $i++){
	    $fil_sub = pg_fetch_array($rs_subsectores, $i);
	    $nombre_subsector = $fil_sub['nombre'];
		$cod_subsector    = $fil_sub['cod_subsector'];
		$orden 			  = $fil_sub['orden'];
		
	
	

		//echo "<br>".$sql_sub;	 
	    ?>
        <input type="hidden" name="subsector<?=$i;?>" value="<?=$cod_subsector;?>">
		<tr>
			<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><input name="orden<?=$i;?>" type="text" size="5" maxlength="2" value="<?=$orden;?>"></font></td>
			<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><?=$nombre_subsector.$fil_sub['id_ramo'];?></font></td>
			<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><?=$cod_subsector?></font></td>
		</tr>
 <? } 
 $contador = $i;
 ?>	
 
 <input type="hidden" name="contador" value="<?=$contador;?>">
</table>



<table width="500">
  <tr>
    <td align="center"><label>
      <input name="ordenar" type="submit" id="ordenar" value="ORDENAR SUBSECTORES" class="botonXX">
      <input name="sierraventana" type="button" id="sierraventana" value="Cerrar" onClick="cerrar();" class="botonXX">
    </label></td>
  </tr>
</table>
</form>
</body>
</head>
</html>
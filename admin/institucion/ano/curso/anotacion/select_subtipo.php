<?
require('../../../../../util/header.inc');

$tipo_anotacion = $_REQUEST[tipo_anotacion];
  
 $q300 = "select * from detalle_anotaciones where id_tipo = '".trim($tipo_anotacion)."' 
order by codigo ASC";

$q400 = "select tipo from tipos_anotacion where id_tipo = '".trim($tipo_anotacion)."' ";
$r400 = @pg_Exec($conn,$q400);
$n400 = @pg_numrows($r400);
$f400 = pg_fetch_array($r400,0);

$r300 = @pg_Exec($conn,$q300);
$n300 = @pg_numrows($r300);

echo '<select name="detalle_anotaciones" id="detalle_anotaciones">';
echo '<option value="0">Seleccione Sub-Tipo</option>';

		$l = 0;
		while ($l < $n300){
		
		$f300 = pg_fetch_array($r300,$l);
		
		$codigosubtipo  = $f300['codigo'];
		$detallesubtipo = $f300['detalle'];
										   
		if ($codigosubtipo!=NULL){
	
	        echo "<option value=".$codigosubtipo.">";
	        echo "$codigosubtipo-".substr($detallesubtipo,0,15)."</option>";
	   }  
	   
	   $l++; }	 
		   
echo '</select><span class="Estilo7">(*)</span>';
echo '<input type="hidden" name="tipo_a" id="tipo_a" value="'.$f400['tipo'].'" />'

?>
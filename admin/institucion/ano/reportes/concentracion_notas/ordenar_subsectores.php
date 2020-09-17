<?
	require('../../../../../util/header.inc');
	
	
	$curso=$cmb_curso;


 // se guarda el orden para soplo un alumno
	  $sql_sub = "select orden_concentracion_notas.cod_subsector, orden_concentracion_notas.orden, subsector.nombre from orden_concentracion_notas inner join subsector on subsector.cod_subsector=orden_concentracion_notas.cod_subsector where id_curso = '$curso' order by orden";
	 $res_sub = pg_Exec($conn, $sql_sub)or die("fallo1");
	 $num_sub = pg_numrows($res_sub);
	 
	 for ($i=0; $i < $num_sub; $i++){	
		 $fil_sub = pg_fetch_array($res_sub, $i);
		 $nombre_subsector = $fil_sub['nombre'];
		 $cod_subsector    = $fil_sub['cod_subsector'];
		 		 
		 $orden_sub = $i;
		// $orden_sub = $orden_sub;
		 
	echo	 $actualizar = "update orden_concentracion_notas set orden = ".$orden_sub." where cod_subsector = $cod_subsector and id_curso = $curso";
		 $res_actualizar = pg_Exec($conn, $actualizar)or die("fallo2 ".$actualizar);			 		
	
	 }		 
	 
?>
<script type="text/javascript">
opener.location.reload();
window.close();

</script>

<?php require('../../../../../util/header.inc');

foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 
   
   function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}
   
   $hora_inicio=$hora_ini.":".$min_ini.":00";
   $hora_termino=$hora_ter.":".$min_ter.":00";
   
   $sql_nom_sub="select * from ramo where id_ramo=".$subsector;
  $res_nom_sub=pg_exec($conn,$sql_nom_sub);
  $fil_cod=@pg_fetch_array($res_nom_sub,0);
  $cod_subsector=$fil_cod['cod_subsector'];
   
   $nuevo=0;
   //hago el insert
  $sql_ins_cal="insert into calendario_actividades(rdb,id_ano,id_curso,id_subsector,actividad,fecha_inicio,fecha_termino,hora_inicio,hora_termino,cod_subsector) values(".$rdb.",".$id_ano.",".$id_curso.",".$subsector.",'".$actividad."','".CambioFecha($fecha_inicio)."','".CambioFecha($fecha_termino)."','".$hora_inicio."','".$hora_termino."',".$cod_subsector.")";
  $res_del=pg_exec($conn,$sql_ins_cal) or die ('no inserte');
?>
<script>
alert ('Actividad Ingresada Exitosamente');
window.open('CalCurso.php?id_curso=<?php echo $id_curso ?>&subsector=<?php echo $subsector ?>&act=1&nuevo=1','_self');
</script>
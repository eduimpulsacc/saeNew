<?php 
require('../../../../../../util/header.inc');
$sql="select * from plani where id_plani=629";
$res=@pg_exec($conn,$sql);

$fil=@pg_fetch_array($res,0);
$fecha_inicio=$fil['fecha_inicio'];
$fecha_fin=$fil['fecha_fin'];
$fecha_abordaje=$fil['fecha_abordaje'];

if (($fecha_abordaje>=$fecha_inicio) and ($fecha_abordaje<=$fecha_fin))
echo "cumplido";

if (($fecha_abordaje<$fecha_inicio) or (strlen($fecha_inicio)<1) or (strlen($fecha_fin)<1) or (strlen($fecha_abordaje)<1))
echo "pendiente";

if ($fecha_abordaje>$fecha_fin)
echo "no cumplido";
?>
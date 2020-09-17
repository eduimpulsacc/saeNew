<?php
require('../../../util/header.inc');

$sql="select * from ano_escolar";
$result=pg_Exec($conn,$sql);
for ($i=0 ; $i<pg_numrows($result) ; $i++){
	$fila=pg_fetch_array($result,$i);
	$sql2="select id_ano, id_institucion from ano_escolar where id_institucion=".$fila["id_institucion"];
	$result2=pg_Exec($conn,$sql);
	for ($j=0 ; $j<pg_numrows($result2) ; $j++){
		$fila2=pg_fetch_array($result2,$j);
		$sql3="select * from ano_escolar where id_institucion=".$fila2["id_institucion"]."order by nro_ano";
		$result3=pg_Exec($conn,$sql3);
			for($k=0 ; $k<pg_numrows($result3) ; $k++){
			    $fila3=pg_fetch_array($result3,$k);
				if ($k>0){
				$ant=($k-1);
				$filaAnt= pg_fetch_array($result3,$ant);
				$anoAnt=$filaAnt["id_ano"];
				$anoActual=$fila3["id_ano"];
				$sql4="update ano_escolar set ano_anterior=".$anoAnt." where id_ano=".$anoActual;
				$result4=pg_Exec($conn,$sql4);
				}
			}
	    }
    }
    pg_close($conn);
?>
				
				


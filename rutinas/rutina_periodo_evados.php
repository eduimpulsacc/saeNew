<?php

	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Viña.");


$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");

	/*ECHO $sql="select distinct id_ano from evados.eva_relacion_evaluacion";
	$rs_final = pg_exec($conn,$sql);
	exit;
	
	for($i=0;$i<@pg_numrows($rs_final);$i++){
	$fila = @pg_fetch_array($rs_final,$i);
	 "ano--->".$fila[0];
	"<pre>";*/
	/*echo $sql_an ="select  * from ano_escolar where id_ano=1161";
	//"</pre>";
	$rs_ano = pg_exec($conn,$sql_an);

      for($x=0;$x<@pg_numrows($rs_ano);$x++){
	  $fila_an = @pg_fetch_array($rs_ano,$x);
	  "<hr>";*/
      $id_ano = 1282;
   
   
   
   //echo $sql_per="select * from periodo where id_ano=$id_ano and nombre_periodo like '%TERCER TRIMESTRE%'";
    echo $sql_per="select * from periodo where id_ano=$id_ano and nombre_periodo like '%PRIMER SEMESTRE%'";
   $rs_per = pg_exec($conn,$sql_per);
   for($j=0;$j<@pg_numrows($rs_per);$j++){
	   
	   $fila_per=pg_fetch_array($rs_per,$j);
	   $id_periodo=$fila_per['id_periodo'];
	  
	    echo"<pre>";
	   echo $id_periodo.'-'.$fila_per['nombre_periodo'];
	   echo "</pre>";
	   
	    echo "<pre>";
	 echo $sql_update="update evados.eva_relacion_evaluacion set id_periodo=$id_periodo where id_ano=$id_ano";
	//$rs_update = pg_exec($conn,$sql_update)or die("FALLO UPDATE" .$sql_update);
	 echo "</pre>";
	    echo "<hr>";
	   }
   //	}
     
//}
	
	
?>
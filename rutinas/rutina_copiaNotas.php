<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
$id_base =1; 
$nano = 2017;  


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }?>
     
     
<?php 
//temporal dav
$sq_tpv="select * from temporal_dav order by id";
$rs_tpv=pg_exec($conn,$sq_tpv);
for($i=0;$i<pg_numrows($rs_tpv);$i++){
$filat=pg_fetch_array($rs_tpv,$i);

$r = explode("-",$filat['campo1']);
$rut_alumno=$r[0];
$cn="";
$nn2="";
// borro notas
echo $sqlc="delete from notas$nano where rut_alumno=".trim($rut_alumno)." and  id_periodo=".trim($filat['campo2'])." and id_ramo=".trim($filat['campo3']);
$rslc = pg_exec($conn,$sqlc);
//exit;
 for($j=1;$j<=15;$j++){
	 $cn.="nota$j,";
		echo "<br>".$sql_nt = "select campo".($j+3)." from temporal_dav where  campo1 ='".trim($filat['campo1'])."' and campo2='".trim($filat['campo2'])."' and campo3='".trim($filat['campo3'])."'"; 
		$rs_nt = pg_exec($conn,$sql_nt);
		//$nn2.= "'".@(trim(pg_result($rs_nt,0)*10)."',"); 
		//$nn2.= "'".@(trim(pg_result($rs_nt,0))."',"); 
		$nn3 =str_replace(",","",pg_result($rs_nt,0));
	$nn2.=($nn3<10 && ($nn3!='MB' && $nn3!='B' && $nn3!='S' && $nn3!='I'))?"'".($nn3*10)."',":"'".$nn3."',";
	
	
 }
 $prom =str_replace(",","",$filat['campo19']);
$prom2 =($prom<10 && ($prom!='MB' && $prom!='B' && $prom!='S' && $prom!='I'))?$prom*10:$prom;
 echo $sql_ins = "insert into notas$nano(rut_alumno,id_periodo,id_ramo,$cn promedio) values ($rut_alumno,".trim($filat['campo2']).",".trim($filat['campo3']).",$nn2 '".$prom2."')";
 $rs_ins = pg_exec($conn,$sql_ins);
echo "<br>";

}  
  
?> 

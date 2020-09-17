<?
/*$conn=@pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");*/
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
/*$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");       */
   
/*$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	 
        */

$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	 
        

$institucion = '4277';           
$nro_ano     = '2018';                    
$id_ano      = '1935';                                         
                                                                         
 /*    
/// eliminar todos los subsectores de todos los cursos 
$sql_borra = "delete from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '".trim($id_ano)."'))";
$res_borra = pg_Exec($conn,$sql_borra);


/// eliminar todos los subsectores de todos los cursos
$sql_borra = "delete from tiene$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '".trim($id_ano)."'))"; 
$res_borra = pg_Exec($conn,$sql_borra);



$sql_borra = "delete from ramo where id_curso in (select id_curso from curso where id_ano = '".trim($id_ano)."')";
$res_borra = pg_Exec($conn,$sql_borra);
/// todos los subsectores eliminados
*/

$qry_0 = "select * from temporal_dav";   
$res_0 = pg_Exec($conn,$qry_0); 
$num_0 = pg_numrows($res_0);

for ($k=0; $k < $num_0; $k++){
     $fil_0 = pg_fetch_array($res_0,$k);
	 
	 $rdb           = $fil_0['campo1'];
	 $ensenanza     = $fil_0['campo2'];
	 $grado_curso   = $fil_0['campo3'];
	 $letra_curso   = $fil_0['campo4'];
	 $cod_subsector = $fil_0['campo5']; 
	 
	 
	 /// rescatar el id_curso	 
	 $sql_cur = "select id_curso from curso where id_ano = '".trim($id_ano)."' and ensenanza = '".trim($ensenanza)."' and grado_curso = '".trim($grado_curso)."' and letra_curso = '".trim($letra_curso)."'";
	 $res_cur = pg_Exec($conn,$sql_cur);
	 $fil_cur = pg_fetch_array($res_cur);
	 $id_curso = $fil_cur['id_curso'];	 
	 
	 
	 /// comprobar si existe el subsector leido		  	  
	 $qry_1 = "select id_ramo from ramo where id_curso = '".trim($id_curso)."' and cod_subsector = '".trim($cod_subsector)."'";
     $res_1 = pg_Exec($conn,$qry_1);
     $num_1 = @pg_numrows($res_1);
	 
	 if ($num_1==0){
	      // subsector no existe se debe crear en RAMO
		  
		  if ($cod_subsector==13){		  
			    $qry_2 = "INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES ('".trim($id_curso)."',1,'".trim($cod_subsector)."',2,1,1,0,2,0,0,1,1,2,0,0,0,0)";
		   
		   }else{
		        $qry_2 = "INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES ('".trim($id_curso)."',1,'".trim($cod_subsector)."',1,1,1,0,2,0,0,1,1,2,0,0,0,0)";	   
		   
		   }	   
		   
		   $res_2 = pg_Exec($conn,$qry_2);
     
	 }	  
	  
}   
  
echo "<br> fin subsectores ano $nro_ano institucion ".$institucion."..."; 	
?>

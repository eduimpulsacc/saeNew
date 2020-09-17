<?php 
 require('../../../util/header.inc');
// for ($i==20000 ; $i < 1875221 ; $i+50){
 //$sql= "select distinct rut_alumno, id_ramo, id_periodo from nota where id_nota between ".$i." and ".$i+50." group by id_nota, rut_alumno, id_ramo, id_periodo";
 $sql="select * from nota order by rut_alumno, id_ramo, id_periodo";
 $resultSql= @pg_Exec($conn, $sql);
 	if (!$resultSql){ 
		error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$sql);
	}

		//for ($X=0 ; $X<@pg_numrows($resultSql); $X++) {
			while ($filaSql=@pg_fetch_array($resultSql)){//,$X);
			
			$sql2= "select * from nota where rut_alumno =".$filaSql['rut_alumno']." and id_ramo =".$filaSql['id_ramo']." and id_periodo =".$filaSql['id_periodo'];
			$resultSql2= @pg_Exec($conn, $sql2);
				if (!$resultSql2){ 
					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>'.$sql2);
				}
					
					for ($Y=0 ; $Y<@pg_numrows($resultSql2); $Y++){
						$filaSql2=@pg_fetch_array($resultSql2);
						
						if ($Y==0 and $filaSql2['valor']!=""){
							$nota1 = $filaSql2['valor'];
						}elseif ($Y==0 and $filaSql2['valor']==""){
							$nota1 = 0;							
						}
						
						if ($Y==1 and $filaSql2['valor']!=""){
							$nota2 = $filaSql2['valor'];
						}elseif ($Y==1 and $filaSql2['valor']==""){
							$nota2 = 0;							
						}
						
						if ($Y==2 and $filaSql2['valor']!=""){
							$nota3 = $filaSql2['valor'];
						}elseif ($Y==2 and $filaSql2['valor']==""){
							$nota3 = 0;							
						}
						
						if ($Y==3 and $filaSql2['valor']!=""){
							$nota4 = $filaSql2['valor'];
						}elseif ($Y==3 and $filaSql2['valor']==""){
							$nota4 = 0;							
						}
						
						if ($Y==4 and $filaSql2['valor']!=""){
							$nota5 = $filaSql2['valor'];
						}elseif ($Y==4 and $filaSql2['valor']==""){
							$nota5 = 0;							
						}
						
						if ($Y==5 and $filaSql2['valor']!=""){
							$nota6 = $filaSql2['valor'];
						}elseif ($Y==5 and $filaSql2['valor']==""){
							$nota6 = 0;							
						}
						
						if ($Y==6 and $filaSql2['valor']!=""){
							$nota7 = $filaSql2['valor'];
						}elseif ($Y==6 and $filaSql2['valor']==""){
							$nota7 = 0;							
						}
						
						if ($Y==7 and $filaSql2['valor']!=""){
							$nota8 = $filaSql2['valor'];
						}elseif ($Y==7 and $filaSql2['valor']==""){
							$nota8 = 0;							
						}
						
						if ($Y==8 and $filaSql2['valor']!=""){
							$nota9 = $filaSql2['valor'];
						}elseif ($Y==8 and $filaSql2['valor']==""){
							$nota9 = 0;							
						}
										
					}//FIN FOR $Y
						
						$sqlExiste="select * from notas1 where rut_alumno =".$filaSql['rut_alumno']." and id_ramo =".$filaSql['id_ramo']." and id_periodo =".$filaSql['id_periodo'];
						$resultExiste= @pg_Exec($conn, $sqlExiste);
							if (@pg_numrows($resultExiste)==0){
						
								$sql3="insert into notas1 (rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16, nota17, nota18, nota19, nota20,promedio) values ('".$filaSql['rut_alumno']."', ".$filaSql['id_ramo'].", ".$filaSql['id_periodo'].", '".$nota1."', '".$nota2."', '".$nota3."', '".$nota4."', '".$nota5."', '".$nota6."', '".$nota7."', '".$nota8."', '".$nota9."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','0')";
								$resultSql3= @pg_Exec($conn, $sql3);
									if (!$resultSql3){ 
										error('<B> ERROR :</b>Error al acceder a la BD. (23)</B>'.$sql3);
									}
									
							}//fin if existe
		}//fin FOR $X
	}	
  
 ?>
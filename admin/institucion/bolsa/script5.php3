<?php 

	$X=13622;
	$Z=0;
	while ($X<1875221)	{
		$conn=@pg_connect("dbname=coe port=1550 user=postgres password=usuariocoegc10");	
			
		$Z=$X+50;
		$qry="select distinct rut_alumno, id_ramo, id_periodo from nota where id_nota between ".$X." and ".$Z;
		  $result=@pg_Exec($conn,$qry);
			
					 while ($fila=@pg_fetch_array($result)){
					  $qry9="select * from nota where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo']."";
						$result9=@pg_Exec($conn,$qry9);
							for ($i=0 ; $i < @pg_numrows($result9); $i++){
							  $fila9=@pg_fetch_array($result9,$i);
								 switch($i){
									 case 0:
										  $valor1=$fila9['valor'];
										  break;					
									 case 1:
										  $valor2=$fila9['valor'];
										   break;
									 case 2:
										  $valor3=$fila9['valor'];
										   break;
									 case 3:
										  $valor4=$fila9['valor'];
										   break;
									 case 4:
										  $valor5=$fila9['valor'];
										   break;
									 case 5:
										  $valor6=$fila9['valor'];
										   break;
									 case 6:
										  $valor7=$fila9['valor'];
										   break;
									 case 7:
										  $valor8=$fila9['valor'];
										   break;
									 case 8:
										  $valor9=$fila9['valor'];
										   break;	   	   	   	   	   
								   }
								 }
								 
								/*$qry8="select * from notas where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo']."";
									$result8=@pg_Exec($conn,$qry8);*/
									
									  // if (@pg_numrows($result8)==0){
											$qry7="insert into notas2 (rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16, nota17, nota18, nota19, nota20, promedio) values (".$fila['rut_alumno'].",  ".$fila['id_ramo'].", ".$fila['id_periodo'].", '".$valor1."', '".$valor2."', '".$valor3."', '".$valor4."','".$valor5."', '".$valor6."', '".$valor7."', '".$valor8."', '".$valor9."','0','0','0','0','0','0','0','0','0','0','0','0')";
											$result7=pg_Exec($conn,$qry7);
											
										//	}
											
							}
						$X=$X+51;
					pg_close($conn);
						}
		
?>       
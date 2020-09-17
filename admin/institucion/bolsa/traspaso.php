
<?php 
 require('../../../util/header.inc');
/*$conn=@pg_connect("dbname=prueba port=1550 user=postgres password=usuariocoegc10");
	if (!$conn) {
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	}*/
	 $qry="select distinct id_institucion, cod_decreto, ensenanza from (curso inner join ano_escolar on curso.id_ano=ano_escolar.id_ano) where cod_decreto <> 0";
	 $result=@pg_Exec($conn,$qry);
		 if (!$result){ 
			error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry);
		}else{
				if (@pg_numrows($result)!=0){
					  for ($i=0 ; $i < @pg_numrows($result) ; $i++){
							$fila = @pg_fetch_array($result,$i);
								$qry2="insert into tipo_ense_inst (rdb, cod_tipo, cod_decreto, estado) values (".$fila['id_institucion'].",".$fila['ensenanza'].",".$fila['cod_decreto'].",1)";
								echo $qry2;
								$result2=@pg_Exec($conn,$qry2);
									 if (!$result2)	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>'.$qry2);
										//}
								$qry4="select * from plan_inst where rdb=".$fila['id_institucion']." and cod_decreto=".$fila['cod_decreto'];
								$result4=@pg_Exec($conn,$qry4);
									 if (pg_numrows($result4)==0){
										$qry3="insert into plan_inst (rdb, cod_decreto) values (".$fila['id_institucion'].",".$fila['cod_decreto'].")";
										$result3=@pg_Exec($conn,$qry3);
											 if (!$result3)	error('<B> ERROR :</b>Error al acceder a la BD. (23)</B>'.$qry3);
									 }
						}//FIN FOR
				}//FIN IF
			}//FIN ELSE
			//}
	
	?>

<?php 
 require('../../../util/header.inc');
/*$conn=@pg_connect("dbname=prueba port=1550 user=postgres password=usuariocoegc10");
	if (!$conn) {
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	}*/
//$qry="Select * from nota order by rut_alumno, id_ramo, id_periodo";
$qry="select distinct rut_alumno, id_ramo, id_periodo from nota where id_nota between 13622 and 20000 group by id_nota, rut_alumno, id_ramo, id_periodo";
   $result=@pg_Exec($conn,$qry);
     if (!$result){ 
		error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry);
		}/*else{
     if (@pg_numrows($result)!=0){*/
	    for ($j=0 ; $j < @pg_numrows($result); $j++){
		     $fila=@pg_fetch_array($result,$j);
			 
		 	$qry2="Select * from nota where rut_alumno=".$fila["rut_alumno"]."and id_ramo=".$fila["id_ramo"]."and id_periodo=".$fila["id_periodo"]."order by rut_alumno, id_ramo, id_periodo";
		 	$result2=@pg_Exec($conn,$qry2);
				if (!$result2){ 
					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>'.$qry2);
				}/*else{
					if (@pg_numrows($result2)!=0){*/
				    	for($i=0 ; $i < @pg_numrows($result2); $i++){
					       $fila2 = @pg_fetch_array($result2,$i);
					        
								if($i==0 and $fila2["valor"]!=""){
									$valor1=$fila2["valor"];
								}elseif($i==0 and $fila2["valor"]==""){ 
									$valor1=0;
								} 
								 
								if($i==1 and $fila2["valor"]!=""){
								 $valor2=$fila2["valor"];
								}elseif($i==1 and $fila2["valor"]==""){ 
								 $valor2=0;
								}
								 
								if($i==2 and $fila2["valor"]!=""){
								 $valor3=$fila2["valor"];
								}elseif($i==2 and $fila2["valor"]==""){ 
								 $valor3=0;
								}
								 
								if($i==3 and $fila2["valor"]!=""){
									$valor4=$fila2['valor'];
								}elseif($i==3 and $fila2['valor']==""){ 
									$valor4=0;
								}
								 
								if($i==4 and $fila2['valor']!=""){
									$valor5=$fila2['valor'];
								}elseif($i==4 and $fila2['valor']==""){ 
									$valor5=0;
								}
							
								if($i==5 and $fila2['valor']!=""){
									$valor6=$fila2['valor'];
								}elseif($i==5 and $fila2['valor']==""){ 
									$valor6=0;
								}
							
								if($i==6 and $fila2['valor']!=""){
									$valor7=$fila2['valor'];
								}elseif($i==6 and $fila2['valor']==""){ 
									$valor7=0;
								}
							
								if($i==7 and $fila2['valor']!=""){
									$valor8=$fila2['valor'];
								}elseif($i==7 and $fila2['valor']==""){ 
									$valor8=0;
								}
						
								if($i==8 and $fila2['valor']!=""){
									$valor9=$fila2['valor'];
								}elseif($i==8 and $fila2['valor']==""){ 
									$valor9=0;
								}
						
						   }//FIN FOR NOTAS ($i)
						   
						   
						/*$qry6="Select promedio from califica where rut_alumno=".$fila2["rut_alumno"]."and id_ramo=".$fila2["id_ramo"]."and id_periodo=".$fila2["id_periodo"];
						$result6=@pg_Exec($conn,$qry6);
						$fila6 = @pg_fetch_array($result6,0); 
							if($fila6['promedio']!=""){ 
								$promedio= $fila6['promedio'];
							}else{
								$promedio=0;
							}*/
						   
						$qry3="Select * from notas where rut_alumno=".$fila2["rut_alumno"]."and id_ramo=".$fila2["id_ramo"]."and id_periodo=".$fila2["id_periodo"];
						$result3=@pg_Exec($conn,$qry3);
							if (@pg_numrows($result3)==0){

								$qry4="insert into notas (rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16, nota17, nota18, nota19, nota20, promedio) values (".$fila2['rut_alumno'].",  ".$fila2['id_ramo'].", ".$fila2['id_periodo'].", '".$valor1."', '".$valor2."', '".$valor3."', '".$valor4."','".$valor5."', '".$valor6."', '".$valor7."', '".$valor8."', '".$valor9."','0','0','0','0','0','0','0','0','0','0','0','".$promedio."')";
								$result4=@pg_Exec($conn,$qry4);
									if (!$result4) {
										error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry4);
										exit;						
					            	}
						    	 //}
													
						   }
						  			  
				     // }
						 
		        //}
	
	      }
		  
    //}   
?>

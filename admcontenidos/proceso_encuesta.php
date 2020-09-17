<?
require('util/header2.inc');

$dd = date(d);
$mm = date(m);
$aa = date(Y);
$fecha = "$dd-$mm-$aa";


if (isset($ingresarencuesta) and $modo != 3 and $op != "e"){
   // ingreso de información en las tablas de la encuesta
   $q1 = "insert into encuesta (pregunta, fecha, activo) values ('$pregunta', '$fecha', '0')";
   $r1 = pg_Exec($conn,$q1);
   if (!$r1){
       echo "Error al intentar ingresar la encuesta, en la tabla encuesta".$q1;
	   exit();
   }else{
       // ingresamos las opciones en la tabla opciones_encuesta
	   $q2 = "select * from encuesta order by id desc";
	   $r2 = pg_Exec($conn,$q2);
	   $n2 = pg_numrows($r2);
	   if ($n2 == 0){
	      echo "Error no ha tomado ningun registro de la tabla encuesta".$q2;
		  exit();
	   }else{
	      $f2 = pg_fetch_array($r2,0);
		  $id_encuesta = $f2['id'];
		  // acá tomo el arreglo opt[] y obtengo cuantos valores tiene
		  $cantopt = count($opt);
		  $i = 0; $j = 1;
		  while ($i < $cantopt){
		     $opcion = $opt[$j];
			 if ($opcion != NULL){
		        $q3 = "insert into opciones_encuesta (id_encuesta, opcion) values ('$id_encuesta', '$opcion')";
			    $r3 = pg_Exec($conn,$q3);
			    if (!$r3){
			       echo "Error al intentar ingresar las opciones de la encuesta a la tabla opciones_encuesta".$q3;
				   exit();
		        }
			 }	
			 $i++; $j++; 
		     
		  }
	   }
   }
   // una vez ingresada la encuesta la muestro
   $modo = 2;
}

if (isset($ingresarencuesta) and $op == "e"){
   // actualizo la encuesta
   $q1 = "update encuesta set pregunta = '$pregunta' where id = '$id_encuesta'";
   $r1 = pg_Exec($q1);
   if (!$r1){
      echo "Error no se puede actualizar la pregunta de la encuesta";
	  exit();
   }else{
      // borramos las opciones de la pregunta para luego ingresarlas en forma actualizada
	  $q2 = "delete from  opciones_encuesta where id_encuesta = '$id_encuesta'";
	  $r2 = pg_Exec($conn,$q2);
      if (!$r2){
	      echo "Error no se pudo borrar las opciones de la encuesta";
		  exit();
	  }else{
	      // ingresamos las nuevas opciones de la encuesta
		  $cantopt = count($opt);
		  $i = 0; $j = 1; $votantes = 0;
		  while ($i < $cantopt){
		     $opcion = $opt[$j];
			 $votos  = $votos[$j];
			 
		     $q3 = "insert into opciones_encuesta (id_encuesta, opcion, votos) values ('$id_encuesta', '$opcion', '$votos')";
			 $r3 = pg_Exec($conn,$q3);
			 if (!$r3){
			    echo "Error al intentar ingresar las opciones de la encuesta a la tabla opciones_encuesta".$q3;
				exit();
		     }
			 $i++; $j++; 
			 $votantes = $votantes + $votos;
			 
		     
		  }	  	 
		  // actualizamos el nuevo total de los votos
		  $q4 = "update encuesta set votantes = '$votantes' where id = '$id_encuesta'";
		  $r4 = pg_Exec($conn,$q4);
		  if (!$r4){
		     echo "Error no se pudo actualizar el total de votos para la encuesta";
		     exit();
		  }		  
	  }
   }
  $modo = 2;
}   	   	  	 
		   		 
				      	   



if ($modo == 2){
   // tomamos los datos de una encuesta para mostrarla en la pagina encuesta
   $q4 = "select * from encuesta where id = '$id_encuesta'";
   $r4 = pg_Exec($conn,$q4);
   if (!$r4){
      echo "Error al tomar los datos de una encuesta determinada".$q4;
	  exit();
   }else{
      $n4 = pg_numrows($r4);
	  if ($n4 == 0){
	     echo "Error al intentar tomar la pregunta";
		 exit();
	  }else{
	     $f4 = pg_fetch_array($r4,0);
		 $p = $f4['pregunta'];
		 	
		 // acá tomas las opciones de la encuesta
		 $q5 = "select * from opciones_encuesta where id_encuesta = '$id_encuesta'";
		 $r5 = pg_Exec($conn,$q5);
		 if (!$r5){
		    echo "Error, no puede tomar las opciones de la encuesta";
			exit();
		 }else{
		    $n5 = pg_numrows($r5);
			if ($n5 == 0){
			    echo "Error, no hay opciones para esta encuesta";
				exit();
		    }else{
			    $i = 0;
				echo "<form name='form' method='post' action='encuesta.php'>";
				echo "<input type='hidden' name='contopt' value='$n5'>";
				echo "<input type='hidden' name='id_encuesta' value='$id_encuesta'>";
				echo "<input type='hidden' name='p' value='$p'>";
				while ($i < $n5){
			       $f5 = pg_fetch_array($r5,$i);
				   $opcion = $f5['opcion'];
				   $id_opt = $f5['id'];
				   echo "<input type='hidden' name='opcion[$i]' value='$opcion'>";
				   echo "<input type='hidden' name='id_opt[$i]' value='$id_opt'>";
		           $i++;
				}
				echo "</form>";
				echo "<html>
                      <body onload='form.submit()'>
                       </body>
                      </html>";
					  
		    }
	    }
	 }	 		
   } 		      
}

if ($modo == 3){
   // ingresamos la opinion del usuario
   // actualizamos el total de votaciones
   
   
   $q1 = "select * from encuesta where id = '$id_encuesta'";
   $r1 = pg_Exec($conn,$q1);
   if (!r1){
      echo "Error al intentar tomar la encuesta";
	  exit();
   }else{
      $n1 = pg_numrows($r1);
	  if ($n1 == 0){
	     echo "Error, la encuesta no existe...";
		 exit();
      }else{
	     $f1 = pg_fetch_array($r1,0);
		 $votantes = $f1['votantes'];
		 $p        = $f1['pregunta'];
		 $votantes++;
		 $q2 = "update encuesta set votantes = '$votantes' where id = '$id_encuesta'";
		 $r2 = pg_Exec($q2);
		 if (!r2){
		    echo "Error no se pudo actualizar la tabla encuesta";
			exit();
		 }else{
		      // Pasamos a actualizar la opcion votada en la tabla opciones_encuesta
			  $q3 = "select * from opciones_encuesta where id_encuesta = '$id_encuesta' and id = '$id_opt'";
			  $r3 = pg_Exec($conn,$q3);
			  if (!r3){
			     echo "Error al intentar actualizar la opcion votada en la tabla opciones_encuesta";
				 exit();
			  }else{
			     $n3 = pg_numrows($r3);
				 if ($n3 == 0){
				     echo "Error La opcion no existe en la tabla opciones_encuesta";
					 exit();
				 }else{
				     $f3 = pg_fetch_array($r3,0);
					 $votos = $f3['votos'];
					 $votos++;
					 $q4 = "update opciones_encuesta set votos = '$votos' where id = '$id_opt'"; 
					 $r4 = pg_Exec($conn,$q4);
					 if (!r4){
					     echo "Error, no se pudo actualizar la votacion en la tabla opciones_encuesta";
						 exit();
					 }else{
					     // aquí mandamos los valores de la encuesta ya actualizados
						 
						 
						 // tomo los nombres y valores de las opciones de la encuesta
						 
				         $q5 = "select * from opciones_encuesta where id_encuesta = '$id_encuesta' order by id ASC";
		                 $r5 = pg_Exec($conn,$q5);
		                 if (!$r5){
		                    echo "Error, no puede tomar las opciones de la encuesta";
			                exit();
		                 }else{
		                    $n5 = pg_numrows($r5);
			                if ($n5 == 0){
			                    echo "Error, no hay opciones para esta encuesta";
				                exit();
		                    }else{
							    echo "<form name='form' method='post' action='encuesta.php?modo=4'>";
				                echo "<input type='hidden' name='p' value='$p'>";
						        echo "<input type='hidden' name='votantes' value='$votantes'>";
							    echo "<input type='hidden' name='contopt' value='$n5'>";
								echo "<input type='hidden' name='id_encuesta' value='$id_encuesta'>";
			                    $i = 0;
				                while ($i < $n5){
			                        $f5 = pg_fetch_array($r5,$i);
				                    $opcion = $f5['opcion'];
				                    $id_opt = $f5['id'];
									$votos  = $f5['votos'];
									$porcentaje = @(($votos * 100) / $votantes); 
				                    echo "<input type='hidden' name='opcion[$i]' value='$opcion'>";
				                    echo "<input type='hidden' name='id_opt[$i]' value='$id_opt'>";
									echo "<input type='hidden' name='votos[$i]'  value='$votos'>";
									echo "<input type='hidden' name='porcentaje[$i]'  value='$porcentaje'>";
		                            $i++;
				                }
				                echo "</form>";
				                echo "<html>
                                      <body onload='form.submit()'>
                                      </body>
                                      </html>";
					            
							}	
						}					 
					 }	 
				 }
			  }
		  }
	  }
   }
}



if ($modo == 4){
   $q1 = "select * from encuesta where id = '$id_encuesta'";
   $r1 = pg_Exec($conn,$q1);
   if (!r1){
      echo "Error al intentar tomar la encuesta";
	  exit();
   }else{
      $n1 = pg_numrows($r1);
	  if ($n1 == 0){
	     echo "Error, la encuesta no existe...";
		 exit();
      }else{
	     $f1 = pg_fetch_array($r1,0);
		 $votantes = $f1['votantes'];
		 $p        = $f1['pregunta'];
		 $q3 = "select * from opciones_encuesta where id_encuesta = '$id_encuesta' order by id";
		 $r3 = pg_Exec($conn,$q3);
	     if (!r3){
	        echo "Error al intentar actualizar la opcion votada en la tabla opciones_encuesta";
			exit();
		 }else{
			$n3 = pg_numrows($r3);
			if ($n3 == 0){
			    echo "Error La opcion no existe en la tabla opciones_encuesta";
			    exit();
		    }else{
			      if ($op == "e"){
				     echo "<form name='form' method='post' action='form_encuesta.php?op=e'>";
				  }else{
				     echo "<form name='form' method='post' action='encuesta.php'>";
			      }		 
				  	 
				  if ($ver == "si"){	 
				     echo "<input type='hidden' name='modo' value='4'>";	 
				  }
				  
				  echo "<input type='hidden' name='p' value='$p'>";
				  echo "<input type='hidden' name='votantes' value='$votantes'>";
				  echo "<input type='hidden' name='contopt' value='$n3'>";
				  echo "<input type='hidden' name='id_encuesta' value='$id_encuesta'>";
			      $i = 0; $j = 1;
				  while ($i < $n3){
			          $f3 = pg_fetch_array($r3,$i);
				      $opcion = $f3['opcion'];
				      $id_opt = $f3['id'];
					  $votos  = $f3['votos'];
					  $porcentaje = @(($votos * 100) / $votantes); 
				      
					  echo "<input type='hidden' name='opcion[$i]' value='$opcion'>";
				      echo "<input type='hidden' name='id_opt[$i]' value='$id_opt'>";
					  echo "<input type='hidden' name='votos[$j]'  value='$votos'>";
					  echo "<input type='hidden' name='porcentaje[$i]'  value='$porcentaje'>";
		              $i++; $j++;
				  }
				  echo "</form>";
				  echo "<html>
				       <body onload='form.submit()'>
					   </body>
                       </html>";
			 }					 
		  }	 
	   }
   }
} 
?>
<html>
<head><title></title>
</head>
<body></body>
</html>   	   	  	 		
			    		  	  	   
   
   
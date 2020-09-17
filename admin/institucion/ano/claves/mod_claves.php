<?

class Claves {
	
	public function Curso($conn,$ano){
		$sql="SELECT id_curso, grado_curso, letra_curso, nombre_tipo FROM curso c INNER JOIN tipo_ensenanza te ON 	c.ensenanza=te.cod_tipo WHERE id_ano=".$ano."
		ORDER BY cod_tipo, grado_curso, letra_curso ASC";
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	public function Claves($conn,$ano,$tipo,$curso){
		if($tipo==1){
			$sql= "select matricula.rut_alumno as rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu as nombres, matricula.id_curso from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";	
		}else{
			$sql = "select apoderado.rut_apo as rut, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo as nombres from matricula, apoderado, tiene2 where matricula.id_ano = ".$ano." and matricula.id_curso = ".$curso." and matricula.rut_alumno = tiene2.rut_alumno and apoderado.rut_apo = tiene2.rut_apo order by apoderado.ape_pat, apoderado.ape_mat";
		}
		
		$result =pg_exec($conn,$sql);
		return $result;
	}
	
	public function ModificaClave($conn,$rut,$estado){
		$sql="UPDATE accede SET estado=".$estado." WHERE id_usuario in (SELECT id_usuario FROM usuario WHERE nombre_usuario='".$rut."')";
		$result=pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	public function Estado($conn,$rut){
		$sql="SELECT estado FROM accede INNER JOIN usuario ON accede.id_usuario=usuario.id_usuario WHERE nombre_usuario='".$rut."'";
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}
	
	public function ClaveUsuario($conn,$rut){
		$sql="SELECT * FROM usuario WHERE nombre_usuario ='".$rut."'";
		$result=pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function EstadoBloqueo($conn,$rut){
		$sql="SELECT bloqueo FROM alumno WHERE rut_alumno=".$rut;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function ModificaBloqueo($conn,$rut,$estado,$tipo){
		$sql="UPDATE alumno SET bloqueo=".$estado." WHERE rut_alumno=".$rut;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function UsuarioCurso($connection,$conn,$curso,$estado,$tipo){
		if($tipo==1){
			$sql="SELECT rut_alumno FROM matricula WHERE id_curso=".$curso;
			$result = pg_exec($conn,$sql);
		}else{
			$sql="SELECT rut_apo as rut_alumno FROM tiene2 t INNER JOIN matricula m ON t.rut_alumno=m.rut_alumno WHERE id_curso=".$curso;
			$result = pg_exec($conn,$sql);
		}
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$sql="UPDATE accede SET estado=".$estado." WHERE id_usuario in (SELECT id_usuario FROM usuario WHERE nombre_usuario='".$fila['rut_alumno']."')";
			$rs_accede = pg_exec($connection,$sql);	
		}
		
		return $rs_accede;	
	}
	
	public function BloqueoCurso($conn,$curso,$estado,$tipo){
		if($tipo==1){
			$sql ="UPDATE alumno SET bloqueo=".$estado." WHERE rut_alumno IN (SELECT rut_alumno FROM matricula WHERE id_curso=".$curso.")";
		}else{
			$sql ="UPDATE alumno SET bloqueo=".$estado." WHERE rut_alumno IN (SELECT m.rut_alumno FROM tiene2 t INNER JOIN matricula m ON t.rut_alumno=m.rut_alumno WHERE m.id_curso=".$curso.")";
		}
		$result = pg_exec($conn,$sql);
		return $result;	
	}
	
	public function BuscaClave($conn,$usuario,$tipo,$rdb){
		$sql="SELECT * FROM usuario WHERE nombre_usuario = '".$usuario."' AND id_usuario IN (SELECT id_usuario FROM accede WHERE rdb = '".$rdb."')";	
		$result= pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function DatosUsuario($conn,$rut,$tipo,$ano){
		if ($tipo==1){
			$sql = "select matricula.rut_alumno as rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu as nombres from matricula, alumno where matricula.rut_alumno = ".$rut." and id_ano = ".$ano." and matricula.rut_alumno = alumno.rut_alumno";
			$result =@pg_Exec($conn,$sql);		
		}else{
			$sql = "select apoderado.rut_apo as rut, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo as nombres from apoderado where apoderado.rut_apo = ".$rut." ";
			$result =@pg_Exec($conn,$sql);			
		}	
		return $result;
	}
	
	public function GeneraClaveAlumno($conn,$connection,$ano,$rdb,$base){
		$sql = "SELECT rut_alumno FROM matricula WHERE rdb=".$rdb." AND id_ano=".$ano."" ;
		$rs_alumno = pg_exec($conn,$sql);
	 
	 
		$total_alum = @pg_numrows($rs_alumno);	
		
		for($i=0;$i<pg_numrows($rs_alumno);$i++){
			$fila_alumno = pg_fetch_array($rs_alumno,$i);
			$pw = substr("".$fila_alumno['rut_alumno']."",0,5);		
			
			$sql_existe = "SELECT id_usuario,pw FROM usuario WHERE nombre_usuario='".trim($fila_alumno['rut_alumno'])."'";
			$rs_existe = @pg_Exec($connection,$sql_existe);
			
			//si no existe el usuario
			if(pg_num_rows($rs_existe)==0){
				
			$sql= "INSERT INTO usuario (nombre_usuario, pw) VALUES ('".$fila_alumno['rut_alumno']."','".$pw."')";
			$Rs_usuario = @pg_exec($connection,$sql);
			
			$sql="SELECT id_usuario FROM usuario WHERE nombre_usuario='".trim($fila_alumno['rut_alumno'])."'";
			$rs_id_usuario = pg_exec($connection,$sql);
			$id_usuario = pg_result($rs_id_usuario,0);
			
			$sql = "INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".$id_usuario.",16,".$rdb.",1,".$base.",1)";
			$Rs_accede = @pg_exec($connection,$sql);

		
			}//fin no existe
			//si existe el usuario
			else{
				
					$sql_deac="delete from accede where id_usuario in(select id_usuario from usuario where nombre_usuario=".$fila_alumno['rut_alumno'].")";
					$rsdeac=@pg_Exec($connection,$sql_deac);
					
					
					//si el usuario existe solo una vez
					if(pg_numrows($rs_existe)==1){
						 $sql_in="INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".pg_result($rs_existe,0).",16,".$rdb.",1,".$base.",1)";
						  $rz=@pg_Exec($connection,$sql_in);
						 
					}
					
					//si el usuario existe mas veces
					else{
						
						 //ver si existe usuario con clave distinta
					$sql_veu ="select id_usuario,nombre_usuario,pw from usuario where nombre_usuario='".$fila_alumno['rut_alumno']."' and pw != '$pw'";
					$rs_veu = pg_exec($connection,$sql_veu);
					
					//si no encuentro nada
					if(pg_numrows($rs_veu)==0){
						$sql_veu2 ="select id_usuario,nombre_usuario from usuario where nombre_usuario='".$fila_alumno['rut_alumno']."' order by id_usuario desc limit 1 " ;
					$rs_veu2 = pg_exec($connection,$sql_veu2);
					
					$uidu = pg_result($rs_veu2,0);
									
					//borro a los demas usuarios iguales
					$sql_dede="delete from usuario where nombre_usuario='".$fila_alumno['rut_alumno']."' and id_usuario!='$uidu'";
					$rz_dede=@pg_Exec($connection,$sql_dede);
					
					 $sql_in="INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".$id_usuario.",16,".$rdb.",1,".$base.",1)";
					 $rz_in=@pg_Exec($connection,$sql_in);
					}
					//si encontre
					else{
						$sql_veu3 ="select id_usuario,nombre_usuario from usuario where nombre_usuario='".$fila_alumno['rut_alumno']."' and pw!='$pw' order by id_usuario asc limit 1 " ;
					$rs_veu3 = pg_exec($connection,$sql_veu3);
					$uidu3 = pg_result($rs_veu3,0);
					
					//$uidu3 = pg_result($rs_existe,0);
						//borro a los demas usuarios iguales
					 $sql_dede="delete from usuario where nombre_usuario='".$fila_alumno['rut_alumno']."' and id_usuario!=$uidu3";
					$rz_dede=@pg_Exec($connection,$sql_dede);
					
					 $sql_in="INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".$uidu3.",16,".$rdb.",1,".$base.",1)";
					 $rz_in=@pg_Exec($connection,$sql_in);	
					
					}
					
							
						 
						 
						 
						 
						
						}
					
					//
				
			
			//fin existe
			}
		}
		$sql="SELECT * FROM usuario WHERE id_usuario IN (SELECT id_usuario FROM accede WHERE rdb=".$rdb." AND id_perfil=16)";
		$rs_total = pg_exec($connection,$sql);
		
		if(pg_numrows($rs_total)>0){
			return $rs_total;
		}else{
			return $rs_total;
		}
	}
	
	public function GeneraClaveApoderado($conn,$connection,$ano,$institucion,$base){
		$sql_apoderado = " SELECT rut_apo from tiene2 as t2 
						   INNER JOIN matricula as m 
						   ON m.rut_alumno=t2.rut_alumno 
						   WHERE m.rdb=".$institucion." AND m.id_ano=".$ano."" ;
		$res_apoderado = @pg_Exec($conn,$sql_apoderado);

		$total_apoderado = @pg_num_rows($res_apoderado);
		
		for($i=0;$i<($total_apoderado);$i++){
		
		$fila1 = @pg_fetch_array($res_apoderado,$i);	
		
		$password = substr("".$fila1['rut_apo']."",0,5);			
		
			
		$sql_existe = "SELECT id_usuario FROM usuario WHERE nombre_usuario='".$fila1['rut_apo']."'";
		$res_existe = @pg_Exec($connection,$sql_existe);
		
		if(@pg_numrows($res_existe)==0){

			$insert_usuario = "INSERT INTO usuario (nombre_usuario, pw) VALUES ('".$fila1['rut_apo']."','".$password."')";
		    $Rs_usuario = @pg_exec($connection,$insert_usuario);

			$sql = "SELECT id_usuario FROM usuario WHERE nombre_usuario='".$fila1['rut_apo']."'";
			$res = @pg_Exec($connection,$sql);
			$max_id_usuario = pg_result($res,0);
			
		    $insert_accede = "INSERT INTO accede (id_usuario, id_perfil, rdb, estado) VALUES (".$max_id_usuario.",15,".$institucion.",1)";
			$Rs_accede = @pg_exec($connection,$insert_accede);
			
		}else{//si existe actualizo accede solamente con el rbd actual jijijiji
		   	$fila = @pg_fetch_array($res_existe,0);
			 
			$sql = "select * from accede where id_usuario = ".$fila['id_usuario']." and id_perfil = 15 and rdb = ".$institucion." ";
			$Rs_accede = @pg_exec($connection,$sql) or die ("ERROR".$sql); 
			 
		   if(pg_num_rows($Rs_accede)==0){
				$insert_accede   = "INSERT INTO public.accede 
				( id_usuario,id_perfil,rdb,id_sistema,id_base,estado ) VALUES ( ".$fila['id_usuario'].",15,".$institucion.",1,".$base.",1);";
				$Rs_accede = @pg_exec($connection,$insert_accede) or die ("ERROR".$insert_accede);
				
			}
		 }
	}
		return $Rs_accede;
	}
}

?>
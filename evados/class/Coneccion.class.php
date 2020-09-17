<?

class DBManager{
        
		var $Conect;
        public $BaseDatos;
		public $num_base;
        public $Servidor;
        public $Usuario;
        public $Clave;
		public $Port;
		
        public function __construct($ip,$idbase){
	            
			$this->Servidor = $ip;
			$this->num_base = $idbase;
	        
			
            if(($this->num_base == 1) && ($this->Servidor=='ip-172-31-0-119.ec2.internal') ){
				   $this->BaseDatos = "coi_final";	
				   $this->Usuario = "postgres";
				   $this->Clave = "f4g5h6.j";
				   $this->Port = "5432";
                };
			
			 if(($this->num_base == 2) && ($this->Servidor = "ip-172-31-13-9.ec2.internal")){
                    $this->BaseDatos = "coi_final_vina";
				    $this->Usuario = "postgres";
                    $this->Clave = "f4g5h6.j";
				    $this->Port = "5432";
				 };	
				
			 if(($this->num_base == 3) && ($this->Servidor = "192.168.1.11")){
					$this->BaseDatos = "coi_antofagasta";	
					$this->Usuario = "postgres";
				    $this->Clave = "f4g5h6.j";
				    $this->Port = "5432";
				};	
								
			  if(($this->num_base == 4) && ($this->Servidor = "ip-172-31-13-9.ec2.internal")){
			  	    $this->BaseDatos = "coi_corporaciones";	
                    $this->Usuario = "postgres";
                    $this->Clave = "f4g5h6.j";
				    $this->Port = "5432";
			     };
        }


       public function coi_usuario(){
 
        $connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario22");
		
		/******************* MODIFICACION DE PID DE POSTGRES ***************/
	/*if(isset($_PID)){
		
		$sql ="UPDATE control_users SET pid=".pg_get_pid($conn)." WHERE rdb_users=".$_INSTIT." and id_perfil=".$_PERFIL."  and pid=".$_PID;
		$result = @pg_exec($connection,$sql);
		
		$_PID = pg_get_pid($conn);
		session_register('_PID');
	}else{
		$_PID = pg_get_pid($conn);
		session_register('_PID');
		
		$hora = date("H:i:s");
		$fecha =date("m-d-Y");
		$sql="INSERT INTO control_users (rut_users,fecha,hora,ip_users,rdb_users,base_datos_users,pid,id_perfil) VALUES('$_NOMBREUSUARIO','$fecha','$hora','".$_SERVER['REMOTE_ADDR']."','$_INSTIT',$id_base,$_PID,$_PERFIL)";
		$result = pg_exec($connection,$sql) or die (pg_last_error($connection));
	}*/
	/***************** FIN *******************************************/

        if(!$connection){
		  return false;
		}else{  
		  return $connection; 
		 } 
		   
	   }


		public function conectar() {
				
		$cadenaconeccion = "dbname = ".$this->BaseDatos." host=".$this->Servidor." port = ".$this->Port." user = ".$this->Usuario."  password = ".$this->Clave." ";
		
		$Conect = pg_connect($cadenaconeccion);
		
		if(!$Conect){?>
			<script>
				alert("Sesion finalizada, por tiempo de espera");
				window.location="../../../web/index.html";
			</script>
    <?
		
		}
			
		//$connection=pg_connect("dbname=coi_usuario host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error de conex Coi_Usuario");
		
		/*if(isset($_PID)){
		
		$sql ="UPDATE control_users SET pid=".pg_get_pid($Conect)." WHERE rdb_users=".$_INSTIT." and id_perfil=".$_PERFIL."  and pid=".$_PID;
		$result = pg_exec($connection,$sql);
		
		$_PID = pg_get_pid($Conect);
		session_register('_PID');
	}else{
		$_PID = pg_get_pid($Conect);
		session_register('_PID');
		
		$hora = date("H:i:s");
		$fecha =date("m-d-Y");
		$sql="INSERT INTO control_users (rut_users,fecha,hora,ip_users,rdb_users,base_datos_users,pid,id_perfil) VALUES('$_NOMBREUSUARIO','$fecha','$hora','".$_SERVER['REMOTE_ADDR']."','$_INSTIT',$id_base,$_PID,$_PERFIL)";
		$result = pg_exec($connection,$sql) or die (pg_last_error($connection));
	}*/
			
			if(!$Conect){
				return false;
			}else{  
				return $Conect; 
				}    

		}
		
		public function Registro($pid,$rdb,$usuario,$perfil){
		
		$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario");
		
		/******************* MODIFICACION DE PID DE POSTGRES ***************/
	if(isset($_PID)){


		$sql ="UPDATE control_users_evados SET pid=".pg_get_pid($connection)." WHERE rdb_users=".$rdb." and id_perfil=".$perfil."  and pid=".$_PID;
		$result = @pg_exec($connection,$sql);
		
		$_PID = pg_get_pid($connection);
		session_register('_PID');
	}else{
		$_PID = pg_get_pid($connection);
		session_register('_PID');
		
		$hora = date("H:i:s");
		$fecha =date("m-d-Y");
		$sql="INSERT INTO control_users_evados (rut_users,fecha,hora,ip_users,rdb_users,base_datos_users,pid,id_perfil) VALUES('$usuario','$fecha','$hora','".$_SERVER['REMOTE_ADDR']."','$rdb',$id_base,$_PID,$perfil)";
		$result = pg_exec($connection,$sql) or die (pg_last_error($connection));
	}
	/***************** FIN *******************************************/	
		}
				

    }
	
	

?>

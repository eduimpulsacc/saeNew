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
	        
			
            if(($this->num_base == 1) && ($this->Servidor=='192.168.1.10') ){
				   $this->BaseDatos = "coi_final";	
				   $this->Usuario = "postgres";
				   $this->Clave = "f4g5h6.j";
				   $this->Port = "5432";
                };
			
			 if(($this->num_base == 2) && ($this->Servidor = "192.168.1.12")){
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
								
			  if(($this->num_base == 4) && ($this->Servidor = "192.168.1.12")){
			  	    $this->BaseDatos = "coi_corporaciones";	
                    $this->Usuario = "postgres";
                    $this->Clave = "f4g5h6.js";
				    $this->Port = "5432";
			     };
        }


       public function coi_usuario(){
 
        $connection=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario");

        if(!$connection){
		  return false;
		}else{  
		  return $connection; 
		 } 
		   
	   }


		public function conectar() {
		
		$cadenaconeccion = "dbname = ".$this->BaseDatos." host=".$this->Servidor." port = ".$this->Port." user = ".$this->Usuario."  password = ".$this->Clave." ";
		
			$Conect = pg_connect($cadenaconeccion) /*or die ("Error al Conectar")*/;
			
			if(!$Conect){
				//return false;
				header('location:../session/finSession.php');
				//sae3.0/session/
			}else{  
				return $Conect; 
				}    

		}
				

    }
/*class DBManager{
        
		var $Conect;
        public $BaseDatos;
        public $Servidor;
        public $Usuario;
        public $Clave;
		public $Port;
		
       public function DBManager($ip,$db){
	            
			$this->Servidor = $ip;
			$this->BaseDatos = $db;
			
            if(($this->BaseDatos == "coi_final") && ($this->Servidor == "10.132.10.36")){
				   $this->Usuario = "postgres";
				   $this->Clave = "cole#newaccess";
				   $this->Port = "5432";
                };
				
			 if(($this->BaseDatos == "coi_antofagasta") && ($this->Servidor = "200.29.70.184")){
					$this->Usuario = "postgres";
				    $this->Clave = "anto2010";
				    $this->Port = "5432";
				};	
				
             if(($this->BaseDatos == "coi_final_vina") && ($this->Servidor = "200.29.21.124")){
                    $this->Usuario = "postgres";
                    $this->Clave = "cole#newaccess";
				    $this->Port = "5432";
				 };	
								
			  if(($this->BaseDatos == "coi_corporaciones") && ($this->Servidor = "200.29.21.124")){
                    $this->Usuario = "postgres";
                    $this->Clave = "cole#newaccess";
				    $this->Port = "5432";
			     };
			   	
        }


		public function conectar() {
		
		$cadenaconeccion = "dbname = ".$this->BaseDatos." host=".$this->Servidor." port = ".$this->Port." user = ".$this->Usuario."  password = ".$this->Clave." ";
		
			$Conect = pg_connect($cadenaconeccion);
			
			if(!$Conect){
				return false;
			}else{  
				return $Conect; 
			}    
		   $this->Conect;
		}
				

    }*/

?>


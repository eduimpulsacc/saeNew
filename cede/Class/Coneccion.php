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
				   $this->Clave ="f4g5h6.j";
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
								
			  if(($this->num_base == 4) && ($this->Servidor = "192.168.1.11")){
			  	    $this->BaseDatos = "coi_corporaciones";	
                    $this->Usuario = "postgres";
                    $this->Clave = "f4g5h6.j";
				    $this->Port = "5432";
			     };
			   	
        }


		public function conectar(){
		
	 $cadenaconeccion = "dbname = ".$this->BaseDatos." host=".$this->Servidor." port = ".$this->Port." user = ".$this->Usuario."  password = ".$this->Clave." ";
		
			$Conect = pg_connect($cadenaconeccion) or die ("Error al Conectarr");
			
			if(!$Conect){
				return false;
			}else{  
				return $Conect; 
				}    
		   $this->Conect;
		}
				

    }

?>

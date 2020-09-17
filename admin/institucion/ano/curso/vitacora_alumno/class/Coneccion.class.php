<?
class DBManager{
        
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
				

    }

?>




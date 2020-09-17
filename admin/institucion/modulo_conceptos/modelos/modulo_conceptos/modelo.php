<?  
class ModuloConceptosModelo{
	
	public $miconecta;
	public $nombretabla = 'modulo_conceptos';
	
	function __construct($eyo) {
		//echo "datos-->".pg_port($eyo);
		$this->miconecta = $eyo;
	 	}
	 
		public  function procesar_sql($s){
		   $rs = pg_exec($this->miconecta,$s); //or die ( pg_last_error($this->miconecta)."Error : ".$s);
		   return $rs;
		}
		
		// para mostrar datos cruzados 
		public  function Select_Total($ano,$rdb)
		{

		  if((!empty($ano)) and (!empty($rdb))){	
		  	$sql = "SELECT id,nombre_concepto,valor_numerico,rango_x,rango_y 
		  	FROM  public.modulo_conceptos WHERE id_ano=$ano AND id_rdb=$rdb ORDER BY id;";
		  	return $rs = $this->procesar_sql($sql);
		  }
		 }
		
		/* Con este Metodo Se arman los formularios de ingreso y modificacion 
		depende del orden de los campos como de mostraran en el formulario */
	    public  function Select_SoloTabla($filtro)
		{
		  $where = "";
		  if(!empty($filtro)) $where  =  "WHERE id = $filtro";
		  	$sql = "SELECT nombre_concepto,valor_numerico,rango_x,rango_y 
		  	FROM  public.modulo_conceptos $where ;";
		  	return $rs = $this->procesar_sql($sql);
		  }
		
		
		/*Este Formulario sera Cargado Sin Alias ya que es para validar si los campos son Forania Key y los values*/	
		public  function Select_SoloTabla_sinalias()
		{
		   $sql = "SELECT nombre_concepto,valor_numerico,rango_x,rango_y FROM  public.modulo_conceptos;";
		   return $rs = $this->procesar_sql($sql);
		}
		
		
	     public function Insert_Into($id_ano,$rdb,$datos){

         $sql = "SELECT * FROM public.modulo_conceptos WHERE id_ano=".$id_ano." AND id_rdb=".$rdb." AND nombre_concepto='".$datos[0]."' "; 
		 $result = $this->procesar_sql($sql);
		 
		 if(pg_num_rows($result)==0){
		 
		   settype($datos[1],"integer");
		   settype($datos[2],"integer");
		   settype($datos[3],"integer");
		 		 		 
		   if(empty($datos[0])) return false;
		   if(empty($datos[1])) return false;
		   if(empty($datos[2])) return false;
		   if(empty($datos[3])) return false;
		 
		   if(!(($datos[1]>=10) and ($datos[1]<=70))) return false;
		   if(!(($datos[2]>=10) and ($datos[2]<=70))) return false;
		   if(!(($datos[3]>=10) and ($datos[3]<=70))) return false;
		  
		 $nombre_concepto = strtr(strtoupper($datos[0]), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
		 
		 $sql = "INSERT INTO public.modulo_conceptos ( id_ano,id_rdb,nombre_concepto,valor_numerico,rango_x,rango_y ) 
				 VALUES ( ".$id_ano.",".$rdb.",'".$nombre_concepto."',".$datos[1].",".$datos[2].",".$datos[3]." );";
				 $r = $this->procesar_sql($sql);
				 	 
           		 return true;
		 
		 }else{
			 
			 return true;
			 
			 }
		 }
	

		public function  Update($Datos){
		   $sql = "UPDATE 
					  public.modulo_conceptos  
					SET 
					  nombre_concepto = '".$Datos[1]."',
					  valor_numerico = ".$Datos[2].",
					  rango_x = ".$Datos[3].",
					  rango_y = ".$Datos[4]."
					WHERE id=".$Datos[0].";"; 
		   return $rs = $this->procesar_sql($sql);  
		}
		
					
	  public function Delete($id){
		$sql = "DELETE FROM public.modulo_conceptos WHERE  id = $id ;";
		return $rs = $this->procesar_sql($sql); 
	  }	
          
  
  }

?>
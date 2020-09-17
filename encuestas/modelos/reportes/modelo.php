<?  
class ReportesModelo{
	
	
	public  $miconecta;
	public $nombretabla = 'respuestas_encuestas';
	
	
	
	function __construct($eyo) 
	{
		$this->miconecta = $eyo;
	 }
	 
	 
		public  function procesar_sql($s)
		{
		   $rs = pg_exec($this->miconecta,$s) or die ( pg_last_error($this->miconecta)."Error : ".$s);
		   return $rs;
		}
   	 
   	    
  }
?>
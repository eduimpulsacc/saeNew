<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Coneccion.php";

class Plantillas {
	   
		public $Conec;
	
		//constructor 
		public function __construct($ip,$bd){
			$this->Conec = new DBManager($ip,$bd);
		 } 
       
	   
      public function carga_ensenanzas($int){
	  $sql = "SELECT TE.nombre_tipo,TE.cod_tipo,TEI.cod_decreto  FROM tipo_ense_inst AS TEI 
	  INNER JOIN tipo_ensenanza AS TE ON TEI.cod_tipo=TE.cod_tipo 
	  WHERE TEI.rdb=$int and TEI.estado <> 2 order by 2 ";
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
	  if($regis){ return $regis; }else{ return false; }} 
	   
	   
      //**************PLANTILLAS********************************// 
	  public function cargaplantillas($id_bloque,$id_nacional){
	  	
	  $sql = "SELECT  id_plantilla,rdb,ensenanza,fecha_creacion,
	  nombre,primera,segunda,tercera,cuarta,quinta,sexta,septima,octava,estado,tipo_plantilla,persona 
	  FROM cede.plantilla_apo order by tipo_plantilla  ;";
	 
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
	 
	  if($regis){ return $regis; }else{ return false; }} 
  
	  public function buscar_plantilla($id_plantilla,$rdb){
	 echo  $sql = "SELECT  id_plantilla,rdb,ensenanza,fecha_creacion,
	  nombre,primera,segunda,tercera,cuarta,quinta,sexta,septima,
	  octava,estado FROM cede.plantilla_apo WHERE id_plantilla = ".$id_plantilla." and rdb=".$rdb."";
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
	  if($regis){ return $regis; }else{ return false; 	}}
	
	   public function insertar_plantilla($id_bloque,$nombre_plantilla,$id_instit,$tipo_plantilla,$personas){
	   $nombre_plantilla = utf8_decode($nombre_plantilla);
	   $sql = "INSERT INTO cede.plantilla_apo
	   (id_plantilla,rdb,ensenanza,fecha_creacion,nombre,estado,tipo_plantilla,persona) 
	   VALUES (DEFAULT,$id_instit,$id_bloque,CURRENT_DATE,'$nombre_plantilla',1,'$tipo_plantilla','$personas');";
       $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 1" );
	   if($regis){ return true; }else{ return false; }
	   }
       
	   public function actualizar_plantilla($id_plantilla,$id_bloque,$nombre_plantilla,$tipo_plantilla,$personas){
	   $nombre_plantilla = utf8_decode($nombre_plantilla);
	   $sql = "UPDATE cede.plantilla_apo SET  ensenanza = $id_bloque,nombre = '$nombre_plantilla'  WHERE  id_plantilla = $id_plantilla;";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 1" );
	   if($regis){ return true; }else{ return false; }
	   }
       
       public function eliminar_plantilla($id_plantilla){
	   $sql = "DELETE FROM cede.plantilla_apo WHERE id_plantilla= $id_plantilla;";
       $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 1" );
	   if($regis){ return true; }else{ return false; }
	   }
       //*************FIN**************///
    
	
	
//******************ADMINISTRA AREAS**************************//

   public function carga_areas($id_pl){
   $sql = "SELECT id_area,id_plantilla,nombre,orden FROM cede.plantilla_apo_area WHERE id_plantilla= $id_pl;";
   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 222" );
   if($regis){ return $regis; }else{ return false; }} 
  
   public function buscar_area($id_area){
   $sql = "SELECT  id_area,id_plantilla,nombre,orden FROM 
   cede.plantilla_apo_area WHERE id_area = ".$id_area."";
   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 222" );
   if($regis){ return $regis; }else{ return false; 	}}
	
   public function insertar_area($id_plantilla,$nombre_area){
   $nombre_area = utf8_decode($nombre_area);
   $sql = "INSERT INTO cede.plantilla_apo_area
   ( id_area,id_plantilla,nombre,orden) VALUES ( DEFAULT,$id_plantilla,'$nombre_area',0);";
   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 222" );
   if($regis){ return true; }else{ return false; } }
   
   public function actualizar_area($nombre_area,$id_area){
   $nombre_area = utf8_decode($nombre_area);
   $sql = "UPDATE cede.plantilla_apo_area  SET nombre='$nombre_area' WHERE id_area = $id_area;";
   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 222" );
   if($regis){ return true; }else{ return false; } }
   
   public function eliminar_area($id_area){
   $sql = "DELETE FROM cede.plantilla_apo_area WHERE id_area = $id_area;";
   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 222" );
   if($regis){ return true; }else{ return false; }}
   
   //**************************************************//
	
	
		//*********ADMINISTRA ITEMS**************************** 
		
		public function carga_items($id_nacional,$id_plantilla,$id_area){
		if($id_plantilla!=0) $where_plantilla = " WHERE id_plantilla = ".$id_plantilla." ";		
		if($id_area!=0)  $where_area = " AND id_area = ".$id_area." ; ";
		$sql = "SELECT id_plantilla,id_area,id_item,nombre,orden
		FROM cede.plantilla_apo_item $where_plantilla  $where_area;";			
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( " Error bd Select 4 " );
		if($regis){ return $regis; }else{ return false; } }
	   
		public function buscar_items($id_item){
		$sql = "SELECT id_plantilla,id_area,id_item,nombre,orden FROM 
		cede.plantilla_apo_item WHERE id_item = ".$id_item."";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
		if($regis){ return $regis; }else{ return false; 	}}
		
		public function insertar_item($id_area,$id_plantilla,$nombre_item){
		$nombre_item = utf8_decode($nombre_item);
		$sql = "  INSERT INTO cede.plantilla_apo_item
		(id_plantilla,id_area,id_item,nombre,orden) 
		VALUES ($id_plantilla,$id_area,DEFAULT,'$nombre_item',0 );";
		$regis = @pg_Exec( $this->Conec->conectar(),$sql );
		if($regis){ return true; }else{ return false; }}
			
	   public function actualizar_item($nombre_item,$id_item){
	   $nombre_item = utf8_decode($nombre_item);
	   $sql = "UPDATE cede.plantilla_apo_item  SET nombre='$nombre_item' 
	   WHERE id_item=$id_item ;";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 30" );
	   if($regis){ return true; }else{ return false; }}
	
	   public function eliminar_item($id_item){
	   $sql = "DELETE FROM cede.plantilla_apo_item WHERE id_item=$id_item;";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 3" );
	   if($regis){ return true; }else{ return false; }
	   
	   }
	   
	   //******************FIN ITEMS*****************************************//
   	   
	   
	   //***********************CONCEPTOS*************************************//
	   public function carga_conceptos($id_plantilla){
	   $sql = "SELECT id_concepto,id_plantilla,glosa,nombre,sigla FROM 
       cede.plantilla_apo_concepto WHERE id_plantilla = $id_plantilla";	
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( " Error bd Select 5.6 " );
	   if($regis){ return $regis; }else{ return false; } }
	   
	   public function buscar_concepto($id_concepto){
	   $sql = "SELECT id_concepto,id_plantilla,glosa,nombre,sigla
       FROM cede.plantilla_apo_concepto WHERE id_concepto = ".$id_concepto."";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Buscar 5.6" );
	   if($regis){ return $regis; }else{ return false; 	}}
			   
	   public function inserta_concepto($id_plantilla,$glosa,$nombre,$sigla){
	   $sql = "INSERT INTO cede.plantilla_apo_concepto
       (id_concepto,id_plantilla,glosa,nombre,sigla) 
       VALUES (DEFAULT,$id_plantilla,'$glosa','$nombre','$sigla');";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( " Error bd Insert 5.6 " );
	   if($regis){ return true; }else{ return false; }}
	   
	   public function actualizar_concepto($id_concepto,$nombre_concepto,$sigla,$glosa){
	   $nombre_concepto = utf8_decode($nombre_concepto);
	   $sql = "UPDATE cede.plantilla_apo_concepto  SET glosa='$glosa',
		nombre='$nombre_concepto',sigla='$sigla' 
	   WHERE id_concepto=$id_concepto;";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 30" );
	   if($regis){ return true; }else{ return false; }}
	   
	   public function eliminar_concepto($id_concepto){
	   $sql = "DELETE FROM cede.plantilla_apo_concepto WHERE id_concepto = $id_concepto";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 3" );
	   if($regis){ return true; }else{ return false; }}
	   
	   /*****************************************************************************/
	   
    
	public function vistaprevia($id_plantilla){
	
	  $sql = "SELECT  * FROM cede.plantilla_apo WHERE id_plantilla = $id_plantilla;";
	  $regis0 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
		
		  if($regis0){
			$fila = pg_fetch_array($regis0,0);
			$nombre_plantilla = $fila['nombre'];
			$id_plantilla = $fila['id_plantilla'];
			
		  }else{
		   echo "No Encontrado";
		  }
		
	$table = "<table border=1 style='border-collapse:collapse'  id='vistaprevia' width='100%' >
	<tr><th colspan='4' >".$nombre_plantilla."</th></tr>";
		
	$sql = "SELECT  * FROM cede.plantilla_apo pla
					INNER JOIN cede.plantilla_apo_area plaa ON plaa.id_plantilla = pla.id_plantilla
					WHERE  pla.id_plantilla = ".$id_plantilla.";";
	$regis1 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		
	if($regis1){
			 
	for($e=0;$e<pg_numrows($regis1);$e++){
			  
	$fila = pg_fetch_array($regis1,$e);
	$nombre_area = $fila['nombre'];
	$id_area = $fila['id_area'];
	$id_plantilla = $fila['id_plantilla'];
				
	$table .= "<tr><td colspan='1' width='3%' >&nbsp;>&nbsp;</td><td><strong>".$nombre_area."</strong></td></tr>";
			  
				 $sql = "SELECT
								plai.nombre FROM cede.plantilla_apo_area plaa
								INNER JOIN cede.plantilla_apo_item plai ON plai.id_area = plaa.id_area AND plai.id_plantilla = 
								plaa.id_plantilla
								WHERE plaa.id_area = ".$id_area.";";

				 $regis2 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
		
				  if($regis2){
					
				  for($t=0;$t<pg_numrows($regis2);$t++){
					  
				  $fila = pg_fetch_array($regis2,$t);
				  $nombre = $fila['nombre'];
				  $id = $fila['id_item'];
				  
				  $table .= "<tr><td>&nbsp;&nbsp;</td><td>
				  <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$nombre.
				  "&nbsp;&nbsp;&nbsp;</strong></td></tr>";
					   
				  } // for 2
				  
				  }else{
				  
				  echo "No Encontrado";
				  
				  } 
			  
			 } // for 1 
			 
		  }else{
		   echo "No Encontrado";
		  }
		
		echo $table .= "</table>";
        
		//return $table;
	
	 } // fun metodo vista previa

			 
    } // FIN FUNCION


?>
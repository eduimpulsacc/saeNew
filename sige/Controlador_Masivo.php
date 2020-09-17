<?  
// Desarrollo  Controlador Maximus
 //Programador : Patricio Cardenas
 // Fecha :  18/04/2012
//require_once('../util/header.inc');
header( 'Content-type: text/html; charset=iso-8859-1' );

  function listar_directorios_ruta($ruta)
  {
		$array = array();
		$e = 0;
		if (is_dir($ruta)) 
		{
			      if ($dh = opendir($ruta)) 
			      {
			         while (($file = readdir($dh)) !== false) 
			         {
			            if (is_dir($ruta . $file) && $file!="." && $file!="..")
			            {
							$array[$e]  = $ruta.$file."/modelo.php";
							$e++;
						    listar_directorios_ruta($ruta.$file ."/");
						}
			         }
			      		closedir($dh);
				  		return $array;
			      }
		}else{
			echo "<br>No es ruta valida";
		}
	} 
	
    $ARREGLO = listar_directorios_ruta("../modelos/"); 

	$archivo= "modelos.php";
	$gestor = fopen($archivo, "w");
	for ($i=0; $i < count($ARREGLO); $i++) { 
	  fwrite($gestor, "<?php \n require_once '".$ARREGLO[$i]."'; \n ?>"); 
	}
	fclose($gestor);
	chmod('modelos.php',0777); 
	
   require_once ('modelos.php');   
				 
	class Controlador_Masivo {
			
			public  $conector;
			public $modelo;
			public $vista;
			public $conn;
			
			 public function __construct ($y,$v,$m) 
			 {   
				$this->vista = $v;
				$this->modelo = $m;
				$this->conector = new $this->modelo($y);		 
			    $this->conn =  $y;
			 }


	          public function Listado_Resultados($sql) 
	          {
				 echo '<script language="javascript">
						 $("#enlace").click(function(event) {
						 $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
						 $("#FormularioExportacion").submit();
						 });
					</script>';
				 
				 echo '<form action="vistas/exportar_exel.php" method="post" target="_blank" id="FormularioExportacion">';
				 
				 echo '<a id="enlace" class="botonXX" title="[ Exportar ]" href="#">[ Exportar ]</a>';
				 
				 echo '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /></form>';
				 
				 echo "<br/>"; 
				 
				 echo $this->Enlace('[ Volver a Buscador ]',array('var'=>'1'));
			     
				 echo "<br/><br/>";	
				 
				 echo "<table border=1  style='border-collapse: collapse;'  width='100%'  id='Exportar_a_Excel' >";
				 
				 echo $this->Encabezados_Resultados($sql);
			 
				 $result = $this->conector->procesar_sql($sql);
				 
				 $e = pg_num_fields($result);
				 
				 		for ($i=0; $i < pg_num_rows($result) ; $i++) 
				 		{
				 			echo "<tr>";   
							
							$fila =  pg_fetch_array($result,$i);
						    
							for ($q=0; $q < $e ; $q++)
							{
							
							   $dato = strtr(strtolower($fila [$q]), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú");
						       echo "<td  height='20' >".ucwords($dato)."</td>";
							   $campos[pg_field_name($result,$q)] = $fila [$q];
					        
							}
							
							echo "</tr>";
						}
						
				  echo "</table>";
			  }
			  
			
	          public function Listado_Datos($a,$acciones) 
	          {
				 echo $this->Enlace('[ Agregar Nuevo ]',array('var'=>'2'));
			     echo "<br/><br/>";	
				 echo "<table border=1 style='border-collapse: collapse;' width='90%' >";
				 
				 echo $this->Encabezados($a);
			 
				 $result = $this->conector->Select_Total();
				 
				 $e = pg_num_fields($result);
				 		for ($i=0; $i < pg_num_rows($result) ; $i++) 
				 		{
				 			echo "<tr>";   
							$fila =  pg_fetch_array($result,$i);
						    for ($q=0; $q < $e ; $q++)
							{
							   $dato = strtr(strtolower($fila [$q]), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú");
						       echo "<td  height='20' >".ucwords($dato)."</td>";
							   $campos[pg_field_name($result,$q)] = $fila [$q];
					        }
						   if(!empty($acciones)){
						   	
							$action ="";

								  $action .="&nbsp;".$this->enlace($acciones[0][0],array('var'=>$acciones[0][1],'id'=>$fila[0]))."&nbsp;";
                                  $action .="&nbsp;".$this->enlace($acciones[1][0],array('var'=>$acciones[1][1],'id'=>$fila[0]))."&nbsp;";
								  $action .="&nbsp;".$this->enlace($acciones[2][0],array('var'=>$acciones[2][1],'id'=>$fila[0]));
																				
							 echo "<td width='20%' style='padding: 10px' >".$action."</td>";							   
						   
						   }else{
							
								$b = $this->enlace('M',array('var'=>'4','id'=>$fila[0]));
						        $c = $this->enlace('E',array('var'=>'6','id'=>$fila[0]));	
								
							   	echo "<td >&nbsp;$b&nbsp;$c</td>";	
						   
						   }
							echo "</tr>";
						}
				  echo "</table>";
			  }
			  
			  
			  public function Form_Agregar() 
			  {
         
			    $array_tablas  = array();
				$array_tablas =  $this->Campos_Foreing_Key();   
				 				
				$ax =  $this->enlace('[Listado de Registros]',array('var'=>'1'));	
				$b =  $this->enlace('[Guardar Datos]',array('var'=>'3'));
				
		        echo ' <h1>Nuevo Resgistro</h1>
		        <form id="form_patoc" name="form_patoc" >
		        <table  border=0  style="border-collapse: collapse;"  width="%" >';
				
				$result = $this->conector->Select_SoloTabla();
				$result_2 = $this->conector->Select_SoloTabla_sinalias();
				
				$e = pg_num_fields($result);
				
				for ($j = 0; $j < $e; $j++) 
				{
						
				$campo[$j] = pg_field_name($result,$j); 			   		// es solo para mostrar los nombres  en el formulario
				$campo_2[$j] = pg_field_name($result_2,$j);   		// es solo para validar campos e indicar sus foreneas keys
					
				echo "<tr><td height='40' ><strong>".ucwords($campo[$j])." : </strong></td>";
  
  				$tabla_primaria= array_search($campo_2[$j],$array_tablas);   
  
				if($tabla_primaria != NULL)
				{
				
				  echo '<td>'.$this->carga_select($r='',"cmb_".$tabla_primaria,$this->Retorno_Array_Select("SELECT * FROM  ".$tabla_primaria." ORDER BY 1")) .'</td>';
				
				}else{
				  
				  echo $this->CardadorElement($a='',pg_fieldtype($result, $j),$campo_2[$j]);
				  
				  }
				
				}
	   
				echo   '</tr>
				              <tr>
				              <td>&nbsp;<br/></td>
				              </tr>
				              <tr>
					          <td>&nbsp;'.$b.'&nbsp;</td>
					          </tr>
					          <tr>
					          <td>&nbsp;'.$ax.'&nbsp;</td>
					          </tr>
					          </table><form> ';
										   						
			 }




        public function CardadorElement($dato='',$value='',$name='')    
        {
                 
		if($value==="varchar") return '<td><input  type="text"  value=" '.$dato.' " id='.$name.' name='.$name.' maxlength="1180" max="1180" /></td>';	
		
		if($value === "text") return '<td><textarea name='.$name.'  cols="50" rows="5">'.$dato.'</textarea></td>';
		
		if($value==="int4") return   '<td><input  type="text"  value=" '.$dato.' "  id='.$name.' name='.$name.' maxlength="180" max="180" /></td>';	
		
		if($value==="bool") return  '<td>'.$this->carga_select($dato,"cmb_estado",array('t'=>'TRUE','f'=>'FALSE')).'</td>';		 
		
					if($value==="date"){ 
					
					echo '<td><script language="JavaScript" type="text/javascript">
										$( ".fecha" ).datepicker({
											dateformat: "mm-yy-dd",    });
											$.datepicker.regional["es"]
								</script>
								<input  type="text"  value=" '.$dato.' " id='.$name.' name='.$name.'  class="fecha"  maxlength="15" max="15" /></td>';
					     
					       }

		/*if($value==="date") 
		{

			$A=htmlentities("Año",ENT_QUOTES,'UTF-8');
			return '<td>'.$A.'&nbsp;:&nbsp;'.$this->carga_select($name."_ano",
			array('2012'=>'2012','2013'=>'2013')).' Mes &nbsp;:&nbsp; '.$this->carga_select($name."_mes",
			array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril',
			'5' => 'Mayo','6' => 'Junio','7' => 'Julio',
			'8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre',
			'11' => 'Noviembre','12' => 'Diciembre',))
			.' Dia &nbsp;:&nbsp; '.$this->carga_select($name."_dia",
			array('1' => '1','2' => '2','3' => '3','4' => '4',
			'5' => '5','6' => '6','7' => '7','8' => '8',
			'9' => '9','10' => '10','11' => '11',
			'12' => '12','13' => '13','14' => '14',
			'15' => '15','16' => '16','17' => '17',
			'18' => '18','19' => '19','20' => '20',
			'21' => '21','22' => '22','23' => '23',
			'24' => '24','25' => '25','26' => '26',
			'27' => '27','28' => '28','29' => '29',
			'30' => '30','31' => '31')).'</td>'; 
		    
		    }*/

		
         }
			
			public function VolverInicio()
			{
			    
				return  "<script language='JavaScript' type='text/javascript'>enviapag('".$this->vista."?var=1')</script >";
			    	
			}
			
			  
	  		  public  function    Guardar($Array)
	  		  {
	  		  	
				/*echo "<pre>";
				print_r($Array);
				echo "</pre>";*/
				
			   $datos = array();
			   foreach($Array as $c=>$v)
			            $datos[] = $v;
			   
		      $result = $this->conector->Insert_Into($datos); 
			   
			    if($result){ 
			   
			      echo $this->VolverInicio();
			  
				}else{
							
					echo "<h1>Error al Guardar</h1><br/>";
					echo $a =  "<u>".$this->enlace('Listado de Registros',array('var'=>'1'))."</u><br/>";
											   
				}
				
			  
		     //echo "<pre>";  print_r($this->Valor_Validacion());  echo "</pre>";  
			
			/*	
				is_int(23);
				foreach($pruebas as $element)
				{
				    if(is_numeric($element)) {
				        echo "'{$element}' es numérica", PHP_EOL;
				    }
				    else {
				        echo "'{$element}' NO es numérica", PHP_EOL;
				    }
				}

			   if (is_string("23")) {
				    echo "es una cadena\n";
				} else {
				    echo "no es una cadena\n";
				}
                */

			  /*
			   	$a =  $this->enlace('Listado de Sistemas',array('var'=>'1'));	
			   
				if(empty($name)){
						return "<h2>EL dato Ingresado&nbsp;".$name."&nbsp;No es Valido</h2><br/>$a<br/>";
				}else{
				if(!is_numeric($name)){		
			   * 				
				   if($this->Insert_Sistema($name)){ 
				       return "<h2>Nombre de Sistema&nbsp;".$name."&nbsp;Guardado</h2><br/>$a<br/>";
	     			}else{
				       return "<h2>Nombre de Sistema&nbsp;".$name."&nbsp;No fue Guardado</h2><br/>$a<br/>";
					}
				
			   * }else{
					return "<h2>EL dato Ingresado&nbsp;".$name."&nbsp;No es Valido</h2><br/>$a<br/>";
				}
				} */
		     
			  } 


			   
			   public function Eliminar($Datos){
                
				$a =  $this->enlace('Listado de Registros',array('var'=>'1'));	
				
						if( 	$this->conector->Delete($Datos['id'])		){
							return "<h2>El Registro Ha sido Eliminado</h2><br/>$a<br/>";
						}else{
							return "<h2>No se pudo Eliminar intentelo más tarde</h2><br/>";
						}
			
			 	}
						


              public function functionPrint_r($value='')
              {
                  	echo "<pre>";
                  	print_r($value);
                  	echo "</pre>";
              }




         	 public  function Form_Modificar($Datos){
						
			     //$this->functionPrint_r($Datos);
	 
			    $array_tablas  = array();
				$array_tablas =  $this->Campos_Foreing_Key();   
				 				
				$a =  $this->enlace('[Listado de Registros]',array('var'=>'1'));	
				$b =  $this->enlace('[Modificar Datos]',array('var'=>'5','id'=>$Datos['id']));
				
		        echo ' <h1>Nuevo Resgistro</h1>
		        <form id="form_patoc" name="form_patoc" >
		        <table  border=0  style="border-collapse: collapse;"  width="%" >';
				
				$result = $this->conector->Select_SoloTabla($Datos['id']);
				
				$result_2 = $this->conector->Select_SoloTabla_sinalias();
				
				$e = pg_num_fields($result);
				
               $fila =  pg_fetch_array($result,0);
               
				
				for ($j = 0; $j < $e; $j++) 
				{
						
				$campo[$j] = pg_field_name($result,$j); 			   		// es solo para mostrar los nombres  en el formulario
				$campo_2[$j] = pg_field_name($result_2,$j);   		// es solo para validar campos e indicar sus foreneas keys
					
				echo "<tr><td height='40' ><strong>".ucwords($campo[$j])." : </strong></td>";
  
  				$tabla_primaria= array_search($campo_2[$j],$array_tablas);   
                
				$xx =$fila[$j];
				
						  if($tabla_primaria != NULL)
						  {
							echo '<td>'.$this->carga_select($xx,"cmb_".$tabla_primaria,$this->Retorno_Array_Select("SELECT * FROM  ".$tabla_primaria." ORDER BY 1")) .'</td>';
						  }else{
						  	echo $this->CardadorElement($xx,pg_field_type($result, $j),$campo_2[$j]);
						  }
				
				}
	   
				echo   '</tr>
				              <tr>
				              <td>&nbsp;<br/></td>
				              </tr>
				              <tr>
					          <td>&nbsp;'.$b.'&nbsp;</td>
					          </tr>
					          <tr>
					          <td>&nbsp;'.$a.'&nbsp;</td>
					          </tr>
					          </table><form> ';
										   						

			
				               }


            
			 public function Modificar($Array){
				
	//		$this->functionPrint_r($Array);
				
			   $Datos = array();
			   foreach($Array as $c=>$v)
			            $Datos[] = $v;
			   
//			   $this->functionPrint_r($Datos);
			   
		       
		       $result = $this->conector->Update($Datos); 
			   
			    if($result){ 
			   
			      echo $this->VolverInicio();
			  
				}else{
							
					echo "<h1>Error al Modificar</h1><br/>";
					echo $a =  "<u>".$this->enlace('Listado de Registros',array('var'=>'1'))."</u><br/>";
											   
				}
				
				
				/*$a =  $this->enlace('Listado de Sistemas',array('var'=>'1'));	
				
				if(empty($name)){
						return "<h2>EL dato Ingresado&nbsp;".$name."&nbsp;No es Valido</h2><br/>$a<br/>";
				}else{
					
				if(!is_numeric($name)){		
				
					if( 	$this->Modificar_Sistema($id,$name) 	){ 
				       return "<h2>Nombre de Sistema&nbsp;".$name."&nbsp;Guardado</h2><br/>$a<br/>";
	     			}else{
				       return "<h2>Nombre de Sistema&nbsp;".$name."&nbsp;No fue Guardado</h2><br/>$a<br/>";
					}
				
				}else{
					return "<h2>EL dato Ingresado&nbsp;".$name."&nbsp;No es Valido</h2><br/>$a<br/>";
				}

				}*/
				
   	          }
			
           
		   
		   
		   
		   
		   
		   
			
			public function Agregar_Tiporespuestas($datos,$con)
			{
					
				echo "<h1><u>Tipo de Respuestas</u></h1>";
						
				$result = $this->conector->Select_Buscador($datos['id']);
				$pregunta = pg_result($result,0);
				
				echo "<h5>Pregunta :</h5>";
				echo "<h3>".$pregunta."</h3>";
				  
				$objtiporespuesta = new TipoRespuestasModelo($con);       
				$result  = $objtiporespuesta->Select_Total();
				   
				echo "<br/><form id='form_patoc' name='form_patoc' ><table border=1 width='90%' >";
				   
				for ($i=0; $i < pg_num_rows($result); $i++) 
				{ 
					$fila =  pg_fetch_array($result,$i);
					echo "<tr>";
					echo "<td>".$fila[0]."</td>";
					echo "<td>".$fila[1]."</td>";
					echo "<td>".$fila[2]."</td>";
					echo "<td><input type='checkbox'' name='check[".$i."]' value='".$fila[0]."' ></td>";
					echo "</tr>";  					
				}        

				echo "</table></form><br/>";   
				
				echo $this->enlace('Guardar Datos',array('var'=>'8','id'=>$datos['id']))."<br/><br/>";	
				
				echo $this->enlace('Listado de Preguntas',array('var'=>'1'))."<br/>";		

				return;     
				
			}
			
			
			public function Guardar_Tiporespuestas($datos,$conn)
			{
				$array = $datos['check'];
				
				foreach(	$array as $i=>$v		)
				{
				  	
				  $sql = "INSERT INTO  encuesta.relacion_preg_tip_resp
							    ( id_preg,id_tip_resp ) 
							   VALUES (".$datos['id'].",".$v.");";
			      $result =  $this->conector->procesar_sql($sql); 
				 
			     }
				
			    if( $result ){
				 	
					echo $this->VolverInicio();
					
				 }else{
				 	
					echo "<h1>Datos no Guardados</h1><br/>";
					echo $a =  "<u>".$this->enlace('Listado de Preguntas',array('var'=>'1'))."</u><br/>";	
					
				 }  
			
			}
			
			
			public function Nombre_Tablas()
			{
					
				
			}  
			  
			  
			  public function Campos_Foreing_Key()
			  {
                
				
			$campos_fk = array();
				
			  $nametable = $this->conector->nombretabla;

			   $sql =  "SELECT  tc.constraint_name,tc.table_name AS fy_table_name, 
							kcu.column_name AS fk_column_name,ccu.table_schema, 
							ccu.table_name AS py_table_name,ccu.column_name AS py_column_name 
							FROM information_schema.table_constraints AS tc 
							JOIN information_schema.key_column_usage AS kcu ON tc.constraint_name = kcu.constraint_name 
							JOIN information_schema.constraint_column_usage AS ccu ON ccu.constraint_name = tc.constraint_name 
							WHERE tc.constraint_type = 'FOREIGN KEY' AND tc.table_name='".$nametable ."';";
						    $result =  $this->conector->procesar_sql($sql);  

				if(pg_num_rows($result)>0)
				{
					
					for ($i=0; $i < pg_num_rows($result); $i++) 
					{ 
					$fila = pg_fetch_array($result,$i);
				    $campos_fk[$fila['table_schema'].'.'.$fila['py_table_name']]  = $fila['fk_column_name']; 
					}
							
					return $campos_fk;
					
				}
			   
			   }
			   
			   
			  
			  public function Encabezados($Array)
			  {
			  	$nombres_campos = "";
				if(!empty($Array))
				{
					$nombres_campos .= "<tr class='tableindex'  >";   
					for ($i=0; $i < count($Array) ; $i++) 
					{
					  $nombres_campos .= "<td>".ucwords($Array[$i])."</td>";
					}	   
				}
				else
				{
					$result = $this->conector->Select_Total();
					$e = pg_num_fields($result);
					$nombres_campos .= "<tr class='tableindex' >";
					for ($j = 0; $j < $e; $j++) 
					{ 
					  $campo[$j] = pg_field_name($result, $j);
					  $nombres_campos .= "<td>".ucwords($campo[$j])."</td>";
					}	
				}
				return  $nombres_campos."<td></td></tr>"; ;
			  }
			  
			  
			  
			  public function Encabezados_Resultados($sql)
			  {
			  	$nombres_campos = "";

				$result = $this->conector->procesar_sql($sql);
				
				$e = pg_num_fields($result);
				
				$nombres_campos .= "<tr class='tableindex' >";
				
				for ($j = 0; $j < $e; $j++) 
				{ 
				 $campo[$j] = pg_field_name($result, $j);
				 $nombres_campos .= "<td>".ucwords($campo[$j])."</td>";
				}	

			  return  $nombres_campos."</tr>"; ;
			  
			 }
			  
			  
			  
			   	public  function  enlace($titulo_enlace,$vector)
			   	{  
					//formato de array
					//$vector = array('var'=>'1','id'=>'2');
	                $z = "";	
	      			foreach($vector as $c=>$v)
	     			$z .= $c."=".$v."&";
					$z = substr($z, 0, -1);
					$e = "'".$this->vista."?$z'";
					return '<a  class="botonXX" id="enlace" href="#" title="'.$titulo_enlace.'" onclick="enviapag('.$e.')" >'.$titulo_enlace.'</a>';
				}

				
			 public function Retorno_Array_Select($sql)
			 {
			   $array_select = Array();
			   $campo = Array();
			   
			   $reg = $this->conector->procesar_sql($sql);
			   
                for ($i=0; $i < pg_num_rows($reg) ; $i++) {
					        $e = pg_num_fields($reg);
							  for ($j = 0; $j < $e; $j++) {
							      $campo[$j] = pg_field_name($reg, $j);
							      }	
						$fila = pg_fetch_array($reg,$i); 
						$dato = strtr(strtolower($fila[$campo[1]]), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú");
						$array_select [$fila[$campo[0]]] = ucwords($dato);
					}		
				return  $array_select;
		     }

            
			public function Valor_Validacion()
			 {
			   $campo = Array();
			   $result = $this->conector->Select_SoloTabla();
					        $e = pg_num_fields($result);
							  for ($j = 0; $j < $e; $j++) {
							      $campo[pg_field_name($result, $j)] = pg_fieldtype($result, $j);
							      }	
				       return  $campo;
		     }
			 
	   
		   public function carga_select($x,$name,$options,$fun,$eti){
			    
				if(!empty($fun))
				{				 
				  $function = "enviapag('reportes.php?$fun')";
				}
		   	    
				$a='';
			 	$select  ="";
				
				$select .= '<select name="'.$name.'" id="'.$name.'"  onChange="'.$function.'" >';
				
				if(!empty($eti))
				{
                 $select .=  '<option value="" SELECTED >'.$eti.'</option>';
				}
				else
				{
				 $select .=  '<option value="" SELECTED >Seleccionar</option>';	
				 }
					
				foreach($options as $i=>$d){
				    if($i==$x){
					   $select .=  '<option 	value="'.$i.'" 	selected="selected"  >'.$d.'</option>'; 
					}else{
						$select .=  '<option 	value="'.$i.'" >'.$d.'</option>'; 
					}
				  }
				
				$select	.= '</select> ';
				
				return  $select;
			 
			 }  
				   		 
	
	
	public function formato_utf8($datos){
				
		return htmlentities($datos,ENT_QUOTES,'UTF-8');
				
		}
				   		 
				   		 

   } // FIN CLASS

		
	/*	$Obj  = new Controlador_Masivo($conn,"ListaSistemasModelo");
	
		echo "<br>";
		echo $Obj->Listado_Datos(); */
		

?>
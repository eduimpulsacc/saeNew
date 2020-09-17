<?

	///////////////////////////////

	//CONECCION A LA BASE DE DATOS

	//////////////////////////////

	
	//******************CONECCION A BASE DE DATOS SOPORTE****************************************//	

$conn2=pg_connect("dbname=soporte host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");
	
/// CONEXIÓN ABIERTA A LA Base de datos coi_final que es la base de datos MAESTRA DONDE DEBEN ESTAR TODOS LOS USUARIOS.
$conn3=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess");
	
	if(!$conn2){
		if($_PERFIL==0){
		echo "No se puede conectar a la base de datos.";
		//error('<b>ERROR:</b>No se puede conectar a la base de datos.');
		}
	}
	//*******************************************************************************************//	  
		
// primero abrimos conecion en coi_final	
$conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess");
	
	// consulta para saber si la institución pertenece a alguna corporacion
	
	$sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
	//if($_PERIFL==0){ echo $sql_corp; exit; }
	//
	//if($_INSTIT==316){ echo $sql_corp; exit;}
	$res_corp = @pg_Exec($conn, $sql_corp);
	$num_corp = @pg_numrows($res_corp);
	
	if ($num_corp>0){   // pertenece a una corporación.... hay que saber a cual...
	     $fil_corp = @pg_fetch_array($res_corp,0);
		 $corporacion = $fil_corp['num_corp'];

		 
		 if ($corporacion=="1" or $corporacion=="4" or $corporacion=="12" or $corporacion=="14" or $corporacion=="15" or $corporacion=="16" or $corporacion=="17" or $corporacion=="18" or $corporacion=="19" or $corporacion=="20"){
		        
				/// pertenece a la corporacion de VIÑA o IQUIQUE
				// la conexión es...
$conn=pg_connect("dbname=coi_final_vina host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Viña.");
				 
				 
				 if ($_PERFIL==0){     /// para chequear en que base de datos estoy
	                 //echo "<font face='verdana' color='ff3355' size='1'>BD: Vina-Iquique</font>";
		         }
				 
		 }else if($corporacion=="13"){
		 		
				
			 	$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
				//$conn=pg_connect("dbname=coi_antofagasta host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Antofagasta.");	
				if (!$conn) {
					 error('<b>ERROR:</b>No se puede conectar a la base de datos Antofagasta.');
					 exit;
					}
				if ($_PERFIL==0){     /// para chequear en que base de datos estoy
					//echo "<font face='verdana' color='ff3355' size='1'>BD: Antofagasta</font>";
		        }
				
		 }else{
		 
		   // es de otra corporación... debe conectar a la base de datos nueva coi_corporacion
           $conn=pg_connect("dbname=coi_corporaciones host=200.29.21.125 port=5432 user=postgres   
		   password=cole#newaccess") or die ("Error de conexión Corporacion.");	
     		 }
		 
	}else{
	     
		 /// no es de corporación, la conexión sigue igual en coi_final
		 if ($_PERFIL==0){     /// para chequear en que base de datos estoy
			 //echo "<font face='verdana' color='ff3355' size='1'>BD: coi_final</font>";
		 }
	
	}	 		  	
		 
		 
	
		
	/*	
	// primero corporacion Viña
	if ($_INSTIT==1680 or $_INSTIT==12171 or $_INSTIT==1667 or $_INSTIT==1217 or $_INSTIT==1710 or $_INSTIT==1715 or $_INSTIT==1691 or $_INSTIT==1708 or $_INSTIT==1682 or $_INSTIT==1681 or $_INSTIT==1688 or $_INSTIT==1693 or $_INSTIT==1717 or $_INSTIT==1698 or $_INSTIT==1677 or $_INSTIT==1714 or $_INSTIT==1695 or $_INSTIT==1716 or $_INSTIT==1684 or $_INSTIT==1724 or $_INSTIT==1705 or $_INSTIT==1729 or $_INSTIT==1702 or $_INSTIT==1700 or $_INSTIT==1701 or $_INSTIT==1728 or $_INSTIT==1683 or $_INSTIT==1678 or $_INSTIT==1732 or $_INSTIT==1686 or $_INSTIT==1685 or $_INSTIT==1718 or $_INSTIT==1692 or $_INSTIT==1721 or $_INSTIT==1730 or $_INSTIT==1722 or $_INSTIT==1668 or $_INSTIT==1697 or $_INSTIT==1704 or $_INSTIT==1707 or $_INSTIT==1709 or $_INSTIT==1703 or $_INSTIT==1712 or $_INSTIT==1713 or $_INSTIT==1674 or $_INSTIT==1676 or $_INSTIT==1675 or $_INSTIT==1664 or $_INSTIT==1672 or $_INSTIT==1720){
	
	      /// conexión a HP1	
		 if ($_PERFIL==0){     
	          echo "<font face='verdana' color='ff3355' size='1'>BD: Vina-Iquique</font>";
		 }
		 $conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");	
		 
		 
	}else{
	     ///  Corporacion de Iquique 
	     if ($_INSTIT==115 or $_INSTIT==109 or $_INSTIT==110 or $_INSTIT==12683 or $_INSTIT==114 or $_INSTIT==126 or $_INSTIT==108 or $_INSTIT==97 or $_INSTIT==112 or $_INSTIT==122 or $_INSTIT==107 or $_INSTIT==117 or $_INSTIT==119 or $_INSTIT==113 or $_INSTIT==116 or $_INSTIT==124 or $_INSTIT==102 or $_INSTIT==120 or $_INSTIT==12560 or $_INSTIT==103 or $_INSTIT==111 or $_INSTIT==10916){
		       /// conexion a HP1
			   if ($_PERFIL==0){     
	                 echo "<font face='verdana' color='ff3355' size='1'>BD: Vina-Iquique</font>";
		       }			 
			   $conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion.");
			 
		 }else{	
		 
		 
		       $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
			   
			   
			   /*			   
			    
		       // aqui ver si la institucion es de otra corporacion
			   $sql_otra_corp = "select rdb from corp_instit where rdb = '".$_INSTIT."'";
			   $res_otra_corp = pg_Exec($conn, $sql_otra_corp);
			   $num_otra_corp = pg_numrows($res_otra_corp);
			   
			   if ($num_otra_corp>0){			   
			        $conn=pg_connect("dbname=coi_corporaciones host=9999999999 port=5432 user=postgres password=cole#newaccess");
			   }else{	 
	                $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
			   }
			   
			   		   
			   
	     }
	}
	*/
	//    LUEGO SACA ESTE IF DE ABAJO   //
	
	
	
	if (!$conn) {

	 error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	 exit;
	 
	}
	

?>
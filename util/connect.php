<?  
  
  /* // primero corporacion Vi�a
	if ($_INSTIT==1680 or $_INSTIT==12171 or $_INSTIT==1667 or $_INSTIT==1217 or $_INSTIT==1710 or $_INSTIT==1715 or $_INSTIT==1691 or $_INSTIT==1708 or $_INSTIT==1682 or $_INSTIT==1681 or $_INSTIT==1688 or $_INSTIT==1693 or $_INSTIT==1717 or $_INSTIT==1698 or $_INSTIT==1677 or $_INSTIT==1714 or $_INSTIT==1695 or $_INSTIT==1716 or $_INSTIT==1684 or $_INSTIT==1724 or $_INSTIT==1705 or $_INSTIT==1729 or $_INSTIT==1702 or $_INSTIT==1700 or $_INSTIT==1701 or $_INSTIT==1728 or $_INSTIT==1683 or $_INSTIT==1678 or $_INSTIT==1732 or $_INSTIT==1686 or $_INSTIT==1685 or $_INSTIT==1718 or $_INSTIT==1692 or $_INSTIT==1721 or $_INSTIT==1730 or $_INSTIT==1722 or $_INSTIT==1668 or $_INSTIT==1697 or $_INSTIT==1704 or $_INSTIT==1707 or $_INSTIT==1709 or $_INSTIT==1703 or $_INSTIT==1712 or $_INSTIT==1713 or $_INSTIT==1674 or $_INSTIT==1676 or $_INSTIT==1675 or $_INSTIT==1664 or $_INSTIT==1672 or $_INSTIT==1720){
	
	      /// conexi�n a HP1	
		 
		 $conn=pg_connect("dbname=coi_final_vina host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexi�n.");	
	}else{
	     ///  Corporacion de Iquique 
	     if ($_INSTIT==115 or $_INSTIT==109 or $_INSTIT==110 or $_INSTIT==12683 or $_INSTIT==114 or $_INSTIT==126 or $_INSTIT==108 or $_INSTIT==97 or $_INSTIT==112 or $_INSTIT==122 or $_INSTIT==107 or $_INSTIT==117 or $_INSTIT==119 or $_INSTIT==113 or $_INSTIT==116 or $_INSTIT==124 or $_INSTIT==102 or $_INSTIT==120 or $_INSTIT==12560 or $_INSTIT==103 or $_INSTIT==111 or $_INSTIT==10916){
		       /// conexion a HP1
			  			 
			   $conn=pg_connect("dbname=coi_final_vina host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexi�n.");
			 
		 }else{	
	           $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
	     }
	}
	
	
	
	if (!$conn) {
		 error('<b>ERROR:</b>No se puede conectar a la base de datos22.');
		 exit;
	}*/
	
	
	// primero abrimos conecion en coi_final	
	//$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");		// consulta para saber si la instituci�n pertenece a alguna corporacion
	
	$sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
	
	$res_corp = @pg_Exec($conn, $sql_corp);
	$num_corp = @pg_numrows($res_corp);
	$numero_corp=@pg_result($res_corp,0);
	if ($num_corp>0 and $numero_corp!=21){   // pertenece a una corporaci�n.... hay que saber a cual...
	     $fil_corp = @pg_fetch_array($res_corp,0);
		 $corporacion = $fil_corp['num_corp'];
		 
		 
		 if ($corporacion=="1" or $corporacion=="4" or $corporacion=="12" or $corporacion=="14" or $corporacion=="15" or $corporacion=="16" or $corporacion=="17" or $corporacion=="18" or $corporacion=="19" or $corporacion=="20" or $corporacion=="22" or $corporacion=="23" or $corporacion=="24" or $corporacion=="25" or $corporacion=="26" or $corporacion=="27" or $corporacion=="28"){
		        
				/// pertenece a la corporacion de VI�A o IQUIQUE o ADVENTISTA
				// la conexi�n es...
				 $conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
				
			}elseif ($corporacion=="13"){
			//$conn=pg_connect("dbname=coi_antofagasta host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexi�n Antofagasta."); 
			$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
				 
				/* if ($_PERFIL==0){     /// para chequear en que base de datos estoy
	                 echo "<font face='verdana' color='ff3355' size='1'>BD: Vina-Iquique</font>";
		         }*/
				 
		 }else{
		 
		       /// es de otra corporaci�n... debe conectar a la base de datos nueva coi_corporacion
			   	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");

				 
				/* if ($_PERFIL==0){     /// para chequear en que base de datos estoy
	                 echo "<font face='verdana' color='ff3355' size='1'>BD: Corporaciones</font>";
		         }*/
		 }
		 
	}else{
	     
		 /// no es de corporaci�n, la conexi�n sigue igual en coi_final
		/* if ($_PERFIL==0){     /// para chequear en que base de datos estoy
			 echo "<font face='verdana' color='ff3355' size='1'>BD: coi_final</font>";
		 }
	*/
	}	 
	 
?>
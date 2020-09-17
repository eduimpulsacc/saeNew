<?
// header( 'Content-type: text/html; charset=latin' );

	session_start();	
	session_register('_bot');

	if($_INSTIT==""){
		$_ESTILO="estilos/estilos.css";
		$_IMAGEN_IZQUIERDA="cortes/fondo_01.jpg";
		$_IMAGEN_DERECHA="cortes/fomdo_02.jpg";		
	}else{
		$_ESTILO="cortes/".$_INSTIT."/estilos.css";
		$_IMAGEN_IZQUIERDA="cortes/".$_INSTIT."/fondo_01.jpg";
		$_IMAGEN_DERECHA="cortes/".$_INSTIT."/fomdo_02.jpg";
	}
	session_register("_ESTILO");
	session_register("_IMAGEN_IZQUIERDA");
	session_register("_IMAGEN_DERECHA");

$soporte=0;

 if(!($_CHK_ID==session_id()) & $soporte!=1){
	
	//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION
		//echo "ERROR DE ACCESO, LA SESION DE USUARIO HA EXPIRADO...";
		echo "<script>window.location = 'http://app.colegiointeractivo.cl/sae3.0/session/finSession.php'</script></HEAD><BODY></BODY></HTML>";
		session_unset();
		session_destroy();
		exit;
	}
	
//	session_cache_limiter ('nocache'); // SETEA SIN CACHE DE PAGINA
	///////////
	//FUNCIONES
	///////////
	function fecha_espanol($fecha)
	{
		$dia = substr($fecha,0,2);
		$mes = trim(substr($fecha,3,2));
		//Descripcion de meses						
		if($mes=="01"){$t_mes="Enero";}
		if($mes=="02"){$t_mes="Febrero";}
		if($mes=="03"){$t_mes="Marzo";}
		if($mes=="04"){$t_mes="Abril";}
		if($mes=="05"){$t_mes="Mayo";}
		if($mes=="06"){$t_mes="Junio";}
		if($mes=="07"){$t_mes="Julio";}
		if($mes=="08"){$t_mes="Agosto";}
		if($mes=="09"){$t_mes="Septiembre";}
		if($mes=="10"){$t_mes="Octubre";}
		if($mes=="11"){$t_mes="Noviembre";}
		if($mes=="12"){$t_mes="Diciembre";}	
		//fin descripcion					
		$ano = substr($fecha,6,4);
		$fecha = "$dia "."de"." $t_mes "."de"." $ano";
		return($fecha);
	}





function fecha_espanol_min($fecha)
	{
		$dia = substr($fecha,0,2);
		$mes = trim(substr($fecha,3,2));
		//Descripcion de meses						
		if($mes=="01"){$t_mes="enero";}
		if($mes=="02"){$t_mes="febrero";}
		if($mes=="03"){$t_mes="marzo";}
		if($mes=="04"){$t_mes="abril";}
		if($mes=="05"){$t_mes="mayo";}
		if($mes=="06"){$t_mes="junio";}
		if($mes=="07"){$t_mes="julio";}
		if($mes=="08"){$t_mes="agosto";}
		if($mes=="09"){$t_mes="septiembre";}
		if($mes=="10"){$t_mes="octubre";}
		if($mes=="11"){$t_mes="noviembre";}
		if($mes=="12"){$t_mes="diciembre";}	
		//fin descripcion					
		$ano = substr($fecha,6,4);
		$fecha = "$dia "."de"." $t_mes "."de"." $ano";
		return($fecha);
	}

	
	function envia_mes($mes){
		
		if($mes=="01"){$t_mes="Enero";}
		if($mes=="02"){$t_mes="Febrero";}
		if($mes=="03"){$t_mes="Marzo";}
		if($mes=="04"){$t_mes="Abril";}
		if($mes=="05"){$t_mes="Mayo";}
		if($mes=="06"){$t_mes="Junio";}
		if($mes=="07"){$t_mes="Julio";}
		if($mes=="08"){$t_mes="Agosto";}
		if($mes=="09"){$t_mes="Septiembre";}
		if($mes=="10"){$t_mes="Octubre";}
		if($mes=="11"){$t_mes="Noviembre";}
		if($mes=="12"){$t_mes="Diciembre";}	
		return ($t_mes);			
	  
	  }
	  
	  
	 
	  
	  function envia_mesCorto($mes){
		
		if($mes=="01"){$t_mes="Ene";}
		if($mes=="02"){$t_mes="Feb";}
		if($mes=="03"){$t_mes="Mar";}
		if($mes=="04"){$t_mes="Abr";}
		if($mes=="05"){$t_mes="May";}
		if($mes=="06"){$t_mes="Jun";}
		if($mes=="07"){$t_mes="Jul";}
		if($mes=="08"){$t_mes="Ago";}
		if($mes=="09"){$t_mes="Sep";}
		if($mes=="10"){$t_mes="Oct";}
		if($mes=="11"){$t_mes="Nov";}
		if($mes=="12"){$t_mes="Dic";}	
		return ($t_mes);			
	  
	  }
	
	
	function error($error) {

		echo "<html><title>ERROR</title></head>";

		echo "<body><center>";

		echo $error;

		echo "</center></body></html>";

		session_destroy();

		exit;

	}



	function tope($path){
		$x  = "<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>";
		$x .= "	<tr>";
		$x .= "   <td align=left>";
		$x .= "     <a href=\"".$path."logout.3\" target=\"_parent\"><INPUT TYPE=\"image\" SRC=\"".$path."btn_logout.gif\" disabled></a>";
		$x .= "	  </td>";
		$x .= "	</tr>";
		$x .= "	</table>";
		return $x;
	};



	function imp($txt){
		if(trim($txt)!=""){
			echo trim($txt);
		//}else{
			//echo "<FONT face=arial size=2 color=white>0</FONT>";
		}
	};



	function impChk($valor,$nombre){ 
		if(trim($valor)=="1")
			echo "<INPUT TYPE=checkbox NAME=\"".$nombre."\" checked>";
		else
			echo "<INPUT TYPE=checkbox NAME=\"".$nombre."\">";
	};



	function impChkEst($valor,$nombre){ 
	if(trim($valor)=="1")
			//echo "<INPUT TYPE=image SRC=\"../../../../../util/tic.gif\" disabled>";
			echo "<INPUT TYPE=image SRC=\"tic.gif\" disabled>";
		else
			echo "_";
	};

	function impF($txt){
	if(trim($txt)!=""){
		echo substr($txt,8,2); //dia
		echo "-";
		echo substr($txt,5,2); //mes
		echo "-";
		echo substr($txt,0,4);  //año
	}else{
		//echo "<FONT face=arial size=2 color=gray>0</FONT>";
	}
	};



 function fEs2En($txt){
	$x= substr($txt,3,2); // MES
	$x.="-";
	$x.=substr($txt,0,2); //DIA
	$x.="-";
	$x.=substr($txt,6,4); // AÑO
	return $x;
	}
	
	
	function fEs2En2($txt){
	$x=substr($txt,6,4); // AÑO
	$x.="-";
	$x.= substr($txt,3,2); // MES
	$x.="-";
	$x.=substr($txt,0,2); //DIA
	
	
	return $x;
	}
	
	function fEs2Enfinal($txt){
	$x= substr($txt,3,2); // DIA
	$x.="-";
	$x.=substr($txt,0,2); //MES
	$x.="-";
	$x.=substr($txt,6,4); // AÑO
	
	
	return $x;
	}



 	function Cfecha($txt){
		$x= substr($txt,8,2); // DIA
		$x.="-";
		$x.=substr($txt,5,2); //MES
		$x.="-";
		$x.=substr($txt,0,4); //AÑO
		return $x;
        };  

	function Cfecha2($txt){
        $x= substr($txt,8,2); // DIA
        $x.="/";
        $x.=substr($txt,5,2); //MES
        $x.="/";
        $x.=substr($txt,0,4); //AÑO
        return $x;
        };  
		

 	function Cfecha3($txt){
       $dia= substr($txt,8,2); // DIA
       $mes=substr($txt,5,2); //MES
       $ano=substr($txt,0,4); //AÑO
	   $x=strftime("%A, %d de %B de %Y",mktime(0,0,0,$mes,$dia, $ano));
       return $x;
      
	  }  
				

 	function compararFechas($primera, $segunda){
		  
      $valoresPrimera = explode ("-", $primera);     
      $valoresSegunda = explode ("-", $segunda);   
      $diaPrimera    = $valoresPrimera[0];    
      $mesPrimera  = $valoresPrimera[1];    
      $anyoPrimera   = $valoresPrimera[2];   
      $diaSegunda   = $valoresSegunda[0];    
      $mesSegunda = $valoresSegunda[1];    
     $anyoSegunda  = $valoresSegunda[2];  
     $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);    
     $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);       
     if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){  
       // "La fecha ".$primera." no es válida";  
       return 0;  
     }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){  
       // "La fecha ".$segunda." no es válida";  
       return 0;  
     }else{  
       return  intval(($diasPrimeraJuliano - $diasSegundaJuliano)/365);  
     }   
   }  
   



	if(($_ANO=="")and($_INSTIT!="")){
		$qry_ano="SELECT * FROM ano_escolar WHERE id_institucion = '".$_INSTIT."' AND situacion = 1";
		$result_ano = @pg_Exec($conn,$qry_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);	
		$_ANO=$fila_ano["id_ano"];
		session_register("_ANO");
	  }

/*
		if(getenv("HTTP_X_FORWARDED_FOR")){
				 $ip2 = getenv("HTTP_X_FORWARDED_FOR");
				 $client = gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']);
				 addslashes($ip2);
			}else{
				 $ip2 = getenv("REMOTE_ADDR");
				 $client = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				 addslashes($ip2);
			}
			$str = preg_split("/\./", $client);
			$i = count($str);
			$x = $i - 1;
			$n = $i - 2;
			$isp = $str[$n] . "." . $str[$x];	*/		
			/* Muestra la ip y el isp del usuario
			echo '<div align="justify">Tu IP: '.$ip.'<br />Tu ISP: '.$isp.' </div>'; */
			
			//Muestra la ruta en la cual se encuentra el usuario
			
		/*	if(isset( $REQUEST_URI )) $ruta = $_SERVER["REQUEST_URI"];
			
			//Determinar la hora actual.
			$time_now = time() + 900;
			
			//Eliminar las ip incativas despues de 15 minutos.
			$time_out = time();			
			
			
			
			$sql="DELETE FROM usuarios_online WHERE fecha < '$time_out'"; 
			$result=@pg_Exec($sql);
			
			//Ver si una usuario existe, si existe lo actualizo, si no lo creo.
			
			$sql2="SELECT id_usuario FROM usuarios_online WHERE id_usuario='$_USUARIO'";
			$result2 = @pg_Exec($sql2);
			$row =@pg_num_rows($result2);
			if($row != 0)
			{
			$sql3="update usuarios_online SET fecha='$time_now', ruta='$ruta' WHERE id_usuario='$_USUARIO'";
			}
			else
			{
			$sql3="INSERT INTO usuarios_online(ip,isp,fecha,id_usuario,ruta,perfil) VALUES ('$ip2','$isp','$time_now','$_USUARIO','$ruta','$_PERFIL')";
			}
			$result3 = @pg_Exec($sql3);
			
			//Seleccionar los id para contabilizar los usuarios.
			$sql4="SELECT count(id_usuario) as tot_user FROM usuarios_online";	
			$result4=@pg_Exec($sql4);
			$fila_user=@pg_fetch_array($result4);
			
			//Muestro los usuarios que hay conectados en la pagina en este momento.
			 $usuarios_online=$fila_user['tot_user'];		
			 
			*/ 

//}
		

//-------------/ FIN USUARIOS EN LINEA /--------------------------



// ------ / Compara fecha / -----------------

//   sintaxis:

//       int Comparafecha (fecha , fecha)

//   Descripcion : devuelve la posicion

//   de la fecha mayor 1 o 2  y 0 si es igual

//-------------------------------------------

function dia_mes($mes,$ano){
	if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}elseif(($ano%4)==0){
		$dia=29;
	}else{
		$dia==28;
	}
	return $dia;
}



function ComparaFecha($fecha1,$fecha2){



        $mesC1= (int) substr($fecha1,8,2);

        $diaC1= (int) substr($fecha1,5,2);

        $anoC1= (int) substr($fecha1,0,4);

        $mesC2= (int) substr($fecha2,8,2);

        $diaC2= (int) substr($fecha2,5,2);

        $anoC2= (int) substr($fecha2,0,4);





                if ($anoC1>$anoC2)  $x=1;

                if ($anoC1<$anoC2)  $x=2;

                if ($anoC1==$anoC2) {

                        if ($mesC1 > $mesC2) $x=1;

                        if ($mesC1 < $mesC2) $x=2;

                        if ($mesC1 == $mesC2) {

                                if ($diaC1 > $diaC2) $x=1;

                                if ($diaC1 < $diaC2) $x=2;

                                if ($diaC1 == $diaC2) $x=0;

                        }





                }

        return $x;

};

function CursoPalabra($id_curso, $tipo, $conn)

{

	// $tipo = 0 - palabra completa

	// $tipo = 1 - iniciales

	// $tipo = 2 - palabra completa solo curso sn enseñanza

	// $tipo = 3 - iniciales solo curso sn enseñanza

	

	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto, curso.ensenanza ";

	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";

	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$id_curso."));";
	
	$result_curso =@pg_Exec($conn,$sql_curso);

	$fila_curso = @pg_fetch_array($result_curso,0);	



	if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987) or ($fila_curso['cod_decreto']==2572010))){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

				

	}else if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==121987) or ($fila_curso['cod_decreto']==1521989)) ){

		$Curso_pal0 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));				

		$Curso_pal3 = "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

				

	}else if ( ($fila_curso['grado_curso']==1) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

				

	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==121987) ){

		$Curso_pal0 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==2) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	  
	
	}else if (($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==5842007) and ($fila_curso['ensenanza']==165)) ){

		$Curso_pal0 =  "NIVEL BASICO 1(1 Y 4 BASICO)- ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "NB1 (1 Y 4 BASICO) - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "BN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 	
		 		
	}else if (($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==5842007) and ($fila_curso['ensenanza']==165)) ){

		$Curso_pal0 =  "NIVEL BASICO 2(5 Y 6 BASICO)- ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "NB2 (5 Y 6 BASICO) - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
		
	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==10002009) and ($fila_curso['ensenanza']==463 || $fila_curso['ensenanza']==563 || $fila_curso['ensenanza']==663)) ){

		$Curso_pal0 =  "2do NIVEL (3 medio) - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
	
	}else if (($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==10002009) and ($fila_curso['ensenanza']==463 || $fila_curso['ensenanza']==563 || $fila_curso['ensenanza']==663)) ){

		$Curso_pal0 =  "3er NIVEL(4 medio) - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
	
	}else if (($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "PREB&Aacute;SICO 1&ordm;-3 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "PB 1-3 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "PREB&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "PB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "PREB&Aacute;SICO 1&ordm;-3 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo'])); 
		
	}else if (($fila_curso['grado_curso']==5) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "PREB&Aacute;SICO 2-4 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "PB 2-4 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "PREB&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "PB - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		
		$Curso_pal4 =  "PREB&Aacute;SICO 2-4 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));
		
	}else if (($fila_curso['grado_curso']==6) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "PREB&Aacute;SICO 2&ordm;-5 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "PB 2-5 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "PREB&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "PB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "PREB&Aacute;SICO 2º-5 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo'])); 
	
	}else if (($fila_curso['grado_curso']==7) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 1-1 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 1-1 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "B&Aacute;SICO 1-1 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));
		
	}else if (($fila_curso['grado_curso']==9) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 1-3 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 1-3 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "B&Aacute;SICO 1-3 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));
	
	}else if (($fila_curso['grado_curso']==10) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 1-4 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 1-4 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B- ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "B&Aacute;SICO 1-4 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	
		
	}else if (($fila_curso['grado_curso']==11) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 2-5 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 2-5 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B- ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "B&Aacute;SICO 2-5 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	
	
	}
	else if (($fila_curso['grado_curso']==12) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 2-6 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 2-6 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B- ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "B&Aacute;SICO 2-6 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	
	
	}
	else if (($fila_curso['grado_curso']==13) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 2-7 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 2-7 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B- ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "B&Aacute;SICO 2-7 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	
	
	}
	else if (($fila_curso['grado_curso']==14) and (($fila_curso['cod_decreto']==2119999) and ($fila_curso['ensenanza']==211)) ){

		$Curso_pal0 =  "B&Aacute;SICO 2-8 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "BSC 2-8 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "B&Aacute;SICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B- ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "BÁSICO 2-8 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	
		
	}else if (($fila_curso['grado_curso']==11) and (($fila_curso['cod_decreto']==871990) and ($fila_curso['ensenanza']==212)) ){

		$Curso_pal0 =  "LABORAL 1 - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "LAB 1 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "LABORAL 1  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "LAB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "LABORAL 1- ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));   
		  	 	
	}else if (($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==871990) and ($fila_curso['ensenanza']==212)) ){

		$Curso_pal0 =  "1° BÁSICO - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	  

		$Curso_pal1 =  "B1 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "1° BÁSICO  - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "B1 - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "1° BÁSICO- ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));     	 	
					
	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==10002009) and ($fila_curso['ensenanza']==363)) ){

		$Curso_pal0 =  "2do NIVEL (3 y 4 medio) - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
			
		
	}else if (($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==10002009) and ($fila_curso['ensenanza']==363)) ){

		$Curso_pal0 =  "1er NIVEL (1 y 2 medio) - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
			
		
	}else if ( ($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==771982)) ){

		$Curso_pal0 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   			

						
	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==2572010) ) ){

		$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	  
		
	}else if (($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==2572010) ) ){

		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	  
		
	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		
		$Curso_pal4 =  "PLAY GROUP - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

						

	}else if ( ($fila_curso['grado_curso']==4) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICION 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]."    ".$fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "TRANSICION 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		
		$Curso_pal4 =  "PRE KINDER ".ucwords(strtoupper($fila_curso["letra_curso"]."        ".$fila_curso['nombre_tipo']));
		
		$Curso_pal5 =  "PRE KINDER ".ucwords(strtoupper($fila_curso["letra_curso"].""));
		
		//$Curso_pal6 =  "NT1 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	

$Curso_pal6 =  ucwords("PK" . "-" . $fila_curso["letra_curso"]. Iniciales($fila_curso['nombre_tipo'])); 	
						

	}else if ( ($fila_curso['grado_curso']==5) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICION 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "TRANSICION 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	
		
		$Curso_pal5 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]));			

		//$Curso_pal6 =  "NT2 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal6 =  ucwords("K" . "-" . $fila_curso["letra_curso"]. Iniciales($fila_curso['nombre_tipo'])); 		

	}else if ( ($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 ) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));						

		

	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==1)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));			
		
	}else if ( (($fila_curso['grado_curso']==2)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]) );		
		
	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==5842007) and (($fila_curso['ensenanza']==167) or ($fila_curso['ensenanza']==165))){

		$Curso_pal0 = "NIVEL B&Aacute;SICO 3 (7 Y 8 BASICO) - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "NB3 (7 Y 8 BASICO)- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "NIVEL B&Aacute;SICO 3 (7 Y 8 BASICO) - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "NB3 - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
											
	}else if ((($fila_curso['grado_curso']==4)) and ($fila_curso['cod_decreto']==5842007) and ($fila_curso['ensenanza']==167)){

		$Curso_pal0 = "3er NIVEL ()- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

	}else if ( (($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

																					

	}
	elseif($fila_curso['ensenanza']==214){
		if($fila_curso['grado_curso']==1){
			
			$Curso_pal0 = "MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "MME- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "MME - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
			
			}
			if($fila_curso['grado_curso']==2){
			
			$Curso_pal0 = "MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "MMA- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "MMA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
			
			}
			if($fila_curso['grado_curso']==3){
			$Curso_pal0 = "PRIMER NIVEL TRANSICI&Oacute;N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "T1N- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "PRIMER NIVEL TRANSICI&Oacute;N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
			
			}
			if($fila_curso['grado_curso']==4){
			$Curso_pal0 = "SEGUNDO NIVEL TRANSICI&Oacute;N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "T2N- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "SEGUNDO NIVEL TRANSICI&Oacute;N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
			
			}
	
			if($fila_curso['grado_curso']==23){
				$Curso_pal0 = "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "NMM- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "NMM - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==24){
				$Curso_pal0 = "PRIMER NIVEL TRANSICIÓN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "PNT- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "PRIMER NIVEL TRANSICIÓN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "PNT - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==25){
				$Curso_pal0 = "SEGUNDO NIVEL TRANSICIÓN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "SNT- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "SEGUNDO NIVEL TRANSICIÓN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "SNT - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
		
		}
		elseif($fila_curso['ensenanza']==216){
		if($fila_curso['grado_curso']==1){
			
			$Curso_pal0 = "PRIMERO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "PRIMERO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PB - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
			
			}
			if($fila_curso['grado_curso']==2){
			
			$Curso_pal0 = "SEGUNDO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "SEGUNDO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SB - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
			
			}
			if($fila_curso['grado_curso']==3){
			$Curso_pal0 = "TERCERO BÁSICO- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "TERCERO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
			
			}
			if($fila_curso['grado_curso']==4){
			$Curso_pal0 = "CUARTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "CB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "CUARTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "CB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
			
			}
	
			if($fila_curso['grado_curso']==5){
				$Curso_pal0 = "QUINTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "QB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "QUINTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "QB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==22){
				$Curso_pal0 = "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "NMM- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "NMM - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==23){
				$Curso_pal0 = "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "NMM- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "NMM - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==24){
				$Curso_pal0 = "NIVEL TRANSICION 1- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "NT- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "NIVEL TRANSICION 1 - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "NT - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==25){
				$Curso_pal0 = "NIVEL TRANSICION 2- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "NT- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "NIVEL TRANSICION 2- ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "NT - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==32){
				$Curso_pal0 = "LABORAL 2- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "LAB 2- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "LABORAL 2- ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "LAB 2 - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
		
		}
		elseif($fila_curso['ensenanza']==212){
		if($fila_curso['grado_curso']==3){
			
			$Curso_pal0 = "TERCERO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "TERCERO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TB - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
			
			}
			if($fila_curso['grado_curso']==4){
			
			$Curso_pal0 = "CUARTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "CB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "CUARTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "CB - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
			
			}
			if($fila_curso['grado_curso']==5){
			$Curso_pal0 = "QUINTO BÁSICO- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "QB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "QUINTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "QB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
			
			}
			if($fila_curso['grado_curso']==6){
			$Curso_pal0 = "SEXTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "SEXTO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
			
			}
	
			if($fila_curso['grado_curso']==7){
				$Curso_pal0 = "SEPTIMO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "SB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "SEPTIMO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "SB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			if($fila_curso['grado_curso']==32){
				$Curso_pal0 = "LABORAL 2 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
				$Curso_pal1 = "LAB 2- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
				$Curso_pal2 = "LABORAL 2 - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
				$Curso_pal3 = "LAB 2 - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

			}
			
		
		}
	
	else{
		
		
		$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]." ". $fila_curso['nombre_tipo'])); 

		$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]." ". $fila_curso['nombre_tipo'])); 		

		$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		

		$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 	
		$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]." ". $fila_curso['nombre_tipo'])); 
		//$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . "º AÑO DE " . $fila_curso['nombre_tipo']));
			
		$Curso_pal5 =  ucwords(strtoupper("AÑO DE ".$fila_curso['nombre_tipo'])); 
		
		$Curso_pal6 =  ucwords(strtoupper($fila_curso["grado_curso"] . "-" . $fila_curso["letra_curso"]. Iniciales($fila_curso['nombre_tipo']))); 
		
		$Curso_pal7 =   $fila_curso['nombre_tipo']; 
				
	}

	if ($tipo == 0)

		return $Curso_pal0;

	if ($tipo == 1)

		return $Curso_pal1;

	if ($tipo == 2)

		return $Curso_pal2;

	if ($tipo == 3)

		return $Curso_pal3;				

	if ($tipo == 4)

		return $Curso_pal4;				

	if ($tipo == 5)

		return $Curso_pal5;		
		
	if ($tipo == 6)

		return $Curso_pal6;	
		
		if ($tipo == 7)

		return $Curso_pal7;				

}



function Conceptual($nota, $tipo)

{

	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual

	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico

	$nota_res=0;

	$concepto="";		

	if ($tipo == 1)

	{

		if ($nota >= 60 and $nota<=70)

			$concepto = "MB";

		if ($nota >= 50 and $nota<=59)

			$concepto = "B";

		if ($nota >= 40 and $nota<=49)

			$concepto = "S";

		if ($nota >= 0 and $nota<=39)

			$concepto = "I";
		
		if($nota==0)
		
			$concepto = "-";

		

		return $concepto ;

	}

	else

	{

		if (trim($nota) == "MB")

			$nota_res = 65;

		if (trim($nota) == "B")

			$nota_res = 55;			

		if (trim($nota) == "S")

			$nota_res = 45;

		if (trim($nota) == "I")

			$nota_res = 35;						

		

		return $nota_res;

		

	}

	

	

}

function Conceptualsigla2($nota, $tipo)

{

	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual

	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico

	$nota_res=0;

	$concepto="";		

	if ($tipo == 1)

	{

		if ($nota >= 60 and $nota<=70)

			$concepto = "D";

		if ($nota >= 50 and $nota<=59)

			$concepto = "S";

		if ($nota >= 40 and $nota<=49)

			$concepto = "ED";

		if ($nota >= 10 and $nota<=39)

			$concepto = "NM";
		
			

		return $concepto ;

	}

	else

	{

		if (trim($nota) == "D")

			$nota_res = 65;

		if (trim($nota) == "D")

			$nota_res = 55;			

		if (trim($nota) == "ED")

			$nota_res = 45;

		if (trim($nota) == "NM")

			$nota_res = 35;	
		
						

		

		return $nota_res;

		

	}

	

	

}



function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {

  /*

    $interval can be:

    yyyy - Number of full years

    q - Number of full quarters

    m - Number of full months

    y - Difference between day numbers

      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)

    d - Number of full days

    w - Number of full weekdays

    ww - Number of full weeks

    h - Number of full hours

    n - Number of full minutes

    s - Number of full seconds (default)

  */

  

  if (!$using_timestamps) {

    $datefrom = strtotime($datefrom, 0);

    $dateto = strtotime($dateto, 0);

  }

  $difference = $dateto - $datefrom; // Difference in seconds

   

  switch($interval) {

   

    case 'yyyy': // Number of full years



      $years_difference = floor($difference / 31536000);

      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {

        $years_difference--;

      }

      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {

        $years_difference++;

      }

      $datediff = $years_difference;

      break;



    case "q": // Number of full quarters



      $quarters_difference = floor($difference / 8035200);

      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {

        $months_difference++;

      }

      $quarters_difference--;

      $datediff = $quarters_difference;

      break;



    case "m": // Number of full months



      $months_difference = floor($difference / 2678400);

      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {

        $months_difference++;

      }

      $months_difference--;

      $datediff = $months_difference;

      break;



    case 'y': // Difference between day numbers



      $datediff = date("z", $dateto) - date("z", $datefrom);

      break;



    case "d": // Number of full days



      $datediff = floor($difference / 86400);

      break;



    case "w": // Number of full weekdays



      $days_difference = floor($difference / 86400);

      $weeks_difference = floor($days_difference / 7); // Complete weeks

      $first_day = date("w", $datefrom);

      $days_remainder = floor($days_difference % 7);

      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?

      if ($odd_days > 7) { // Sunday

        $days_remainder--;

      }

      if ($odd_days > 6) { // Saturday

        $days_remainder--;

      }

      $datediff = ($weeks_difference * 5) + $days_remainder;

      break;



    case "ww": // Number of full weeks



      $datediff = floor($difference / 604800);

      break;



    case "h": // Number of full hours



      $datediff = floor($difference / 3600);

      break;



    case "n": // Number of full minutes



      $datediff = floor($difference / 60);

      break;



    default: // Number of full seconds (default)



      $datediff = $difference;

      break;

  }    



  return $datediff;



}

function DiasTrabajados($id_ano,$fecha1, $fecha2, $conn)

{

	 $sqlFeriados = "select * from feriado where id_ano = ".$id_ano." and fecha_inicio >= '".$fecha1."' and fecha_fin <= '".$fecha2."' order by fecha_inicio";

	$rsFeriado =@pg_Exec($conn,$sqlFeriados );

	for($i=0 ; $i < @pg_numrows($rsFeriado) ; ++$i)

	{

		$fFeriado= @pg_fetch_array($rsFeriado,$i);

		

		$fecha_inicio = $fFeriado['fecha_inicio'];

		$fecha_fin = $fFeriado['fecha_fin'];

		if (!empty($fecha_fin)){

			// DateDiff('d',$fecha_inicio, $fecha_fin);
			 $dias_entre =ddiff($fecha_inicio, $fecha_fin);

			$dias = $dias + $dias_entre+1;

		}else{

			$dias = $dias + 1;

		}

	}



	$diferencia = datediff('w', $fecha1, $fecha2, false);
//echo $diferencia-$dias;
	return $diferencia-$dias;

}

function Promediar($suma,$cantidad, $truncado){
	if ($truncado == 1){
		$promedio = @round($suma/$cantidad,0);
	}else{
		$promedio = @intval($suma/$cantidad);
    }
	
	return $promedio;
}

function PromediarSolo($suma,$cantidad){
	//calcular promedio sin aproximar
	
		$promedio = $suma/$cantidad;

	return $promedio;
}


function imprime_array($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}

function aproximar_promedio($prom,$valor){
//si valor=1 aproxima, si no no


	if ($valor==1){
		$prom=round($prom,0);
	}
	if ($valor==1){
		$prom=floor($prom);
	}
	return $prom;
}

function promediar_conceptos($arreglo){
	$valores[]=1;
	$valores[]=2;
	$valores[]=3;
	$valores[]=4;
	$conceptos[]="I";
	$conceptos[]="S";
	$conceptos[]="B";
	$conceptos[]="MB";
	
	$largo=count($arreglo);
	//echo "<h1>$largo</h1>";

	for ($i=0;$i<$largo;++$i){
	 	$posicion=array_search(trim($arreglo[$i]),$conceptos);
		$suma=$suma+$valores[$posicion];
		//	echo "<h1>$suma</h1>";
	}	
//	echo $suma;
	if ($largo>0){
	$prom=$suma/$largo;
	}else{
		return null;
	}

	 $prom=round($prom);
	 	
	$prom_concepto=$conceptos[$prom-1];
	return $prom_concepto;//echo "<h1>$prom_concepto</h1>";
	
}
		$posp = $_POSP;//<----pertenece a while de imagenes

		$a = 0;
		$d = "";
		while ($a < $posp){ // while de imagenes
		$d = $d."../../sae3.0/";
		$a++; 
		}

function CursoPalabra_Informe($tipo,$ensenanza,$grado,$conn){
	$sql = "SELECT nombre_tipo FROM tipo_ensenanza WHERE cod_tipo=".$ensenanza;
	$rs_ense = @pg_exec($conn,$sql);
	$nombre_ense = @pg_result($rs_ense,0);
	
	if(($grado==1) and ($ensenanza==10)){
		$Curso_pal0 = "SALA CUNA, ".$nombre_ense;
		$Curso_pal1 =  "SC, ".$nombre_ense;
		$Curso_pal2 = "SALA CUNA ";
	}else if(($grado==2) and ($ensenanza==10)){
		$Curso_pal0 = "NIVEL MEDIO MENOR, ".$nombre_ense;
		$Curso_pal1 =  "NMM, ".$nombre_ense;
		$Curso_pal2 = "NIVEL MEDIO MENOR ";
	}else if(($grado==3) and ($ensenanza==10)){
		$Curso_pal0 = "NIVEL MEDIO MAYOR, ".$nombre_ense;
		$Curso_pal1 =  "NMM, ".$nombre_ense;	
		$Curso_pal2 = "NIVEL MEDIO MAYOR ";
	}else if(($grado==4) and ($ensenanza==10)){
		$Curso_pal0 = "TRANSICIÓN 1er NIVEL, ".$nombre_ense;
		$Curso_pal1 =  "T1N, ".$nombre_ense;
		$Curso_pal2 = "TRANSICIÓN 1er NIVEL ";
	}else if(($grado==5) and ($ensenanza==10)){
		$Curso_pal0 = "TRANSICIÓN 2do NIVEL, ".$nombre_ense;
		$Curso_pal1 =  "T2N, ".$nombre_ense;
		$Curso_pal2 = "TRANSICIÓN 2do NIVEL ";
	}
	if($tipo==0){
		return $Curso_pal0;
	}
	if($tipo==1){
		return $Curso_pal1;
	}
	if($tipo==2){
		return $Curso_pal2;
	}
	
}
function CursoPalabra_Ingles($id_curso, $tipo, $conn)

{

	// $tipo = 0 - palabra completa

	// $tipo = 1 - iniciales

	// $tipo = 2 - palabra completa solo curso sn enseñanza

	// $tipo = 3 - iniciales solo curso sn enseñanza

	

	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";

	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";

	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$id_curso.")); ";

	$result_curso =@pg_Exec($conn,$sql_curso);

	$fila_curso = @pg_fetch_array($result_curso,0);	



	if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

				

	}else if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==121987) or ($fila_curso['cod_decreto']==1521989)) ){

		$Curso_pal0 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));				

		$Curso_pal3 = "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

				

	}else if ( ($fila_curso['grado_curso']==1) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						


	}else if ( ($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

				

	}else if ( ($fila_curso['grado_curso']==2) and ($fila_curso['cod_decreto']==121987) ){

		$Curso_pal0 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==2) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   		

						

	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==4) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==5) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));				

		

	}else if ( ($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 ) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));						

		

	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

						

	}else{

		$ensenanza_nuevo= trim(strtoupper($fila_curso['nombre_tipo'])) ;
		if( !strcasecmp($ensenanza_nuevo,"ENSEÑANZA BÁSICA")  ){
			$ensenanza_nuevo="PRIMARY"; }
		if( !strcasecmp($ensenanza_nuevo,"ENSEÑANZA MEDIA HUMANÍSTICO - CIENTÍFICO")  ){
			$ensenanza_nuevo="SECONDARY HUMANISTIC - SCIENTIST"; }
		if( !strcasecmp($ensenanza_nuevo,"ENSEÑANZA MEDIA")  ){
			$ensenanza_nuevo="SECONDARY"; }

		$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $ensenanza_nuevo)); 

		$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $ensenanza_nuevo)); 		

		$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		

		$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 
		
		$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . " AÑO " )); 		

		

	}

	if ($tipo == 0)

		return $Curso_pal0;

	if ($tipo == 1)

		return $Curso_pal1;

	if ($tipo == 2)

		return $Curso_pal2;

	if ($tipo == 3)

		return $Curso_pal3;				
	if($tipo==4){
		return $Curso_pal4;
	}
}


function porcentaje($periodo,$id_ramo,$post,$nota,$conn,$id_ano){
				// sacamos el nro_ano
				$qry_ano    = "SELECT nro_ano FROM ano_escolar WHERE id_ano = '".$id_ano."'";
		        $result_ano = @pg_Exec($conn,$qry_ano);
		        $fila_ano   = @pg_fetch_array($result_ano,0);	
		        $nro_ano    = $fila_ano["nro_ano"];
								
				
				$sql_ponderado="SELECT $post FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$id_ramo;
				$sql_ponderado="SELECT $post FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$id_ramo;
				$resp = pg_exec($conn,$sql_ponderado);
				$ponderacion = pg_result($resp,0);
				if($ponderacion<1){
					
					if($nota<1){
						$pd1="&nbsp;";
					}else{
						$pd1="/";
					}
				
				}else{
					$pd = ($ponderacion / 100) * $nota;
					if ($pd<1){
						$pd1 = "&nbsp;";
					}else{
						$pd1=$pd;
					}
				}
				return $pd1;
				
}

//datediff rango de fechas
function ddiff($start, $end) {
    			
        $sdate = strtotime($start." 00:00:00");
        $edate = strtotime($end." 23:59:59");
		
        
        if ($edate < $sdate) {
            $sdate_temp = $sdate;
            $sdate = $edate;
            $edate = $sdate_temp;
            
        }
       $time = $edate - $sdate;
        $preday[0] = 0;
        
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);
               
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
               
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);
               
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;
               
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        

        return $preday[0]+1;
} 



//dias habiles por rango fijo, sin feriados
function hbl($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
		
		// $fechainicio.".....".$fechafin;;
		
        $fechainicio = strtotime($fechainicio." 00:00:00");
	 $fechafin = strtotime($fechafin." 23:59:59");
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
      //echo  count($diashabiles);
        return count($diashabiles);
}

//conteo inhabiles
function ihbl($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(1,2,3,4,5))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       //echo  count($diashabiles);
        return count($diashabiles);
}

//determinar si una fecha es de fin de semana o no
function EsSabadoDomingo($d)
{ 
	$dia=date('w', strtotime($d));
	if (($dia == 0) || ($dia == 6)) 
	{$c=1;}
	else{
	$c=0;
	}
	return $c;
}


//eliminar caracteres especiales
function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array("á", "à", "ä", "â", "ª", "Á", "À", "Â", "Ä"),
        array("a", "a", "a", "a", "a", "A", "A", "A", "A"),
        $string
    );

    $string = str_replace(
        array("é", "è", "ë", "ê", "É", "È", "Ê", "Ë"),
        array("e", "e", "e", "e", "E", "E", "E", "E"),
        $string
    );

    $string = str_replace(
        array("í", "ì", "ï", "î", "Í", "Ì", "Ï", "Î"),
        array("i", "i", "i", "i", "I", "I", "I", "I"),
        $string
    );

    $string = str_replace(
        array("ó", "ò", "ö", "ô", "Ó", "Ò", "Ö", "Ô"),
        array("o", "o", "o", "o", "O", "O", "O", "O"),
        $string
    );

    $string = str_replace(
        array("ú", "ù", "ü", "û", "Ú", "Ù", "Û", "Ü"),
        array("u", "u", "u", "u", "U", "U", "U", "U"),
        $string
    );

    $string = str_replace(
        array("ñ", "Ñ", "ç", "Ç"),
        array("n", "N", "c", "C"),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/", "?", "'", "¡","¿", "[", "^", "`", "]","+", "}", "{", "¨", "´",">", "< "),
        ' ',
        $string
    );


    return $string;
}


function CambioFD($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}


function CambioFDSN($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla sin año
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m;
	else
		$retorno="";
	return $retorno;
}

function CambioFE($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

function envia_mes2($i){
		switch($i){
			case 1:
				echo "ENERO";
				break;	
			case 2:
				echo "FEBRERO";
				break;	
			case 3:
				echo "MARZO";
				break;
			case 4:
				echo "ABRIL";
				break;		
			case 5:
				echo "MAYO";
				break;	
			case 6:
				echo "JUNIO";
				break;	
			case 7:
				echo "JULIO";
				break;	
			case 8:
				echo "AGOSTO";
				break;	
			case 9:
				echo "SEPT.";
				break;	
			case 10:
				echo "OCT.";
				break;	
			case 11:
				echo "NOV.";
				break;	
			case 12:
				echo "DIC.";
				break;	
			

				
		}
	}
	
	function espacio($cadena){
	$cad =str_replace("\n","<br>",$cadena);
	return $cad;
	}

	function CalcularEdad($fecha){
 list($Y,$m,$d) = explode("-",$fecha);
   return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
	
	function show($array){
	echo "<pre>";
	var_dump($array);
	echo  "</pre>";
	}
	
	function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
	
	
	function Iniciales($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		return trim(strtoupper(substr($Subsector,0,3)));
	else
		return trim($cadena);
}	

//funcion para convertir un numero en hora
function convertirMH($num){
        $res=$num/60;
        $div=explode('.',$res);
        $hor=$div[0];//aqui obtienes las horas
        $min=$num - (60*$hor);//aca obtienes los minutos
	return "$hor:$min";
    }
	
	
	//calculo edad
	function edad($fecha){
 list($Y,$m,$d) = explode("-",$fecha);
   return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}




//edad con años y meses
function edadAnoMes($fecha_inicio,$fecha_termino,$caso=""){
	//echo $fecha_inicio."--".$fecha_termino;
$arr_finicio = explode("-",$fecha_inicio);
$arr_termino = explode("-",$fecha_termino);
	// Comprobamos si hay algún año bisiesto. 86400 segundos es un dias
$fInicio = $ob_reporte->fecha_nacimiento;

$fFinal = $fecha_termino;
$AInicio = $arr_finicio[0];
$AFinal = $arr_termino[0];
$sumadiasBis=0;
for ($i = $AInicio; $i <= $AFinal; $i++) {
(($i % 4) == 0) ? $bis = 86400 : $bis = 0;
$sumadiasBis += $bis;
}

// Calculamos los segundos entre las dos fechas
$fechaInicio = mktime(0,0,0,$arr_finicio[1],$arr_finicio[2],$arr_finicio[0]);
$fechaFinal = mktime(0,0,0,$arr_termino[1],$arr_termino[2],$arr_termino[0]);
$segundos = ($fechaFinal - $fechaInicio);
$anyos = floor(($segundos-$sumadiasBis)/31536000);

$segundosRestante = ($segundos-$sumadiasBis)%(31536000);
$meses = floor($segundosRestante/2592000);

$segundosRestante = ($segundosRestante%2592000); // Suma un día mas por cada años bisiesto
//$segundosRestante = (($segundosRestante-$sumadiasBis)%2592000); // No suma un día mas por cada año bisiesto
$dias = floor($segundosRestante/86400);

if($caso==""){
return $anyos. " a&ntilde;os ".$meses. " meses";
}else if($caso==2){
return $anyos. " a&ntilde;os ";	
}
else{
return $anyos;	
}
}


 function lCapital($palabra){
	 $cad=ucfirst(strtolower($palabra))	;
	 return $cad; 
}

function semanasMes($year,$month)
{
    # Obtenemos el ultimo dia del mes
    $ultimoDiaMes=date("t",mktime(0,0,0,$month,1,$year));
 
    # Obtenemos la semana del primer dia del mes
    $primeraSemana=date("W",mktime(0,0,0,$month,1,$year));
 
    # Obtenemos la semana del ultimo dia del mes
    $ultimaSemana=date("W",mktime(0,0,0,$month,$ultimoDiaMes,$year));
	
	if($month==12 && $ultimaSemana=="01"){
	$ultimaSemana="52";	
	}
 
    # Devolvemos en un array los dos valores
	return array($primeraSemana,$ultimaSemana);
	
}

//convertir numero decimal a romano
function convertirNum($num) 
  {
   /*** intval(xxx) para que convierta explicitamente a int ***/
   $n = intval($num);
   $res = '';
   
   /*** Array con los numeros romanos  ***/
   $roman_numerals = array(
      'M'  => 1000,
      'CM' => 900,
      'D'  => 500,
      'CD' => 400,
      'C'  => 100,
      'XC' => 90,
      'L'  => 50,
      'XL' => 40,
      'X'  => 10,
      'IX' => 9,
      'V'  => 5,
      'IV' => 4,
      'I'  => 1);
   
   foreach ($roman_numerals as $roman => $number) 
   {
    /*** Dividir para encontrar resultados en array ***/
    $matches = intval($n / $number);
   
    /*** Asignar el numero romano al resultado ***/
    $res .= str_repeat($roman, $matches);
   
    /*** Descontar el numero romando al total ***/
    $n = $n % $number;
   }
   
   /*** Res = String ***/
   return $res;
  }


//encriptar
function encriptar_AES($string)
{
	
	$key="colegiointeractivo";
	
     $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
     $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM );
     mcrypt_generic_init($td, $key, $iv);
     $encrypted_data_bin = mcrypt_generic($td, $string);
     mcrypt_generic_deinit($td);
     mcrypt_module_close($td);
     $encrypted_data_hex = bin2hex($encrypted_data_bin);
     return $encrypted_data_hex;
 }
 
 function desencriptar_AES($encrypted_data_hex)
 {
     $key="colegiointeractivo";
	 $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
     $iv_size_hex = mcrypt_enc_get_iv_size($td)*2;
     $iv = pack("H*", substr($encrypted_data_hex, 0, $iv_size_hex));
     $encrypted_data_bin = pack("H*", substr($encrypted_data_hex, $iv_size_hex));
     mcrypt_generic_init($td, $key, $iv);
     $decrypted = mdecrypt_generic($td, $encrypted_data_bin);
     mcrypt_generic_deinit($td);
     mcrypt_module_close($td);
     return $decrypted;
 }
 
  function check_valid_image_size( $file ) { 
  $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'); 
  if (!in_array($file['type'], $allowed_mimetypes))
  { return $file; } 
  $image = getimagesize($file['tmp_name']); 
  $maximum = array( 'width' => '100', 'height' => '100' );
   
  $image_width = $image[0]; $image_height = $image[1]; 
  $too_large = "Image dimensions are too large. Maximum size is {$maximum['width']} by {$maximum['height']} pixels. Uploaded image is $image_width by $image_height pixels."; 
  if ( $image_width > $maximum['width'] || $image_height > $maximum['height'] ) {
	   //add in the field 'error' of the $file array the message 
	   $file['error'] = $too_large; 
	   
	   return $file; 
	   }
	   else { return $file; } 
  }
  
  function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

function cortar_palabras($texto, $largor = 20, $puntos = "...") 
{ 
   $palabras = explode(' ', $texto); 
   if (count($palabras) > $largor) 
   { 
     return implode(' ', array_slice($palabras, 0, $largor)) ." ". $puntos; 
   } else
         {
           return $texto; 
         } 
} 

function truncate_number($number, $precision = 2) {

    // Zero causes issues, and no need to truncate
    if (0 == (int)$number) {
        return $number;
    }

    // Are we negative?
    $negative = $number / abs($number);

    // Cast the number to a positive to solve rounding
    $number = abs($number);

    // Calculate precision number for dividing / multiplying
    $precision = pow(10, $precision);

    // Run the math, re-applying the negative value to ensure
    // returns correctly negative / positive
    return floor( $number * $precision ) / $precision * $negative;
}

function truncateFloat($number, $digitos)
{
    $raiz = 10;
    $multiplicador = pow ($raiz,$digitos);
    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
    return number_format($resultado, $digitos);

}


function convertirNotaPorcentaje($nota,$rbd,$conn){
  
$query = "select * from escala_notas where rbd=".$rbd;
$rs = pg_exec($conn,$query);
if(pg_numrows($rs)==0){
$query = "select * from escala_notas where rbd=0";
$rs = pg_exec($conn,$query);
}

$fila = pg_fetch_array($rs,0);


//echo "<br>nota_recibida->".
$nota = $nota/10;   
//echo "<br>min->".
$nmin = $fila['nmin'];
//echo "<br>max->".
$nmax = $fila['nmax'];
//echo "<br>apr->".
$napr = $fila['napr'];
//echo "<br>exig->".
$nexi = $fila['exig'];
    
$pmax = 100;
    
     

if($nota < $napr){
  $p = (($nota - $nmin) / ($napr - $nmin)) * ($nexi*$pmax);
	
}
else{
	 $p =( ( ($nota - $napr) / ($nmax - $napr)) * ($pmax*(1-$nexi)) ) + ($nexi*$pmax)  ;
   
	 
}

 return round($p,0);
}


  function desifranotaconseptualGlobal($conn,$dato,$rdb){
$nueva_nota=0;

	$sql="SELECT valor_numerico, rango_x, rango_y FROM modulo_conceptos WHERE AND id_rdb=".$rdb." AND nombre_concepto=".$dato;
	
	if($_PERFIL==0){echo $sql;}
	$rs_concepto = pg_exec($conn,$sql);
	$nueva_nota = pg_result($rs_concepto,0);
	return $nueva_nota;
	
}

function promedioconceptualglobal($conn,$prom_conc,$rbd){
	$letra = "";
	
	
	$sql="SELECT nombre_concepto FROM modulo_conceptos WHERE id_rdb=".$rbd." AND rango_x >=".$prom_conc." AND rango_y <=".$prom_conc;
	$rs_result = pg_exec($conn,$sql);
	$letra = pg_result($rs_result,0);
	/*if( $prom_conc >=60 && $prom_conc <= 70 ) $letra = 'SI';
	if( $prom_conc >=50 && $prom_conc <= 59 ) $letra = 'G';
	if( $prom_conc >=40 && $prom_conc <= 49 ) $letra = 'RV';
	if( $prom_conc >0   && $prom_conc <= 39 ) $letra = 'N';*/
	
	return $letra;
	}
    

function getEscalaNotas($rbd,$conn){
  
 $query = "select * from escala_notas where rbd=".$rbd;
	$rs = pg_exec($conn,$query);
	if(pg_numrows($rs)==0){
$query = "select * from escala_notas where rbd=0";
	$rs = pg_exec($conn,$query);
	}
return $rs;
}


function ConceptualBD($nota,$tipo,$ano,$rbd,$conn)

{

	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual

	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico

	$nota_res=0;

	$concepto="";	
	
	$campo=($tipo==1)?"nombre_concepto":"valor_numerico";
	
	$param=($tipo==1)?" and rango_x <=$nota and rango_y>=$nota":" and nombre_concepto='$nota'";	
	
	//a buscar al coegio
	$sql_conc = "select $campo from modulo_conceptos where id_ano=$ano and id_rdb=$rbd $param ";
	$rs_conc= pg_exec($conn,$sql_conc); 

//if($_SESSION['_PERFIL']==0){echo "<br>".$sql_conc;}
	//si encontre datos
	if(pg_numrows($rs_conc)>0){
		$valor = pg_result($rs_conc,0);
		
		return $valor;
	
	}//fin si encontre datos
	
	//no encontre datos
	else{
	
		
	if ($tipo == 1)

	{

		if ($nota >= 60 and $nota<=70)

			$concepto = "MB";

		if ($nota >= 50 and $nota<=59)

			$concepto = "B";

		if ($nota >= 40 and $nota<=49)

			$concepto = "S";

		if ($nota >= 0 and $nota<=39)

			$concepto = "I";
		
		if($nota==0)
		
			$concepto = "-";

		

		return $concepto ;

	}

	else

	{

		if (trim($nota) == "MB")

			$nota_res = 65;

		if (trim($nota) == "B")

			$nota_res = 55;			

		if (trim($nota) == "S")

			$nota_res = 45;

		if (trim($nota) == "I")

			$nota_res = 35;						

		

		return $nota_res;

		

	}

	}//fin escala estandar

	

}
  
?>
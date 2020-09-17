<?
/*<!--<script language=JavaScript>

var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
 
</script>
// -->*/



?>

<?

	
	/////////////////

	//INICIO SESSION

	/////////////////

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


	if(!($_CHK_ID==session_id())){//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION

//		echo "ERROR DE ACCESO, LA SESION DE USUARIO HA EXPIRADO...";
		echo "<script>window.location = 'http://intranet.colegiointeractivo.cl/sae3.0/session/finSession.php'</script></HEAD><BODY></BODY></HTML>";

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
		if($mes=="01"){$t_mes=Enero;}
		if($mes=="02"){$t_mes=Febrero;}
		if($mes=="03"){$t_mes=Marzo;}
		if($mes=="04"){$t_mes=Abril;}
		if($mes=="05"){$t_mes=Mayo;}
		if($mes=="06"){$t_mes=Junio;}
		if($mes=="07"){$t_mes=Julio;}
		if($mes=="08"){$t_mes=Agosto;}
		if($mes=="09"){$t_mes=Septiembre;}
		if($mes=="10"){$t_mes=Octubre;}
		if($mes=="11"){$t_mes=Noviembre;}
		if($mes=="12"){$t_mes=Diciembre;}	
		//fin descripcion					
		$ano = substr($fecha,6,4);
		$fecha = "$dia "."de"." $t_mes "."de"." $ano";
		return($fecha);
	}
	
	function envia_mes($mes)
	{
		if($mes=="01"){$t_mes=Enero;}
		if($mes=="02"){$t_mes=Febrero;}
		if($mes=="03"){$t_mes=Marzo;}
		if($mes=="04"){$t_mes=Abril;}
		if($mes=="05"){$t_mes=Mayo;}
		if($mes=="06"){$t_mes=Junio;}
		if($mes=="07"){$t_mes=Julio;}
		if($mes=="08"){$t_mes=Agosto;}
		if($mes=="09"){$t_mes=Septiembre;}
		if($mes=="10"){$t_mes=Octubre;}
		if($mes=="11"){$t_mes=Noviembre;}
		if($mes=="12"){$t_mes=Diciembre;}	
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
		
		$x.=substr($txt,6,4); 
		
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

        };  		



	///////////////////////////////

	//CONECCION A LA BASE DE DATOS

	//////////////////////////////

//	$conn=pg_connect("dbname=coe port=1550 user=postgres password=cole#newaccess");
  //  $conn=pg_connect("dbname=coe30 host=localhost port=1550 user=postgres password=coleint@2005jz");
    if ($_USUARIO == 90404){	
	    
	    $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess"); 
	}else{ 
	    //$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
		$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");
	}	
	if (!$conn) {

	 error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	 exit;
	 
	 
	
	 
//VEL	 	$conn=pg_connect("dbname=coe_traspaso host=200.22.29.33 port=3110 user=postgres password=cole#newaccess");
//			if(!$conn){
//				 error('<b>ERROR:</b>No se puede conectar a la base de datos.');
//				 exit;			
//			}
	}

    
	
	

//	echo "[Perfil]".$_PERFIL."[Modo]".$_FRMMODO."[Ramo]".$_RAMO."[Usuario]".$_USUARIO."[Curso]".$_CURSO."[Instit]".$_INSTIT."[AÑO]".$_ANO."[REGIMEN]".$_TIPOREGIMEN;

//	echo "[Ramo]".$_RAMO;

//	echo "[Perfil]".$_PERFIL."[TipoDocente]".$_TIPODOCENTE;

	if(($_ANO=="")and($_INSTIT!="")){
		$qry_ano="SELECT * FROM ano_escolar WHERE id_institucion = '".$_INSTIT."' AND situacion = 1";
		$result_ano = @pg_Exec($conn,$qry_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);	
		$_ANO=$fila_ano["id_ano"];
		session_register("_ANO");
	}


	///////////////////////////////

	//USUARIOS EN LINEA-/VEL/-

	//////////////////////////////
	
//if($_INSTIT==8933){	
//echo "Trabajando en colegio de prueba...";
// $_USUARIOENSESION; <--Nombre del usuario
// $_USUARIO; <-- Id de usuario
// $ruta = $_SERVER[REQUEST_URI]; <-- Ruta de navegacion
//echo $_SERVER['HTTP_USER_AGENT'];
			//obteniendo la ip del usuario.
			
			
			
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
			$isp = $str[$n] . "." . $str[$x];			
			/* Muestra la ip y el isp del usuario
			echo '<div align="justify">Tu IP: '.$ip.'<br />Tu ISP: '.$isp.' </div>'; */
			
			//Muestra la ruta en la cual se encuentra el usuario
			$ruta = $_SERVER[REQUEST_URI];
			
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
			 
			 

//}
		

//-------------/ FIN USUARIOS EN LINEA /--------------------------



// ------ / Compara fecha / -----------------

//   sintaxis:

//       int Comparafecha (fecha , fecha)

//   Descripcion : devuelve la posicion

//   de la fecha mayor 1 o 2  y 0 si es igual

//-------------------------------------------

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

						

	}else if ( ($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   		
		
		
	}else if ( ($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==771982)) ){

		$Curso_pal0 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   			

						

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

	

		$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 

		$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 		

		$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		

		$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		
	
	}

	if ($tipo == 0)

		return $Curso_pal0;

	if ($tipo == 1)

		return $Curso_pal1;

	if ($tipo == 2)

		return $Curso_pal2;

	if ($tipo == 3)

		return $Curso_pal3;				

}



Function Conceptual($nota, $tipo)

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

	$sqlFeriados = "select * from feriado where id_ano = ".$id_ano." and fecha_inicio >= '".$fecha1."' and fecha_inicio <= '".$fecha2."' order by fecha_inicio";

	$rsFeriado =@pg_Exec($conn,$sqlFeriados );

	for($i=0 ; $i < @pg_numrows($rsFeriado) ; ++$i)

	{

		$fFeriado= @pg_fetch_array($rsFeriado,$i);

		

		$fecha_inicio = $fFeriado['fecha_inicio'];

		$fecha_fin = $fFeriado['fecha_fin'];

		if (!empty($fecha_fin)){

			$dias_entre = DateDiff('d',$fecha_inicio, $fecha_fin);

			$dias = $dias + $dias_entre+1;

		}else{

			$dias = $dias + 1;

		}

	}



	$diferencia = datediff('w', $fecha1, $fecha2, false);

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

		

	}

	if ($tipo == 0)

		return $Curso_pal0;

	if ($tipo == 1)

		return $Curso_pal1;

	if ($tipo == 2)

		return $Curso_pal2;

	if ($tipo == 3)

		return $Curso_pal3;				
}



?>










<?php
	/////////////////
	//INICIO SESSION
	/////////////////
	session_start();	
	
	
	if(!($_CHK_ID==session_id())){//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION
		echo "ERROR DE ACCESO, LA SESION DE USUARIO HA EXPIRADO...";
		session_unset();
		session_destroy();
		exit;
	};
//	session_cache_limiter ('nocache'); // SETEA SIN CACHE DE PAGINA

	///////////
	//FUNCIONES
	///////////

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
		$x .= "     <a href=\"".$path."logout.php3\" target=\"_parent\"><INPUT TYPE=\"image\" SRC=\"".$path."btn_logout.gif\" disabled></a>";
		$x .= "	  </td>";
		$x .= "	</tr>";
		$x .= "	</table>";
		return $x;
		
	};

	function imp($txt){
		if(trim($txt)!=""){
			echo trim($txt);
		}else{
			echo "<FONT face=arial size=2 color=white>.</FONT>";
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
		$x.=substr($txt,6,4); //AÑO
		return $x;
	};

 	function Cfecha($txt){
                $x= substr($txt,8,2); // DIA
                $x.="-";
                $x.=substr($txt,5,2); //MES
                $x.="-";
                $x.=substr($txt,0,4); //AÑO
                return $x;
        };  

	///////////////////////////////
	//CONECCION A LA BASE DE DATOS
	//////////////////////////////
	$conexion =@pg_connect("dbname=coe port=1550 user=postgres password=colegiogc2004#");
	if (!$conexion) {
	 error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	 exit;
	}

//	echo "[Perfil]".$_PERFIL."[Modo]".$_FRMMODO."[Ramo]".$_RAMO."[Usuario]".$_USUARIO."[Curso]".$_CURSO."[Instit]".$_INSTIT."[AÑO]".$_ANO."[REGIMEN]".$_TIPOREGIMEN;
//	echo "[Ramo]".$_RAMO;
//	echo "[Perfil]".$_PERFIL."[TipoDocente]".$_TIPODOCENTE;



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

		
	function Cfecha2($txt){
                $x= substr($txt,8,2); // DIA
                $x.="/";
                $x.=substr($txt,5,2); //MES
                $x.="/";
                $x.=substr($txt,0,4); //AÑO
                return $x;
        };  



?>
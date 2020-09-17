<? 
require('../util/header.inc');

$institucion	=$_INSTIT;
$usuarioensesion = $_USUARIOENSESION;
$id = $_GET['id'];
$idusuario = $_USUARIO;
$_POPS=1;




?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script language="JavaScript"> 
function ventanaSecundaria (URL){ 
window.open(URL,"ventana1","width=500, height=350, scrollbars=yes, menubar=no, location=no, resizable=yes") 
} 
</script> 
<script language="JavaScript" type="text/javascript">
<!--
function showSelected()



{
var Obj = document.formulario('selSeaShells');
var len = Obj.length
alert(len);

var i,texto;
texto=""
for (i=0; i<len; i++) {
if (Obj[i].selected) {
texto=texto + ";" + Obj[i].value
}
}

document.formulario('txtIndex').value=texto


}

//-->
</script>


<SCRIPT type=text/javascript>
<!--
/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.submenu3{display: none;}\n')
document.write('</style>\n')
}

function SwitchMenu(obj){
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		if(el.style.display != "block"){ //DynamicDrive.com change
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu3") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="680" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="680" align="left" valign="top">
	<table width="100%" height="754" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="677" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="480" colspan="3"><table width="100%" height="1%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="467" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="389">
								  
								  
								  <!------------------------------------------inicio codigo mensajeria -------------------->
								  
								  <SCRIPT type=text/javascript>
<!--
/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.submenu3{display: none;}\n')
document.write('</style>\n')
}

function SwitchMenu(obj){
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		if(el.style.display != "block"){ //DynamicDrive.com change
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu3") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>



								  
 <? if ($_POST['respuesta'] == NULL){ 

	?>                           
 <form name="recibir" method="POST" action=""  enctype="multipart/form-data">
                                      <table width="" height="381" border="1">
                                        <tr>
                                          <td height="296" valign="top">
										  
										  
										  <table width="" border="0">
                                              <tr>
                                                <td height="23" colspan="2" valign="top">
                                                  <table width="100%" border="1">
                                                    <tr>
                                                      <td width="415"><a href="enviados.php"><span class="Estilo1">Bandeja de enviados</span></a></td>
                                                     
                                                      <? //$fecha = date('m-d-Y');
$hora = date('h:i:s');
$dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$di = date('w');
$dis = $di-1;
$dia = $dias[$dis];

//$mess = $messs[date('n')];
$e = date('n');
$ass = $e-1;
$mess = $mes[$ass];
$diass = date(d);
$an = date(Y);
// fin  hora 
?>
<? 

$a = 1;
$qryse="UPDATE mensajero SET lee=".$a."where id_mensaje=".$id;
$resultas =pg_Exec($conn,$qryse);



    $qry="SELECT * FROM mensajero where id_mensaje=".$id;

/*."and id_perfil =1";//.$perfil_user;*/
	$result =pg_Exec($conn,$qry);
	$num=pg_numrows($result);
	if (!$result) {
											
	error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
	}else{
											
											
		 $i = 0; 
	while($row = pg_fetch_array($result)){
												
		$id = $row["id_mensaje"];												
		$de = $row["user1men"];
		$para = $row["user2men"];
		$mensaje = $row["mensaje"];
		$asunto = $row["asunto"];
		$idusuario = $row["id_usuario"];
		$horas = $row["hora"];
		$fecha = $row["fecha"];
		$archivor = $row["archivos"];
		
		
		/* $qrypara="select * from usuario where nombre_usuario='".$para."'";
		$resultadopara=pg_Exec($connect,$qrypara)or die("Fallo s1...".$qrypara);
		$filapara=pg_fetch_array($resultadopara,0);
		 "Rut_User".$rut_usuario=$filapara['nombre_usuario'];*/
		
		$selectusuariofinal="select * from empleado where rut_emp='".$para."'";
		$resultadouserfinal=pg_Exec($conn,$selectusuariofinal)or die("Fallo sl2".$selectusuariofinal);
		$filauserf=pg_fetch_array($resultadouserfinal,0);
		 "nom->".$nombre_completo=$filauserf['nombre_emp'].$filauserf['ape_pat'];
		 
		 if(!isset($nombre_completo)){
			 $selectusuariofinal="select * from apoderado where rut_apo=".$rut_usuario;
		$resultadouserfinalapo=pg_Exec($conn,$selectusuariofinalapo)or die("Fallo sl2".$selectusuariofinalapo);
		$filauserapo=pg_fetch_array($resultadouserfinalapo,0);
		 "nom->".$nombre_completo=$filauserapo['nombre_apo'].$filauserapo['ape_pat'];
			 }
			 
			 if(!isset($nombre_completo)){
			 $selectusuariofinal="select * from alumno where rut_alumno=".$rut_usuario;
		$resultadouserfinalalum=pg_Exec($conn,$selectusuariofinalalum)or die("Fallo sl2".$selectusuariofinalalum);
		$filauseralum=pg_fetch_array($resultadouserfinalalum,0);
		 "nom->".$nombre_completo=$filauseralum['nombre_alu'].$filauseralum['ape_pat'];
			 }
		//$archivos=unserialize($row['archivos']);
		//$largo_archivos=count($archivos);
		//$archivos = $row["archivos"];

 } }?>
                                                      <td width="255" class="cuadro02">
                                                      <div align="center" class="Estilo1"> <? echo $dia.", ".$diass." ".$mess." ".$an; ?>&nbsp;</div></td>
                                                    </tr>
                                                  </table></td>
                                              </tr>
                                              <tr>
                                                <td width="148" height="23" class="cuadro02">De: </td>
                                                <td width="596" class="cuadro01"><? echo $usuarioensesion ?></td>
                                              </tr>
                                              <tr>
                                                <td height="23" class="cuadro02">Para : </td>
                                                <td height="23" class="cuadro01"><? echo $nombre_completo; ?>	 
												<input name=respuesta Type= "hidden" value="<? echo $idusuario; ?>" ></td>
												</tr>
                                              <tr>
                                                <td height="23" class="cuadro02">Asunto : 
                                                  <label></label>
                                                </span>                                                  <label></label></td>
													<td height="23">                                                  <input name="men_asunto" type="text" id="men_asunto" value="<? echo $asunto; ?>">                                                  </td>
                                              </tr>
                                              <tr>
                                                <td height="23" class="cuadro02">Archivos Adjuntos : </td>
                                                <td height="23"><input type="hidden" name="MAX_FILE_SIZE" value="100000" >
                                                    <input type="file" name="archivo" value="Examinar" ></td>
                                              </tr>
                                              <tr>
                                                <td height="16" colspan="2"> </td>
                                              </tr>
                                              <tr>
                                                <td height="16" colspan="2">
												
												<table width="100%" border="1">
                                                  <tr class="cuadro02">
                                                    <td width="288"><span class="Estilo7">De: <? echo $para; ?></span></td>
                                                    <td width="283"><span class="Estilo7">Fecha: <? echo $fecha; ?></span></td>
                                                    <td width="96"><span class="Estilo7">Hora: <? echo $horas ?></span></td>
                                                  </tr>
												  
												  <table border="1" width="100%" height="200">
                                                  <tr>
                                                    <td colspan="3" valign="top" align="center"><span class="cuadro02">Mensaje :</span><span class="Estilo7"><br>
                                                    <center><textarea name="mensaje" cols="80" rows="10" id="mensaje" ><? echo $mensaje ?></textarea></center></span></td>
												  </tr>
												  
                                                  <tr>
                                                    <td colspan="3" class="cuadro02"><span class="Estilo7">Archivos Adjuntos : <a href="archivos/<? echo $archivor ?>" target="_blank" ><? echo $archivor ?></a></span>                                                    </td>
                                                  </tr>
												  </table>
                                                  <tr>

                                   <td colspan="3">&nbsp;</td>
                                                  </tr>
                                                </td>
                                              </tr>
											 <div id="masterdiv3">			
					                         
                                             
                                              
                                          </table>
										  
										  <span class="submenu3" id="escribir_respuesta">
                                            <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td><br><div align="center">
                                                  <textarea name="mensaje" cols="80" rows="10" id="mensaje" ></textarea>
                                                </div></td>
                                              </tr>
                                              <tr>
                                                <td><label>
                                                  <input type="submit" name="Submit3" value="Enviar" class="botonXX">
                                                  <a href="enviados.php"><span class="Estilo1">Bandeja de enviados</span></a></label></td>
                                              </tr>
                                            </table>
										  </span>	
											</div>
											
											</td>
                                        </tr>
                                      </table>
                                    </form>
									
									<div align="center">
									 <? }else{
if ( $_POST["respuesta"] != NULL){
									  
$hora = date('h:i:s');
$dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$di = date('w');
$dis = $di-1;
$dia2 = $dias[$dis];

//$mess = $messs[date('n')];
$e = date('n');
$ass = $e-1;
$mess2 = $mes[$ass];
$diass2 = date(d);
$an2 = date(Y);
//$fecha = $dia2." , ".$diass2." ".$mess2." ".$an2;
$fecha = date('m-d-y');
$hora = date('h:i:s');
// fin  hora 
?>
									  
									 <?  //inserto mensaje
									 
									$para = $_GET["usuario"];
									$men = $_POST["mensaje"];
									$asu = $_POST["men_asunto"];
									$paras = $_POST["respuesta"];
									$archi = 'archivo';
									$de = $_NOMBREUSUARIO;
									
$archivos =$HTTP_POST_FILES['archivo']['name'];
//echo"<br>";
//echo "archivos -->".$archivos."<br>";
//echo "archivo recibido -->".$archivo;		

if (isset($archivos)  && strlen($archivos)>0){							
	if (!copy($_FILES['archivo']['tmp_name'],"archivos/".$archivos)){ 
       echo ".Ocurrió algún error al subir el fichero. No pudo guardarse"; 
    }else{ 
       echo "El archivo ha sido cargado correctamente."; 
    }
									
	}	else {
	$archivo = "";}							
?><!-- nombre --><?	









$largo =0;	
$largo=count($paras);
								
for ($as=0;$as<$largo;$as++){


$qryqw="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$de;

$resultrtw = pg_Exec($conn,$qryqw);
       
if (!$resultrtw){
	   
        error('<b>ERROR: No pude acceder a la base de datos</b>');
			 
}else{//1/2
			 
      while ( $filass = pg_fetch_array($resultrtw)){
	   
	   $nombres = $filass["nombre_emp"];
	   $nombres = trim($nombres);
	   
	   $apellido = $filass["ape_pat"];
	   $apellido = trim($apellido);
	   $nombre = $nombres." ".$apellido;
	   
	   }
	   
	   
	   
       //$nombres = $filass["nombre_emp"]."".$filass["ape_pat"];
	  
	 if ($nombre == NULL){//2
		 $qrye="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$de;
		 
		 $resultase = @pg_Exec($conn,$qrye);
						 
		  if (!$resultase){
	  
		   error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
	   
		  }else{//2/2
	  
			  $filae = @pg_fetch_array($resultase); 
		  
			  //$nombre = $filae["nombre_alu"]."".$filae["ape_pat"];
	  
	      $nombres = $filae["nombre_alu"];
	      $nombres = trim($nombres);
	   
	   $apellido = $filae["ape_pat"];
	   $apellido = trim($apellido);
	   $nombre = $nombres." ".$apellido;
	  
		   }//2/2
	  }//2
	  
	  
	  if ($_PERFIL == 15){//2
	      $nombreusuario=$_NOMBREUSUARIO;
	      $qrynueva="SELECT * FROM APODERADO WHERE RUT_APO='".$nombreusuario."'";
		  $resultnueva = @pg_Exec($conn,$qrynueva);
		  if (!$resultnueva){
			  error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
		  }else{
			  $filanueva = @pg_fetch_array($resultnueva,0);	
			  		
			  //Nombre de quien inició la session
			  $nombre = $filanueva["nombre_apo"];
			  $nombre.= $filanueva["ape_pat"];
			  $nombre.= $filanueva["ape_mat"];
		  }; 
      }	 
}								
									
?><!-- fin nombre --><?									
									
									
									

									
 $qryser="INSERT INTO mensajero (user1men,user2men,mensaje,asunto,archivos,fecha,lee,id_usuario,hora) VALUES ('".$nombre."','".$paras."','".$men."','"."".'Re: '.$asu."','".$archivos."','".$fecha."','0','".$idusuario."','".$hora."')";
		
$resus =pg_Exec($conn,$qryser);
									?>
									
									<center>
									  <span class="textonegrita">Su mensaje ha sido enviado.</span>
									</center>
									<?php 
									 }
									 
									 
									//echo $archivo;
									//echo $archivos; 
									 }} //fin else 
									?>
									
                                    <!------------------------------------------- fin codigo mensajeria  ---------------------------------------------------------------- -->
	                                <center><br><a href="enviados.php" target="_self">Bandeja de enviados</a></center></div></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="12" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

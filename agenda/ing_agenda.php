<?
require('../util/header.inc');
$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;
$_MDINAMICO = 1;
$perfil = $_PERFIL; 
$usuarioensesion = $_USUARIOENSESION;

$ano2 = date(Y);

function sanear_string1($string)
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
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
              " "),
        "",
        $string
    );


    return $string;
}


if ($fecha_caduca == NULL OR $fecha_caduca == ""){
   $fecha_caduca = "01-01-2001";
}
$dia  = substr($fecha_inicio,8,2);
$diac = substr($fecha_caduca,8,2);   


$tiempo = time();
$tiempo = substr($tiempo,4,3);

$file1   = $_FILES['file']['name'];
$file1 = sanear_string1($file1);
$imagen1 = $_FILES['imagen']['name'];

if ($_FILES['file']['size']!= 0){
   $file1   = "$tiempo$file1";
}
if ($_FILES['imagen']['size']!= 0){   
   $imagen1 = "$tiempo$imagen1";
}
//---------------------------
	$sql_padre = "select max(id_padre) as maximo_id from agenda";	
	$res_padre = pg_Exec($conn,$sql_padre);
	$fila_padre = pg_fetch_array($res_padre);
	$cont_max_id = $fila_padre['maximo_id'];	
	$cont_max_id++;
//----------------------------
//-------------------------- Cuenta dias a ingresar
function CalculaDias($fec0, $fec1){ 
	$s = strtotime($fec1)-strtotime($fec0);
	$d = intval($s/86400);
	$s -= $d*86400;
	$h = intval($s/3600);
	$s -= $h*3600;
	$m = intval($s/60);
	$s -= $m*60;
	return $d;
}

$dia1= $fecha_inicio;
$dia2= $fecha_caduca;
$a=CalculaDias($dia1, $dia2);
$cont_dias = 0;

//-----------------------------

if ($a >= 0){
   // entonces hago varios registros en la tabla agenda
   $aume=0;
   $n_fecha=$fecha_inicio;
	
   while ($cont_dias <= $a){ 
	
       $sqlInsert = "insert into agenda 
	   (rdb,id_curso,id_ano,id_usuario,fecha,caduca,titulo,detalle,file,imagen,para,id_padre) values 
	   ('$institucion','$cmb_curso','$ano','$perfil','$n_fecha','$fecha_caduca','$titulo','$detalle','$file1','$imagen1','$cmb_curso','$cont_max_id')";
       $rsInsert = pg_Exec($conn,$sqlInsert);
	   
	   $aume++;
	   $n_fecha=suma_dias($fecha_inicio,$aume);
       $cont_dias++;
   }
}else{
    	$sqlInsert = "insert into agenda (rdb,id_curso,id_ano,id_usuario,fecha,caduca,titulo,detalle,file,imagen,para,id_padre) values 
	   ('$institucion','$cmb_curso','$ano','$perfil','$fecha_inicio','$fecha_caduca','$titulo','$detalle','$file1','$imagen1','$cmb_curso','$cont_max_id')";
    	$rsInsert = pg_Exec($conn,$sqlInsert);
		if (!$rsInsert){
	    	echo "Error, no se ha insertado el registro".$sqlInsert;
			exit();
    	}		
}    
	
if (!$rsInsert){
    echo "ERROR EN: $sqlInsert"; 
    exit;
}else{
    // copiamos ahora el archivo en el servidor
	//$newfile = "/var/www/html/coeint_ver9.1/tmp/".$txtNOMBRE;
	if ($_FILES['file']['size'] != 0){
       if (!copy($file,"files/".$file1)) {
          echo "No se puede subir el archivo adjunto";
       }
	}
	if ($_FILES['imagen']['size'] != 0){
	   if (!copy($imagen,"images/".$imagen1)) {
           echo "No se puede subir la foto";
       }
	}   
}	


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=latin9">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<style type="text/css">
<!--
.Estilo2 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<meta http-equiv="refresh" content="1;URL=lista_agenda.php?sw=1">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              
			 
			   <tr align="left" valign="top"> 
                <td height="75" valign="top">
				
				    <?
			         include("../cabecera/menu_superior.php");
			        ?>
				
				</td>
              </tr>
			  
			  </table>
			  
			  
			  
             
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
						include("../menus/menu_lateral.php");
						?> 
					  
					  
                    </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="center" valign="top"> 
                                  <td height="162" align="center">
								       <table width="100%">
						            <tr><td class="tableindex"><div align="center">INGRESO DE INFORMACION A LA AGENDA DIARIA</div></td></tr></table>
								       <br>
									  
								        <span class="Estilo2">Ingresando Informaci&oacute;n...</span>								    </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?
function suma_dias($fecha,$ndias)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($año,$mes,$dia)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($año,$mes,$dia)=split("-",$fecha);

      $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
      $nuevafecha=date("Y-m-d",$nueva);
      return ($nuevafecha);  
}
?>
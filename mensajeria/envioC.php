<? 
require('../util/header.inc');
//print_r($_POST);
//show($_POST);
$institucion	=$_INSTIT;
$usuarioensesion = $_USUARIOENSESION;
$perfil_user =$_PERFIL;

 $idusuario   =$_USUARIO;
 $rut_usuario2= $_NOMBREUSUARIO;

$ano		 =$_ANO;
$contador    = 0;
$_POSP = 1;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.Estilo1{
font:Arial, Helvetica, sans-serif;
color:#666666;
size:2;
}
</style>
<script type="text/javascript" src="../admin/clases/jquery/jquery.js"></script>
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
<script>
function inserta(){
var i;
i= i+1;
return i;
}
</script>
<script language="javascript" type="text/javascript">
<!--
function delRow(a)
{
b="adjunta["+a+"]";
a="td"+a;
z=document.getElementById(b);
z.disabled=true;
x=document.getElementById(a);
x.style.display="none";
//x=document.getElementById('mytable').deleteRow(a)
}

function insRow()
{
	largo=document.getElementById('mytable').rows.length;
	var x=document.getElementById('mytable').insertRow(largo);
	j=largo;
	var y=x.insertCell(0)
	y.className="td2";
	y.id="td"+j;
	y.innerHTML="<input name='adjunta["+j+"]' type='file' id='adjunta["+j+"]'><input name='nombreadjunta["+j+"]' type='hidden' id='adjunta["+j+"]'>		<a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"

}

function tomaNombre(box){
	var checkStr = box.value;
	var checkOK = "/\\";
	
	for (i = checkStr.length;  i >= 0;  i--){
		ch = checkStr.charAt(i);
		for (x = 0;  x < checkOK.length;  x++)
			if (ch == checkOK.charAt(x)){
				//alert(checkStr.substr(i+1,checkStr.length-i));
				return checkStr.substr(i+1,checkStr.length-i);
				break;
		};
	};
	return false;
};

function coloca_nombre(){
largo=document.getElementById('mytable').rows.length;
	for (ii=1;ii<largo;ii++){
		origen="adjunta["+ii+"]";
		z=document.getElementById(origen);
		temp=tomaNombre(z)
		
		destino="nombreadjunta["+ii+"]";
		zz=document.getElementById(destino);
		zz.value=temp;	
	}
}

function muestra_tabla(tabla){
a=document.getElementById(tabla);
if (a.style.display=="none"){
	a.style.display="";
	}else{
	a.style.display="none";
}
}


function coloca_nombre_colegio(){
document.form.nombre_colegio2.value=document.form.rdb.value;
alert(document.form.nombre_colegio2.value);
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
$(document).on('change','input[type="file"]',function(){
	// this.files[0].size recupera el tamaño del archivo
	// alert(this.files[0].size);
	
	var fileName = this.files[0].name;
	var fileSize = this.files[0].size;
	
	var valid1 = /^[-_\w\.\:\\]+$/;

			if (!valid1.test(fileName)) {
				alert("El nombre del Archivo no es Valido Solo puede tener Letras y Numeros");
				this.value = '';
			}

			

	if(fileSize > 10485760){
		alert('El archivo no debe superar los 10MB');
		this.value = '';
		//this.files[0].name = '';
	}else{
		// recuperamos la extensión del archivo
		var ext = fileName.split('.').pop();
		
		// Convertimos en minúscula porque 
		// la extensión del archivo puede estar en mayúscula
		ext = ext.toLowerCase();
    
		// console.log(ext);
		switch (ext) {
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx': 
			case 'ppt':
			case 'pptx':
			case 'pdf':
			case 'zip': 
			case 'rar':break;
			default:
				alert('El archivo no tiene la extensión adecuada');
				this.value = ''; // reset del valor
				//this.files[0].name = '';
		}
	}
});
</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="100%" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="480" colspan="3"><span class="Estilo9"></span>
                  <table width="100%" height="1%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="467" align="left" valign="top"> 
                        <? $menu_lateral=5; include("../menus/menu_lateral.php"); ?></td>
                        <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="389">
                                    
                                    <div align="center">
                                      <!------------------------------------------inicio codigo mensajeria -------------------->
                                      
 <? if (((!$HTTP_POST_VARS) or ($_POST['llave'] != NULL) or ($_POST['userfile'])) and ($enviado!=1) ){ ?>
                                    </div>
						              <form name="recibir" method="POST" action="envioC.php" enctype="multipart/form-data" size="10240">
						                 
										 <div align="center">
						                <table width="100%" height="100%" border="0">
						                  <tr>
						                    <td height="296"><a href="mira.php">Ir a Bandeja de entrada </a><br><br>
											<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
						                      <tr>
						                        <td width="5%"  class="cuadro02"><strong>De : </strong></td>
                                                
													<td width="20%" class="cuadro01"><? echo $usuarioensesion; ?></td>
													<td height="22" valign="top" class="cuadro01"><a href="#" onClick="MM_openBrWindow('v_buscapara.php','','scrollbars=yes,resizable=yes,width=650,height=500')">Buscar Destinatarios</a> </td>
                                                   <!--
													<td width="20%" class="cuadro01" colspan="2"><? //echo $usuarioensesion ?></td> -->
												
												
					                          </tr>
						                      <tr>
						                        <td height="23" class="cuadro02"><strong>Para : </strong></td>
                                                    <td width="246" height="23" class="cuadro01">
                                                      <input name=men_para Type="hidden">
													  -------------&gt;</td>
                                                    <td width="100%" rowspan="4" align="center" valign="top">
                                                                                                           
                                                        
                                                        <? //inicio codigo verusuarioa ?>
                                                        <table width="100%" border="0" align="center">
                                                         <tr align="center">
                                                          <td width="100%"  align="center" valign="top">
                                                        
<table width="100%" border="0" bordercolor="#FF0000" cellpadding="0" cellspacing="0">
  <tr>
   <td>
      											      
      <table width="100%"  border="0" bordercolor="#0099FF" align="center" cellpadding="0" cellspacing="0"> 
          <tr><td class="cuadro02">Nombre</td>
	          <td width="15%" class="cuadro02">Perfil</td>
		      
	      </tr>
      </table>
	  
  </td></tr>
	
  <tr>
  <td valign="top">
	   
	   <div style="overflow:auto; height: 100px"> 
	   <table width="100%"  border="0" bordercolor="#990000"  cellpadding="0" cellspacing="0"> 
 
<?
// verifico si el envío es para algun grupo específico
if (($perfilseleccionado=="no") OR ($perfilseleccionado==NULL)){
	
    
    if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
	    session_register('_DESTINO');
	}
	if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
	    session_register('_PERFILDESTINO');
	}
	if (($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO==0)){ // no tiene valor
	    session_register('_EMAILDESTINO');
	}	

    
	$j = 0; $k = 1;
	//$encontradois;
	
	while ($j < $encontrados){	
	
	    $id_usuario = "id_usuario".$k;
		$id_usuario = $$id_usuario;	
					
		if ($id_usuario!=NULL){	
		   
		      		   
		//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
		  $qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";  
		
		
			$resultrt = @pg_Exec($conn,$qryq)or die("Fallo select");
		 $nuqry = @pg_numrows($resultrt);
			
																	
			if (!$resultrt){
			    echo "<script>alert('Error, el usuario seleccionado no tiene un perfil de acceso creado.  No es posible enviar el mensaje al usuario seleccionado');</script>";
				
				//error('<b>ERROR: No pude acceder a la b. datos 333</b>');
			}else{				
				
				$filas = @pg_fetch_array($resultrt,0);
				$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
				$nomb = $filas['rut_emp'];
				$emaildestino = $filas['email'];
				
				 $qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
				$resultaqw =pg_Exec($connection,$qrysio);
				$numa=pg_numrows($resultaqw);
				
				$rowse = @pg_fetch_array($resultaqw,0);
				$idusuario = $rowse["id_usuario"];
				
				if ($nombre_empleado != NULL){
					$_DESTINO[] = $nomb;
					//$_PERFILDESTINO[] = $perfilseleccionado;
				}	
			}
			
			
			
			if ($nuqry==0){
			   			
				/// si no esta acá puede que sea alumno
				$qryq = "select * from alumno where rut_alumno ".trim($id_usuario);   
				
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);				
																	
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1020</b>');
				}else{
					$filas = @pg_fetch_array($resultrt,0);
					$nombre_empleado=$filas["nombre_alu"]."".$filas["ape_pat"]."".$filas["ape_mat"];
					$nomb = $filas['rut_alumno'];
					$emaildestino = $filas['email'];								
					
					$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
					$resultaqw =pg_Exec($connection,$qrysio);
					$numa=pg_numrows($resultaqw);
					$rowse = pg_fetch_array($resultaqw,0);
					$idusuario = $rowse["id_usuario"];
					if ($nombre_empleado != NULL){
						$_DESTINO[] = "$nomb";	
						$_EMAILDESTINO[] = $emaildestino;					
					}				
				}
			
			}				
			
		}		
		
		$nuqry = 0;	
		
		$j++; $k++;
	}
	
}else{

       
     ////////////////////////////////////////////////////////
     //        PROCESO CON PERFILES SELECCIONADOS         ///
     ////////////////////////////////////////////////////////
	 
		// echo "a";

	/// tengo el perfil debo ver que perfil tiene seleccionado para enviar mensajes:
	 $q1 = "select * from config_mensajeria where id_perfil = '".trim($_PERFIL)."'";
	$r1 = pg_Exec($conn,$q1);
	$n1 = pg_numrows($r1);
	if ($n1==0){
		echo "No hay perfil en session. Sistema detenido";
		exit();
	}else{
		$f1    = pg_fetch_array($r1,0);
		$p_19  = $f1['p_19'];
		$p_25  = $f1['p_25'];
		$p_20  = $f1['p_20'];
		$p_6   = $f1['p_6'];
		$p_21  = $f1['p_21'];
		$p_15  = $f1['p_15'];
		$p_16  = $f1['p_16'];
		$p_17  = $f1['p_17'];
		$p_1   = $f1['p_1'];
		$p_8   = $f1['p_8'];
		$p_14  = $f1['p_14'];
		$p_27  = $f1['p_27'];
	}
	
	
	if ($p_17==1){  // puede enviar a los que estan en la tabla empleado, docente    
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
								
		
		$j = 0; $k = 1;
		
		while ($j < $encontrados){	
			  
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;	
							
				if ($id_usuario!=NULL and $perfilseleccionado == '17'){	
				
// $qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
  $qryq = "select * from empleado where rut_emp  = ".trim($id_usuario)."";   
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
														
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 17</b> '.$qryq);
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								
								 $qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){
										$_DESTINO[] = $nomb;
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
																																	
										?>
										<!-- no despliego nada solo acomulo 
										 
										<tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Docente</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											<input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td> 
                                              <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>									     
											
										</tr> -->
								 <? } 
								}  // Aqui termina el ciclo que ingresa los nuevos usuarios seleccionados
								  
								
								
							}
						}
				}
				$j++; $k++;
		}	 	
		
	}
	
	
	
	
	if ($p_14==1){  // puede enviar a los que estan en la tabla empleado, docente
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if (($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO==0)){ // no tiene valor
		    session_register('_EMAILDESTINO');
		}
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '14'){
					//	$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
					$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";    
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
						    echo "<script>alert('Error, el usuario seleccionado no tiene un perfil de acceso creado.  No es posible enviar el mensaje al usuario seleccionado');</script>";
							exit();
							//error('<b>ERROR: No pude acceder a la b. datos 333</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Administrador Web</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td> 									     
											
										</tr>  -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	if ($p_27==1){  // puede enviar a los que estan en la tabla empleado, administrativo web
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if (($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO==0)){ // no tiene valor
		    session_register('_EMAILDESTINO');
		}
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '27'){
						//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
						$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";    
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 27</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Administrador Web</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td> 									     
											
										</tr>  -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	

	if ($p_25==1){  // puede enviar a los que estan en la tabla empleado, JEFE UTP
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '25'){
						 $qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";   
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 25</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Orientador</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr> -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}

	
	if ($p_20==1){  // puede enviar a los que estan en la tabla empleado, orientador
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '20'){
					//	$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";
					
					 $qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";      
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 20</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Orientador</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr> -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	
	if ($p_6==1){  // puede enviar a los que estan en la tabla empleado, Enfermería
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '6'){
						//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
						$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";
						
						
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 6</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Enfermería</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr> -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	if ($p_21==1){  // puede enviar a los que estan en la tabla empleado, Psicologo
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '21'){
						//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";  
						$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";   
						
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos </b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Psicologo</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr> -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	
	if ($p_19==1){  // puede enviar a los que estan en la tabla empleado, Inspector
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '19'){
						 //$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
						 $qryq = "select * from empleado where rut_emp  = ".trim($id_usuario)."";  
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 777</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										  ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Inspector</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr> -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	
	if ($p_1==1){  // puede enviar a los que estan en la tabla empleado, Director General
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '1'){
						//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";
						$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";      
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 888</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){ 
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Director General</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr>  -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	if ($p_8==1){  // puede enviar a los que estan en la tabla empleado, Profesor Jefe
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO== 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
				$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL and $perfilseleccionado == '8'){
						//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')"; 
						$qryq = "select * from empleado where rut_emp  = '".trim($id_usuario)."'";  
						$resultrt = @pg_Exec($conn,$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 999</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_emp'];
								$emaildestino = $filas['email'];
								$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										  ?> 
									<!--- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Profesor Jefe</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr> -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	if ($p_15==1){  // puede enviar a Apoderados
	
	
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
			$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL && $perfilseleccionado == '15'){
						  $qryq = "select * from apoderado where rut_apo  = '".trim($id_usuario)."'";   
						$resultrt = @pg_Exec($conn,$qryq) or die ("error: ".$qryq);
						$nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 1010</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_apo"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								$nomb = $filas['rut_apo'];
								$emaildestino = $filas['email'];
							  	$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
								$resultaqw =pg_Exec($connection,$qrysio);
								
								$numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
									   <!--	<tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Apoderado</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr>  -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
		 }			 				
	}
	
	
	if ($p_16==1){  // puede enviar a Alumnos
		if(($_DESTINO==NULL) OR ($_DESTINO == 0)){	// no tiene valor
			session_register('_DESTINO');
		}
		if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){	// no tiene valor
			session_register('_PERFILDESTINO');
		}
		if(($_EMAILDESTINO==NULL) OR ($_EMAILDESTINO == 0)){	// no tiene valor
			session_register('_EMAILDESTINO');
		}
		
		
		$j = 0; $k = 1;
		while ($j < $encontrados){	
				$id_usuario = "id_usuario".$k;
			$id_usuario = $$id_usuario;			
							
				if ($id_usuario!=NULL && $perfilseleccionado == '16'){
							//$qryq = "select * from alumno where rut_alumno in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
							
			$qryq = "select * from alumno where rut_alumno  = ".trim($id_usuario);   
					
					
							
						$resultrt = @pg_Exec($conn,$qryq);
					 $nuqry = @pg_numrows($resultrt);
						
									
						if (!$resultrt){
							error('<b>ERROR: No pude acceder a la b. datos 1020</b>');
						}else{
							for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
								$filas = @pg_fetch_array($resultrt,$i);
								$nombre_empleado=$filas["nombre_alu"]."".$filas["ape_pat"]."".$filas["ape_mat"];
								
								$nomb = $filas['rut_alumno'];
								$emaildestino = $filas['email'];
								   $qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb' order by id_usuario desc limit 1";
								$resultaqw =pg_Exec($connection,$qrysio);
								 $numa=pg_numrows($resultaqw);
								for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
									$rowse = pg_fetch_array($resultaqw,$a);
									$idusuario = $rowse["id_usuario"];
									if ($nombre_empleado != NULL){
										$_DESTINO[] = "$nomb";
										$_PERFILDESTINO[] = $perfilseleccionado;
										$_EMAILDESTINO[] = $emaildestino;
										 ?>
										<!-- <tr>
											<td class="cuadro01"><? echo $nombre_empleado; ?></td>
											<td width="15%" class="cuadro01">Alumno</td>
											<td width="5%" class="cuadro01"><div align="right">&nbsp;
											  <input type="hidden" name="usuario[]" value="<? echo $idusuario;?>"></div></td>
											
										</tr>  -->
								 <? } 
								}
							}
						}
				}
				$j++; $k++;
				
				//var_dump($_DESTINO);
		 }			 				
	}
}




//////////////////////////////////////////////////////////////////////////////
////////            PROCESO SIN PERFIL SELECCIONADO            ///////////////
//////////////////////////////////////////////////////////////////////////////


if(($_PERFILDESTINO==NULL) OR ($_PERFILDESTINO == 0)){
	// PROCESO QUE MUESTRA SIN PERFIL SELECCIONADO  //	
	
		
	$ii = 0;
	$total = count($_DESTINO);
	
    while ($ii < $total) {  
	
		$id_usuario      = $_DESTINO[$ii];
		$id_emaildestino = $_EMAILDESTINO[$ii];	
		
		
		// ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
	    if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
	        $_DESTINO[$ii] = " ";
	        $_PERFILDESTINO[$ii] = " ";
			$_EMAILDESTINO[$ii] = " ";
	    }else{	 
	        $id_usuario    = $_DESTINO[$ii];
	        $perfildestino = $_PERFILDESTINO[$ii];
			$id_emaildestino = $_EMAILDESTINO[$ii];
	    }
		
		 
		if ($id_usuario!=NULL){
			//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')"; 
			$qryq = "select * from empleado where rut_emp  = ".trim($id_usuario)."";   
			$resultrt = @pg_Exec($conn,$qryq);
			$nuqry = @pg_numrows($resultrt);
											
			if (!$resultrt){
				error('<b>ERROR: No pude acceder a la b. datos 1030</b>');
			}else{
				
				$filas = @pg_fetch_array($resultrt,0);
				$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
				$nomb = $filas['rut_emp'];
				$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
				$resultaqw =pg_Exec($connection,$qrysio);
				$numa=pg_numrows($resultaqw);
				$rowse = @pg_fetch_array($resultaqw,0);
				$idusuario = $rowse["id_usuario"];
				if ($nombre_empleado != NULL){
				    
					?>														
					<tr>
					<td class="cuadro01"><? echo $nombre_empleado; ?></td>
					<!--<td width="15%" class="cuadro01">Docente</td>-->
					<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
					<input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
					<input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
					<td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td> 									     
					</tr>
			 <? } 
										
				
			}
			
			if ($nuqry==0){			
						
				// consultamos si esta en alumno
				$qryq = "select * from alumno where rut_alumno  = ".trim($id_usuario)."";   
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);				
							
				if (!$resultrt){
					//error('<b>ERROR: No pude acceder a la b. datos 2010</b>');
				}else{
					
					$filas = @pg_fetch_array($resultrt,0);
					$nombre_empleado=$filas["nombre_alu"]."".$filas["ape_pat"]."".$filas["ape_mat"];
					$nomb = $filas['rut_alumno'];
					$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
					$resultaqw =pg_Exec($connection,$qrysio);
					$numa=pg_numrows($resultaqw);
					
					$rowse = @pg_fetch_array($resultaqw,0);
					$idusuario = $rowse["id_usuario"];
					if ($nombre_empleado != NULL){ 
						
						?>
						<tr>
						<td class="cuadro01"><? echo $nombre_empleado; ?></td>
						<!--<td width="15%" class="cuadro01">Alumno 2</td>-->
						<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
						<input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
						<input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
						<td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>							
						</tr>
				 <? }				
				}
			}
			
			$nuqry = 0;				
		}
		$ii++;
	}	
				
	
}else{   


	//  *********************************************************************
	// luego de que llenamos la variable de arreglo de destino mostramos a quien enviar
	// busco en empleado:
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino  = $_EMAILDESTINO[$ii];
		 }
		
		  
		  // EMPLEADO
		 if ($id_usuario!=NULL and $perfildestino == '17'){
				$qryq = "select * from empleado where rut_emp  = ".trim($id_usuario)."";   
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
												
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1030</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ 
								?>														
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Docente</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									<input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									<input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									<td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td> 									     
								</tr>
						 <? } 
						}  // Aqui termina el ciclo que ingresa los nuevos usuarios seleccionados					
					}
				}
		}
		$ii++;
	}
	
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  
		  // ADMINISTRADOR WEB
		  if ($id_usuario!=NULL and $perfildestino == '14'){
				//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
				$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";    
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1040</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){  ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Administrador Web colegio</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td> 
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>									     
									
								</tr> 
						 <? } 
						}
					}
				}
		  }
		  $ii++;
	}
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  
		  // ADMINISTRATIVO WEB
		  if ($id_usuario!=NULL and $perfildestino == '27'){
				//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";  
				$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";     
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1041</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){  ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Administrativo Web</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td> 
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>									     
									
								</tr> 
						 <? } 
						}
					}
				}
		  }
		  $ii++;
	}
	
		  

	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 } 
		  // JEFE DE  UTP
	
		  if ($id_usuario!=NULL and $perfildestino == '25'){
				//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
				$qryq = "select * from empleado where rut_emp  = ".trim($id_usuario)."";   
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1025</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Jefe de UTP</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr>
						 <? } 
						}
					}
				}
		  }
		  $ii++;
	}	  

	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 } 
		  // ORIENTADOR
	
		  if ($id_usuario!=NULL and $perfildestino == '20'){
				//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
				 $qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";   
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1050</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Orientador</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									   <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr>
						 <? } 
						}
					}
				}
		  }
		  $ii++;
	}	  
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }  
		  // ENFERMERIA
	
		  if ($id_usuario!=NULL and $perfildestino == '6'){
//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1060</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Enfermería</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr>
						 <? } 
						}
					}
				}
		  }
		  $ii++;
	}	  
	
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  // PSICOLOGO
	
		   if ($id_usuario!=NULL and $perfildestino == '21'){
//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";
$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";      
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1070</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){  ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Psicologo</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr>
						 <? } 
						}
					}
				}
		   }
		   $ii++;
	}
	
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  
		  // INSPECTOR
		  
		  if ($id_usuario!=NULL and $perfildestino == '19'){
				//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";   
				 $qryq = "select * from empleado where rut_emp  = ".trim($id_usuario)."";  
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1080</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Inspector</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr>
						 <? } 
						}
					}
				}
		  }
		  $ii++;
	}
	
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			  $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  
		  // DIRECTOR GENERAL	  
	
			if ($id_usuario!=NULL and $perfildestino == '1'){
				//$qryq = "select * from empleado where rut_emp in (select cast(nombre_usuario as integer) from usuario where nombre_usuario = '".trim($id_usuario)."')";  
				$qryq = "select * from empleado where rut_emp = ".trim($id_usuario)."";    
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					error('<b>ERROR: No pude acceder a la b. datos 1090</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_emp"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_emp'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ ?>
								<tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Director General</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr>
						 <? } 
						}
					}
				}
			}
			$ii++;
	}		
	
	
	
	$ii = 0;
	$total = count($_DESTINO);
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  
		  // APODERADO	 
	
		   if ($id_usuario!=NULL and $perfildestino == '15'){
				 $qryq = "select * from apoderado where rut_apo  = '".trim($id_usuario)."'";   
				$resultrt = @pg_Exec($conn,$qryq);
				$nuqry = @pg_numrows($resultrt);
				
							
				if (!$resultrt){
					//error('<b>ERROR: No pude acceder a la b. datos 2000</b>');
				}else{
					for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
						$filas = @pg_fetch_array($resultrt,$i);
						$nombre_empleado=$filas["nombre_apo"]."".$filas["ape_pat"]."".$filas["ape_mat"];
						$nomb = $filas['rut_apo'];
						$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb'";
						$resultaqw =pg_Exec($connection,$qrysio);
						$numa=pg_numrows($resultaqw);
						for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
							$rowse = pg_fetch_array($resultaqw,$a);
							$idusuario = $rowse["id_usuario"];
							if ($nombre_empleado != NULL){ ?>
							   <tr>
									<td class="cuadro01"><? echo $nombre_empleado; ?></td>
									<td width="15%" class="cuadro01">Apoderado</td>
									<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?>-->
									  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
									  <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
									  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
									
								</tr> 
						 <? } 
						}
					}
				}
		   }
		   $ii++;
	}	   
	
	
	
	$ii = 0;
	$total = count($_DESTINO);
	
	
	while ($ii < $total) {
		 $id_usuario    = $_DESTINO[$ii];
			 
		 // ANTES DE MOSTRAR VERIFICAMOS SI HAY QUE BORRAR
		 if ($borradestinatario==1 and trim($borrarusuario)==trim($id_usuario)){
			 $_DESTINO[$ii] = " ";
			 $_PERFILDESTINO[$ii] = " ";
			 $_EMAILDESTINO[$ii] = " ";
		 }else{	 
			 $id_usuario    = $_DESTINO[$ii];
			 $perfildestino = $_PERFILDESTINO[$ii];
			 $id_emaildestino = $_EMAILDESTINO[$ii];
		 }
		  
		  
		 if ($id_usuario!=NULL && $perfildestino == '16'){
			 
			 
			 
			$qryq = "select * from alumno where rut_alumno  = '".trim($id_usuario)."'";   
			$resultrt = @pg_Exec($conn,$qryq);
			$nuqry = @pg_numrows($resultrt);
			
						
			if (!$resultrt){
				//error('<b>ERROR: No pude acceder a la b. datos 2010</b>');
			}else{
				for($i=0 ; $i < @pg_numrows($resultrt) ; $i++){
					$filas = @pg_fetch_array($resultrt,$i);
					$nombre_empleado=$filas["nombre_alu"]."".$filas["ape_pat"]."".$filas["ape_mat"];
					$nomb = $filas['rut_alumno'];
					$qrysio = "SELECT * FROM usuario WHERE nombre_usuario ='$nomb' order by nombre_usuario desc limit 1";
					$resultaqw =pg_Exec($connection,$qrysio);
					$numa=pg_numrows($resultaqw);
					for($a=0 ; $a < @pg_numrows($resultaqw) ; $a++){
						$rowse = pg_fetch_array($resultaqw,$a);
						$idusuario = $rowse["id_usuario"];
						if ($nombre_empleado != NULL){ ?>
							<tr>
								<td class="cuadro01"><? echo $nombre_empleado; ?></td>
								<td width="15%" class="cuadro01">Alumno</td>
								<!--<td width="5%" class="cuadro01"><div align="right">&nbsp;<?=$nomb; ?> -->
								  <input type="hidden" name="usuario[]" value="<? echo $nomb;?>">
								   <input type="hidden" name="id_emaildestino[]" value="<? echo $id_emaildestino;?>"></div></td>
								  <td width="5%" class="cuadro01"><div align="right"><a href="envio2.php?borradestinatario=1&borrarusuario=<?=$id_usuario ?>"><img src="images/b_drop.png" border="0"></a></div></td>
								
							</tr>
					 <? } 
					}
				}
			}
		 }
		 $ii++;
	}
	
		
}	 




?>


<!-- FIN PROCESO QUE AGREGÓ PROFESORES PARA QUE EL ELUMNO ENVIE MENSAJES  -->
	</table>
	</div>
	 </td></tr>
	 </table> 	      </td>
                        </tr>
                         </table>  
						 
 <? //fin codigo usuario ?>			   </tr>
						                      <tr>
						                        <td height="23" class="cuadro02"><strong>Asunto :</strong></td>
                                                <td height="23"><input name="men_asunto" type="text" id="men_asunto"></td>
                                              </tr>
						                      <tr>
											
						                        <td height="23" class="cuadro02" col><strong>Archivos Adjunto : </strong> </td>
												
                                                    <td height="23" class="cuadro01">
													<input type="hidden" name="MAX_FILE_SIZE" value="100000000">
                                                    <input type="file" name="archivo" value="Examinar"> (maximo 3MB)</td>
                                              </tr>
											  
											  <tr>
											
		<td height="23" class="cuadro02" col><strong>Con copia a e-mail personal: </strong> </td>
												
                                                    <td height="23">
													<input name="concopia" type="checkbox" value="1"></td>
                                              </tr>


						                      <tr>
						                        <td height="192" class="cuadro02" colspan="3" align="center">
													<strong>Mensaje :</strong>
						                          <div align="center">
						                            <textarea name="mensaje" cols="60" rows="10"></textarea>
					                              </div>
                                                  </label></td>
                                              </tr>
						                      <tr>
						                        <td height="23" colspan="3"><label>
												  <input name="enviado" type="hidden" value="1">
						                          <input name="enviar" type="submit" class="botonXX" id="enviar" value="Enviar">
						                          <!--a href="mira.php">
						                            <span class="Estilo1">  Bandeja de entrada </span></a--></label></td>
                                              </tr>
						                      </table></td>
                                          </tr>
					                    </table>                                        
					                </form>									  
 <? }else{ ?>
						                  
						                  
						                  <!-- determino fecha y hora del sistema --->						               
						                  
						                  <? //$fecha = date('m-d-Y');
$hora = date('h:i:s');
if(pg_dbname($conn)=="Antofagasta" OR pg_dbname($conn)=="coi_final"){
	$fecha = date('m-d-Y');
}else{
		$fecha = date('m-d-Y');
}
 


$dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$di = date('w');
$dis = $di-1;
$dia2 = $dias[$dis];


//$mess = $messs[date('n')];
$e = date('n');
$a = $e-1;
$mess2 = $mes[$a];
$diass2 = date(d);
$an2 = date(Y);
//$fecha = $dia2." , ".$diass2." ".$mess2." ".$an2;
// fin  hora 
?>
						                  
						                  
  <!--------------- recibo mensaje y usuarios e inserto --->
						                  
                                          
<? 
//print_r($_POST); 
//inserto mensaje
$emails = $_POST["id_emaildestino"];									 
$para = $_POST["usuario"];
 "destinatario  -->".$rut_dest=$_POST['rut_dest'];
$men = $_POST["mensaje"];
$asu = $_POST["men_asunto"];
$concopia = $_POST["concopia"];
 $de = $_NOMBREUSUARIO;

if($_FILES['archivo']['size'] > 10485760){
	echo "<script>alert('archivo supero el tamaño permitido')</script>";
	echo "<script>window.location='envio2.php'</script>";
	exit;
}

$archivos =sanear_string($_FILES['archivo']['name']);
 
?><!---- determinamos nombre de usuarios segun perfil y tabla ---><?

//if($perfil_user == 14){

//////////// AQUI GUARDAMOS EL ARCHIVO ADJUNTO SI ES QUE TRAE   //////////////////
if ($archivos != NULL){
    if (!copy($_FILES['archivo']['tmp_name'],"archivos/".$archivos)){ 
         //echo ".Ocurrió algún error al subir el fichero. No pudo guardarse"; 
    }else{ 
         //echo "<span class=cuadro01>El archivo ha sido cargado correctamente.</span><br>"; 
    }
}else{
    $archivos ="";
}	

//$des = 'hola';								

$largo =0;	
$largo=count($para);
								
for ($as=0;$as<$largo;$as++){


$qryqw="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$de;

$resultrtw = pg_Exec($conn,$qryqw);
       
if (!$resultrtw){
	   
        error('<b>ERROR: No pude acceder a la base de datos 2030</b>'.$qryqw);
			 
}else{//1/2
			 
    while ( $filass = pg_fetch_array($resultrtw)){
	   
	   $nombres = $filass["nombre_emp"];
	   $nombres = trim($nombres);
	   
	   $apellido = $filass["ape_pat"];
	   $apellido = trim($apellido);
	   $nombre = $nombres." ".$apellido;
	   
	   $email_de = $filass["email"];
	   
	} 
    
	  
	 if ($nombre == NULL){//2
		 $qrye="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$de;
		 
		 $resultase = @pg_Exec($conn,$qrye);
						 
		  if (!$resultase){
	  
		   error('<b>ERROR :</b>No se puede acceder a la base de datos 2040');
	   
		  }else{//2/2
	  
			  $filae = @pg_fetch_array($resultase); 
		  
			
	  
	      $nombres = $filae["nombre_alu"];
	      $nombres = trim($nombres);
	   
	   $apellido = $filae["ape_pat"];
	   $apellido = trim($apellido);
	   $nombre = $nombres." ".$apellido;
	   
	   $email_de = $filae["email"];
	  
		   }//2/2
	  }//2
	  
	  
	  
	  if ($_PERFIL == 15){//2
	      $nombreusuario=$_NOMBREUSUARIO;
	  
	      $qrynueva="SELECT * FROM APODERADO WHERE RUT_APO='".$nombreusuario."'";
		  $resultnueva = @pg_Exec($conn,$qrynueva);
		  if (!$resultnueva){
			  error('<b>ERROR :</b>No se puede acceder a la base de datos 2050');
		  }else{
			  $filanueva = @pg_fetch_array($resultnueva,0);	
			  		
			  //Nombre de quien inició la session
			  $nombre = $filanueva["nombre_apo"];
			  $nombre.= $filanueva["ape_pat"];
			  $nombre.= $filanueva["ape_mat"];
			  
			  $email_de = $filanueva["email"];
		      
		  }; 
		 
		 
		 /*$qrye="SELECT * FROM APODERADO WHERE RUT_APO=".$de;
		 
		 $resultase = @pg_Exec($conn,$qrye);
						 
		  if (!$resultase){
	  
		   error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
	   
		  }else{//2/2
	  
			  $filae = @pg_fetch_array($resultase); 
		  
			
	  
	      $nombres = $filae["nombre_apo"];
	      $nombres = trim($nombres);
	   
	   $apellido = $filae["ape_pat"];
	   $apellido = trim($apellido);
	   $nombre = $nombres." ".$apellido; */
	   
	  
	  
		  //2/2
	  }//2
	  
	  
	  
//		die($nombre);
 
			 
}	//1/2		 

//}//1
?><!-------------------------------------------------------------------------------------------------------><?

?><!--------------------------------------------------------------------------------------------------------><?

	 "User2------->".$paras = $para[$as];
    $email = $emails[$as];
	/*function fEs2En($txt){
	$x= substr($txt,3,2); // MES
	$x.="-";
	$x.=substr($txt,0,2); //DIA
	$x.="-";
	$x.=substr($txt,6,4); // AÑO
	return $x;
	}*/
	//echo "---$as---------";
			
	
	
	 $qrys="INSERT INTO mensajero
		(user1men,user2men,mensaje,asunto,fecha,archivos,lee,id_usuario,hora) VALUES 
		('".$nombre."','".$paras."','".$men."','".$asu."','".$fecha."','".$archivos."','0','".$rut_usuario2."','".$hora."')";
	echo "<br><br>";
	pg_Exec($conn, $qrys) or die ("INSERT FALLO2222: ".$qrys);
	

    /// aqui se cosntruye el mensaje para enviar por e-mail
	/// para enviar e-mail siempre que sea ADM total
	/// copio el archivo en el servidor

			  /// copio texto sacado de san google ///
			 if ($archivos != NULL){	
				 $file = fopen("archivos/$archivos", "r");
				 $contenido = fread($file, filesize("archivos/$archivos"));
				 $encoded_attach = chunk_split(base64_encode($contenido));
				 fclose($file);
			 }	 
		
			 $asunto= "$asu";
			 $email_a= "$email";
			 
				
			 $cabeceras = "From: $nombre <$email_de>\n";
			 $cabeceras .= "Reply-To: $email_a;$email_de \n";
			 $cabeceras .= "MIME-version: 1.0\n";
			 $cabeceras .= "Content-type: multipart/mixed; ";
			 $cabeceras .= "boundary=\"Message-Boundary\"\n";
			 $cabeceras .= "Content-transfer-encoding: 7BIT\n";
			 
			 if ($concopia==1){
			 	 //direcciones que recibián copia
             $cabeceras .= "Cc: $email_de\r\n";
             	    }
			 
			   
             //direcciones que recibirán copia oculta
             //$cabeceras .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 
			 
			 
			 if ($archivos != NULL){	
			
			      $cabeceras .= "X-attachments: $archivos";
			 }
			 
			 $body_top = "--Message-Boundary\n";
			 $body_top .= "Content-type: text/html; charset=US-ASCII\n";
			 $body_top .= "Content-transfer-encoding: 7BIT\n";
			 $body_top .= "Content-description: Mail message body\n\n";
		
			 $cuerpo = $body_top.$men;
		
			 if ($archivos != NULL){	
				 $nombref="$archivos";
				 $cuerpo .= "\n\n--Message-Boundary\n";
				 $cuerpo .= "Content-type: Binary; name=\"$archivos\"\n";
				 $cuerpo .= "Content-Transfer-Encoding: BASE64\n";
				 $cuerpo .= "Content-disposition: attachment; filename=\"$archivos\"\n\n";
				 $cuerpo .= "$encoded_attach\n";
				 $cuerpo .= "--Message-Boundary--\n";	
			
			}
			

			 		
			 /// envío e-mail		
			 mail($email,$asu,$cuerpo,$cabeceras);
		 
		 
		 

 }										

     $carpeta = 'archivos/'.$archivos;
	 
	 
/*	    echo $email_de."<br>";
		echo $email;*/
		
		 ?>
					 	
		 <span class="cuadro01"><br>Su mensaje ha sido enviado.<br><br>
		 <a href="../mensajeria/mira.php" target="_self" class="Estilo3">Bandeja de entrada</a></span>
											
											
										<?
										// MATO LAS SECIONES DE DESTINATARIOS
										
										@session_destroy('_DESTINO');
										@session_destroy('_PERFILDESTINO');
										@session_unregister('_DESTINO');
										@session_unregister('_PERFILDESTINO');
										@session_unregister('_EMAILDESTINO');
										
										?>	
											
											
  <?  }//fin else ?>
  
						                  <!------------------------------------------- fin codigo mensajeria  ------------------------------>
				                    </td>
                                </tr>
                              </table></td>
                          </tr>
                          </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="12" colspan="2" class="piepagina"> <?
						 include("../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  </td>
                    </tr>
                </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
<?
function vueta_cargo($n_cargo){
	$car[]='INDETERMINADO';
	$car[]='Director(a)';
	$car[]='Jefe UTP';
	$car[]='Enfermeria';
	$car[]='Contador';
	$car[]='Docente';
	$car[]='Sub-Director';
	$car[]='Inspector General';
	$car[]='Titulacion';
	$car[]='Curriculista';
	$car[]='Evaluador';
	$car[]='Orientador(a)';
	$car[]='Sicopedagogo(a)';
	$car[]='Sicologo(a)';
	$car[]='Inspector(a)';
	$car[]='Auxiliar';
	$car[]='Coordinación CRA';
	$car[]='Coordinación Pastoral';
	$car[]='Coordinación ACLE';
	$car[]='Secretaria';
	$car[]='Tesorero(a)';
	$car[]='Asistente Social';
	$car[]='Coordinación Mantenimiento';
	return $car[$n_cargo];
}
?>
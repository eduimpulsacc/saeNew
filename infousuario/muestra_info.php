<?
require('../util/header.inc');
include('../util/rpc.php3');
$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso          =$_CURSO;
$_POSP = 2;
$_bot = 0;
$_MDINAMICO = 1;
$op = $op;

$frmModo=="modificar";

$perfil = $_PERFIL; 
$nombreusuario=$_NOMBREUSUARIO;

trim($nombreusuario);
	
$usuarioensesion = $_USUARIOENSESION;
##Selecciono los datos para mostrar en el Diario Mural.


if (isset($actualizar) and ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19)){
   $tiempo = time();
   $digitos = substr($tiempo,6,3);
   // SUBIR FOTO AL SERVIDOR
   $filep = $_FILES['file']['size'];
   if ($filep != 0){
      $filen = "$nombreusuario$digitos.jpg";
	  	  
	  if (!copy($_FILES['file']['tmp_name'], "images/$filen")){
	      echo "el archivo no ha sido copiado";
	  }else{
	      // actualizamos en la base de datos
		  $q3 = "update empleado set nom_foto2 = '$filen' where rut_emp = '$nombreusuario'";
		  $r3 = pg_Exec($conn,$q3);
	  }	    
       
   }else{
      
   }
   
   // ACTUALIZAMOS LA INFORMACION PERSONAL
   $q2 = "update empleado set nombre_emp = '$nombre_emp', ape_pat = '$ape_pat', ape_mat = '$ape_mat', telefono = '$telefono',
   email = '$email',   telefono2 = '$telefono2',
   telefono3 = '$telefono3'  where rut_emp = '$nombreusuario'";
   $r2 = pg_Exec($conn,$q2);
     
   	  
}


// ACTUALIZACION DE DATOS DEL ALUMNO
if (isset($actualizar4) and $_PERFIL == 16){
   $tiempo = time();
   $digitos = substr($tiempo,6,3);
   // SUBIR FOTO AL SERVIDOR
   $filep = $_FILES['file']['size'];
   if ($filep != 0){
      $filen = "$nombreusuario$digitos.jpg";
	  	  
	  if (!copy($_FILES['file']['tmp_name'], "images/$filen")){
	      echo "el archivo no ha sido copiado";
	  }else{
	      // actualizamos en la base de datos
		  $q3 = "update alumno set nom_foto = '$filen' where rut_alumno = '$nombreusuario'";
		  $r3 = pg_Exec($conn,$q3);
	  }	    
       
   }else{
      
   }
   
   // ACTUALIZAMOS LA INFORMACION DEL ALUMNO
   $q2 = "update alumno set calle = '$calle', email = '$email',   nro = '$nro', depto = '$depto', block = '$block', villa = '$villa', telefono = '$telefono' where rut_alumno = '$nombreusuario'";
   $r2 = pg_Exec($conn,$q2);
     
   	  
}


// ACTUALIZACION DE DATOS DEL APODERADO
if (isset($actualizar5) and $_PERFIL == 15){
   $tiempo = time();
   $digitos = substr($tiempo,6,3);
   // SUBIR FOTO AL SERVIDOR
   $filep = $_FILES['file']['size'];
   if ($filep != 0){
      $filen = "$nombreusuario$digitos.jpg";
	  	  
	  if (!copy($_FILES['file']['tmp_name'], "images/$filen")){
	      echo "el archivo no ha sido copiado";
	  }else{
	      // actualizamos en la base de datos
		  $q3 = "update apoderado set nom_foto = '$filen' where rut_apo = '$nombreusuario'";
		  $r3 = pg_Exec($conn,$q3);
	  }	    
       
   }else{
      
   }
   
   // ACTUALIZAMOS LA INFORMACION DEL APODERADO
   $q2 = "update apoderado set calle = '$calle', email = '$email',   nro = '$nro', depto = '$depto', block = '$block', villa = '$villa', telefono = '$telefono' where rut_apo = '$nombreusuario'";
   $r2 = pg_Exec($conn,$q2);
     
   	  
}


if (isset($actualizar2) and ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19)){
      
   // ACTUALIZAMOS LA INFORMACION PERSONAL
   $q2 = "update empleado set calle = '$calle', nro = '$nro', depto = '$depto', block = '$block',
   villa = '$villa'  where rut_emp = '$nombreusuario'";
   $r2 = pg_Exec($conn,$q2);
     
   	  
}

if (isset($actualizar3) and ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19)){
      
   // ACTUALIZAMOS LA INFORMACION PERSONAL
   $q2 = "update empleado set titulo = '$titulo', estudios = '$estudios', anos_exp = '$anos_exp', idiomas = '$idiomas' where rut_emp = '$nombreusuario'";
   $r2 = pg_Exec($conn,$q2);
     
   	  
}   	  	  
 





if ($_PERFIL == 19 AND $ano == NULL){
   $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
   $result = @pg_Exec($conn,$qry);
   $fila = @pg_fetch_array($result,0);	
   $_ANO=$fila["id_ano"];
   $ano = $_ANO;
} 


if ($_PERFIL == 2 AND $ano == NULL){
   $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
   $result = @pg_Exec($conn,$qry);
   $fila = @pg_fetch_array($result,0);	
   $_ANO=$fila["id_ano"];
   $ano = $_ANO;
} 


if ($_PERFIL == 17 AND $ano == NULL){
   $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
   $result = @pg_Exec($conn,$qry);
   $fila = @pg_fetch_array($result,0);	
   $_ANO=$fila["id_ano"];
   $ano = $_ANO;
} 
if ($_PERFIL == 19){	
	$_MDINAMICO = $menu;
}else{
	$_MDINAMICO = 0;
}

// AQUI TOMO LOS DATOS DE LA INFORMACIÓN PERSONAL
if (($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19) and $op == 1 or (isset($actualizar))){
   $q1 = "select * from empleado where rut_emp = '$nombreusuario'";
   $r1 = pg_Exec($conn,$q1);
   $n1 = pg_numrows($r1);
   if ($n1 != 0){
      $f1 = pg_fetch_array($r1,0);
      $rut_emp = trim($f1['rut_emp']);
	  $dig = trim($f1['dig_rut']);
	  $nombre_emp = trim($f1['nombre_emp']);
	  $ape_pat = trim($f1['ape_pat']);
	  $ape_mat = trim($f1['ape_mat']);
	  $telefono = trim($f1['telefono']);
	  //$sexo = trim($f1['sexo']);
	  $email = trim($f1['email']);
	  //$estado_civil = trim($f1['estado_civil']);
	  $foto = trim($f1['nom_foto2']);
	  //$nacionalidad = trim($f1['nacionalidad']);
	  $telefono2 = trim($f1['telefono2']);
	  $telefono3 = trim($f1['telefono3']);
	  //$atencion = trim($f1['atencion']);
   }
}

if (($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19) and $op == 2 or (isset($actualizar2))){
   $q1 = "select * from empleado where rut_emp = '$nombreusuario'";
   $r1 = pg_Exec($conn,$q1);
   $n1 = pg_numrows($r1);
   if ($n1 != 0){
      $f1 = pg_fetch_array($r1,0);
      $calle = trim($f1['calle']);
	  $nro = trim($f1['nro']);
	  $depto = trim($f1['depto']);
	  $block = trim($f1['block']);
	  $villa = trim($f1['villa']);
	  $region = trim($f1['region']);
	  $ciudad = trim($f1['ciudad']);
	  $comuna = trim($f1['comuna']);
	  
   }
}


if (($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19) and $op == 3 or (isset($actualizar3))){
   $q1 = "select * from empleado where rut_emp = '$nombreusuario'";
   $r1 = pg_Exec($conn,$q1);
   $n1 = pg_numrows($r1);
   if ($n1 != 0){
      $f1 = pg_fetch_array($r1,0);
      $titulo = trim($f1['titulo']);
	  $estudios = trim($f1['estudios']);
	  $anos_exp = trim($f1['anos_exp']);
	  $idiomas = trim($f1['idiomas']);  
   }
}


if ($_PERFIL == 16){
   $q1 = "select * from alumno where rut_alumno = '$nombreusuario'";
   $r1 = pg_Exec($conn,$q1);
   $n1 = pg_numrows($r1);
   if ($n1 != 0){
      $f1 = pg_fetch_array($r1,0);
      $rut_alumno = trim($f1['rut_alumno']);
	  $dig = trim($f1['dig_rut']);
	  $nombre_alu = trim($f1['nombre_alu']);
	  $ape_pat = trim($f1['ape_pat']);
	  $ape_mat = trim($f1['ape_mat']);
	  $calle = trim($f1['calle']);
	  $nro = trim($f1['nro']);
	  $depto = trim($f1['depto']);
	  $block = trim($f1['block']);
	  $villa = trim($f1['villa']);
	  $region = trim($f1['region']);
	  $ciudad = trim($f1['ciudad']);
	  $comuna = trim($f1['comuna']);
	  $telefono = trim($f1['telefono']);
	  $email = trim($f1['email']);  
	  $foto = trim($f1['nom_foto']);
   }
}


if ($_PERFIL == 15){
   $q1 = "select * from apoderado where rut_apo = '$nombreusuario'";
   $r1 = pg_Exec($conn,$q1);
   $n1 = pg_numrows($r1);
   if ($n1 != 0){
      $f1 = pg_fetch_array($r1,0);
      $rut_apo = trim($f1['rut_apo']);
	  $dig = trim($f1['dig_rut']);
	  $nombre_apo = trim($f1['nombre_apo']);
	  $ape_pat = trim($f1['ape_pat']);
	  $ape_mat = trim($f1['ape_mat']);
	  $calle = trim($f1['calle']);
	  $nro = trim($f1['nro']);
	  $depto = trim($f1['depto']);
	  $block = trim($f1['block']);
	  $villa = trim($f1['villa']);
	  $region = trim($f1['region']);
	  $ciudad = trim($f1['ciudad']);
	  $comuna = trim($f1['comuna']);
	  $telefono = trim($f1['telefono']);
	  $email = trim($f1['email']);  
	  $foto = trim($f1['nom_foto']);
   }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

		
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
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
                      <td width="190" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
						include("../menus/menu_lateral.php");
						?>                    </td>
                      <td width="100%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="left" valign="top"> 
                                  <td height="162" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="tableindex"><div align="center">INFORMACI&Oacute;N</div></td>
                                    </tr>
                                  </table>
                                  <br>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <form name="f1" method="post" action="muestra_info.php" enctype="multipart/form-data">
                                       									
									   <?
									   if ($_PERFIL == 15){
									     ?>
							
									    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FF9966">
                                          <tr>
                                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                <tr>
                                                  <td width="20%" class="cuadro02">RUT</td>
                                                  <td width="50%" class="cuadro01">
                                                    <?=$rut_apo ?>
                                                    -
                                                    <?=$dig ?>
                                                  </td>
                                                  <td rowspan="14" valign="top"><div align="center">Fotograf&iacute;a<br>
                                                          <img src="images/<?=$foto ?>" width="150" height="200"><br>
                                                          <!--<label>
                                                          <input name="file" type="file" class="Estilo12" id="file">
                                                          </label>-->
                                                  </div></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">NOMBRE</td>
                                                  <td class="cuadro01"><label>
                                                    <!--<input name="nombre_apo" type="text" id="nombre_apo" value="<?=$nombre_apo ?>" size="35">-->
													<?=$nombre_apo ?>
                                                  </label></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">APELLIDO PATERNO </td>
                                                  <td class="cuadro01">
												  <!--<input name="ape_pat" type="text" id="ape_pat" value="<?=$ape_pat ?>" size="35">-->
												  <?=$ape_pat ?>
												  </td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">APELLIDO MATERNO </td>
												  
                                                 <td class="cuadro01">
												  <!--<input name="ape_mat" type="text" id="ape_mat" value="<?=$ape_mat ?>" size="35">-->
												  <?=$ape_mat ?>
												  </td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">CALLE</td>
                                                  <td><input name="calle" type="text" id="calle" value="<?=$calle ?>" size="35"></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">NRO</td>
                                                  <td><input name="nro" type="text" id="nro" value="<?=$nro ?>" size="10"></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">DEPARTAMENTO</td>
                                                  <td><input name="depto" type="text" id="depto" value="<?=$depto ?>" size="35"></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">BLOCK</td>
                                                  <td><input name="block" type="text" id="block" value="<?=$block ?>" size="35"></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">VILLA</td>
                                                  <td><input name="villa" type="text" id="villa" value="<?=$villa ?>" size="35"></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td class="cuadro02">TELEFONO</td>
                                                  <td><input name="telefono" type="text" id="telefono" value="<?=$telefono ?>" size="35"></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro02">E-MAIL</td>
                                                  <td><input name="email" type="text" id="email" value="<?=$email ?>" size="35"></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="3"><div align="center">
                                                      <label>
                                                      <input name="actualizar5" class="botonXX" type="submit" id="actualizar5" value="ACTUALIZAR INFORMACION">
                                                      </label>
                                                  </div></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                        </table>
										
										<?
										} ?>
									    
										
										
									    <?
										if ($_PERFIL == 16){
										   ?>	
										<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FF9966">
                                          
                                          <tr>
                                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                              <tr>
                                                <td width="20%" class="cuadro02">RUT</td>
                                                <td width="50%"  class="cuadro01"><?=$rut_alumno ?>-<?=$dig ?></td>
                                                <td rowspan="14" valign="top"><div align="center">Fotograf&iacute;a<br>
                                                    <img src="images/<?=$foto ?>" width="150" height="200"><br>
                                                 <!--   <label>
                                                    <input name="file" type="file" class="Estilo12" id="file">
                                                    </label>-->
</div></td>
                                              </tr>
                                              <tr>
                                                <td class="cuadro02">NOMBRE</td>
                                                <td class="cuadro01"><label>
                                                  <!--<input name="nombre_alu" type="text" id="nombre_alu" value="<?=$nombre_alu ?>" size="35">-->
													<?=$nombre_alu ?>												  
                                                </label></td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">APELLIDO PATERNO </td>
                                                <td class="cuadro01">
												<!--<input name="ape_pat" type="text" id="ape_pat" value="<?=$ape_pat ?>" size="35">-->
													<?=$ape_pat ?>												
												</td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">APELLIDO MATERNO </td>
                                                <td class="cuadro01">
												<!--<input name="ape_mat" type="text" id="ape_mat" value="<?=$ape_mat ?>" size="35">-->
													<?=$ape_mat ?>												
												</td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">CALLE</td>
                                                <td><input name="calle" type="text" id="calle" value="<?=$calle ?>" size="35"></td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">NRO</td>
                                                <td><input name="nro" type="text" id="nro" value="<?=$nro ?>" size="10"></td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">DEPARTAMENTO</td>
                                                <td><input name="depto" type="text" id="depto" value="<?=$depto ?>" size="35"></td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">BLOCK</td>
                                                <td><input name="block" type="text" id="block" value="<?=$block ?>" size="35"></td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">VILLA</td>
                                                <td><input name="villa" type="text" id="villa" value="<?=$villa ?>" size="35"></td>
                                                </tr>
                                              
                                              <tr>
                                                <td class="cuadro02">TELEFONO</td>
                                                <td><input name="telefono" type="text" id="telefono" value="<?=$telefono ?>" size="35"></td>
                                                </tr>
                                              <tr>
                                                <td class="cuadro02">E-MAIL</td>
                                                <td><input name="email" type="text" id="email" value="<?=$email ?>" size="35"></td>
                                                </tr>
                                              <tr>
                                                <td colspan="3"><div align="center">
                                                  <label>
                                                  <input name="actualizar4" class="botonXX" type="submit" id="actualizar4" value="ACTUALIZAR INFORMACION">
                                                  </label>
</div></td>
                                                </tr>
                                              
                                            </table></td>
                                          </tr>
                                        </table>
										<?
										}
										
										
										if ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19){
										   ?>                                     
                                        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FF9966">
                                        <tr>
                                          <td bgcolor="#FFFFFF"><table border="0" cellspacing="1" cellpadding="3">
                                            <tr>
                                              <td width="100" bgcolor="#999999" class="tablatit2-1"><div align="center"><a href="muestra_info.php?op=1">PERSONAL</a></div></td>
                                              <td width="100" bgcolor="#999999" class="tablatit2-1" onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#999999'><div align="center"><a href="muestra_info.php?op=2">DIRECCI&Oacute;N</a></div></td>
                                              <td width="100" bgcolor="#999999" class="tablatit2-1" onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#999999'><div align="center"><a href="muestra_info.php?op=3">ACADEMICO</a></div></td>
                                            </tr>
                                          </table></td>
                                          </tr>
                                        <tr>
                                          <td bgcolor="#FFFFFF">
										  
										  
										 <?
										 if ($op == 1 OR isset($actualizar) and ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19)){
										    ?> 
										  
										  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                              <td width="20%" class="cuadro02">RUT</td>
                                              <td class="cuadro01"><label><?=$rut_emp ?>-<?=$dig ?></label></td>
                                              <td rowspan="8" valign="top"><div align="center">Fotograf&iacute;a<br>
                                                  <table width="150" height="200" border="1" cellpadding="0" cellspacing="0">
                                                  <tr>
                                                    <td><div align="center"><img src="images/<?=$foto ?>" width="150" height="200"></div></td>
                                                  </tr>
                                                </table>
                                                  <br>
                                                  <label>
                                                  <input name="file" type="file" class="Estilo12">
                                                  </label>
                                                  <label></label>
                                              </div></td>
                                            </tr>
                                            <tr>
                                              <td>NOMBRE</td>
                                              <td class="cuadro01">
											 <!-- <input name="nombre_emp" type="text" id="nombre_emp" value="<?=$nombre_emp ?>" size="40">-->
												<?=$nombre_emp ?>											 
											  </td>
                                            </tr>
                                            <tr>
                                              <td>APELLIDO PATERNO </td>
                                              <td class="cuadro01">
											  <!--<input name="ape_pat" type="text" id="ape_pat" value="<?=$ape_pat ?>" size="40">-->
												<?=$ape_pat ?>											  
											  </td>
                                            </tr>
                                            <tr>
                                              <td>APELLIDO MATERNO </td>
                                              <td class="cuadro01">
											  <!--<input name="ape_mat" type="text" id="ape_mat" value="<?=$ape_mat ?>" size="40">-->
												<?=$ape_mat ?>											  
											  </td>
                                            </tr>
                                            <tr>
                                              <td>TELEFONO</td>
                                              <td><input name="telefono" type="text" id="telefono" value="<?=$telefono ?>" size="40"></td>
                                            </tr>
											<tr>
                                              <td>TELEFONO 2 </td>
                                              <td><input name="telefono2" type="text" id="telefono2" value="<?=$telefono2 ?>" size="40"></td>
                                            </tr>
                                            <tr>
                                              <td>TELEFONO 3 </td>
                                              <td><input name="telefono3" type="text" id="telefono3" value="<?=$telefono3 ?>" size="40"></td>
                                            </tr>
                                           
                                            <tr>
                                              <td>E-MAIL</td>
                                              <td><input name="email" type="text" id="email" value="<?=$email ?>" size="40"></td>
                                            </tr>
                                           
                                            <tr>
                                              <td colspan="3"><div align="center">
                                                  <label> <br>
                                                  <br>
                                                  <br>
                                                  <input name="actualizar" class="botonXX" type="submit" class="BotonXX" id="actualizar" value="ACTUALIZAR INFORMACI&Oacute;N">
                                                  </label>
                                              </div></td>
                                            </tr>
                                          </table>
										      <?
										  }
										  ?>	  
										  								  
										  
										  <?
										  if ($op == 2 OR isset($actualizar2) and ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19)){
										      ?>
										  
										  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                              <td width="20%">CALLE</td>
                                              <td><label>
                                                <input name="calle" type="text" id="calle" value="<?=$calle ?>" size="50">
                                              </label></td>
                                            </tr>
                                            <tr>
                                              <td>NRO</td>
                                              <td><input name="nro" type="text" id="nro" value="<?=$nro ?>" size="10"></td>
                                            </tr>
                                            <tr>
                                              <td>DEPARTAMENTO</td>
                                              <td><input name="depto" type="text" id="depto" value="<?=$depto ?>" size="10"></td>
                                            </tr>
                                            <tr>
                                              <td>BLOCK</td>
                                              <td><input name="block" type="text" id="block" value="<?=$block ?>" size="10"></td>
                                            </tr>
                                            <tr>
                                              <td>VILLA</td>
                                              <td><input name="villa" type="text" id="villa" value="<?=$villa ?>" size="50"></td>
                                            </tr>
											<!-- select dinamicos -->
											<tr>
											  <td colspan="2">
											<TABLE width=100% height=100% bgcolor=White BORDER=0  CELLSPACING=0 CELLPADDING=0>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>REGION</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
			<?php if($frmModo=="modificar"){ ?>
				<!--INPUT type="text" name=txtREG size=20 value="<?php echo $fila['region']?>"-->


<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			if($filaREG['cod_reg']==$fila['region'])
				echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\" selected>".trim($filaREG['nom_reg'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

			<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>PROVINCIA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
										$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										imp($filaPRO['nom_pro']);
																						};
																					?>
<?php if($frmModo=="modificar"){ ?>
	<!--INPUT type="text" name=txtCIU size=20 value=<?php echo $fila['ciudad']?>-->

<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			if($filaPRO['cor_pro']==$fila['ciudad'])
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\" selected>".trim($filaPRO['nom_pro'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>
<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>COMUNA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM  method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			imp($filaCOM['nom_com']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
											<!--INPUT type="text" name=txtCOM size=20 value=<?php echo $fila['comuna']?>-->

<FORM method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			if($filaCOM['cor_com']==$fila['comuna'])
				echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" selected>".trim($filaCOM['nom_com'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>
																				<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																</TR>
															</TABLE>
											     </td>
												 </tr>
											
											<!-- fin select dinamicos -->
											
											
											
											
											<tr>
                                              <td>COMUNA</td>
                                              <td><input name="comuna" type="text" id="comuna" value="<?=$comuna ?>" size="50"></td>
                                            </tr>
                                            <tr>
                                              <td>CIUDAD</td>
                                              <td><input name="ciudad" type="text" id="ciudad" value="<?=$ciudad ?>" size="50"></td>
                                            </tr>
                                            <tr>
                                              <td>REGION</td>
                                              <td><input name="region" type="text" id="region" value="<?=$region ?>" size="50"></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2"><div align="center"><br>
                                                  <input name="actualizar2" type="submit" id="actualizar2" value="ACTUALIZAR INFORMACION" class="BotonXX">
                                              </div>
                                                <label></label></td>
                                              </tr>
                                          </table>
										       <?
										}
										?>	   
										  
										  <?
										  if ($op == 3 OR isset($actualizar3) and ($_PERFIL == 17 or $_PERFIL == 2 or $_PERFIL == 14 or $_PERFIL == 19)){
										      ?>
										      <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                 <tr>
                                                   <td width="20%">TITULO</td>
                                                   <td><label>
                                                     <input name="titulo" type="text" id="titulo" value="<?=$titulo ?>" size="50">
                                                   </label></td>
                                                 </tr>
                                                 <tr>
                                                   <td>ESTUDIOS</td>
                                                   <td><textarea name="estudios" cols="45" rows="5" id="estudios"><?=trim($estudios); ?>
                                                   </textarea></td>
                                                 </tr>
                                                 <tr>
                                                   <td>A&Ntilde;OS DE EXPERIENCIA </td>
                                                   <td><input name="anos_exp" type="text" id="anos_exp" value="<?=$anos_exp ?>" size="2" maxlength="2"> </td>
                                                 </tr>
                                                 <tr>
                                                   <td>IDIOMAS</td>
                                                   <td><input name="idiomas" type="text" id="idiomas" value="<?=$idiomas ?>" size="50"></td>
                                                 </tr>
                                                 <tr>
                                                   <td colspan="2"><div align="center">
                                                     <label>
                                                     <input name="actualizar3" class="botonXX" type="submit" id="actualizar3" value="ACTUALIZAR INFORMACION" class="BotonXX">
                                                     </label>
</div></td>
                                                   </tr>
                                               </table>
											   <?
											   }
											   ?>
											   
											   
											   
											   </td>
                                        </tr>
                                      </table>
									     <?
										 }
										 ?>								  
									  </form>
									  </td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

<?
require('../util/header.inc');

$institucion	=$_INSTIT;
$usuarioensesion = $_USUARIOENSESION;
$perfil_user = $_PERFIL;
$idusuario = $_USUARIO;

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

// consulto si existe la institucion en la tabla config_mensajeria //
$q1 = "select * from config_mensajeria where rdb = '".trim($institucion)."'";
$r1 = @pg_Exec($conn,$q1);
$n1 = @pg_numrows($r1);

if ($n1==0){
     // insertamos registros para la nueva institución
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('19','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);

	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('25','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);

	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('20','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('6','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('21','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('15','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('16','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('17','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('1','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('8','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('14','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('27','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
	 
	 /// fin de insertar
}	 

////// especial para agregar perfil 27 a las instituciones que no lo tienen  /////////
// consulto si existe la institucion en la tabla config_mensajeria //
$q2 = "select * from config_mensajeria where rdb = '".trim($institucion)."' and p_27='0' and est = '1'";
$r2 = @pg_Exec($conn,$q2);
$n2 = @pg_numrows($r2);

if ($n2==0){
     $q2 = "insert into config_mensajeria (id_perfil,p_19,p_25,p_20,p_6,p_21,p_15,p_16,p_17,p_1,p_8,p_14,p_27,est,rdb)
	 values ('27','0','0','0','0','0','0','0','0','0','0','0','0','1','".trim($institucion)."')";
	 $r2 = pg_Exec($conn,$q2);
}


	
$idele = $_GET['idel'];
function vacio ($x)
{
   
   $tipo = gettype($x);
    
   if ($tipo=="NULL"){
      $x = 0;	  	
   } 
   return $x;
}


if ($perfilesdisponibles2!=NULL){
    $perfilesdisponibles = $perfilesdisponibles2;
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function enviapag(form){
	form.submit(true);	
}

//-->
</script>
<style type="text/css">
<!--
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #666666; }
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=5;  include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                          <td height="40" class="tableindex">CONFIGURACI&Oacute;N DE MENSAJER&Iacute;A </td>
                        </tr>
                        <tr>
                          <td><br>
                          						    
						  <form name="form1" method="post" action="configuracion.php">
						  	
						     <? if (!isset($ir)){ ?>
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td width="30%"><div align="right" class="Estilo7">CONFIGURAR PERFIL </div></td>
									  <td width="40%"><label>
										<div align="center">
										  <select name="perfilesdisponibles" id="perfilesdisponibles" onChange="enviapag(this.form);">
											<option value="14" <? if ($perfilesdisponibles==14){ ?> selected="selected" <? } ?>>ADMINSITRADOR WEB COLEGIO</option>
											<option value="27" <? if ($perfilesdisponibles==27){ ?> selected="selected" <? } ?>>ADMINISTRATIVO WEB</option>
											<option value="1" <? if ($perfilesdisponibles==1){ ?> selected="selected" <? } ?>>DIRECTOR GENERAL</option>
											<option value="17" <? if ($perfilesdisponibles==17){ ?> selected="selected" <? } ?>>DOCENTE</option>
											<option value="19" <? if ($perfilesdisponibles==19){ ?> selected="selected" <? } ?>>INSPECTOR</option>
											<option value="21" <? if ($perfilesdisponibles==21){ ?> selected="selected" <? } ?>>PSICOLOGO</option>
											<option value="25" <? if ($perfilesdisponibles==25){ ?> selected="selected" <? } ?>>JEFE DE UTP</option>
											<option value="20" <? if ($perfilesdisponibles==20){ ?> selected="selected" <? } ?>>ORIENTADOR</option>
											<option value="6" <? if ($perfilesdisponibles==6){ ?> selected="selected" <? } ?>>ENFERMERIA</option>
											<option value="15" <? if ($perfilesdisponibles==15){ ?> selected="selected" <? } ?>>APODERADO</option>
											<option value="16" <? if ($perfilesdisponibles==16){ ?> selected="selected" <? } ?>>ALUMNO</option>
											<option value="2" <? if ($perfilesdisponibles==2){ ?> selected="selected" <? } ?>>DIRECTOR(A) ACADEMICO</option>
											<option value="30" <? if ($perfilesdisponibles==30){ ?> selected="selected" <? } ?>>PARADOCENTE</option>
											<option value="22" <? if ($perfilesdisponibles==22){ ?> selected="selected" <? } ?>>PSICOPEDAGOGO(A)</option>
										  </select>
									    </div>
									  </label></td>
									  <td width="30%"><label>
									  <? if($modifica==1){?>
										<input name="ir" type="submit" id="ir" value="MODIFICAR" class="botonXX">
									<? } ?>
									  </label></td>
									</tr>
								  </table>
								  
								  <!-- Aqui muestro el mapa  -->
									<? 
																	
									
									    $qry2 = "select * from config_mensajeria where id_perfil = '$perfilesdisponibles'";
										$res2 = @pg_Exec($conn,$qry2);										
										$f2   = @pg_fetch_array($res2,0);
										$n2   = @pg_numrows($res2);
										
																				
										if (($n2==NULL) AND ($perfilesdisponibles2==NULL)){
										   $perfilesdisponibles = 14;
										   $qry2 = "select * from config_mensajeria where id_perfil = '$perfilesdisponibles'";
										   $res2 = pg_Exec($conn,$qry2);										
										   $f2   = @pg_fetch_array($res2,0);
										   
										}  									
										
										
										$p_19    = $f2['p_19'];
										$p_25    = $f2['p_25'];
										$p_20    = $f2['p_20'];
										$p_6     = $f2['p_6'];
										$p_21    = $f2['p_21'];
										$p_15    = $f2['p_15'];
										$p_16    = $f2['p_16'];
										$p_17    = $f2['p_17'];
										$p_1     = $f2['p_1'];
										$p_8     = $f2['p_8'];
										$p_14    = $f2['p_14'];
										$p_27    = $f2['p_27'];	
																
								        ?>
                                   <br>
                                   <br>
								 <? if (!isset($actualizar)){ ?>  
								   
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
										 <tr>
										   <td height="50" class="cuadro02"><div align="center">MAPA DE COMUNICACI&Oacute;N </div></td>
										 </tr>
										 <tr>
										   <td><div align="center"> <br>
											 <table width="100%" border="0" cellspacing="0" cellpadding="0">
											   <tr>
												 <td width="40%"><div align="center"><strong>PERFIL:  <span class="titulos-respaldo">											 
												    <!-- Aqui obtengo el nombre del perfil disponible -->
													<?
																										  							
														   if ($perfilesdisponibles=="14"){
																$nombreperfildisponible = "ADMINISTRADOR WEB COLEGIO";
														   }
														   if ($perfilesdisponibles=="27"){
																$nombreperfildisponible = "ADMINISTRATIVO WEB";
														   }
														   if ($perfilesdisponibles=="1"){
																$nombreperfildisponible = "DIRECTOR GENERAL";
														   }
														   if ($perfilesdisponibles=="17"){
																$nombreperfildisponible = "DOCENTE";
														   }
														   
														   if ($perfilesdisponibles=="19"){
																$nombreperfildisponible = "INSPECTOR";
														   }
														   if ($perfilesdisponibles=="21"){
																$nombreperfildisponible = "PSICOLOGO";
														   }
														   if ($perfilesdisponibles=="20"){
																$nombreperfildisponible = "ORIENTADOR";
														   }
														   if ($perfilesdisponibles=="25"){
																$nombreperfildisponible = "JEFE DE UTP";
														   }
														   if ($perfilesdisponibles=="6"){
																$nombreperfildisponible = "ENFERMERIA";
														   }
														   if ($perfilesdisponibles=="15"){
																$nombreperfildisponible = "APODERADO";
														   }
														   if ($perfilesdisponibles=="16"){
																$nombreperfildisponible = "ALUMNO";
														   }									   
														   
														   echo "$nombreperfildisponible";  ?>
														   
														   </span></strong></td>
												 <td width="10%">&nbsp;</td>
												 <td width="50%">&nbsp;</td>
											   </tr>
											   
											   <?
											   
											  
												 if ($p_14 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_administrador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ADMINISTRADOR WEB COLEGIO</span></td>
											         </tr>
												<? }
												
												 if ($p_27 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_administrador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ADMINISTRATIVO WEB </span></td>
											         </tr>
												<? }							
												
												
												
												if ($p_1 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_director.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL DIRECTOR GENERAL </span></td>
											         </tr>
												<? }
												if ($p_17 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_docente.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL DOCENTE </span></td>
											         </tr>
												<? }
												
												
												if ($p_19 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_inspector.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL INSPECTOR </span></td>
											         </tr>
												<? }
												if ($p_21 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_sicologo.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL PSICOLOGO </span></td>
											         </tr>
												<? }
												if ($p_25 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_orientador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL JEFE DE UTP </span></td>
											         </tr>
												<? }
												if ($p_20 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_orientador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ORIENTADOR </span></td>
											         </tr>
												<? }
												if ($p_6 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_enfermeria.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ENFERMERÍA </span></td>
											         </tr>
												<? }
												if ($p_15 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_apoderado.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL APODERADO </span></td>
											         </tr>
												<? }
												if ($p_16 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_alumno.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ALUMNO </span></td>
											         </tr>
												<? }  ?>							   
											   
											   
											   <tr>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
											   </tr>
											 </table>
										   </div></td>
										 </tr>
										 <tr>
										   <td>&nbsp;</td>
										 </tr>
					            </table> 
								      
								<? } ?>	
								  
								  <?
								 
								  
								   if (isset($actualizar)){ 
								    
								        $chkinspector        = vacio($chkinspector);
										$chkjefeutp			 = vacio($chkjefeutp);
										$chkorientador       = vacio($chkorientador);
										$chkenfermeria       = vacio($chkenfermeria);
										$chkpsicologo        = vacio($chkpsicologo);
										$chkapoderado        = vacio($chkapoderado);
										$chkalumno           = vacio($chkalumno);
										$chkdocente          = vacio($chkdocente);
										$chkdirectorgeneral  = vacio($chkdirectorgeneral);
										$chkprofesorjefe     = vacio($chkprofesorjefe);
										$chkadministradorweb = vacio($chkadministradorweb);
										$chkadministrativoweb = vacio($chkadministrativoweb);
										
										// antes de actualizar para marcar ambos perfiles con comunicacion entre si,
										// debo desmarcar a todos los demas perfiles donde corresponda el perfil
												
										
										
								        
										// proceso que altualiza el mapa individual de comunicacion
										$qry = "update config_mensajeria set p_19 = '$chkinspector', p_20 = '$chkorientador', p_25 = '$chkjefeutp', p_6 = '$chkenfermeria', p_21 = '$chkpsicologo', p_15 = '$chkapoderado', p_16 = '$chkalumno', p_17 = '$chkdocente', p_1 = '$chkdirectorgeneral', p_14 = '$chkadministradorweb', p_27 = '$chkadministrativoweb' where id_perfil = '".trim($perfilesdisponibles2)."'";
										$res = pg_Exec($conn,$qry); 
										// ya actualicé  el perfil del perfil elegido que envía a...
										// ahora debo actualizar quin recibe.
										if (($perfilesdisponibles2 == 19) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);												
										}
										if (($perfilesdisponibles2 == 19) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);												
										}			
										    
										if (($perfilesdisponibles2 == 19) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 19) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 19) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 19) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 19) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 19) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 19) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 19) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 19) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										

										if (($perfilesdisponibles2 == 19) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_19 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
										}
										if (($perfilesdisponibles2 == 19) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_19 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
										}
										
										
										// trabajo con el perfil orientador
										
										if (($perfilesdisponibles2 == 20) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 20) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 20) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 20) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 20) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 20) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 20) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 20) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 20) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 20) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										

										if (($perfilesdisponibles2 == 20) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_20 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 20) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_20 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}


										// trabajo con el perfil JEFE DE UTP
										
										if (($perfilesdisponibles2 == 25) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 25) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 25) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 25) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 25) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 25) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 25) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 25) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 25) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 25) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_25 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 25) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_25 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
		
/******/										
										// trabajo con el perfil enfermería
										if (($perfilesdisponibles2 == 6) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 6) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 6) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 6) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 6) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_6 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 6) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_6 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										// trabajo con el perfil psicologo
										if (($perfilesdisponibles2 == 21) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										
										if (($perfilesdisponibles2 == 21) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 21) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 21) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 21) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										
										if (($perfilesdisponibles2 == 21) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 21) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 21) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 21) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 21) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}

										if (($perfilesdisponibles2 == 21) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_21 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 21) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_21 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										// trabajo con apoderado
										if (($perfilesdisponibles2 == 15) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 15) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
																		
										if (($perfilesdisponibles2 == 15) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 15) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 15) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_15 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 15) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_15 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										
										// trabajamos con alumno
										if (($perfilesdisponibles2 == 16) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 16) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 16) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 16) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_16 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 16) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_16 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}


										
										// TRABAJO CON DOCENTE
										if (($perfilesdisponibles2 == 17) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 17) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 17) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 17) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
																			
										
										if (($perfilesdisponibles2 == 17) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 17) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 17) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 17) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 17) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 17) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										

										if (($perfilesdisponibles2 == 17) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_17 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 17) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_17 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										

																				
										
										
										
										// TRABAJO CON EL DIRECTOR GENERAL
										if (($perfilesdisponibles2 == 1) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										

										if (($perfilesdisponibles2 == 1) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 1) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 1) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 1) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 1) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 1) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 1) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 1) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 1) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										

										if (($perfilesdisponibles2 == 1) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_1 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 1) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_1 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}


																
										// PROFESOR JEFE
										if (($perfilesdisponibles2 == 8) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 8) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 8) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 8) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										
										if (($perfilesdisponibles2 == 8) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 8) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 8) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 8) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 8) and ($chkadministradorweb == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkadministradorweb != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '14'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 8) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										
										if (($perfilesdisponibles2 == 8) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_8 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 8) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_8 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}


													
										// TRABAJO CON EL ADMINISTRADOR WEB
										if (($perfilesdisponibles2 == 14) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}				
										
										
										if (($perfilesdisponibles2 == 14) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}								
										
										
										if (($perfilesdisponibles2 == 14) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										if (($perfilesdisponibles2 == 14) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}								
										
										
										if (($perfilesdisponibles2 == 14) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}								
										
										
										if (($perfilesdisponibles2 == 14) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										if (($perfilesdisponibles2 == 14) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										if (($perfilesdisponibles2 == 14) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}									
										
										if (($perfilesdisponibles2 == 14) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										if (($perfilesdisponibles2 == 14) and ($chkadministrativoweb == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkadministrativoweb != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '27'";
											$r1 = pg_Exec($conn,$q1);
											
										}

										if (($perfilesdisponibles2 == 14) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_14 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 14) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_14 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										// TRABAJO CON EL ADMINISTRATIVO WEB
										if (($perfilesdisponibles2 == 27) and ($chkinspector == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkinspector != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '19'";
											$r1 = pg_Exec($conn,$q1);
											
										}				
										
										
										if (($perfilesdisponibles2 == 27) and ($chkorientador == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkorientador != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '20'";
											$r1 = pg_Exec($conn,$q1);
											
										}								
										
										
										if (($perfilesdisponibles2 == 27) and ($chkenfermeria == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkenfermeria != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '6'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										if (($perfilesdisponibles2 == 27) and ($chkpsicologo == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkpsicologo != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '21'";
											$r1 = pg_Exec($conn,$q1);
											
										}								
										
										
										if (($perfilesdisponibles2 == 27) and ($chkapoderado == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkapoderado != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '15'";
											$r1 = pg_Exec($conn,$q1);
											
										}								
										
										
										if (($perfilesdisponibles2 == 27) and ($chkalumno == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkalumno != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '16'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										if (($perfilesdisponibles2 == 27) and ($chkdocente == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkdocente != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '17'";
											$r1 = pg_Exec($conn,$q1);
											
										}										
										
										if (($perfilesdisponibles2 == 27) and ($chkprofesorjefe == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkprofesorjefe != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '8'";
											$r1 = pg_Exec($conn,$q1);
											
										}									
										
										if (($perfilesdisponibles2 == 27) and ($chkdirectorgeneral == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkdirectorgeneral != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '1'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										
										
										if (($perfilesdisponibles2 == 27) and ($chkjefeutp == 1)){
										    $q1 = "update config_mensajeria set p_27 = 1 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										if (($perfilesdisponibles2 == 27) and ($chkjefeutp != 1)){
										    $q1 = "update config_mensajeria set p_27 = 0 where id_perfil = '25'";
											$r1 = pg_Exec($conn,$q1);
											
										}
										

										
																				
										$qry2 = "select * from config_mensajeria where id_perfil = '$perfilesdisponibles2'";
										$res2 = @pg_Exec($conn,$qry2);										
										$f2   = @pg_fetch_array($res2,0);
										$p_19    = $f2['p_19'];
										$p_25    = $f2['p_25'];
										$p_20    = $f2['p_20'];
										$p_6     = $f2['p_6'];
										$p_21    = $f2['p_21'];
										$p_15    = $f2['p_15'];
										$p_16    = $f2['p_16'];
										$p_17    = $f2['p_17'];
										$p_1     = $f2['p_1'];
										$p_8     = $f2['p_8'];
										$p_14    = $f2['p_14'];
										$p_27    = $f2['p_27'];	
																
								        ?>
                                   <br>
                                   <br>
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
										 <tr>
										   <td height="50" class="cuadro02"><div align="center">MAPA DE COMUNICACI&Oacute;N </div></td>
										 </tr>
										 <tr>
										   <td><div align="center"> <br>
											 <table width="100%" border="0" cellspacing="0" cellpadding="0">
											   <tr>
												 <td width="40%"><div align="center">PERFIL <? echo "$nombreperfildisponible"; ?> </div></td>
												 <td width="10%">&nbsp;</td>
												 <td width="50%">&nbsp;</td>
											   </tr>
											   
											   <?
											   
											  
												 if ($p_14 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_administrador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ADMINISTRADOR WEB COLEGIO </span></td>
											         </tr>
												<? }
												
												if ($p_27 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_administrador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ADMINISTRATIVO WEB </span></td>
											         </tr>
												<? }
												
												if ($p_1 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_director.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL DIRECTOR GENERAL </span></td>
											         </tr>
												<? }
												if ($p_17 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_docente.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL DOCENTE </span></td>
											         </tr>
												<? }
												
											  /* if ($p_8 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50"><div align="right"><img src="images/raya.gif" width="94" height="16"></div></td>
												       <td><img src="images/flecha.gif" width="47" height="16"></td>
												       <td>PERFIL PROFESOR JEFE </td>
											         </tr>
												<? }
												*/
												
												if ($p_19 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_inspector.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL INSPECTOR </span></td>
											         </tr>
												<? }
												if ($p_21 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_sicologo.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL PSICOLOGO </span></td>
											         </tr>
												<? }
												if ($p_25 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_orientador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL JEFE DE UTP </span></td>
											         </tr>
												<? }

												if ($p_20 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_orientador.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ORIENTADOR </span></td>
											         </tr>
												<? }
												if ($p_6 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_enfermeria.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ENFERMERÍA </span></td>
											         </tr>
												<? }
												if ($p_15 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_apoderado.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL APODERADO </span></td>
											         </tr>
												<? }
												if ($p_16 == "0"){ // entonces no lo muestro
												 }else{
													 // muestro el perfil ?>  
													 <tr>
												       <td height="50">&nbsp;</td>
												       <td><img src="images/i_alumno.jpg" width="65" height="52"></td>
												       <td><span class="Estilo7">PERFIL ALUMNO </span></td>
											         </tr>
												<? }  ?>							   
											   
											   
											   <tr>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
											   </tr>
											 </table>
										   </div></td>
										 </tr>
										 <tr>
										   <td>&nbsp;</td>
										 </tr>
							    </table>
								  <? } ?>
								  
								  
								  
								  
								  
								  
							 <? }else{ ?>						  
								   <table width="100%" border="0" cellspacing="0" cellpadding="3">
									 <tr>
									   <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3">
										 <tr>
										   <td>PERFIL: <strong><?
										   if ($perfilesdisponibles=="14"){
										        $nombreperfildisponible = "ADMINISTRADOR WEB COLEGIO";
										   }
										   if ($perfilesdisponibles=="27"){
										        $nombreperfildisponible = "ADMINISTRATIVO WEB";
										   }
										   if ($perfilesdisponibles=="1"){
										        $nombreperfildisponible = "DIRECTOR GENERAL";
										   }
										   if ($perfilesdisponibles=="17"){
										        $nombreperfildisponible = "DOCENTE";
										   }
										   if ($perfilesdisponibles=="8"){
										        $nombreperfildisponible = "PROFESOR JEFE";
										   }
										   if ($perfilesdisponibles=="19"){
										        $nombreperfildisponible = "INSPECTOR";
										   }
										   if ($perfilesdisponibles=="21"){
										        $nombreperfildisponible = "PSICOLOGO";
										   }
										   if ($perfilesdisponibles=="20"){
										        $nombreperfildisponible = "ORIENTADOR";
										   }
										   if ($perfilesdisponibles=="25"){
										        $nombreperfildisponible = "JEFE DE UTP";
										   }
										   if ($perfilesdisponibles=="6"){
										        $nombreperfildisponible = "ENFERMERIA";
										   }
										   if ($perfilesdisponibles=="15"){
										        $nombreperfildisponible = "APODERADO";
										   }
										   if ($perfilesdisponibles=="16"){
										        $nombreperfildisponible = "ALUMNO";
										   }									   
										   
										   echo "$nombreperfildisponible";  ?></strong>
										   <input name="perfilesdisponibles2" type="hidden" id="perfilesdisponibles2" value="<?=$perfilesdisponibles ?>">
									       <input name="nombreperfildisponible" type="hidden" id="nombreperfildisponible" value="<?=$nombreperfildisponible ?>"> </td>
										   <td><div align="right">&nbsp;</div></td>
										 </tr>
									   </table></td>
								     </tr>
									 <tr>
									   <td height="50" colspan="2" class="cuadro02"><div align="center">COMUNICACI&Oacute;N CON: </div></td>
								     </tr>
									 <?
									 $qry2 = "select * from config_mensajeria where id_perfil = '$perfilesdisponibles'";
									 $res2 = @pg_Exec($conn,$qry2);
										
										
										$f2   = @pg_fetch_array($res2,0);
										$p_19    = $f2['p_19'];
										$p_25    = $f2['p_25'];
										$p_20    = $f2['p_20'];
										$p_6     = $f2['p_6'];
										$p_21    = $f2['p_21'];
										$p_15    = $f2['p_15'];
										$p_16    = $f2['p_16'];
										$p_17    = $f2['p_17'];
										$p_1     = $f2['p_1'];
										$p_8     = $f2['p_8'];
										$p_14    = $f2['p_14'];
										$p_27    = $f2['p_27'];	
									 ?>
									 
									 
									 <? 
									 
									     // muestro el perfil ?>  
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkadministradorweb" value="1" <? if ($p_14==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL ADMINISTRADOR WEB COLEGIO </span></td>
									     </tr>
										 
										 <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkadministrativoweb" value="1" <? if ($p_27==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL ADMINISTRATIVO WEB </span></td>
									     </tr>
								    
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkdirectorgeneral" value="1" <? if ($p_1==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL DIRECTOR GENERAL </span></td>
									     </tr>
								   
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkdocente" value="1" <? if ($p_17==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL DOCENTE </span></td>
									     </tr>
								   
									
									    							   
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkinspector" value="1" <? if ($p_19==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL INSPECTOR </span></td>
									     </tr>
								   
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkpsicologo" value="1" <? if ($p_21==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL PSICOLOGO </span></td>
									     </tr>
								    
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkjefeutp" value="1" <? if ($p_25==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL JEFE DE UTP </span></td>
									     </tr>

									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkorientador" value="1" <? if ($p_20==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL ORIENTADOR </span></td>
									     </tr>
			    
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkenfermeria" value="1" <? if ($p_6==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL ENFERMERIA </span></td>
									     </tr>
								   
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkapoderado" value="1" <? if ($p_15==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL APODERADO </span></td>
									     </tr>
								    
									     <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkalumno" value="1" <? if ($p_16==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PERFIL ALUMNO </span></td>
									     </tr>
								   			<tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkalumno" value="1" <? if ($p_2==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">DIRECTOR(A)  ACADEMICO </span></td>
									     </tr> 
									 <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkalumno" value="1" <? if ($p_30==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PARADOCENTE</span></td>
									     </tr> 
										 <tr>
									       <td width="30%"><div align="right">
										     <input type="checkbox" name="chkalumno" value="1" <? if ($p_22==1){ ?> checked="checked" <? } ?>>
									        </div></td>
									       <td width="70%"><span class="Estilo7">PSICOPEDAGOGO(A)</span></td>
									     </tr> 
									 <tr>
									   <td>&nbsp;</td>
									   <td>&nbsp;</td>
									 </tr>
									 <tr>
									   <td colspan="2"><div align="center">
										 <label>
										 <input name="actualizar" type="submit" id="actualizar" value="ACTUALIZAR">
										 </label>
										 <label>
										 <input name="Submit3" type="submit" onClick="MM_goToURL('parent','configuracion.php?perfilesdisponibles=<?=$perfilesdisponibles ?>');return document.MM_returnValue" value="VOLVER">
										 </label>
									   </div></td>
								     </tr>
									 <tr>
									   <td>&nbsp;</td>
									   <td>&nbsp;</td>
									 </tr>
							    </table>							   
								   
					            <? } ?>		   
						  </form>						  
						  
						  </td>
                        </tr>
                    	   
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

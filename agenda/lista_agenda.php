<?
session_start();
require('../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$ano3			=$_ANO;
$curso          =$_CURSO;


$_POSP = 1;
$_bot = 0;

if ($ano > 0){
   $_MDINAMICO = 1;
}else{
   $_MDINAMICO = 0;
}
      
$perfil = $_PERFIL; 


/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;

}
elseif($_PERFIL==16){
	if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
	$ingreso = 0;
	$modifica =0;
	$elimina =0;
	$ver =1;
}
else{
	if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		//$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$perfil." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$perfil." AND id_menu=9 AND id_categoria=49";
		
		//if($_INSTIT==14804 ){echo $sql;}
		
		$rs_permiso = @pg_exec($conn,$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
}
if(isset($fecha)){
	$sw=0;
}else{
	$sw=1;
}

	
$usuarioensesion = $_USUARIOENSESION;

//Tomo todos los datos de la agenda
  $dia  = substr($fecha,8,2);
   $mes  = substr($fecha,5,2);
   $ano2 = substr($fecha,0,4);
if ($sw == 1){
   $sqlagenda="select * from agenda  where rdb = '$institucion' ";
   $rsagenda= @pg_Exec($conn,$sqlagenda);
}else{
   $dia  = substr($fecha,8,2);
   $mes  = substr($fecha,5,2);
   $ano2 = substr($fecha,0,4);
    $sqlagenda="select * from agenda where fecha = '$fecha' and rdb = '$institucion'";
   $rsagenda= @pg_Exec($conn,$sqlagenda);
}

if($_PERFIL==17){
	$sqlagenda="SELECT * FROM agenda WHERE rdb=".$institucion." AND id_curso=".$curso;	
	if(isset($fecha)){
		$sqlagenda.=" AND fecha='$fecha'";
	
	}
	
}
if($_PERFIL==16){
	$sqlagenda="SELECT * FROM agenda WHERE rdb=".$institucion." AND id_curso in (select id_curso from matricula where rut_alumno=".$_NOMBREUSUARIO." AND id_ano=".$ano." AND bool_ar=0) ";	
	if(isset($fecha)){
		$sqlagenda.=" AND fecha='$fecha'";
	
	}
	
}
$rsagenda= @pg_Exec($conn,$sqlagenda);
//echo $sqlagenda."   --->".pg_numrows($rsagenda);

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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
					    $menu_lateral=5;
						include("../menus/menu_lateral.php");
						?> 
					  
					  
                    </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="center" valign="top"> 
                                  <td height="162" align="center">
								       <table width="100%">
						            <tr><td class="tableindex"><div align="center"><img src="images/IMAGE_AGENDA_2.png" width="239" height="83">
						              <?
									if ($sw != 1){
										echo $fecha;
									   ?>
									   <!--: <?=$dia ?> - <?=$mes ?> - <?=$ano2 ?>-->
									   <?
									} ?>								   
									
									</div></td></tr></table>
								       
									   <?
									   $_ANO = $ano;
									    
									 //  if ($_PERFIL == 2 OR $_PERFIL == 17 OR $_PERFIL == 19 OR $_PERFIL == 0 OR $_PERFIL == 14 OR$_PERFIL == 8 OR $_PERFIL == 28){
										    if ( $_PERFIL == 17 OR  $_PERFIL == 0 OR $_PERFIL == 14 OR $ingreso==1){
									      if ($ano3 > 0){
									         ?>
									   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                              <td align="left"><div align="left">
                                                <?
											     if ($ingreso==1){
													
													  ?>												 
												     <input name="Submit" type="button" class="botonXX" onClick="MM_goToURL('parent','form_agenda.php');return document.MM_returnValue" value="Agregar informacion">
                                              <? } ?>
							     </div></td>
                                       <td width="400" align="center"><img src="images/icono_agenda.png" width="93" height="99"></td>
                                               </tr>
                                    </table>
										      <?
										   }else{
										      echo "<font face='arial' size='1'>Para agregar informacion a la agenda debe elegir un año académico</font>";
										   }	  
									   }
									   ?>							   
						            <br>
						            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                            <tr class="tabla01">
                                                  <td width="20%" ><div align="center"><span class="Estilo1">Fecha</span></div></td>
                                                  <td width="20%" ><div align="center"><span class="Estilo1">Hasta</span></div></td>
                                                  <td width="60%" ><div align="center"><span class="Estilo1">Titulo</span></div></td>
                                                </tr>
                                              </table>
							           <br>
								       									       
												   <?
												   $titulo = "";
												   if(@pg_numrows($rsagenda)!=0){
												      for($i=0 ; $i < @pg_numrows($rsagenda) ; $i++)
	                                                     {
		                                                 $fagenda = @pg_fetch_array($rsagenda,$i);	
													     $id = $fagenda['id'];
														 $id_padre = $fagenda['id_padre'];
														 $id_curso = $fagenda['id_curso']; 
														 $titulo2 = $fagenda['titulo'];
														 $fechalini = $fagenda['fecha'];
														 $di = substr($fechalini,8,2);
														 $mi = substr($fechalini,5,2);
														 $ai = substr($fechalini,0,4);
														 $fechalini = "$di-$mi-$ai";
														 $fechalcad = $fagenda['caduca'];
														 $dc = substr($fechalcad,8,2);
														 $mc = substr($fechalcad,5,2);
														 $ac = substr($fechalcad,0,4);
														 $fechalcad = "$dc-$mc-$ac";														
														 if ($fechalcad == "01-01-2001"){
														    $fechalcad = "-";
														 }	
														 
														 if ($titulo != $titulo2){
														    $titulo = $fagenda['titulo'];
															if ($id_curso == 0){
															   //muestro														
															   ?>
														       <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                 <tr>
                                                                  <td>
										   					       <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                                                    <tr>
                                                                      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                                        <tr class="textolink">
                                                                          <td width="20%"><div align="center"><span class="Estilo3"><?=$fechalini ?></span></div></td>
                                                                          <td width="20%"><div align="center"><span class="Estilo3"><?=$fechalcad ?></span></div></td>
                                                                          <td width="60%"><div align="center"><span class="Estilo3"><a href="detalle_agenda.php?id_agenda=<?=$id?>&id_padre=<?=$id_padre?>&fecha=<?=$fecha?>"><?=$titulo2 ?></a></span></div></td>
                                                                        </tr>
                                                                      </table>
                                                                      </td>
                                                                    </tr>
                                                                    </table>
														           </td>
                                                                 </tr>
                                                                   
                                    </table>		
												                  <?
															 }else{
															      if ($id_curso == $curso){
																      //muestro
																	  ?>
														              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                      <tr>
                                                                      <td>
										   					          <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                                                       <tr>
                                                                       <td bgcolor="#FFFFFF">
											   				             <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                                           <tr>
                                                                             <td width="20%" class="textolink"><div align="center"><span class="Estilo3"><?=$fechalini ?>
                                                                             </span></div></td>
                                                                             <td width="20%" class="textolink"><div align="center"><span class="Estilo3">
                                                                               <?=$fechalcad ?>
                                                                             </span></div></td>
                                                                             <td width="60%" class="textolink"><div align="center"><span class="Estilo3"><a href="detalle_agenda.php?id_agenda=<?=$id ?>&id_padre=<?=$id_padre?>&fecha=<?=$fecha?>">
                                                                               <?=$titulo2 ?>
                                                                             </a></span></div></td>
                                                                           </tr>
                                                                         </table>
											   				             </td>
                                                                        </tr>
                                                                        </table>
															            </td>
                                                                        </tr>
                                                                        
                                    </table>		
												                        <?
																    }else{
																	  //  if ($perfil == 17 OR $perfil == 16 OR $perfil == 2 OR $perfil == 19 OR $perfil == 0 OR $perfil == 14 OR $perfil == 35 )
																		 if ($perfil == 17 OR $perfil == 16 OR $perfil == 0 OR $perfil == 14)
																		{//echo "pase";
																			
																		    // muestro
																		    ?>
														                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                            <tr>
                                                                            <td>
										   					                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                                                            <tr>
                                                                              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                                                <tr>
                                                                                  <td width="20%" class="textolink"><div align="center"><span class="Estilo3"><?=$fechalini ?>
                                                                                  </span></div></td>
                                                                                  <td width="20%" class="textolink"><div align="center"><span class="Estilo3">
                                                                                    <?=$fechalcad ?>
                                                                                  </span></div></td>
                                                                                  <td width="60%" class="textolink"><div align="center"><span class="Estilo3">
                                                                                    <a href="detalle_agenda.php?id_agenda=<?=$id ?>&id_padre=<?=$id_padre?>&fecha=<?=$fecha?>"><?=$titulo2 ?></a>
                                                                                  </span></div></td>
                                                                                </tr>
                                                                              </table>
                                                                              </td>
                                                                            </tr>
                                                                            </table>
															                </td>
                                                                            </tr>
                                                                            
                                                                            </table>		
												                            <?
																		}
																		 elseif ($ver==1 )
																		{
																		    // muestro
																		    ?>
														                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                            <tr>
                                                                            <td>
										   					                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                                                            <tr>
                                                                              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                                                <tr>
                                                                                  <td width="20%" class="textolink"><div align="center"><span class="Estilo3"><?=$fechalini ?>
                                                                                  </span></div></td>
                                                                                  <td width="20%" class="textolink"><div align="center"><span class="Estilo3">
                                                                                    <?=$fechalcad ?>
                                                                                  </span></div></td>
                                                                                  <td width="60%" class="textolink"><div align="center"><span class="Estilo3">
                                                                                    <a href="detalle_agenda.php?id_agenda=<?=$id ?>&id_padre=<?=$id_padre?>&fecha=<?=$fecha?>"><?=$titulo2 ?></a>
                                                                                  </span></div></td>
                                                                                </tr>
                                                                              </table>
                                                                              </td>
                                                                            </tr>
                                                                            </table>
															                </td>
                                                                            </tr>
                                                                            
                                                                            </table>		
												                            <?
																		}else{
																		    																													   
																	        // no muestro nada
																		}     
																 	}									  
															   }														  
														}else{
														    // no muestra nada
															
													    }		   
														 
													  }	
													    ?>
														<a href="#" onClick="MM_callJS('history.go(-1)')">Volver</a> &nbsp;
														<?
														if ($ano3 > 0){
														   ?>
														   - &nbsp;<a href="../index.php">Ir al Calendario</a> <br>
														   <?
														}   												  
												   }
												   ?>	  
												
							      </td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <?
						 include("../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  </td>
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

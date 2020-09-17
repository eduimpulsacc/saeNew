<?
require('../util/header.inc');

$institucion		= $_INSTIT;
$usuarioensesion 	= $_USUARIOENSESION;
$perfil_user 		= $_PERFIL;
$ano				= $_ANO;
$idusuario 			= $_USUARIO;
$_POSP = 1;


$sql="select situacion from ano_escolar where id_ano=$ano";
$result =pg_exec($conn,$sql);
$situacion=pg_result($result,0);

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

function carga_perfil(perfil){
	var parametros = "funcion=1&perfil="+perfil;
	
	$.ajax({
	  url:'con_mensajeria.php',
	  data:parametros,
	  type:'POST',
		success:function(data){
			//alert(data);
			if(data==0){
				alert("Error al Cargar Select");
			}else{ 
				$('#tabla').html(data);
				
					
					
			  }
		  }
	})
		
}

function agregar(perfil){
	var id_perfil = $("#perfilesdisponibles").val();
	var parametros = "funcion=2&perfil="+perfil+"&id_perfil="+id_perfil;
	$.ajax({
	  url:'con_mensajeria.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
			if(data==0){
				alert("Error al Cargar Select");
			}else{ 
				carga_perfil(id_perfil);
		    }
		  }
	})
}

function elimina(perfil){
	var id_perfil = $("#perfilesdisponibles").val();
	var parametros = "funcion=3&perfil="+perfil+"&id_perfil="+id_perfil;
	$.ajax({
	  url:'con_mensajeria.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
			if(data==0){
				alert("Error al Cargar Select");
			}else{ 
				carga_perfil(id_perfil);
		    }
		  }
	})
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
                          						    
						 
						    <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									  <td width="30%"><div align="right" class="Estilo7">CONFIGURAR PERFIL &nbsp;&nbsp;</div></td>
									  <td width="40%"><label>
									    <select name="perfilesdisponibles" id="perfilesdisponibles" onChange="carga_perfil(this.value);">
									      <option value="0">seleccione...</option>
									      <? $sql = "SELECT id_perfil,nombre_perfil FROM perfil WHERE sistema=1 AND id_perfil not in (47,26,24,4,31,44,51) ORDER BY 2";
											$rs_perfil = pg_exec($connection,$sql);
										
											for($i=0;$i<pg_numrows($rs_perfil);$i++){
												$fila = pg_fetch_array($rs_perfil,$i);?>
									      
									      <option value="<?=$fila['id_perfil'];?>">
								          <?=$fila['nombre_perfil'];?>
								          </option>
									      <? } ?>
								        </select>
								      </label></td>
									 
								  </tr>
                                    
								  </table>
								  <div id="tabla">&nbsp;</div>
								  <!-- Aqui muestro el mapa  -->
										  
						  
						  </td>
                        </tr>
                    	   
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../cabecera/menu_inferior.php"); ?></td>
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

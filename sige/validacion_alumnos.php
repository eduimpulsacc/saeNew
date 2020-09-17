<? 
require('../util/header.inc');
require_once("../admin/clases/class_MotorBusqueda.php");

header( 'Content-type: text/html; charset=iso-8859-1' );
   	session_start();

$institucion	=$_INSTIT;
"Ensecion->".$usuarioensesion = $_USUARIOENSESION;
$perfil_user = $_PERFIL;
"Id_Usuario->".$idusuario = $_USUARIO;
$idele = $_GET['idel'];

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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->


	// Cargar Paginas._
	function enviapag(pag){
	//alert(pag);
		if(pag!=""){
		     $.ajax({
				  url:"vistas/"+pag,
				  type:'GET', 
				  data: $('#form_patoc').serialize(),
				/*  error: function(objeto, quepaso, otroobj){
			           window.location.href="logout.php";
			        },*/
				  success:function(data){
					//alert(data);
				    $("#Contenedor").html(data);
				    }
		    });
		  }	
	 };
 

</script>


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <? include("../cabecera/menu_superior.php"); ?>
            <!-- FIN DE COPIA DE CABECERA -->        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><!-- AQUI VA EL MEN{U LATERAL -->
                  <?
						 $menu_lateral=3;
						 include("../menus/menu_lateral.php");
						 ?>
                  <!--  FIN MENU LATERAL -->              </td>
              <td width="73%" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top">
                    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><!-- FIN DEL CONTENIDO CENTRAL DE LA PÁGINA -->
                              <!-- INSERTO EL CONTENIDO DEL MOTOR DE BUSQUEDA -->
                            <br>
                              <br>
      <form method "post" action="print_validacion_alumnos.php" name="form" target="_blank">
        <center>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="tableindex">Buscador Avanzado </td>
                  </tr>
                  <tr>
                    <td height="27"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
            <? 
			
												  
	$ob_curso = new MotorBusqueda();
	$ob_curso ->ano = $ano;
	$ob_curso ->institucion = $institucion;
	$result_curso = $ob_curso -> curso($conn);
?>
	  <td width="130" class="cuadro01">Curso <br>
		  <br></td>
	  <td width="21" class="cuadro01">:</td>
	  <td width="495" class="cuadro01"><select name="c_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
		  <option value=0 selected>(Todos Los Cursos)</option>
                                                      <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
            </select>
            </td>
        </tr>
       
        <tr>
          <td class="cuadro01">&nbsp;</td>
          <td width="21" class="cuadro01">&nbsp;</td>
          <td width="495" class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
            <input name="cb_exp" type="submit"  class="botonXX"  id="cb_exp" value="Exportar"> <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver" onClick="window.location='Menu_Reportes_new2.php'"></td>
    </tr>
    </table></td>
    </tr>
    </table></td>
    </tr>
    </table>
    </center>
    </form>
    <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->                          </td>
    </tr>
    </table></td>
    </tr>
    </table></td>
    </tr>
    <tr align="center" valign="middle">
    <td height="45" colspan="2" class="piepagina"><? include("../cabecera/menu_inferior.php"); ?></td>
    </tr>
    </table></td>
    </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
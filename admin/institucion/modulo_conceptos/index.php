<? header( 'Content-type: text/html; charset=iso-8859-1' );
require('../../../util/header.inc');

$institucion	=$_INSTIT;
$usuarioensesion = $_USUARIOENSESION;
$perfil_user = $_PERFIL;
$idusuario = $_USUARIO;
$idele = $_GET['idel'];
$_POSP=3;

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
<XHTML>
<HEAD>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link type="text/css" href="jquery-ui-1.8.17.custom/css/redmond/jquery-ui-1.7.3.custom.css" rel="stylesheet" />

<script type="text/javascript" src="jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom/js/jquery-ui-1.8.17.custom.min.js"></script>

<script language="JavaScript" src="../../clases/jqueryui/jquery.ui.core.js"></script>
<script language="JavaScript" src="../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" src="../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script language="JavaScript" src="../../clases/jqueryui/jquery.ui.widget.js"></script>

<script language="JavaScript" type="text/JavaScript">

	// Cargar Paginas._
	function enviapag(pag){
	
	//alert(pag);
	//var aaa = $('#form_patoc').serialize();
	//alert(aaa);
	
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
				    
					$("#Contenedor").remove();
	 
	                $("#mantenedor").append('<div id="Contenedor"></div>');
	 
					$("#Contenedor").append(data);
					
				  }
		    });
		  }	
	 };
	 


</script>

<style type="text/css">
#Contenedor{	margin:auto;padding-left:55px;padding-bottom:30px;	}
#enlace	{  	font-size:12px;font-style:normal;color:#FFFFFF;padding:5px; margin:10px;	}
#enlace:hover   {	color:#06F;	}
</style>

</HEAD>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="15%" height="100%" align="left" valign="top"> 
                      
                        <? $menu_lateral=5;  include("../../../menus/menu_lateral.php"); ?></td>
                      
                      <td width="73%" align="left" valign="top">
                      	
                      	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td  id="mantenedor" ><!--INICIO MANTENEDOR -->
							
                            <div id="Contenedor">
                            
                            </div>
								    
								  <!-- FIN DE MANTENEDOR -->
								   </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">
                      	 <?
						 include("../../../cabecera/menu_inferior.php");
						 ?>
	 				 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>"></td>
        </tr>
      </table>
      </td>
  </tr>
</table>
</body>
</html>

<script language="JavaScript" type="text/JavaScript">	 
	 enviapag('modulo_conceptos.php?var=1');
</script>


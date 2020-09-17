<?	require('../../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 3;
	
	$sql="SELECT * FROM menu_alu_apo";
	$rs_menu_alu = pg_exec($conn,$sql);
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Latin1" />
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../clases/jquery/jquery.js"></script>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script>
$( document ).ready(function() {
   cargamenu(16);
});

function cargamenu(tipo){
	var parametros="funcion=1&tipo="+tipo;
 $.ajax({
	  url:'cont_menu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#menu").html(data);
		
		  }
	  })
}


function accion(prf,acc,mn){
	var parametros="funcion=2&prf="+prf+"&acc="+acc+"&mn="+mn;
	var accion =(acc==0)?"eliminar":"agregar";
	if(confirm("Seguro desea "+accion+" esta opción?")){
 $.ajax({
	  url:'cont_menu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
	    //$("#menu").html(data);
		cargamenu(prf);
		
		  }
	  })
	}
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%"  height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50" rowspan="3" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
    <td colspan="2">&nbsp;
	<? include("../../../cabecera/menu_superior5.php");?></td>
    <td width="53" rowspan="3" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
  <tr>
    <td width="70" valign="top"><? include("../../../menus/menu_lateral.php");?></td>
    <td valign="top"><br />
        <table width="95%" border="0" class="cajaborde" align="center">
          <tr>
            <td>
            	<table width="95%" border="0" class="textonegrita">
                  <tr>
                    <td>&nbsp;</td>
                    <td class="tableindex">MEN&Uacute; DE APODERADO Y ALUMNO</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><label for="radio"></label> 
                      <input name="radio" type="radio" id="radio" onclick="cargamenu(16)" value="radio" checked="checked" />
                      Alumno 
                    
                      <input type="radio" name="radio" id="radio2" value="radio2" onclick="cargamenu(15)" />
                      Apoderado
<label for="checkbox"></label></td>
                    <td>&nbsp;</td>
                  </tr>
                </table><br />
                <div id="menu">
            </div></td>
          </tr>
        </table>
	</td>
  </tr>
  <tr>
    <td colspan="2"><? include("../../../cabecera/menu_inferior.php"); ?></td>
  </tr>
</table>


</body>
</html>

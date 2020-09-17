<?php 
	require('../../../../util/header.inc');
	
	$_POSP   =4;
	$institucion = $_INSTIT;
	$ano = $_ANO;
?>
<!doctype html>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../../clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.dialog.js"></script>

<script type="text/javascript">

function tablaTipo(){
var tipo = $("#tipo").val();
var ano = <?php echo $ano; ?>;
var ins = <?php echo $institucion ?>;
var funcion = 1;
var parametros = "funcion="+funcion+"&tipo="+tipo+"&ano="+ano+"&ins="+ins;
$.ajax({
	  url:'cont_credencial.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $(".app").remove();
		if(tipo!=0){
		 $("#tablaCred tbody").append(data);
		 carN();
		}
		  }
	  })	
}

function carN(){
	//cargar los nombres
	var funcion = 2;
	var tipo = $("#tipo").val();
	var ano = <?php echo $ano; ?>;
	var ins = <?php echo $institucion ?>;
	var cc = $("#idC").val();
	var parametros = "funcion="+funcion+"&tipo="+tipo+"&ano="+ano+"&ins="+ins+"&cc="+cc;
	$.ajax({
	  url:'cont_credencial.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $("#nom").html(data);
		  }
	  })
}

function generaC(){
var funcion = 3;
	var tipo = $("#tipo").val();
	var ano = <?php echo $ano; ?>;
	var ins = <?php echo $institucion ?>;
	var cc = $("#idC").val();
	var idn = $("#idN").val();
	var parametros = "funcion="+funcion+"&tipo="+tipo+"&ano="+ano+"&ins="+ins+"&cc="+cc+"&idn="+idn;
	
	$.ajax({
	   url:'cont_credencial.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $(".print").html(data);
		 $("#liscod" ).dialog(
		 {
      resizable: true,
      height: "auto",
      width: 800,
      modal: true,
      buttons: {
        "Imprimir": function() {
         desWord();
        },
        "Salir": function() {
          $( this ).dialog( "close" );
        }
      }
    }
		 );
		 
		
		  }
	  })
	
}

function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

function desWord(){
/*var ruta = "credencialW.php?curso=<?php echo $curso ?>";
window.open(ruta, '_blank');*/
var tipo = $("#tipo").val();
	var ano = <?php echo $ano; ?>;
	var ins = <?php echo $institucion ?>;
	var cc = $("#idC").val();
	var idn = $("#idN").val();
	var parametros = "&tipo="+tipo+"&ano="+ano+"&ins="+ins+"&cc="+cc+"&idn="+idn;
  
  var ruta = "credencialW.php?"+parametros;
window.open(ruta, '_blank');

}

</script>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td>
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?php $menu_lateral="3_1"; include("../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top">
                                  
   <!--aqui planto el buscador-->
   <table width="100%" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD align=center colspan=2 class="tableindex">
			GENERADOR CREDENCIALES ESTABLECIMIENTO
		</TD>
	</TR>
	<TR height=20>
	  <TD align=center colspan=2 ><table width="650" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center" id="tablaCred">
	    <tr >
	      <td width="16%" class="cuadro02">Cargo Usuario</td>
	      <td width="84%" class="cuadro01">
          <select id="tipo" onChange="tablaTipo();">
          <option value="0">Seleccione</option>
          <option value="3">Alumno</option>
          <option value="2">Apoderado</option>
          <option value="1">Empleado</option>
          </select></td>
	      </tr>
	    </table><br>
         <table width="650" border="0" cellspacing="1" cellpadding="0" align="center"><tr><td align="right"><input type="button" value="Generar" class="botonXX" onClick="generaC()"></td></tr></table>
</TD>
	  </TR>
      <tr>
      </tr>
   </table>
<br>
   <!--aqui termina el buscador-->                               
                                  
                                  
                                  </td>
                                  </tr>
                              </table></td>
                          </tr>
                          </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<div id="liscod"><div class="print"></div></div>
</body>
</html>

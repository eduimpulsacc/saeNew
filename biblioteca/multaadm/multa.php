<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script>
function tipo(t){
if(t==1){
	$('.tp2').show();
	$('.tp1').hide();
	traeEmp();
}
else if(t==2 || t==3){
	$('.tp1').show();
	  $('.tp2').show();
	    traeCur(t);
	//  traeNombre(t);
	}
else{
$('.tp1').hide();
 $('.tp2').hide();

}
}


function traeEmp(){
	$("#nom").html("");
	$("#cur").html("");
	var funcion =2;
	var rdb = <?php echo $_INSTIT; ?>;
	var parametros = "funcion="+funcion+"&rdb="+rdb;
	$.ajax({
	  url:'cont_multa.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#nom").html(data);
				
		  }
	  })
}
function traeCur(){
	$("#nom").html("");
	$("#cur").html("");
	var funcion =3;
	var ano = <?php echo $_ANO; ?>;
	var tipo = $("#cmbTipo").val();
	var parametros = "funcion="+funcion+"&ano="+ano+"&tipo="+tipo;
	$.ajax({
	  url:'cont_multa.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#cur").html(data);
		  }
	  })
	
}
function traeNombre(){
	$("#nom").html("");
	//$("#cur").html("");
	var funcion =4;
	var tipo = $("#cmbTipo").val();
	var curso =$("#cmbCurso").val();
	var rdb = <?php echo $_INSTIT; ?>;
	var parametros = "funcion="+funcion+"&curso="+curso+"&tipo="+tipo;
	$.ajax({
	  url:'cont_multa.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#nom").html(data);
		  }
	  })
}

function traeMulta(){
var tipo = $("#cmbTipo").val();
var curso = (tipo==2 || tipo ==3)?$("#cmbCurso").val():0;
var usu = $("#cmbRUT").val();
var funcion = 5;
var parametros = "funcion="+funcion+"&curso="+curso+"&tipo="+tipo+"&usu="+usu;
	$.ajax({
	  url:'cont_multa.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data)
		$("#lista").html(data);
		  }
	  })
}

function datoMulta(pres,ejm,usu){
var funcion = 6;
	var parametros = "funcion="+funcion+"&pres="+pres+"&ejm="+ejm+"&usu="+usu;
	
	$.ajax({
	  url:'cont_multa.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //console.log(data)
		$("#res").html(data);
			
			$("#res").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 600,
			   Height: 700,
			   minWidth: 700,
			   minHeight: 300,
			   maxWidth: 600,
			   maxHeight: 500,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Generar Multa": function(){
					 if($('#rebaja').val()=="" || $('#rebaja').val()==0){
						alert("DEBE INDICAR VALOR REBAJA");
						$('#rebaja').focus();
						return false;
					}
					else if($('#rebaja').val()>$('#mon').val()){
						alert("VALOR INGRESADO ES MAYOR AL MONTO DE LA MULTA");
						$('#rebaja').focus();
						return false;
					}
						CreaMulta();
					  
					   $(this).dialog("close");
					 } ,
				 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  }) 
		  }
	  })
}

function  muestrarebaja(){
	 $('#rebaja').attr('type', 'text');
}


function CreaMulta(){
	var funcion=7;
	var pres = $("#prestamo").val();
	var ejm = $("#ejemplar").val();
	var rba = $("#rebaja").val();
	var rutu = $("#rutu").val();
	var datr = $("#datraso").val();
	var mon = $("#mon").val();
	var tipo = $("#ttt").val();
	var cad = $("#ccc").val();
	var nano = $("#nano").val();
	
	
	var parametros ="funcion="+funcion+"&pres="+pres+"&ejm="+ejm+"&rba="+rba+"&rutu="+rutu+"&datr="+datr+"&mon="+mon+"&nano="+nano;
	
	$.ajax({
	  url:'cont_multa.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 if(data==1){
			
		alert("MULTA CREADA");
		traeMulta();
	  }else{
		  alert("ERROR AL GUARDAR");
		  }
		  }
	  })
	
}
</script>

<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="center" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br /><table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
                          <tr>
                            <td align="center" class="titulos-respaldo"><p>&nbsp;</p></td>
                          </tr>
                          <tr>
                            <td width="5%" colspan="4">
                            
                            <br />
                            
                          <table width="100%">
                              <tr>
                                <td width="100%">
                                <table width="95%" border="0" align="center">
        <tr>
          <td colspan="3" align="center" class="titulos-respaldo"><p>MULTAS PRESTAMOS</p></td>
        </tr>
        <tr>
          <td width="11%">&nbsp;</td>
          <td width="3%" align="center">&nbsp;</td>
          <td width="86%">&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td class="cuadro02">Buscar</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01"><select name="cmbTipo" id="cmbTipo" onChange="tipo(this.value)">
            <option value="0">Seleccione</option>
            <option value="1">Empleado</option>
            <option value="2">Apoderado</option>
            <option value="3">Alumno</option>
          </select></td>
          </tr>
        <tr class="tp1">
          <td class="cuadro02">Curso</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01"><div id="cur">
            <select name="cmbCurso" id="cmbCurso">
              <option value="0">Seleccione Curso</option>
            </select>
          </div></td>
          </tr>
        <tr class="tp2">
          <td class="cuadro02">Nombre</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01">
            <div id="nom">
              <select name="cmbRUT" id="cmbRUT">
                <option value="0">Seleccione</option>
              </select>
          </div></td>
          </tr>
        <tr >
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">&nbsp;</td>
          </tr>
        <tr class="tp2">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
       
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3"><div id="lista"></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3"><div id="res" title="Informacion multas"></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        
      </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                <div id="tabla">&nbsp;</div>
                                </td>
                                </tr>
                                </table>
                     </td>
                              </tr>
                            </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>


</body>

</html>

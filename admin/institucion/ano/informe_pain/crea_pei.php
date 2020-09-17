<?php require('../../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script>
$(document).ready(function(){
	pas1();
});

function pas1(){
	var parametros="funcion=0";
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
	    $("#cont").html(data);
		  }
	  })	
	
}

function pas2(){
	var parametros="funcion=2";
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	 
	    $("#cont").html(data);
		  }
	  })	
	 
	
}
function pas3(plantilla){
	var parametros="funcion=4&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
	    $("#cont").html(data);
		  }
	  })	
	 
	
}


function guardaPla(){
	var frem=$("#frm1").serialize();
	var parametros="funcion=1&frem="+frem;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
	if(data==1){
	  pas2();
	}else{
		alert("error al guardar");
		}
		  }
	  })			
	
	
}
function insRow(tabla)
{
	largo=document.getElementById(tabla).rows.length;
	var x=document.getElementById(tabla).insertRow(largo);
	var y=x.insertCell(0);
	var w=x.insertCell(1);
	var z=x.insertCell(2);
	//y.id="td"+j;
	y.innerHTML="<input name='nombre2[]' type='text' class='tnom'>";
	w.innerHTML="<input name='sigla[]' type='text' class='tsig'>";
	z.innerHTML="<input name='glosa[]' type='text' class='tglo'>";
}
function delRow(tabla)
{
	largo=document.getElementById(tabla).rows.length;
	largo=largo-1
	var x=document.getElementById(tabla).deleteRow(largo);
	
}

function guardaConc(){
	
	var funcion=3;
	var plantilla=$("#hiddenPlantilla").val();
	
	var searchNom = [];
	var searchSig = [];
	var searchGlo = [];
$(".tnom").map(function(){
    searchNom.push($(this).val());
  });
  $(".tsig").map(function(){
    searchSig.push($(this).val());
  });
   $(".tglo").map(function(){
    searchGlo.push($(this).val());
  });
  
  var parametros="funcion="+funcion+"&nombre="+searchNom+"&sigla="+searchSig+"&glosa="+searchGlo+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  // console.log(data);
	 pas3(plantilla);
		  }
	  })
  
}

function guadaItem(){
	var funcion=5;
	var frm=$("#frimtm").serialize();
	var plantilla=$("#hiddenPlantilla").val();
	var searchNom = [];
	 $(".chitm").map(function(){
		ch=($(this).is(':checked'))?1:0;
    	searchNom.push(ch);
		
  });
	var parametros = "funcion="+funcion+"&frm="+frm+"&searchNom="+searchNom;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  //console.log(data)
	 location.href="lista_pei.php";
		  }
	  })
}


function creaarea(){
var funcion=6;
var parametros = "funcion="+funcion
$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  // console.log(data);
	// pas3(plantilla);
	$("#cmdd").html(data);
	$("#cmdd").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		
	 "Guardar Datos": function(){
		 if($('#nombre_clas').val()==0){
			alert("Escriba nombre de Rrcurso");
			$('#nombre_clas').focus();
			return false;
		}
		   ingresar_Rec();
		  
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

function ingresar_Rec(){
var funcion=7;
var txt = $('#nombre_clas').val();
var parametros = "funcion="+funcion+"&txt="+txt;	
$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	   console.log(data);
	 combo();
		  }
	  })
}
function combo(){
	var funcion=8;
	var parametros = "funcion="+funcion;	
$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	 
	   $('#carea').html(data);
	 
		  }
	  })
}
/*function Confirmacion(form){
		var pla=form.hiddenPlantilla.value;
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			//window.location='procesoPlantilla.php?plantilla=pla&eliminar=1'
			form.action='procesoPlantilla.php?eliminar=1';
			form.submit(true);
		};
function Modifica(form){
		form.target='_parent';
		form.action='modificarPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

function agregaReg(form){
		form.target='_parent';
		form.action='../plantillaModifica/agregarRegistrosPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}
*/
</script>
<script>
contador_sub=-1;
function nuevoItem(cat,pos_cat,id_sub_local,pos_sub)
{	
	largo=document.getElementById(cat).rows.length;
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	label=pos_cat+1;
	pos_sub2=pos_sub-1;
	temp=largo+1; 		
	label=label+"."+pos_sub+"."+temp;
	y.innerHTML=label+" <input name=\"items[]\" size=70 class=\"item\"> <input name=\"id_sub1[]\"  type=hidden  value=\""+id_sub_local+"\"><input name=\"id_cat1[]\" value=\""+pos_cat+"\"  type=hidden ><input type=\"checkbox\" name=\"aplicaconc[]\" value=1 class=\"chitm\" checked>(Evaluable)";
//";
}

function nuevaSub(cat,pos)
{	
	vhs=cat+"-----"+pos;
//	alert (vhs);
//	alert (cat);
//	cat=eval(cat);
	largo=document.getElementById(cat).rows.length;
//	alert (largo);
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	temp=largo+1
	nombre_items="items"+pos+"_"+temp;
	temp=largo+1;
	label=pos+1;
	label=label+"."+temp;
	contador_sub=contador_sub+1;
	y.innerHTML=label+" <input name=\"sub[]\" size=70 ><input name=\"id_cat[]\" type=hidden value=\""+pos+"\"><input name=\"id_sub[]\" type=hidden  value=\""+contador_sub+"\"><input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Nuevo Item\"onclick=\"nuevoItem('"+nombre_items+"',"+pos+","+contador_sub+","+temp+");\">&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Elimina Item\" onclick=\"eliminaItems('"+nombre_items+"');\"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table id=\""+nombre_items+"\" ></table>";
}

function nuevaCategoria()
{
	largo=document.getElementById('tabla_categoria').rows.length;
	var x=document.getElementById('tabla_categoria').insertRow(largo);
	j=largo;
	var y=x.insertCell(0);
	y.className="td2";
	y.id="td"+j;
	nombre_sub="sub_infor"+j;
	j=j+1;
	anterior=j-1;	
	y.innerHTML="<table ><tr><td colspan=2>Categoria "+j+"<input name=\"cat[]\" size=70 ><input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Nueva Sub Cat\" onclick=\"nuevaSub('"+nombre_sub+"',"+anterior+");\">&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Elimina Sub Cat\" onclick=\"eliminaSub('"+nombre_sub+"')\"></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><table id=\""+nombre_sub+"\" cellpadding=\"0\" cellspacing=\"0\"></table></td></tr></table>";
}

function eliminaCategoria(){
largo=document.getElementById('tabla_categoria').rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById('tabla_categoria').rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById('tabla_categoria').deleteRow(largo);
			}else{
				document.getElementById('tabla_categoria').rows[largo].className="normal";
			}

	}
}

function eliminaSub(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById(subcate).deleteRow(largo);
			}else{
				document.getElementById(subcate).rows[largo].className="normal";
			}
		}
}

function eliminaItems(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
//		alert ("hola");
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
		if (a==true){
			var x=document.getElementById(subcate).deleteRow(largo);
		}else{
			document.getElementById(subcate).rows[largo].className="normal";
		}
	}
}

</script>	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					  	 $menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%"><tr><td valign="top">
						<div id="cont"></div>
                              
                            </td></tr></table>                         </td>

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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

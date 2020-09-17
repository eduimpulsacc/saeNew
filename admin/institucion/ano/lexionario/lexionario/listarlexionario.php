<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<?
require('../../../../util/header.inc');
//include ("../calendario/calendario.php");

	$cmb_curso = $_REQUEST[id_curso];
    $id_ramo  = $_REQUEST[id_ramo];
	

	$institucion	=$_INSTIT;
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
	
  
   	
	$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '".$_ANO."'";
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_ano'];
	?>
	
<?
function generaCurso($ano,$conn)
	{
	
	
	
	$sql="select id_curso from curso where id_ano=".$ano;
	$sql = $sql."ORDER BY  curso.ensenanza, curso.grado_curso, curso.letra_curso ASC";
	$rs_curso= pg_exec($conn, $sql) or die ("select fallo:".$sql);
	
	echo "<select name='cmb_curso' id='cmb_curso' onChange='cargaContenido(this.id)'>";
	
	echo "<option value='0'>Elige</option>";
	for($i=0; $i< pg_numrows($rs_curso); $i++){
	$fila= pg_fetch_array($rs_curso,$i);
	$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	echo "<option value='".$fila['id_curso']."'>".$Curso_pal."</option>";
	}
	echo "</select>";
	
	
	
	}

	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<style type="text/css">
	body.a{
		/*
		You can remove these four options 
		
		*/
		background-repeat:no-repeat;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
		margin:0px;
		

	}
	#ad{
		padding-top:220px;
		padding-left:10px;
	}
	
</style>
	

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
}</style>
-->
<style type="text/css" media="screen, projection">

  tr.tdsea { 
    background-color: #ebf3ff;
	color: #000000; 
	cursor:pointer; 
	}
  
  tr.hilite { 
  	background-color:#FFFF99;
	color: #000000;
	cursor:pointer;
	
	 }
			
 div.ui-datepicker{
    font-size:14px;

    }
  

</style><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=latin9">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js" > </script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js" > </script>

<!--<script language="JavaScript" src="../../../../clases/jquery.ui.core.js"></script>-->
<!--<script language="JavaScript" src="../../../../clases/jquery.ui.datepicker-es.js"></script>-->
<!--<script language="JavaScript" src="../../../../clases/jquery.ui.datepicker.js"></script>-->
<!--<script language="JavaScript" src="../../../../clases/jquery.ui.widget.js"></script>-->

<script language="JavaScript" src="../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script language="JavaScript" src="../../../clases/jqueryui/jquery.ui.core.js"></script>

<script language="JavaScript" src="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" src="../../../clases/jqueryui/jquery.ui.datepicker.js"></script>

<script type="text/javascript" src="select_dependientes.js"> </script>
<!--<script type="text/javascript" language="javascript" src="select.js"></script>
--><!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" ></script>-->



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
function abrirdialog(){

   var cmb_curso=document.form.cmb_curso.value;
   var cmb_ramo=document.form.cmb_ramo.value;
	
  var parametros='id_curso='+cmb_curso+'&id_ramo='+cmb_ramo;
    		   // alert(parametros);
    $.ajax({
			
	  url:'mostrard.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	     
	    $("#dialogo").html(data);
		
			   $("#dialogo").dialog({
				  modal: true,
				  title: "Tipo Lexionario:",
				  width: 800,
				  minWidth: 400,
				  maxWidth: 700,
				  show: "fold",
				  hide: "scale"
			   });
		  }
	  })
												
					
  }
  $("#listalexionario.tdsea").hover(function () {
      $(this).addClass("hilite");
  }, function () {
      $(this).removeClass("hilite");
	  
	  
  });
//-->


//-->>
// FIN FUNCION  

function enviapag(form){

document.form.action= 'listarlexionario.php';
document.form.submit(true);
}

/*function enviapagg(x){


	if(document.form.cmb_ramo.value==0){
		alert('Seleccione un Ramo.');
		return false;
	};

	
    if ( x == 0 )
	   { var Cuenta = 0;
	    }
	else { var Cuenta = x;
		}


	var curso=document.form.cmb_curso.value;
	var ano=document.form.cmb_ramo.value;
	
	document.form.submit(true);
	

}
*/
function elimina_lexionario(xidlex){ 
		
	if(!confirm('¿Desea Eliminar Este Registro?'))
       { 
	     return false; 
	   }
	else
	   {	
	   
	     var parametros = "xidlex="+xidlex;
	    //alert(parametros);
		 
		  	$.ajax({
		 		  url:'elimina_lexionario.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
				  
				  alert(data);
				  
			  if (data==1){ 
				
				alert("Se ha eliminado El Registro"); 
				
				cargadatos();
			
				
					      } 
		 			  } 
		 		  })
	   }
	   
} // FIN FUNCION  


function cargadatos(){

var id_curso = $("#cmb_curso").val();
var id_ramo = $("#cmb_ramo").val();

parametros = 'id_ano='+<?=$ano?>+'&id_curso='+id_curso+'&id_ramo='+id_ramo;
//alert(parametros);
var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
    x = x+'<img src="../../../clases/img_jquery/ajax-loader.gif"><br><br><br><br><br><br><br>';
	$("#tabledata").html(x);
$.ajax({
url:'cargatable.php',
data:parametros,
type:'POST',
	success:function(data){
	   $("#tabledata").html(data);
	   
	  
	} 
})
				  

}

function pruebalex(id_lex){
var id_curso = $("#cmb_curso").val();
var id_ramo = $("#cmb_ramo").val();

parametros = 'id_lexionario='+id_lex+'&frmModo=modificar&id_curso='+id_curso+'&id_ramo='+id_ramo;

//alert(parametros);

$.ajax({
url:'pruebalex.php',
data:parametros,
type:'POST',
	success:function(data){
	   $("#tabledata").html(data);
	} 
})
				  

}

function pruebalexag(){

if(document.form.cmb_curso.value==0){
		alert('Seleccione un Curso.');
		return false;
	};

	if(document.form.cmb_ramo.value==0){
		alert('Seleccione un Ramo.');
		return false;
	};

var id_curso = $("#cmb_curso").val();
var id_ramo = $("#cmb_ramo").val();

parametros = 'frmModo=agregar&id_curso='+id_curso+'&id_ramo='+id_ramo;

//alert(parametros);

$.ajax({
url:'pruebalex.php',
data:parametros,
type:'POST',
	success:function(data){
	   $("#tabledata").html(data);
	} 
})
	
	
	
}

function valida(){


	if(document.form.txt_obser.value.length==0){
		alert('Ingrese Descripción.');
		return false;
	};

	if(document.form.cmb_tipo.value==0){
		alert('Ingrese Tipo.');
		return false;
	};

	if(document.form.cmb_nota.value==0){
		alert('Ingrese Nota.');
		return false;
	};
	
	 
	var var1 = $("#txt_obser").val();
	var var2 = $("#cmb_tipo").val();
	var var3 = $("#cmb_nota").val();
	var var4 = $("#cmb_curso").val();	
	var var5 = $("#cmb_ramo").val();
	var var6 = $("#theDate").val();
			
 parametros='txt_obser='+var1+'&cmb_tipo='+var2+'&cmb_nota='+var3+'&curso='+var4+'&ramo='+var5+'&theDate='+var6+'&frmModo=ingresar';

//alert(parametros);

$.ajax({
url:'procesoLexionario.php',
data:parametros,
type:'POST',
	success:function(data){
	
	//alert(data);
	
		if(data==1){
			alert('Datos Guardados ');
			
		}else{
			alert( 'Error : '+data ); 
		}
	  // $("#tabledata").html(data);
	} 
})

cargadatos();
}

function validag(id){

    var var1 = $("#theDate").val();
	var var2 = $("#cmb_tipo").val();
	var var3 = $("#cmb_nota").val();
	var var4 = $("#txt_obser").val();
		
		
	var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
    x = x+'<img src="../../../clases/img_jquery/ajax-loader.gif"><br><br><br><br><br><br><br>';
	$("#tabledata").html(x);
		
	parametros='theDate='+var1+'&cmb_tipo='+var2+'&cmb_nota='+var3+'&txt_obser='+var4+'&frmModo=modificar&idlex='+id;
//alert(parametros);


$.ajax({
url:'procesoLexionario.php',
data:parametros,
type:'POST',
	success:function(data){
		if(data==1){
			alert('Datos modificados');
			
		}else{
			alert( 'Error : '+data ); 
		}
	  // $("#tabledata").html(data);
	} 
})
cargadatos();
}


function validatipo(){

	/*if(document.form.txt_tipo.value.length==0){
		alert('Ingrese Tipo.');
		return false;
	};*/

	var var1 = $("#txt_tipo").val();
	var var2 = <?=$ano?>;
	var var3 = $("#cmb_curso").val();
	var var4 = $("#cmb_ramo").val();
	
	/*".$ano.",".$curso.",".$ramo.",'".$fecha."','".$obser."',".$tipo.",".$nota.")";*/
	

	parametros = 'txt_tipo='+var1+'&id_ano='+var2+'&curso='+var3+'&ramo='+var4+  '&frmModo=ingresatipo';
   //alert(parametros);

$.ajax({
url:'procesoLexionario.php',
data:parametros,
type:'POST',
	success:function(data){
		if(data==1){
		
			alert('Datos Guardados');
			 
			cerrar();
			
		}else{
			alert( 'Error : '+data ); 
			
		}
		
	}
	

})
}

function cerrar(){
$('#dialogo').dialog('close');
}
/********************************************************************************/


//-->>
// FIN FUNCION  
</script>

<body onLoad="cargadatos()">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3; 
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
				<table width="100%" align="center">				 
	<td align="middle" colspan="6" class="tableindex">Lexionario</td></tr></table>
	<form name="form" id="form" action="procesoLexionario.php"  method="post">
	<input type="hidden" name="ingresar" value="agregar" /> 
	
	
<br>
  <table cellpadding="5" cellspacing="0">
  <tr>
  <td height="15" class="textonegrita">CURSO</td>
  <td class="textonegrita">:</td>
 
  <td>
		 	 <?php generacurso($ano,$conn);?>		
		 	
 </td>
 
</tr>
<tr>
<td height="15" class="textonegrita">ASIGNATURA</td>
<td class="textonegrita">:</td>
<td>
   
   <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql="select id_ramo, ramo.cod_subsector, subsector.nombre
from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector
where id_curso=".$cmb_curso; 
$rs_apo=@pg_exec($conn,$sql);
                 ?>
				 
		 
<select disabled="disabled" name="cmb_ramo" class="ddlb_x" id="cmb_ramo" >
<option value="0">Selecciona opci&oacute;n...</option>
</select>				  
		  
   </td>
		  
<td>
<input class="botonXX" Type="button"  value="AGREGAR" onClick="pruebalexag();" name="agregar"></td>
 
</tr>
 </table>
 
					    	

<br />

<!--INICIO -->

<div id="dialogo" ></div>

<div id="tabledata">
<table id="listalexionario" width="65%" class="tablatit2-1" cellspacing="1" cellpadding="0"
border="0" style="border-collapse:collapse" >
 <tr align="left" style="border:solid" >
	</tr>
	<tr > 
	  <td align="center" class="tablatit2-1"> 
	  FECHA </td>
	  <td align="center" class="tablatit2-1"> 
		DESCRIPCION </td>
	  <td align="center" class="tablatit2-1"> 
		TIPO</td>
	  <td align="center" class="tablatit2-1"> 
		CASILLERO </td>
		<td ALIGN=CENTER class="tablatit2-1">&nbsp;</td>
	</tr>
</table>
</div>






</form>
	
								 
								  <!-- FIN DEL NUEVO CÓDIGO -->                                  </td>
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
</tr>
</tr>

</div>

</body>
</html>

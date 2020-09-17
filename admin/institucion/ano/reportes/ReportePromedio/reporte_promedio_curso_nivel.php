 <?php
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_Reporte.php');

	
	
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	
	$reporte		=$c_reporte;
	$_POSP = 5;  
	$_bot = 8;

	


$qry_url = "select * from salida where rdb = '$institucion'";
    $result_2 =pg_Exec($conn,$qry_url);
    $fila_1 = @pg_fetch_array($result_2,0);	
	$web = $fila_1['direccion'];


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
		var id_ano="<?=$ano?>"
		anos_acad();
		//carga_periodo(id_ano);
      });

</script>



	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.mayuscula{text-transform:uppercase;}
-->
    </style>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">

	function anos_acad(){
		var rdb="<?=$institucion;?>"
		 funcion=0;
	var parametros='funcion='+funcion+'&rdb='+rdb;
	//alert(parametros);	 
	$.ajax({
	  url:'cont_reporte_promedio_curso_nivel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#select_ano").html(data);
		  }
	  })
	} 
	
		
	function carga_nivel(){
		var id_ano="<?=$ano;?>"
		 funcion=1;
	var parametros='funcion='+funcion+'&id_ano='+id_ano;
	//alert(parametros);	 
	$.ajax({
	  url:'cont_reporte_promedio_curso_nivel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
	    $("#select_nivel").html(data);
		  }
	  })
	} 
	
	
	
function carga_curso(id_nivel){
	
	var id_ano = $('#select_anos').val();
	var funcion =2;
	var parametros='funcion='+funcion+'&id_ano='+id_ano+'&id_nivel='+id_nivel;
	//alert(parametros);
		$.ajax({
	  url:'cont_reporte_promedio_curso_nivel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
	    $("#select_curso").html(data);
		carga_asignaturas_nivel(id_nivel)
		// var ano=$('#select_anos').val();
		 //$("#select_anos option[value="+ano+"]").attr("selected",true);
		 
		  }
	  })
	}
	
	
	function carga_asignatura(id_curso){
	
	var id_ano = $('#select_anos').val();
	var funcion =3;
	var parametros='funcion='+funcion+'&id_curso='+id_curso;
	//alert(parametros);
		$.ajax({
	  url:'cont_reporte_promedio_curso_nivel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
	    $("#select_ramos").html(data);
		// var ano=$('#select_anos').val();
		 //$("#select_anos option[value="+ano+"]").attr("selected",true);
		 
		  }
	  })
	}
	
	function carga_asignaturas_nivel(id_nivel){
		
		var funcion=4;
		var id_ano=$('#select_anos').val();
		var parametros='funcion='+funcion+'&id_nivel='+id_nivel+'&id_ano='+id_ano;
	//alert(parametros);
		$.ajax({
	  url:'cont_reporte_promedio_curso_nivel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//	 alert(data);
	    $("#select_ramos").html(data);
		  }
	  })
	}
	
	
	
	function carga_alumnos(id_curso){

		var funcion="carga_alumnos";
		var id_ano=$('#select_anos').val();
		var parametros='funcion='+funcion+'&id_curso='+id_curso+'&id_ano='+id_ano;
	//alert(parametros);
		$.ajax({
	  url:'cont_reporte_promedio_curso_nivel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//	 alert(data);
	    $("#select_alumno").html(data);
		  }
	  })
	}
		
		
	
function validaform(){
	
	
		if($('#select_anos').val()==0){
		alert("Seleccione Año Escolar");
		return false;
		}
		
	if($('#select_niveles').val()==0){
		alert("Seleccione niveles");
		return false;
		}	
		
		
		if($('#select_ramos_niveles').val()==0){
		alert("Seleccione Asignatura");
		return false;
		}	
		
	if($('#select_asignatura').val()==0){
		alert("Seleccione Asignatura");
		return false;
		}			
		
	if($('#txt_nota').val()==""){
		alert("Escriba una Nota");
		$('#txt_nota').focus();
		return false;
		}	
					
	document.form.submit(); 
	document.form.action='print_reporte_promedio_curso_nivel.php';
	
	//RecargaPagina();
	}
	
	
	function RecargaPagina(){
		location.reload();
		//$('#form')[0].reset();
}
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}

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
//-->
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../../cabecera/menu_superior.php");
				?>
</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../../menus/menu_lateral.php");
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
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <div id="layer2"></div>
<br>
<form name="form" id="form" method="post" action="print_promedios_insuficientes_curso.php" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">

  <center>
    <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
      </tr>
       <tr>
      <td>Año</td>
      <td><div id="select_ano"><select name="select_ano" >
      <option>Seleccionar</option>
      </select></div></td>
    </tr> <tr>
      <td>Nivel</td>
      <td><div id="select_nivel"><select name="select_nivel" >
      <option>Seleccionar</option>
      </select></div></td>
    </tr>
    <tr>
      <td>Curso</td>
      <td><div id="select_curso"><select name="select_curso" >
      <option>Seleccionar</option>
      </select></div></td>
    </tr>
     <tr>
      <td>Asignatura</td>
      <td><div id="select_ramos"><select name="select_ramo" >
      <option>Seleccionar</option>
      </select></div></td>
    </tr>
    <tr>
      <td colspan="2"><div id="lista_ramos">&nbsp;
           </div></td>
    </tr>
    
    <tr class="cuadro01">
    <td>Nota</td>
    <td>
      <div align="left">
        <input name="orden" type="radio" value="0" checked>
      Menor &nbsp; 
      <input name="orden" type="radio" value="1">
      Mayor &nbsp;&nbsp;&nbsp;A:&nbsp;
        <input name="txt_nota" id="txt_nota" type="text" size="2" maxlength="2">
        </div></td>
        </tr>
    
    
    <tr>
      <td colspan="2"><div align="center">
        <label>
        <input name="BUSCAR" type="button" id="BUSCAR" value="BUSCAR" class="botonXX" onClick="validaform()">
        </label>
      <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver" onClick="window.location='../Menu_Reportes_new2.php'"></div></td>
      </tr>
  </table>  
</center>
</form>

								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
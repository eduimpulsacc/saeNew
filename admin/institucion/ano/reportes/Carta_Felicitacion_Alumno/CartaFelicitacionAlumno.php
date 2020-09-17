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
if ($cmb_curso>0){
   $q1 = "SELECT * from institucion where rdb = '".trim($_INSTIT)."'";
   $r1 = @pg_Exec($conn,$q1);
   $n1 = @pg_numrows($r1);
    
   
   
    $qryEMP="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultEMP =@pg_Exec($conn,$qryEMP);
	if (!$resultEMP) {
	    error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
	     if (pg_numrows($resultEMP)!=0){//En caso de estar el arreglo vacio.
				$filaEMP = @pg_fetch_array($resultEMP,0);
				$nombre_director  =	$filaEMP['nombre_emp'];
				$nombre_director .= $filaEMP['ape_pat'];
				$nombre_director .= $filaEMP['ape_mat'];
				$ciudad           = $filaEMP['ciudad'];                
		 }
	}
	/// aqui determino el curso elegio
	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.id_curso = '".trim($cmb_curso)."'";
	$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	$resultado_query_cue = pg_exec($conn,$sql_curso);
	//------------------
	$sql_peri = "select * from periodo where id_ano = ".$ano;
	$result_peri = pg_exec($conn,$sql_peri);
    
	$fila = @pg_fetch_array($resultado_query_cue,0); 
	$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	/// fin curso elegido
	
	// ahora tomo el nombre  del apoderado
	//$rs = @pg_Exec($conn,$sq);
	//$ns = @pg_numrows($rs);
	 
}

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
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		var ano=<?=$ano?>;
		//alert(ano);
		 anos_acad();
		 carga_curso(ano);
      });
	  
	  function anos_acad(){
		  //alert("llego");
		  var rdb=<?=$institucion;?>;
		var funcion=1; 
		var parametros='funcion='+funcion+'&rdb='+rdb;
		//alert(parametros);	 
		$.ajax({
		  url:'Cont_CartaFelicitacionAlumno.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
			 // alert(data);
			$("#ano_acad").html(data);
			  }
		  })
		 }


function carga_curso(id_ano){
	//var ano = $('#select_anos').val();
	var perfil = <?=$_PERFIL;?>;
	var curso = $("#select_curso").val();
	var usuario = "<?=$_NOMBREUSUARIO;?>";
	var rdb = <?=$_INSTIT;?>;
	var funcion =2;
	var parametros='funcion='+funcion+'&id_ano='+id_ano+"&perfil="+perfil+"&curso="+curso+"&usuario="+usuario+"&rdb="+rdb;
	//alert(parametros);
		$.ajax({
	  url:'Cont_CartaFelicitacionAlumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
		 //alert(data);
	    $("#select_curso").html(data);
		 var ano=$('#select_anos').val();
		 $("#select_anos option[value="+ano+"]").attr("selected",true);
		 
		  }
	  })
	}
	
	
	function carga_ramos(id_curso){
		
		var funcion="carga_ramos";
		
		var parametros='funcion='+funcion+'&id_curso='+id_curso;
	//alert(parametros);
		$.ajax({
	  url:'Cont_CartaFelicitacionAlumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//	 alert(data);
	    $("#lista_ramos").html(data);
		  }
	  })
	}
		
		
function dime_valor(id_ramo){
	
	//alert(id_ramo);
}		

function validanota1(){
	var prom_gral=$("#prom_gral").val();
	if(prom_gral.length==2){
		if(isNaN($("#prom_gral").val())){
		alert("Ingrese solo Numeros");
		$("#prom_gral").val("");
	}
	if($("#prom_gral").val() > 70){
		alert("La Nota no puede ser Mayor a 70");
		$("#prom_gral").val("");
	}
	if($("#prom_gral").val() <= -0){
		alert("la Nota no puede ser Negativa");
		$("#prom_gral").val("");
	}
	
	
	}
}

function validanota2(){
	var prom_ramos=$("#prom_ramos").val();
	if(prom_ramos.length==2){
		if(isNaN($("#prom_ramos").val())){
		alert("Ingrese solo Numeros");
		$("#prom_ramos").val("");
	}
	if($("#prom_ramos").val() > 70){
		alert("La Nota no puede ser Mayor a 70");
		$("#prom_ramos").val("");
	}
	if($("#prom_ramos").val() <= -0){
		alert("la Nota no puede ser Negativa");
		$("#prom_ramos").val("");
	}
	}
}

function validanota3(){
	var not_religion=$("#not_religion").val();
	
	var not_religion2=$("#not_religion").text();
	if(not_religion.length==2){
		if(!isNaN($("#not_religion").val())){
		alert("Ingrese Nota Conceptual (No Numeros)");
		$("#not_religion").val("");
	}
	}
}


function validaform(){
	
	if($('#select_cursos').val()==0){
		alert("Seleccione Curso");
		return false;
		}
		
	if($('#prom_gral').val()==""){
		alert("Escriba Promedio General");
		$('#prom_gral').focus();
		return false;
		}	
		
		if($('#prom_ramos').val()==""){
		alert("Escriba Promedio de Ramos");
		$('#prom_ramos').focus();
		return false;
		}			
		
		if($('#not_religion').val()==""){
		alert("Escriba Promedio de Religion");
		$('#not_religion').focus();
		return false;
		}	
					
	

	form.target = "_blank";
	form.action='Print_Informe_CartaFelicitacionAlumno.php?cb_ok=Buscar';
	document.form.submit(); 
	//RecargaPagina();
	}
	
	
	function RecargaPagina(){
		location.reload();
		//$('#form')[0].reset();
}

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

	/*function anos_acad(){
		var rdb=<?=$institucion;?>;
		var funcion=1; 
		var parametros='funcion='+funcion+'&rdb='+rdb;
		alert(parametros);	 
		$.ajax({
		  url:'Cont_CartaFelicitacionAlumno.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
			  alert(data);
			$("#ano_acad").html(data);
			  }
		  })
		} 
	
function carga_curso(id_ano){
	//var ano = $('#select_anos').val();
	var perfil = <?=$_PERFIL;?>;
	var curso = <?=$_CURSO;?>;
	var usuario = <?=$_NOMBREUSUARIO;?>;
	var rdb = <?=$_INSTIT;?>;
	var funcion =2;
	var parametros='funcion='+funcion+'&id_ano='+id_ano+"&perfil="+perfil+"&curso="+curso+"&usuario="+usuario+"&rdb="+rdb;
	alert(parametros);
		$.ajax({
	  url:'Cont_CartaFelicitacionAlumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		 alert(data);
	    $("#select_curso").html(data);
		 var ano=$('#select_anos').val();
		 $("#select_anos option[value="+ano+"]").attr("selected",true);
		 
		  }
	  })
	}
	
	
	function carga_ramos(id_curso){
		
		var funcion="carga_ramos";
		
		var parametros='funcion='+funcion+'&id_curso='+id_curso;
	//alert(parametros);
		$.ajax({
	  url:'Cont_CartaFelicitacionAlumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//	 alert(data);
	    $("#lista_ramos").html(data);
		  }
	  })
	}
		
		
function dime_valor(id_ramo){
	
	//alert(id_ramo);
}		

function validanota1(){
	var prom_gral=$("#prom_gral").val();
	if(prom_gral.length==2){
		if(isNaN($("#prom_gral").val())){
		alert("Ingrese solo Numeros");
		$("#prom_gral").val("");
	}
	if($("#prom_gral").val() > 70){
		alert("La Nota no puede ser Mayor a 70");
		$("#prom_gral").val("");
	}
	if($("#prom_gral").val() <= -0){
		alert("la Nota no puede ser Negativa");
		$("#prom_gral").val("");
	}
	
	
	}
}

function validanota2(){
	var prom_ramos=$("#prom_ramos").val();
	if(prom_ramos.length==2){
		if(isNaN($("#prom_ramos").val())){
		alert("Ingrese solo Numeros");
		$("#prom_ramos").val("");
	}
	if($("#prom_ramos").val() > 70){
		alert("La Nota no puede ser Mayor a 70");
		$("#prom_ramos").val("");
	}
	if($("#prom_ramos").val() <= -0){
		alert("la Nota no puede ser Negativa");
		$("#prom_ramos").val("");
	}
	}
}

function validanota3(){
	var not_religion=$("#not_religion").val();
	
	var not_religion2=$("#not_religion").text();
	if(not_religion.length==2){
		if(!isNaN($("#not_religion").val())){
		alert("Ingrese Nota Conceptual (No Numeros)");
		$("#not_religion").val("");
	}
	}
}


function validaform(){
	
	if($('#select_cursos').val()==0){
		alert("Seleccione Curso");
		return false;
		}
		
	if($('#prom_gral').val()==""){
		alert("Escriba Promedio General");
		$('#prom_gral').focus();
		return false;
		}	
		
		if($('#prom_ramos').val()==""){
		alert("Escriba Promedio de Ramos");
		$('#prom_ramos').focus();
		return false;
		}			
		
		if($('#not_religion').val()==""){
		alert("Escriba Promedio de Religion");
		$('#not_religion').focus();
		return false;
		}	
					
	

	document.form.submit(); 
	form.action='Print_Informe_CartaFelicitacionAlumno.php?cb_ok=Buscar';
	RecargaPagina();
	}
	
	
	function RecargaPagina(){
		location.reload();
		//$('#form')[0].reset();
}*/
									
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
<form name="form" id="form" method="post" action="Print_Informe_CartaFelicitacionAlumno.php" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">

  <center>
    <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
      </tr>
      <tr>
      <td width="29%">Año Académico</td>
      <td width="71%">
      <div id="ano_acad">
      <select name="select_ano" >
      <option>Seleccionar</option>
      </select>
      </div></td>
    </tr>
    <tr>
      <td>Curso</td>
      <td><div id="select_curso"><select name="select_curso" >
      <option>Seleccionar</option>
      </select></div></td>
    </tr>
    <tr>
      <td colspan="2"><div id="lista_ramos">&nbsp;
           </div></td>
    </tr>
    
     <tr>
      <td width="29%">Promedio General</td>
      <td width="71%"><input type="text" name="prom_gral" id="prom_gral" size="2" maxlength="2"  onKeyUp="validanota1()"></td>
    </tr>
	     
     <tr>
      <td width="29%">Promedio Ramos</td>
      <td width="71%"><input type="text" name="prom_ramos" id="prom_ramos" size="2" maxlength="2" onKeyUp="validanota2()"></td>
    </tr>
    
    <tr>
      <td>Religión</td>
      <td><input type="text" class="mayuscula"  name="not_religion" id="not_religion" size="2" maxlength="2" onKeyUp="validanota3()"></td>
    </tr>
    
     <tr>
      <td width="29%">Promedios Rojos</td>
      <td width="71%">Si:<input type="radio" name="prom_rojo" id="prom_rojo" value="0" checked>
      No:<input type="radio" name="prom_rojo" id="prom_rojo" value="1" ></td>
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
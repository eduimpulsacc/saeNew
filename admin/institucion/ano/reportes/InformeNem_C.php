<?php
require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');

$institucion = $_INSTIT;
$ano		 = $_ANO;
$curso       = $cmb_curso;
$reporte	 = $c_reporte;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

	
<SCRIPT language="JavaScript">
<!--

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function window_open(url,ancho,alto){
var opciones="left=100,top=100,width="+ancho+",height="+alto+",scrollbars=yes,resizable=yes,status=yes", i= 0;
 window.open(url,"aa",opciones); 
 }

//-->
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
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

//-->
       function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../seteaAno.php3?caso=10&pa=14&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }//-->
		 
		
		 
		 function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.target="_parent";
		form.action = 'InformeNem_C.php';
		form.submit(true);
	}	
}



function act(){
	
	
	var alu  = document.getElementById("c_alumno").value;
	var cur  = document.getElementById("cmb_curso").value;
	
	/* if (cur!=0 && alu!=0){
		 document.getElementById("individual").checked=true;
	}
	*/
	
	
	var opt = document.getElementById("individual").checked;
	//alert(opt);
	
	
	
	//var ruta = "printInformeNem_C.php";
	if(alu==0 && opt==false){
		var ruta = "printInformeNem_C.php";
	}
	else if(alu==0 && opt==true){
		var ruta = "printInformeNem_C2.php";
	}
	else if(alu!=0){
		var ruta = "printInformeNem_C2.php";
	}

	/*if(opt==false){
		var ruta = "printInformeNem_C.php";
	}
	else if(alu==0 && opt==false ){
		var ruta = "printInformeNem_C.php";
	}
	else if(alu==0 && opt==true ){
		var ruta = "printInformeNem_C2.php";
	}
	else{
		var	ruta = "printInformeNem_C2.php";
	}*/
	form.target="_blank";
		form.action = ruta;
	//	form.submit(true);


}
</script>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg');"  >

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
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
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
 
<form method="post" action="printInformeNem_C.php" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
	$tipo = "310,410,510";
	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano =$ano;
	$ob_motor ->Ensenanza =$tipo;
	$ob_motor ->grado =4;
	$resultado_query_cue = $ob_motor ->curso_ensenanza($conn);
	
?>
<center>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" valign="top">
	  <table width="90%" height="43" border="0" cellpadding="0" cellspacing="0" class="textosimple" align="center">
  <tr>
    <td width=""  class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27"  class="cuadro01">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
 	<tr class="textosimple">
	<td colspan="2" class="cuadro01"><br>
	  Curso<br>
	  <font size="1" face="arial, geneva, helvetica">
      <select name="cmb_curso" id="cmb_curso"  class="ddlb_9_x"onChange="enviapag(this.form);" >
        <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
		  
		  	  $fila = @pg_fetch_array($resultado_query_cue,$i); 
			  $ensenanza = $fila['ensenanza'];
			  if ($fila["id_curso"]==$cmb_curso){
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option selected value=".$fila['id_curso'].">".$Curso_pal.$fila['id_curso']."</option>";
			  }else{
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			  }
          } ?>
      </select>
      <br>
	  </font></td>
    </tr>
   <?php  //if($_PERFIL==0){?>
 	<tr class="textosimple">
 	  <td colspan="2" class="cuadro01">&nbsp;</td>
 	  </tr>
 	<tr class="textosimple">
 	  <td colspan="2" class="cuadro01">Alumno<br>
      <select name="c_alumno" id="c_alumno" class="ddlb_9_x" onChange="act();">
        <option value=0 selected>(Todos los Alumnos)</option>
        <?
			$ob_alumno = new MotorBusqueda();
			$ob_alumno ->ano = $ano;
			$ob_alumno ->cmb_curso = $cmb_curso;
			$ob_alumno ->rdb = $institucion;
			$result_alumno = $ob_alumno -> alumno($conn);
			
		for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++){
			$fila = @pg_fetch_array($result_alumno,$i);
			$rutalumno = $fila["rut_alumno"];
			if ($rutalumno == $c_alumno){
		?>
        <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>	><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
        <? }else{ ?>
        <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
        <?
	       }
		}
		?>
      </select>
      </td>
 	  </tr>
 	<tr class="textosimple">
 	  <td colspan="2" class="cuadro01">&nbsp;</td>
 	  </tr>
 	<tr class="textosimple">
 	  <td colspan="2" class="cuadro01"><input type="checkbox" name="individual" id="individual" onClick="act();" >
 	    Reporte Individual por alumno</td>
 	  </tr>
 	<tr class="textosimple">
 	  <td colspan="2" class="cuadro01">&nbsp;</td>
 	  </tr>
	<?php //  }?>
	<tr>
	  <td width="107" class="cuadro01">&nbsp;</td>
	  <td width="592" class="cuadro01">
      <?php //$tipo=($_PERFIL==0)?"submit":"submit"; ?>
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar" onclick="act()">
	 	<? if($_PERFIL == 0){?>
	  <input name="cb_ex" type="submit" class="botonXX"  id="cb_ex"  value="Exportar">
	  	<? }?>
	    <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
	  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>

 								  								  
								  </td></tr>
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
</body>
</html>
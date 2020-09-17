<?php
require('../../../../util/header.inc');
$query_ins_ano="select rdb,dig_rdb, nombre_instit from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'"; //revisar
$row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));


$institucion = $_INSTIT;
$ano		 = $_ANO;
$curso       = $cmb_curso;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
td{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	font-style: normal;
	font-weight: normal;
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
.Estilo1 {font-size: 10px}
-->
    </style>
	
<SCRIPT language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
		 }


</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')"  >

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
                                  <td>
								  <table width="700" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#FF0000">
                                    <tr>
                                      <td><strong>Importante:</strong> <br>
                                        <br>
                                        Para obtener la informaci&oacute;n de este reporte, primero debe LISTAR EL REPORTE NRO. 24, CONCENTRACI&Oacute;N DE NOTAS, con la opci&oacute;n &quot;Todos los alumnos&quot;, dicho reporte demor&aacute; entre 15 a 20 minutos en la entrega de la informaci&oacute;n.<br>
                                        <br>
                                        Una vez que halla hecho lo anterior podr&aacute; listar este reporte con la informaci&oacute;n del Demre.<br>
                                        <br>
                                        Para cualquier consulta comunicarse al fono: (56 2 - 465 3350). </td>
                                    </tr>
                                  </table>
								  <?
								  if (isset($cb_ok)){  ?>
								  
                                   <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                      <tr>
                                        <td colspan="5"><div align="right">
                                          <label></label>
                                          <label>
                                          <input name="Submit2" type="button" onClick="MM_goToURL('parent','Resumen_4_medios2_excel.php?curso=<?=$curso ?>');return document.MM_returnValue" value="Exportar a Excel" class="botonXX">
                                          <input name="Submit" type="button" onClick="MM_openBrWindow('printResumen_4_medios.php?curso=<?=$curso ?>','','resizable=yes,width=600,height=500')" value="Imprimir" class="botonXX">
                                          </label>
                                        </div></td>
                                      </tr>
									  <?
										$Curso_pal = CursoPalabra($curso, 1, $conn);
									  ?>
                                      <tr>
                                        <td colspan="5"><div align="center">Curso: <?=$Curso_pal ?></div></td>
                                      </tr>
                                      <tr>
                                        <td width="20%"><div align="left">Rut</div></td>
                                        <td width="45%"><div align="left">Nombre</div></td>
                                        <td width="10%"><div align="center">Suma</div></td>
                                        <td width="10%"><div align="center">Cantidad</div></td>
                                        <td width="15%"><div align="center">Ponderaci&oacute;n</div></td>
                                      </tr>
									  <?
									  $qry="SELECT matricula.bool_ar, matricula.total_notas, suma_pond, pond_demre, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$_ANO.")) and bool_ar='0'  order by nro_lista asc, ape_pat, ape_mat, nombre_alu asc";
				                      $result =@pg_Exec($conn,$qry);
									  $num_res = @pg_numrows($result);
									  for ($j = 0; $j < $num_res; $j++){								  
											$fil_res = pg_fetch_array($result,$j);
											$nombre_alu = $fil_res['nombre_alu'];
											$ape_pat    = $fil_res['ape_pat'];
											$ape_mat    = $fil_res['ape_mat'];
											$rut_alumno = $fil_res['rut_alumno'];
											$dig_rut    = $fil_res['dig_rut'];
											$total_notas  = $fil_res['total_notas'];
											$suma_pond    = $fil_res['suma_pond'];
											$pond_demre   = $fil_res['pond_demre'];
											  
											///// AQUI DEJAR EN UN ARREGLO TODOS LOS SUBSECTORES DEL ALUMNO EN LA ENSEÑANZA MEDIA ////
										  
										  
										    ?>											  
										    <tr>
											<td><span class="Estilo1"><? echo "$rut_alumno-$dig_rut"; ?></span></td>
											<td><span class="Estilo1"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></span></td>
											<td><div align="right" class="Estilo1"><? echo "$suma_pond"; ?></div></td>
											<td><div align="right" class="Estilo1"><? echo "$total_notas"; ?></div></td>
										    <td><div align="right"><?=$pond_demre ?></div></td>
										    </tr>
										    <?
										    									   
									   }  /// fin for contador de alumnos
									?>								  
                                   </table>
      							<? } ?>

<br>
<form method "post" action="Resumen_4_medios2.php">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.ensenanza > 300 and curso.grado_curso='4' ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";

$resultado_query_cue = pg_exec($conn,$sql_curso);

?>
<center>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" valign="top">
	  <table width="100%" height="43" border="0" cellpadding="0" cellspacing="0" class="textosimple">
  <tr>
    <td width=""  class="fondo">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
 	<tr class="textosimple">
	<td colspan="2" class="cuadro01"><br>
	  Curso<br>
	  <font size="1" face="arial, geneva, helvetica">
      <select name="cmb_curso"  class="ddlb_9_x" >
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
	
	<tr>
	  <td width="107" class="cuadro01">&nbsp;</td>
	  <td width="592"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar"></td>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007</td>
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
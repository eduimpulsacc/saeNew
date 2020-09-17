<?php require('../../../../util/header.inc');
//setlocale(LC_ALL,"es_ES");
$query_ins_ano="select rdb,dig_rdb, nombre_instit from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'"; //revisar
$row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));
///////////////////
$institucion = $_INSTIT;
$ano		 =$_ANO;
$curso       = $cmb_curso;
$rut_alumno  = $cmb_alumno;


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
-->
    </style>
	
<SCRIPT language="JavaScript">
<!--




function imprimir(){
Element = document.getElementById("botones");
Element.style.display='none';
Element = document.getElementById("motor");
Element.style.display='none';
Element = document.getElementById("menu");
Element.style.display='none';
window.print();
Element = document.getElementById("botones");
Element.style.display='';
Element = document.getElementById("motor");
Element.style.display='';
Element = document.getElementById("menu");
Element.style.display='';

}
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'concentracionnotas_nueva.php';
				form.submit(true);
	
				}	
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
                      <td width="73%" align="left" valign="top">
					  <?
					  if ($buscar){ 
					        if ($rut_alumno!=0){
							    $total_alumnos = 1;
							}	
							
							for ($i=0; $i < $total_alumnos; ++$i){
							    if ($rut_alumno=0){
								    $rut_alumno = $alumnos[$i];
								}	
								?>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="30%">Rut Alumno </td>
                                    <td><?=$rut_alumno ?></td>
                                  </tr>
                                </table>
						<table width="750" border="1" align="center" cellpadding="0" cellspacing="0">
								 <tr>
								   <td width="60%"><table width="100%" border="1" cellspacing="0" cellpadding="2">
								  <tr>
									<td width="50%" rowspan="2"><span class="textosimple">SUBSECTOR ASIGNATURA Y MODULO</span></td>
									<td colspan="4"><span class="textosimple">CURSO DE ENSE&Ntilde;ANZA MEDIA</span></td>
									</tr>
								  <tr>
									<td width="12%">&nbsp;</td>
									<td width="12%">&nbsp;</td>
									<td width="12%">&nbsp;</td>
									<td width="12%">&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								</table></td>
								<td width="40%">&nbsp;</td>
								</tr>
						</table>
					      <? } ?>
					  
					  
					  
				   <? } ?>
							  
					  <!-- BUSCADOR AVANZADO -->
                       
                          <? 
						$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
						$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
						$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.ensenanza > 300 and curso.grado_curso = 4 ";
						$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
											
						$resultado_query_cue = @pg_exec($conn,$sql_curso);
						
						?>
                         
                      <form method "post" action="concentracionnotas_nueva.php">					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td colspan="2">BUSCADOR AVANZADO 
                            </td>
                          </tr>
                        <tr>
                          <td width="20%">Cursos</td>
                          <td><label>
                            <select name="cmb_curso" class="ddlb_9_x" onChange="enviapag(this.form);">
							   <option value="0">Seleccione Curso </option>
							   <?
							   for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
							       $fila = @pg_fetch_array($resultado_query_cue,$i); 
		                           $ensenanza = $fila['ensenanza'];
								   $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
								   ?>
								   <option value="<?=$fila['id_curso']; ?>" <? if ($cmb_curso==$fila['id_curso']){ ?> selected="selected" <? } ?>><?=$Curso_pal ?></option>
						    <? } ?>
                            </select>
                          </label></td>
                        </tr>
                        <tr>
                          <td>Alumnos</td>
                          <td><label>
						    <?
							$sql="select alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.rut_alumno where alumno.rut_alumno in (select rut_alumno from matricula where matricula.id_curso = '$curso') order by ape_pat, ape_mat, nombre_alu";
                            $res_sql = @pg_Exec($conn,$sql);
							$total_alumnos = @pg_numrows($res_sql);
							?>
							<select name="cmb_alumno">
							<option value="0">Todos los alumnos</option>
							<?
							for ($i=0; $i < @pg_numrows($res_sql); ++$i){
							     $fila = pg_fetch_array($res_sql,$i);
								 $alumnos[] = $fila['rut_alumno'];
							     ?>
								 <option value="<?=$fila['rut_alumno']; ?>" <? if ($cmb_alumno==$fila['rut_alumno']){ ?> selected="selected" <? } ?>><? echo $fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_alu']; ?></option>
								 <?
							} ?>						
                            </select>
                          </label></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div align="center">
                            <input name="alumnos" type="hidden" id="alumnos" value="<?=$alumnos ?>">
                            <input name="total_alumnos" type="hidden" id="total_alumnos" value="<?=$total_alumnos ?>">
                            <label>
                            <input name="buscar" type="submit" class="botonXX" id="buscar" value="Buscar">
                            </label>
                          </div></td>
                          </tr>
                      </table>
					</form>  
					  
					  
					  </td>
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
<?
//echo "<h1>fin ".date('h:i:s')."</h1>";//PERCY CUANDO HAGAS ESTO HAZLO PARA QUE LO VEA NADIE SOLO TU

//print_r($total);

?>
<? pg_close($conn);?>

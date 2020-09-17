<?	require('../../util/header.inc');


	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;

	
	
/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}
?>

<script language="javascript" type="text/javascript">


</script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
--><script type="text/javascript" language="javascript">
function agregar(form2){
	if(document.form2.count.value < 6){
			form2.submit(true);
	}else{
			alert("YA SE AGREGARON TODOS LOS SUBSECTORES.");
	}
}
			 </script>
<SCRIPT language="JavaScript">
function envia_postulacion(form,rut_alumno){
	var curso = document.form.cmb_curso.value;
	//var ensenanza = document.form.cmb_ensenanza.value;
	window.location='postulacion_becas.php?rut_alumno='+rut_alumno+'&curso='+curso;
}
function enviapag(){
	form.submit(true);
}
function borrar_psu(){

}
function eliminar_sub(cod_psu,ano,cod_sub_psu){
	if(confirm("SE ELIMARAN LOS PUNTAJES RELACIONADOS.")){
		window.location='procesaagregarsubsector_psu.php?tipo=2&cod_sub_psu='+cod_sub_psu+'&cod_subsector='+cod_psu+'&cod_ano='+ano+'&caso=1'
	}
}
function ponderaciones(cod_subsector,cod_sub_psu){
		window.location='detalle_ponderacion_psu.php?cod_subsector='+cod_subsector+'&cod_sub_psu='+cod_sub_psu
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function eliminar_sub_simce(subsector,ano,grado,ensenanza,id_sim,rdb){
	if(confirm("SE ELIMARA EL SUBSECTOR Y LOS PUNTAJES RELACIONADOS.")){
		window.location='procesaagregarsubsector_simce.php?tipo=2&cod_subsector='+subsector+'&ano='+ano+'&grado='+grado+'&ensenanza='+ensenanza+'&id_sub_sim='+id_sim+'&rdb='+rdb
	}	
}							
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
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
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
						include("../../menus/menu_lateral.php");
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
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
<FORM method="post" name="form" action="becas_beneficios.php">
<center>
		<table width="81%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td colspan="5" class="tableindex">Postulaciones</td>
  </tr>
  <? if($cmb_curso!=0){?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
   <tr>
     <td width="9%">&nbsp;</td>
    <td width="37%" class="cuadro02"><div align="center">Alumnos</div></td>
    <td width="16%" class="cuadro02"><div align="center">Nro. Becas</div></td>
    <td width="21%" class="cuadro02"><div align="center">Postulaciones</div></td>
    <td width="17%">&nbsp;</td>
   </tr>
  <?
				$sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
				$sql.="alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, ";
				$sql.=" alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat ";
				$sql.=" FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON ";
				$sql.=" matricula.rut_alumno = alumno.rut_alumno WHERE (matricula.bool_ar=0 AND((matricula.id_curso)=".$cmb_curso.") AND ";
				$sql.=" ((matricula.id_ano)=".$_ANO.")) order by ape_pat, ape_mat, nombre_alu ";
				$resp = pg_exec($conn,$sql);
				$num_alumnos = pg_numrows($resp);
				for($i=0;$i<$num_alumnos;$i++){
				$fila_alumnos = pg_fetch_array($resp,$i);
	?>
  <tr>
    <td>&nbsp;</td>
    <td class="cuadro01"><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
    <?  $sql_becas = "SELECT count(id_beca) FROM becas_benef WHERE rut_alumno=".$fila_alumnos['rut_alumno'];
		$resp_becas = pg_exec($conn,$sql_becas);
	?>
	<td class="cuadro01"><div align="center"><?=pg_result($resp_becas,0)?></div></td>
    <td class="cuadro01"><div align="center">
	<? if($ingreso==1 || $modifica==1){?>
      <input type="button" class="botonXX" name="Submit2" value="P" onClick="javascript:envia_postulacion(this.form,<?=$fila_alumnos['rut_alumno']?>)">
    <? } ?>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <? }?>
  <? }?>
  <tr>
    <td colspan="5">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="cuadro02" colspan="2">Buscador Cursos</td>
  </tr>
  <tr>
    <td class="cuadro01">Curso</td>
	<td class="cuadro01">
	  <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> 
		  	  
		 
			    </strong> </font></td>
  </tr>
  
</table>	</td>
  </tr>
</table>

</center>
</FORM>

	
<!-- FIN CUERPO DE LA PAGINA -->

 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
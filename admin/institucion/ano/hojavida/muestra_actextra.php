<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
   
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
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--

function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
     function enviapag(form){
		    var curso, frmModo; 
			curso=form.cmb_curso.value;
			cmb_acti=form.cmb_acti.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="muestra_actextra.php"
				form.action = pag;
				form.submit(true);	
			}		
		 }
//-->
</script>

		<?php include('../../util/rpc.php3');?>
	
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>

          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
                <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>		
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=3; 
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  <form name="form1" method="post" action="procesa_actextra.php">
					    <table width="278" border="0" align="center">
                          <tr>
                            <td class="tableindex" colspan="2" align="center"><center>
                                ASIGNAR ACTIVIDADES A ALUMNO
                            </center></td>
                          </tr>
                          <tr>
                            <td width="43" class="textosimple">Cursos</td>
                            <td width="225">&nbsp;<br>
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
&nbsp;</td>
                          </tr>
                          <tr>
                            <td class="textosimple">Actividades&nbsp;</td>
                            <td><? 
							$sql_acti="select * from actividades_extra where id_curso=".$_REQUEST["cmb_curso"];
							$result = pg_exec($conn,$sql_acti);
                 ?>
                                <select name="cmb_acti" class="ddlb_x" onChange="enviapag(this.form);">
                                  <option value=0 selected>(Seleccione una actividad)</option>
                                  <?
		     for($i=0 ; $i < @pg_numrows($result) ; $i++)
		        {  
		        $fila_acti = @pg_fetch_array($result,$i); 
		        
		        if (($fila_acti['id_extra'] == $cmb_acti) or ($fila_acti['id_extra'] == $curso)){
		           echo "<option value=".$fila_acti['id_extra']." selected>".$fila_acti['nombre_extra']." </option>";
		        }else{	    
		           echo "<option value=".$fila_acti['id_extra'].">".$fila_acti['nombre_extra']." </option>";
                }
		     } ?>
                                  &nbsp;
                              </select></td>
                          </tr>
                        </table>
					    <table width="632" border="0" cellpadding="0" cellspacing="0" align="center">
                          <tr class="tableindex">
                            <td width="152" align="center">NOMBRE ALUMNO </td>
                            <td width="120" align="center">APELLIDO PATERNO</td>
                            <td width="120" align="center">APELLIDO MATERNO</td>
                            <td width="165" align="center">ASISTENCIA</td>
							<td width="75" align="center">TODOS &nbsp;</td>
                          </tr>
						  <TR class="textosimple">
				  <td align="center"><B>TODOS&nbsp;</B></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"></td>
				  <td>&nbsp;</td>
				  </TR>
						  <?	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$_REQUEST["cmb_curso"].") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
				 				$result =@pg_Exec($conn,$qry);
								
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila_alum = @pg_fetch_array($result,$i);
									$total = @pg_numrows($result);
				 ?>
				 <INPUT type="hidden" name="total" value="<? echo $total;?>">
				  <INPUT type="hidden" name="rut_<?= $i?>" value="<?= $fila_alum["rut_alumno"]?>">
				         <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow' onMouseOut=this.style.background='ffffff'>
                            <td align="center" class="textosimple">&nbsp;<?= $fila_alum["nombre_alu"];?></td>
                            <td align="center" class="textosimple">&nbsp;<?= $fila_alum["ape_pat"];?></td>
                            <td align="center" class="textosimple">&nbsp;<?= $fila_alum["ape_mat"];?></td>
						<? 		 $sqlchecked="select * from asiste_actividad where rut_alumno=".$fila_alum["rut_alumno"]."and id_extra=".$cmb_acti;
								$resultchecked = @pg_Exec($conn,$sqlchecked);
								$fila_chek = @pg_fetch_array($resultchecked,0);
								if( $fila_chek["asiste"]==1){?>
							  <td align="center" class="textosimple"><input type="checkbox" checked name="confirma_<?= $i?>" value="1">							    </td>
								<? }else{?>
                                <td align="center" class="textosimple"><input type="checkbox" name="confirma_<?= $i?>" value="1"></td>
                                <? }?> 
						  </tr>
						  <? }?>
						  <tr>
						  <td>&nbsp;</td>
						  </tr>
                          <tr>
                            <td colspan="4" align="center">
							<? if($ingreso==1){?>
							<input name="btn" type="submit" class="botonXX" value="Guardar" >
							<? } ?>
                            &nbsp;</td>
                          </tr>
                        </table>
					    <p>&nbsp;</p>
					  </form></td>
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

<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 4;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
	
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

	if(!chkVacio(frm.txt_corp,'Ingrese Corporaci�n')){
		return false;
	};

	frm.submit()
	
}
     function enviapag(form){
		    var curso, frmModo; 
			curso=form.cmb_curso.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="hoja_de_vida.php"
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
		/*$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND curso.ensenanza=".pg_result($rs_acceso,3)." AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";*/
 
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
                        </table>
					    <table cellpadding="0" cellspacing="0" align="center">
                          <tr class="tableindex">
                            <td width="152" align="center">NOMBRE ALUMNO </td>
                            <td width="120" align="center">APELLIDO PATERNO</td>
                            <td width="120" align="center">APELLIDO MATERNO</td>
                            <td width="120" align="center">INFORME PERSONALIDAD</td>
                            <td width="120" align="center">FICHA MEDICA</td>
                            <td width="120" align="center">FICHA DEPORTIVA</td>
                            <td width="120" align="center">ACTIVIDADES EXTRAPROGRAMATICAS</td>
                            <td width="120" align="center">CITACION APODERADOS</td>
                          </tr>
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
							<td align="center" class="textosimple">&nbsp;<a href="../reportes/printInformePersonalidadAnual_C.php?c_reporte=23&cmb_curso=<?= $_REQUEST['cmb_curso']?>&cmb_alumno=<?= $fila_alum["rut_alumno"]?>&cb_ok=Buscar&retirado=1&evaluacion=1&obs=0&destaca=0&txtFILAS=3&escala=1&capa=10" target="_blank">Ver</a></td>
                            <td align="center" class="textosimple">&nbsp;<a href="../fichas/medicas/listarFichasAlumno.php3?alumno=<?= $fila_alum["rut_alumno"]?>&caso=1&curso=<?= $_REQUEST['cmb_curso']?>">Ver</a></td>
                            <td align="center" class="textosimple">&nbsp;<a href="../fichas/deportivas/seteaFicha.php3?alumno=<?= $fila_alum["rut_alumno"]?>&caso=4&curso=<?= $_REQUEST['cmb_curso']?>">Ver</a></td>
							<td align="center" class="textosimple">&nbsp;<a href="acti_extra.php3?alumno=<?= $fila_alum["rut_alumno"]?>&curso=<?= $_REQUEST['cmb_curso']?>">Ver</a></td>
							<td align="center" class="textosimple">&nbsp;<a href="cita_apo.php3?alumno=<?= $fila_alum["rut_alumno"]?>&curso=<?= $_REQUEST['cmb_curso']?>">Ver</a></td>
                            </tr>
						  <? }?>
						  <tr>
						  <td>&nbsp;</td>
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
<?	require('../../util/header.inc');
	//include('../../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
--><SCRIPT language="JavaScript">

function enviapag(form){
			if (form.cmb_subsector.value!=0){
				//form.cmb_ensenanza.target="self";
					//form.action = 'agregasubsector_psu.php?institucion=$institucion';
				form.submit(true);
			}else{
			alert("DEBE SELECCIONAR SUBSECTOR");
			}	
}
			
function enviapag2(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'agregasubsector_psu.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			

function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}


function eliminar_postulacion(rut_alumno,id_beca,ano,curso){
	if(confirm("DESEA BORRAR LA POSTULACION A LA BECA SELECCIONADA.")){
		window.location='procesaagregar_becas.php?tipo=5&id_beca='+id_beca+'&rut_alumno='+rut_alumno+'&ano='+ano+'&curso='+curso;
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
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>>>>>>>>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	

<FORM method="post" name="form" action="procesaagregar_becas.php?ano=<?=$ano?>&rut_alumno=<?=$rut_alumno?>&curso=<?=$curso?>&ensenanza=<?=$ensenanza?>&tipo=1">
		<center>
		  <table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" class="tableindex">Postulacion:</td>
  </tr>
  <tr class="cuadro01">
    <td width="16%">Alumno:</td>
	<?
		$sql ="SELECT nombre_alu,ape_pat,ape_mat FROM alumno WHERE rut_alumno =".$rut_alumno;
		$resp = pg_exec($conn,$sql);
		$fila_nomb = pg_fetch_array($resp,0);
		$nombre = $fila_nomb['ape_pat']." ".$fila_nomb['ape_mat'].",".$fila_nomb['nombre_alu'];
	 
	?>
    <td colspan="3"><?=$nombre?></td>
    </tr>
  <tr class="cuadro01">
    <td>Curso:</td>
	<?
		$sql ="SELECT grado_curso,letra_curso FROM curso WHERE id_curso =".$curso." AND id_ano=".$ano;
		$resp = pg_exec($conn,$sql);
		$nomb_curso = pg_result($resp,0)."-".pg_result($resp,1);
	?>
    <td width="17%"><?=$nomb_curso?></td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr class="tableindex">
    <td colspan="4">Becas Ingresadas:</td>
    </tr>
  <tr>
    <td colspan="4" align="center">
	
	<table width="62%" border="0" cellpadding="0" cellspacing="1">
<tr>
      <td class="cuadro02"><div align="center">Nombre Beca<br />&nbsp;&nbsp;&nbsp;(Fecha Ingreso)</div></td>
      <td class="cuadro02"><div align="center"><input type="button" name="eliminar" class="botonXX" value="E"><br/ >Eliminar</div></td>
</tr>
  <? 
  	$sql= "SELECT a.*,b.nomb_beca FROM becas_benef a INNER JOIN becas_conf b ON (a.id_beca=b.id_beca) ";
	$sql.=" WHERE a.rut_alumno=".$rut_alumno." AND b.id_ano=".$_ANO." ORDER BY a.fecha_postul ASC";
	$resp_beca = pg_exec($conn,$sql);
  	for($i=0;$i<pg_numrows($resp_beca);$i++){
  	$fila_beca = pg_fetch_array($resp_beca,$i);
  ?>
  <tr bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='ffffff'">
 	<?
	$fecha_postul=$fila_beca['fecha_postul'];
	$YY = substr($fecha_postul,0,4);
	$dd = substr($fecha_postul,8,9);
	$mm = substr($fecha_postul,5,2);
	$fecha = $dd."-".$mm."-".$YY;
	?>
	<td align="center" class="cuadro01" bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='ffffff'" onClick="javascript:window.open('../institucion/ano/reportes/Informe_becas_postulacion.php?rut_alumno=<?=$rut_alumno?>&curso=<?=$curso?>&beca=<?=$fila_beca['id_beca']?>&fecha_postul=<?=$fila_beca['fecha_postul']?>','','width=700,height=500,resizable=no,scrolbars=yes');void(false)"><div align="center"><?=$fila_beca['nomb_beca']."&nbsp;&nbsp;&nbsp;(".$fecha.")"?></div></td>
    <td class="cuadro01"><div align="center"><input type="button" name="eliminar" class="botonXX" value="E" onClick="javascript:eliminar_postulacion(<?=$fila_beca['rut_alumno']?>,<?=$fila_beca['id_beca']?>,<?=$ano?>,<?=$curso?>)"></div></td>
  </tr>
  <? }?>
</table>	</td>
  </tr>
  <tr>
    <td colspan="4" class="tableindex">Ingresar Beca:</td>
  </tr>
  <tr>
  <td colspan="2" class="cuadro01"><div align="center">Beca:</div></td>
    <td colspan="2" align="left" class="cuadro01">
	<?		$sql="SELECT * FROM becas_conf WHERE id_beca NOT IN (SELECT id_beca FROM becas_benef WHERE rut_alumno=".$rut_alumno.") AND id_ano=".$_ANO;
			$resp_cmb = pg_exec($conn,$sql);
			$num_becas = pg_numrows($resp_cmb);
	  ?>
	  	<select name="cmb_becas" class="ddlb_x">
		  <option value="0" selected>(Seleccione Beca)</option>
		  <?  for($i=0;$i<$num_becas;$i++){
				$fila_cmb = @pg_fetch_array($resp_cmb,$i); 
					if ($fila_cmb['id_beca'] == $cmb_beca){?>
						<option value="<?=$fila_cmb['id_beca']?>" selected><?=$fila_cmb['nomb_beca']?></option>
					<? }else{?>
						<option value="<?=$fila_cmb['id_beca']?>"><?=$fila_cmb['nomb_beca']?></option>
				<?	}
			}?>
       	</select>	</td>
  </tr>
  <tr>
    <td colspan="4" class="cuadro01">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><div align="center"></div></td>
  	<td width="67%" align="center"><div align="center">
  	  <input type="submit" name="guardar" class="botonXX" value="Guardar">
  	</div></td>
    <td align="center"><input type="button" name="volver" value="Volver" class="botonXX" onClick="javascript:window.location='becas_beneficios.php?cmb_curso=<?=$curso?>&cmb_ensenanza=<?=$ensenanza?>'"></td>
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
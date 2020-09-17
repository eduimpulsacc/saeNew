<?	require('../../util/header.inc');
	//include('../../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$cmb_ensenanza;
	$cmb_grado;
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">

function enviapag(form){
			if (form.cmb_ensenanza.value!=0){
				form.cmb_ensenanza.target="self";
				form.action = 'agregasubsector_simce.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
function enviapag2(form){
			if (form.cmb_grado.value!=0){
				form.cmb_grado.target="self";
				form.action = 'agregasubsector_simce.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			

function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>>>>>>>>>>>>>>>><? include("../../cabecera/menu_inferior.php");?></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
<FORM method="post" name="form" action="procesaagregarsubsector_simce.php?ano=<?=$ano?>&rdb=<?=$institucion?>&tipo=1">
		<center>
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="4"><div align="right">
			  <input name="cb_ok" type="submit" class="botonXX" id="cb_ok" value="Guardar">
                <input name="cb_volver" type="button" class="botonXX" id="cb_volver" value="Volver" onClick="window.location='prueba_simce_psu.php'">
              </div></td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" class="tableindex">AGREGAR SUBSECTOR SIMCE</td>
              </tr>
            <tr>
			  <td class="cuadro01"><?="Tipo de enseñanza";?></td>
			  <td class="cuadro01">
			  <? 
			  $sql="SELECT * FROM tipo_ensenanza WHERE cod_tipo IN (SELECT cod_tipo FROM tipo_ense_inst WHERE ";
			  $sql.="rdb = $institucion AND cod_tipo > 10) AND cod_tipo in (110,310) ORDER BY cod_tipo ASC";
			  $rs_ense = @pg_exec($conn,$sql);
				?>
              <select name="cmb_ensenanza" id="cmb_ensenanza" class="ddlb_9_x" onChange="enviapag(this.form)">
			        <option value="0" selected>(Seleccione tipo enseñanza)</option>
			        <? 	
							 //llenar combo 
							  //$ob_ense = new Reporte();
							  //$ob_ense->institucion=$institucion;							  
							  //$resultado_cmb=$ob_ense->Ensenanza($conn);				  		  	 
										  for($i=0;$i<pg_numrows($rs_ense);$i++){
												$llenar_combo=pg_fetch_array($rs_ense,$i);
										  if($llenar_combo['cod_tipo']==$cmb_ensenanza){
						?>
			        <option value="<?=$llenar_combo['cod_tipo'];?>" selected="selected">
			          <?=$llenar_combo['nombre_tipo'];?>
			          </option>
			        <? }else{ ?>
			        <option value="<?=$llenar_combo['cod_tipo'];?>">
			          <?=$llenar_combo['nombre_tipo'];?>
			          </option>
			        <? }
								} ?>
			        </select>
			  </td>
            </tr>
			  <tr>
              <td class="cuadro01"><?="Grado";?></td>
              <td class="cuadro01">
  

				<select name="cmb_grado" class="ddlb_x" id="cmb_grado" onChange="enviapag2(this.form)">
					  <option value="0" selected>(Seleccione grado)</option>
			<? if($cmb_ensenanza==110){ 
				 	if($cmb_grado==4){?>
				 		 <option value="4" selected="selected">Cuarto grado</option>
				 	<? }else{?>
						<option value="4">Cuarto grado</option>
					<? }
				 	if($cmb_grado==8){?>
						<option value="8" selected="selected">Ocatavo grado</option>
					<? }else{?>
					   <option value="8">Ocatavo grado</option>
					<? }
				 }
				 
				if($cmb_ensenanza!=110 & $cmb_ensenanza!=0){
					if($cmb_grado==2){?>
						<option value="2" selected="selected">Segundo grado</option>
					<? }else{?>
					  <option value="2">Segundo grado</option>
					<? }
					}?>  
       			 </select>	 
			  </td>
			  <tr>
			  <td class="cuadro01"><?="Subsector";?></td>
              <td class="cuadro01">
			<? 
			
			if($cmb_grado==0 or $cmb_ensenanza==110 and $cmb_grado==2 or $cmb_ensenanza!=110 and $cmb_grado==4 or $cmb_ensenanza!=110 and $cmb_grado==8){?>
			<select name="cmb_subsector" class="ddlb_x">
					  <option value="0" selected>(Seleccione subsector)</option>
       			 </select> 
			<? }
			
			
			if($cmb_ensenanza==110 and $cmb_grado==4){?>
			
				<select name="cmb_subsector" class="ddlb_x">
					  <option value="0" selected>(Seleccione subsector)</option>
					  <option value="14" >LENGUAJE Y COMUNICACION</option>
					  <option value="15" >EDUCACION MATEMATICA</option>
					  <option value="132" >COMPRENSION DEL MEDIO NATURAL</option>
					  <option value="133" >COMPRENSION DEL MEDIO SOCIAL Y CULTURAL</option>
					  <option value="89" >ESCRITURA</option>
       			 </select>
			
			
			<? }?>
			
			<? if($cmb_ensenanza==110 and $cmb_grado==8){?>
			
				<select name="cmb_subsector" class="ddlb_x">
					  <option value="0" selected>(Seleccione subsector)</option>
					  <option value="14" >LENGUAJE Y COMUNICACION</option>
					  <option value="15" >EDUCACION MATEMATICA</option>
					  <option value="20" >ESTUDIO Y COMPRENSION DE LA NATURALEZA </option>
					  <option value="21" >ESTUDIO Y COMPRENSION DE LA SOCIEDAD</option>
       			 </select>
			
			
			<? }?>
			
				<? if($cmb_ensenanza!=110 and $cmb_grado==2){?>
			
				<select name="cmb_subsector" class="ddlb_x">
					  <option value="0" selected>(Seleccione subsector)</option>
					  <option value="27" >LENGUA CASTELLANA Y COMUNICACION</option>
					  <option value="5" >MATEMATICA</option>
       			 </select>
			
			
			<? }?>
			
				<?php /*?><select name="cmb_subsector" class="ddlb_x">
					  <option value="0" selected>(Seleccione subsector)</option>
					  <?
					  
					  for($i=0 ; $i < @pg_numrows($resultado_query_sub) ; $i++)
					  {
						$fila_sub = @pg_fetch_array($resultado_query_sub,$i); 
						if ($fila_sub['id_ramo'] == $cmb_subsector){
						   echo "<option value=".$fila_sub['id_ramo']." selected>".$fila_sub['nombre']."</option>";
						}else{
							echo "<option value=".$fila_sub['id_ramo'].">".$fila_sub['nombre']."</option>";
						}
					  }
					
					  ?>
       			 </select><?php */?>
				 </td>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
<?php
require('../../../../util/header.inc');
/*require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');*/

/*$_POSP = 4;
$_bot = 8;*/


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$periodo		=$c_periodos;
	
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, institucion.numero_inst, institucion.letra_inst,region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono,institucion.dependencia,
institucion.area_geo, institucion.dig_rdb, institucion.email ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	$region = $fila_ins['nom_reg'];	
	$provincia = $fila_ins['nom_pro'];	
	$comuna = $fila_ins['nom_com'];	
	$numero = $fila_ins['letra_inst']."-".$fila_ins['numero_inst'];
	$dependencia = $fila_ins['dependencia'];
	$area = $fila_ins['area_geo'];
	$div = $fila_ins['dig_rdb'];
	$email = $fila_ins['email'];
	//------------------------

	$sql = "SELECT nro_ano FROM ano_escolar WHERE id_ano='$ano'";
	$result = @pg_exec($conn,$sql);
	$fila = @pg_fetch_array($result,$sql);
	$nro_ano = $fila['nro_ano'];
	
	//--------------------- TIPO DE ENSEÑANZA ---------------------
	$sql = "SELECT a.bool_ecp,a.bool_pj FROM tipo_ense_inst a WHERE a.rdb=".$institucion." AND cod_tipo=110 limit 1 offset 1";
	$result = @pg_exec($conn,$sql);
	$fila_ense = @pg_fetch_array($result,0);
		if($fila_ense['bool_ecp']==1){
			$cpadres = "SI";
		}else{
			$cpadres = "NO";
		}
		if($fila_ense['bool_pj']==1){
			$pjuridica = "SI";		
		}else{
			$pjuridica = "NO";
		}

	$sql = "SELECT nombre_emp || cast(' ' as varchar)|| ape_pat || cast(' ' as varchar)|| ape_mat as nombre FROM empleado WHERE rut_emp in(SELECT rut_emp FROM trabaja WHERE RDB=".trim($institucion)." AND CARGO=1)";
	$result = @pg_exec($conn,$sql);
	$Director = @pg_result($result,0);
	
	$sql = "SELECT nombre_emp || cast(' ' as varchar)|| ape_pat || cast(' ' as varchar)|| ape_mat as nombre FROM empleado WHERE rut_emp in(SELECT rut_emp FROM trabaja WHERE RDB=".trim($institucion)." AND CARGO=2)";
	$result = @pg_exec($conn,$sql);
	$UTP = @pg_result($result,0);
?>
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
</script>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:7px;
 
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	
	}
.Estilo4 {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
 
}
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 7px; font-weight: bold; }
-->
</style>
 <style>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
 </style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../cabecera/menu_superior.php");
				?>                </td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><br>
                              <!-- INCLUYO CODIGO DE LOS BOTONES -->
                              <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
                              <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="" height="" align="center" valign="top"><?
						//include("../../../../cabecera/menu_inferior.php");
						?>                                  </td>
                                </tr>
                              </table>
                            <? } ?>
                              <!-- FIN CODIGO DE BOTONES -->
                              <!-- INICIO CUERPO DE LA PAGINA -->

                            
			
<table width="650" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div id="capa0">
<div align="right">
<input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printFormulario1.php','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
</div>
</div></td>
</tr>
</table>
<p>
               
				            <table width="650" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="196"><div align="center"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong>REPUBLICA DE CHILE </strong></font></div></td>
                                    <td width="81">&nbsp;</td>
                                    <td width="187"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">N&ordm; de Folio <strong>2 </strong></font></div></td>
                                    <td width="186"><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">FORMULARIO N&ordm;1</font> </strong></div></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center"><font size="1" face="Verdana, Verdana, Arial, Helvetica, sans-serif">MINISTERIO DE EDUCACI&Oacute;N </font></div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="Estilo2"><div align="center"><? echo $ins_pal;?></div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">A&Ntilde;O
                                      <? echo $fila['nro_ano'];?></font></div></td>
                                  </tr>
                            </table>
                                <table width="650" border="1" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><table width="650" border="0" class="cajaborde" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td colspan="2"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="2">IDENTIFICACI&Oacute;N</font></strong></td>
                                          <td width="75" class="Estilo2">Let. N&uacute;mero </td>
                                          <td width="160" class="Estilo2"><? echo $numero;?></td>
                                        </tr>
                                        <tr>
                                          <td width="166" class="Estilo2">Nombre del Establecimiento</td>
                                          <td width="231" class="Estilo2"><? echo $ins_pal;?></td>
                                          <td class="Estilo2">Tel&eacute;fono</td>
                                          <td class="Estilo2"><? echo $telefono;?></td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Direci&oacute;n/Localidad</td>
                                          <td class="Estilo2"><? echo $direccion;?></td>
                                          <td class="Estilo2">Celular</td>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" class="Estilo2">&iquest;Existe Centro de Padre? <? echo $cpadres;?> &iquest;Tiene Personalidad Juridica ? <? echo $pjuridica;?></td>
                                          <td class="Estilo2">E-mail</td>
                                          <td class="Estilo2"><? echo $email;?></td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Regi&oacute;n</td>
                                          <td class="Estilo2"><? echo $region;?></td>
                                          <td colspan="2" rowspan="2"><table width="100%" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" class="cajaborde">
                                              <tr>
                                                <td class="Estilo2">Depend.</td>
                                                <td class="Estilo2">Área Geograf.</td>
                                                <td class="Estilo2">Tipo de Enseñanza</td>
                                                <td class="Estilo2">RBD</td>
                                                <td class="Estilo2">D/V</td>
                                              </tr>
                                              <tr>
                                                <td class="Estilo2"><div align="center"><? echo $dependencia;?></div></td>
                                                <td class="Estilo2"><div align="center"><? echo $area;?></div></td>
                                                <td class="Estilo2"><div align="center">110</div></td>
                                                <td class="Estilo2"><div align="center"><? echo $institucion;?></div></td>
                                                <td class="Estilo2"><div align="center"><? echo $div;?></div></td>
                                              </tr>
                                          </table></td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Provincia</td>
                                          <td class="Estilo2"><? echo $provincia;?></td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Comuna</td>
                                          <td class="Estilo2"><? echo $comuna;?></td>
                                          <td colspan="2">&nbsp;</td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="650" border="1" class="Estilo2">
                                  <tr>
                                    <td rowspan="2" class="Estilo2">SEXO</td>
                                    <td rowspan="2" class="Estilo2">A&Ntilde;O DE NACIMIENTO. </td>
                                    <td colspan="11"><div align="center">MATRICULA INCIAL POR SEXO <span class="Estilo4">(SEG&Uacute;N A&Ntilde;O DE NACIMIENTO) </span></div></td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2"><div align="center">1</div></td>
                                    <td class="Estilo2"><div align="center">2</div></td>
                                    <td class="Estilo2"><div align="center">3</div></td>
                                    <td class="Estilo2"><div align="center">4</div></td>
                                    <td class="Estilo2"><div align="center">5</div></td>
                                    <td class="Estilo2"><div align="center">6</div></td>
                                    <td class="Estilo2"><div align="center">7</div></td>
                                    <td class="Estilo2"><div align="center">8</div></td>
                                    <td class="Estilo2"><div align="center">TOTAL</div></td>
                                    <td class="Estilo2"><div align="center">G.D.</div></td>
                                    <td class="Estilo2"><div align="center">Al.Integ.</div></td>
                                  </tr>
								  <? for($i=2001;$i>=1988;$i--){
								  		$Total_Grado=0;
								 		if($i==2001){
								  ?>
								   <tr>
                                    <td class="Estilo2">Masculino</td>
                                    <td class="Estilo2">Después del <? echo $i;?></td>
								<? 	for($x=1;$x<=8;$x++){	
										$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=2 AND date_part('year',fecha_nac)>".trim($i)." AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
										$result = @pg_exec($conn,$sql);
										$fila = @pg_fetch_array($result,0);
										$Total_Grado = $Total_Grado + $fila['cuenta'];
								?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
								<? 	} ?>
                                    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                  </tr>
								  <? $Total_Grado=0;
								  } ?>
                                  <tr>
                                    <td class="Estilo2">Masculino</td>
                                    <td class="Estilo2"><? echo $i;?></td>
                                  <? 	for($x=1;$x<=8;$x++){
								  			$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=2 AND date_part('year',fecha_nac)=".trim($i)." AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
										$result = @pg_exec($conn,$sql);
										$fila = @pg_fetch_array($result,0);
										$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
								  <? 	} ?>
                                    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                  </tr>
 								  <? } // FIN FOR AÑOS?>
								  <tr>
                                    <td class="Estilo2">Masculino</td>
                                    <td class="Estilo2">Antes del <? echo $i+1;?></td>
                                    <? 	for($x=1;$x<=8;$x++){
											$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=2 AND date_part('year',fecha_nac)<".trim($i+1)." AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
											$result = @pg_exec($conn,$sql);	
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
                                    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                  </tr>
								  <tr>
								    <td class="Estilo2">Masculino</td>
								    <td class="Estilo2">Totales</td>
								     <? 	for($x=1;$x<=8;$x++){
									 		$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=2 AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
											$result = @pg_exec($conn,$sql);	
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								  <tr>
								    <td class="Estilo2">Masculino</td>
								    <td class="Estilo2">Als. Repitentes </td>
								     <? $Total_Grado=0;
									 	for($x=1;$x<=8;$x++){
									 		$sql = "SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=2 AND rut_alumno in
(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)."  AND bool_rg=1 AND id_curso in
(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)."  AND grado_curso=1))";
											$result = @pg_exec($conn,$sql);
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];
												?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								  <tr>
								    <td class="Estilo2">Masculino</td>
								    <td class="Estilo2">Als. Integrados </td>
								     <? $Total_Grado=0;
									 	for($x=1;$x<=8;$x++){
									 		$sql = "SELECT count(*)as cuenta FROM alumno$nro_ano WHERE sexo=2 AND rut_alumno in
(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)."  AND bool_i=1 AND id_curso in
(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)."  AND grado_curso=1))";
											$result = @pg_exec($conn,$sql);
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								  <tr>
								    <td class="Estilo2">Masculino</td>
								    <td class="Estilo2">Als. Origen Indigena </td>
								     <? $Total_Grado=0;
									 	for($x=1;$x<=8;$x++){
											$sql = "SELECT count(*)as cuenta FROM alumno$nro_ano WHERE sexo=2 AND rut_alumno in
(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)."  AND bool_aoi=1 AND id_curso in
(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)."  AND grado_curso=1))";
											$result = @pg_exec($conn,$sql);
											$fila = @pg_fetch_array($result,0);
										?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								 
								  <!--CICLO MUJERES-->
								  
                                  <? for($i=2001;$i>=1988;$i--){
								  		$Total_Grado=0;
								 		if($i==2001){
								  ?>
								   <tr>
                                    <td class="Estilo2">Femenino</td>
                                    <td class="Estilo2">Después del <? echo $i;?></td>
								<? 	for($x=1;$x<=8;$x++){	
										$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=1 AND date_part('year',fecha_nac)>".trim($i)." AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
										$result = @pg_exec($conn,$sql);
										$fila = @pg_fetch_array($result,0);
										$Total_Grado = $Total_Grado + $fila['cuenta'];
								?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
								<? 	} ?>
                                    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                  </tr>
								  <? $Total_Grado=0;
								  } ?>
                                  <tr>
                                    <td class="Estilo2">Femenino</td>
                                    <td class="Estilo2"><? echo $i;?></td>
                                  <? 	for($x=1;$x<=8;$x++){
								  			$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=1 AND date_part('year',fecha_nac)=".trim($i)." AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
										$result = @pg_exec($conn,$sql);
										$fila = @pg_fetch_array($result,0);
										$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
								  <? 	} ?>
                                    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                  </tr>
 								  <? } // FIN FOR AÑOS?>
								  <tr>
                                    <td class="Estilo2">Femenino</td>
                                    <td class="Estilo2">Antes del <? echo $i+1;?></td>
                                    <? 	for($x=1;$x<=8;$x++){
											$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=1 AND date_part('year',fecha_nac)<".trim($i+1)." AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
											$result = @pg_exec($conn,$sql);	
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
                                    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                    <td class="Estilo2"><div align="right">0</div></td>
                                  </tr>
								  <tr>
								    <td class="Estilo2">Femenino</td>
								    <td class="Estilo2">Totales</td>
								     <? 	for($x=1;$x<=8;$x++){
									 		$sql ="SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=1 AND rut_alumno in(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)." AND id_curso in(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)." AND grado_curso=".trim($x)."))";
											$result = @pg_exec($conn,$sql);	
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								  <tr>
								    <td class="Estilo2">Femenino</td>
								    <td class="Estilo2">Als. Repitentes </td>
								     <? $Total_Grado=0;
									 	for($x=1;$x<=8;$x++){
									 		$sql = "SELECT count(*) as cuenta FROM alumno$nro_ano WHERE sexo=1 AND rut_alumno in
(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)."  AND bool_rg=1 AND id_curso in
(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)."  AND grado_curso=1))";
											$result = @pg_exec($conn,$sql);
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];
												?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								  <tr>
								    <td class="Estilo2">Femenino</td>
								    <td class="Estilo2">Als. Integrados </td>
								     <? $Total_Grado=0;
									 	for($x=1;$x<=8;$x++){
									 		$sql = "SELECT count(*)as cuenta FROM alumno$nro_ano WHERE sexo=1 AND rut_alumno in
(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)."  AND bool_i=1 AND id_curso in
(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)."  AND grado_curso=1))";
											$result = @pg_exec($conn,$sql);
											$fila = @pg_fetch_array($result,0);
											$Total_Grado = $Total_Grado + $fila['cuenta'];?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
								  <tr>
								    <td class="Estilo2">Femenino</td>
								    <td class="Estilo2">Als. Origen Indigena </td>
								     <? $Total_Grado=0;
									 	for($x=1;$x<=8;$x++){
											$sql = "SELECT count(*)as cuenta FROM alumno$nro_ano WHERE sexo=1 AND rut_alumno in
(SELECT rut_alumno FROM matricula$nro_ano WHERE id_ano=".trim($ano)."  AND bool_aoi=1 AND id_curso in
(SELECT id_curso FROM curso WHERE id_ano=".trim($ano)."  AND grado_curso=1))";
											$result = @pg_exec($conn,$sql);
											$fila = @pg_fetch_array($result,0);
										?>
                                    <td class="Estilo2"><div align="right"><? echo $fila['cuenta'];?></div></td>
									<? 	} ?>
								    <td class="Estilo2"><div align="right"><? echo $Total_Grado;?></div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
								    <td class="Estilo2"><div align="right">0</div></td>
							      </tr>
                                </table>
								<BR>
                                <table width="650" border="0" cellpadding="0" cellspacing="0" class="Estilo2">
                                  <tr>
                                    <td>CURSOS COMBINADOS </td>
                                  </tr>
                                  <tr>
                                    <td valign="top"><table width="650" border="1" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td rowspan="7" class="Estilo2">CURSOS <br>
                                          COMBINADOS</td>
                                        <td rowspan="2" class="Estilo2">CURSOS</td>
                                        <td colspan="8" class="Estilo2"><div align="center">MATRICULA</div></td>
                                        <td rowspan="2" class="Estilo2">TOTAL</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">1</td>
                                        <td class="Estilo2">2</td>
                                        <td class="Estilo2">3</td>
                                        <td class="Estilo2">4</td>
                                        <td class="Estilo2">5</td>
                                        <td class="Estilo2">6</td>
                                        <td class="Estilo2">7</td>
                                        <td class="Estilo2">8</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">1ER CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">2DO CURO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">3ER CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">4TO CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">5TO CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
								<BR>
                                <table width="650" border="0">
                                  <tr>
                                    <td class="Estilo2">RESUMEN DE MATRICULA, N&Uacute;MERO DE CURSOS POR JORNADA Y HORARIO DE FUNCIONAMIENTO </td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">CURSOS COMBINADOS </td>
                                  </tr>
                                  <tr>
                                    <td><table width="100%" border="1">
                                      <tr>
                                        <td rowspan="2" class="Estilo2">JORN.CURSOS<br>
                                          CAMBINADOS</td>
                                        <td colspan="2" class="Estilo2"><div align="center">Horario</div></td>
                                        <td colspan="2" class="Estilo2"><div align="center">Total</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          1</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          2</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          3</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          4</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          5</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2"><div align="center">Desde</div></td>
                                        <td class="Estilo2"><div align="center">Hasta</div></td>
                                        <td class="Estilo2"><div align="center">N&ordm; Cursos </div></td>
                                        <td class="Estilo2"><div align="center">Matric.</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2"><strong>TOTAL</strong></td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
										<td class="Estilo2"><div align="right">0</div></td>
										<td class="Estilo2"><div align="right">0</div></td>
										<td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">Ma&ntilde;ana</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">Tarde</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">Ma&ntilde;ana y Tarde </td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="650" border="0">
                                  <tr>
                                    <td class="Estilo2">CURSOS SIMPLES </td>
                                  </tr>
                                  <tr>
                                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td rowspan="2" class="Estilo1">JORNADA<br>
                                          C.SIMPLES</td>
                                        <td colspan="2" class="Estilo1">Horario</td>
                                        <td colspan="2" class="Estilo1">Total</td>
                                        <td colspan="2" class="Estilo1"><div align="center">1&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">2&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">3&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">4&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">5&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">6&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">7&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">8&ordm;</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Desde</td>
                                        <td class="Estilo1">Hasta</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo6">TOTAL</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
										<? 	$sql = "SELECT COUNT(*) FROM curso WHERE id_ano='$ano' AND ensenanza=110";
											$result =@pg_exec($conn,$sql);
											$Total_Curso = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Total_Curso;?></div></td>
										<?	$sql =" SELECT COUNT(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in ";
											$sql.=" (SELECT id_curso FROM curso WHERE ensenanza=110 AND id_ano='$ano')";
											$result = @pg_exec($conn,$sql);
											$Total_Mat = @pg_result($result,0);										
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Total_Mat;?></div></td>
										<?  for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE ID_ANO='$ano' AND id_curso IN ";
											$sql.="(SELECT id_curso FROM curso WHERE grado_curso='$i' AND id_ano='$ano' AND ";
											$sql.=" ensenanza=110)";
											$result = @pg_exec($conn,$sql);
											$totalmat = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND grado_curso='$i' AND ";
											$sql.=" ensenanza=110";
											$result = @pg_exec($conn,$sql);
											$Total = @pg_result($result,0);
										?>
										<td class="Estilo2"><div align="right"><? echo $Total;?></div></td>
										<td class="Estilo2"><div align="right"><? echo $totalmat;?></div></td>
										<? } ?>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Ma&ntilde;ana</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
										<? 	$sql= " SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=1 AND ";
											$sql.=" ensenanza=110 ";
											$result =@pg_exec($conn,$sql);
											$Curso_Man = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Curso_Man;?></div></td>
										<?
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in (SELECT id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND bool_jor=1)";
											$result = @pg_exec($conn,$sql);
											$Total_Man = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Total_Man;?></div></td>
										<? 	for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=1 AND ";
											$sql.=" ensenanza=110 AND grado_curso='$i' ";
											$result =@pg_exec($conn,$sql);
											$Curso_M = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in (SELECT ";
											$sql.=" id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND ";
											$sql.=" grado_curso='$i' AND bool_jor=1)";
											$result = @pg_exec($conn,$sql);
											$Total_M = @pg_result($result,0);
											
										
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Curso_M;?></div></td>
                                        <td class="Estilo2"><div align="right"><? echo $Total_M;?></div></td>
										<? } ?>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Tarde</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <? 	$sql= " SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=2 AND ";
											$sql.=" ensenanza=110 ";
											$result =@pg_exec($conn,$sql);
											$Curso_Man = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Curso_Man;?></div></td>
										<?
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in (SELECT id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND bool_jor=2)";
											$result = @pg_exec($conn,$sql);
											$Total_Man = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Total_Man;?></div></td>
										<? 	for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=2 AND ";
											$sql.=" ensenanza=110 AND grado_curso='$i' ";
											$result =@pg_exec($conn,$sql);
											$Curso_T = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in (SELECT ";
											$sql.=" id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND ";
											$sql.=" grado_curso='$i' AND bool_jor=2)";
											$result = @pg_exec($conn,$sql);
											$Total_T = @pg_result($result,0);
											
										
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Curso_T;?></div></td>
                                        <td class="Estilo2"><div align="right"><? echo $Total_T;?></div></td>
										<? } ?>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Ma&ntilde;ana y Tarde </td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <? 	$sql= " SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=3 AND ";
											$sql.=" ensenanza=110 ";
											$result =@pg_exec($conn,$sql);
											$Curso_Man = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Curso_Man;?></div></td>
										<?
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in (SELECT id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND bool_jor=3)";
											$result = @pg_exec($conn,$sql);
											$Total_Man = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Total_Man;?></div></td>
											<? 	for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=3 AND ";
											$sql.=" ensenanza=110 AND grado_curso='$i' ";
											$result =@pg_exec($conn,$sql);
											$Curso_MT = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM matricula$nro_ano WHERE id_ano='$ano' AND id_curso in (SELECT ";
											$sql.=" id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND ";
											$sql.=" grado_curso='$i' AND bool_jor=3)";
											$result = @pg_exec($conn,$sql);
											$Total_MT = @pg_result($result,0);
											
										
										?>
                                        <td class="Estilo2"><div align="right"><? echo $Curso_MT;?></div></td>
                                        <td class="Estilo2"><div align="right"><? echo $Total_MT;?></div></td>
										<? } ?>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="650" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="234" height="20" class="Estilo2">Nombre Responsable llenado Formulario </td>
                                    <td width="175" height="30" class="Estilo2"><u><? echo ucwords(strtolower($UTP));?></u></td>
                                    <td width="241" height="10" class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="30" class="Estilo2">Nombre del Director del Establecimiento </td>
                                    <td height="20" class="Estilo2"><u><? echo ucwords(strtolower($Director));?></u></td>
                                    <td height="20" class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">_______________________________________</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2"><div align="center">Nombre del Director y Timbre del Establecimiento </div></td>
                                  </tr>
                                </table>
                                <br>
                                <br>
                          </td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema 
                de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
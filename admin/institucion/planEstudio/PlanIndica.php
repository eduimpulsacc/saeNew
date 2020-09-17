<?php 
	require('../../../util/header.inc');
	$_POSP = 3;
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	 
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPLAN.value!=0){
				form.cmbPLAN.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'PlanIndica.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg','../botones/periodo_roll.gif','../botones/feriados_roll.gif','../botones/tipos_roll.gif','../botones/cursos_roll.gif','../botones/matricula_roll.gif','../botones/informe_roll.gif','../botones/reportes_roll.gif','../botones/actas_roll.gif','../botones/generar_roll.gif')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
		   <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
          <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr valign="top"> 
                                  <td height="390">
								  <!---- inicio codigo -->
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
     <!-- <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../ano/periodo/listarPeriodo.php3"><img src="../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/feriado/listaFeriado.php3"><img src="../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../botones/planes_roll.gif" name="Image4" width="81" height="30" border="0" id="Image4"></a></td>
          <td width="81" height="30"><a href="../atributos/listarTiposEnsenanza.php3"><img src="../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/curso/listarCursos.php3"><img src="../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/matricula/listarMatricula.php3"><img src="../botones/matricula.gif" name="Image71" width="81" height="30" border="0" id="Image71" onMouseOver="MM_swapImage('Image71','','../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ano/ActasMatricula/Menu_Actas.php?botonera=1"><img src="../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81"><a href="generar();"><img src="../botones/linea.gif" width="81" height="30" border="0"></a></td>
        </tr>
      </table> --></td>
  </tr>
</table>

		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		
		<SCRIPT language="JavaScript">
		
		
		
			function valida(form){
				if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
					return false;
				};
				if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
					return false;
				};
				//if(!chkVacio(form.txtLETRA,'Ingresar LETRA del curso.')){
				//	return false;
				//};
				//if(!letraOnly(form.txtLETRA,'Se permiten sólo letras para la LETRA del curso.')){
				//	return false;
				//};
				if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
					return false;
				};

				if(!form.cmbPLAN.disabled){
					if(!chkSelect(form.cmbPLAN,'Seleccionar DECRETO DE PLAN DE ESTUDIO del curso.')){
						return false;
					};
				};
				if(!form.cmbEVAL.disabled){
					if(!chkSelect(form.cmbEVAL,'Seleccionar DECRETO DE EVALUACION del curso.')){
						return false;
					};
				};

				if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
					return false;
				};
				//VALIDACION TIPO DE ENSEÑANZA
				/*if(form.cmbENS.value==110){
					if(form.txtGRA.value>8){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					}
				}else{
					if(form.txtGRA.value>5){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					};
				};*/
				//FIN VALIDACION TPO DE ENSEÑANZA
				if(!chkFecha(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
				return true;
			}
		</SCRIPT>
	</head>
	<form method="post" name="frm" action="procesoPlanEstudio.php3">
	<?php //echo tope("../../../util/");?>
                        <table border="0" cellpadding="0" cellspacing="0" width=600  align="center">
                         <tr>
                            <TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD width="1%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD width="85%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result){
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
                       </tr>
                     </table>
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=600>
						<tr>
							<td align="left" width=0>
								<table width="99%" align=center>
            					<tr valign=bottom>
										
              <td width="17%" height="26"> </td>
										<td width="69%"align=right>
									 <INPUT class="botonXX" TYPE="submit" value="GUARDAR" onClick=document.location="return valida(this.form);">
										</td>
             			 				<td width="14%" align=right>
			  						<INPUT class="botonXX" TYPE="button" value="VOLVER" onClick=document.location="listarPlanesEstudio.php3"> </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							
        <td align="center" colspan="2">&nbsp; </td>
						</tr>
					</table>
					</center>
				
<?php
           
			
	if($frmModo=="mostrar"){
	   
		$qry="SELECT DISTINCT plan_estudio.* FROM plan_estudio  WHERE ((plan_estudio.cod_decreto)=".$plan.") ORDER BY cursos";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
					exit();
				};
			};
		};
	};
?>

	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=600 align=center>
		<tr>
			<td colspan=6>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
												
					</tr>
                        
				</table>
			</td>
		</tr>
		<tr height="20" bgcolor="#003b85">
			
    <td colspan="6" class="tableindex">  PLAN DE ESTUDIO</td>
		</tr>
		
			
    <td ALIGN=CENTER WIDTH=187> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>DECRETO DE PLAN DE ESTUDIO</strong> </font> </td>
			
    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>CODIGO DE DECRETO</strong></font> </td>
			 
    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>DESCRIPCION</strong> </font> </td>
 		</tr>
				
    
			<td align="center"> 
				<?php if($frmModo=="mostrar"){ ?>
				<?php } ?>
				<?php if($frmModo=="ingresar1"){ ?>
					<select name="cmbPLAN" onChange="enviapag(this.form);">
					<option value=0 selected>Selecione Plan de Estudio</option>
				<?php
					$qry="select * from plan_estudio where rdb=0"; 
					$result =@pg_Exec($conn,$qry);
					$fila= @pg_fetch_array($result,0);
						for($i=0 ; $i < @pg_numrows($result) ; $i++){
							$fila = @pg_fetch_array($result,$i);
								if ($fila["cod_decreto"]==$cmbPLAN){
									echo  "<option selected value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
								}else{
									echo  "<option value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
								}
											
						}?>
					
					</select>
						<?php };?>	
			</td>
			
			 
      <td align="center"> 
        <?php if($frmModo=="mostrar"){ ?>
        <? } ?>
        <?php if($frmModo=="ingresar1"){
	  $qry="select * from plan_estudio where cod_decreto=".$cmbPLAN;
		$result =@pg_Exec($conn,$qry);
		$fila= @pg_fetch_array($result,0);?>
	   <font size="2" face="Arial, Helvetica, sans-serif"> <?php echo $fila["cod_decreto"];?></font>
       <?php } ?>
      </td>
				<td align="center">
				<?php if($frmModo=="mostrar"){ ?>
				<? } ?>
				<?php if($frmModo=="ingresar1"){ ?>
		<font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila["cursos"];?></font>
				 <?PHP }?>
				</td>
			</tr>
			
		
		<tr>
			<td colspan="6">
			<br>
			
			</td>
		</tr>

		 <tr>
			<td colspan="6">
			<hr width="100%" color="#0099cc">
			</td>
		</tr>
		<tr height="50" bgcolor="white">
			
    <td align="middle" colspan="6">&nbsp; </td>
		</tr>
		   
	</table>
</form>

								  
								  
								  
								  
								  
								  
								  <!-- fin codigo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><div align="center">SAE 
                          Sistema de Administraci&oacute;n Escolar - 2005 - Desarrolla 
                          Colegio Interactivo</div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

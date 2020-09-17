<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$anotacion		=$_ANOTACION;
	$empleado		=$_EMPLEADO;
	$alumno			=$_ALUMNO;
	$desde			=$_DESDE;
	$ano			=$_ANO;

	$_POSP          =4;
	$_bot           =5;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANOTACION WHERE ID_ANOTACION=".$anotacion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1333)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
	$sql_peri = "select * from periodo where id_ano = ".$ano;
	$result_peri = pg_exec($conn,$sql_peri);
?>
<HTML>
	<HEAD>

			
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			var nro=0;
		
			function valida(form){	
			    if(!chkVacio(form.sigla2,'Ingrese SIGLA.')){
						return false;
				};
				if(!chkVacio(form.codigo2,'Ingrese CODIGO.')){
						return false;
				};					
			
			    if(!chkSelect(form.cmb_periodos2,'Debe Seleccionar PERIODO.')){
						return false;
				};

				if(!chkVacio(form.txtFECHA2,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA2,'Fecha inválida.')){
					return false;
				};

/*				if(!chkVacio(form.txtOBS2,'Ingresar OBSERVACION.')){
					return false;
				};*/
						
				form.por.value=1;		
								
				return true;
				
				
			}
			
			
			function valida2(form){	
			   
			    if(!chkSelect(form.cmb_periodos,'Debe Seleccionar PERIODO.')){
				       
						return false;
				};				
				
				if(!chkSelect(form.sigla_subsector,'Debe Seleccionar SUBSECTOR APRENDIZAJE.')){
				        
						return false;
				};
				
				if(!chkSelect(form.tipo_anotacion,'Debe Seleccionar TIPO ANOTACIÓN.')){
						
						return false;
				};
				
				if(!chkSelect(form.detalle_anotaciones,'Debe Seleccionar SUB TIPO.')){
						
						return false;
				};				

				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					
					return false;
				};

/*				if(!chkVacio(form.txtOBS,'Ingresar OBSERVACION.')){
					return false;
				};*/
				
				form.por.value=2;
								
				return true;
			}

			
		</SCRIPT>

<?php }?>


<SCRIPT type=text/javascript>
<!--
/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.botones1{display: none;}\n')

<?
if (isset($tipo_anotacion)){ ?>
   document.write('.submenu20{display: block;}\n')
   
<?
	
}else{ ?>	
    document.write('.submenu20{display: none;}\n')
    document.write('.botones2{display: none;}\n')
<? } ?>

document.write('</style>\n')
}


function SwitchMenuAnotacion(obj){  
   
	    var el = document.getElementById(obj);
		var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		
	   
	    if (el.className=="submenu1"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu20") //DynamicDrive.com change
				ar[i].style.display = "none";
				
				if (ar[i].className=="botones1") //DynamicDrive.com change
				   ar[i].style.display = "block";				
				
				if (ar[i].className=="botones2") //DynamicDrive.com change
				   ar[i].style.display = "none";
			}
		   
		   
	    }
	
	    if (el.className=="submenu20"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu1") //DynamicDrive.com change
				ar[i].style.display = "none";
				
				
				if (ar[i].className=="botones2") //DynamicDrive.com change
				   ar[i].style.display = "block";				
				
				if (ar[i].className=="botones1") //DynamicDrive.com change
				   ar[i].style.display = "none";
				   
				   
			}
	    }	
}


function enviapag(form){
    form.action = 'anotacion.php3';
	form.submit(true);
}


function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
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
<style type="text/css">
<!--
.Estilo2 {font-size: 9px}
.Estilo3 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 9px; }
.Estilo7 {font-family: Georgia, "Times New Roman", Times, serif; font-size: 9px; font-weight: bold; color: #FF0000; }
.Estilo9 {font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo13 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="91%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral= "3_1"; 
						include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  
								  
								  <!-- INICIO CODIGO ANTIGUO -->




	<?php //echo tope("../../../../util/");?>
	<!--FORM method=post name="frm" action="seteaAnotacion.php3?pag=procesoAnotacion.php3&caso=2&desde= echo $desde &frmModo= echo $frmModo &alumno= echo $alumno "-->
	<FORM method=post name="frm" action="procesoAnotacion__.php3">
	<?php 
		echo "<input type=hidden name=rut value=".$alumno.">";
		echo "<input type=hidden name=emp value=".$empleado.">";
	?>
		
		<input name="por" type="hidden" id="por">
		<div id="masterdiv3">	
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
										
									
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
											
											
											
											
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>RESPONSABLE</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
																
										<?php 
										
										
										
										  if ($_PERFIL!=0){ 
											$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$empleado;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_emp']);
												}
											}
										}	
										
										
										
										
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
							  <span class="botones1">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="right"><?php if($frmModo=="ingresar"){ ?>
                                      <input class="botonXX"  type="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >
                                      &nbsp;
                                      <?php if ($desde!="alumno"){ 
											echo ?>
                                      <input class="botonXX"  type="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAnotacion.php3">
                                      &nbsp;
                                      <?php }else{ 
											echo ?>
                                      <input class="botonXX"  type="button" value="CANCELAR" name=btnCancelar onClick=document.location="../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4">
                                      <?php } ?>
                                      <?php };?>
                                      <?php if($frmModo=="mostrar"){ ?>
                                      <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
                                      <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
                                      <!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar disabled-->
                                      &nbsp;
                                      <?php }?>
                                      <?php }?>
                                      <input name="button"  type="button" class="botonXX" onClick=document.location="listarAnotacion.php3" value="VOLVER">
                                      &nbsp;
                                      <?php };?></td>
                                  </tr>
								</table>
								</span>
								
								<span class="botones2">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">  
                                  <tr>
                                    <td align="right">
									<?php if($frmModo=="ingresar"){ ?>
                                      <input class="botonXX"  type="submit" value="GUARDAR"   name=btnGuardar onClick="return valida2(this.form);" >
                                      &nbsp;
                                      <?php if ($desde!="alumno"){ 
											echo ?>
                                      <input class="botonXX"  type="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAnotacion.php3">
                                      &nbsp;
                                      <?php }else{ 
											echo ?>
                                      <input class="botonXX"  type="button" value="CANCELAR" name=btnCancelar onClick=document.location="../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4">
                                      <?php } ?>
                                      <?php };?>
                                      <?php if($frmModo=="mostrar"){ ?>
                                      <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
                                      <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
                                      <!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar disabled-->
                                      &nbsp;
                                      <?php }?>
                                      <?php }?>
                                      <input name="button"  type="button" class="botonXX" onClick=document.location="listarAnotacion.php3" value="VOLVER">
                                      &nbsp;
                                      <?php };?>								
									
									</td>
                                  </tr>
                                </table>
								</span>
								
								</TD>
						</TR>
						
						
						<TR height=20 >
							<TD align=middle colspan=2 class="tableindex">ANOTACION </TD>
						</TR>
						
						
						<TR height=20 >
							<TD align=middle colspan=2><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><div class="Estilo9" onClick="SwitchMenuAnotacion('ingresocodigo')">
                                    <div align="center">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><a href="#">INGRESO POR CODIGO </a></td>
                                        </tr>
                                      </table>
                                    </div>
                                </div></td>
                                <td><div class="Estilo9" onClick="SwitchMenuAnotacion('ingresonormal')">
                                    <div align="center">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><a href="#">INGRESO POR SELECCI&Oacute;N </a></td>
                                        </tr>
                                      </table>
                                    </div>
                                </div></td>
                               
                                <td><div align="center"><a href="anotacion_old.php">INGRESO DE ANOTACION TRADICIONAL </a></div></td>
                               
                              </tr>
                            </table></TD>
						</TR>
						
					
						<TR height=0 >
							<TD align=middle colspan=2 >					
							
							<span class="submenu1" id="ingresocodigo">
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td width="30%"><span class="Estilo3">CODIGO DE ANOTACION </span></td>
                                <td width="40%">
								
								<table width="150" border="0" align="center" cellpadding="3" cellspacing="0">
                                  <tr>
                                    <td><div align="center"><span class="Estilo3">SIGLA</span></div></td>
                                    <td><div align="center"></div></td>
                                    <td><div align="center"><span class="Estilo3">CODIGO</span></div></td>
                                  </tr>
                                  <tr>
                                    <td><label>
                                      <div align="center">
                                        <input name="sigla2" type="text" id="sigla2" size="4">
                                        <span class="Estilo7">(*)</span></div>
                                      </label></td>
                                    <td><div align="center">-</div></td>
                                    <td><label>
                                      <div align="center">
                                        <input name="codigo2" type="text" id="codigo2" size="4">
                                        <span class="Estilo7">(*)</span></div>
                                      </label></td>
                                  </tr>
                                </table>						
								
								</td>
                                <td width="30"><label> <br>
                                </label></td>
                              </tr>
							  
							  <tr>
								  <td width="30%"><span class="Estilo2"><font face="Geneva, Arial, Helvetica" color=#000000>PERIODO</font></span></td>
								  <td width="70%"><select name="cmb_periodos2" class="ddlb_9_x Estilo2">
                                    <option value=0 selected>(Seleccione Periodo)</option>
                                    <?
										
										
										  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
										  {
										  $fila1 = @pg_fetch_array($result_peri,$i); 
										  if ($fila1['id_periodo']==$cmb_periodos)
											echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  else
											echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  ?>
                                    <? } 
									
									
									
									
									?>
                                  </select> 
								    <span class="Estilo7">(*) </span></td>
								</tr>
								
								
							  <tr>
								  <td width="30%"><span class="Estilo3">FECHA</span></td>
								  <td width="70%"><span class="Estilo2">
								    <label>
								    <INPUT type="text" name="txtFECHA2" size="10" maxlength="10">
								    <span class="Estilo7">(*)</span>								    <br>
										<FONT face="arial, geneva, helvetica" size=1 color=#000000>
											<STRONG>(DD-MM-AAAA)</STRONG>										</FONT>								    </label>
								  </span></td>
								  </tr>
								<tr>
								  <td width="30%"><span class="Estilo3">OBSERVACI&Oacute;N</span></td>
								  <td width="70%"><span class="Estilo2">
								    <textarea name="txtOBS2" cols="40" rows="5"></textarea>
								  </span></td>
								  </tr>
								  
								<tr>
								  <td colspan="2"><div align="center"><span class="Estilo13">(*) Datos obligatorios </span></div></td>
								  </tr> 						  
                            </table>
							</span>				
							
							
							
							</TD>
						</TR>
						
						
						<tr>
							
							<td>
							
														
							<span class="submenu20" id="ingresonormal">
							<table width="100%" border="0" cellpadding="5" cellspacing="0">
								<tr>
								  <td width="30%"><span class="Estilo2"><font face="Geneva, Arial, Helvetica" color=#000000>PERIODO</font></span></td>
								  <td width="70%"><select name="cmb_periodos" class="ddlb_9_x Estilo2">
                                    <option value=0 selected>(Seleccione Periodo)</option>
                                    <?
										
										
										  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
										  {
										  $fila1 = @pg_fetch_array($result_peri,$i); 
										  if ($fila1['id_periodo']==$cmb_periodos)
											echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  else
											echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  ?>
                                    <? } 
									
									
									
									
									?>
                                  </select> 
								    <span class="Estilo7">(*)								    </span></td>
								</tr>
								
								
								
							
								
								<tr>
								  <td width="30%"><span class="Estilo3">SECTOR DE APRENDIZAJE </span></td>
								  <td width="70%"><span class="Estilo2">
								    <label>
									<?
									 $q100 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion' order by detalle";
									 $r100 = pg_Exec($conn,$q100);
									 $n100 = pg_numrows($r100);
									  
									 ?> 
									
								    <select name="sigla_subsector">
									  <option value="0">Seleccione Sector de Aprendizaje </option>
									  <?
									  
								
									  $j = 0;
									  while ($j < $n100){
									       $f100 = pg_fetch_array($r100,$j);
										   $sigla    = $f100['sigla'];
										   $detalle  = $f100['detalle'];
										   $id_sigla = $f100['id_sigla'];
										   ?>
										   <option value="<?=$id_sigla ?>" <? if ($sigla_subsector==$id_sigla) { ?> selected="selected" <? } ?> ><? echo "$detalle - $sigla"; ?></option>
										   <?
										   $j++;
									  }
									 
									  
									  ?>									
								      </select>
								    </label>
								  </span></td>
								</tr>
								<tr>
								  <td width="30%"><span class="Estilo3">TIPO ANOTACION </span></td>
								  <td width="70%"><span class="Estilo2">
								     <?
									
									  $q200 = "select * from tipos_anotacion where rdb = '$institucion'";
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
									  
								  
								    <select name="tipo_anotacion" onChange="enviapag(this.form);">
									  <option value="0">Seleccione Tipo de Anotación </option>
									  <?									
									
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $id_tipo = $f200['id_tipo'];
										   $codtipo = $f200['codtipo'];
										   $descripcion = $f200['descripcion'];
										   ?>
										   <option value="<?=$id_tipo ?>" <? if ($tipo_anotacion==$id_tipo){ ?> selected="selected" <? }  ?> ><? echo "$codtipo - $descripcion"; ?></option>
										   <?
										   $k++;
									  }						  
									
									    
								     ?>
									</select>
									
								  </span></td>
								  </tr>
								<tr>
								  <td width="30%"><span class="Estilo3">SUB TIPO </span></td>
								  <td width="70%"><span class="Estilo2">
								    <?
									
								
									
									  $q300 = "select * from detalle_anotaciones where id_tipo = '".trim($tipo_anotacion)."' order by codigo";
									  $r300 = @pg_Exec($conn,$q300);
									  $n300 = @pg_numrows($r300);
									
									?>
									<select name="detalle_anotaciones">
									   <option value="0">Seleccione Sub-Tipo de Anotación</option>
									  
									 <?								
									 
																  
									  $l = 0;
									  while ($l < $n300){
									       $f300 = pg_fetch_array($r300,$l);
										   $codigosubtipo  = $f300['codigo'];
										   $detallesubtipo = $f300['detalle'];
										   
										   if ($codigosubtipo!=NULL){
										       ?>
										       <option value="<?=$codigosubtipo ?>"><? echo "$codigosubtipo - $detallesubtipo"; ?></option>
										       <?
										   }	   
										   $l++;
									  }		  	 
										 
										 
									
									 ?>	   
                                    </select>
								  </span></td>
								  </tr>
								  
						 
								<tr>
								  <td width="30%"><span class="Estilo3">FECHA</span></td>
								  <td width="70%"><span class="Estilo2">
								    <label>
								    <INPUT type="text" name=txtFECHA size=10 maxlength=10>
								    <span class="Estilo7">(*)</span>								    <br>
										<FONT face="arial, geneva, helvetica" size=1 color=#000000>
											<STRONG>(DD-MM-AAAA)</STRONG>										</FONT>								    </label>
								  </span></td>
								  </tr>
								<tr>
								  <td width="30%"><span class="Estilo3">OBSERVACI&Oacute;N</span></td>
								  <td width="70%"><span class="Estilo2">
								    <textarea name="txtOBS" cols="40" rows="5"></textarea>
								  </span></td>
								  </tr>
								  
								<tr>
								  <td colspan="2"><div align="center"><span class="Estilo13">(*) Datos obligatorios </span></div></td>
								  </tr>  
							  </table>
							  </span>
							</td>
						</tr>
						
						
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
		</div>
	</FORM>
	
	
                             <!-- FIN CODIGO ANITGUO -->
 
                               </td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>"></td>
        </tr>
      </table></td>
  </tr>
</table>	
	
</BODY>
</HTML>
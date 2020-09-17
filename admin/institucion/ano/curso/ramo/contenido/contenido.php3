<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$archivo		=$_ARCHIVO;
	$_POSP          =6;
	$_bot           =5;
	$_MDINAMICO = 1;
?>
<?php
	if($frmModo!="ingresar"){
	    $qry="SELECT * FROM ARCHIVO WHERE ID_ARCHIVO=".$archivo;
		$result =@pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>

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

$( function() {
    $( "#txtFECHAENTREGA" ).datepicker(
	{
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	firstDay: 1,
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	//buttonImage: '../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/datepicker/images/calendar.gif',
	}
	);
  } );

function MyD(fi){
			$.ajax({
				url:"marcaarcl.php",
				data:"funcion=1&ida="+fi,
				type:'POST',
				success:function(data){
				//console.log(data);
				location.reload();
		  }
		})  
}
</script>
	<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
		<?php if($frmModo=="ingresar"){?>
			<SCRIPT language="JavaScript">
			
				function valida(form){
				   // alert('Recuerde ingresar solo caracteres validos');
				    //if(!chkVacio(form.txtUPLOAD,'Ingresar ARCHIVO FISICO')){
						//return false;
					//};
					var fileName = form.txtUPLOAD.value;
				
							if(fileName.length==0 && form.txtDESCRIPCION.value.length==0){
									if(!confirm("Si no sube archivo, Debe completar el campo descripci\xf3n, \xBfdesea continuar?")){
										return false;
										
									}
									else{
										form.txtDESCRIPCION.focus();
										return false;
									}
										
										
								}else{
									if(fileName.length==0 && form.txtDESCRIPCION.value.length>=0){
										
										return true;
									}
									else if(fileName.length>0 && form.txtDESCRIPCION.value.length==0){
										alert("Debe completar el campo descripci\xf3n de archivo");
										return false;
									}
									else{
										var patron = /^[-_\w\.\:\\]+$/;
										if(patron.test(form.txtUPLOAD.value)){
										form.txtNOMBRE.value=tomaNombre(form.txtUPLOAD);
										return true;
										//alert("pasa");
										}else{
											alert("El nombre del Archivo no es Valido Solo puede tener Letras y Numeros");
											return false;
											}
									}
								}
					
							
							
							return false;
				}
						
						
						$(document).on('change','input[type="file"]',function(){
	// this.files[0].size recupera el tamaÃ±o del archivo
	// alert(this.files[0].size);
	
	var fileName = this.files[0].name;
	var fileSize = this.files[0].size;

	if(fileSize > 10485760){
		alert('El archivo no debe superar los 10MB');
		this.value = '';
		//this.files[0].name = '';
	}else{
		// recuperamos la extensiÃ³n del archivo
		var ext = fileName.split('.').pop();
		
		// Convertimos en minÃºscula porque 
		// la extensiÃ³n del archivo puede estar en mayÃºscula
		ext = ext.toLowerCase();
    
		// console.log(ext);
		switch (ext) {
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx': 
			case 'ppt':
			case 'pptx':
			case 'pps':
			case 'ppsx':
			case 'pdf':
			case 'zip': 
			case 'rar':break;
			default:
				alert('El archivo no tiene la extensi\xf3n adecuada');
				this.value = ''; // reset del valor
				//this.files[0].name = '';
		}
	}
});
						
			</SCRIPT>
		<?php }?>
		<?php if($frmModo=="modificar"){?>
			<SCRIPT language="JavaScript">
				function valida(form){
					return true;
				}
			</SCRIPT>
		<?php }?>
	<?php }?>
	
<style>
div.ui-datepicker{
	font-size:12px;
	}
</style>
</head>
<link href="../../../../../../<?=$_ESTILO ?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <? $menu_lateral="3_1";?>  <? include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo antiguo  -->
								  
								  
								  
								  
								  
								  
<? if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=17)&&($_PERFIL!=15)&&($_PERFIL!=16)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="95%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top">&nbsp; 
       </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../../../util/");?>
	<FORM method=post name="frm" action="procesoContenido.php3" enctype="multipart/form-data" size="10240">
	<input name="ramo_new" type="hidden" value="<?=$ramo;?>">
		<TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
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
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
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
													echo trim($fila1['nombre_instit']);
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
									<strong>A&Ntilde;O ESCOLAR</strong>
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
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
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
									<strong>CURSO</strong>
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
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
									<strong>ASIGNATURA</strong>
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
											$qry="SELECT subsector.nombre FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre']);
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
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick=" return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarContenidos.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){?>
									<?php if(($_PERFIL==17)||($_PERFIL==0)||($_PERFIL==1) || ($_PERFIL==14) || ($_PERFIL==15) || ($_PERFIL==25) ){?>
										<?php if($_TIPODOCENTE==2 || ($_PERFIL==14) || ($_PERFIL==17) ){//PROFESOR DOCENTE?>
										<?			if($institucion==24977 || $institucion==9566){
													}else{	?>
											<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaContenido.php3?archivo=<?php echo $archivo?>&caso=3">&nbsp;
											<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick=document.location="seteaContenido.php3?caso=9;">&nbsp;
										<?			}	?>											
<!-- este iba despues del otro if -->
											<input name="button" type="button" class="botonXX" onClick=document.location="listarContenidos.php3"  value="VOLVER">										&nbsp;
										<?php }?>
										<?php if(($_PERFIL==0)||($_PERFIL==1)||($_PERFIL==25)){//ADMINISTRADORES?>
											<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaContenido.php3?archivo=<?php echo $archivo?>&caso=3">&nbsp;
											<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick=document.location="seteaContenido.php3?caso=9;">&nbsp;
											<input name="button" type="button" class="botonXX" onClick=document.location="listarContenidos.php3"  value="VOLVER">										&nbsp;
										<?php }?>	
									<?php }?>
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaContenido.php3?archivo=<?php echo $archivo?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 >
							<TD align=middle colspan=2 class="tableindex">
								ADJUNTAR ARCHIVOS
							</TD>
						</TR>
					<?php if($frmModo=="ingresar"){ ?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ARCHIVO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<TABLE width=100% CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD valign=top>
														<p>
														  <input type=file name=txtUPLOAD size=60>
														  <input type=hidden name=txtNOMBRE>
														</p>
														<p><strong><u>Observaciones</u></strong></p>
														<p>1_ El Archivo  no puede superar el peso m&aacute;ximo que es de 10 Mb</p>
                                                        <p>2_ El nombre  del Archivo no puede tener espacios ni caracteres que no sean n&uacute;meros letras o guiones.</p>
                                                        <p>3_ Los tipos de Archivos pueden ser extenciones de Office y Archivos PDF o RAR.</p>
                                                        <p>&nbsp;</p>
                                                        
                                                        </TD>
													<TD align=left width=65%><p>&nbsp;</p>
<p>&nbsp;</p></TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					<?php }?>
					<?php if($frmModo=="mostrar"){ ?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NOMBRE ARCHIVO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<TABLE width=100% CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD valign=top class="textosimple">
														<?php 
														   imp($fila['nombre_archivo']);
														?>
													</TD>
													<TD align=left width=65%>
														<?php												
														
												/*$output= "select lo_export(".$fila[archivo]."../../../../../../tmp/".trim($fila[nombre_archivo])."');";
												$retrieve_result = @pg_exec($conn,$output);*/
														if(strlen(trim($fila["nombre_archivo"]))>0){
														?>
														
														<a href="../../../../../../tmp/<?php echo trim($fila[nombre_archivo])?>" onmouseover=this.style.cursor='hand' title="Descargar" target="_blank">
															<img src= "../../../../../../util/disk2.png" width="30" border="0" >
														</a>
					<? } ?>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					<?php }?>
					<?php if($frmModo=="modificar"){ ?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NOMBRE ARCHIVO</STRONG>
											</FONT></TD>
									</TR>
									<TR>
										<TD>
											<TABLE width=100% CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD valign=top class="textosimple">
														<?php 
															imp($fila['nombre_archivo']);
														?>
													</TD>
													<TD align=left width=65%>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					<?php }?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5 width=100%>
                               <?php  //if($_PERFIL==0){?>
									<TR>
									  <TD><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>T&Iacute;TULO</STRONG></FONT></TD>
									  </TR>
									<TR>
									  <TD><?php if($frmModo=="ingresar"){ ?>
												<input name="txtTITULO" type="text" size="50">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													echo nl2br(htmlspecialchars(trim($fila['titulo'])));
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input name="txtTITULO" type="text" id="txtTITULO" value="<?php echo trim($fila['titulo'])?>" size="50">
											<?php };?></TD>
									  </TR>
                                      <?php // }?>
									<TR>
									  <TD>&nbsp;</TD>
									  </TR>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DESCRIPCION</STRONG>											</FONT>										</TD>
									</TR>
									<TR>
										<TD class="textosimple">
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtDESCRIPCION" cols="60" rows="5"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													echo nl2br(htmlspecialchars(trim($fila['descripcion_archivo'])));
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtDESCRIPCION" cols="60" rows="3"> <?php echo trim($fila['descripcion_archivo'])?></textarea>
											<?php };?>										</TD>
									</TR>
									<TR>
									  <TD>&nbsp;</TD>
									  </TR>
                                      
                                       <?php  //if($_PERFIL==0){?>
									<TR>
									  <TD><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>FECHA DE ENTREGA</STRONG></FONT></TD>
									  </TR>
									<TR>
									  <TD><?php if($frmModo=="ingresar"){ ?>
												<input name="txtFECHAENTREGA" type="text" id="txtFECHAENTREGA" size="10">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													echo CambioFD($fila['fecha_entrega']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input name="txtFECHAENTREGA" type="text" id="txtFECHAENTREGA" value="<?php echo CambioFD($fila['fecha_entrega'])?>" size="10">
											<?php };?></TD>
									  </TR>
                                      <?php //}?>  
                                      
                                      
									<TR>
									  <TD><FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>BIBLIOGRAF&Iacute;A WEB </STRONG>											</FONT>	 </TD>
									  </TR>
									<TR>
									  <TD>
									  <? if($frmModo=="ingresar" || $frmModo=="modificar"){?>
									  <input name="txtWEB1" type="text" size="50" value="<? echo $fila['web1'];?>"><FONT face="arial, geneva, helvetica" size=1 color=#000000>(*) </FONT>
									  <? }
									  	 if($frmModo=="mostrar"){
										 // $url1=str_replace("http://","",$fila['web1']);
										 $url1=$fila['web1']?>
											<a href="<? echo $url1;?>" target="_blank"><? echo $fila['web1'];?></a>
									  	 <? } ?>
									  
									  </TD>
									  </TR>
									<TR>
									  <TD>
									   <? if($frmModo=="ingresar" || $frmModo=="modificar"){?>
									  <input name="txtWEB2" type="text" size="50" value="<? echo $fila['web2'];?>"><FONT face="arial, geneva, helvetica" size=1 color=#000000>(*) </FONT>
									  <? }
									  	 if($frmModo=="mostrar"){
											// $url2=str_replace("http://","",$fila['web2']);
											 $url2=$fila['web2'];
											?>
											<a href="<? echo $url2;?>" target="_blank"><? echo $fila['web2'];?></a>
									  <? } ?>
									  </TD>
									  </TR>
									<TR>
									  <TD>
									   <? if($frmModo=="ingresar" || $frmModo=="modificar"){?>
									  <input name="txtWEB3" type="text" size="50" value="<? echo $fila['web3'];?>"><FONT face="arial, geneva, helvetica" size=1 color=#000000>(*) </FONT>
									   <? }
									  	 if($frmModo=="mostrar"){
										// $url3=str_replace("http://","",$fila['web3']);
										 $url3=$fila['web2'];
										 ?>
											<a href="<? echo $url3;?>" target="_blank"><? echo $fila['web3'];?></a>
									  <? } ?>
									  
									  
									  </TD>
									  </TR>
									<TR>
									  <TD><FONT face="arial, geneva, helvetica" size=1 color=#000000>(*)Copiar y Pegar la URL de la p&aacute;gina deseada</FONT></TD>
									  </TR>
								</TABLE>
							</TD>
						</TR>
                        <?php //if($_PERFIL==0){?>
						<TR>
						  <TD></TD>
						  <TD>&nbsp;</TD>
						  </TR>
						<TR>
						  <TD></TD>
						  <TD class="tableindex">RESPUESTAS ENVIADAS POR LOS ALUMNOS</TD>
						  </TR>
						<TR>
						  <TD></TD>
						  <TD>
                          <?php  $sqlRA = "select al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu as nombre,aa.* from archivo_alumno aa 
inner join alumno al on al.rut_alumno = aa.rut_alumno
where id_archivo = ".$fila['id_archivo']." order by 1";
				$rsRA = pg_exec($conn,$sqlRA);  ?>
                          
                          <table WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5>
						    <tr>
						      <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>ALUMNO</strong></font></td>
						      <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>FECHA ENV&Iacute;O</strong></font></td>
						      <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>FECHA MODIFICACI&Oacute;N</strong></font></td>
						      <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>VISTO</strong></font></td>
						      <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>ARCHIVO</strong></font></td>
						      </tr>
                              <?php if(pg_numrows($rsRA)==0){?>
						    <tr class="textosimple">
						      <td colspan="5" align="center">Sin respuestas</td>
						      </tr>
                            <?php   }else{
								for($aa=0;$aa<pg_numrows($rsRA);$aa++){
									$fila_aa = pg_fetch_array($rsRA,$aa);
								?>
						    <tr class="textosimple">
						      <td align="left"><?php echo $fila_aa['nombre'] ?></td> 
						      <td align="center"><?php echo CambioFD($fila_aa['fecha_carga']) ?></td>
						      <td align="center"><?php echo @CambioFD($fila_aa['fecha_modificacion']) ?></td>
						      <td align="center"><?php echo ($fila_aa['visto']==1)?"SI":"NO" ?></td>
						      <td align="center"><a href="../../../../../../fichas/alumno/respuesta_alumno/cargaFile/<?php echo $fila_aa['ruta'] ?>" target="_blank"><img src= "../../../../../../util/disk2.png" alt="Descargar Archivo" width="30" border="0" onClick="MyD(<?php echo $fila_aa['id_carga']?>)" style="cursor:pointer"></a></td>
						      </tr>
                              <?php 
								}
							   } ?>
						    </table></TD>
						  </TR>
                          <?php // }?>
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
	</FORM>

								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$horario		=$_HORARIO;
	$_POSP          =5;
	$bot = 5;
	
	
	
	$sql_ano = "SELECT * FROM ano_escolar WHERE id_ano=".$ano;
	$result_ano = @pg_Exec($conn,$sql_ano);
	$fils_ano = @pg_fetch_array($result_ano,0);
	
if (($_PERFIL!=0)&&($_PERFIL!=14)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)){$whe_perfil_curso=" and curso.id_curso=$curso";}	
	    
?>
<?php
	function LLenarCombo($sql,$cone,$param,$flag,$mensaje,$next=""){
		$Conexion = @pg_exec($cone,$sql);
		$fc="";
		if($next!=""){
		 $fc = 'onChange="siguiente(\''.$next.'\')";';
		}
		echo "<select " . $param . " $fc >";
		$cadena_vacio = $cadena_vacio . "&nbsp;";
		if ($flag=="true"){
			echo "<option style='Courier' value='null'>" . $mensaje . "</option>";
		};
		if ($Conexion){
			if (@pg_numrows($Conexion)!=0){
				$strValue = "       ";
				$fils = @pg_fetch_array($Conexion,0);
				for ($i=0;$i<pg_numrows($Conexion);$i++){
					$fils = @pg_fetch_array($Conexion,$i);
					echo "<option style='Courier' value='" . Trim($fils[0]) . "'>" . Trim($fils[1]) . $strValue . "</option>";
				};
			};
		};
		@pg_close($Conexion);
		echo "</select>";
	};
	if($frmModo!="ingresar"){
		//echo $qry = "SELECT trim(c.nombre) AS nombre, a.id_estancia, a.dia,  to_char(a.horaini,'HH24:MI') AS horaini, to_char(a.horafin,'HH24:MI') AS horafin FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . "  AND a.id_horario=" . $horario . "";
		$qry ="SELECT trim(c.nombre_taller) AS nombre, a.id_taller, a.id_ramo, a.id_estancia, a.dia, to_char(a.horaini,'HH24:MI') AS horaini, to_char(a.horafin,'HH24:MI') AS horafin 
				FROM horario a, taller c 
				WHERE a.id_horario=" . $horario . " and a.id_taller=c.id_taller union(SELECT trim(c.nombre) AS nombre, a.id_taller, a.id_ramo, a.id_estancia, a.dia, to_char(a.horaini,'HH24:MI') AS horaini, to_char(a.horafin,'HH24:MI') AS horafin FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . " AND a.id_horario=" . $horario . ")";		
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if(pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);
				if($fila['id_ramo']!="0")
					$Option="1";
				else
					$Option="2";

				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}else{
			$qry ="select *,to_char(horaini,'HH24:MI') AS horaini, to_char(horafin,'HH24:MI') AS horafin from horario where id_horario = '$horario'";		
				$result = @pg_Exec($conn,$qry);	
				$fila = @pg_fetch_array($result,0);
				$Option="2";
			}		
		}
	} ?>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
		
		
		<?php include('../../../../../util/rpc.php3');?>
	<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<?php if($frmModo=="modificar"){?>
				<SCRIPT LANGUAGE="JavaScript">
					function SeleccionaCombo(Objeto, valor){
						for (i=0;i < Objeto.options.length; i ++){
							if (Objeto.options[i].value == valor){
								Objeto.options[i].selected = true; 
							};
						};
					};
	
					function valida(form){
						if(!chkSelect(form.cmbESTANCIA,'Seleccionar Sala.')){
							return false;
						};

						if(!chkVacio(form.cmbDia,'Seleccionar DIA.')){
							return false;
						};

						if(!chkVacio(form.txtHoraIni,'Ingresar HORA INICIO.')){
							return false;
						};
						if(!chkHora(form.txtHoraIni,'Hora inválida.')){
							return false;
						};

						if(!chkVacio(form.txtHoraFin,'Ingresar HORA FIN.')){
							return false;
						};
						if(!chkHora(form.txtHoraFin,'Hora inválida.')){
							return false;
						};
						if (form.txtHoraIni.value > form.txtHoraFin.value){
							alert("La HORA INICIO es mayor a la HORA FIN.");
							form.txtHoraIni.focus();
							return false;
						};
						return true;
					}
				</SCRIPT>
		<?php }?>
		<?php if($frmModo=="ingresar"){?>
				<SCRIPT language="JavaScript">
					function SeleccionaCombo(Objeto, valor){
						for (i=0;i < Objeto.options.length; i ++){
							if (Objeto.options[i].value == valor){
								Objeto.options[i].selected = false; 
							};
						};
					}; 

					function valida(form){
											    					 	

						if(form.cmbRAMO.selectedIndex==0){	
							if(form.cmbTALLER.selectedIndex==0){												
								alert("Debe seleccionar Subsector o Taller.");
								return false;
							}
						}						
								    
						if(!chkSelect(form.cmbESTANCIA,'Seleccionar Sala.')){
							return false;
						};

						if(!chkVacio(form.cmbDia,'Seleccionar DIA.')){
							return false;
						};

						if(!chkVacio(form.txtHoraIni,'Ingresar HORA INICIO.')){
							return false;
						};
						if(!chkHora(form.txtHoraIni,'Hora inválida.')){
							return false;
						};

						if(!chkVacio(form.txtHoraFin,'Ingresar HORA FIN.')){
							return false;
						};
						if(!chkHora(form.txtHoraFin,'Hora inválida.')){
							return false;
						};
						if (form.txtHoraIni.value > form.txtHoraFin.value){
							alert("La HORA INICIO es mayor a la HORA FIN.");
							form.txtHoraIni.focus();
							return false;
						};
						form.submit();
						
					};
				
				</SCRIPT>
		<?php }?>
	<?php }?>
	
	

</HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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
function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=6&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=13&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }





siguienteCampo = "txtHoraIni";
nombreForm = "form";
        function TelcaPulsada( e ) {
                

           if ( window.event != null)                                
                  tecla = window.event.keyCode;
           else if ( e != null )                                 
                  tecla = e.which;
           else
                  return;
                
           if (tecla == 13) {                                         
                  if ( siguienteCampo == 'fin' ) {                        
                         return false                                        
                  } else { 
				//  alert(siguienteCampo);                                                
                        eval('document.form.' + siguienteCampo  + '.focus()');
						 
                         return false
                  }
           }
        }

        document.onkeydown = TelcaPulsada;                        
        if (document.captureEvents)                                
                document.captureEvents(Event.KEYDOWN)
				

function siguiente( e ){
	//alert(e);
	 eval('document.form.' + e  + '.focus();');
}

</script>	
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?php $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top"><!-- inicio codigo antiguo -->
								  
						  
			<?php 	
			$str_Set_E = "{";
			if($frmModo=="modificar"){
				if ($fila['id_estancia']!=""){
					$str_Set_E = $str_Set_E . "SeleccionaCombo(frm.cmbESTANCIA," . $fila['id_estancia'] . ");";
				};
			};
			$str_Set_E = $str_Set_E . "}"; 
	?>
<!--BODY onLoad="<?php echo $str_Set_E; ?>"-->
	
		<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						
						<TR valign="top">
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
				<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} 
					
					?>
					
						<FONT face="arial, geneva, helvetica" size=2>
							<strong><? echo $fils_ano['nro_ano'];?></strong>
						</FONT>										
<?					?>

				<? }	?>
									
							</TD>
						</TR>
						<TR valign="top">
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
								
			
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.id_curso = ".$_CURSO." $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);

             
				    $filan = @pg_fetch_array($resultado_query_cue,0); 
   		            $Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
					?>
 				    <FONT face="arial, geneva, helvetica" size=2>
							<strong><? echo "$Curso_pal"; ?></strong></FONT>
										
					</TD>	
					</TR>
					</TABLE>
				</TD>
			</TR>
			
	<FORM method=post name="form" action="procesoHorario.php">
		<INPUT TYPE="hidden" name="curso" value="<?php echo $curso; ?>">
		
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php 
								if(($_PERFIL!=16)&&($_PERFIL!=15)){ ?>
									<?php if($frmModo=="ingresar"){ ?>
										<INPUT class="botonXX"  TYPE="button" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);"  onKeydown="return valida(this.form);" >&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarHorario.php">&nbsp;
									<?php }; ?>
									<?php if($frmModo=="mostrar"){ ?>
										<?php if($_PERFIL==17){//DOCENTE?>
											<?php if(($_PERFIL!=2)&&($_PERFIL!=20)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
												<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
															if($_PERFIL==16 && $institucion==516){   ?>
														<? 	}
														else{?>
												<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaHorario.php?horario=<?php echo trim($horario)?>&caso=3">&nbsp;
												<? if ($_PERFIL==14 or $_PERFIL==0 or $_PERFIL==20){ ?><INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick="document.location='seteaHorario.php?caso=9'"><? }?>
														<? 	}	?>														
												<?php }?>
											<?php }?>
										<?php }?>
											<INPUT class="botonXX"  TYPE="button" value="VER HORARIO" onClick=document.location="listarHorario.php">&nbsp;
											<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaHorario.php?horario=<?php echo trim($horario)?>&caso=3">&nbsp;
												<? if ($_PERFIL==14 or $_PERFIL==0 or $_PERFIL==20){ ?><INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick="document.location='seteaHorario.php?caso=9'"><? }
										 };?>
									<?php if($frmModo=="modificar"){ ?>
										<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onKeydown="return valida(this.form);">&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaHorario.php?horario=<?php echo trim($horario)?>&caso=1">&nbsp;
									<?php };?>
								<?php };?>
							</TD>
						</TR>
						<TR height=20 >
							<TD align=middle colspan=2 class="tableindex">Horario</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD colspan="2" class="cuadro02">
											<? if($frmModo=="ingresar"){ ?>
												<INPUT TYPE="radio" NAME="Option" onClick="LayerRAMO.style.visibility='visible'; LayerTALLER.style.visibility='hidden'" >
											<? } ?>
											Sub-Sector
										</TD>
									</TR>
									<TR>
										<TD colspan="2" class="cuadro01">
										  <?php 
											if($frmModo=="ingresar"){ ?>
												<div id="LayerRAMO" style="visibility:hidden">
												<? LlenarCombo("SELECT a.id_ramo,trim(b.nombre) as subsector FROM ramo a, subsector b WHERE a.id_curso=". $curso ." AND a.cod_subsector=b.cod_subsector order by b.nombre", $conn, "name='cmbRAMO' id='cmbRAMO' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","","cmbESTANCIA");	
											}
											if(($frmModo!="ingresar")&&($fila['id_ramo']!="0")){ 
												imp($fila['nombre']);
											}

												if($frmModo=="modificar"){ ?>
													<div id="LayerRAMO">
													<? LlenarCombo("SELECT a.id_ramo,trim(b.nombre) as subsector FROM ramo a, subsector b WHERE a.id_curso=". $curso ." AND a.cod_subsector=b.cod_subsector order by b.nombre", $conn, "name='cmbRAMO' id='cmbRAMO' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","","cmbESTANCIA");		
													}			 							
											?>
										   </div></TD>									
									</TR>
                                    
									<tr>
										<TD colspan="2" class="cuadro02">
										<? if($frmModo=="ingresar"){ ?>
											<INPUT TYPE="radio" NAME="Option"  onClick="LayerRAMO.style.visibility='hidden'; LayerTALLER.style.visibility='visible'">
										<? } ?>
											TALLER
										</TD>										
									</TR>
									<TR>
									  <TD colspan="2" class="cuadro01">
										<?php if($frmModo=="ingresar"){ ?>
											<div id="LayerTALLER" style="visibility:hidden "> 
											<? LlenarCombo("select id_taller,nombre_taller from taller where id_ano=" . $ano ." order by nombre_taller ", $conn, "name='cmbTALLER' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","","cmbESTANCIA");
										};
										if(($frmModo!="ingresar")&&($fila['id_taller']!="0")){ 
											imp($fila['nombre']);
										};
										?>
									<div></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                        
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD class="cuadro02">SALA</TD>

									</TR>
									<TR>
										<TD class="cuadro01">
											<?php if($frmModo=="ingresar"){ 
													LlenarCombo("SELECT a.id_estancia, trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nomestancia FROM estancia a, sede b WHERE a.id_institucion=".$institucion." AND a.id_sede=b.id_sede", $conn, "name='cmbESTANCIA' id='cmbESTANCIA' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","","cmbDia");
												?>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
												    
												    
													$qry="SELECT trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nombre FROM estancia a, sede b WHERE a.id_estancia=" . $fila['id_estancia'] . " AND a.id_sede=b.id_sede";
													$result =@pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (3.1) Sala</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila3 = @pg_fetch_array($result,0);	
															if (!$fila3){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															echo trim($fila3['nombre']);	?>
													<?	}
													}
												};
											?>
											
											<?php 
												if($frmModo=="modificar"){ 
													$qry="SELECT a.id_estancia, trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nombre FROM estancia a, sede b WHERE a.id_estancia=" . $fila['id_estancia'] . " AND a.id_sede=b.id_sede";
													$result =@pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (3.2) Sala</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila3 = @pg_fetch_array($result,0);	
															if (!$fila3){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															echo trim($fila3['nombre']);	?>
													<?	}
													}	?>
													<input type="hidden" name="cmbESTANCIA" value="<?=$fila3['id_estancia']?>">			<br>
											<?
													LlenarCombo("SELECT a.id_estancia, trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nomestancia FROM estancia a, sede b WHERE a.id_institucion=".$institucion." AND a.id_sede=b.id_sede", $conn, "name='cmbESTANCIA' id='cmbESTANCIA' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","","cmbDia");									
											?>
											<?php };
											?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                        
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR class="cuadro02">
										<TD width="30%">
											DIA
										</TD>
										<TD width="20%">
											HORA INICIO<BR>(HH:MM)
										</TD>
										<TD width="50%">
											HORA TERMINO<BR>(HH:MM) 
										</TD>
									</TR>
									<TR class="cuadro01">
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												<SELECT name="cmbDia" onChange="siguiente('txtHoraIni')">
													<OPTION value=""></OPTION>
													<OPTION value=0>LUNES</OPTION>
													<OPTION value=1>MARTES</OPTION>
													<OPTION value=2>MIERCOLES</OPTION>
													<OPTION value=3>JUEVES</OPTION>
													<OPTION value=4>VIERNES</OPTION>
													<OPTION value=5>SABADO</OPTION>
													<OPTION value=6>DOMINGO</OPTION>
												</SELECT>
										<?php };?>
										<?php 
											if($frmModo=="mostrar"){ 
												switch ($fila['dia']){
													case 0:
														echo ("LUNES");
														break;
													case 1:
														echo ("MARTES");
														break;
													case 2:
														echo ("MIERCOLES");
														break;
													case 3:
														echo ("JUEVES");
														break;
													case 4:
														echo ("VIERNES");
														break;
													case 5:
														echo ("SABADO");
														break;
													case 6:
														echo ("DOMINGO");
														break;
												};
										};
										?>
										<?php if($frmModo=="modificar"){ ?>
												<SELECT name="cmbDia" onChange="siguiente('txtHoraIni')">
													<OPTION value=""></OPTION>
													<OPTION value=0 <?php if ($fila['dia']==0){ echo ("SELECTED"); };?>>LUNES</OPTION>
													<OPTION value=1 <?php if ($fila['dia']==1){ echo ("SELECTED"); };?>>MARTES</OPTION>
													<OPTION value=2 <?php if ($fila['dia']==2){ echo ("SELECTED"); };?>>MIERCOLES</OPTION>
													<OPTION value=3 <?php if ($fila['dia']==3){ echo ("SELECTED"); };?>>JUEVES</OPTION>
													<OPTION value=4 <?php if ($fila['dia']==4){ echo ("SELECTED"); };?>>VIERNES</OPTION>
													<OPTION value=5 <?php if ($fila['dia']==5){ echo ("SELECTED"); };?>>SABADO</OPTION>
													<OPTION value=6 <?php if ($fila['dia']==6){ echo ("SELECTED"); };?>>DOMINGO</OPTION>
												</SELECT>
										<?php };?>
										</TD>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtHoraIni" size=10 maxlength=50 onfocus="siguienteCampo ='txtHoraFin';" >
										<?php };?>
										<?php 
											if($frmModo=="mostrar"){ 
												imp($fila['horaini']);
											};
										?>
										<?php if($frmModo=="modificar"){?>
												
												<INPUT type="text" name="txtHoraIni" size=10 maxlength=50 value="<?php echo trim($fila['horaini'])?>" onfocus="siguienteCampo ='txtHoraFin';">
										<?php }; ?>
										</TD>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtHoraFin size=10 maxlength=50 onfocus="siguienteCampo ='btnGuardar';">
										<?php };?>
										<?php 
											if($frmModo=="mostrar"){ 
												imp($fila['horafin']);													
										};
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtHoraFin size=10 maxlength=50 onfocus="siguienteCampo ='btnGuardar';" value="<?php echo trim($fila['horafin'])?>">
										<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						
						
					</TABLE>
				</TD>
			</TR>
		</TABLE>
					  
 </form>								  
								  
								  <!-- fin codigo -->
								   </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

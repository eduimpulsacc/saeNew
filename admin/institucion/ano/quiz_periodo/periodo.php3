<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$periodo		=$_PERIODO;
	$_POSP = 4;
	$_bot = 1;
	$sql="select situacion from ano_escolar where id_ano=$ano";
	$result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM QUIZ_PERIODOS WHERE ID_PERIODO=".$periodo;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
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
	
	
	
	// CONSULTO SI DEBO CERRAR EL PERIODO
	if ($cerrarp == 1){
	  
	   $q1 = "update QUIZ_PERIODOS set cerrado = '$opc' where id_periodo = '$periodo'";
	   $r1 = pg_Exec($conn,$q1);
	   if (!$r1){
	     echo "Error, no se pudo realizar la actualización";
		 exit();
	   }
	}    
	
	// CONSULTO COMO ESTA EL PERIODO PARA VER QUE BOTON MOSTRAR (ABRIR O CERRAR)
	$q2 = "select * from QUIZ_PERIODOS where id_periodo = '$periodo'";
	$r2 = pg_Exec($conn,$q2);
	$n2 = pg_numrows($r2);
	if ($n2 > 0){
	    $f2 = pg_fetch_array($r2,0);
		$cerradop = $f2['cerrado'];
		
	}else{
	    echo "Error, no se ha encopntrado periodo";
		exit();
	}		
	
		 
	
?>
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
</script>
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtPER,'Ingresar nombre del periodo.')){
					return false;
				};
				if(!alfaOnly(form.txtPER,'Se permiten sólo caracteres alfanumericos para el nombre del periodo.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

			

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				
				if(!chkVacio(form.txtHABIL,'Ingresar cantidad de días hábiles.')){
					return false;
				};

				if(!nroOnly(form.txtHABIL,'Número de días hábiles inválido.')){
					return false;
				};

				//VALIDACION INTERVALO DE FECHAS
				/*if(amd(form.txtFECHAINI.value)>amd(form.txtFECHATER.value)){
					alert("Intervalo de fechas inválido.");
					return false;
				}*/


				return true;
			}
		</SCRIPT>
<?php }?>
		
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									
	<FORM method=post name="frm" action="procesoPeriodo.php3">
	<?php 
		echo "<input type=hidden name=ano value=".$ano.">"; ?>
		<TABLE WIDTH=600 BORDER=0 align=center CELLPADDING=0 CELLSPACING=0>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong> </FONT> </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												$fila2 = @pg_fetch_array($result,0);	
												if (!$fila2){
													error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
													exit();
												}
												echo trim($fila2['nro_ano']);
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
                            
								<?php 
								if ($situacion !=0){
								if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX" TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX" TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarPeriodoQuiz.php">&nbsp;
								<?php };?>
								<?php
								
								if($frmModo=="mostrar"){ 
								          if ($_PERFIL == 0 OR $_PERFIL == 14){
										      if ($cerradop == 0 OR $cerradop == NULL){ 
										         ?>
											     <INPUT class="botonXX"  TYPE="button" value="CERRAR PERIODO" name=btnModificar  onClick=document.location="seteaPeriodo.php3?periodo=<?=$periodo ?>&caso=4&opc=1">&nbsp;
									             <?
											   }else{
											      ?>
											     <INPUT class="botonXX"  TYPE="button" value="ABRIR PERIODO" name=btnModificar  onClick=document.location="seteaPeriodo.php3?periodo=<?=$periodo ?>&caso=4&opc=0">&nbsp;
									             <?
											   }	   	 
										  }?>	 
									  
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaPeriodo.php3?periodo=<?php echo $periodo?>&caso=3">&nbsp;
										<INPUT TYPE="button" value="ELIMINAR" class="botonXX"  name=btnEliminar onClick=document.location="seteaPeriodo.php3?caso=9;">&nbsp;
											<?php }?>
									<?php }?>
									
              <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarPeriodoQuiz.php">
              &nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaPeriodo.php3?periodo=<?php echo $periodo?>&caso=1">&nbsp;
								<?php }
								}// cierre if año academico?>
							</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">
								PERIODO
								<?
								if ($cerradop == 1){
								   echo " (CERRADO)";
								}
								?>   
								
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD class="cuadro02">
												<STRONG>NOMBRE</STRONG>										</TD>
										<TD class="cuadro02">
												<STRONG>FECHA INICIO</STRONG>										</TD>
										<TD class="cuadro02">
										  <STRONG>FECHA TERMINO</STRONG>										</TD>
										<TD class="cuadro02"><strong>POSICION NOTA</strong></TD>
										</TR>
									<TR class="cuadro01">
										<TD class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtPER size=40 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_periodo']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtPER size=40 maxlength=50 value="<?php echo $fila['nombre_periodo']?>">
											<?php };?>
										</TD>
										<TD class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHAINI size=10 maxlength=10 onChange="chkFecha(form.txtFECHAINI,'Fecha inicio invalida.');">
												<br>
												<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_inicio']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHAINI size=10 maxlength=10  value="<?php impF($fila['fecha_inicio'])?>">
												<?php };?>										</TD>
										<TD class="cuadro01">
										  <?php if($frmModo=="ingresar"){ ?>
										  <INPUT type="text" name=txtFECHATER size=10 maxlength=10 onChange="chkFecha(form.txtFECHATER,'Fecha termino invalida.');">
										  <?php };?>
										  <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_termino']);
												};
											?>
										  <?php if($frmModo=="modificar"){ ?>
										  <INPUT type="text" name=txtFECHATER size=10 maxlength=10 value="<?php impF($fila['fecha_termino'])?>">
										  <?php };?>										</TD>
										<TD class="cuadro01">
                                        
										  <?php 
												if($frmModo=="mostrar"){ 
													echo $fila['posicion_nota'];
												};
											?>
										  <?php if($frmModo=="modificar"){ ?>
										  <INPUT type="text" name=txtPOSICION size=10 maxlength=10 value="<?php echo $fila['posicion_nota']?>">
										  <?php };?>
                                        </TD>
										</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=4>
							<?php if($frmModo=="modificar"){ ?>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD class="cuadro01">
											Las Fechas deben ser ingresadas con formato dd-mm-aaaa
										</TD>
									</TR>
								</TABLE>
								<? } ?>
							</TD>
						</TR>
						
					</TABLE>
				</TD>
			</TR>			
		</TABLE>
	</FORM>							
									
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
							  	   </td>
								 </tr>
							 </table>	
                          </tr>
                        </table></td>
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
<? pg_close ($conn);?>
</body>
</html>

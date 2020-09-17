<?
	require('../../../util/header.inc');
	$institucion	=$_INSTIT;
	if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
?>
<?
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<HTML>
	<HEAD>
	
			<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

		<LINK REL="STYLESHEET" HREF="../../../<?=$_ESTILO?>" TYPE="text/css">
		<? if($frmModo!="mostrar"){ ?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				return true;
			}
		</SCRIPT>
	<? };?>

	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>

<BODY topmargin="0" marginheight="0" onLoad="MM_preloadImages('botones/institucion_roll.gif','botones/reglamento_roll.gif','botones/carta_roll.gif','botones/admision_roll.gif','botones/educativo_roll.gif','botones/uniforme_roll.gif','botones/mapa_roll.gif','botones/insignia_roll.gif','botones/biblioteca_roll.gif')">
	<? if (($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)&&($_PERFIL!=8)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>

	  <? } ?>

	<? //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoUniforme.php">
	<INPUT TYPE="hidden" name=rdb value=<? echo $institucion;?>>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
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
										<?
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
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<? if($frmModo=="ingresar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" onClick=document.location="..">&nbsp;
								<? };?>

								<? if($frmModo=="mostrar"){ ?>
									<? if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<? if(($_PERFIL!=3)&&($_PERFIL!=5) and ($_PERFIL!=15)&&($_PERFIL!=16)&&($_PERFIL!=17)&&($_PERFIL!=8)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaUniforme.php?caso=3">&nbsp;
											<?php }?>
									<? }//ACADEMICO Y LEGAL?>
									<? if(($_PERFIL!=15)&&($_PERFIL!=16)){ ?>
									<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../institucion.php3"-->&nbsp;
									<? };?>
								<? };?>

								<? if($frmModo=="modificar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="seteaUniforme.php?caso=1">&nbsp;
								<? };?>
							</TD>
						</TR>
						<TR height=20>
							<TD colspan=2 align=middle class="tableindex">  							UNIFORME															</TD>
					  </TR>
						<TR>
							<!--TD width=30></TD-->
							<TD WIDTH=570>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>CONTENIDO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<? if($frmModo=="ingresar"){ ?>
												<TEXTAREA NAME="txtCONT" ROWS="20" COLS="60"></TEXTAREA>
											<? };?>
											<?
												if($frmModo=="mostrar"){ 
													imp($fila['uniforme']);
													//nl2br($fila['uniforme']);
													//echo "<form action=insertaunif.php method=post>&nbsp;&nbsp;&nbsp;&nbsp<input type=BUTTON  value='IMAGEN DE UNIFORME' onClick=window.open('img_uniforme.php?rut=$institucion','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')></form>";
												};
											?>
											<? if($frmModo=="modificar"){ ?>
												<TEXTAREA NAME="txtCONT" ROWS="20" COLS="60">
												<?
													echo $fila['uniforme'];
												?>
												</TEXTAREA>
											<? };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=2>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color="003b85">
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>


						<TR>
							
            <TD> 
              <? if($frmModo=="ingresar"){ ?>
              <? };?>
              <? 
									if(($frmModo=="mostrar") and ($_PERFIL!=15)&&($_PERFIL!=16)){ 
									
										echo "<form action=insertaunif.php method=post>&nbsp;&nbsp;&nbsp;&nbsp<input class='botonZ' onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type=BUTTON  value='IMAGEN DE UNIFORME' onClick=window.open('img_uniforme.php?rut=$institucion','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')></form>";
									};
								?>
              <? if($frmModo=="modificar"){ ?>
              <? };?>
            </TD>
						</TR>

				  </TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>
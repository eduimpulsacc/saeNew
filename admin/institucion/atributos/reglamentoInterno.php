<?php 

	require('../../../util/header.inc');

	$institucion	=$_INSTIT;

	if ($botonera==1){

	$frmModo="mostrar";

	}else{

	$frmModo		=$_FRMMODO;

	}
	
	/************ PERMISOS DEL PERFIL *************************/
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);

?>

<?php

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
echo "modo-->".$frmModo;
?>

<HTML>

	<HEAD>
	
	<script language="JavaScript"> 
function maximaLongitud(texto,maxlong) { 
alert ("aviso")
  var tecla, in_value, out_value; 

  if (texto.value.length > maxlong) { 
    in_value = texto.value; 
    out_value = in_value.substring(0,maxlong); 
    texto.value = out_value; 
    return false; 
  } 
  return true; 
} 
</script> 


	<script language="JavaScript" type="text/JavaScript">


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

		<?php if($frmModo!="mostrar"){ ?>

		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">

			function valida(form){

				return true;

			}

		</SCRIPT>

	<?php };?>



	

<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

<!--

body {

	margin-left: 75px;

	background-image: url(../../../menu/adm/imag/fondomain.gif);

}

-->

</style></HEAD>



<BODY topmargin="0" marginheight="0" onLoad="MM_preloadImages('botones/institucion_roll.gif','botones/reglamento_roll.gif','botones/carta_roll.gif','botones/admision_roll.gif','botones/educativo_roll.gif','botones/uniforme_roll.gif','botones/mapa_roll.gif','botones/insignia_roll.gif','botones/biblioteca_roll.gif')">

	<?php if (($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)&&($_PERFIL!=8)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>



<!--table width="739" height="38" border="0" cellpadding="0" cellspacing="0">

  <tr> 

    <td height="38" align="center" valign="top"> 



      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">

        <tr> 

          <td width="81" height="30"><a href="nuestraInstitucion.php3?botonera=1"><img src="../botones/institucion.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../botones/institucion_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><img src="../botones/reglamento_roll.gif" name="Image2" width="81" height="30" border="0" id="Image2"></td>

          <td width="81" height="30"><a href="cartaDireccion.php3?botonera=1"><img src="../botones/carta.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../botones/carta_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="procesoAdmision.php3?botonera=1"><img src="../botones/admision.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../botones/admision_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="proyectoEducativo.php3?botonera=1"><img src="../botones/educativo.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../botones/educativo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../uniforme.php?botonera=1"><img src="../botones/uniforme.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../botones/uniforme_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../mapa.php?botonera=1"><img src="../botones/mapa.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../botones/mapa_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../insignia.php?botonera=1"><img src="../botones/insignia.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../botones/insignia_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81"><a href="../biblioteca/listarLibros.php?botonera=1"><img src="../botones/biblioteca.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../botones/biblioteca_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

        </tr>

      </table>

	   </td>

  </tr>

</table -->  

	  <?php } ?>

	<FORM method=post name="frm" action="procesoReglamentoInterno.php">	

		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0>

			<TR height=15>

				<TD>

					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">

                      <TR height="50" >

                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </FONT> </TD>

                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>

                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>

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

                        </strong> </FONT> </TD>

                      </TR>

                    </TABLE></TD>

			</TR>

			<TR height=15>

				<TD>

					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">

						<TR height="50" >

						  <TD align=right colspan=2><?php if($frmModo=="ingresar"){ 
										if($ingreso==1){?>

									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;

									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" onClick=document.location="..">&nbsp;

								<?php 	}
									  };?>

								<?php if($frmModo=="mostrar"){ 
										if($modifica==1){?>

										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaReglamentoInterno.php?caso=3">&nbsp;
									<?php }?>

								<?php if($ver==1){ ?>

									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../institucion.php">&nbsp;

									<?php } ?>

								<?php };?>



								<?php if($frmModo=="modificar"){ 
											if($modifica==1)?>

									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;

					        <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="seteaReglamentoInterno.php?caso=1">&nbsp;

							<?php 		};
										}?></TD>
						</TR>

						<TR height=20 bgcolor=003b85>

							<TD align=middle colspan=2>

								<FONT face="arial, geneva, helvetica" size=2 color=White>

									<strong>REGLAMENTO INTERNO</strong>								</FONT>							</TD>
						</TR>

						<TR>

							<TD width=19></TD>

							<TD WIDTH=543>

								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>

									<TR>

										<TD height="32">

											<FONT face="arial, geneva, helvetica" size=2 color=#000000>

												<STRONG>CONTENIDO</STRONG>											</FONT>										</TD>
									</TR>

									<TR>

										<TD>

											<?php if($frmModo=="ingresar"){ ?>

												<TEXTAREA NAME="txtCONT" ROWS="20" COLS="60" onKeyUp="return maximaLongitud(this,10)"></TEXTAREA>

											<?php };?>

											<font face="Arial, Helvetica, sans-serif" size="2">

											<?php 

												if($frmModo=="mostrar"){ 

													echo nl2br($fila['reglamento_interno']);

												};

											?>
											</font>

											<?php if($frmModo=="modificar"){ ?>

												<TEXTAREA NAME="txtCONT" ROWS="20" COLS="60" onKeyUp="return maximaLongitud(this,10)">

												<?php 

													echo trim($fila['reglamento_interno']);

												?>

												</TEXTAREA>

											<?php };?>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>

						<TR>

							<TD colspan=2>

								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>

									<TR>

										<TD>

											<HR width="100%" color=003b85>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
					</TABLE>

				</TD>

			</TR>

		</TABLE>

	</FORM>

</BODY>

</HTML>
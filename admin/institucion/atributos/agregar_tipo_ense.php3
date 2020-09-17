<?php require('../../../util/header.inc');
$_POSP = 3; 
$_bot = 4;

$institucion	=$_INSTIT;
$tipoense		=$_TIPOENSE;
$frmModo		=$_FRMMODO;
$ensenanza		=$_ENSENANZA;
$plan			=$_PLAN;

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	/*if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}*/
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

  
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM tipo_ense_inst WHERE rdb=".$institucion." AND cod_tipo=".$ensenanza." AND cod_decreto=".$plan;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
					exit();
				}
			}
		}
	}
 
?>
	
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		
    <?php if($frmModo=="modificar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){
				
	if (document.form._JM.checked){
	var hora_ini = document.getElementById("txtHoraIni").value;
	var hora_fin = document.getElementById("txtHoraFin").value;
	
	if(hora_ini.length == 0){
		alert("ingrese hora entrada mañana");
		return false;
		}
	if(hora_ini.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}	
		
	if(hora_fin.length == 0){
		alert("ingrese hora salida mañana");
		return false;
		}
	if(hora_fin.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}		
		
	}
	
	
	if (document.form._JT.checked){
	var hora_ini_T = document.getElementById("txtHoraIniT").value;
	var hora_fin_T = document.getElementById("txtHoraFinT").value;
	
	if(hora_ini_T.length == 0){
		alert("ingrese hora entrada tarde");
		return false;
		}
	if(hora_ini_T.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}	
		
	if(hora_fin_T.length == 0){
		alert("ingrese hora salida tarde");
		return false;
		}
	if(hora_fin_T.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}		
	}
	
	
	if (document.form._JMT_2.checked){
	var hora_ini_MT = document.getElementById("txtHoraIniMT").value;
	var hora_fin_MT = document.getElementById("txtHoraFinMT").value;
	
	if(hora_ini_MT.length == 0){
		alert("ingrese hora entrada mañana tarde");
		return false;
		}
	if(hora_ini_MT.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}	
		
	if(hora_fin_MT.length == 0){
		alert("ingrese hora salida mañana tarde");
		return false;
		}
	if(hora_fin_MT.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}		
		
	}
	
	
	
		
			    if(!chkVacio(form.txtNUME2,'Ingresar NUMERO.')){
					return false;
				}else{
				
     			if(!nroOnly(form.txtNUME2,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
				};
			}		
			   /* if(!chkVacio(form.txtNUM3,'Ingresar NUMERO.')){
					return false;
				}else{
				
     			if(!nroOnly(form.txtNUM3,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
				};
											
			  }
			    if(!chkVacio(form.txtNumDife,'Ingresar NUMERO.')){
					return false;
					
				}
				
     			if(!nroOnly(form.txtNumDife,'Se permiten sólo numeros en Grupo Diferencial.')){
							return false;
				
				};  */

												
			  			  
			  
/*				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};
				
				if(!chkFecha2(form.txtFECHA,'Fecha invalida.')){
					return false;
				};
				
				if(!chkVacio(form.txtFECHAcierre,'Ingresar FECHA DE CIERRE.')){
					return false;
				};
						
               if(!chkFecha(form.txtFECHAcierre,'Fecha invalida.')){
					return false;
				};								
				
		    	if(!nroOnly(form.txtNumDif,'Se permiten sólo numeros en Grupos Diferenciales.')){
					return false;
				};	
								
				if(!chkVacio(form.txtNUMdif,'Ingresar NUMERO DE GRUPOS DIFERENCIALES.')){
					return false;
				};
				if(!nroOnly(form.txtNUMERO,'Se permiten sólo numeros en el Número de resolución.')){
					return false;
				};*/
				function chkENS(form){
				         tipo=form.cmbTipoEnse.value;
				           if((tipo==110)){//ENSENANZA BASICA
					           form.cmbTipoEnse.disabled=true;
					         }else{
					           form.cmbEVAL.disabled=false;
				           };
				}
				return true;
			}
		
		</SCRIPT>
<?php }?>

          <?php if($frmModo=="ingresar"){ ?>
				<SCRIPT language="JavaScript">
				function valida(form){
					
					
					if (document.form._JM.checked){
	var hora_ini = document.getElementById("txtHoraIni").value;
	var hora_fin = document.getElementById("txtHoraFin").value;
	
	if(hora_ini.length == 0){
		alert("ingrese hora entrada mañana");
		return false;
		}
	if(hora_ini.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}	
		
	if(hora_fin.length == 0){
		alert("ingrese hora salida mañana");
		return false;
		}
	if(hora_fin.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}		
		
	}
	
	
	if (document.form._JT.checked){
	var hora_ini_T = document.getElementById("txtHoraIniT").value;
	var hora_fin_T = document.getElementById("txtHoraFinT").value;
	
	if(hora_ini_T.length == 0){
		alert("ingrese hora entrada tarde");
		return false;
		}
	if(hora_ini_T.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}	
		
	if(hora_fin_T.length == 0){
		alert("ingrese hora salida tarde");
		return false;
		}
	if(hora_fin_T.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}		
	}
	
	
	if (document.form._JMT_2.checked){
	var hora_ini_MT = document.getElementById("txtHoraIniMT").value;
	var hora_fin_MT = document.getElementById("txtHoraFinMT").value;
	
	if(hora_ini_MT.length == 0){
		alert("ingrese hora entrada mañana tarde");
		return false;
		}
	if(hora_ini_MT.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}	
		
	if(hora_fin_MT.length == 0){
		alert("ingrese hora salida mañana tarde");
		return false;
		}
	if(hora_fin_MT.length < 8){
		alert("formato hora incorrecto(08:00:00)");
		return false;
		}		
		
	}
					
					
						//alert(document.getElementById('txtHoraIni').value);
					
						if(!chkVacio(form.txtNUME2,'Ingresar Número de resolución.')){
							return false;
						};
						if(!nroOnly(form.txtNUME2,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
						};
						if(!chkVacio(form.txtFECHA,'Ingresar FECHA DE RESOLUCION.')){
							return false;
						};
						if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					        return false;
				        };
						
                       /* if(!nroOnly(form.txtNUMERO,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
						};
						if(!soloNumeros(form.txtNumDif,'Se permiten sólo numeros en Grupos Diferenciales.')){
							return false;
						};	
						if(!chkVacio(form.txtNumDif,'Ingresar Nº de grupos Diferenciales.')){
							return false;
						};  */
                       
						
						function chkENS(form){
				         tipo=form.cmbTipoEnse.value;
				           if(tipo<>110){//ENSENANZA BASICA
					           form.txtNumDif.disabled=true;
					         }else{
					           form.txtNumDif.disabled=false;
				           };
						return true;
					}
				</SCRIPT>
		<?php };?>
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

<script language="javascript">
function fechas(caja)
{ 
  
   if (caja)
   {  
      borrar = caja;
       
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr($i,1)== " ") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
			{
               borrar = '';
               break;  
			}  
         }
	     if (borrar)
	     { 
	        a = caja.substr(6,4);
		    m = caja.substr(3,2);
		    d = caja.substr(0,2);
		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		       borrar = '';
		    else
		    {
		       if((a%4 != 0) && (m == 2) && (d > 28))	   
		          borrar = ''; // Año no viciesto y es febrero y el dia es mayor a 28
			   else	
			   {
		          if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			         borrar = '';	      				  	 
			   }  // else
		    } // fin else
         } // if (error)
      } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	  else
	     borrar = '';
		 
	  if (borrar == '')
	     alert('Fecha erronea');
  
   
   }  // if (caja)   
   
    
} // FUNCION
</script>


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
		  <td width="0%" align="left" valign="top" bgcolor="f7f7f7">
          <? $menu_lateral=2; include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      
              <td width="27%" height="363" align="left" valign="top"> <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  
                      <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td height="246" align="center" valign="top">
								  
								  
								  <!-- agregar_tipo de enseñanza.php3-->
								  
								  

<div id="gif_sige" style="text-align:right"><img src="../../clases/soap/gif_sige.gif"></div>
<FORM method="post" name="form" action="../ensenanza/procesoEnsenanza.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=agrupacion value=".$ensenanza.">";
		echo "<input type=hidden name=plan value=".$plan.">";
		
		
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center style="display:none ">
			<TR>
				<TD>
					<TABLE width="100%" height="100%" BORDER=0 CELLPADDING=1 CELLSPACING=1 class="fondo">
						<TR >
							<TD width="1%" align=left class="fondo">
								INSTITUCION
							</TD>
							<TD width="1%">
								:
							</TD>
							<TD>
								<font color="#666666">
										<?php 
                                            if($frmModo!="ingresar"){
												
												
											
												
											$qryEN="SELECT * FROM tipo_ensenanza WHERE cod_tipo=".$ensenanza;
											$resultEN =@pg_Exec($conn,$qryEN);
											if (!$resultEN) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
									 		}else{
												if (pg_numrows($resultEN)!=0){
													$fila1 = @pg_fetch_array($resultEN,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													            }
                                                           }                                                
												        }                                                    
											        }
                                                     $qry2="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											      $result2 =@pg_Exec($conn,$qry2);
                                                    $fila2 = @pg_fetch_array($result2,0);
													echo ($fila2['nombre_instit']);
										?>
								  </font>
							</TD>
						</TR>
						<!--------------------------------------------------------------------->
						<!-- ESTA PARTE DEL DOCUMENTO SE MUESTRA SOLO SI ID_AGRUPACION ES "" -->
						<!--------------------------------------------------------------------->
						<!--TR>
							<TD></TD>
							<TD></TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
								
									</strong>
								</FONT>
							</TD>
						</TR-->
						<!--------------------------------------------------------------------->
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
            <TD align=right colspan=2> 
              <?php if($frmModo=="ingresar"){ ?>
              &nbsp; <input class="botonXX" type="submit" value="GUARDAR"   name="btnGuardar2" onClick="return valida(this.form);">
              <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick="window.history.go(-2)">
              &nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name="btnModificar"  onClick=document.location="seteaTipoEnse.php3?ensenanza=<?php echo $ensenanza ?>&caso=3&plan=<?php echo $plan ?>&corre=<?php echo $corre ?>">
										&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name="btnEliminar" onClick=document.location="seteaTipoEnse.php3?caso=9;">
										&nbsp;
											<?php }?>
									<?php } //ACADEMICO Y LEGAL?>
									<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarTiposEnsenanza.php3">
									&nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){
								
								    echo "estoy en este boton ... <br>"; ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">
									&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick="window.history.go(-3)">
									&nbsp;
								<?php };?>
							</TD>
						</TR>
						          <TR align="left"  height=20> 
                                    <TD colspan=2 class="fondo">TIPO DE ENSE&Ntilde;ANZA&nbsp;&nbsp;&nbsp;
                                       <font color="#666666">
                                      <?php echo ($fila1['cod_tipo'])?>&nbsp;-&nbsp;<?php echo ($fila1['nombre_tipo'])?> 
									  
									  </font></TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
							<?php if($frmModo=="ingresar"){ ?>			
                  <TD width="51%" class="nombre_campo">  
       TIPOS DE ENSE&Ntilde;ANZAS&nbsp;&nbsp;&nbsp;</TD> 
                  <?php } ?>
                           <TD width="49%" class="nombre_campo"> ESTADO DEL TIPO DE ENSEÑANZA </TD> 
									</TR>
									<TR>
										<TD align="left" class="datosB">
											<?php   if($frmModo=="ingresar"){   ?>                                                    
												<?php  if(($_PERFIL==1)||($_PERFIL==0)){                                                                                                                                                                               
                                                        $qry2="SELECT * FROM tipo_ensenanza ORDER BY cod_tipo ASC";                                                                                                              
		                                                   $result2	=@pg_Exec($conn,$qry2);
                                                            if (@pg_numrows($result2)!=0){;?>
                                                               <Select name="cmbTipoEnse" onChange="chkENS(this.form)">                                                                                                                      
                                                              <?php for($i=0 ; $i < @pg_numrows($result2) ; $i++){ 
                                                                 $fila2 = @pg_fetch_array($result2,$i);
                                                                  echo "<OPTION value=\"".trim($fila2['cod_tipo'])."\">".trim($fila2['nombre_tipo'])." </OPTION>\n";
                                                                   ?>
                                                               <?php };//for resultT                                                                                                                                                                               
	                                                                     ?>
							              </Select>
												<?php }else{
													imp('YA INGRESADAS');
												echo "<input type=hidden name=cmbESTADO value=0>";
													};?>
											<?php  };
                                                  };  ?>
                        <?php 
												if($frmModo=="mostrar"){ 
													switch ($fila["estado"]) {
														 case 0:
															 imp('FUNCIONANDO');
															 break;
														 case 1:
															 imp('AUTORIZADO SIN MATRICULA');
															 break;
														 case 2:
															 imp('CERRADO');
															 break;
													 };
												};
											?>
                                                      <?php if($frmModo=="modificar"){ ?>
                                                       <?php if(($_PERFIL==14)||($_PERFIL==0)){
													       ?>
                                                        <Select name="cmbESTADO">
														<?php if (pg_numrows($result)==0){?>
														
														   <option value=0>FUNCIONANDO </option>
														   <option value=1>AUTORIZADO SIN MATRICULA </option>
                                                           <option value=2 selected>CERRADO </option> 
														   <?php }
														    else{?>
														<?php  switch ($fila["estado"]) {
														 case 0:
															 echo "<option value=0 selected>".('FUNCIONANDO')."</option>"; ?>
															       <option value=1>AUTORIZADO SIN MATRICULA </option>
                                                        		   <option value=2>CERRADO </option>
															<?php break;
														 case 1:
															 echo "<option value=1 selected>".('AUTORIZADO SIN MATRICULA')."</option>";?>
															       <option value=2>CERRADO </option>
                                                               	   <option value=0>FUNCIONANDO </option>
															<? break;
														 case 2:
															 echo "<option value=2 selected>".('CERRADO')."</option>";?>
															  <option value=0>FUNCIONANDO</option>
                                                              <option value=1>AUTORIZADO SIN MATRICULA</option>   
															<?php break;
													 } };?>
														
													</Select>
												<?php }else{
													switch ($fila["estado"]) {
														 case 0:
															 imp('FUNCIONANDO');
															echo "<input type=hidden name=cmbESTADO value=0>";
															 break;
														 case 1:
															 imp('AUTORIZADO SIN MATRICULA');
															echo "<input type=hidden name=cmbESTADO value=1>";
															 break;
                                                          case 2:
															 imp('CERRADO');
															echo "<input type=hidden name=cmbESTADO value=2>";
															 break;
													 };
													};?>
											<?php };?>
                                       
										</TD>
                                             <TD align="left"><?php if($frmModo=="ingresar"){ ?>
												<?php if(($_PERFIL==1)||($_PERFIL==0)){?>
													<Select name="cmbESTADO">
														<option value=0 selected>FUNCIONANDO</option>
														<option value=1>AUTORIZADO SIN MATRICULA</option>
                                                        <option value=2>CERRADO</option>
													</Select>
                                             <?php 
													};?>
                                           <?php };?>
                   
                                       </TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR class="datosB">
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
                  <TD width="56%" height="13" class="nombre_campo">RESOLUCION DE AUTORIZACION DE TIPO DE ENSE&Ntilde;ANZA 
                   </TD>
									<TR class="datosB">
               
										
                  <TD width="56%" class="datosB"><b>Numero</b></TD>
                      <TD width="44%" class="datosB"> 
                    <strong>Fecha</strong></TD>
									</TR>
									<TR class="datosB">
										
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="text" name="txtNUME22" size="10" maxlength="10" onChange="nroOnly(this,'Solo números');"> 
                    <br>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													echo($fila['nu_resolucion']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="text" name="txtNUME22" size="10" maxlength="10" onChange="nroOnly(this,'Solo números');" value="<?php echo($fila['nu_resolucion'])?>"> 
                    <br>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    </FONT> 
                    <?php };?>
                  </TD>
                                              <TD> <?php if($frmModo=="ingresar"){ ?>
												<input type="text" name="txtFECHA" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar'>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_res']);
												};
											?>
											<?php if($frmModo=="modificar"){ 
											
											    echo "este campo a validar... <br>"; ?>
												<input type="text" name="txtFECHA" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar' value=<?php impF($fila['fecha_res']);?>>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                        <?php 
						
						if($frmModo!="ingresar"){ ?>   
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
                                    <TD width="56%" class="nombre_campo">RESOLUCION DE CIERRE DE TIPO DE ENSE&Ntilde;ANZA 
                                   </TD>
									<TR class="datosB">
										<TD width="56%" class="datosB"><strong> NUMERO </strong></TD>
                                             <TD width="44%" class="datosB"><strong>FECHA</strong></TD>
									</TR>
									<TR class="datosB">
										<TD class="datos">
											
                                          <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtNUMERO" size="10" maxlength="10" >
												<br>
                                           
                                               <?php };?>
                                          <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nu_resolucion_cierre']);
												};
											?>
                                          <?php if($frmModo=="modificar"){?>
                                               <INPUT type="text" name="txtNUMERO" size="10" maxlength="10" value="<?php echo($fila['nu_resolucion_cierre'])?>" >
												<br>
                                                
                                              <?php };?>
                                       </TD>
                                              <TD class="datos"> <?php if($frmModo=="ingresar"){ ?>
												<input type="text" name="txtFECHAcierre" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar'>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_res_cierre']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="txtFECHAcierre" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar' value="<?php impF($fila['fecha_res_cierre'])?>">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                        <?php };?>  
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100% align="top">
									<TR class="nombre_campo">
										
                                         <TD width="56%" height="15" class="nombre_campo">                                         
                                          EXISTENCIA DE CENTRO DE PADRES </TD>
                                         <TD width="44%" class="nombre_campo"> 
                                          PERSONALIDAD JURIDICA  </TD>
									</TR>
									<TR>
										
                  <TD> 
                   <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name="ecp" size="83" maxlength="50" >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_ecp']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=ecp size="83" maxlength="50" value="1" 
											<?php 
											  echo ($fila['bool_ecp']==1)?"checked":"";
											?>>
											<?php };?>
                  </TD>
                    <TD><?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name="pj" size="83" maxlength="50" >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_pj']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name="pj" size="83" maxlength="50" value="1" 
											<?php 
											  echo ($fila['bool_pj']==1)?"checked":"";
											?>>
											<?php };?>
                  </TD>
                                  

 
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD><?php if($ensenanza==110){ ?>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width="100%">
                                   
                  <TD width="56%" height="13" bgcolor=#cccccc class="nombre_campo" Border=0 cellpadding=1 cellspacing=0> 
                GRUPO DIFERENCIAL </TD>
                                           <TD width="44%" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
                                      </TD>
									<TR>
										<TD class="datosB"><strong> Nº DE GRUPOS DIFERENCIALES </strong></TD>
                                        <TD width="44%" valign="middle">
											
                                          <?php if($frmModo=="ingresar"){ ?>
												<input type=text name="txtNumDif" size=8 maxlength="10">
												<br>
                                               <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                                              </FONT> 
                                              <?php };?>
                                           <?php 
												if($frmModo=="mostrar"){ 
													echo($fila['nu_grupos_dif']);
												};
											?>
                                            <?php if($frmModo=="modificar"){ ?>
                                             <input type=text name="txtNumDif" size="8" maxlength="10" value=<?php echo($fila['nu_grupos_dif']);?> >
                                            <?php };?>
                  </TD>
									</TR>
									<TR>
										<TD>
										
										</TD>
									</TR>
								</TABLE>
								<?php }?>
							</TD>
						</TR>             <?php
                                          $qryH="SELECT * FROM hora_jm, tipo_ense_inst WHERE (hora_jm.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                       $resultH	=@pg_Exec($conn,$qryH);
                                                        if (@pg_numrows($resultH)!=0){;
                                                         $filaH = @pg_fetch_array($resultH,0);
                                                         };
                                           $qryT="SELECT * FROM hora_jt, tipo_ense_inst WHERE (hora_jt.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                       $resultT	=@pg_Exec($conn,$qryT);
                                                        if (@pg_numrows($resultT)!=0){;
                                                         $filaT = @pg_fetch_array($resultT,0);
													     };   
                                             $qryMT="SELECT * FROM hora_mt, tipo_ense_inst WHERE (hora_mt.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                           $resultMT	=@pg_Exec($conn,$qryMT);
                                                           if (@pg_numrows($resultMT)!=0){;
                                                           $filaMT = @pg_fetch_array($resultMT,0);
                                                           };
                                             $qryVN="SELECT * FROM hora_vn, tipo_ense_inst WHERE (hora_vn.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                           $resultVN	=@pg_Exec($conn,$qryVN);
                                                           if (@pg_numrows($resultVN)!=0){;
                                                           $filaVN = @pg_fetch_array($resultVN,0);
												        };   
                                            

                                           ?>
                              <TR>
							<TD width=30 height="50"></TD>
							<TD valign="top">
                              <?php if($frmModo!="ingresar"){
							        if (pg_numrows($result)!=0){ ?>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=1 width="100%">
                <TD width="50%" align="left" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0> HORARIO</TD>
                 <TD width="50%" align="left" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0></TD>
                <TR> <?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                  <TD class="datosB"><strong> JORNADA MA&Ntilde;ANA </strong></TD> 
                  <?php };?>
                    <?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <TD class="datosB"><strong>JORNADA MA&Ntilde;ANA Y TARDE</strong></TD> 
                    <?php };?>
                </TR>
                <TR> 
                  <TD align="left" valign="top" nowrap> <p><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <input type="checkbox" name="_JM2" size="83" maxlength="50" >
                      <?php };?>
                      <?php 
												if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)) {
													imp("SI");
												};
											?>
                      <?php if($frmModo=="modificar"){ ?>
                      <INPUT type="checkbox" name="_JM2" size="83" maxlength="50" value="1"
											<?php 
											  echo (@pg_numrows($resultH)!=0)?"checked":"";
											?>>
                      <?php };?>
                      </FONT></p></TD>
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name="_JMT_1" size="83" maxlength="50" > 
                    <?php };?>
                                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>                   
                    <?php                                                      
												 if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)) { 
													imp("SI");
												    };
                                       ?>
                                          </FONT>
			<?php if($frmModo=="modificar"){ ?>
						<INPUT type="checkbox" name="_JMT_1" size="83" maxlength="50" value="1" <?php echo (@pg_numrows($resultMT)!=0)?"checked":""; ?>> 
			<?php };?>
					
					</FONT></p>
                    </TD>
                </TR>
                     <TR>
                       
                  <TD align="left" valign="top" class="datosB"><strong> 
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    HORA INICIO &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    			<INPUT type="text" name="txtHoraIni" size="10" maxlength="50"> 
                    <?php };?>
                    <?php 
											 if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)) { 
												imp($filaH['hora_ini']);
											
                                           };
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name="txtHoraIni" size="10" maxlength="50" value="<?php echo trim($filaH['hora_ini'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                    </FONT>
                    <?php }; ?>
                  </strong></TD>
                        
                  <TD align="left" valign="top" class="datosB"><strong>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    HORA 
                    INICIO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                    <?php }; ?>                    
                    <?php if($frmModo=="ingresar"){ ?>                    
                    <INPUT type="text" name="txtHoraIniMT" size="10" maxlength="50">                    
                    <?php };?>                    
                    <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)) { 
											imp($filaMT['hora_ini']);
											};
                                           
										?>                    
                    <?php if($frmModo=="modificar"){ ?>                    
                    <INPUT type="text" name="txtHoraIniMT" size="10" maxlength="50" value="<?php echo trim($filaMT['hora_ini'])?>">                    
                    <?php }; ?>                    
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                    </FONT>                    <?php }; ?>                      
                    </strong></TD>
									</TR>

                                           <TR> 	
                  <TD align="left" valign="top" class="datosB">
                      <strong>
                <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                HORA TERMINO 
                <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name="txtHoraFin" size="10" maxlength="50">
										<?php };?>
										<?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)){
                                               if (@pg_numrows($resultH)!=0){ 
												imp($filaH['hora_ter']);
											};
                                           };
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name="txtHoraFin" size="10" maxlength="50" value="<?php echo trim($filaH['hora_ter'])?>">
                                        <?php }; ?>
                                        <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                                                <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                                                                            </FONT>                                                <?php }; ?>
                      </strong></TD>
                              
                  <TD valign="top" class="datosB"> 
                    <strong>
<?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
HORA 
                    TERMINO&nbsp;
                    <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name="txtHoraFinMT" size="10" maxlength="50"> 
                    <?php };?>
                    <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)){
                                             if (@pg_numrows($resultMT)!=0){ 
												imp($filaMT['hora_ter']);
											};
                                          };
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name="txtHoraFinMT" size="10" maxlength="50" value="<?php echo trim($filaMT['hora_ter'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                    </FONT> 
                    <?php }; ?>
                      </strong></TD>
									</TR>

                                    <TR> 	
                                    <TR>
                               </TR>
                                                                 
							<TR>
						<?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?> 			  
                        <TD width="33%" height="12" class="datosB"><strong> 
                          JORNADA TARDE</strong></TD> <?php }; ?>
                         <?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>                
                          
						<?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>
						<TD width="33%" class="datosB"><strong>JORNADA VESPERTINO/ NOCTURNA</strong></TD> <?php } }; ?>
                                    
                                    </TR>
                                  <TR> 	
                  		<TD align="left" valign="top"> <p><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <input type="checkbox" name="_JT2" size="83" maxlength="50" >
                      <?php };?>
                      <?php             
                                               
												if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
													imp("SI");
												};
                                                   
											?>
                      <?php if($frmModo=="modificar"){ ?>
                      <INPUT type="checkbox" name="_JT2" size="83" maxlength="50" value="1" 
											<?php 
											  echo (@pg_numrows($resultT)!=0)?"checked":"";
											?>>
                                      <?php };?>
                      </FONT></p>
                    
                            </TD>
							    <?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>
                                        
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name="_JVN" size="83" maxlength="50" >
                      <?php };?>
                                             <FONT face="arial, geneva, helvetica" size=1 color=#000000>       
                      <?php 
                                              
												if(($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0)){
 													imp("SI");
												};
                                          ?>
                                             </FONT>
                      <?php if($frmModo=="modificar"){
					       ?>
                      <INPUT type="checkbox" name="_JVN" size="83" maxlength="50" value="1"
											<?php 
											  echo (@pg_numrows($resultVN)!=0)?"checked":"";
											?>>
                      <?php };?>
                      </FONT></p>
                    

                                </TD>  
								<?php } ?>             
									</TR>
									<TR>
									 <BR>                                                                        
                                    </TR>
                                  <TR> 
                               	
                      
                  <TD align="left" valign="top" class="datosB"><strong> 
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    HORA 
                    INICIO &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php };?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraIniT size="10" maxlength="50"> 
                    <?php };?>
                    <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
                                                if (@pg_numrows($resultT)!=0){ 
												imp($filaT['hora_ini']);
											  };
                                           };
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name="txtHoraIniT" size="10" maxlength="50" value="<?php echo trim($filaT['hora_ini'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                    </FONT> 
                    <?php };?>
                  </strong></TD>  
				   <?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>  
                   <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                 
                  <TD align="left" valign="top" class="datosB"> <p><strong> HORA INICIO &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php };?>
                        <?php if($frmModo=="ingresar"){ ?>
                        <INPUT type="text" name="txtHoraIniVN" size="10" maxlength="50">
                        <?php };?>
                        <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0)){
                                                 if (@pg_numrows($resultVN)!=0){
												imp($filaVN['hora_ini']);
											};
                                          };
										?>
                        <?php if($frmModo=="modificar"){ ?>
                        <INPUT type="text" name="txtHoraIniVN" size="10" maxlength="50" value="<?php echo trim($filaVN['hora_ini'])?>">
                        <?php }; ?>
                        <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                        <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                        </FONT> 
                        <?php // };?>
                  </strong></TD>
				     <?php } };?>
									</TR>

                                           <TR> 	
                  <TD align="left" valign="top" class="datosB"><strong>
                      <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                     HORA TERMINO 
                     <?php };?> 
                     <?php if($frmModo=="ingresar"){ ?>
                     <INPUT type="text" name="txtHoraFinT" size="10" maxlength="50">
										<?php };?>
										<?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
                                               if (@pg_numrows($resultT)!=0){ 
												imp($filaT['hora_ter']);
											};
                                           };
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name="txtHoraFinT" size="10" maxlength="50" value="<?php echo trim($filaT['hora_ter'])?>">
                                        <?php }; ?>
                                        <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                                        <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                                                </FONT>                                        <?php }; ?>
                  </strong></TD>
                       <?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>  
                      <TD align="left" valign="top" class="datosB"><strong>
                                      <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                                     HORA TERMINO
                                     <?php }; ?>
										 
                                     <?php if($frmModo=="ingresar"){ ?>
                                     <INPUT type="text" name="txtHoraFinVN" size="10" maxlength="50">
										<?php };?>
										<?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0)){
                                               if (@pg_numrows($resultVN)!=0){
												imp($filaVN['hora_ter']);
											};
                                          };
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name="txtHoraFinVN" size="10" maxlength="50" value="<?php echo trim($filaVN['hora_ter'])?>">
                                        <?php }; ?>
                                        <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                                        <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) 
                                                </FONT> </strong></TD> <?php  } }; ?>
                               
                                      
                                         
                                 
									</TR>
									<TR>
										<TD>
											
										</TD>
									</TR>
								</TABLE>
                         <?php } }; ?>
							</TD>
						</TR>
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
						<TR height=15>
							<TD width="100%" colspan=2>
								
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	    <table width="615" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="407" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>
                  <td height="20" align="left" valign="middle"><div align="center"></div>
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr align="center" valign="middle">
                          <td>
						  <?php if($frmModo=="ingresar"){ ?>
									&nbsp;
									<input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar2" onClick="return valida(this.form);">
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick="window.history.go(-2)">
									&nbsp;
						<?php };?>
						<?php if($frmModo=="mostrar"){ ?>
							<?php if($modifica==1){ ?>
							<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name="btnModificar"  onClick=document.location="seteaTipoEnse.php3?ensenanza=<?php echo $ensenanza ?>&caso=3&plan=<?php echo $plan ?>&corre=<?php echo $corre ?>">
							&nbsp;
							<? } 
							if($elimina==1){?>
							<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name="btnEliminar" onClick=document.location="seteaTipoEnse.php3?caso=9;">
							&nbsp;
							<?php }
							}?>
							<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarTiposEnsenanza.php3">
							&nbsp;
							<?php if($frmModo=="modificar"){  
									if($modifica==1){?>
							<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">
							&nbsp;
                            <INPUT class="botonXX"  TYPE="submit" value="GUARDAR SIGE"   name="btnGuardarSige" onClick="return valida(this.form);">
							&nbsp;
							<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick="window.history.go(-3)">
							&nbsp;
							<?php 	}
								   };?></td>
                          </tr>
                    </table></td>
                </tr>
                <tr>
                  <td height="20" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                  <td height="60" class="fondo">Tipo de Ense&ntilde;anza: <font color="#666666"><?php echo ($fila1['cod_tipo'])?>&nbsp;-&nbsp;<?php echo ($fila1['nombre_tipo'])?> </font></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                      <tr>
                        <td width="36%"><font color="#6699FF"><strong>ESTADO DEL TIPO DE ENSE&Ntilde;ANZA </strong></font></td>
                        <td width="21%" class="datosB"><?php   if($frmModo=="ingresar"){   ?>
                          <?php  if(($_PERFIL==1)||($_PERFIL==0)){                                                                                                                                                                               
                                                        $qry2="SELECT * FROM tipo_ensenanza ORDER BY cod_tipo ASC";                                                                                                              
		                                                   $result2	=@pg_Exec($conn,$qry2);
                                                            if (@pg_numrows($result2)!=0){;?>
                          <Select name="cmbTipoEnse" onChange="chkENS(this.form)">
                            <?php for($i=0 ; $i < @pg_numrows($result2) ; $i++){ 
                                                                 $fila2 = @pg_fetch_array($result2,$i);
                                                                  echo "<OPTION value=\"".trim($fila2['cod_tipo'])."\">".trim($fila2['nombre_tipo'])." </OPTION>\n";
                                                                   ?>
                            <?php };//for resultT                                                                                                                                                                               
	                                                                     ?>
                          </Select>
                          <?php }else{
													imp('YA INGRESADAS');
												echo "<input type=hidden name=cmbESTADO value=0>";
													};?>
                          <?php  };
                                                  };  ?>
                          <?php 
												if($frmModo=="mostrar"){ 
													switch ($fila["estado"]) {
														 case 0:
															 imp('FUNCIONANDO');
															 break;
														 case 1:
															 imp('AUTORIZADO SIN MATRICULA');
															 break;
														 case 2:
															 imp('CERRADO');
															 break;
													 };
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <?php if(($_PERFIL==14)||($_PERFIL==0)){
													       ?>
                          <select name="cmbESTADO">
                            <?php if (pg_numrows($result)==0){?>
                            <option value=0>FUNCIONANDO </option>
                            <option value=1>AUTORIZADO SIN MATRICULA </option>
                            <option value=2 selected>CERRADO </option>
                            <?php }
														    else{?>
                            <?php  switch ($fila["estado"]) {
														 case 0:
															 echo "<option value=0 selected>".('FUNCIONANDO')."</option>"; ?>
                            <option value=1>AUTORIZADO SIN MATRICULA </option>
                            <option value=2>CERRADO </option>
                            <?php break;
														 case 1:
															 echo "<option value=1 selected>".('AUTORIZADO SIN MATRICULA')."</option>";?>
                            <option value=2>CERRADO </option>
                            <option value=0>FUNCIONANDO </option>
                            <? break;
														 case 2:
															 echo "<option value=2 selected>".('CERRADO')."</option>";?>
                            <option value=0>FUNCIONANDO</option>
                            <option value=1>AUTORIZADO SIN MATRICULA</option>
                            <?php break;
													 } };?>
                          </select>
                          <?php }else{
													switch ($fila["estado"]) {
														 case 0:
															 echo "FUNCIONANDO";
															echo "<input type=hidden name=cmbESTADO value=0>";
															 break;
														 case 1:
															 imp('AUTORIZADO SIN MATRICULA');
															echo "<input type=hidden name=cmbESTADO value=1>";
															 break;
                                                          case 2:
															 imp('CERRADO');
															echo "<input type=hidden name=cmbESTADO value=2>";
															 break;
													 };
													};?>
                          <?php };?></td>
                        <td width="23%"><font color="#6699FF">&nbsp;</font></td>
                        <td width="20%">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                      <tr class="datosB">
                        <td width="55%" height="15"><font color="#6699FF"><strong>RESOLUCION DE AUTORIZACION DE TIPO DE ENSE&Ntilde;ANZA</strong></font></td>
                        <td width="9%" class="datos"><strong>N&uacute;mero</strong></td>
                        <td width="7%" class="datos"><?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name="txtNUME2" size="10" maxlength="10"  >
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; </FONT>
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													echo($fila['nu_resolucion']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name="txtNUME2" size="10" maxlength="10" value="<?php echo($fila['nu_resolucion'])?>">
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; </FONT>
                          <?php };?></td>
                        <td width="7%" class="datos"><strong>Fecha</strong></td>
                        <td width="22%" class="datos"><?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name="txtFECHA" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar'>
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>(DD-MM-AAAA)</STRONG> </FONT>
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_res']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name="txtFECHA" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar' value=<?php impF($fila['fecha_res']);?>>
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>(DD-MM-AAAA)</STRONG> </FONT>
                          <?php };?></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                      <tr class="datosB">
                        <td width="55%" height="15"><font color="#6699FF"><strong>RESOLUCION DE CIERRE DE TIPO DE ENSE&Ntilde;ANZA</strong></font></td>
                        <td width="9%" class="datosB"><strong>N&uacute;mero</strong></td>
                        <td width="7%" class="datosB"><span class="datos">
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name="txtNUM3" size=10 maxlength=10  >
                          <br>
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nu_resolucion_cierre']);
												};
											?>
                          <?php if($frmModo=="modificar"){?>
                          <INPUT type="text" name="txtNUM3" size="10" maxlength="10" value="<?php echo($fila['nu_resolucion_cierre'])?>">
                          <br>
                          <?php };?>
                        </span></td>
                        <td width="7%" class="datosB"><strong>Fecha</strong></td>
                        <td width="22%" class="datosB"><span class="datos">
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name="txtFECHAcierre" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar'>
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>(DD-MM-AAAA)</STRONG> </FONT>
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_res_cierre']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name="txtFECHAcierre" size="15" maxlength="10" onChange='fechas(this.value); this.value=borrar' value="<?php impF($fila['fecha_res_cierre'])?>">
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>(DD-MM-AAAA)</STRONG> </FONT>
                          <?php };?>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                      <tr>
                        <td width="36%" height="15"><font color="#6699FF"><strong>EXISTENCIA DE CENTRO DE PADRES</strong></font></td>
                        <td width="7%" class="datos"><?php if($frmModo=="ingresar"){ ?>
                          <INPUT type="checkbox" name=ecp size=83 maxlength=50 >
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_ecp']==0)?"NO":"SI");
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="checkbox" name=ecp size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila['bool_ecp']==1)?"checked":"";
											?>>
                          <?php };?></td>
                        <td width="26%"><font color="#6699FF"><strong>PERSONALIDAD JURIDICA</strong></font></td>
                        <td width="31%" class="datos"><?php if($frmModo=="ingresar"){ ?>
                          <INPUT type="checkbox" name=pj size=83 maxlength=50 >
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_pj']==0)?"NO":"SI");
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="checkbox" name="pj" size="83" maxlength="50" value=1 
											<?php 
											  echo ($fila['bool_pj']==1)?"checked":"";
											?>>
                          <?php };?></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                      <tr>
                        <td width="20%" height="15"><font color="#6699FF"><strong>GRUPO DIFERENCIAL </strong></font></td>
                        <td width="26%" class="datosB"><strong>N&ordm; de Grupos Diferenciales</strong></td>
                        <td width="54%" class="datosB"><?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name="txtNumDife" size="8" maxlength="10">
                          <br>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; </FONT>
                          <?php };?>
                          <?php 
												if($frmModo=="mostrar"){ 
													echo($fila['nu_grupos_dif']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name="txtNumDife" size="8" maxlength="10" value=<?php echo($fila['nu_grupos_dif']);?> >
                          <?php };?></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="19" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                      <tr class="datos">
                        <td width="15%" height="15"><font color="#6699FF"><strong>HORARIO</strong></font></td>
                        <td width="21%" class="datosB"><strong>JORNADA MA&Ntilde;ANA</strong></td>
                        <td width="7%" class="datos">
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="checkbox" name="_JM" id="_JM" size="83" maxlength="50" >
                          <?php };?>
                          <?php 
												if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)) {
													imp("SI");
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="checkbox" name="_JM" size="83" maxlength="50" value="1" 
											<?php 
											  echo (@pg_numrows($resultH)!=0)?"checked":"";
											?>>
                          <?php };?>
                        </td>
                        <td width="34%" class="datosB"><strong>JORNADA ESCOLAR COMPLETA</strong></td>
                        <td width="23%"  class="datos"><?php if($frmModo=="ingresar"){ ?>
                          <input type="checkbox" name="_JMT_2" id="_JMT_2" size="83" maxlength="50" >
                          <?php };?>
                         
                          <?php                                                      
												 if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)) { 
													imp("SI");
												    };
                                       ?>
                         
                          <?php if($frmModo=="modificar"){ 
					  ?>
                                <INPUT type="checkbox" name="_JMT_2" id="_JMT_2" size="83" maxlength="50" value="1"
											<?php 
											  echo (@pg_numrows($resultMT)!=0)?"checked":"";
											?>>
                          <?php };?>                          </td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                      <tr class="datosB">
                        <td width="15%" height="15"><font color="#6699FF"><strong>HORA INICIO </strong></font></td>
                        <td width="28%" class="datosB"><strong>
                          <strong>
                          <?php if($frmModo=="ingresar"){ ?>
                          <INPUT type="text" name="txtHoraIni" id="txtHoraIni" size="10" maxlength="50">
                          <?php };?>
                          <?php 
											 if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)) { 
												imp($filaH['hora_ini']);
											
                                           };
										?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="text" name="txtHoraIni" id="txtHoraIni" size="10" maxlength="50" value="<?php echo trim($filaH['hora_ini'])?>">
                          <?php }; ?>
                          <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM:SS) </FONT>
                          <?php }; ?>
                          </strong></strong></td>
                        <td width="28%"><font color="#6699FF"><strong>HORA INICIO</strong></font></td>
                        <td width="29%" class="datosB"><strong>
                          <strong>
                          <?php if($frmModo=="ingresar"){ ?>
                          <INPUT type="text" name="txtHoraIniMT" id="txtHoraIniMT" size="10" maxlength="50">
                          <?php };?>
                          <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)) { 
											imp($filaMT['hora_ini']);
											};
                                           
										?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="text" name="txtHoraIniMT" id="txtHoraIniMT" size="10" maxlength="50" value="<?php echo trim($filaMT['hora_ini'])?>">
                          <?php }; ?>
                          <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM:SS) </FONT>
                          <?php }; ?>
                          </strong> </strong></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                      <tr class="datosB">
                        <td width="15%" height="15"><font color="#6699FF"><strong>HORA TERMINO </strong></font></td>
                        <td width="28%" class="datosB"><strong>
                          <?php if($frmModo=="ingresar"){ ?>
                          <INPUT type="text" name="txtHoraFin" id="txtHoraFin" size="10" maxlength="50">
                          <?php };?>
                          <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)){
                                               if (@pg_numrows($resultH)!=0){ 
												imp($filaH['hora_ter']);
											};
                                           };
										?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="text" name="txtHoraFin" id="txtHoraFin" size="10" maxlength="50" value="<?php echo trim($filaH['hora_ter'])?>">
                          <?php }; ?>
                          <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM:SS) </FONT>
                          <?php }; ?>
                        </strong></td>
                        <td width="17%"><font color="#6699FF"><strong>HORA TERMINO</strong></font></td>
                        <td width="3%" class="datosB"><strong>
                        <?php if($frmModo=="ingresar"){ ?>
                        <INPUT type="text" name="txtHoraFinMT" id="txtHoraFinMT" size="10" maxlength="50">
                        <?php };?>
                        <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)){
                                             if (@pg_numrows($resultMT)!=0){ 
												imp($filaMT['hora_ter']);
											};
                                          };
										?>
                        <?php if($frmModo=="modificar"){ ?>
                        <INPUT type="text" name="txtHoraFinMT" id="txtHoraFinMT" size="10" maxlength="50" value="<?php echo trim($filaMT['hora_ter'])?>">
                        <?php }; ?>
                        <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                        <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM) </FONT>
                        <?php }; ?>
                        </strong></td>
                        <td width="37%" class="datosB">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                      <tr class="datosB">
                        <td width="15%" height="15"><font color="#6699FF"><strong>HORARIO</strong></font></td>
                        <td width="21%" class="datosB"><strong>JORNADA TARDE</strong></td>
                        <td width="5%"><FONT face="arial, geneva, helvetica" size=1 color=#000000>
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="checkbox" name="_JT" id="_JT" size="83" maxlength="50" >
                          <?php };?>
                          <?php             
                                               
												if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
													imp("SI");
												};
                                                   
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="checkbox" name="_JT" size="83" maxlength="50" value="1" 
											<?php 
											  echo (@pg_numrows($resultT)!=0)?"checked":"";
											?>>
                          <?php };?>
                        </FONT></td>
                        <td width="19%">&nbsp;</td>
                        <td width="40%">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                      <tr class="datosB">
                        <td width="15%" height="15"><font color="#6699FF"><strong>HORA INICIO </strong></font></td>
                        <td width="21%"><strong>
                          <?php if($frmModo=="ingresar"){ ?>
                          <INPUT type="text" name="txtHoraIniT" id="txtHoraIniT" size="10" maxlength="50">
                          <?php };?>
                          <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
                                                if (@pg_numrows($resultT)!=0){ 
												imp($filaT['hora_ini']);
											  };
                                           };
										?>
                          <?php if($frmModo=="modificar"){ ?>
                          <INPUT type="text" name="txtHoraIniT" id="txtHoraIniT" size="10" maxlength="50" value="<?php echo trim($filaT['hora_ini'])?>">
                          <?php }; ?>
                          <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM:SS) </FONT>
                          <?php };?>
                        </strong></td>
                        <td width="13%"><font color="#6699FF">&nbsp;</font></td>
                        <td width="51%">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                      <tr class="datosB">
                        <td width="15%" height="15"><font color="#6699FF"><strong>HORA TERMINO </strong></font></td>
                        <td width="21%"><strong>
                        <?php if($frmModo=="ingresar"){ ?>
                        <INPUT type="text" name="txtHoraFinT" id="txtHoraFinT" size="10" maxlength="50">
                        <?php };?>
                        <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
                                               if (@pg_numrows($resultT)!=0){ 
												imp($filaT['hora_ter']);
											};
                                           };
										?>
                        <?php if($frmModo=="modificar"){ ?>
                        <INPUT type="text" name="txtHoraFinT" id="txtHoraFinT" size=10 maxlength=50 value="<?php echo trim($filaT['hora_ter'])?>">
                        <?php }; ?>
                        <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                        <FONT face="arial, geneva, helvetica" size=1 color=#000000>(HH:MM:SS) </FONT>
                        <?php }; ?>
                        </strong></td>
                        <td width="24%"><font color="#6699FF">&nbsp;</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="37%">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="45" align="center" valign="middle"><table border="0" align="center" cellpadding="10" cellspacing="0" class="tabla02">
                    <tr align="center" valign="middle">
                      
                      <td><a href="#arriba" class="boton02"><img src="../../../cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
                      <td class="boton02"><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="19" align="center" valign="middle">&nbsp;</td>
          </tr>
        </table>
	</FORM>
</BODY>
</HTML>
								  
								  <!-- fin agregar -->
                                  </td>
                                </tr>
                                <!-- <tr>
                                  <td height="103" align="center" valign="top"> 
                                    <table width="98%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                      <tr class="textolink"> 
                                        <td colspan="2">Tipo Instituci&oacute;n</td>
                                        <td width="38%">buscar por RBD (sin verificador)</td>
                                        <td width="31%">&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td width="20%" height="35"> <select name="select" size="1" class="cajatexto">
                                            <option>Colegios</option>
                                            <option>Universidades</option>
                                            <option>Escuelas</option>
                                            <option>Liceos</option>
                                          </select></td>
                                        <td width="11%" align="left"><img src="../../../Sea/cortes/b_listar.gif" width="56" height="18"></td>
                                        <td height="35"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="40%"><input name="textfield" type="text" class="cajatexto" size="15" maxlength="15"></td>
                                              <td width="60%"><img src="../../../Sea/cortes/b_buscar.gif" width="63" height="18"></td>
                                            </tr>
                                          </table></td>
                                        <td height="35">&nbsp;</td>
                                      </tr>
                                      <tr valign="middle"> 
                                        <td height="35" colspan="4"><div align="center" class="piepagina">- 
                                            Seleccionar presionando con el puntero 
                                            del mouse sobre el per&iacute;odo 
                                            que corresponda.</div></td>
                                      --></tr>
                                    </table>
                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                     <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
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

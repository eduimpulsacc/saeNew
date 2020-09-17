<?php require('../../../util/header.inc');?>
<?php 


	$institucion	=$_INSTIT;
	$_POSP = 3;
	
	$menu1 = $_GET['menus'];
	
	if ($menu1 == ''){
	
	$menu1 =0 ;
	
	}
	
	if ($_PERFIL == 19)
	{
	
	$_MDINAMICO = $menu1;
	
	}else{
	 
	$_MDINAMICO = 0;
	
	}
	if ($_PERFIL == 1){
	   $_MDINAMICO = 1;	
	}
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
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
	}
	
?>
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

function confirmar_creacion(){
     if(!confirm("Estimado usuario. \n Para crear un nuevo año, debe tener todos sus años escolares CERRADOS, y crear el nuevo año ABIERTO. \n ¿Está seguro que se encuentra en dicha situación?")){return false;} 
        else {
             window.location="seteaAno.php3?caso=2";
             return false;
     }			 
}	
//-->
</script>

		<?php include('../../../util/rpc.php3');?>
<?php	if($frmModo=="ingresar"){
			include('../../../util/rpc.php3');?>

			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
						return false;
					};

					if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo letras en el NOMBRE.')){
						return false;
					};

					if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
						return false;
					};

					if(!chkVacio(form.txtNUMERO,'Ingresar NUMERO.')){
						return false;
					};

					if(!nroOnly(form.txtNUMERO,'Se permiten sólo números en NUMERO.')){
						return false;
					};
					return true;
				}
			</SCRIPT>
<?php	}; ?>
<?php	if($frmModo=="modificar"){
			include('../../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
						return false;
					};

					if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo letras en el NOMBRE.')){
						return false;
					};

					if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
						return false;
					};

					if(!chkVacio(form.txtNUMERO,'Ingresar NUMERO.')){
						return false;
					};

					if(!nroOnly(form.txtNUMERO,'Se permiten sólo números en NUMERO.')){
						return false;
					};

					if(!chkSelect(f2.m2,'Seleccionar PROVINCIA.')){
						return false;
					};

					if(!chkSelect(f3.m3,'Seleccionar COMUNA.')){
						return false;
					};

					return true;
				}
			</SCRIPT>
<?php	}; ?>
	
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
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
									
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=5 align=right>
					<?php if($_PERFIL==0){ ?>
								<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick="confirmar_creacion();">
					<?php } ?>
					
					
					</td>
			</tr>
			<tr height="20">
				<td colspan="5" align="middle" class="tableindex">A&ntilde;os Acad&eacute;micos </td>
			</tr>
			<tr>
				<td align="center" width="50" class="tablatit2-1">
					<div align="center">NUMERO					  </div></td>
				<td align="center" width="150" class="tablatit2-1">
					<div align="center">FECHA INICIO					  </div></td>
				<td align="center" width="150" class="tablatit2-1">
					<div align="center">FECHA TERMINO					  </div></td>
				<td align="center" width="50" class="tablatit2-1"><div align="center">TIPO DE REGIMEN</div></td>
				<td align="center" width="250" class="tablatit2-1">
					<div align="center">SITUACION					  </div></td>
			</tr>
			<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result =pg_Exec($conn,$qry) or die(pg_last_error($conn));
				//if($_PERFIL==0) echo "numero".pg_dbname($conn);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0;$i < @pg_numrows($result);$i++){
						$fila = @pg_fetch_array($result,$i);
			?>
			
			
			
				<!--MODIFICAR Y DIRECCIONARLO A HISTORICO-->
				<?php if($fila['situacion']==0){//CERRADO?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('seteaAno.php3?ano=<?php echo $fila["id_ano"];?>&caso=1&mdi=<?=$menu1 ?>')>
				<?php }?>
				<?php if($fila['situacion']==1){//ABIERTO
						if (($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=6)&&($_PERFIL!=2)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)){?>
							<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('seteaAno.php3?ano=<?php echo $fila["id_ano"];?>&caso=1')>
					<? }else{ ?>	
							<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('seteaAno.php3?ano=<?php echo $fila["id_ano"];?>&caso=1&from=1&mdi=1')>						
				<?php 	}
				}?>

							<td width="10%" align="right" >
								<div align="center"><font face="arial, geneva, helvetica" size="1" color="#000000">
								  <strong><?php echo $fila["nro_ano"]; ?></strong> </font> </div></td>
							<td width="10%" align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php impF($fila["fecha_inicio"]);?>
									</strong>								</font>							</td>
							<td width="10%" align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
										<?php impF($fila["fecha_termino"]);?>
								</font></td>
							<td width="20%" align="center">
							<font face="arial, geneva, helvetica" size="1" color="#000000">
							<?php switch ($fila['tipo_regimen']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 2:
																		 imp('TRIMESTRAL');
																		 break;
																	 case 3:
																		 imp('SEMESTRAL');
																		 break;
											 };
										?>
										</font></td>
							<td width="20%" align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
										<?php 
											switch ($fila['situacion']) {
												 case 0:
													 imp('CERRADO');
													 break;
												 case 1:
													 imp('ABIERTO');
													 break;
												 default:
													 imp('INDETERMINADO');
													 break;
											 };
										?>
								</font>							</td>
						</tr>
			<?php
					}
				}
			?>
		</table>
	</center>
	<?
	 $ano			=$_ANO;
	?>
									 
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							   </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?> </td>
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
<? pg_close($conn); ?>
</body>
</html>
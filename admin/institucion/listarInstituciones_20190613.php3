<?php 
	require('../../util/header.inc');
	
	session_unregister("_CURSO");
	session_unregister("_ANO");
	session_unregister("_ALUMNO");
	session_unregister("_RAMO");
	session_unregister("ccc");
	session_unregister("_EDUGESTOR");
	
	
	unset($_CURSO);
	unset($_ANO);
	unset($_ALUMNO);
	unset($_RAMO);
	unset($ccc);
	unset($_EDUGESTOR);
	
$_ANO="";
$_CURSO="";

//$pagina_destino='http://192.168.100.203/sae3.0/index.html';
	

	if($tipoIns=="") $tipoIns=1;

    $_POSP = 2;
	$_MDINAMICO = 1;

	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
	
	/*if ($_USUARIO!=1){
header("Location: $pagina_destino");
exit();
}*/
	echo $usuarioensesion = $_USUARIOENSESION;
	
	//$nombreusuario=$_NOMBREUSUARIO;

	
	if ($_PERFIL!=0){ echo "No Permitido"; 
	exit;} 
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}/*else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}*/
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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


function activate(xinstitucion,xstatus,xsistema){ 

	var status = xstatus;
	var mensaje ="";
	
	if(status == 0)
	mensaje= "¿Desea DESACTIVAR Este Sistema para la institucion?";
	else
	mensaje= "¿Desea ACTIVAR Este Sistema para la institucion?";
		
	if(!confirm(mensaje))
       { 
	     return false; 
	   }
	else
	   {	
	   
	     var parametros = "xinstitucion="+xinstitucion+"&xstatus="+xstatus+"&xsistema="+xsistema;
	     
		 //alert(parametros);
		 
		  	$.ajax({
		 		  url:'activasistema.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
					 
		 			    //  if (data==1){ 
					       	$('#sis_'+xsistema+'_'+xinstitucion+'').html(data);
							 alert("Datos modificados"); 
					       // window.location = 'listarMatricula.php3';
							//window.location.reload();
					     // } 
		 			  } 
		 		  })
	   }
	   
} // FIN FUNCION  


</script>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			include("../../cabecera/menu_superior.php");
			?>	
				  
              </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						include("../../menus/menu_lateral.php");
						?>
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- INGRESO DE NUEVO CÓDIGO A LA PLANTILLA -->
                              <?php //echo tope("../../util/");?>
                              <?php if($modo=="ini"){ ?>
                              <form method="post" name="frm1" action="listarInstituciones.php3?listar=A&pag=1">
                              
                              
					<center>
						
    <table border="0" cellpadding="0" cellspacing="0" width=700>
      <tr> 
        <td height="61" colspan=2> <table align=center>
            <tr valign=bottom> 
              <td> <FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>TIPO  DE
                INSTITUCION</strong> </FONT> 
			  </td>
			  <td width="10">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td width="10">&nbsp;</td>
			  <td> <FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>BUSCAR 
                POR RBD(sin verificador)</strong> </FONT> 
			  </td>
			  <td width="10">&nbsp;</td>
			  <td><FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>BUSCAR POR NOMBRE</strong> </FONT></td>
			  <td width="10">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			  <tr>	
			  <td>
				<select NAME="tipoIns">			
                  <option value="1" selected>COLEGIOS 
                  <option value="2">JARDIN INFANTIL 
                  <option value="3">SALA CUNA </select> 
			  </td>
			  <td width="10">&nbsp;</td>
              <td> <input class="botonXX" type="submit" name="submit2" value="LISTAR"> </td>
			  <td width="10">&nbsp;</td>
              <!------------------/filtro por RBD/-------------->
              <td><input type="text" name="filtroRBD"  size="12" > 
                <input type="hidden" name="swrbd"  value=1 size="12" > </td>
				<td>&nbsp;</td>
			  <td><input type="text" name="filtroNOMBRE"  size="20" > </td> 
			  <td width="10">&nbsp;</td>
              <td> <div align="left"> 
                  <input class="botonXX" type="submit" name="submit2" value="BUSCAR">
                </div></td>
              <!------------------/find filtro por RBD/-------------->
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td width="227" align=right> <div align="right">
            <!--input class="botonXX"  type="button" name="Button2" value="NOTICIAS PORTAL" onClick=document.location="../../portal/noticia/listarNoticia.php3"-->&nbsp;&nbsp;&nbsp;
          </div></td>
        <td width="373" align=left> &nbsp;&nbsp;&nbsp;&nbsp; 
          <input class="botonXX" type="button" name="Button" value="AGREGAR INSTITUCION" onClick=document.location="seteaInstitucion.php3?caso=2"> 
        </td>
      </tr>
    </table>
					</center>
				</form>
			<?php }else{?>
				<form method="post" name="frm1" action="listarInstituciones.php3?listar=A&pag=1">
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=700>
						<tr>
							<td align="left" width=0>
								<table align=center>
									<tr valign=bottom>
										<td>
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK>
												<strong>TIPO DE INSTITUCION</strong>
											</FONT><br>
										</td>
										<td width="10">&nbsp;</td>
										<td>&nbsp;</td>
										<td width="10">&nbsp;</td>
										<td>
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK>
												<strong>BUSCAR POR RBD(sin verificador)</strong>
											</FONT><br>
										</td>
										<td width="10">&nbsp;</td>
										<td><FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>BUSCAR POR NOMBRE</strong> </FONT></td>
										<td width="10">&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>										
										<td>
											<select NAME="tipoIns">
													<option value="1" <?php if (trim($tipoIns)==1) echo "selected"  ?>>COLEGIOS
													<option value="2" <?php if (trim($tipoIns)==2) echo "selected"  ?>>JARDIN INFANTIL
													<option value="3" <?php if (trim($tipoIns)==3) echo "selected"  ?>>SALA CUNA
											</select>
										</td>
										<td width="10">&nbsp;</td>
										<td>
										<input class="botonXX" type="submit" name="submit2" value="LISTAR">
										</td>
										<td width="10">&nbsp;</td>
										<!------------------/filtro por RBD/-------------->

											<td>
												<input type="text" name="filtroRBD"  size="12" >
												<input type="hidden" name="swrbd"  value=1 size="12" >
											</td>
											<td width="10">&nbsp;</td>
											<td><input type="text" name="filtroNOMBRE"  size="20" > </td>
											<td width="10">&nbsp;</td>
											<td>
												<div align="left"><input class="botonXX" type="submit" name="submit2" value="BUSCAR"></div>
											</td>
									<!------------------/find filtro por RBD/-------------->
									</tr>
									
								</table>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								<table>
									<tr>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=A&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>A</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=B&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>B</h4></strong></a><td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=C&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>C</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=D&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>D</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=E&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>E</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=F&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>F</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=G&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>G</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=H&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>H</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=I&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>I</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=J&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>J</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=K&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>K</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=L&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>L</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=LL&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>LL</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=M&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>M</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=N&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>N</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=%D1&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>Ñ</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=O&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>O</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=P&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>P</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=Q&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>Q</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=R&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>R</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=S&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>S</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=T&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>T</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=U&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>U</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=V&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>V</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=W&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>W</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=X&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>X</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=Y&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>Y</h4></strong></a></td>
	<td><a HREF="listarInstituciones.php3?pag=1&listar=Z&tipoIns=<?php echo trim($tipoIns) ?>"><strong><h4>Z</h4></strong></a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</center>
				</form>
<?php

	$filRBD=(trim($swrbd)=='1')?$filtroRBD:"";
	if($filtroNOMBRE!='')
	{
	
		$qry = "SELECT * FROM INSTITUCION 
		WHERE upper(nombre_instit) like '%".strtoupper($filtroNOMBRE)."%'"; 
	
	}else
								
	if ($filRBD!='')
	
		$qry = "SELECT * FROM INSTITUCION WHERE rdb=$filtroRBD";
	
	 else {
	
		$qry = "SELECT * FROM INSTITUCION 
		WHERE TIPO_INSTIT=$tipoIns AND (upper(NOMBRE_INSTIT) LIKE '$listar%') 
		ORDER BY NOMBRE_INSTIT LIMIT $largoPagina OFFSET $pagOffset";
	
	 }
	
	$result =pg_Exec($connection,$qry);
	
	if (@pg_numrows($result)!=0){ 
	
	?>

	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=650 align=center>
		<tr>
			<td colspan=20>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
						<td align=left>
							<!--input class="botonXX"  type="button" name="Button2" value="NOTICIAS PORTAL" onClick=document.location="../../portal/noticia/listarNoticia.php3"-->						</td>
						<td>
							<H1><?php echo trim($listar)?></H1>						</td>
						<td align=right><input type="button" name="button2" value="TRASPASO DE INSTITUCION" class="botonXX"  onClick="window.location='traspaso/ConfiguracionTraspaso.php'">
						<input class="botonXX"  type="button" name="Button" value="AGREGAR INSTITUCION" onClick=document.location="seteaInstitucion.php3?caso=2">						                </td>
				</tr>
				</table>			
               </td>
		</tr>
		<tr height="20">
			<td align="middle" colspan="20" class="tableindex">
					Total de Instituciones			</td>
		</tr>
		<tr bgcolor="#48d1cc">
		  <td colspan="16" ALIGN=left bgcolor="#FFFFFF"><font face="arial, geneva, helvetica" size="1" color="#000000">
						   <strong>(Si desea activar/desactivar una aplicaci&oacute;n, haga click sobre la imagen)</strong></font></td>
		  </tr>
		<tr bgcolor="#48d1cc">
			<td ALIGN=CENTER WIDTH=70 class="tablatit2-1">
				RBD			</td>
			<td ALIGN=CENTER WIDTH=200 class="tablatit2-1">
				NOMBRE			</td>
			
			<td ALIGN=CENTER class="tablatit2-1">SISTEMA SAE</td>
			<td ALIGN="center" class="tablatit2-1">SAE MOVIL</td>
			<td ALIGN="center" class="tablatit2-1">EVADOS</td>
			<td ALIGN="center" class="tablatit2-1">RECA</td>
			<td ALIGN="center" class="tablatit2-1">CEDE</td>
			<td ALIGN="center" class="tablatit2-1">SUELDOS</td>
			
			<!--<td ALIGN=center class="tablatit2-1">WEB</td>
			<td ALIGN=center class="tablatit2-1">EMAIL</td>-->
			<td ALIGN=center class="tablatit2-1">PLANIF</td>
			<td ALIGN=center class="tablatit2-1">BIBLIO</td>
			<td ALIGN=center class="tablatit2-1">SMS</td>
			<td ALIGN=center class="tablatit2-1">COMUNICAPP</td>
			<td ALIGN=center class="tablatit2-1">EDUGESTOR</td>
			<td ALIGN=center class="tablatit2-1">CODBARRA</td>
		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){

				$fila = @pg_fetch_array($result,$i);

		 ?>
		    <tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
                <td align="right">
				    <? 
				    if ($_PERFIL!=0){
					   ?>
				   	    <a href="seteaInstitucion.php3?institucion=<?=trim($fila["rdb"])?>&caso=1&_ID_BASE=<?=$fila["base_datos"]?>" 
                        onMouseover="window.status=' !'; return true">
					   <?
					}else{
					   	?>
						<a href="../institucion/seteaInstitucion.php3?institucion=<?php echo trim($fila["rdb"]);?>&caso=1&_ID_BASE=<?=$fila["base_datos"]?>" 
                        onMouseover="window.status=' '; return true">
						<?
					}
					?>	
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						   <strong><?php echo $fila["rdb"]." - ".$fila["dig_rdb"];?></strong>&nbsp;&nbsp;&nbsp;	</font></a></td>
				<td align="left">
				  <?
				    if ($_PERFIL!=0){
					   ?>
				  <a href="seteaInstitucion.php3?institucion=<?php echo trim($fila["rdb"]);?>&caso=1&_ID_BASE=<?=$fila["base_datos"]?>" 
                        onMouseover="window.status=' !'; return true">
				    <?
					}else{
					   	?>
				    <a href="../institucion/seteaInstitucion.php3?institucion=<?php echo trim($fila["rdb"]);?>&caso=1&_ID_BASE=<?=$fila["base_datos"]?>" 
                        onMouseover="window.status=' !'; return true">
				    <?
					}
					?>	
				    
				    <font face="arial, geneva, helvetica" size="1" color="#000000">
				      <strong><?php echo $fila["nombre_instit"];?></strong></font></a>	</td>
				<td align="center"><div id="sis_1_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["estado_colegio"]==1?0:1)?>,1)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["estado_colegio"]==1?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_2_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["saemovil"]==2?0:2)?>,2)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["saemovil"]==2?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_3_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["evados"]==3?0:3)?>,3)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["evados"]==3?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_4_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["reca"]==4?0:4)?>,4)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["reca"]==4?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_7_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["cede"]==7?0:7)?>,7)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["cede"]==7?"OK":"NO")?>.png" border="0"></a></div></td>
                
				<td align="center"><div id="sis_11_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["sueldos"]==11?0:11)?>,11)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["sueldos"]==11?"OK":"NO")?>.png" border="0"></td>
                
				<!--<td align="center"><div id="sis_9_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["web"]==9?0:9)?>,9)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["web"]==9?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_10_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["aemail"]==10?0:10)?>,10)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["aemail"]==10?"OK":"NO")?>.png" border="0"></a></div></td>-->
				<td align="center"><div id="sis_12_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["planificacion"]==12?0:12)?>,12)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["planificacion"]==12?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_13_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["biblioteca"]==13?0:13)?>,13)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["biblioteca"]==13?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_15_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["sms"]==15?0:15)?>,15)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["sms"]==15?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_17_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["sms"]==17?0:17)?>,17)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["comunicapp"]==17?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_14_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["edugestor"]==14?0:14)?>,14)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["edugestor"]==14?"OK":"NO")?>.png" border="0"></a></div></td>
				<td align="center"><div id="sis_16_<?php echo $fila["rdb"] ?>"><a href="#" onClick="activate(<?php echo $fila["rdb"] ?>,<?php echo ($fila["codbarra"]==16?0:16)?>,16)"><img src="../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo ($fila["codbarra"]==16?"OK":"NO")?>.png" border="0"></a></div></td>				
			</tr>
		<?php }?>
		<tr>
			<td colspan="20">
			<hr width="100%" color="#003b85">			</td>
		</tr>
		<tr height="50" bgcolor="white">
			<td align="middle" colspan="20">
				<?php if($pag!=1){?>
					<a HREF="listarInstituciones.php3?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Anteriores <?php echo $largoPagina?> ...</strong></font></a>
					<?php if(pg_numrows($result)==$largoPagina){?>
						&nbsp;&nbsp;&nbsp;
						<font face="arial, geneva, helvetica" size="5" color="black">
							<strong>-</strong>						</font>
						&nbsp;&nbsp;&nbsp;
					<?php }?>

				<?php }?>
				<?php if(pg_numrows($result)==$largoPagina){?>
					<a HREF="listarInstituciones.php3?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Siguientes <?php echo $largoPagina?> ...</strong>						</font>					</a>
				<?php }?>			</td>
		</tr>
	</table>
	<?php }?>
<?php }?>

<!-- FIN DEL NUEVO CODIGO DE LA PLANTILLA -->
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">
					  <?  include("../../cabecera/menu_inferior.php"); ?>
	                </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? 
	pg_close($conn);
	pg_close($connection);
?>
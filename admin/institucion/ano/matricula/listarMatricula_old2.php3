<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	$sql="";
	$sql="SELECT count(bool_ar) AS ret FROM matricula WHERE id_ano=".$ano." AND bool_ar=1";
	$Rs_Retirados = @pg_exec($conn,$sql);
	$filsRetirados = @pg_fetch_array($Rs_Retirados,0);

	$sql="";
	$sql="SELECT count(bool_ar) AS mat FROM matricula WHERE id_ano=".$ano." AND bool_ar=0";
	$Rs_Matriculados =@pg_exec($conn,$sql);
	$filsMatriculados =@pg_fetch_array($Rs_Matriculados,0);
?>
<html>
	<head>
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

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../feriado/listaFeriado.php3"><img src="../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../curso/listarCursos.php3"><img src="../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/matricula_roll.gif" name="Image7" width="81" height="30" border="0" id="Image7" ></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../util/");?>
			<?php if($modo=="ini"){ ?>
				<form method="post" name="frm1" action="listarMatricula.php3?sw_lista=1">
				  <center>
				</center>
				</form>
			<?php }else{?>
				<form method="post" name="frm1" action="listarMatricula.php3?sw_lista=1">
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=650>
						<tr>
							<td align="left">
								<table align=center width="100%">
									<tr valign=bottom>
										<td>
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK>&nbsp;
											</FONT><br>								      </td>
										<td align="left" valign="top">
										<input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" name="submit2" value="LISTAR">
										</td>
										<td align="left" valign="middle">
										<input name="BUSCARX" type="radio" value="1" onClick="LayerRut.style.visibility='visible'; LayerApe.style.visibility='hidden'">
										  <FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>BUSCAR POR RUT </strong></FONT><br>
									    <input name="BUSCARX" type="radio" value="2" onClick="LayerRut.style.visibility='hidden'; LayerApe.style.visibility='visible'">
									    <FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>BUSCAR POR APELLIDO </strong></FONT></td>
										<!------------------/filtro por RBD/-------------->
										<td>
										<div id="LayerRut" style="visibility:hidden ">
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK>
											<strong>INGRESE RUT(sin verificador)<br></strong>
											</FONT>
											<input type="text" name="filtroRUT"  size="12" >
											<input type="hidden" name="swrbd"  value=1 size="12" >	
									    </div>
										<div id="LayerApe" style="visibility:hidden ">
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>INGRESE APELLIDO<br>
											<input name="Apellido" type="text"  size="20" maxlength="40" >
											</strong></FONT>
									    </div>
									   </td>
											<td><FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>										    </strong></FONT></td>
											<td align="right" valign="top">
												<div align="left"><input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" name="submit2" value="BUSCAR"></div>
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
	<td><a HREF="listarMatricula.php3?pag=1&listar=A&sw_lista=1"><strong><h4>A</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=B&sw_lista=1"><strong><h4>B</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=C&sw_lista=1"><strong><h4>C</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=D&sw_lista=1"><strong><h4>D</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=E&sw_lista=1"><strong><h4>E</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=F&sw_lista=1"><strong><h4>F</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=G&sw_lista=1"><strong><h4>G</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=H&sw_lista=1"><strong><h4>H</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=I&sw_lista=1"><strong><h4>I</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=J&sw_lista=1"><strong><h4>J</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=K&sw_lista=1"><strong><h4>K</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=L&sw_lista=1"><strong><h4>L</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=LL&sw_lista=1"><strong><h4>LL</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=M&sw_lista=1"><strong><h4>M</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=N&sw_lista=1"><strong><h4>N</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=�&sw_lista=1"><strong><h4>�</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=O&sw_lista=1"><strong><h4>O</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=P&sw_lista=1"><strong><h4>P</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Q&sw_lista=1"><strong><h4>Q</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=R&sw_lista=1"><strong><h4>R</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=S&sw_lista=1"><strong><h4>S</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=T&sw_lista=1"><strong><h4>T</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=U&sw_lista=1"><strong><h4>U</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=V&sw_lista=1"><strong><h4>V</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=W&sw_lista=1"><strong><h4>W</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=X&sw_lista=1"><strong><h4>X</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Y&sw_lista=1"><strong><h4>Y</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Z&sw_lista=1"><strong><h4>Z</h4></strong></a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</center>
				</form>
<?php

	$filRUT=(trim($swrbd)=='1')?$filtroRUT:"";
	

	if ($filRUT!=''){
		if ($BUSCARX==1){
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso  FROM MATRICULA, ALUMNO WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rut_alumno = alumno.rut_alumno";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso  FROM MATRICULA, ALUMNO WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rut_alumno = alumno.rut_alumno";
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
		}
	 } else {
		if ($BUSCARX==2){	 
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso FROM MATRICULA, ALUMNO WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and alumno.rut_alumno = matricula.rut_alumno and matricula.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and alumno.rut_alumno = matriculatpsincurso.rut_alumno and matriculatpsincurso.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso FROM MATRICULA INNER JOIN ALUMNO ON alumno.rut_alumno = matricula.rut_alumno WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and matricula.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON alumno.rut_alumno = matriculatpsincurso.rut_alumno WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%')and matriculatpsincurso.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";		
		}
	 }
	 
	 //------
	if ($BUSCARX==0){	 
		if ($filRUT!=''){
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso  FROM MATRICULA, ALUMNO WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rut_alumno = alumno.rut_alumno";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso  FROM MATRICULA INNER JOIN ALUMNO ON matricula.rut_alumno=alumno.rut_alumno WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rdb= ".$institucion;
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON matriculatpsincurso.rut_alumno=alumno.rut_alumno WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rdb= ".$institucion;		
		 } else {
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso FROM MATRICULA, ALUMNO WHERE (alumno.ape_pat LIKE '$listar%') and alumno.rut_alumno = matricula.rut_alumno and matricula.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE (alumno.ape_pat LIKE '$listar%') and alumno.rut_alumno = matriculatpsincurso.rut_alumno and matriculatpsincurso.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso FROM MATRICULA INNER JOIN ALUMNO ON alumno.rut_alumno = matricula.rut_alumno WHERE (alumno.ape_pat LIKE '$listar%') and matricula.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON alumno.rut_alumno = matriculatpsincurso.rut_alumno WHERE (alumno.ape_pat LIKE '$listar%') and matriculatpsincurso.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";		

		 }	 
	}
	if ($sw_lista==1){
		$result =@pg_Exec($conn,$qry);
		$result3 =@pg_Exec($conn,$qry2);
	?>
	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=650 align=center>
		<tr>
			<td colspan=3>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
					  <td align="right">                       <?php  /*$qry="SELECT * FROM (institucion INNER JOIN matricula ON institucion.rdb=matricula.rdb)INNER JOIN (curso INNER JOIN tipo_ensenanza ON cod_tipo=ensenanza ) ON matricula.id_curso=curso.id_curso WHERE (institucion.rdb=(".$institucion.") AND (cod_tipo='410' OR cod_tipo='510' OR cod_tipo='610' OR cod_tipo='710' OR cod_tipo='810' ))";*/
					   			$qry="select * from tipo_ense_inst where rdb=".$institucion." and cod_tipo>310 and estado=0";
											$result2 =@pg_Exec($conn,$qry);
												if (pg_numrows($result2)!=0){  ?>
                     <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="AGREGAR SIN CURSO" onClick=document.location="seteaMatriculaTP.php3?caso=2">
											<?php }?>
					   <?php }?>
                     <?php }?>

					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<? if($institucion==24511){?><INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="POSTULACION" onClick=document.location="SaintAngela/ListadoPostulantes.php?ano_escolar2<? echo $ano_escolar2?>"><? }?>											
						<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="AGREGAR" onClick=document.location="seteaMatricula.php3?caso=2">
											<?php }?>
					<?php }?>
					<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../seteaAno.php3?caso=4"></td>
				  </tr>
					<tr>
						<td align=center>
							<H1><?php echo trim($listar)?></H1></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr height="20" bgcolor="#003b85">
			<td align="center" colspan="3">
				<font face="arial, geneva, helvetica" size="2" color="#ffffff">
					<strong>MATRICULA <? echo @pg_numrows($result)+@pg_numrows($resul3)?> ALUMNOS</strong>
				</font>
			</td>
		</tr>
		<tr bgcolor="#48d1cc">
			<td ALIGN=CENTER>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>RUT</strong>
				</font>
			</td>
			<td ALIGN=CENTER >
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>NOMBRE ALUMNO </strong></font></td>
			<td ALIGN=CENTER>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>CURSO</strong></font>
			</td>
		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
		?>

						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaMatricula.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo $fila["rut_alumno"]."-".$fila["dig_rut"];?></strong>
			  </font>
		  </td>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo ucwords(strtolower(trim($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])));?></strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>  				  </strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		    <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
  			  </font>
		  </td>
		  <td align="left">
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>
				  <?php 
				  $Curso_pal = CursoPalabra($fila["id_curso"], 0, $conn);
				  if (empty($Curso_pal))
				  	$Curso_pal = "Sin Curso";
   			  	  $Curso_pal = trim(ucwords(strtolower($Curso_pal)));
				  echo $Curso_pal;
				  
				  ?>
				  </strong>
			  </font>
		  </td>
			</tr>
		<?php }?>
		<?php
			for($i=0 ; $i < @pg_numrows($result3) ; $i++){
				$fila = @pg_fetch_array($result3,$i);
		?>

		<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaMatriculaTP.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo $fila["rut_alumno"]."-".$fila["dig_rut"];?></strong>
			  </font>
		  </td>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo ucwords(strtolower(trim($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])));?></strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>  				  </strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		    <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
  			  </font>
		  </td>
		  <td align="left">			  <font face="arial, geneva, helvetica" size="1" color="#000000">
			  <strong>
				  SIN CURSO
			  </strong>
		  </font>
		  </td>
	  </tr>
		<?php }?>		
		<tr>
			<td colspan="3">
			<hr width="100%" color="#003b85">
			</td>
		</tr>

	</table>
	<?php }?>
	<?php }?>
<?php 
	//	echo "pag:".$pag."<BR>";
	//	echo "pagOffset:".$pagOffset."<BR>";
	//	echo "pg_numrows:".pg_numrows($result)."<BR>";

if ($sw_lista==1){
?>
<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=650 align=center>
<TR>
	<TD WIDTH="70%"> <font face="arial, geneva, helvetica" size="1">Total Alumnos Matriculados</font></TD>
	<TD> <font face="arial, geneva, helvetica" size="1" color="#000000"><? echo $filsMatriculados['mat'];?></font></TD>
</TR>
<TR>
	<TD WIDTH="30%"> <font face="arial, geneva, helvetica" size="1">Total Alumnos Retirados</font></TD>
	<TD> <font face="arial, geneva, helvetica" size="1" color="#000000"><? echo $filsRetirados['ret'];?></font></TD>
</TR>
</TABLE>
<? } ?>
</body>
</html>
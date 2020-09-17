<?php 	require('../../../../../util/header.inc');?>
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
//-->
</script>
<head>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;

	$fecha=getdate();
	$diaActual=$fecha["mday"];
	
	
	
	
	
	$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}
	
?>
					

<SCRIPT language="JavaScript">

function enviapag(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'asistencia.php3';
				form.submit(true);
	
				}	
			}
</SCRIPT>
<script language= "JavaScript">
var ancho , alto , cCeldas , celdas , pasoH , pasoV;

/*
function iniciar(){
	celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
	celdas1 = document.getElementById("contenido").getElementsByTagName("td").length;

	for (i=0; i<celdas0;i++){
		cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";
	}

	for (j=0; j<celdas1;j++){
		cCeldas = document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML;
		document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML = cCeldas+"<img class=\"rell\">";
	}
}
*/

function iniciar(){
	celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
	
	for (i=0; i<celdas0;i++){
		cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";

		cCeldas2 = document.getElementById("contenido").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("contenido").getElementsByTagName("td").item(i).innerHTML = cCeldas2+"<img class=\"rell\">";
	}
}


function desplaza(){
	pasoH = document.getElementById("contenedor").scrollLeft;
	pasoV = document.getElementById("contenedor").scrollTop;
	document.getElementById("contEncCol").scrollLeft = pasoH;
	document.getElementById("contEncFil").scrollTop = pasoV;
}

</script>
<!--
<style>
table{border-collapse:collapse}
table td{font:12px monospace; border:0px solid; text-align:center; height:1.5em}
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; width:40em}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em}
#contenedor{overflow:auto; width:40em; height:20em}
#contenido{}
.tabla td{border:1px solid; width:2em}
.rell{width:2em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red}
</style>
-->
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<style>
.td_temp{font:12px monospace; border:3px solid; text-align:center; height:1.5em; width:50px}
.td_temp2{font:12px monospace; border:0px solid; text-align:center; height:1.5em; }
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; width:40em}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em}
#contenedor{overflow:auto; width:40em; height:20em}
#contenido{}
.tabla td{border:1px solid; width:6em}
.rell{width:2em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red}
</style>


<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
-->
</head>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%"><tr><td>&nbsp;</td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="15%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>
                        <? include("../../../../../menus/menu_lateral.php"); ?>
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="85%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> <? include("../../../../../menus/menu_lateral.php"); ?></td>
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo nuevo -->
								  
								  				  
								  
								   
<!--<body onload=iniciar()>-->

<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<?php }?>


<?php //echo tope("../../../../../util/");?>
<form name="form1" method="post" action="procesoAsistencia.php3">

	  	<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1  width="90%">
          <TR> 
            <TD><div align="left"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong> 
              </FONT> </div></TD>
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </div></TD>
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{

													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);

 											}
										?>
              </strong> </FONT> </div></TD>
          </TR>
          <TR> 
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </div></TD>
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </div></TD>
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong> 
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
													$nroAno=trim($fila1['nro_ano']);
												}
											}
										?>
              </strong> </FONT> </div></TD>
          </TR>
          <TR>
            <TD><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CURSO
              </strong></font></div></TD>
            <TD><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></div></TD>
            <TD><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">
		    <?php 	$qry="SELECT * FROM CURSO WHERE ID_CURSO=".$curso;
					$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
						}else{
							if (pg_numrows($result)!=0){
								$fila11 = @pg_fetch_array($result,0);	
								if (!$fila11){
									error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
									exit();
								}
								$qry2="select nombre_tipo from tipo_ensenanza where cod_tipo=".$fila11[ensenanza];
									$result2 =@pg_Exec($conn,$qry2);
										if (!$result2) {
											error('<B> ERROR :</b>Error al acceder a la BD. (53)</B>');
										}else{
											if (pg_numrows($result2)!=0){
												$fila12 = @pg_fetch_array($result2,0);	
												if (!$fila12){
													error('<B> ERROR :</b>Error al acceder a la BD. (54)</B>');
													exit();
												}
											}
										}
								}
						}
						echo $fila11[grado_curso] , "-" , $fila11[letra_curso] , " " , $fila12[nombre_tipo] ; ?>
						  

			&nbsp;</font></strong></div></TD>
          </TR>
        </TABLE>

        <input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
        <table  width="90%" border="0" cellpadding="5" cellspacing="5">
          <tr> 
            <td height="33"><div align="right">
              <?php if (($frmModo=="ingresar") OR ($frmModo=="modificar")){?>		  		    
			    
                    <input class="botonXX"  type="submit" name="Button" value="GUARDAR"> 
                <?php } ?>
                <?php if ($frmModo=="mostrar") {
			  			if(($_PERFIL!=6)&&($_PERFIL!=20)) {
						       
							   
							   if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
				                      ?>
				                      <input class="botonXX"  type="button" name="Button2" value="MODIFICAR"> 
									  <?
								}else{
								      ?>
				                      <input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAsistencia.php3?caso=1&mes=<?php echo $cmbMes ?>">
									  <?
								}?>								
								
									  
									  
              		            <? } ?>
                             <?php } ?>
					            <input class="botonXX"  type="button" name="Button3" value="VOLVER" onClick=window.location="seteaAsistencia.php3?caso=6">
              </div></td>
          </tr>
</table>
        <table width="95%" border="0">
          <tr> 
            <td width="58"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado</font></strong></td>
            <td width="10"><strong><font size="1" face="Arial, Helvetica, sans-serif">:</font></strong></td>
            <td width="17" bgcolor="#FFE6E6">&nbsp;</td>
            <td width="9">&nbsp;</td>
            <td width="72"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actual</font></strong></td>
            <td width="9"><strong><font size="1" face="Arial, Helvetica, sans-serif">:</font></strong></td>
            <td width="16" bgcolor="#FFFFD7">&nbsp;</td>
            <td width="81"><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana</font></strong></td>
            <td width="8"><strong><font size="1" face="Arial, Helvetica, sans-serif">:</font></strong></td>
            <td width="16" bgcolor="#EAEAEA">&nbsp;</td>
            <td width="75" ><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Inasistencia</font></td>
            <td width="7" ><font size="1" face="Arial, Helvetica, sans-serif">:</font></td>
            <td width="17" bgcolor="#E1EFFF" ><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="75" ><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias del Mes</font></td>
            <td width="7" ><font size="1" face="Arial, Helvetica, sans-serif">:</font></td>
            <td width="47"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;I.M.</font></td>
            <td width="">&nbsp;</td>

          </tr>
        </table>
<br>
        <table width="740" border="0" cellpadding="1" cellspacing="1">
          <tr> 
            <td width="17%" height="20" align="left" class="tableindex">INASISTENCIA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="cmbMes" onChange="enviapag(this.form);">
			   <option value="0" selected>Selecciones Mes</option>
			    <?php 
				if($cmbMes==""){
				$fecha=getdate();
				$cmbMes=$fecha["mon"];
				}
				if ($cmbMes=="01"){
               		 echo "<option value=01 selected>ENERO</option>";
				 }else	 
					echo "<option value=01>ENERO</option>";
				 if ($cmbMes=="02"){
               	 	echo "<option value=02 selected>FEBRERO</option>";
				  }else 
					echo "<option value=02>FEBRERO</option>";
				 if ($cmbMes=="03"){
                echo "	<option value=03 selected>MARZO</option>";
				 }else 
					echo "<option value=03>MARZO</option>";
				 if ($cmbMes=="04"){
                	echo "<option value=04 selected>ABRIL</option>";
				 }else 
					echo "<option value=04>ABRIL</option>";
				 if ($cmbMes=="05"){
                	echo "<option value=05 selected>MAYO</option>";
				 }else
					echo "<option value=05>MAYO</option>";
				 if ($cmbMes=="06"){
               		echo "<option value=06 selected>JUNIO</option>";
				 }else
					echo "<option value=06>JUNIO</option>";
				
				 if ($cmbMes=="07"){
                echo "	<option value=07 selected>JULIO</option>";
				 }else
					echo "<option value=07>JULIO</option>";
				 if ($cmbMes=="08"){
                echo "	<option value=08 selected>AGOSTO</option>";
				 }else
					echo "<option value=08>AGOSTO</option>";
				 if ($cmbMes=="09"){
                	echo "<option value=09 selected>SEPTIEMBRE</option>";
				 }else
					echo "<option value=09>SEPTIEMBRE</option>";
				 if ($cmbMes=="10"){
                	echo "<option value=10 selected>OCTUBRE</option>";
				 }else
					echo "<option value=10>OCTUBRE</option>";
				 if ($cmbMes=="11"){
                echo "<option value=11 selected>NOVIEMBRE</option>";
				 }else
					echo "<option value=11>NOVIEMBRE</option>";
				 if ($cmbMes=="12"){
                echo "<option value=12 selected>DICIEMBRE</option>";
				 }else	echo "<option value=12>DICIEMBRE</option>";
				 ?>
              </select>
             </td>
          </tr>

</table>

<br>

<form name="form1" method="post" action="../../../../../procesoAsistencia.php3">
  <table border="0" cellpadding="1" cellspacing="1">
		             <?php

						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}

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
						$nroAno=trim($fila1['nro_ano']);
					}
				}
		
				if ($cmbMes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if (($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if ($cmbMes==1) $diaFinal=31;
					if ($cmbMes==3) $diaFinal=31;
					if ($cmbMes==4) $diaFinal=30;
					if ($cmbMes==5) $diaFinal=31;
					if ($cmbMes==6) $diaFinal=30;
					if ($cmbMes==7) $diaFinal=31;
					if ($cmbMes==8) $diaFinal=31;
					if ($cmbMes==9) $diaFinal=30;
					if ($cmbMes==10) $diaFinal=31;
					if ($cmbMes==11) $diaFinal=30;
					if ($cmbMes==12) $diaFinal=31;
					//FIN AJUSTA
				}

				//ALUMNOS DEL CURSO
//				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ORDER BY ape_pat,ape_mat,nombre_alu asc";
				$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
				$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
				$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ";
				$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
				$result =@pg_Exec($conn,$qry);

				if(!$result)
					error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
				else{
					if(pg_numrows($result)!=0){ ?>

							<TR class="tablatit2-1">
							<TD>&nbsp;&nbsp;ALUMNO&nbsp;&nbsp;
							</TD>

							<td>
							<div id="contEncCol"   style="width:400px ">	
							<table class="tabla" id="encCol" style="width:100% "> 
								<tr>

<?							for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ ?>
										<TD width="50" class="td_temp" style=" width:90px; "><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG> 0<? echo $count; ?> </STRONG></FONT></TD>
                                        <?									}else{  ?>
										<TD class="td_temp" ><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;<? echo $count; ?></STRONG></FONT></TD>
                                        <?									}
								}
								else{
									if ($count<10){ ?>
										<TD class="td_temp"  width="90"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;0<? echo $count; ?></STRONG></FONT></TD>
                                        <?									}else{ ?>
										<TD class="td_temp" ><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><? echo $count; ?></STRONG></FONT></TD>
                                        <?									}
								}
							} // fin for $count
					}	// fin if
					if ($frmModo=="mostrar"){ ?>
						<TD class="td_temp"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>I.M.</STRONG></FONT></TD>
                        <?					} ?>

							<TD class="td_temp"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;</STRONG></FONT></TD>
						</tr>
						</table>
						</div>		
						</td>
					</tr>


					<tr>
					<td valing=top>
					<div id="contEncFil">
					<table width="100%" height="100%" Id="encFil">	

<?					


					$X=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$X++;
						$Y=0;
						$fila1 = @pg_fetch_array($result,$i);
						if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
							if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
								   ?>								
									<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> <?
							}else{  ?>
								<TR bgcolor=#ffffff>
<?							}
						}else{  ?>
							<TR bgcolor=#ffffff>
<?						}  ?>
<?												//width=15   ?>

						<TD align=left  class="td_temp2"><div align="left"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?						if($fila1["nro_lista"]!=NULL){
							if($fila1["nro_lista"]<10){
								echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
							}
							else{
								echo  trim($fila1["nro_lista"])." &nbsp;";
							}
						}
						else{
							echo  " &nbsp; &nbsp; &nbsp;";
						}
						echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);	?>
						</STRONG></FONT></div>
						</TD>
						</tr>
<? 					}	?>
					</table>
					</div>	
					</td>
					
					<td>
					<div id="contenedor" onscroll="desplaza()" style="width:400px " >
					<table width="100%" class="tabla" id="contenido">	


<?
					//ALUMNOS DEL CURSO
/*					$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  ";
					$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
					$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ";
					$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
					$result =@pg_Exec($conn,$qry);
*/

/*
echo "<br>";
echo						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}
*/

					$X=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$X++;
						$Y=0;
						$fila1 = @pg_fetch_array($result,$i);

 						$qry9="select count (rut_alumno) as cantidad from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
						$result9 =@pg_Exec($conn,$qry9);
						$fila9 = @pg_fetch_array($result9,0);
						$cant=$fila9["cantidad"];
						if (!$result9) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry9);
						}
							
						/******** QRY PARA TRAER DIAS FERIADOS Y COLOREAR LA COLUMNA QUE CORRESPONDE********/
/*echo "<br>";
echo						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}
*/							
						/******** QRY PARA TRAER DIAS INASISTENCIA********/	
						$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
						$result2 =@pg_Exec($conn,$qry2);
						if (!$result2)
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
													
						if ($frmModo=="mostrar"){

?>							
<tr bgcolor="ffffff">
<?						
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+2;
							//for($c=1;$c<=33;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{
										//if ($c==32){
										if ($c==($cDias-1)){	?>
											<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?											echo $cant;	?>
											</strong></font></TD>
	<?										$flag=1;
										}else{
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "3*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else{ ?>
													<TD align=center bgcolor=#E1EFFF class="td_temp"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "4*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
												$ñ++;
											}
											else{
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else{	?>
													<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}

										}
									}
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) and ($flag!=1)){	?>
									<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo $cant;	?>
									</strong></font></TD>
<?								}
							}//fin for($c=1;$c<32;$c++)
?>
								<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;</strong></font></TD>
							</tr>
<?															
						}else{
							if($frmModo=="ingresar"){

?>							<tr bgcolor="ffffff">
<?						
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+1;
							
							//for($c=1;$c<=32;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<32)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){	?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										<INPUT TYPE=checkbox NAME="a[<? echo $X;?>][<? echo $c; ?>]" disabled>		
										</strong></font></TD>
<?										$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											<INPUT TYPE=checkbox NAME="a[<? echo $X;?>][<? echo $c;?>]" disabled>
											</strong></font></TD>
<?										}
										$c=$c-1;
										$m++;
									}else{
										if ($c==$fila2["day"]){
											$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
											if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}else///
											if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" disabled>
												</strong></font></TD>
<?											}else///
											if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}else{	?>
												<TD align=center bgcolor='#E1EFFF'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}
											$ñ++;
										}else{
										$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
										if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}else///
										if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" disabled>
												</strong></font></TD>
<?										}else///
										if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}else{	?>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
							  </strong></font></TD>
<?										}
									}
																		
								}
																	
							}//fin if $c<32

						}//fin for($c=1;$c<32;$c++)

					}//fin if $frmModo
?>
								<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;</strong></font></TD>
							</tr>
<?															
				}// fin else 
			}
?>
					  </table>
					  </div>
					  </td>
<?

		}
?>

			</tr>
  </table>
</form>

							
					  
								  
								  
								  <!-- fin codigo nuevo  -->
								  </td>
                                </tr>
                              </table>
						    </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>

</body>
</html>

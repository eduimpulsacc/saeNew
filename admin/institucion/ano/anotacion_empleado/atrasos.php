<?php 	require('../../../../util/header.inc');

$institucion	= $_INSTIT;
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
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25) &&($_PERFIL!=19)){$whe_perfil_curso=" and curso.id_curso=$curso";}

if($frmModo=="")
{
$frmModo = mostrar;
}

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

function enviapag3(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'atrasos.php';
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
//	document.getElementById("contEncFil").scrollTop = pasoV;
}

function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="seteaCurso.php3?caso=11&p=15&curso="+curso2+"&frmModo="+frmModo
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
				pag="../seteaAno.php3?caso=10&pa=13&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
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
<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<style>
.td_temp{font:12px monospace; border:3px solid; text-align:center; height:1.5em; vertical-align:top}
.td_temp2{font:12px monospace; border:0px solid; text-align:center; height:1.5em; vertical-align:top }
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; vertical-align:top}
#encCol{}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em; vertical-align:top}
#contenedor{overflow:auto; height:20em; vertical-align:top; vertical-align:top}
#contenido{}
.tabla td{border:1px solid;  vertical-align:top}
.rell{ height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red; vertical-align:top}
</style>



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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%">
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="1%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>&nbsp;
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="85%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../cabecera/menu_superior7.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 
						  <table><tr><td  valign="top" width="1%">
						 <?  $menu_lateral="6";?> <? include("../../../../menus/menu_lateral.php"); ?>
						 </td>
						 <td valign="top" width="100%"  class="cajaborde">
						  <!--- AQUI ENPIEMZA-->
						 <!-- inicio codigo nuevo -->
								  
								  				  
								  
								   
<!--<body onload=iniciar()>-->

<?php /*if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<?php } */?>


<?php //echo tope("../../../../../util/");?>


	  	<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1  width="90%">
          <TR> 
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </div></TD>
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </div></TD>
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
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
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">

						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
				<? }	?>
              </form>
          </TR>          
        </TABLE>
		

<form name="form1" method="post" action="procesoAtrasos.php?">
        <input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
		<input type="hidden" name="ensenanza" value="<?=$filan['ensenanza']; ?>">
        <table  width="740" cellpadding="5" cellspacing="5" align="center" border="0">
          <tr> 
            <td height="20"><div align="right">
              <?php 
			  if(($frmModo=="ingresar") OR ($frmModo=="modificar")){
			  		if($ingreso==1 || $modifica==1){?>
              <input class="botonXX"  type="submit" name="Button" value="GUARDAR">
              <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAtrasos.php?caso=2"> 
                <?php }
				} ?>
                <?php if($frmModo=="mostrar" OR $frmModo="ingresar"){
							if($frmModo=="mostrar")					       							   
								   if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
										if (($modifica==1)){  ?>
										   <input class="botonXX"  type="button" name="Button2" value="MODIFICAR"> 
									 <? }  
										
									}else{
									  if ($modifica==1){ ?>
										  <input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAtrasos.php?caso=1&mes=<?php echo $cmbMes ?>">
									   <?  } ?>	  
									<?
									 if (($_PERFIL == 19) AND ($_PERFIL == 0) AND ($_PERFIL == 14)){ ?>
									    <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../curso.php3">
								  <? } ?>		
									      
									  <?
								}?>																									  									  

              </div></td>
          </tr>
</table>
        <table width="740" border="0" align="center">
        <!--  <tr> 
            <td width="48"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado:</font></strong></td>
            <td width="21" bgcolor="#FFE6E6">&nbsp;</td>
            <td width="33">&nbsp;</td>
            <td width="47"><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana:</font></strong></td>
            <td width="21" bgcolor="#EAEAEA">&nbsp;</td>
			<td width="33">&nbsp;</td>
            <td width="33"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actua:</font></strong></td>
            <td width="21" bgcolor="#FFFFD7">&nbsp;</td>
			<td width="33">&nbsp;</td>
            <td width="57" ><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Inasistencia:</font></td>
            <td width="21" bgcolor="#E1EFFF" ><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
			<td width="33">&nbsp;</td>
            <td width="58" ><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias del Mes:</font></td>
            <td width="114"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;I.M.</font></td>           
          </tr>
	-->
        </table>
<br>
        <table width="740" border="0" cellpadding="1" cellspacing="1" align="center">
          <tr> 
            <td width="17%" height="20" align="left" class="tableindex">ATRASOS DEL PERSONAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="cmbMes" onChange="enviapag3(this.form);">
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
<?  //Nombres de los alumnos				
	$qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo ";
	$res = pg_Exec($qry);	
?>
<center>



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
					if(($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if($cmbMes==1){ 
						$diaFinal=31; 
						$mes="01";
					}
					if($cmbMes==2){ 
						$mes="02";
					}
					if($cmbMes==3){ 
						$diaFinal=31; 
						$mes="03";
					}
					if($cmbMes==4){ 
						$diaFinal=30; 
						$mes="04";
					}
					if($cmbMes==5){ 
						$diaFinal=31; 
						$mes="05";
					}
					if($cmbMes==6){ 
						$diaFinal=30; 
						$mes="06";
					}
					if($cmbMes==7){ 
						$diaFinal=31; 
						$mes="07";
					}
					if($cmbMes==8){ 
						$diaFinal=31; 
						$mes="08";
					}
					if($cmbMes==9){ 
						$diaFinal=30; 
						$mes="09";
					}
					if($cmbMes==10){ 
						$diaFinal=31; 
						$mes="10";
					}
					if($cmbMes==11){ 
						$diaFinal=30; 
						$mes="11";
					}
					if($cmbMes==12){ 
						$diaFinal=31; 
						$mes="12";
					}
					//FIN AJUSTA
				}
	?>
				
	<input type="hidden" name="diaFinal" value="<?=$diaFinal?>">
	<table width="700">
					<TR>
							<td valign="top" align="right">
							
							<div id="contEncCol"   style="width:700px ">
														
							<table border="1" bordercolor="#666666" id="encCol" style="width:100% "> 
								<tr>
								<td width="300">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?							for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ ?>
										<TD width="50" align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG> 0<? echo $count; ?> </STRONG></FONT></TD>
                                        <?									}else{  ?>
										<TD align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;<? echo $count; ?></STRONG></FONT></TD>
                                        <?									}
								}
								else{
									if ($count<10){ ?>
										<TD align="center"  ><img src="../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>0<? echo $count; ?></STRONG></FONT></TD>
                                        <?									}else{ ?>
										<TD align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><? echo $count; ?></STRONG></FONT></TD>
                                        <?									}
								}
							} // fin for $count
					}	// fin if
					 if($cmbMes!=""){?>
						<TD align="center" ><img src="../../../../cortes/p.gif" width="20" height="1"><br>
						  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>A.M.</STRONG></FONT></TD>                    
							<TD ><img src="../../../../cortes/p.gif" width="20" height="8"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;</STRONG></FONT></TD>
						<? } ?>	
						</tr>
						</table>
						</div>		
						</td>
					</tr>
		</table>
	<div id="contenedor" onscroll="desplaza()" style="width:700px">
		<table width="100%" bordercolor="#666666" id="contenido" border="1">			
<?	

				
 					$ultima_fetch = $nroAno=trim($fila1['nro_ano'])."-".$mes."-".$diaFinal;	
					$primera_fech = $nroAno=trim($fila1['nro_ano'])."-".$mes."-"."01";
				$rut_existe[]="";
				$y=0;			
				for($i=0;$i<@pg_numrows($res);$i++)	
				{
				$fila = pg_fetch_array($res,$i);	
				if(in_array($fila[rut_emp],$rut_existe)){}else{
					$y++;
					$rut_existe[]=$fila[rut_emp]; 
											
					//trae todas las anotaciones
					$qry_atraso = "select fecha, id_anotacion from anotacion_empleado where rut_emp = '$fila[rut_emp]' and tipo = 1 and fecha >= '$primera_fech' and fecha <= '$ultima_fetch'";
					$res_atraso = @pg_Exec($qry_atraso);	
					$num_anota = @pg_numrows($res_atraso);
					?>					
					<tr onmouseover=this.style.background='yellow'; <? if($y%2==0){?>onmouseout=this.style.background="#FFFFFF" bgcolor="#FFFFFF"<? }else{?>onmouseout=this.style.background="#D7DAFD" bgcolor="#D7DAFD"<? }?>>					
						<td valign="top" width="300" class="textosesion"><?=$fila['ape_pat']." ".$fila['ape_mat'].", ".$fila['nombre_emp']?></td>						
					<?	for($count=1 ; $count<=$diaFinal ; $count++){														
						if($diaFinal==29 || $diaFinal==28){
							if ($count<10){ ?>											
								<?		$continua = true;									
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);										
										$cont="0".$count;										
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){ //de l hasta final de mes y estan activados?>
												<input type="checkbox" checked="checked" disabled="disabled">
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 10 hasta final de mes y estan desactivados ?>
												<input type="checkbox" disabled="disabled">
										<? }
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}?>											
								
									<?	}else{  ?> 
								<TD align="center">
							<?			$continua = true;									
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);						
									 	$cont = $count;
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){ //de 1 hasta final de mes y estan activados?>
												<input type="checkbox" checked="checked" disabled="disabled">
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 10 hasta final de mes y estan desactivados ?>
												<input type="checkbox" disabled="disabled">
										<? }
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}?>											 
								</TD>
								<?	}
							}else{
									if($count<10){ ?>
								<TD align="center">	
								<?		$continua = true;																	
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);										
										$cont="0".$count;										
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){  //del 01 al 09 y estan activados?>
												<font  class="textonegrita">X</font> 
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>">
										<?	}
										} 
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 01 al 09 y estan desactivados	?>
												<input type="checkbox" disabled="disabled">
										<? 	}
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}?>																			
								</TD>
									<? 	}else{ ?>																
								<TD align="center">
							<?			$continua = true;									
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);						
									 	$cont = $count;
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){ //del hasta final de mes y estan activados?>
												<font  class="textonegrita">X</font>
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 10 hasta final de mes y estan desactivados ?>
												<input type="checkbox" disabled="disabled">
										<? }
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>">
										<?	}										 
										}?>									 
								</TD>
									<?  } 
								}
							} 
							?>			
						<td align="center" class="textonegrita"><?=$num_anota?></td>
					</tr>
			<?	} }	?>
					<tr>
						<? if($cmbMes!=""){ ?>
						<td width="300">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>						
						<td colspan="<?=$diaFinal?>">&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<? } ?>
					</tr>											
		</table>
	</div>
</form>
</center>
				
					  
								  
								  
						 <!--AQUI TERMINA -->
						 
						 
						 </td>
						 
						 </tr></table>
						  </td>
                            <td height="395" align="left" valign="top"> 
                     
						    </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table>
<? pg_close($conn); ?>
</body>
</html>

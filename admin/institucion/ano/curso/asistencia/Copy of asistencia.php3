<?php 	require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;

	$fecha=getdate();
	$diaActual=$fecha["mday"];
	
?>
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

<html>
<head>
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">

<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">

<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php }?>

<?php //echo tope("../../../../../util/");?>
<form name="form1" method="post" action="procesoAsistencia.php3">
  <table width="64%" border="0" align="left" cellpadding="2" cellspacing="1">
    <tr>

    </tr>
    <tr> 
      <td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
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
              </strong> </FONT> </TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
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
              </strong> </FONT> </TD>
          </TR>
          <TR>
            <TD align=left><font size="2" face="Arial, Helvetica, sans-serif"><strong>CURSO
              </strong></font></TD>
            <TD><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></TD>
            <TD><strong><font size="2" face="Arial, Helvetica, sans-serif">
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
						
			&nbsp;</font></strong></TD>
          </TR>
        </TABLE>

        <table width="100%" border="0" cellpadding="5" cellspacing="5">
          <tr> 
            <td height="33" align="right"> 
			  <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Button3" value="VOLVER" onClick=document.location="seteaAsistencia.php3?caso=6">
            </td>
          </tr>
        </table>

        <table width="598" border="0">
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
            <td width="122">&nbsp;</td>

          </tr>
        </table>
        <table width="830" border="0" align="center" cellpadding="1" cellspacing="1">
          <tr> 
            <td width="17%" height="20" align="left" bordercolor="#0099CC" bgcolor="#003b85"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>INASISTENCIA</strong></font><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
              </font></td>
          </tr>

</table>
<table width="810" align="center" cellpadding="1" cellspacing="1">


<?php
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
			if($frmModo=="mostrar"){	
?>
		  
				<TR bgcolor=#30d1cc>
				<TD width=51 align=center><div align="center"><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000>ALUMNO</FONT>
		          </div></TD>
<?				for($count=1 ; $count<=$diaFinal ; $count++){
					if ($count<10){ ?>
						<TD align=center size=12><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000>0<? echo $count; ?></FONT></TD>
<?					}else{ ?>
						<TD align=center size=12><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><? echo $count; ?></FONT></TD>
<?					}
				}
				if($diaFinal==30){ ?>
						<!--TD align=center size=12>&nbsp;&nbsp;</TD-->
<?				}
				if($diaFinal==29){ ?>
						<TD align=center size=15>&nbsp;</TD>
<?				}
?>

				<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000>I.M.</FONT></TD>
<?			} //fin modo mostrar  
?>



        </table>

<!--iframe src="detalle_not.htm" width=415 height=250 name="interno"-->
		<iframe src="asistencia_curso.php?curso=<? echo $curso;?>&cmbMes=<? echo $cmbMes?>&nroAno=<? echo $nroAno?>" width=830 height=240 name="interno">
		</iframe>


      </td>
    </tr>
  </table>
</form>
</body>
</html>

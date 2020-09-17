<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 5;
	$_bot = 8;
	$rut=			$_POST["txtrut"];
	$grado= $_POST["cmb_grado"];
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
 <style type="text/css">
  
      .texto {
      
	  font:Arial, Helvetica, sans-serif;
	  font-size:11px;
      }
	    .titulo {
      
	  font:Arial, Helvetica, sans-serif;
	  font-size:15px;
      }
    
      h1 {
        font-family: Helvetica, Geneva, Arial, sans-serif;
      }
    </style>
	<style type="text/css">
@media print {
    div,a {display:none}
    .ver {display:block}
    .nover {display:none}
}
</style>
<script language="JavaScript" type="text/JavaScript">
<!--


function imprimir(num) 
{
	/*document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';*/
	
   // document.getElementById(num).className="ver";
    print();
    //document.getElementById(num).className="nover";
}
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


   function ver_confirm()
   {
	 document.form.action = "Rprt3.php";
     document.form.submit();
   }
function targetBlank () {
   window.open("pRprt3.php?grado=<?= $grado?>&ano=<?= $ano?>  ","ventana1","width=940,height=1020,scrollbars=YES") 
   }
   function enviapag(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt3.php';
		form.submit(true);
	}	
}
   
function abrir(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
     var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;
     var ventana = window.open(direccion,"venta",opciones,sustituir);

}   
//-->
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                        <?
						 $sql="select * from formulario_postulacion inner join alumno on formulario_postulacion.rut=alumno.rut_alumno where rut=".$rut;
						 $resp = pg_exec($conn,$sql);
						$fila = @pg_fetch_array($resp,0);
						 ?>
                      <td width="84%" align="left" valign="top">
                        <form name="form" method="post">
							<table width="794" border="0">
																					  <tr>
								<td align="left" class="texto">CORPORACION MUNICIPAL VALPARAISO<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AREA DE EDUCACION&nbsp;</td>
								
							    <td align="right">
								  <?
									$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
									$arr=@pg_fetch_array($result,0);
									$fila_foto = @pg_fetch_array($result,0);
									## c&oacute;digo para tomar la insignia
							
								  if($institucion!=""){
									   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
								  }else{
									   echo "<img src='".$d."menu/imag/logo.gif' >";
								  }?></td>
							    <td align="left">&nbsp;</td>
							  </tr>
							  <tr class="tableindex">
								<td colspan="3" align="center"><CENTER>FORMULARIO DE POSTULACION DE ENSEÑANZA MEDIA</CENTER></td>
								
							  </tr>
							  <tr class="texto">
								<td width="310" height="23">RUT</td>
								<td width="474"><?=$fila["rut"] ?>-<?=$fila["dig_rut"] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							  <tr class="texto">
							    <td>NOMBRES</td>
							    <td><?=$fila["nombres"]." ".$fila["ape_pat"]." ".$fila["ape_mat"] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						      </tr>
							  <tr class="texto">
							    <td>SEXO</td>
							    <td>
								<? 
									if($fila["sexo"]==1){
										echo "Hombre";
									}
									
									if($fila["sexo"]==2){
										echo "Mujer";
									}
								?>
								&nbsp;</td>
						      </tr>
							  <tr class="texto">
							    <td>ESTABLECIMIENTO PROCEDENCIA</td>
							    <td><?=$fila["establecimiento_proc"] ?></td>
						      </tr>
							  <tr>
							  <td>&nbsp;</td>
							  </tr>
							  <tr class="texto">
							  
							    <td colspan="2">PROMEDIO DE NOTAS 7&deg; A&Ntilde;O Y PROMEDIO GENERAL DE 8&deg;A&Ntilde;O (1&deg; y 2&deg; TRIMESTRE O 1&deg; SEMESTRE)</td>
						      </tr>
							  <tr class="texto">
							    <td height="28" colspan="2">7&deg; A&Ntilde;O:
                                  <input type="text" value="<? echo $fila["prom_7"] ?>" size="3">
8&deg; A&Ntilde;O:
<input type="text" value="<?=$fila["prom_8"] ?>" size="3">
PROMEDIO POSTULACION:
<input type="text" value="<?=$fila["prom_postu"] ?>" size="3"></td>
						      </tr>
							  <tr>
							    <td height="100" colspan="2">
								<table border="0">
                                  <tr>
                                    <td height="20" colspan="4" class="tableindex">Preferencia de la postulaci&oacute;n </td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" width="370">
									
									<table>
									<tr class="texto">
									<? 
									$sqlprefe1="select nombre_instit from institucion where rdb =".$fila["prefe_1"];
									$resp = pg_exec($conn,$sqlprefe1);
									$prefe1 = @pg_fetch_array($resp,0);
									
									$sqlprefe2="select nombre_instit from institucion where rdb =".$fila["prefe_2"];
									$resp2 = pg_exec($conn,$sqlprefe2);
									$prefe2 = @pg_fetch_array($resp2,0);
									
									$sqlprefe3="select nombre_instit from institucion where rdb =".$fila["prefe_3"];
									$resp3 = pg_exec($conn,$sqlprefe3);
									$prefe3 = @pg_fetch_array($resp3,0);
									
									
									$sqlprefe4="select nombre_instit from institucion where rdb =".$fila["prefe_4"];
									$resp4 = pg_exec($conn,$sqlprefe4);
									$prefe4 = @pg_fetch_array($resp4,0);
									
									
									$sqlprefe5="select nombre_instit from institucion where rdb =".$fila["prefe_4"];
									$resp5 = pg_exec($conn,$sqlprefe5);
									$prefe5 = @pg_fetch_array($resp5,0);
									?>
									<td><strong>1. </strong><?= $prefe1["nombre_instit"]; ?><br>
									  <strong>2.</strong><?= $prefe2["nombre_instit"]; ?><br>
									  <strong>3.</strong><?= $prefe3["nombre_instit"]; ?>
									<br>
									<strong>4.</strong><?= $prefe4["nombre_instit"]; ?><br>
									<strong>5.</strong><?= $prefe5["nombre_instit"]; ?><br></td>
									</tr>
									</table>
									</td>
                                    <td width="385">&nbsp;									</td>
                                  </tr>
                                  <tr class="texto">
                                    <td colspan="4">LOS ESTABLECIMIENTOS 1,5,8 y 10 EST&Aacute;N ADSCRITOS AL SISTEMA DE FINANCIAMIENTO COMPARTIDO </td>
                                  </tr>
                                  <tr class="texto">
                                    <td colspan="4">LOS ESTABLECIMIENTOS 2,3,4,6,7,9,10,11 Y 12 TIENEN JORNADA ESCOLAR COMPLETA</td>
                                  </tr>
                                  <tr>
                                    <td colspan="4">&nbsp;</td>
                                  </tr>
                                </table></td>
						      </tr>
							  <tr class="texto">
							    <td colspan="2" class="tableindex">DATOS PARA EL ESTABLECIMIENTO</td>
						      </tr>
							  <tr class="texto">
							    <td>FECHA NACIMIENTO:<?=$fila["fecha_nac"] ?></td>
						        <td>EDAD AL 31 DE MARZO DE 2009 :<?=$fila["edad_31mar"] ?></td>
							  </tr>
							  <tr class="texto">
							    <td>DOMICILIO PARTICULAR</td>
							    <td><?=$fila["calle"] ?></td>
						      </tr>
							  <tr class="texto">
							    <td>NÚMERO DOMICILIO </td>
							    <td><?=$fila["nro"] ?></td>
						      </tr>
							  <tr class="texto">
							    <td>SECTOR O CERRO</td>
							    <td><?=$fila["cerro"] ?></td>
						      </tr>
							  <tr class="texto">
							    <td>CIUDAD</td>
								<?   $qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila["region"]." and cor_pro= ".$fila["ciudad"];
		      						$resultPRO	=@pg_Exec($conn,$qryPRO);
									$filaPRO = @pg_fetch_array($resultPRO,0);
			      					?>
							    <td><?=$filaPRO['nom_pro'] ?></td>
						      </tr>
							  <tr class="texto">
							    <td>FONO-CELULAR-TELEFONO RECADOS</td>
							    <td><?=$fila["telefono"] ?></td>
						      </tr>
							  <tr class="texto">
							    <td>TIPO PROCEDENCIA</td>
							    <td>
								<? 
									if($fila["tipo_inst"]==1){
										echo "Municipal";
									}
									if($fila["id_procedencia"]==2){
										echo "Particular Suvencionado";
									}
									
									if($fila["id_procedencia"]==3){
										echo "Particular";
									}
								?>
								&nbsp;</td>
						      </tr>
							  <tr>
							    <td colspan="3">
								 <!----------------------------------------------COMPROBANTE-------------------------------------->
										  <table height="119">
										  <tr>
										  <td width="768" height="21" valign="top">-------------------------------------------------------------------------------------------------------------------------------</td>
										  </tr>
										  <tr class="texto">
										    <td height="21" valign="top"><div align='justify'>CORPORACION MUNICIPAL DE VALPARAISO<br>
										      PARA EL DESARROLLO SOCIAL</div></td>
										    </tr>
										  <tr>
										    <td height="21" valign="top" class="tableindex"><strong><center>COMPROBANTE DE INSCRIPCI&Oacute;N </center></strong></td>
										    </tr>
										  <tr class="texto">
										    <td height="21" valign="top">1) CEDULA DE IDENTIDAD 
										      <?=$fila["rut"] ?>
										      -
										      <?=$fila["dig_rut"] ?>
									        &nbsp;&nbsp;&nbsp;&nbsp;</td>
										    </tr>
											<td class="texto">2) NOMBRE COMPLETO DEL ALUMNO &nbsp;&nbsp;&nbsp;&nbsp;<?=$fila["nombres"]." ".$fila["ape_pat"]." ".$fila["ape_mat"] ?></td>
										    <tr class="texto">
										      <td>3) PREFERENCIA DE LA POSTULACI&Oacute;N </td>
									        <tr class="texto">
									          <td><strong>1. </strong><?= $prefe1["nombre_instit"]; ?><br>
									  <strong>2.</strong><?= $prefe2["nombre_instit"]; ?><br>
									  <strong>3.</strong><?= $prefe3["nombre_instit"]; ?>
									<br>
									<strong>4.</strong><?= $prefe4["nombre_instit"]; ?><br>
									<strong>5.</strong><?= $prefe5["nombre_instit"]; ?></td>
									        <tr class="texto">
									          <td>4) ESTABLECIMIENTO PROCEDENCIA&nbsp;&nbsp;&nbsp;&nbsp;<?=$fila["establecimiento_proc"] ?>&nbsp;</td>
								            <tr class="texto">
								              <td>________________________<br>
													NOMBRE Y FIRMA <br> 
													ENCARGADO RECEPCI&Oacute;N </td>
							                <tr>
									</table>
										  <!----------------------------------------------------------------------------------------------->
								</td>
						      </tr>
							  </div>
							  <tr>
							    <td colspan="3" align="center">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="left">
	  <td width="1%">&nbsp;	  	  </td>
	    <td align="right" >
          <strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2" color="#000099">ESTE REPORTE SE IMPRIME EN HOJA TAMA&Ntilde;O OFICIO </font></strong>		</td>
        <td align="right">
		<? if($institucion!=1971){?>
		<input name="button3" type="button" class="botonXX" onClick="imprimir('uno');"  value="IMPRIMIR"></td>
      	<? if($_PERFIL == 0){?>
		<td align="right">&nbsp;</td>
		<? }
		} ?>
	  </tr>
    </table></td>
						      </tr>
							</table>
                        </form></td>
                    </tr>	
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
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
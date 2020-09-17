<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 5;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../ut:dil/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--





function imprimir() 
{
	window.print();
}
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt4.php';
		form.submit(true);
	}	
}

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt4.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="imprimir()">  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="965" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                      <td align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
   <table>
   <tr>
   <td><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></td>
   <td>&nbsp;</td>
   </tr>
   <tr>
      <td width="70" align="left" ><font face="Arial, Helvetica, sans-serif" size="2">Institucion:</font></td>
								  <td width="153" align="left"><? 
								  $sql6="select nombre_instit from institucion where rdb=".$institucion;
									$resultinst= pg_exec($conn,$sql6);
		        					$filainst = @pg_fetch_array($resultinst,0); 
								  	echo $filainst["nombre_instit"];
								  ?>
                              &nbsp; </td>
                            </tr>
                                  <tr><td align="left">&nbsp;</td>
						            <td colspan="2" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="3">
									<table width="700">
									<tr class="tableindex" align="center">
									<td colspan="2"><center>TOTAL DE POSTULACIONES A UN ESTABLECIMIENTO POR ALUMNO</center></td>
									</tr>
									<tr>
									  <td width="239"><font face="Arial, Helvetica, sans-serif" size="2" >Nombre Establecimiento Destino:</font></td>
									  <td width="449"><font face="Arial, Helvetica, sans-serif" size="2">
									  <?
									$sql2="select nombre_instit from  institucion where rdb=".$_GET["cmb_insti"];
									$result= pg_exec($conn,$sql2);
		        					$fila = @pg_fetch_array($result,0); 
									echo $fila["nombre_instit"];
									?></font>
									  &nbsp;</td>
									</tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">Nivel:</font></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">
									 <? $sql3="select id_nivel from  curso where id_curso =".$_GET["cmb_grado"];
									$result2= pg_exec($conn,$sql3);
		        					$fila = @pg_fetch_array($result2,0); 
									
									$sql7="select * from niveles where id_nivel=".$fila["id_nivel"];
									$result4= pg_exec($conn,$sql7);
		        					$fila4 = @pg_fetch_array($result4,0); 
									echo $fila4["nombre"];
									?>
									</font>
									  &nbsp;</td>
									  </tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">A&ntilde;o:</font></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">
								<? $sql4="select nro_ano from  ano_escolar where id_ano =".$ano;
									$result3= pg_exec($conn,$sql4);
		        					$fila2 = @pg_fetch_array($result3,0); 
									echo $fila2["nro_ano"];
									?></font>
									  &nbsp;</td>
									  </tr>
									<tr>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  </tr>
									<tr class="tableindex">
									  <td colspan="3" align="center">ALUMNOS</td>
									  </tr>
									<? 
									$y=0;
									$sql5="select rut_alumno from postulaciones where id_curso =".$_GET["cmb_grado"];
									$result = pg_exec($conn,$sql5);
		  						  for($x=0 ; $x < @pg_numrows($result) ; $x++){
		        					$fila = @pg_fetch_array($result,$x);
									$sql6="select rut_alumno,nombre_alu,ape_pat,ape_mat from alumno where rut_alumno=".$fila["rut_alumno"];
									$resultalum = pg_exec($conn,$sql6);
									$fila2 = @pg_fetch_array($resultalum,0);
									$y++;
								  ?>
									<tr>  
										<td><font face="Arial, Helvetica, sans-serif" size="2"><?= $y?></font></td>
									  <td colspan="3">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"> <?= $fila2["nombre_alu"]." ".$fila2["ape_pat"]." ".$fila2["ape_mat"];?></font></td>
									  </tr>
									<? }?>
									<tr>
									  <td>&nbsp;</td>
									  </tr>
									<tr>
									  <td align="right"><font face="Arial, Helvetica, sans-serif" size="2">TOTAL&nbsp;</font></td>
									  <td>&nbsp;<?= $x?></td>
									  </tr>
									
									</table>
									
									
									 </td>
                                  </tr>
   </table>
                        </form>&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="24" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

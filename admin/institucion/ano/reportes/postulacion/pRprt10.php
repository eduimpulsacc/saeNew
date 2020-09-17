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
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
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

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt1.php';
		form.submit(true);
	}	
}

function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt10.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="imprimir()">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">&nbsp; 
					  </td>
                      <td width="73%" align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
                          <p><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></p>
                          <table width="798" height="138" border="0" cellspacing="0" cellpadding="0">
                            <tr>
							  
                              <td align="center">  
								  <?  $sqlniv="select * from niveles order by nombre asc"; 
						$result = @pg_Exec($conn,$sqlniv);
						  ?>
						  &nbsp;&nbsp;		<div align="right">
        </div></td>
							
							</tr>
                                <td align="center" valign="top">
		                          <table width="467" border="0" cellspacing="0">
                                    <tr>
                                      <td colspan="2" class="tableindex"><center>Selecci&oacute;n de Alumno por Nivel</center></td>                                    
                                    </tr>
                                    <tr>
                                      <td width="245" class="textosimple"><b>Nombre Establecimiento</b></td>
                                      <td width="206" class="textosimple">
									  <?
									$sql2="select nombre_instit from  institucion where rdb=".$institucion;
									$result= pg_exec($conn,$sql2);
		        					$fila = @pg_fetch_array($result,0); 
									echo $fila["nombre_instit"];
									?>
									  &nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td class="textosimple"><b>Nivel</b></td>
                                      <td class="textosimple">
									  <? 
									    $sqlniv2="select * from niveles where id_nivel= ".$_GET["cmb_grado"]; 
										$resultniv2=pg_exec($conn,$sqlniv2);
										$fila2 = @pg_fetch_array($resultniv2,0);
										echo $fila2["nombre"];
										
										?>
									  &nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td class="textosimple"><b>A&ntilde;o</b></td>
                                      <td class="textosimple">
									  
							<?
							$sqlano0="SELECT nro_ano from ano_escolar where id_ano = ".$ano;
							$resultano0= pg_exec($conn,$sqlano0);
							$filano0 = @pg_fetch_array($resultano0,0);
							echo $filano0["nro_ano"];
							?>
									  &nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr class="textosimple">
                                      <td>Alumnos</td>
                                      <td>Aceptado/ No Aceptado </td>
                                    </tr>
							<? 	$a=0;
								$n=0;
							 	$sqlacpt="select id_curso from curso where id_nivel=".$_GET["cmb_grado"]." and id_ano = ".$ano;
								$resultgr= pg_exec($conn,$sqlacpt);
								  for($x=0 ; $x < @pg_numrows($resultgr) ; $x++){
									$filagr = @pg_fetch_array($resultgr,$x);
										$sqlpos="select * from postulaciones where id_curso =".$filagr["id_curso"];
										$resultpos= pg_exec($conn,$sqlpos);
										
								  for($i=0 ; $i < @pg_numrows($resultpos) ; $i++){
										$filapos = @pg_fetch_array($resultpos,$i);
										
										//}
								if($filapos["rut_alumno"]!=null){
							?>
                                    <tr class="textosimple">
                                      <td>&nbsp;<?= $filapos["rut_alumno"];?></td>
                                      <td>&nbsp;<?
									  
									  if($filapos["estado"]>0){
									  		echo "A";
											$a++;
									  }else{
									  		echo "N";
											$n++;
									  }?></td>
                                    </tr>
                                    <? } 
										}
										}
									?>
									<tr>
									<td>&nbsp;</td>
									</tr>
									<tr class="textosimple">
                                      <td><b>Aceptados</b></td>
                                      <td><?= $a?>&nbsp;</td>
                                    </tr>
                                    <tr class="textosimple">
                                      <td><b>No Aceptados</b></td>
                                      <td><?= $n?>&nbsp;</td>
                                    </tr>
                                    <tr class="textosimple">
                                      <td><b>Total</b></td>
                                      <td>&nbsp;<?= $n+$a ?></td>
                                    </tr>
                                  </table>						
								</td>
                            <tr>
                              <td colspan="8">&nbsp;</td>
                            </tr>
							
                          </table>
                          <p>&nbsp;                          </p>
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

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
	//document.getElementById("capa0").style.display='none';
	window.print();
	//document.getElementById("capa0").style.display='block';
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
                    <td rowspan="6">&nbsp;</td>
                    
                  </tr>
                    <tr> 
                      <td width="73%" align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
                          <p><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></p>
                          <table width="798" height="138" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tableindex">
                              
                              <td width="739" align="CENTER">Instituci&oacute;n</td>
                            </tr>
                            <tr>
							  
                              <td align="center"><? $sqlinst="select nombre_instit from institucion where rdb=".$_GET["cmb_insti"];
													$resultinst= pg_exec($conn,$sqlinst);
													$filainst = @pg_fetch_array($resultinst,0);
													echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='3'> ".$filainst["nombre_instit"]."</font>";
													?></td>
							<?
							$sqlano0="SELECT nro_ano from ano_escolar where id_institucion=".$_GET["cmb_insti"]." order by id_ano desc";
							$resultano0= pg_exec($conn,$sqlano0);
							$filano0 = @pg_fetch_array($resultano0,0);
							?>
							</tr>
                                <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br><p><b>Año escolar:</b> <?= $filano0['nro_ano'];?>
                                  <br>
                                  <br>
                                </p></font>
                                  </td>
						    <tr>
							  <td height="36">
							  <table width="404" border="0" align="center" cellspacing="0">
							  
                                <tr>
                                  <td width="155" class="tableindex"><center><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Curso Nivel </font></center></td>
                                  <td width="239" height="26" class="tableindex"><center><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Cantidad Postulantes</font> </center></td>
                                </tr>
                                <?
							$sqlano="SELECT id_ano from ano_escolar where id_institucion=".$_GET["cmb_insti"]." order by id_ano desc";
							$resultano= pg_exec($conn,$sqlano);
							$filano = @pg_fetch_array($resultano,0);
							/*$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto,tipo_ensenanza.cod_tipo  ";
							$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
							$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$filano["id_ano"].")) $whe_perfil_curso";
							echo $sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso";*/
							$sql_curso="SELECT count(*) as cuenta,id_nivel FROM postulaciones INNER JOIN curso ON postulaciones.id_curso = curso.id_curso WHERE curso.id_ano=".$filano["id_ano"]." GROUP BY curso.id_nivel ORDER BY curso.id_nivel";
							$resultado_query_cue = pg_exec($conn,$sql_curso);
							
							for($z=0 ; $z < @pg_numrows($resultado_query_cue) ; $z++){
							   $fila2 = @pg_fetch_array($resultado_query_cue,$z);
							   	
								 $sql2="select * from niveles where id_nivel=".$fila2["id_nivel"];
							 	 $result2= @pg_Exec($conn,$sql2);
							   	$fila3 = @pg_fetch_array($result2,0);
							  ?>
                                <tr>
                                  <td><center><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fila3["nombre"] ?>&nbsp;</font></center></td>
                                  <td height="26" class="detalle"> <center><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fila2["cuenta"]; ?></font></center></td>
                                </tr>
                                <? } ?>
                              </table></td>
						    </tr>
                            <tr>
                              <td colspan="8">&nbsp;</td>
                            </tr>
							
                          </table>
                          <p>&nbsp;                          </p>
                        </form> </td>
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

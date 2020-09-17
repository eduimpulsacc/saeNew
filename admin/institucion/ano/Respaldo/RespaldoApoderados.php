<?php require('../../../../util/header.inc');?>
<?
	//---------------
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 0;
	//----------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];	
	//----------------
	$ls_string 		= ""		;
	$salto 			= "\n"		;
	$ls_espacio		= chr(9)	;
 	//---------------
	$fichero = fopen("Archivos/APODERADOS".$nro_ano.".xls", "w"); 
	//---------------
	$ls_string = $ls_string . "rut_apo"  . "$ls_espacio";
	$ls_string = $ls_string . "dig_rut"  . "$ls_espacio";
	$ls_string = $ls_string . "nombre_apo"  . "$ls_espacio";
	$ls_string = $ls_string . "ape_pat"  . "$ls_espacio";
	$ls_string = $ls_string . "ape_mat"  . "$ls_espacio";
	$ls_string = $ls_string . "calle"  . "$ls_espacio";
	$ls_string = $ls_string . "nro"  . "$ls_espacio";
	$ls_string = $ls_string . "depto"  . "$ls_espacio";
	$ls_string = $ls_string . "block"  . "$ls_espacio";
	$ls_string = $ls_string . "villa"  . "$ls_espacio";
	$ls_string = $ls_string . "region"  . "$ls_espacio";
	$ls_string = $ls_string . "ciudad"  . "$ls_espacio";
	$ls_string = $ls_string . "comuna"  . "$ls_espacio";
	$ls_string = $ls_string . "telefono"  . "$ls_espacio";
	$ls_string = $ls_string . "relacion"  . "$ls_espacio";
	$ls_string = $ls_string . "email"  . "$ls_espacio";
	$ls_string = $ls_string . "id_usuario"  . "$ls_espacio";
	$ls_string = $ls_string . "foto"  . "$ls_espacio";
	$ls_string = $ls_string . "celular"  . "$ls_espacio";
	$ls_string = $ls_string . "nivel_edu"  . "$ls_espacio";
	$ls_string = $ls_string . "profesion"  . "$ls_espacio";
	$ls_string = $ls_string . "lugar_trabajo"  . "$ls_espacio";
	$ls_string = $ls_string . "cargo"  . "$ls_espacio";
	$ls_string = $ls_string . "rut_apo"  . "$ls_espacio";
	$ls_string = $ls_string . "rut_alumno"  . "$ls_espacio";
	$ls_string = $ls_string . "responsable"  . "$ls_espacio";
	$ls_string = $ls_string . "sostenedor"  . "$salto";

	//---------------
	@ fwrite($fichero,"$ls_string"); 
	//---------------
	$sqlApo = "select apoderado.*, tiene2.* from apoderado, matricula, tiene2 ";
	$sqlApo = $sqlApo . "where matricula.id_ano = $ano ";
	$sqlApo = $sqlApo . "and   tiene2.rut_alumno = matricula.rut_alumno ";
	$sqlApo = $sqlApo . "and   apoderado.rut_apo = tiene2.rut_apo ";
	$sqlApo = $sqlApo . "order by apoderado.ape_pat, apoderado.ape_mat ";
	$rsApo =@pg_Exec($conn,$sqlApo);
	//---------------
	for($e=0 ; $e < @pg_numrows($rsApo) ; $e++)
	{	
		//---------------
		$fApo = @pg_fetch_array($rsApo,$e);
		//---------------
		$ls_string = trim($fApo['rut_apo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['dig_rut'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['nombre_apo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['ape_pat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['ape_mat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['calle'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['nro'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['depto'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['block'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['villa'])  . "$ls_espacio";
		
					$sqlRpc = "select reg.nom_reg,pro.nom_pro,com.nom_com 
			from region reg
				inner join provincia pro on (pro.cod_reg = reg.cod_reg) AND (pro.cor_pro = ".trim($fApo['ciudad']).")
				inner join comuna com on (com.cod_reg = reg.cod_reg)  AND (com.cor_pro =pro.cor_pro) AND (com.cor_com = ".trim($fApo['comuna']).")
				where reg.cod_reg = ".trim($fApo['region'])."";
	        $rsRpc =@pg_Exec($conn,$sqlRpc);
			$fRpc = @pg_fetch_array($rsRpc,0);

		$ls_string = $ls_string . trim($fRpc['nom_reg'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fRpc['nom_pro'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fRpc['nom_com'])  . "$ls_espacio";

		$ls_string = $ls_string . trim($fApo['telefono'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['relacion'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['email'])  . "$ls_espacio";

		$ls_string = $ls_string . trim($fApo['foto'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['celular'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['nivel_edu'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['profesion'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['lugar_trabajo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['cargo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['rut_apo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['rut_alumno'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['responsable'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['sostenedor'])  . "$salto";

		//---------------
		@ fwrite($fichero,"$ls_string"); 
		//---------------
	}
	//---------------	
	fclose($fichero); 
	//---------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
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
                                  <td><br>

								   <!-- INSERTAMOS CODIGO NUEVO -->
							 
							     <center>
  <table width="90%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="71">
        <div align="right">
          <INPUT class = "botonXX" TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="../Menu_Respaldo.php">
      </div></td>
    </tr>
    <tr>
      <td>
	      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableindex">
            <tr>             
            <td><div align="center">Respaldo de Informaci&oacute;n desde Colegio Interactivo </div></td>
           </tr>
          </table>
	  
        </td>
    </tr>
    <tr>
      <td>        <div align="center">
          <p>&nbsp;</p>
          <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo Apoderados del Colegio </font></strong></p>
          <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El archivo ha sido creado con el nombre de <a href='Archivos/APODERADOS<? echo $nro_ano?>.xls'> &quot;APODERADOS<? echo $nro_ano?>.xls&quot;</a> <br>
          </strong></font></p><br>
      </div></td>
    </tr>
    <tr>
      <td>
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para guardar el archivo en su PC Solo debe clickear con el boton derecho sobre el Link que esta en el nombre del archivo y elegir la opcion &quot;<strong>guardar destino como</strong>&quot; (Save Target As)</font></div></td>
    </tr>
  </table>
</center>
							 
							 	   <!-- FIN DE INGRESO DE CODIGO NUEVO --> 
								   </td>
								 </tr>
							 </table>	
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php");?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close ($conn);?>
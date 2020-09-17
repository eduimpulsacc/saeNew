<?php require('../../../../util/header.inc');
$_POSP = 4;
$_bot = 7;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
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
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 include("../../../../menus/menu_lateral.php");
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
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  <?
							   //$Modo	=$_FRMMODO;
$institucion	=$_INSTIT;
$eliminar=$_GET[eliminar];
//$eliminar=$hiddenPlantilla;
$plantilla=$hiddenPlantilla;
	
	if($pa)		$pa=1; else $pa=0;
	if($sa)		$sa=1; else	$sa=0;	
	if($ta)		$ta=1; else	$ta=0;	
	if($cu)		$cu=1; else	$cu=0;	
	if($qu)		$qu=1; else	$qu=0;	
	if($sx)		$sx=1; else	$sx=0;	
	if($sp)		$sp=1; else	$sp=0;	
	if($oc)		$oc=1; else	$oc=0;
	
	//quitar de la session algun id_plantilla anterior
	if(session_is_registered('_PLANTILLA')){
		session_unregister('_PLANTILLA');
	};
	
	$fechaCreacion = date("d-m-Y H:i:s");
	
if($Modo=="modificar"){
	for($i=0;$i<$CantArea;$i++){
		$SQLAREA ="UPDATE informe_area SET nombre='" . $NomArea[$i] . "' WHERE id_area=" . $IdArea[$i];
		$SQLSUBAREA = "UPDATE informe_subarea SET nombre='" . $NomSubArea[$i] ."' WHERE id_subarea= " . $IdSubArea[$i];
		$ResultArea = @pg_exec($conn, $SQLAREA);
		$ResultSubArea = @pg_exec($conn, $SQLSUBAREA);
		
	}
	for($j=1;$j<=$CantItem;$j++){
		$SQLITEM = "UPDATE informe_item SET glosa = '" . $NomItem[$j] ."' WHERE id_item = " . $IdItem[$j];
		$ResultItem = @pg_exec($conn, $SQLITEM);
		
	}

	if ((!$ResultArea) and (!$ResultSubArea) and (!$ResultItem)){
		error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$SQLAREA."<br>".$SQLSUBAREA."<br>".$SQLITEM);
		exit;
	}
	echo "<script>window.location = 'seteaPlantilla.php?caso=1' </script>";
}else{
	if($eliminar!=1){
		//crea la plantilla
//		 $sqlCrea="insert into informe_plantilla (rdb, nombre, tipo_ensenanza, fecha_creacion, pa, sa, ta, cu, qu, sx, sp, oc) values(".$institucion.", '".$txtNombrePla."', ".$cmbEns.", to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.")";

		if(trim($txtNombreTitulo1)=='' || trim($txtNombreTitulo1)==NULL){
			$titulo1 = "Informe Educacional";
		}
		else{
			$titulo1 = $txtNombreTitulo1;
		}
		if(trim($txtNombreTitulo2)=='' || trim($txtNombreTitulo2)==NULL){
			$titulo2 = "INFORME DE DESARROLLO PERSONAL Y SOCIAL";
		}
		else{
			$titulo2 = $txtNombreTitulo2;
		}

		$sqlCrea="insert into informe_plantilla (rdb, nombre, tipo_ensenanza, fecha_creacion, pa, sa, ta, cu, qu, sx, sp, oc, titulo_informe1, titulo_informe2) values(".$institucion.", '".$txtNombrePla."', ".$cmbEns.", to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.",'".$titulo1."','".$titulo2."')";
		$resultCrea=pg_Exec($conn, $sqlCrea);
			if (!$resultCrea){
				echo "error 50";//error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlCrea);
			}else{
				//trae el id ded la ultima plantilla para registrarlo en la session
				$sqlTraeId="select max (id_plantilla) as id_plantilla from informe_plantilla where rdb=".$institucion;
				$resultTraeId=pg_Exec($conn, $sqlTraeId);
					if (!$resultTraeId)
						echo "error 56";//error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
					else{
						$filaTraeId=pg_fetch_array($resultTraeId,0);
						$_PLANTILLA=$filaTraeId['id_plantilla'];
				
						//registra el id de la ultima plantilla en la session, la q recien se grabó
						if(!session_is_registered('_PLANTILLA')){
								session_register('_PLANTILLA');
						};
					//inserto en plantillaGrado
					/*$sqlInsGrados="INSERT INTO informe_plantillagrado (id_plantilla, pa, sa, ta, cu, qu, sx, sp, oc) VALUES (".$_PLANTILLA.",".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.")";
					$resultGrados=pg_Exec($conn, $sqlInsGrados);
					if (!$resultGrados)
						error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlInsGrados);*/
					
					}//fin if (!$resultTraeId)
			}//fin if (!$resultCrea)
			echo "<script>parent.location='plantilla.php'</script>";
		}else//fin if($eliminar!=1)
		
		if($eliminar==1){
		$sqlElimina="update informe_plantilla set activa=0 where id_plantilla=".$plantilla;
		$resultElimina=pg_exec($conn, $sqlElimina);
			if (!$resultElimina) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlElimina);
			}

		
		
		echo "<script>parent.location='listaPlantillas.php'</script>";
		}//fin if($eliminar==1)
			
			/*echo "<script>window.location='creaPlantilla.php?creada=1&plantilla=".$_PLANTILLA."'</script>";*/

}// fin If MODO		
?>	
							
							
							
							  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

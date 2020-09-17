<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'acepta.php';
		form.submit(true);
	}	
}
//-->
</script>

		<?php include('../../util/rpc.php3');?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  
					  <form name="form1" method="post" action="guardaacepta.php">
					  <table width="673" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td colspan="4" class="tableindex"><font face="Arial, Helvetica, sans-serif" size="3"><center>Acepta Postulaci&oacute;n </center></b></font></td>
                        </tr>

                        <tr>
                          <td colspan="3">
						  <table width="671" border="0">
						    <tr>
						  <td width="329" height="19" class="textosimple">Niveles</td>
						  <td width="326" class="textosimple"><?  $sqlniv="select * from niveles where tipo_ense=310 order by nombre asc"; 
						$result = @pg_Exec($conn,$sqlniv);
						  ?>
						  &nbsp;<select name="cmb_grado" class="ddlb_x" onChange="enviacmb(this.form);">
                                        <option value=0 selected>(Seleccione un Nivel)</option>
                                        <?
		    for($x=0 ; $x < @pg_numrows($result) ; $x++)
		        {  
		        $fila = @pg_fetch_array($result,$x); 
		        
		        if (($fila['id_nivel'] == $_REQUEST["cmb_grado"]) or ($fila['id_nivel'] == $_REQUEST["cmb_grado"])){
		           echo "<option value=".$fila['id_nivel']." selected>".$fila['nombre']." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_nivel'].">".$fila['nombre']." </option>";
                }
		     } ?>
                                      </select>&nbsp;</td>
						  </tr>
						  <tr>
						    <td height="19" class="textosimple">&nbsp;</td>
						    <td class="textosimple">&nbsp;</td>
						    </tr>
						  <tr>
						    <td height="19" class="textosimple">Alumnos</td>
						    <td class="textosimple">Aceptar</td>
						    </tr>
						<?
				 //$sql="SELECT postulaciones.id_curso,id_nivel,postulaciones.rut_alumno,postulaciones.estado FROM postulaciones INNER JOIN curso on postulaciones.id_curso=curso.id_curso where curso.id_ano=$ano and curso.id_nivel=".$_REQUEST["cmb_grado"]." order by grado desc";
				echo $sqlgrado="select grado_curso from curso where curso.id_nivel=".$_REQUEST["cmb_grado"]." limit 1";
				$resultgrado = @pg_Exec($conn,$sqlgrado);
				$filagrado = @pg_fetch_array($resultgrado,0);
				
				
				echo "<br>".$sqlprefe="select * from formulario_postulacion where grado=".$filagrado["grado_curso"];
				//$resultprefe = @pg_Exec($conn,$sqlprefe);
				//$filaprefe = @pg_fetch_array($resultprefe,0);
				
				//$sql="select * from formulario_postulacion inner join alumno on formulario_postulacion.rut=alumno.rut_alumno where grado=".$filagrado["grado_curso"]." and prefe_".$filaprefe["preferencia"]." = ".$institucion." order by ape_pat desc";
				//$result = @pg_Exec($conn,$sql);
				$result = @pg_Exec($conn,$sqlprefe);
				echo "<input type='hidden' value='".@pg_numrows($result)."' name='num_fila'>";
				for($i=0;$i < @pg_numrows($result);$i++){
					$filaprefe = @pg_fetch_array($result,$i);
					echo "<br>".$sql="select * from formulario_postulacion inner join alumno on formulario_postulacion.rut=alumno.rut_alumno where  prefe_".$filaprefe["preferencia"]." = ".$institucion." and grado=".$filagrado["grado_curso"]." and rut_alumno=".$filaprefe["rut"]." and (id_estado = 0 Or id_estado =2) order by ape_pat desc";
					$result2 = @pg_Exec($conn,$sql);
					$fila = @pg_fetch_array($result2,0);
					if($fila["rut_alumno"]!=null){
					?>
						  <tr>
						    <td height="19" class="textosimple">
					<? echo $fila["nombre_alu"]." ".$fila["ape_pat"];?>&nbsp;</td>
					
					<input type="hidden" value="<? $ano?>" name="id_ano">
					<input type="hidden" value="<?= $_REQUEST["cmb_grado"]?>" name="ano">
					<input type="hidden" value="<?= $fila["rut_alumno"];?>" name="rut_<?= $i?>">
						    <td class="textosimple">
							<? if($fila["id_estado"]==2){?>
							<input name="chk_acepta_<?= $i?>" type="checkbox" value="1">
							<? }else{ ?>
							<input name="chk_acepta_<?= $i?>" type="checkbox" value="1" checked>
							<? }?>
							</td>
						    </tr>
					
				<? }
				}
				?>
						  <tr>
						    <td class="textosimple" colspan="2">&nbsp;</td>
						    </tr>
						  <tr>
						    <td class="textosimple" colspan="2" align="center"><input type="submit" name="Submit" value="Guardar" class="botonxx"></td>
						    </tr>
						  </table>
						   </td>
                        </tr>	
                      </table>
					  </form>
					  </td>
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

<?php 
require('../util/header.inc');
require('../util/funciones_new.php'); 

	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP = 1;
	//-------------------------------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$nro_ano=$fila['nro_ano'];


	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'LISTADO DE PROFESORES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
	


	$sqlProfesores = "select matricula.rut_alumno, ramo.id_ramo, subsector.nombre, ramo.cod_subsector, ramo.modo_eval, empleado.rut_emp, empleado.dig_rut, empleado.ape_pat, empleado.ape_mat,empleado.nombre_emp,empleado.nom_foto2 ";
	$sqlProfesores.= "from matricula, ramo, subsector, dicta, empleado, tiene$nro_ano ";
	$sqlProfesores.= "where matricula.rut_alumno = ".$alumno." and matricula.id_ano = ".$ano." ";
	$sqlProfesores.= "and ramo.id_curso = matricula.id_curso ";
	$sqlProfesores.= "and subsector.cod_subsector = ramo.cod_subsector ";
	$sqlProfesores.= "and dicta.id_ramo = ramo.id_ramo ";
	$sqlProfesores.= "and empleado.rut_emp = dicta.rut_emp " ;
	$sqlProfesores.= "and tiene$nro_ano.id_curso = matricula.id_curso and tiene$nro_ano.rut_alumno = matricula.rut_alumno and tiene$nro_ano.id_ramo = ramo.id_ramo ";
	$sqlProfesores;
	$rsProfesores =@pg_Exec($conn,$sqlProfesores);	
	
	//-------------------------------
?>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
<center>

<table width="650" border="0" cellspacing="1" cellpadding="3">
  <TR height=20 class="tableindex">
    <TD align="center" colspan=5> LISTADO DE PROFESORES </TD>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr class="tablatit2-1">
    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE PROFESOR </strong></font></td>
    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>SUBSECTOR QUE IMPARTE </strong></font></td>
    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>FOTO</strong></font></td>
  </tr>
  <?
	for($i=0 ; $i < @pg_numrows($rsProfesores) ; $i++){
		$fProfesores = @pg_fetch_array($rsProfesores,$i); 
		$rut_profe = trim($fProfesores['rut_emp'])."-". trim($fProfesores['dig_rut']);
		$rut_profe2 = trim($fProfesores['rut_emp']);
		$prof_jefe = trim($fProfesores['supervisor']);
		$foto = trim($fProfesores['nom_foto2']);
		$jefe = '';
		if($rut_profe2==$prof_jefe)
		{
			$jefe = "(Profesor Jefe)";
			$cont++;
		}
		
		$nombre = ucwords(strtolower(trim($fProfesores['ape_pat'])." ".trim($fProfesores['ape_mat'])." ".trim($fProfesores['nombre_emp'])));
		$subsector = trim($fProfesores['nombre']);
  ?>  
  
  <? if ($_INSTIT==9035){ ?>
  
<? if($cont=="")
	{
	$sqljefe = "select ape_pat, ape_mat, nombre_emp from empleado where rut_emp = '$prof_jefe'";
	$sqlres = @pg_Exec($sqljefe);
	$fila_jefe = @pg_fetch_array($sqlres);
	$fila_jefe['nombre_emp'];	
	$nombre = ucwords(strtolower(trim($fila_jefe['ape_pat'])." ".trim($fila_jefe['ape_mat'])." ".trim($fila_jefe['nombre_emp'])));
	$prof_jefe;
?> <!-- Funcion para Colegio El Carmen Teresiano II NO sacar para este colegio-->
 
  <!-- 	fin -->
<?	}
}

	?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('DetalleProfesor.php?rut_profe=<?php echo $rut_profe2;?>')>
    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $nombre."&nbsp;&nbsp;&nbsp;".$jefe;?></strong></font></td>
    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $subsector;?></strong></font></td>
    <td align="center">
    <?
	
	
   //$foto="Roberto Reyes.jpg";
	if($foto){
   ?> 
	<img src="../tmp/<?php echo $foto?>" width=48 height="70">
	<?
	}else{
		
		?>
										    <img src="/fichas/icono_profesores.png" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="48" height="70" id="ALUMNO">
											<?	}?>
	 
	</td>
    
   
    
   
  </tr>
  <? } ?>
  
  
  
</table>

</center>

								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                            
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

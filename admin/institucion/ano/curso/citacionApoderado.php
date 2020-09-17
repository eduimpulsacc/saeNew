<?php 
require('../../../../util/header.inc');
require('../../../../util/funciones_new.php'); 

	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$usuario		=$_NOMBREUSUARIO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =4;
	//-------------------------------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$nro_ano=$fila['nro_ano'];

//var_dump($_SESSION);

	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'CITACIONES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//


	$sqlProfesores = "select matricula.rut_alumno, ramo.id_ramo, subsector.nombre, ramo.cod_subsector, ramo.modo_eval, empleado.rut_emp, empleado.dig_rut, empleado.ape_pat, empleado.ape_mat,empleado.nombre_emp,supervisa.rut_emp as supervisor ";
	$sqlProfesores = $sqlProfesores . "from matricula, ramo, subsector, dicta, empleado, tiene$nro_ano, supervisa ";
	$sqlProfesores = $sqlProfesores . "where matricula.rut_alumno = ".$alumno." and matricula.id_ano = ".$ano." ";
	$sqlProfesores = $sqlProfesores . "and ramo.id_curso = matricula.id_curso and ramo.id_curso = supervisa.id_curso ";
	$sqlProfesores = $sqlProfesores . "and subsector.cod_subsector = ramo.cod_subsector ";
	$sqlProfesores = $sqlProfesores . "and dicta.id_ramo = ramo.id_ramo ";
	$sqlProfesores = $sqlProfesores . "and empleado.rut_emp = dicta.rut_emp " ;
	$sqlProfesores = $sqlProfesores . "and tiene$nro_ano.id_curso = matricula.id_curso and tiene$nro_ano.rut_alumno = matricula.rut_alumno and tiene$nro_ano.id_ramo = ramo.id_ramo ";
	$rsProfesores =@pg_Exec($conn,$sqlProfesores);	
	
	//-------------------------------
?>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../Sea/cortes/b_ayuda_r.jpg','../../../../Sea/cortes/b_info_r.jpg','../../../../Sea/cortes/b_mapa_r.jpg','../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
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
    <TD align="center" colspan=3> CITACIONES </TD>
	</TR>
	
</table>
<table width="609" border="0" align="center">
               
               
               
               <tr>
                 <td width="103" align="center" class="textosimple"><b> Nombre Alumno&nbsp;</b></td>
                 <td width="168" class="textosimple"><div align="center"><b>Fecha&nbsp;</b></div></td>
                 <td align="center" class="textosimple" colspan="6"><b>Observacion&nbsp;</b></td>
                 <td align="center" class="textosimple" colspan="6">&nbsp;</td>
               </tr>
               <?   /*$sql_cita="select * from citacion 
			   left join citacion_asunto asu on asu.id_asunto = c.id_asunto
			   INNER JOIN tiene2 ON (citacion_apo.rut_alumno=tiene2.rut_alumno) 
			   where tiene2.rut_apoderado=".$usuario;*/
			   
			   /*  $sql_cita="select a.id_asistencia, c.id_citacion, c.fecha, c.hora, c.id_asunto,c.motivo,
				a.estado, a.rut_apo,a.id_curso, asu.asunto,tiene2.rut_alumno
				from citacion c inner join citacion_asistencia a on c.id_citacion=a.id_citacion 
				left join citacion_asunto asu on asu.id_asunto = c.id_asunto 
				INNER JOIN tiene2 ON (a.rut_apo=tiene2.rut_apo) 
				left join apoderado ap on ap.rut_apo = a.rut_apo 
				inner join matricula m on m.rut_alumno = tiene2.rut_alumno
				where c.id_ano = $_ANO and a.rut_apo=$_NOMBREUSUARIO
				 and m.id_curso = $_CURSO";*/
				  $sql_cita = "select distinct(a.id_asistencia), c.id_citacion, c.fecha, c.hora, c.id_asunto,c.motivo,
a.estado, a.rut_apo,a.id_curso, asu.asunto, t.rut_alumno
from citacion c inner join citacion_asistencia a 
on c.id_citacion=a.id_citacion and a.id_curso = $_CURSO
INNER JOIN matricula m ON m.id_curso=a.id_curso
inner join citacion_asunto asu on asu.id_asunto = c.id_asunto 
left join tiene2 t on t.rut_apo = a.rut_apo AND m.rut_alumno=t.rut_alumno
where c.id_ano = $_ANO and a.rut_apo=$_NOMBREUSUARIO and t.rut_alumno is not null";
			   
					
				$sql_cita.=" ORDER BY c.fecha,a.id_asistencia ASC";
				
				//echo $sql_cita;
			   
			   
			  	$result_cita =@pg_Exec($conn,$sql_cita);
				 for($i=0 ; $i < @pg_numrows($result_cita) ; $i++)
		      		{  
		       $fila_cita = @pg_fetch_array($result_cita,$i);
			   
			    $sql_alum="select nombre_alu, ape_pat, ape_mat from alumno where rut_alumno=".$fila_cita["rut_alumno"];
			  	$result_alum =@pg_Exec($conn,$sql_alum);
				$fila_alum = @pg_fetch_array($result_alum,0);
			   
			  ?>
               <tr class="textosimple">
                 <td align="center"><? echo $fila_alum['nombre_alu']." ".$fila_alum['ape_pat']." ".$fila_alum['ape_mat'];?></td>
                 <td align="center"><? echo $fila_cita["fecha"]?></td>
                 <td align="center" colspan="6"><? echo $fila_cita["motivo"]?></td>
				 <td>
				 <? if($elimina==1){?>
				 <input type="button" name="eliminar" value="Eliminar" class="botonxx" onClick="valida_elimina('<?php echo $cmb_acti?>','<?= $fila_cita["id_citacion"]?>')">
				 <? } ?>
				 </td>
               </tr>
               <? }?>
             </table>

</center>

								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2006 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

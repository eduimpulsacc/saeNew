<?php 
require('../util/header.inc');
require('../util/funciones_new.php'); 

	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =1;
	//-------------------------------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$nro_ano=$fila['nro_ano'];

	$sql="SELECT nombre_alu ||' '|| ape_pat ||' '|| ape_mat AS nombre FROM alumno WHERE rut_alumno=".$alumno;
	$rs_alumno = pg_exec($conn,$sql);
	$nombre_alumno = pg_result($rs_alumno,0);
	
	$sql="SELECT nombre_emp ||' '|| ape_pat||' '|| ape_mat as nombre FROM empleado e INNER JOIN supervisa s ON e.rut_emp=s.rut_emp WHERE id_curso=".$curso;
	$rs_empleado = pg_exec($conn,$sql);
	$nombre_profesor = pg_result($rs_empleado,0);
	
	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'LISTADO DE PROFESORES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
?>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../menu_new/css/styles.css">
<link rel="stylesheet" type="text/css" href="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script type="text/javascript" src="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="50" height="" rowspan="3" background="../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" height="50" valign="top"><? include("../cabecera_new/head_sae.php"); ?></td>
    <td width="50" rowspan="3" background="../cortes/<?=$institucion;?>/fomdo_02_reca.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="25%" width="%"> <? include("../menu_new/menu_alu_apo.php"); ?></td>
    <td valign="top" height="50%" ><br>

    <table width="95%" border="0" class="cajaborde" align="center">
  <tr>
    <td>
       <div id="fdo_tabla">
<h2 class="titulo_new">Listado del Curso</h2>
<div class="datagrid">
<table>
<thead>
<tr>
  <th width="170">Curso</th><th colspan="2"><? echo CursoPalabra($curso,0,$conn);?></th></tr>
<tr>
  <th width="170">Profesor Jefe</th>
  <th colspan="2"><?=$nombre_profesor;?></th></tr>
  <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  
   <tr>
  <th width="170">Número de Lista</th>
  <th width="390">Nombre</th>
  <th width="100" align="center">Foto</th>
  </tr>

</thead>
 <? 	$sql="SELECT a.rut_alumno,nro_lista,nombre_alu ||' '|| ape_pat||' '|| ape_mat as alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." ORDER BY nro_lista ASC";
	  		$rs_curso = pg_exec($conn,$sql);
			for($i=0;$i<pg_numrows($rs_curso);$i++){
				$fila = pg_fetch_array($rs_curso,$i);
?>

<tr>
  <td width="170" height="80" align="center"><?=$fila['nro_lista'];?></td>
  <td width="390" height="80"><?=$fila['alumno'];?></td>
  <td width="100" height="80" align="center"><? if(file_exists("../infousuario/images/".$fila['rut_alumno']."")){?>
            
            <img src="../infousuario/images/<?php echo $fila['rut_alumno']?>"  width=100 height="100">
            <? }else{ ?>
            <img src="apoderado/imag/alumno222.jpg"  name="ALUMNO" width="100" height="100" id="ALUMNO">
            <? } ?></td></tr>
<? } ?>
</table>
</div>

<table width="600" border="0" cellspacing="0" cellpadding=" 0">
  <tr>
    <td width="885"><img src="../cortes/10774/sombra.png" width="600" height="32" /></td>
  </tr>
</table>

</td></tr></table>
    


    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="89">&nbsp;<img src="../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>

</body>
</html>

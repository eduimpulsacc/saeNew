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
	
			
			
			$sql_prom="select cu.grado_curso ||' - '|| cu.letra_curso ||' '|| te.nombre_tipo as curso, 
						an.nro_ano,cu.ensenanza, 
						CASE WHEN pr.promedio IS NULL THEN (SELECT avg(CAST(n.promedio as INTEGER)) 
						FROM notas$nro_ano n 
						where n.rut_alumno=".$alumno."  and n.promedio not in ('MB','B','I','S','')) 
						ELSE pr.promedio END as promedio 
						from promocion pr 
						inner join ano_escolar an on pr.id_ano=an.id_ano 
						inner join curso cu on pr.id_curso=cu.id_curso 
						inner join tipo_ensenanza te on cu.ensenanza=te.cod_tipo 
						where pr.rut_alumno= ".$alumno." and cu.ensenanza > 309 
						union
						SELECT cn.curso ||' - '|| letra as curso, ano as nro_ano, 310, cn.promedio
						FROM concentracion_notas cn 
						INNER JOIN nem_notas nn ON cn.promedio=nn.nota AND cn.curso in(1,2,3)
						WHERE cn.rut_alumno=".$alumno."  and nn.tipo_ense=310
						order by nro_ano asc ";	
				
				$rsProm=@pg_Exec($conn,$sql_prom);		


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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="50" height="" rowspan="3" background="../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" height="50" valign="top"><? include("../cabecera_new/head_sae.php"); ?></td>
    <td width="50" rowspan="3" background="../cortes/<?=$institucion;?>/fomdo_02_reca.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="50%" width="%"> <? include("../menu_new/menu_alu_apo.php"); ?></td>
    <td valign="top" height="50%" ><br>

    <table width="95%" border="0" class="cajaborde" align="center">
  <tr>
    <td>&nbsp;<br>

    <table width="650" border="0" cellspacing="1" cellpadding="3" align="center">
      <TR height=20 class="tableindex" align="center">
        <TD align="center" colspan=3> INFORME NEM </TD>
       </TR>
       
    </table><br>

<table align="center" width="650" border="0"  cellspacing="1" cellpadding="3" class="cajaborde">
  <tr class="tableindexredondo">
   <td align="center" class="tableindexredondo">AÑO ESCOLAR</td>
   <td align="center" class="tableindexredondo">CURSO </td>
   <td align="center" class="tableindexredondo">PROMEDIO</td>
   <td align="center" class="tableindexredondo">NOTA NEM </td>
   
   
   <?
   
   for($i=0 ; $i < @pg_numrows($rsProm) ; $i++){
		$fila = @pg_fetch_array($rsProm,$i); 
	  	$promedio = round($fila['promedio']);
		
		?>
 <tr class="textosimple" align="center">
 <td>&nbsp;<?=$fila['nro_ano']?></td>
 <td>&nbsp;<?=$fila['curso']?></td>
 <td>&nbsp;<?=$promedio?></td>
 <td >
 <?
 	$sql_nm = "select ps from nem_notas where nota=$promedio and tipo_ense=".$fila['ensenanza'];
	$rsmn=@pg_Exec($conn,$sql_nm);
	$pr = pg_result($rsmn,0);
	
	echo $pr;
 ?>
 </td>
 </tr>
  <? } ?>
</table>
<br>

    </td>
  </tr>
</table><br>


    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="89">&nbsp;<img src="../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>

</body>
</html>

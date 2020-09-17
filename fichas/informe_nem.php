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
	
	/*if($fila['situacion']==1){
		
		echo "Año Abierto";
		}else{
		
		echo "Año Cerrado";	
			
			}*/
			
			
			
	/*$sql_prom="select cu.grado_curso ||' - '|| cu.letra_curso ||' '|| te.nombre_tipo as curso, an.nro_ano,cu.ensenanza,
				CASE WHEN pr.promedio IS NULL THEN  (SELECT avg(CAST(n.promedio as INTEGER))  FROM notas$nro_ano n 
				where n.rut_alumno=".$alumno." 
				and n.promedio not in ('MB','B','I','S',''))
				ELSE pr.promedio END as promedio
				from promocion pr  
				inner join ano_escolar an on pr.id_ano=an.id_ano
				inner join curso cu on pr.id_curso=cu.id_curso
				inner join tipo_ensenanza te on cu.ensenanza=te.cod_tipo
				where pr.rut_alumno= ".$alumno." and cu.ensenanza > 309 order by cu.grado_curso asc";	*/
				
		$sql_prom="select cu.grado_curso ||' - '|| cu.letra_curso ||' '|| te.nombre_tipo as curso, an.nro_ano,cu.ensenanza, 
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
                <td height="83" colspan="3"><table width="%" height="%" border="0" cellpadding="0" cellspacing="0" >
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
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
    <TD align="center" colspan=3> INIFORME NEM </TD>
   </TR>
   
</table>

<table align="center" width="650" border="1" style="border-collapse:collapse" cellspacing="1" cellpadding="3">
  <tr class="tablatit2-1">
   <td align="center">AÑO ESCOLAR</td>
   <td align="center">CURSO </td>
   <td align="center">PROMEDIO</td>
   <td align="center">NOTA NEM </td>
   
   
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
 	/*if($promedio>=10 and $promedio <=49){
		
	$promedio=393;	
	}else if($promedio>=50 and $promedio<=54){
		$promedio=496;
		
	}else if($promedio>=55 and $promedio<=59){
		$promedio=599;
		
	}else if($promedio>=60 and $promedio<=64){
		$promedio=702;
		
	}else if($promedio>=65 and $promedio<=70){
		$promedio=826;
	}*/
	$sql_nm = "select ps from nem_notas where nota=$promedio and tipo_ense=".$fila['ensenanza'];
	$rsmn=@pg_Exec($conn,$sql_nm);
	$pr = pg_result($rsmn,0);
	
	echo $pr;
 ?>
 </td>
 </tr>
 
 
 
 
 
  <? }
 ?>
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

<?php require('../../../../util/header.inc');
//setlocale(LC_ALL,"es_ES");
$whe_conceptos=	"and promedio not in ('I','S','B','MB')";

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";

}
$institucion = $_INSTIT;
$ano		 = $_ANO;

header('Content-type: application/vnd.ms-excel');
   // header("Content-Disposition: attachment; filename=notas_$fechahoy.xls");
header("Content-Disposition:inline; filename=resumen_4_medios.xls");

$query_ins_ano="select rdb,dig_rdb, nombre_instit from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'"; //revisar
$row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
td{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	font-style: normal;
	font-weight: normal;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo1 {font-size: 10px}
-->
    </style>
	
<SCRIPT language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function window_open(url,ancho,alto){
var opciones="left=100,top=100,width="+ancho+",height="+alto+",scrollbars=yes,resizable=yes,status=yes", i= 0;
 window.open(url,"aa",opciones); 
 }

//-->
</script>

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
       function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../seteaAno.php3?caso=10&pa=14&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }


</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')"  >

 
								
								  
									<?
									$Curso_pal = CursoPalabra($curso, 1, $conn);
									?>
									<table width="700" border="0" align="center" cellpadding="3" cellspacing="0">
                                      <tr>
                                        <td colspan="4"><div align="center">Curso: <?=$Curso_pal ?></div></td>
                                      </tr>
                                      <tr>
                                        <td width="15%"><div align="left">Rut</div></td>
                                        <td width="40%"><div align="left">Nombre</div></td>
                                        <td width="10%"><div align="center">Suma</div></td>
                                        <td width="10%"><div align="center">Cantidad</div></td>
                                        <td width="25%"><div align="center">Ponderaci&oacute;n</div></td>
                                      </tr>
									  <?
									  $qry="SELECT matricula.bool_ar, matricula.total_notas, suma_pond, pond_demre, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$_ANO.")) and bool_ar='0'  order by nro_lista asc, ape_pat, ape_mat, nombre_alu asc ";
				                      $result =@pg_Exec($conn,$qry);
									  $num_res = @pg_numrows($result);
									  for ($j = 0; $j < $num_res; $j++){								  
											$fil_res = pg_fetch_array($result,$j);
											$nombre_alu = $fil_res['nombre_alu'];
											$ape_pat    = $fil_res['ape_pat'];
											$ape_mat    = $fil_res['ape_mat'];
											$rut_alumno = $fil_res['rut_alumno'];
											$dig_rut    = $fil_res['dig_rut'];
											$total_notas  = $fil_res['total_notas'];
											$suma_pond    = $fil_res['suma_pond'];
											$pond_demre   = $fil_res['pond_demre'];											  
											
										    ?>											  
										    <tr>
											<td><span class="Estilo1"><? echo "$rut_alumno-$dig_rut"; ?></span></td>
											<td><span class="Estilo1"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></span></td>
											<td><div align="right" class="Estilo1"><? echo "$suma_pond"; ?></div></td>
											<td><div align="right" class="Estilo1"><? echo "$total_notas"; ?></div></td>
										    <td><div align="right"><?=$pond_demre ?></div></td>
										    </tr>
										    <?
									   
									   
									    }  /// fin for contador de alumnos							
									
									?>								  
</table>
</body>
</html>
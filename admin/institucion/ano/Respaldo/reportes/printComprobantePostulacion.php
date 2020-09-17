<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$alumno;
	$_POSP = 4;
	$_bot = 8;
	
	
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];		 
?>
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
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo6 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo7 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
</style>
</head>
<body>
 <div id="capa0">
	<table width="600" align="center">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	     <td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
     	</td></tr>
  </table>
</div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td><div align="center" class="Estilo7">COMPROBANTE DE POSTULACION </div></td>
      </tr>
    </table>
    <br>
	<?
	$dd = date("d");
	$mm = date("m");
	$aa = date("Y");
	$fecha = "$dd-$mm-$aa";
	
	$qry="SELECT matricula.*, alumno.*, matricula.fecha as fecha_entera, date_part('day',matricula.fecha) AS day, date_part('month',matricula.fecha) AS month, date_part('year',matricula.fecha) AS year FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)=".$alumno."))";
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);
	$nombre_alu = $fila['nombre_alu'];
	$ape_pat    = $fila['ape_pat'];
	$ape_mat    = $fila['ape_mat'];
	
	?>	
    <table width="600" border="0" cellspacing="0" cellpadding="3" align="center">
      <tr>
        <td width="20%"><span class="Estilo5">Fecha</span></td>
        <td width="30%"><span class="Estilo6"><?=$fecha ?></span></td>
        <td width="20%"><span class="Estilo5">Folio</span></td>
        <td width="30%"><span class="Estilo6"><input name="folio" type="text" value="0" size="10">
        </span></td>
      </tr>
      <tr>
        <td><span class="Estilo5">Establecimiento</span></td>
        <td colspan="3"><span class="Estilo6"><?=$nombre_institu ?> </span></td>
      </tr>
      <tr>
        <td><span class="Estilo5">Curso</span></td>
        <td colspan="3"><span class="Estilo6">
		<? 
		$qryC = "SELECT cod_decreto, grado_curso, letra_curso, nombre_tipo FROM ((curso INNER JOIN matricula ON curso.id_curso=matricula.id_curso) INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza) WHERE matricula.rut_alumno=".$fila["rut_alumno"]." and matricula.id_ano=".$ano; 
		$resultC =@pg_Exec($conn,$qryC);
		$filaC = @pg_fetch_array($resultC,0); 
		
		if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
			$grado="PRIMER NIVEL";
		}else if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==121987) or ($filaC['cod_decreto']==1521989)) ){
			$grado="PRIMER CICLO";
		}else if ( ($filaC['grado_curso']==1) and ($filaC['cod_decreto']==1000)){
			$grado="SALA CUNA";
		}else if ( ($filaC['grado_curso']==2) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
			$grado="SEGUNDO NIVEL";
		}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==121987) ){
			$grado="SEGUNDO CICLO";
		}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==1000)){
			$grado="NIVEL MEDIO MENOR";
		}else if ( ($filaC['grado_curso']==3) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
			$grado="TERCER NIVEL";
		}else if ( ($filaC['grado_curso']==3) and ($filaC['cod_decreto']==1000)){
			$grado="NIVEL MEDIO MAYOR";
		}else if ( ($fila1['grado_curso']==4) || ($filaC['cod_decreto']==1000)){
			$grado="TRANSICIÓN 1er NIVEL";
		}else if ( ($fila1['grado_curso']==5) || ($filaC['cod_decreto']==1000)){
			$grado="TRANSICIÓN 2er NIVEL";
		}else{
			$grado=$filaC['grado_curso'];
		}
					
		
		imp($grado."-".$filaC["letra_curso"]." ".$filaC["nombre_tipo"]);
				
		?></span></td>
      </tr>
	  <tr>
        <td><span class="Estilo5">Alumno</span></td>
        <td colspan="3"><span class="Estilo6"><? echo "$nombre_alu $ape_pat $ape_mat"; ?></span></td>
      </tr>
      <tr>
        <td height="120" colspan="4"><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br></td>
      </tr>
      <tr>
        <td colspan="4"><div align="center">__________________________</div></td>
      </tr>
      <tr>
        <td colspan="4"><div align="center" class="Estilo5">Nombre y firma responsable </div></td>
      </tr>
    </table>

</body>
</html>

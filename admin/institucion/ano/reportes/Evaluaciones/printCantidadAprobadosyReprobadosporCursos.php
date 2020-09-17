<?
echo "antes de header";

require('../../../../../util/header.inc'); 

echo "despues de header ++";

include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');

echo "despues de membrete";

//exit;

	//setlocale("LC_ALL","es_ES");
    $institucion	=$_INSTIT;
	$ano			=$_ANO;
	$idnivel        =$_cmbNIVEL; 
	$reporte		=$c_reporte;

	$_POSP = 5;
	$_bot = 8;
	
		
	//---------------------Configuro Membrete--------------------//
	
	$ob_membrete = new Membrete();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn); 
		
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_membrete ->idnivel = $idnivel;
	$ob_membrete ->nivel($conn);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>

<SCRIPT language="JavaScript">
									
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


function cerrar(){ 
window.close() 
} 

</script>

</head>

<body >

 <div id="capa0">
  <table width="700" align="center">
    <tr>
      <td width="302"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">      </td>
      <td width="316" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">      </td>
      <td width="66" align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form);"  value="EXPORTAR"> </td>
    </tr>
  </table>
</div>
		<table width="628" align="center" border=0 cellpadding=1 cellspacing=1>
		  <tr> 
			<td width="20%" align=left class="titulo"> <strong> INSTITUCION </strong></td>
			<td width="1%"> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong></font> </td>
			<td width="44%" class="subitem"><font face="arial, geneva, helvetica" size="1"><strong><?=$ob_membrete->ins_pal;?></strong></font></td>
            <td width="35%" rowspan="3" class="subitem">
			<?
			/*	$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }*/
			  
			  
			  ?>		
			&nbsp;</td>
		  </tr>
         <tr> 
            <td align=left class="item"> <strong> AÑO ESCOLAR  </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> <?=$ob_membrete->nro_ano?></strong> </font> </td>
          </tr>
		  <tr> 
            <td align=left class="item"> <strong> NIVEL </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong><?=$ob_membrete->nombre_nivel?>								
              </strong> </font> </td>
          </tr>
        </table>

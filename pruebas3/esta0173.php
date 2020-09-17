<?php
require('conn/conn.php');
include ("FusionCharts.php");

$corporacion=8;
$mes = "03";
$ano = 2010;

$sql = "SELECT rdb FROM corp_instit where num_corp=8";
$rs_inst = @pg_exec($conn,$sql);

for($i=0;$i<@pg_numrows($rs_inst);$i++){
	$fila = @pg_fetch_array($rs_inst,$i);
	$rdb = $fila['rdb'];

	
	$sql = "SELECT count(*) FROM matricula WHERE rdb=".$fila['rdb']." AND id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila['rdb']." AND nro_ano=".$ano.") and date_part('month',fecha)=".$mes;
	$rs_matricula = @pg_exec($conn,$sql);
	$matricula = @pg_result($rs_matricula,0);
	echo "<br>".$total[$rdb]=$matricula;
	
	
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Minuta Gasto Común</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="file:///C|/Documents%20and%20Settings/visita/Escritorio/admedif/sitio/estilo1.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

function imprimir() {
        document.getElementById("capa0").style.display='none';
        window.print();
        document.getElementById("capa0").style.display='block';
}
</script>
<link href="../estilo1.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="capa0">
  <table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="right"><input name="volver" type="button" value="VOLVER" class="botadd" onClick="window.location='esta0170.php'">&nbsp;&nbsp;<input name="imprimir" type="button" value="IMPRIMIR" class="botadd" onClick="imprimir();" ></td>
</tr>
</table>

</div>
<br>
<table width="640" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td> <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="celdas3">
        <tr>
          <td width="390" align="left"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="celdas3">
                <td width="390"> <div align="left">nombre colegio</div></td>
              </tr>
              <tr class="celdas3">
                <td><div align="left">RUT : <? echo "82.049.000-2"; ?>  </div></td>
              </tr>
          </table></td>



       




        </tr>
        <tr>
        </tr>
        <tr>

                        <BR>
            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="content_impresion_content">

       

            <table width="95%" border="2" align="center" cellpadding="3" cellspacing="0" class="content_impresion_content">
                        <?php



// ahora que todo esta en $tabla1(conceptos1-5 , meses 1-12)
// se lleva el formato grafico
// los colores
                                $cola = "AFD8F8";


   //Create an XML data document in a string variable
   $strXML  = "";

   $vartitulo ="Grafico Estadistico Matricula Mes".$mes." del ".$ano;

   $vartituxx ="Periodo ";

   $vartituyy =" Valor Gasto";


   $strXML .= "<graph caption='$vartitulo' xAxisName='$vartituxx' yAxisName='$vartituyy'

   decimalPrecision='0' formatNumberScale='0'>";


   // se hacen todos los select buscando unidades
   // se barre el archivo de lugar aprehencion


                        // en $ababjo se calcula la lnea a visualizar

                        /*$abajo = 0;
                        for($bbarre=1;$bbarre<=$maxgru;$bbarre++)
                        {
                                if (trim($codcon) == trim($tabla1[$bbarre][0]))
                                {
                                        $abajo = $bbarre;
                                }
                        }*/



                        for ($i=0;$i<@pg_numrows($rs_inst);$i++){
								$fila= @pg_fetch_array($rs_inst,$i);
								$rdb=$fila['rdb'];
								// se grarfica imprime
								$nomest=$fila['rdb'];
								$cantid=$total[$rdb];
								$colorea=$cola;
								$strXML .= "<set name='$nomest' value='$cantid' color='$colorea' />";
		
        			        
						}


   $strXML .= "</graph>";

   //Create the chart - Column 3D Chart with data from strXML variable using dataXML method
 //  echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", 600, 300);

   $ancho=200+(60*10);
   echo renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 250);


        echo "</table>";
        echo "<p></p>";


                                  ?>

      
<br>
</body>
<html>

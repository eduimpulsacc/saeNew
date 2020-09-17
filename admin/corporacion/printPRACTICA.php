<?php require('../../util/header.inc');

$corporacion   =$_CORPORACION;

function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
.Estilo10 {color: #0099FF}
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}
.Estilo11 {font-size: 9px}
.Estilo20 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-size: 9}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo26 {font-size: 9; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }

-->
</style>
</head>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<body>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td>
	<div id="capa0">
  <table width="100%" border="0">
  <tr>
	<td class="Estilo4" align="left"><input name="cerrar" type="button" class="botonXX" onClick="window.close();" value="CERRAR" /></td>
	<td class="Estilo4" align="right"><input name="imprimir" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR" /></td>
  </tr>
  </table>
  </div>  </td>
  </tr>
  <br />
  <tr>
    <td><?
	
	?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" align="center" class="tableindex">REPORTE ESTADISTICO PRACTICAS Y TITULACI&Oacute;N</td>
      </tr>
      <tr>
        <td align="center" class="Estilo25">A&Ntilde;O:<?=$cmbANOS;?></td>
      </tr>
    </table>
	 <table width="650" border="0" cellspacing="0" cellpadding="5" align="center" id="practica">                 
											<tr>
											  <td rowspan="2">&nbsp;</td>
											  <td>
                                              
                                                                                      <table width="100%" border="0">
                                                <tr>
                                                  <td colspan="7" class=" Estilo20 Estilo1">INSTITUCIONES</td>
                                                </tr>
                                                <tr>
                                                <? 
									$sql=" select b.* from corp_instit a  inner join institucion b on (a.rdb=b.rdb) where num_corp=".$corporacion;
									$resp=pg_exec($conn,$sql);
									
								for($i=0;$i<pg_numrows($resp);$i++){	
									$fila_inst=pg_fetch_array($resp,$i);
									$rdb=$fila_inst['rdb'];		
												
												?>
                                                  <td width="45%" colspan="7" class="Estilo25"><?=ucfirst($fila_inst['nombre_instit']);?>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                 <td valign="top">
                                                  <table width="100" border="1" cellspacing="0" bordercolor="#999999"> 
												
                                                    <tr>
                                                     <?  
														$sql2="select * from estado_practica ";
														if($cmb_estados!=100){
														   $sql2.=" where cod_estado=$cmb_estados";														
														}else{
																													
														}
														$resp2=pg_exec($conn,$sql2);
														
													for($j=0;$j<pg_numrows($resp2);$j++){
														$fila=pg_fetch_array($resp2,$j);
														$cod_estado=$fila['cod_estado'];
													 ?>
                                                      <td width="90" height="55"  align="center" bgcolor="#CCCCCC" class="Estilo4"><?=$fila['nombre_estado'];?>&nbsp;</td>
                                                    <? } ?>
                                                    </tr>
                                                    <tr>
                                                   <?
								$sql_ano=" select id_ano from ano_escolar where nro_ano=$cmbANOS and id_institucion=$rdb";	
								$resp_ano=pg_exec($conn,$sql_ano);
								$ano_inst=pg_result($resp_ano,0);
													
											for($x=0;$x<pg_numrows($resp2);$x++){
											$fila=pg_fetch_array($resp2,$x);
											$cod_estado=$fila['cod_estado'];				
                                $sql3="select DISTINCT a.* from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) where a.estado=$cod_estado and b.rdb=$rdb and a.id_ano=$ano_inst";
								
								$resp3=pg_exec($conn,$sql3);
								$total=pg_numrows($resp3);														
													
													?>
                                                      <td align="center" class="Estilo1"><?=$total;?>&nbsp;</td>
                                                       <? }?>
                                                    </tr> 
                                                  </table> 
												 </td>
                                                </tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<? }?>
                                              </table>	
                                              									    
											    <p>&nbsp;</p>											    </td>
            </tr>           
                </table>   	
    
    </td>
  </tr>
</table>

</body>
</html>

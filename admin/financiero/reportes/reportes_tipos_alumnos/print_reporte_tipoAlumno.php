<?
require('../../../../util/header.inc');


$corporacion = $_CORPORACION;
$ano		 = $cmb_anos;
$mes		 = $cmb_mes;
$nacional=	$id_nacional;
switch($mes){
			case $mes == 1;
			$mes='Enero';
			break;
			case $mes == 2;
			$mes='Febrero';
			break;
			case $mes == 3;
			$mes='Marzo';
			break;
			case $mes == 4;
			$mes='Abril';
			break;
			case $mes == 5;
			$mes='Mayo';
			break;
			case $mes == 6;
			$mes='Junio';
			break;
			case $mes == 7;
			$mes='Julio';
			break;
			case $mes == 8;
			$mes='Agosto';
			break;
			case $mes == 9;
			$mes='Septiembre';
			break;
			case $mes == 10;
			$mes='Octubre';
			break;
			case $mes == 11;
			$mes='Noviembre';
			break;
			case $mes == 12;
			$mes='Diciembre';
			break;
			}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../../../../estilo.css" rel="stylesheet" type="text/css" />
<link href="../../../corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script language="javascript">
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	  
		  
</script>
<link href="../../../../../../../../admin/corporacion/estilo.css" rel="stylesheet" type="text/css" />
<link href="../../../corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-weight: bold; background-color: #CCCCCC; text-align: center;}
.Estilo3 {font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; font-weight: bold; background-color: #CCCCCC;}
-->
</style>
</head>
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="cerrar" value="CERRAR" onClick="javascript:window.close() " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"/>
      </div></td>
	  
    </tr>
  </table>
</div>
<br />
<? 	$sql="SELECT logo FROM corporacion WHERE num_corp=".$_CORPORACION;
	$rs_logo = pg_exec($conn,$sql);
	$logo = pg_result($rs_logo,0);?>
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../../../../images/linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"><img src="<?=$logo;?>" /></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../../../../images/linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br /> 
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">REPORTE CANTIDAD TIPO ALUMNOS SUBVENCIONADOS <br />
            A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
   <table  width="650" align="center" border="1" style="border-collapse:collapse">
            <tr class="tableindex">
            <td width="250">Instituci&oacute;n</td>
          
            <td width="400"  align="center"><?=$mes?>
              <table width="100%"  border="1" style="border-collapse:collapse; background-color:#CCC;border-color:#999">
                <tr >
                  <td width="100"  align="center">SEP</td>
                  <td width="100"  align="center">PIE</td>
                  <td width="100"  align="center">RETOS</td>
                  <td width="100"  align="center">NORMAL</td>
                </tr>
              </table></td>
           </tr>
       
             
             <?
			
		/* $sql="SELECT c.ensenanza,id_curso, c.grado_curso || ' ' || c.letra_curso || '-' || te.nombre_tipo as curso  
		from curso c
		inner join tipo_ensenanza te on c.ensenanza=te.cod_tipo
		where c.id_ano = $id_ano order by c.ensenanza,c.grado_curso,c.letra_curso";*/
		
		
		
		
		$contador_p=0;
		$contador_r=0;
		$contador_n=0;
		$contador_s=0;
		
		$sql="select ins.rdb,ins.nombre_instit,estado 
				from nacional_corp nc 
				inner join corp_instit ci on ci.num_corp=nc.num_corp
				inner join institucion ins on ins.rdb=ci.rdb
				where nc.id_nacional=".$nacional." 
				order by nombre_instit asc";
		
		$rs=pg_Exec($conn,$sql)or die ("Fallo x!!" .$sql);
			for($x=0;$x<@pg_numrows($rs);$x++){
				$fila=pg_fetch_array($rs,$x);
				//$Curso_pal = CursoPalabra($fila['id_curso'], 0, $conn);
				
				
				$sql_id_ano="select * from ano_escolar where nro_ano=$ano";
				$rs_ano=pg_exec($conn,$sql_id_ano);
				$fila_ano=pg_fetch_array($rs_ano,$x);
				$id_ano=$fila_ano['id_ano'];
				
				
				$sql="SELECT c.ensenanza,id_curso, c.grado_curso || ' ' || c.letra_curso || '-' || te.nombre_tipo as curso  
						from curso c
						inner join tipo_ensenanza te on c.ensenanza=te.cod_tipo
						where c.id_ano = $id_ano order by c.ensenanza,c.grado_curso,c.letra_curso";
						$rs_curso=pg_exec($conn,$sql);
						$fila_curso=pg_fetch_array($rs_curso,$x);
						//print_r($fila_curso);
		
				
				

			?>
  <tr>
            <td style="font-size:10px; font-family:Arial, Helvetica, sans-serif;"><?=$fila['nombre_instit'];?></td>
            <td style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
             <table width="100%" border="1" style="border-collapse:collapse" >
                <tr >
                  <td width="100" align="center">
                  <?
                  	  $sql_sep="SELECT count(*) as sep
						from matricula m 
						where m.id_ano = ".$id_ano." and date_part('month',fecha)<=".$cmb_mes." and m.ben_sep=1";
						
						$rs_sep=@pg_exec($conn,$sql_sep);
						
						
						$fila_sep=@pg_fetch_assoc($rs_sep,0);
						if($fila_sep['sep']!=0){
							echo $fila_sep['sep'];
						}else{
							echo 0;
							}
							
						$contador_s=$fila_sep['sep']+$contador_s;
				  ?>
                  </td>
                  <td width="100"  align="center">
                  <?
                  	 $sql_pie="SELECT count(*) as pie
						from matricula m 
						where m.id_ano = ".$id_ano." and date_part('month',fecha)<=".$cmb_mes." and m.ben_pie=1";
						
						$rs_pie=@pg_exec($conn,$sql_pie);
						
						
						$fila_pie=@pg_fetch_assoc($rs_pie,0);
							if($fila_pie['pie']!=0){
								echo $fila_pie['pie'];
								}else{
							     echo 0;
			                   }
						$contador_p=$fila_pie['pie']+$contador_p;	  
						$contador_p; 
							   
				  ?>
                  </td>
                  <td width="100"  align="center">
                  
                   <?
                  	 $sql_retos="SELECT count(*) as retos
						from matricula m 
						where m.id_ano = ".$id_ano." and date_part('month',fecha)<=".$cmb_mes." and m.bool_retos=1";
						
						$rs_retos=@pg_exec($conn,$sql_retos);
						
						
						$fila_retos=@pg_fetch_assoc($rs_retos,0);
							if($fila_retos['retos']!=0){
								echo $fila_retos['retos'];
								}else{
							     echo 0;
			                   }
						$contador_r=$fila_retos['retos']+$contador_r;	   
				  ?>
                  </td>
                  <td width="100"  align="center">
                  <?
				  
	 $sql_nor="SELECT count(m.*) as normal
	from matricula m 
	where m.id_ano = ".$id_ano." and date_part('month',fecha)<=".$cmb_mes." and  
	 (m.ben_pie=0 or m.ben_pie is null) and (m.ben_sep=0 or m.ben_sep is null) and (m.bool_retos=0 or m.bool_retos is NULL)";
					
					$res_nor=@pg_exec($conn,$sql_nor);
					$fila_nor=@pg_fetch_array($res_nor,0);
							if(isset($fila_nor['normal'])){
					echo $fila_nor['normal'];
							}else{
								echo 0;
								}
					$contador_n=$fila_nor['normal']+$contador_n;
						
				  ?>
                  </td>
                </tr>
              </table>
            </td>          
            <?
			}
			?>
            </tr>
            </table>
    <br />
    
    <br>
            <table width="650" align="center" border="1" style="border-collapse:collapse">
            <tr>
            <td width="240" align="center" style="font:bold">TOTAL</td>
            <td width="93" align="center"><?=$contador_s?></td>
            <td width="96" align="center"><?=$contador_p?></td>
            <td width="96" align="center"><?=$contador_r?></td>
            <td width="91" align="center"><?=$contador_n?></td>
            
            </tr>
            </table>
    
    
    <br />
    <br /></td>
  </tr>
  
  <tr>
  <?
  	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
  ?>
    <td valign="baseline"><HR />
       <div align="right" class="fecha">Valparaiso, <?=$fechaEspañol?> </div></td>
  </tr>
</table>
</body>
</html>
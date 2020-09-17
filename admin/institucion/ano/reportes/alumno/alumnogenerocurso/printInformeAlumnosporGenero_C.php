<? 

require('../../../../../../util/header.inc');

include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');


$institucion			= $_INSTIT;
$ano			= $cmb_ano;
$reporte		=$c_reporte;
$curso = 1;



$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
"</br>".$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];



	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
		$ob_reporte->rdb=$institucion;
		$ob_reporte->item= $reporte;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->item= $fils_item['id_item'];
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
				
			
				}
				else{
				$crp = $aut;
				}
			
			$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}else{
		$crp=1;
		}
	
	
	
		

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
</style>
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

<script> 
function cerrar(){ 
window.close() 
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
<body>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$nombre_institucion?></font></div></td>
                <td width="161" rowspan="3" align="center" valign="top" >
				<?
		$result_foto = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_foto,0);
		$fila_foto = @pg_fetch_array($result_foto,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../../".$d."menu/imag/logo.gif' >";
	  }?>
				</td>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ano_esc?></font></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>	
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="161" rowspan="5" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
		    </table>

<table width="650" border="1" align="center" style="border-collapse:collapse ">
<tr>
        <td colspan="9" class="tableindex">
          <div align="center">CANTIDAD DE ALUMNOS POR GENERO</div></td>
    </tr>
      <tr>
        <td colspan="9"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
    </tr>
		  <tr>
        <td width="341" class="textonegrita"><strong>CURSOS</strong></td>
        <td colspan="3" class="textonegrita">HOMBRES</td>
        <td width="91" class="textonegrita">MUJERES</td>
        <td width="64" class="textonegrita">TOTAL</td>
      </tr>
      <? 	$sql ="SELECT id_curso, grado_curso ||''|| letra_curso ||' '|| te.nombre_tipo as curso FROM curso c INNER JOIN tipo_ensenanza te ON c.ensenanza=te.cod_tipo WHERE id_ano=".$ano." ORDER BY ensenanza,grado_curso,letra_curso ASC";
	  		$rs_curso =pg_exec($conn,$sql);
			
			for($i=0;$i<pg_numrows($rs_curso);$i++){
				$fila =pg_fetch_array($rs_curso,$i);
				$total=0;
	?>			
      <tr>
        <td class="Estilo7">&nbsp;<?=$fila['curso'];?></td>
        <? 	$sql="SELECT count(*) FROM matricula m INNER JOIN alumno a ON m.rut_alumno=a.rut_alumno WHERE id_ano=".$ano."  AND id_curso=".$fila['id_curso']." AND sexo=2";
			if($chkRETIRADO==1){
				$sql.=" AND bool_ar in (1,0)";	
			}else{
				$sql.=" AND bool_ar=0";
			}
			$rs_hombre = pg_exec($conn,$sql);
			$hombres = pg_result($rs_hombre,0);
			$total_hombre = $total_hombre + $hombres;
		?>
        <td colspan="3" class="Estilo7">&nbsp;<?=$hombres;?></td>
        <?  $sql2="SELECT count(*) FROM matricula m INNER JOIN alumno a ON m.rut_alumno=a.rut_alumno WHERE id_ano=".$ano."  AND id_curso=".$fila['id_curso']." AND sexo=1";
			if($chkRETIRADO==1){
				$sql2.=" AND bool_ar in(1,0)";	
			}else{
				$sql2.=" AND bool_ar=0";
			}
			//echo  $sql2;
			$rs_mujer = pg_exec($conn,$sql2);
			$mujeres = pg_result($rs_mujer,0);
			$total_mujer = $total_mujer + $mujeres;
		?>
        <td class="Estilo7">&nbsp;<?=$mujeres;?></td>
        <? $total =$hombres + $mujeres;
			$total_gral = $total_gral + $total;?>
        <td class="Estilo7">&nbsp;<?=$total;?></td>
      </tr>
      <? } ?>
      <tr>
        <td class="Estilo7">&nbsp;</td>
        <td colspan="3" class="Estilo7">&nbsp;<?=$total_hombre;?></td>
        <td class="Estilo7">&nbsp;<?=$total_mujer;?></td>
        <td class="Estilo7">&nbsp;<?=$total_gral;?></td>
    </tr>	
		

</table><br />
<br />

 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $concur=0;
		 include("../../firmas/firmas.php");?>
</div>
</body>
</html>

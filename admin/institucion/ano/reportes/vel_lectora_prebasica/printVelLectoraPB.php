<?php
require('../../../../../util/header.inc');


	
	
	$institucion	= $_INSTIT;
	$ano			= $select_ano;
	$curso			= $select_cursos;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	
    $reporte		= $c_reporte;
	
	$fecha = CambioFE($txtFECHA);
	
	include('../../../../clases/class_Reporte.php');
	include('../../../../clases/class_Membrete.php');
	
	//******INSITUCION ******************
	$ob_membrete = new Membrete();
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->BuscaReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_reporte->fecha=$fecha;
	
	
	$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
"</br>".$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];


		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$ob_reporte ->orden =$ck_orden;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
		
		
		//area reporte
		$ob_reporte ->rdb = $institucion;
		$ob_reporte ->padre = 0;
		$rs_area= $ob_reporte ->itmVelLectoraPB($conn);
?>
<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<div id="capa0">
<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>
</div>
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
               <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>CURSO</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=CursoPalabra($curso,1,$conn);?></font></div></td>
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
<p>&nbsp;</p>
<table width="850" border="1" align="center" style="border-collapse:collapse ">
<tr>
        <td colspan="9" class="tableindex">
          <div align="center">VELOCIDAD LECTORA</div></td>
  </tr></table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1" align="center" style="border-collapse:collapse ">
<tr>
  <td colspan="2" align="center" class="tableindex">&nbsp;</td>
<?php   for($ar=0;$ar<pg_numrows($rs_area);$ar++){
	$fila_area = pg_fetch_array($rs_area,$ar);  $ob_reporte ->padre = $fila_area['id_item'];
		$rs_item= $ob_reporte ->itmVelLectoraPB($conn);
		
	?>
  <td align="center" class="tableindex" colspan="<?php echo pg_numrows($rs_item) ?>"><?php echo $fila_area['glosa'] ?></td>
 
  <?php }?>
</tr>
<tr>
        <td align="center" class="tableindex">#</td>
        
        <td  align="center" class="tableindex">Alumno</td>
      <?php 
	   for($ar=0;$ar<pg_numrows($rs_area);$ar++){
	$fila_area = pg_fetch_array($rs_area,$ar);
	   $ob_reporte ->padre = $fila_area['id_item'];
		$rs_item= $ob_reporte ->itmVelLectoraPB($conn);
		for($it=0;$it<pg_numrows($rs_item);$it++){
			$fila_item = pg_fetch_array($rs_item,$it);
			?>
        <td align="center" class="tableindex"><div align="center"><?php echo $fila_item['glosa'] ?></div></td>
        <?php }}?>
        
  </tr>
  <?php for($a=0;$a<pg_numrows($result_alu);$a++){
	  $fila = pg_fetch_array($result_alu,$a);
	  $ob_reporte->rut=$fila['rut_alumno'];
	  ?>
<tr class="textosimple">
  <td><?php echo $a+1 ?></td>
  <td  ><? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?></td>
  <?php 
	   for($ar=0;$ar<pg_numrows($rs_area);$ar++){
	$fila_area = pg_fetch_array($rs_area,$ar);
	   $ob_reporte ->padre = $fila_area['id_item'];
		$rs_item= $ob_reporte ->itmVelLectoraPB($conn);
		for($it=0;$it<pg_numrows($rs_item);$it++){
			$fila_item = pg_fetch_array($rs_item,$it);
			$ob_reporte ->area =$fila_area['id_item'];
			$ob_reporte ->item =$fila_item['id_item'];
			$rs_eva = $ob_reporte->tengoEvaPB($conn);
			
			$muestra="";
			if(pg_numrows($rs_eva)>0){
				$ob_reporte ->concepto=pg_result($rs_eva,6);
				$rs_concepto = $ob_reporte ->tengoRespEvaPB($conn);	
				$muestra=($concepto==1)?pg_result($rs_concepto,2):pg_result($rs_concepto,3);
				//$concepto = pg_result()
			}
			
			?>
        <td align="center" class="texsosimple"><?php echo $muestra ?></td>
        <?php }}?>
</tr>
<?php }?>
</table>

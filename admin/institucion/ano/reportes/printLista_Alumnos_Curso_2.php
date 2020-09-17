<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
</head>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 9px;
}
.Estilo6 {font-size: 9px}
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 9px; }
.Estilo12 {font-weight: bold; font-size: 9px;}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($cmb_curso!=0){
   ?>

<?php //echo tope("../../../../../util/");?>
<table>
    <tr>
	  <td align="left">&nbsp;</td>
	</tr>
  </table>
  
  
	<center>

<table width="550" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>

	  <div id="capa0">
	  <table width="100%">
	    <tr>
	  <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	  <td align="right">
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		</td>
		
		</tr></table>
	  </div>

<?	}	?>	
	</td>
  </tr>
  <TR><TD>&nbsp;</TD></TR>
</table>


  <table width="550" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> 
	  
	  
  <? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br>";
		   
	  }else{
	
		?>
	  
	  
	  
	  <table width="550" border=0 cellspacing=1 cellpadding=1>
          <tr> 
            <td align=left> <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> INSTITUCION 
              </font></strong> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?php  
                                                                               
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
												}
											}
										?>
               </font> </td>

                <td width="161" rowspan="5" align="center" valign="top" >
			<?	
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
			
				if($institucion!=""){
					echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				}else{
					echo "<img src='".$d."menu/imag/logo.gif' >";
				}
			?>
				</td>



          </tr>
          <tr> 
            <td align=left> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>AÑO ESCOLAR</strong> </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
               </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>CURSO</strong> 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?php
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";

											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{

												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
													exit();
												}
												
							if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
								echo "SALA CUNA"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
								echo "TERCER NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
								echo "TRANSICIÓN 1er NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
								echo "TRANSICIÓN 2do NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else{
								echo $fila1['grado_curso']." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}
												
											}
										?>
               </font> </td>
          </tr>
		  
		<tr> 
            <td align=left> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>PROFESOR JEFE</strong> 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result =@pg_Exec($conn,$sql4);
				if (!$result) 
				{
					//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}
				else
				{
					if (pg_numrows($result)!=0)
					{
						$fila = @pg_fetch_array($result,0);	
						if (!$fila)
						{
							//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							//exit();
						}
					}
				}
				
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				//$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				
				?>
               </font> </td>
          </tr>
		  
		    
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		  
        </table>
		
	<? } ?>
	
			
		
	</td>
    </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">LISTADO DEL CURSO</div></td>
      </tr>
	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td><table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
	
    <tr> 
      <td align="center" width="30" class="tablatit2-1">N&ordm;</td>
      <td align="center" width="150" class="tablatit2-1">APELLIDOS</td>
      <td align="center" width="150" class="tablatit2-1">NOMBRES</td>
      <td align="center" width="100" class="tablatit2-1">SEXO</td>
      <td align="center" width="70" class="tablatit2-1">FECHA NAC.</td>

    </tr>
    <?php
				$qry="SELECT matricula.bool_ar, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.comuna, alumno.sexo, alumno.fecha_nac, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) and bool_ar='0' order by ape_pat, ape_mat, nombre_alu asc ";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						exit();
					}
				}
			?>
    <?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						$sexo = $fila["sexo"]; 
						if($sexo==2){
							$sexo="Masculino";
						}
						if($sexo==1){
							$sexo="Femenino";
						}
			?>
      <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
      <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<?php echo $fila["ape_pat"]." ".$fila["ape_mat"]." ";?></strong> </font></td>

      <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila["nombre_alu"]; ?></font> </td>
      <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<? echo $sexo; ?></strong> </font></td>
      <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? impF($fila["fecha_nac"]); ?></font> </td>

    </tr>
    <?php
					}
				}
			?>
	
	</table></td></tr>
    
	<tr> 
      <td colspan="5"> <hr width="100%" color="#003b85"> </td>
    </tr>
  </table>
</center>
  <?
}
?>  
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>
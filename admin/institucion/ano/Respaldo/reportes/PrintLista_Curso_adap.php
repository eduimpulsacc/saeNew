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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

//-->
</script>

<style type="text/css">
<!--
.Estilo5 {color: #FFFFFF; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso != 0){
   ?>
<?php //echo tope("../../../../../util/");?>
<center>
<table width="550" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>
	<div align="right">
	  <div class="Estilo8" id="capa0">Esta Hoja debe Imprimirse en forma Horizontal 
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	  </div>
    </div>
    <span class="Estilo8">
    <?	}	?>	
    </span></td>
  </tr>
  <TR><TD>&nbsp;</TD></TR>
</table>

<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br>";
  }
?>



  <table width="90%" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> <table width="550" border=0 cellspacing=1 cellpadding=1>
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
	
   <? if ($institucion=="770"){ 
		  
			   
	 }else{
		
		    ?>


			  <?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>
  <? } ?>	  
	  
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
		  
        </table></td>
    </tr>

      <tr>
        <td height="20" class="tableindex"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#ffffff">
					    <strong>LISTADO DEL CURSO ADAPTABLE</strong></font></div></td>
      </tr>

	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td>
	
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<tr bgcolor="#48d1cc"> 
			  <td width="30" align="center" bgcolor="#999999" ><span class="Estilo5">N&ordm;</span></td>
			  <td width="30" align="center" bgcolor="#999999" ><span class="Estilo5">nº Mat.</span></td>
			  
			  <? if($email==1){	?>
			  <td width="50" align="center" bgcolor="#999999"><span class="Estilo5">E-mail</span></td>
<?			}?>
			  <td width="160" align="center" bgcolor="#999999" ><span class="Estilo5">APELLIDOS</span></td>
			  <td width="160" align="center" bgcolor="#999999" ><span class="Estilo5">NOMBRES</span></td>
<?			if($lista_rut==1){	?>
			  <td width="75" align="center" bgcolor="#999999"><span class="Estilo5">RUT</span></td>
<?			}
			if($lista_sexo==1){	?>
			  <td width="65" align="center" bgcolor="#999999"><span class="Estilo5">SEXO</span></td>
<?			}
			if($lista_fecha==1){	?>
			  <td width="70" align="center" bgcolor="#999999" ><span class="Estilo5">FECHA NAC.</span></td>
<?			}
			if($lista_fono==1){		?>
			  <td width="60" align="center" bgcolor="#999999" ><span class="Estilo5">TELEFONO</span></td>
<?			}	
			if($lista_dir==1){		?>
			  <td width="170" align="center" bgcolor="#999999" ><span class="Estilo5">DIRECCI&Oacute;N</span></td>
<?			}	?>

<? if($lista_comuna==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo5">Comuna</span></td>

<? }
if($lista_padre==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo5">Padre</span></td>

<? 			}
			if($lista_madre==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo5">Madre</span></td>

<? 			}
?>





			</tr>
	<?php
				$qry = "SELECT  matricula.bool_ar, matricula.num_mat, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.email, alumno.comuna, matricula.id_curso ";
				if($lista_sexo==1){
					$qry = $qry ." , alumno.sexo ";
				}
				if($lista_fecha==1){
					$qry = $qry ." , alumno.fecha_nac ";
				}
				if($lista_fono==1){
					$qry = $qry ." , alumno.telefono ";
				}
				if($lista_dir==1){
					$qry = $qry ." , alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa ";
					
				}
				
				if($lista_comuna==1){
					$qry = $qry ." , alumno.comuna, alumno.region, alumno.ciudad ";
				}
				$qry = $qry ." FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) and bool_ar='0' order by nro_lista asc, ape_pat, ape_mat, nombre_alu asc ";
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
				if($lista_padre==1){
					$sql = "SELECT ape_pat || cast(',' as varchar) || nombre_apo as nombre FROM apoderado a WHERE a.sexo=2 AND a.rut_apo in(SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$fila['rut_alumno'].")";
					$rs_padre = @pg_exec($conn,$sql);
					$Nombre_padre = @pg_result($rs_padre,0);
				}
				if($lista_madre==1){
					$sql = "SELECT ape_pat || cast(',' as varchar) || nombre_apo as nombre FROM apoderado a WHERE a.sexo=1 AND a.rut_apo in(SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$fila['rut_alumno'].")";
					$rs_madre = @pg_exec($conn,$sql);
					$Nombre_madre = @pg_result($rs_madre,0);
				}
				$sexo = $fila["sexo"]; 
				if($sexo==2){
					$sexo="Masculino";
				}
				if($sexo==1){
					$sexo="Femenino";
				}
			?>
			<tr>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila["num_mat"]; ?></font> </td>
			  
			  
			  <?			if($email==1){	?>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila["email"]; ?></font> </td>
<?			}?>
			  
			  
			  
			  
			  <td align="left" width="140"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<?php echo $fila["ape_pat"]." ".$fila["ape_mat"]." ";?></strong> </font></td>
			
			  <td align="left" width="180"> <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila["nombre_alu"]; ?></font> </td>
<?			if($lista_rut==1){	?>
			  <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<? echo trim($fila["rut_alumno"])."-".trim($fila["dig_rut"]); ?></strong> </font></td>
<?			}
			if($lista_sexo==1){	?>
			  <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<? echo $sexo; ?></strong> </font></td>
<?			}
			if($lista_fecha==1){	?>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? impF($fila["fecha_nac"]); ?></font> </td>
<?			}
			if($lista_fono==1){		?>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila["telefono"]; ?></font> </td>
<?			}	
			if($lista_dir==1){		?>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;
			  <? echo $fila["calle"]." ".$fila["nro"]; 
			  	if(trim($fila["depto"])!=NULL && trim($fila["depto"])!=''){
					echo ", depto ".$fila["depto"]; 
				}
			  	if(trim($fila["block"])!=NULL && trim($fila["block"])!=''){
					echo ", ".$fila["block"]; 
				}
			  	if(trim($fila["villa"])!=NULL && trim($fila["villa"])!=''){
					echo ", ".$fila["villa"]; 
				}
			  ?></font> </td>
<?			}	?>

<?
if($lista_comuna==1){		?>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;
			  <? $cod_comuna = $fila["comuna"];
			  $cod_region = $fila["region"];
			  $cod_ciudad = $fila["ciudad"]; 
			  
			  
			  $qry_12345="SELECT nom_com from comuna where cor_com=$cod_comuna and cod_reg=$cod_region and cor_pro=$cod_ciudad";
			  $result_111 = @pg_Exec($conn,$qry_12345);
			  $fila_12345 = @pg_fetch_array($result_111);
			  echo $fila_12345["nom_com"];
			  

		}	  ?></font> </td>
<? 		if($lista_padre==1){?>
			<td><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<?=$Nombre_padre;?></font></td>
			<? } 
			if($lista_madre==1){ ?>
			<td><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<?=$Nombre_madre;?></font></td>
			<? }



?>
	    </tr>
    <?php
				}
			}
			?>
	</table></td></tr>
    
	<tr> 
      <td colspan="5"></td>
    </tr>
  </table>
</center>
   <?
  }
 ?>
</body>
</html>
<? pg_close($conn);?>
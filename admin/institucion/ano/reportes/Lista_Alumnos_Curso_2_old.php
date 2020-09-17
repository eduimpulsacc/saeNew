<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;

	
	if (trim($_url)=="") $_url=0;
?>
<html>
	<head>
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

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


//-->
</script>

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>

<?	if ($cmb_curso==0)
		 exit;
?>

	
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
    </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">

	<?php //echo tope("../../../../../util/");?>
	<center>

<table width="550" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>
	<div align="right">
	  <div id="capa0">
	    <input name="button3" TYPE="button" class="botonX" onClick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	  </div>
    </div>
<?	}	?>	
	</td>
  </tr>
  <TR><TD>&nbsp;</TD></TR>
</table>


  <table width="550" border="0" cellspacing="1" cellpadding="3">
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
				<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/opt/www/coeint/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
			<img src=../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100" >
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
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		  
        </table></td>
    </tr>

      <tr>
        <td height="20" bgcolor="#003b85"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#ffffff">
					    <strong>LISTADO DEL CURSO </strong></font></div></td>
      </tr>

	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td><table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
	
    <tr bgcolor="#48d1cc"> 
      <td align="center" width="30"> <font face="arial, geneva, helvetica" size="1" color="#000000"><strong>N&ordm;</strong></font></td>
      <td align="center" width="150"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>APELLIDOS</strong></font> </td>
      <td align="center" width="150"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRES</strong></font> </td>
      <td align="center" width="100"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>SEXO</strong></font> </td>
      <td align="center" width="70"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>FECHA NAC.</strong></font> </td>

    </tr>
    <?php
				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.comuna, alumno.sexo, alumno.fecha_nac, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
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
</body>
</html>
<? pg_close($conn);?>
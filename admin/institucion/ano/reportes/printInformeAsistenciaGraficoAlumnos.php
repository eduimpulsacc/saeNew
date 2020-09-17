<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$curso;
	$periodo        =$periodo;
	$_POSP = 4;
	$_bot = 8;
	
	$sql_periodo    = "select * from periodo where id_periodo = ".$periodo." order by fecha_inicio";
	$result_periodo = pg_Exec($conn, $sql_periodo);
	$fila_periodo   = pg_fetch_array($result_periodo,0);
	$nombre_periodo = $fila_periodo['nombre_periodo'];
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
<body leftmargin="0" topmargin="0">
<table width="700" border="0" cellpadding="0" cellspacing="3">
  <tr><td>
  <div id="capa0" align="right">
  	  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
  </div>
  </td></tr>
  <tr><td><table border=0 cellspacing=1 cellpadding=3>
          <tr> 
            <td align=left> <strong><font face="arial, geneva, helvetica" size="1"> INSTITUCION 
              </font></strong> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
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
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="arial, geneva, helvetica" size="1"> <strong>AÑO ESCOLAR</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
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
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="arial, geneva, helvetica" size="1"> <strong>CURSO</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
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
              </strong> </font> </td>
          </tr>
        </table></td></tr>
  <tr><td>
   <table width="100%"> 
	<br>
	<tr height="20"> 
      <td align="middle" class="tableindex"><div align="center">LISTADO DEL CURSO</div></td>
    </tr>
	<tr><td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><?=$nombre_periodo ?>
	  <br>
	  <br>
	  <br>
	</b></font></td></tr>
	<br>
	<tr><td>
	    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
	       <tr> 
           <td align="center" width="5%" class="tablatit2-1">N&ordm;</td>
           <td align="center" width="20%" class="tablatit2-1">NOMBRE</td>
           <td align="center" width="55%" class="tablatit2-1">Asistencia</td>
           <td align="center" width="20%" class="tablatit2-1" bgcolor="#c8d6fb"><div align="center">%</div></td>
           </tr>
			<?
			$qry="SELECT matricula.bool_ar, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) and bool_ar='0'  order by ape_pat, ape_mat, nombre_alu asc ";
			$result =@pg_Exec($conn,$qry);
			if (!$result){
				error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
			}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					
				   if (!$fila){
					  error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
					  exit();
				   }
				}   
			}
	
			/// ciclo para listar cada alumno	
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
				$rut_alumno = $fila['rut_alumno'];		
				
				$sql_periodo = "select * from periodo where id_periodo = ".$periodo." order by fecha_inicio";
				$result_periodo = @pg_Exec($conn, $sql_periodo);
				$periodos = @pg_numrows($result_periodo);
				$cadena_asis_periodo=0;
				for($cont=0 ; $cont < @pg_numrows($result_periodo) ; $cont++){
					$fila_periodo = @pg_fetch_array($result_periodo,$cont);
					$fecha_ini = $fila_periodo['fecha_inicio'];
					$fecha_fin = $fila_periodo['fecha_termino'];
					$dias_habiles = $fila_periodo['dias_habiles'];
									
					
					$sql_asis = "select * from asistencia where fecha > '".$fila_periodo['fecha_inicio']."' and fecha < '".$fila_periodo['fecha_termino']."' and rut_alumno = ".trim($rut_alumno);
					$result_asis = @pg_Exec($conn, $sql_asis);
					$num_asis = @pg_numrows($result_asis);
					
					
					$asistencia = @round(100-($num_asis*100/$dias_habiles));	
					$anchotabla = (3 * $asistencia);
							
				}		
				?>
			   <tr>
			   <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
			   <td align="left" ><font face="arial, geneva, helvetica" style="font-size:9px"  color="#000000"><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></font></td>
			   <td align="left" width="310" >
				       <table border="2" cellspacing="0" cellpadding="0" height="13">
					      <tr>
						      <td  width="<?=$anchotabla ?>"></td>
							  <td  width="9"></td>
						  </tr>
					    </table>
				</td>
			   <td align="right" bgcolor="#c8d6fb" ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo "$asistencia %"; ?></font></td>
			   </tr>
             <?php
	       }
		   ?>
		 </table>
	 </td>
	 </tr>
	 </table>   
  </td></tr>
</table>
<br>
</body>
</html>
<? pg_close($conn);?>
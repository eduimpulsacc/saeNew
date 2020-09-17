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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>

<style type="text/css">
<!--
.Estilo7 {color: #FFFFFF; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
       <?
	   include("../../../../cabecera/menu_inferior.php");
	   ?>
	
  
</table>
<? } ?>

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
	  <div id="capa0">
      <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('PrintLista_Curso_adap.php?cmb_curso=<?=$cmb_curso ?>&lista_rut=<?=$lista_rut?>&lista_sexo=<?=$lista_sexo?>&lista_fecha=<?=$lista_fecha?>&lista_fono=<?=$lista_fono?>&lista_dir=<?=$lista_dir?>&email=<?=$email?>&lista_comuna=<?=$lista_comuna?>&lista_padre=<?=$lista_padre;?>&lista_madre=<?=$lista_madre;?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
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
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
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
					    <strong>LISTADO DEL CURSO </strong></font></div></td>
      </tr>

	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td>
	
		<table width="800" border="1" align="center" cellpadding="0" cellspacing="0">
			<tr bgcolor="#48d1cc"> 
			  <td width="30" align="center" bgcolor="#999999" ><span class="Estilo7">N&ordm;</span></td>
			  
			   <td width="1" align="center" bgcolor="#999999" ><span class="Estilo7">nº Mat.</span></td>
			   <? if($email==1){	?>
			  <td width="50" align="center" bgcolor="#999999" ><span class="Estilo7">E-mail</span></td>
<?			}?>
	
			  <td width="150" align="center" bgcolor="#999999" ><span class="Estilo7">APELLIDOS</span></td>
			  <td width="150" align="center" bgcolor="#999999"><span class="Estilo7">NOMBRES</span></td>
<?			if($lista_rut==1){	?>
			  <td width="95" align="center" bgcolor="#999999" ><span class="Estilo7">RUN</span></td>
<?			}
			if($lista_sexo==1){	?>
			  <td width="95" align="center" bgcolor="#999999" ><span class="Estilo7">SEXO</span></td>
<?			}
			if($lista_fecha==1){	?>
			  <td width="70" align="center" bgcolor="#999999"><span class="Estilo7">FECHA NAC.</span></td>
<?			}
			if($lista_fono==1){		?>
			  <td width="130" align="center" bgcolor="#999999" ><span class="Estilo7">TELEFONO</span></td>
<?			}	
			
			if($lista_dir==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo7">DIRECCI&Oacute;N</span></td>
<?			}		

			if($lista_comuna==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo7">Comuna</span></td>

<? 			}
			if($lista_padre==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo7">Padre</span></td>

<? 			}
			if($lista_madre==1){		?>
			  <td width="160" align="center" bgcolor="#999999"><span class="Estilo7">Madre</span></td>

<? 			}
?>

		</tr>
	<?php
				$qry = "SELECT matricula.bool_ar, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.comuna,alumno.email, matricula.id_curso, matricula.num_mat";
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
				
				$num_mat = $fila["num_mat"];			
				
				
				if($sexo==2){
					$sexo="Masculino";
				}
				if($sexo==1){
					$sexo="Femenino";
				}
			?>
			<tr>
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
			  
			  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $num_mat; ?></font> </td>
			  <? if($email==1){	 ?>
			   <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila["email"]; ?></font> </td>
			   <? } ?>
			  
			  <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<?php echo $fila["ape_pat"]." ".$fila["ape_mat"]." ";?></strong> </font></td>
			
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
			  
			 ?></font> </td>
<?			}	
			if($lista_padre==1){?>
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
      <td colspan="5"> <hr width="100%" color="#003b85"> </td>
    </tr>
  </table>
</center>
   <?
  }
 ?>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>

<center>
<form action="Lista_Curso_adap.php" method="post">
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr class="cuadro01">
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr  class="cuadro01">
    <td width="78">Curso</td>
    <td width="263" colspan="3">
	  <div align="left"> 
		  <select name="cmb_curso" class="ddlb_x">
			  <option value=0 selected>(Seleccione Curso)</option>
			<?
			  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
			  {
				  $fila = @pg_fetch_array($resultado_query_cue,$i); 
				  $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				  echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			   } ?>
		  </select>
		</div>	</td>
   
    <td width="80">&nbsp;</td>
	</tr>
	<tr  class="cuadro01">
	<td colspan="8"><table width="100%" border="0">
        <tr>
          <td><span class="Estilo12">Sexo
              <input name="lista_sexo" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">Fecha Nac.
              <input name="lista_fecha" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">Telefono
              <input name="lista_fono" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">Direcci&oacute;n
              <input name="lista_dir" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">RUN
              <input name="lista_rut" type="checkbox" value="1" checked>
          </span></td>
        </tr>
        <tr>
          <td><span class="Estilo12">E-mail
              <input name="email" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">Comuna
              <input name="lista_comuna" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">Pap&aacute;
              <input name="lista_padre" type="checkbox" value="1" checked>
          </span></td>
          <td><span class="Estilo12">Mam&aacute;
              <input name="lista_madre" type="checkbox" value="1" checked>
          </span></td>
          <td><input name="cb_ok" type="submit" class="botonXX " value="Buscar"></td>
        </tr>
      </table></td>
	</tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</form>
</center>

<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
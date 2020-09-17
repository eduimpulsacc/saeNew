<?php require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$formula		=$_FORMULA;
	$frmModo		=$_FRMMODO;
	$docente		=5; //Codigo Docente
	$_POSP           =5;
	
	
	
	
	// TENGO LA FORMULA, DEBO SABER QUE MODO TIENE
	$q1 = "select * from formula where id_formula = '".trim($formula)."'";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	if ($n1>0){
	    $f1 = @pg_fetch_array($r1);
		$modo    = $f1['modo'];
		$id_ramo = $f1['id_ramo'];
	}	
	
	// calculo cuantos subsectores hijos tiene el padre			 
	$q11 = "select * from formula_hijo where id_formula = '".trim($formula)."'";
	$r11 = pg_Exec($conn,$q11);
	$n11 = pg_numrows($r11);
	
	
	

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
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

	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodos	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

	$cmbPERIODO	=	$periodos;
	
	//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto from ((institucion inner join ano_escolar on institucion.rdb=ano_escolar.id_institucion)inner join curso on ano_escolar.id_ano=curso.id_ano)inner join tipo_ensenanza on curso.ensenanza = tipo_ensenanza.cod_tipo where curso.id_curso=".$curso;
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);
	
	$qry1="";
	$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE (((formula_hijo.id_formula)=".trim($formula).")) ";
	$Rs_Hijo = @pg_exec($conn,$qry1);
	for($i=0;$i<@pg_numrows($Rs_Hijo);$i++){
		$fils = @pg_fetch_array($Rs_Hijo,$i);
		$Subsector[$i] = $fils['id_ramo'];
		$Porcentaje[$i] = $fils['porcentaje'];
		$Truncado[$i] = $fils['truncado'];
		$contador++;
	}
	
		//---------------- SELECCIONA TODOS LOS ALUMNOS DEL CURSO------------------
	$qryalum="";
	$qryalum = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE (tiene$nro_ano.id_ramo)=".$Subsector[0]."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
	$Rs_alum = @pg_exec($conn,$qryalum);
	
		
	//-------------- PROXIMAR EL SUBSECTOR PADRE-----------
	$qry3="";
	$qry3 = "SELECT truncado, formula.id_ramo,nota FROM formula INNER JOIN ramo ON formula.id_ramo=ramo.id_ramo WHERE id_formula='".trim($formula)."'";
	$Rs_Ramo = @pg_exec($conn,$qry3);
	$fila_ramo = @pg_fetch_array($Rs_Ramo,0);
	
	
	?>
	<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'formulaSubsector.php3?aux=1&periodos='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		</SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
</style>
</head>
<link href="../../../../../<?=$_ESTILO ?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php");  ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../../menus/menu_lateral.php");  ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  
								  <!-- inicio codigo antiguo -->
								  
								  
<? if ($modo==1){ ?>								  
								  
<form name="form" method="post" action="procesoFormulaSub.php3">
<input name="modo" type="hidden" value="1">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="599" colspan="3"><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nombre_instit']); ?></strong></FONT></TD>
        </TR>
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO 
            ESCOLAR</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nro_ano']); ?></strong></FONT></TD>
        </TR>
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong> 
            <?php
											if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "PRIMER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==121987) or ($fCurso['cod_decreto']==1521989)) ){
												echo "PRIMER CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==2) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "SEGUNDO NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==2) and ($fCurso['cod_decreto']==121987) ){
												echo "SEGUNDO CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==3) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "TERCER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else{
												echo $fCurso['grado_curso']." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											}
								?>
            </strong> </FONT> </TD>
        </TR>
      </TABLE></td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font size="2" face="arial, geneva, helvetica">PERIODO</font>
	 <select name="cmbPERIODO" onChange="enviapag(this.form)">
      <?php
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
					exit();
				};
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila1 = @pg_fetch_array($result,$i);
					if($fila1['id_periodo']==$periodos){
						echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
					}else{
						echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
					}
				}
			}
		};																																																																																																																															
	?>
   </Select></td>
  </tr>
  <tr>
    <td colspan="3"><input name="calc_arm" type="checkbox" id="calc_arm" value="1">
     <font size="2" face="arial, geneva, helvetica"> C&aacute;lculo Aritm&eacute;tico</font></td>
  </tr>
  <tr>
    <td colspan="3" align="right">
	<INPUT class="BotonXX"  TYPE="submit"  value="AGREGAR"> 
	<INPUT class="BotonXX"  TYPE="button"  value="VOLVER" onClick=document.location="listarFormulas.php3"> 
	</td>
  </tr>
  <tr>
  <td><table width="600" border="1" cellspacing="0" cellpadding="0">
          <tr  class="tablatit2-1"> 
            <td width="50%">&nbsp;ALUMNOS</td>
            <? for($i=0;$i<@pg_numrows($Rs_Hijo);$i++){
  				$fila_hijo = @pg_fetch_array($Rs_Hijo,$i)?>
                 <TD width="10%"><font color="#FFFFFF" size="1" face="arial, geneva, helvetica"><? echo InicialesSubsector($fila_hijo['nombre']);?>&nbsp;<? echo $fila_hijo['porcentaje'];?>%</font></TD>
            <? } ?>
            <td width="10%"><font color="#FFFFFF" size="1" face="arial, geneva, helvetica">PROMEDIO</font></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
	<td> <table width="600" border="1" cellspacing="0" cellpadding="0">
  <? for($i=0;$i<@pg_numrows($Rs_alum);$i++){
  		$fila_alum = @pg_fetch_array($Rs_alum,$i);
		$Promedio=0;
  ?>
			
     <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
    <td width="50%"><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $fila_alum['ape_pat']." " .$fila_alum['ape_mat'].", ".$fila_alum['nombre_alu'];?></font></td>
    	<? for($j=0;$j<$contador;$j++){
				
				$qry3 ="";
				$qry3 = "select promedio, notas$nro_ano.rut_alumno from notas$nro_ano where (id_ramo=" . $Subsector[$j] .") and id_periodo=". $cmbPERIODO ." and rut_alumno='" . $fila_alum['rut_alumno'] ."'";
				$Rs_Notas = @pg_exec($conn,$qry3);
				$fila_nota = @pg_fetch_array($Rs_Notas,0);
		?>
	<td  width="10%"><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $fila_nota['promedio'];?></font></td>
	<? 	$Promedio = $Promedio + (($fila_nota['promedio']*$Porcentaje[$j])/100); ?>
	<? }  

	?>
	<? if($fila_ramo['truncado']==1) $PromedioF=round($Promedio); else $PromedioF=intval($Promedio); ?>
    <td width="10%"><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $PromedioF;?></font></td>
  </tr>
  <input name="nota[]" type="hidden" value="<? echo $PromedioF;?>">
  <input name="periodo[]" type="hidden" value="<? echo $cmbPERIODO;?>">
  <input name="ramo[]" type="hidden" value="<? echo $fila_ramo['id_ramo'];?>">
  <input name="posicion[]" type="hidden" value="<? echo $fila_ramo['nota'];?>">
  <input name="Rut[]" type="hidden" value="<? echo $fila_alum['rut_alumno'];?>">
  <? 
  } ?>
</table>
</td>  
  </tr>
</table>
</form>
<? } ?>

<? if ($modo==2){  ?>
<br>
<form name="form" method="post" action="procesoFormulaSub.php3">
<input name="modo" type="hidden" value="2">
<input name="periodo" type="hidden" value="<?=$periodos ?>">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="599" colspan="3"><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nombre_instit']); ?></strong></FONT></TD>
        </TR>
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO 
            ESCOLAR</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nro_ano']); ?></strong></FONT></TD>
        </TR>
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong> 
            <?php
											if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "PRIMER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==121987) or ($fCurso['cod_decreto']==1521989)) ){
												echo "PRIMER CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==2) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "SEGUNDO NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==2) and ($fCurso['cod_decreto']==121987) ){
												echo "SEGUNDO CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==3) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "TERCER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else{
												echo $fCurso['grado_curso']." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											}
								?>
            </strong> </FONT> </TD>
        </TR>
      </TABLE></td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font size="2" face="arial, geneva, helvetica">PERIODO</font> <select name="cmbPERIODO" onChange="enviapag(this.form)">
        <?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$periodos){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};																																																																																																																															
									?>
      </Select></td>
  </tr>
   <tr>
    <td colspan="3"><input name="calc_arm" type="checkbox" id="calc_arm" value="1">
     <font size="2" face="arial, geneva, helvetica"> C&aacute;lculo Aritm&eacute;tico</font></td>
  </tr>
  <tr>
    <td colspan="3" align="right">
	<INPUT class="botonXX"  TYPE="submit" value="AGREGAR"> 
	<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3">	</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td rowspan="2" class="cuadro02"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">ALUMNOS</font></div></td>
        <td class="cuadro02"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">PROMEDIO PORCENTUAL SUBSECTORES HIJOS </font></div></td>
        <td rowspan="2" class="cuadro02"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">PROMEDIO PARA SUBSECTOR PADRE </font></div></td>
      </tr>
      <tr>
        <td>
		
		
		<!-- Aqui van las iniciales del subsector hijo  -->		
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr class="cuadro01">
		    <?
            $qry1="";
			$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
			$Rs_Hijo = @pg_exec($conn,$qry1);
			for($i=0;$i<@pg_numrows($Rs_Hijo);$i++){
				$fils = @pg_fetch_array($Rs_Hijo,$i);
				$Subsector[$i] = $fils['id_ramo'];
				$porcentaje    = $fils['porcentaje'];
				$Truncado[$i] = $fils['truncado'];
				?>
				<td width="<?php echo  round(100/@pg_numrows($Rs_Hijo)) ?>"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;
				        <?				
				echo $fils['nombre'];
				echo "&nbsp;";
				echo $fils['porcentaje'];
				echo "%";	
			    ?>
				  </font>
				  </div></td>
				<?
			}	
	        ?>		    
          </tr>
        </table>		
		<!-- fin nombres subsectores hijos -->
		
				
		
		</td>
        </tr>
	  <? 
	  //---------------- SELECCIONA TODOS LOS ALUMNOS DEL CURSO------------------
	  $qryalum="";
	  $qryalum = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE (tiene$nro_ano.id_ramo)=".trim($id_ramo)."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
	  $Rs_alum = @pg_exec($conn,$qryalum);
	
	  // empiezo ciclo para desplegar a los alumnos
	  $variable = @pg_numrows($Rs_alum);
	  	  
	  for($i=0;$i<@pg_numrows($Rs_alum);$i++){
  		 $fila_alum = @pg_fetch_array($Rs_alum,$i);
		 $rut_alumno = $fila_alum['rut_alumno'];
		 $cpan=0;
		   
         ?>	
         <tr>
         <td><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;<? echo $fila_alum['ape_pat']." " .$fila_alum['ape_mat'].", ".$fila_alum['nombre_alu'];?></font></td>
         <td>
		 
		 
		  <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
            <?
            $qry1="";
			$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
			$Rs_Hijo = @pg_exec($conn,$qry1);
			$progeneral = 0;
			for($ii=0;$ii<@pg_numrows($Rs_Hijo);$ii++){
				$fils = @pg_fetch_array($Rs_Hijo,$ii);
				$id_ramo         = $fils['id_ramo'];
				$porcentaje      = $fils['porcentaje'];
				$Truncado[$ii]   = $fils['truncado'];
				$SumaExamen=0;
				$PromPeriodo=0;
				
				$sql = "SELECT porc_examen FROM ramo WHERE id_ramo='".trim($id_ramo)."'";
				$Rs_examen = @pg_exec($conn,$sql);
				$fila_porc = @pg_fetch_array($Rs_examen,0);

				$qrynotas  = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($periodos)."'";
				$resnotas  = @pg_Exec($conn,$qrynotas);
				$filanotas = @pg_fetch_array($resnotas);
				
				if($fila_porc['porc_examen']==100){
					$promedio  = $filanotas['promedio'];
				}else{
					$sql = "SELECT * FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo='".trim($id_ramo)."'";
					$rs_curso = @pg_exec($conn,$sql);
					
					for($x=0;$x<@pg_numrows($rs_curso);$x++){
						$fila_ex=@pg_fetch_array($rs_curso,$x);
						$Porc_Examen = 0;
						$sql = "SELECT nota FROM notas_examen WHERE id_examen=".$fila_ex['id_examen']." AND id_curso=".$curso." AND id_ano=".$ano." AND periodo=".$cmbPERIODO." AND id_ramo='".trim($id_ramo)."' AND rut_alumno=".trim($rut_alumno);
						$rs_notas_alu = @pg_exec($conn,$sql);
						$Notas_alu = @pg_result($rs_notas_alu,0);
						$Porc_Examen = ($Notas_alu * $fila_ex['porc'])/100;
						$SumaExamen = $SumaExamen + $Porc_Examen;
					}
						if($SumaExamen==0){
							$PromPeriodo=$filanotas['promedio'];
						}else{
							$PromPeriodo = ($filanotas['promedio'] * $fila_porc['porc_examen'])/100;
							$PromPeriodo = $PromPeriodo + $SumaExamen;
						}
						if($fila_ex['bool_ap']==1){
							$promedio = round($PromPeriodo);
						}else{
							$promedio=abs($PromPeriodo);
						}
					
				}	
															
				
				//if($institucion==24995){
					if($_POST['calc_arm']==1){
					$promedio=$filanotas['promedio'];
				}else{
					$promedio = ($promedio * $porcentaje)/100;
				}
								
				?>
				<td width="<?php echo  round(100/@pg_numrows($Rs_Hijo)) ?>"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;
				<?			
				if ($promedio<10){
				   if ($promedio==0){
				      /// no muestro nada
				   }else{	  
				       echo "0$promedio";
				   }
				}else{
				   echo $promedio;
				   $cpan++;
				}      	
			    ?>
				  </font>
				  </div></td>
				<?
				
				
				$progeneral = $progeneral + $promedio;
				
				
			}
			if($_POST['calc_arm']==1){
			//if($institucion==24995){ 
				$progeneral=$progeneral/$cpan;
			}
			if($fila_ramo['truncado']==1) $progeneral=round($progeneral); else $progeneral=intval($progeneral);
			$progeneral = round($progeneral);
			
				
	        ?>		
            </tr>
          </table>	
		  
		  
		  	  
		   
		 </td>
		 <?
           /* $qry1="";
			$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
			$Rs_Hijo = @pg_exec($conn,$qry1);
			$progeneral = 0;
			for($ii=0;$ii<@pg_numrows($Rs_Hijo);$ii++){
				$fils = @pg_fetch_array($Rs_Hijo,$ii);
				$id_ramo         = $fils['id_ramo'];
				$porcentaje      = $fils['porcentaje'];
				$Truncado[$ii]   = $fils['truncado'];
				
				$qrynotas  = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($periodos)."'";
				$resnotas  = @pg_Exec($conn,$qrynotas);
				$filanotas = @pg_fetch_array($resnotas);
				$promedio  = $filanotas['promedio'];
				
				$promedio = round(($promedio * $porcentaje)/100);
				
				$progeneral = $progeneral + $promedio;
			 }	*/
								
			 ?>
             <td><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;
			    <?
				if ($progeneral==0){
				    // no muestro nada
				}else{
				    echo $progeneral;
				}	
			    ?>				
				</font></div></td>
         </tr>
		 <?
	 }
	 ?>
    </table>
	
	<!--
      <br>
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" rowspan="2">ALUMNOS</td>
          <?
		
		for ($a=0; $a < 20; $a++){ ?>	     
        
        <td colspan="<?=$n11 + 1 ?>" ><div align="center">NOTA 
          <?=$a + 1 ?> 
          </div></td>
        <? } ?>
        </tr>
      <tr>
        <?
		for ($a=0; $a < 20; $a++){ 	
		     for($i=0;$i<@pg_numrows($Rs_Hijo);$i++){
  				$fila_hijo = @pg_fetch_array($Rs_Hijo,$i)?>			      
        
        <td>
          <div align="center" class="Estilo1">
            <?
				 	 echo InicialesSubsector($fila_hijo['nombre']);		 
				      ?>				 
            </div></td>
            <? } ?>    
        <td bgcolor="#CCCCCC"><div align="center" class="Estilo1">PM</div></td>
        <? } ?>	
        </tr>
      <? for($i=0;$i<@pg_numrows($Rs_alum);$i++){
  		    $fila_alum = @pg_fetch_array($Rs_alum,$i);
			$rut_alumno = $fila_alum['rut_alumno'];
		   
            ?>
      
      <tr>
        <td><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $fila_alum['ape_pat']." " .$fila_alum['ape_mat'].", ".$fila_alum['nombre_alu'];?></font></td>
              <?
		
	  	    for ($a=0; $a < 20; $a++){ 
			    $notas = 0; $contador = 0;  $promedio=" ";
		        for($j=0;$j<@pg_numrows($Rs_Hijo);$j++){
  				     $fila_hijo  = @pg_fetch_array($Rs_Hijo,$j);
					 $id_ramo    = $fila_hijo['id_ramo'];
					 $porcentaje = $fila_hijo['porcentaje'];
					 
					 $q1 = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_periodo = '".trim($cmbPERIODO)."' and id_ramo = '".trim($id_ramo)."'";
					 $r1 = @pg_Exec($conn,$q1);
					 $f1 = @pg_fetch_array($r1,0);
					 $campo = $a + 1;
					 $nota = $f1['nota'.$campo];
					 
					 $nota = round(($nota * $porcentaje) / 100); 
					 
					 ?>		
        
        <td>
          <?
					 if (($nota!=0) AND ($nota!=NULL)){
					     
						 $notas = $notas + $nota;
						 $contador++;
					
					      ?>					
          <div align="center" class="Estilo1"><?=$nota ?></div>
				     <? }else{ ?>
          &nbsp; 				   
          <? } ?>			   
          
          </td>
               <? }
			    // Aquí saco el promedio
				if ($contador!=0){				
				    //$promedio = round($notas / $contador);
					$promedio = $notas;			 
			    }
			    ?>    
        <td bgcolor="#CCCCCC"><div align="center" class="Estilo1"><?=$promedio ?></div></td>
            <? } ?>	
        </tr>
      <? } ?>
      
    </table>
	dfgdfgdfg
	-->
	
	
	
	</td></tr>
</table>
</form>
<br>
<? } ?>	
<? if ($modo==3){  ?>
<br>
<form name="form" method="post" action="procesoFormulaSub.php3">
<input name="modo" type="hidden" value="3">
<input name="periodo" type="hidden" value="<?=$periodos ?>">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="599" colspan="3"><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nombre_instit']); ?></strong></FONT></TD>
        </TR>
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO 
            ESCOLAR</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nro_ano']); ?></strong></FONT></TD>
        </TR>
        <TR> 
          <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
          <TD><FONT face="arial, geneva, helvetica" size=2><strong> 
            <?php
											if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "PRIMER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==121987) or ($fCurso['cod_decreto']==1521989)) ){
												echo "PRIMER CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==2) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "SEGUNDO NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==2) and ($fCurso['cod_decreto']==121987) ){
												echo "SEGUNDO CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else if ( ($fCurso['grado_curso']==3) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
												echo "TERCER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											
											}else{
												echo $fCurso['grado_curso']." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
											}
								?>
            </strong> </FONT> </TD>
        </TR>
      </TABLE></td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font size="2" face="arial, geneva, helvetica">PERIODO</font> <select name="cmbPERIODO" onChange="enviapag(this.form)">
        <?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$periodos){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};																																																																																																																															
									?>
      </Select></td>
  </tr>
  
  <tr>
    <td colspan="3" align="right">
	<INPUT class="botonXX"  TYPE="submit" value="AGREGAR"> 
	<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3">	</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td rowspan="2" class="cuadro02"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">ALUMNOS</font></div></td>
        <td class="cuadro02"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">PROMEDIO  SUBSECTORES HIJOS </font></div></td>
        <td rowspan="2" class="cuadro02"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">PROMEDIO PARA SUBSECTOR PADRE </font></div></td>
      </tr>
      <tr>
        <td>
		
		
		<!-- Aqui van las iniciales del subsector hijo  -->		
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr class="cuadro01">
		    <?
            $qry1="";
			$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
			$Rs_Hijo = @pg_exec($conn,$qry1);
			for($i=0;$i<@pg_numrows($Rs_Hijo);$i++){
				$fils = @pg_fetch_array($Rs_Hijo,$i);
				$Subsector[$i] = $fils['id_ramo'];
				$porcentaje    = $fils['porcentaje'];
				$Truncado[$i] = $fils['truncado'];
				?>
				<td width="<?php echo  round(100/@pg_numrows($Rs_Hijo)) ?>"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;
				        <?				
				echo $fils['nombre'];
				echo "&nbsp;";
				/*echo $fils['porcentaje'];
				echo "%";	*/
			    ?>
				  </font></div></td>
				<?
			}	
	        ?>		    
          </tr>
        </table>		
		<!-- fin nombres subsectores hijos -->
		
				
		
		</td>
        </tr>
	  <? 
	  //---------------- SELECCIONA TODOS LOS ALUMNOS DEL CURSO------------------
	  $qryalum="";
	  $qryalum = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE (tiene$nro_ano.id_ramo)=".trim($id_ramo)."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
	  $Rs_alum = @pg_exec($conn,$qryalum);
	
	  // empiezo ciclo para desplegar a los alumnos
	  $variable = @pg_numrows($Rs_alum);
	  	  
	  for($i=0;$i<@pg_numrows($Rs_alum);$i++){
  		 $fila_alum = @pg_fetch_array($Rs_alum,$i);
		 $rut_alumno = $fila_alum['rut_alumno'];
		 $cpan=0;
		   
         ?>	
         <tr>
         <td><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;<? echo $fila_alum['ape_pat']." " .$fila_alum['ape_mat'].", ".$fila_alum['nombre_alu'];?></font></td>
         <td>
		 
		 
		  <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
            <?
            $qry1="";
			$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
			$Rs_Hijo = @pg_exec($conn,$qry1);
			$progeneral = 0;
			for($ii=0;$ii<@pg_numrows($Rs_Hijo);$ii++){
				$fils = @pg_fetch_array($Rs_Hijo,$ii);
				$id_ramo         = $fils['id_ramo'];
				$porcentaje      = $fils['porcentaje'];
				$Truncado[$ii]   = $fils['truncado'];
				$SumaExamen=0;
				$PromPeriodo=0;
				
				$sql = "SELECT porc_examen FROM ramo WHERE id_ramo='".trim($id_ramo)."'";
				$Rs_examen = @pg_exec($conn,$sql);
				$fila_porc = @pg_fetch_array($Rs_examen,0);

				$qrynotas  = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($periodos)."'";
				$resnotas  = @pg_Exec($conn,$qrynotas);
				$filanotas = @pg_fetch_array($resnotas);
				
				if($fila_porc['porc_examen']==100){
					$promedio  = $filanotas['promedio'];
				}else{
					$sql = "SELECT * FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo='".trim($id_ramo)."'";
					$rs_curso = @pg_exec($conn,$sql);
					
					for($x=0;$x<@pg_numrows($rs_curso);$x++){
						$fila_ex=@pg_fetch_array($rs_curso,$x);
						$Porc_Examen = 0;
						$sql = "SELECT nota FROM notas_examen WHERE id_examen=".$fila_ex['id_examen']." AND id_curso=".$curso." AND id_ano=".$ano." AND periodo=".$cmbPERIODO." AND id_ramo='".trim($id_ramo)."' AND rut_alumno=".trim($rut_alumno);
						$rs_notas_alu = @pg_exec($conn,$sql);
						$Notas_alu = @pg_result($rs_notas_alu,0);
						$Porc_Examen = ($Notas_alu * $fila_ex['porc'])/100;
						$SumaExamen = $SumaExamen + $Porc_Examen;
					}
						if($SumaExamen==0){
							$PromPeriodo=$filanotas['promedio'];
						}else{
							$PromPeriodo = ($filanotas['promedio'] * $fila_porc['porc_examen'])/100;
							$PromPeriodo = $PromPeriodo + $SumaExamen;
						}
						if($fila_ex['bool_ap']==1){
							$promedio = round($PromPeriodo);
						}else{
							$promedio=abs($PromPeriodo);
						}
					
				}	
															
				
				//if($institucion==24995){
					//if($_POST['calc_arm']==1){
					$promedio=$filanotas['promedio'];
				/*}else{
					$promedio = ($promedio * $porcentaje)/100;
				}*/
								
				?>
				<td width="<?php echo round(100/@pg_numrows($Rs_Hijo)) ?>"><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;
				<?			
				if ($promedio<10){
				   if ($promedio==0){
				      /// no muestro nada
				   }
				}else{
				   echo $promedio;
				}      	
			    ?></font>
				  </div></td>
				<?
				
				if ($promedio>0){
				 $progeneral = $progeneral + $promedio;
				  $cpan++;
				}
				
			}
			
				$progeneral=$progeneral/$cpan;
			
			if($fila_ramo['truncado']==1) $progeneral=round($progeneral); else $progeneral=intval($progeneral);
			$progeneral = round($progeneral);
			
				
	        ?>		
            </tr>
          </table>	
		  
		  
		  	  
		   
		 </td>
		 <?
           /* $qry1="";
			$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
			$Rs_Hijo = @pg_exec($conn,$qry1);
			$progeneral = 0;
			for($ii=0;$ii<@pg_numrows($Rs_Hijo);$ii++){
				$fils = @pg_fetch_array($Rs_Hijo,$ii);
				$id_ramo         = $fils['id_ramo'];
				$porcentaje      = $fils['porcentaje'];
				$Truncado[$ii]   = $fils['truncado'];
				
				$qrynotas  = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($periodos)."'";
				$resnotas  = @pg_Exec($conn,$qrynotas);
				$filanotas = @pg_fetch_array($resnotas);
				$promedio  = $filanotas['promedio'];
				
				$promedio = round(($promedio * $porcentaje)/100);
				
				$progeneral = $progeneral + $promedio;
			 }	*/
								
			 ?>
             <td><div align="center"><font face="arial, geneva, helvetica" style="font-size:9px">&nbsp;
			    <?
				if ($progeneral==0){
				    // no muestro nada
				}else{
				    echo $progeneral;
				}	
			    ?>				
				</font></div></td>
         </tr>
		 <?
	 }
	 ?>
    </table>
	
	<!--
      <br>
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" rowspan="2">ALUMNOS</td>
          <?
		
		for ($a=0; $a < 20; $a++){ ?>	     
        
        <td colspan="<?=$n11 + 1 ?>" ><div align="center">NOTA 
          <?=$a + 1 ?> 
          </div></td>
        <? } ?>
        </tr>
      <tr>
        <?
		for ($a=0; $a < 20; $a++){ 	
		     for($i=0;$i<@pg_numrows($Rs_Hijo);$i++){
  				$fila_hijo = @pg_fetch_array($Rs_Hijo,$i)?>			      
        
        <td>
          <div align="center" class="Estilo1">
            <?
				 	 echo InicialesSubsector($fila_hijo['nombre']);		 
				      ?>				 
            </div></td>
            <? } ?>    
        <td bgcolor="#CCCCCC"><div align="center" class="Estilo1">PM</div></td>
        <? } ?>	
        </tr>
      <? for($i=0;$i<@pg_numrows($Rs_alum);$i++){
  		    $fila_alum = @pg_fetch_array($Rs_alum,$i);
			$rut_alumno = $fila_alum['rut_alumno'];
		   
            ?>
      
      <tr>
        <td><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $fila_alum['ape_pat']." " .$fila_alum['ape_mat'].", ".$fila_alum['nombre_alu'];?></font></td>
              <?
		
	  	    for ($a=0; $a < 20; $a++){ 
			    $notas = 0; $contador = 0;  $promedio=" ";
		        for($j=0;$j<@pg_numrows($Rs_Hijo);$j++){
  				     $fila_hijo  = @pg_fetch_array($Rs_Hijo,$j);
					 $id_ramo    = $fila_hijo['id_ramo'];
					 $porcentaje = $fila_hijo['porcentaje'];
					 
					 $q1 = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_periodo = '".trim($cmbPERIODO)."' and id_ramo = '".trim($id_ramo)."'";
					 $r1 = @pg_Exec($conn,$q1);
					 $f1 = @pg_fetch_array($r1,0);
					 $campo = $a + 1;
					 $nota = $f1['nota'.$campo];
					 
					 $nota = round(($nota * $porcentaje) / 100); 
					 
					 ?>		
        
        <td>
          <?
					 if (($nota!=0) AND ($nota!=NULL)){
					     
						 $notas = $notas + $nota;
						 $contador++;
					
					      ?>					
          <div align="center" class="Estilo1"><?=$nota ?></div>
				     <? }else{ ?>
          &nbsp; 				   
          <? } ?>			   
          
          </td>
               <? }
			    // Aquí saco el promedio
				if ($contador!=0){				
				    //$promedio = round($notas / $contador);
					$promedio = $notas;			 
			    }
			    ?>    
        <td bgcolor="#CCCCCC"><div align="center" class="Estilo1"><?=$promedio ?></div></td>
            <? } ?>	
        </tr>
      <? } ?>
      
    </table>
	dfgdfgdfg
	-->
	
	
	
	</td></tr>
</table>
</form>
<br>
<? } ?>	


					  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

<?php require('../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="modificar";
	$rut_apo = $_GET['rut_apo'];

	
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO='".$alumno."'";
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
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.nombres,'Ingresar NOMBRES.')){
						return false;
					};
								
				if(!chkSelect(form.Region,'Seleccionar REGION.')){
						return false;
					};		
					
				if(isNaN(form.Provincia.value)){
					alert("Seleccione Provincia");
					return false;
					}	
					
				if(isNaN(form.Comuna.value)){
					alert("Seleccione Comuna");
					return false;
					}		
			}
			
//**********************************************************************************************************//
//-------------------------------------- CARGA ARREGLO PROVINCIA, COMUNA -----------------------------------//
//**********************************************************************************************************//
        //------------------------ PROVINCIA -----------------------------------//
                var ArrayProvincia = new Array();
                var contador_provincia;
                <?php        $SQL = "SELECT cor_pro,cod_reg,nom_pro FROM provincia ORDER BY nom_pro";
                                $Conexion = @pg_exec($conn,$SQL);
                                $i=0;
                                if (!$Conexion)
                                {
                                        echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 1 </b></td></tr></table></center>");
                                        exit();
                                }
                                if (@pg_numrows($Conexion)!=0)
                                { 
                                        $filsprov = @pg_fetch_array($Conexion,0);
                                        for ($i=0;$i<@pg_numrows($Conexion);$i++)
                                        {
                                                $filsprov = @pg_fetch_array($Conexion,$i); ?>
                                                var ArrayFilProv = new Array(3);
                                                ArrayFilProv[0] = '<?php echo Trim($filsprov["cor_pro"])?>';
                                                ArrayFilProv[1] = '<?php echo Trim($filsprov["cod_reg"])?>';
                                                ArrayFilProv[2] = '<?php echo Trim($filsprov["nom_pro"])?>';
                                                ArrayProvincia[<?php echo $i?>] = ArrayFilProv;
                <?php                }
                                }
                                @pg_close($Conexion); ?>
                                contador_provincia = <?php echo $i?>;
        //---------------------- FIN PROVINCIA ---------------------------------//

        //-------------------------- COMUNA ------------------------------------//
                var ArrayComuna = new Array();
                var contador_comuna;
                <?php        $SQL = "SELECT cor_com,cor_pro,cod_reg,nom_com FROM comuna ORDER BY nom_com";
                                $Conexion = @pg_exec($conn,$SQL);
                                $i=0;
                                if (!$Conexion){
                                        echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 2 </b></td></tr></table></center>");
                                        exit();
                                };
                                if (@pg_numrows($Conexion)!=0){
                                        $filscom = @pg_fetch_array($Conexion,0);
                                        for ($i=0;$i<@pg_numrows($Conexion);$i++){
                                                $filscom = @pg_fetch_array($Conexion,$i); ?>
                                                var ArrayFilCom = new Array(4);
                                                ArrayFilCom[0] = '<?php echo Trim($filscom["cor_com"])?>';
                                                ArrayFilCom[1] = '<?php echo Trim($filscom["cor_pro"])?>';
                                                ArrayFilCom[2] = '<?php echo Trim($filscom["cod_reg"])?>';
                                                ArrayFilCom[3] = '<?php echo Trim($filscom["nom_com"])?>';
                                                ArrayComuna[<?php echo $i?>] = ArrayFilCom;
                <?php                };
                                };
                                @pg_close($Conexion); ?>
                                contador_comuna = <?php echo $i; ?>;

        //----------------------- FIN COMUNA -----------------------------------//

//**********************************************************************************************************//
//-------------------------------------------- FIN ARREGLOS ------------------------------------------------//
//**********************************************************************************************************//

//**********************************************************************************************************//
//-------------------------------------------- LLENA COMBO -------------------------------------------------//
//**********************************************************************************************************//

        //----------------------- PROVINCIA-----------------------------------//
function LlenaProvincia(){
        var id_search;
        if (document.frm.Region.options.selectedIndex!=-1 || document.frm.Region.options[document.frm.Region.options.selectedIndex].value!="null"){
                id_search = document.frm.Region.options[document.frm.Region.options.selectedIndex].value;
                if (id_search!=""){
                        document.frm.Provincia.length = 0;
                        document.frm.Provincia.options[document.frm.Provincia.options.length++] = new Option("Seleccionar Provincia");
                        document.frm.Provincia.options[document.frm.Provincia.options.length - 1].value = "null";
                        document.frm.Comuna.length = 0;
                        document.frm.Comuna.options[document.frm.Comuna.options.length++] = new Option("Seleccionar Comuna");
                        document.frm.Comuna.options[document.frm.Comuna.options.length - 1].value = "null";
                        for(i=0;i<=contador_provincia-1;i++){
                                if (id_search==ArrayProvincia[i][1]){
                                        document.frm.Provincia.options[document.frm.Provincia.options.length++] = new Option(ArrayProvincia[i][2]);
                                        document.frm.Provincia.options[document.frm.Provincia.options.length - 1].value = ArrayProvincia[i][0];
                                };
                        };
                };
        };
};
        //--------------------- FIN PROVINCIA---------------------------------//

        //------------------------- COMUNA ------------------------------------//
                function LlenaComuna(){
                        var id_search,id_search_aux;
                        if (document.frm.Provincia.options.selectedIndex!=-1 || document.frm.Provincia.options[document.frm.Provincia.options.selectedIndex].value!="null"){
                                id_search = document.frm.Region.options[document.frm.Region.options.selectedIndex].value; 
                                id_search_aux = document.frm.Provincia.options[document.frm.Provincia.options.selectedIndex].value;
                                if (id_search!=""){
                                        document.frm.Comuna.length = 0;
                                        document.frm.Comuna.options[document.frm.Comuna.options.length++] = new Option("Seleccionar Comuna");
                                        document.frm.Comuna.options[document.frm.Comuna.options.length - 1].value = "null";
                                        for(i=0;i<=contador_comuna-1;i++){
                                                if (id_search==ArrayComuna[i][2] && id_search_aux==ArrayComuna[i][1]){
                                                        document.frm.Comuna.options[document.frm.Comuna.options.length++] = new Option(ArrayComuna[i][3]);
                                                        document.frm.Comuna.options[document.frm.Comuna.options.length - 1].value = ArrayComuna[i][0];
                                                };
                                        };
                                };
                        };
                };
        //----------------------- FIN COMUNA -----------------------------------//

//**********************************************************************************************************//
//----------------------------------------- FIN LLENA COMBO ------------------------------------------------//
//**********************************************************************************************************//
  function SeleccionaCombo(Objeto, valor)
  	{
		
		for (i=0;i < Objeto.options.length; i ++) 
		{
		
			if (Objeto.options[i].value == valor)
			{
		
				Objeto.options[i].selected = true; 
			}
		}
	}

</script>
<? 

	 $str_Set_E = "{";

        if ($fila['region']!=""){
                $str_Set_E = $str_Set_E . "SeleccionaCombo(document.frm.Region,".$fila['region'].");";
                $str_Set_E = $str_Set_E . "LlenaProvincia();";
        };
        if ($fila['ciudad']!=""){
                $str_Set_E = $str_Set_E . "SeleccionaCombo(document.frm.Provincia,".$fila['ciudad'].");";
                $str_Set_E = $str_Set_E . "LlenaComuna();";
        };
        if ($fila['comuna']!=""){
                $str_Set_E = $str_Set_E . "SeleccionaCombo(document.frm.Comuna,".$fila['comuna'].");";
        };

        $str_Set_E = $str_Set_E . "}";
?>
        
        
<?php }?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>            <table width="100%"><tr><td>&nbsp;</td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
								  
								  
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
	<center>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=650>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
							<td rowspan=4>
								<TABLE BORDER=3 CELLSPACING=5 CELLPADDING=5>
									<TR>
										<TD>
											<?php
												$sql_arr = "select * from alumno where rut_alumno= '$alumno'";
												$result = pg_Exec($conn,$sql_arr);												
												$arr=pg_fetch_array($result);
																								/*
 												$output= "select lo_export('/opt/www/newsae/infousuario/images/".$arr[rut_alumno]."');";
												$retrieve_result = @pg_exec($conn,$output);
												$retrieve_result;
											if (!$retrieve_result){ */												
												$nombre_archivo = '../infousuario/images/'.$arr[rut_alumno];																																		 

												if (file_exists($nombre_archivo)) {?>
												   <img src="../infousuario/images/<?php echo $arr[rut_alumno]?>" ALT="NO DISPONIBLE" width=150></p>
											<?	} else { ?>
												   <img src="apoderado/imag/alumno.gif" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO">
											<?	}?>
	
										</TD>
									</TR>
								</TABLE>
							</td>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
						 	// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
							// ---------------------------------------------------------------------
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													$tipo=$fila1['cod_tipo'];
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
													
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
					<br>
					<table width="650" border="0" cellpadding="1" cellspacing="1">
 					 	<TR height=20>
							<TD class="tableindex" align="center">
							FICHA APODERADOS
							</TD>
 						</TR>
					</table><br>
					<?
			
 $sqlApoderado="select apoderado.*, tiene2.*, region.nom_reg, provincia.nom_pro, comuna.nom_com from apoderado, tiene2, region, comuna, provincia where apoderado.rut_apo='".$rut_apo."' and tiene2.rut_alumno = '".$alumno."' and apoderado.rut_apo = tiene2.rut_apo
and comuna.cod_reg = apoderado.region and comuna.cor_com = apoderado.comuna and comuna.cor_pro = apoderado.ciudad 
and region.cod_reg = apoderado.region and provincia.cod_reg = apoderado.region and provincia.cor_pro = apoderado.ciudad ";
					$rsApoderado = @pg_Exec($conn,$sqlApoderado);
							
					for($x=0 ; $x < @pg_numrows($rsApoderado) ; $x++){
						$fApoderado = @pg_fetch_array($rsApoderado,$x);
						$sqlFoto= "select lo_export(".$fApoderado[foto].",'/opt/www/coeint/tmp/".chop($fApoderado['rut_apo'])."');";
						$rsFoto = @pg_exec($conn,$sqlFoto);
						
						
						//-------
						$nombres = strtoupper($fApoderado['nombre_apo']);
					    $ape_pat = trim(strtoupper($fApoderado['ape_pat']));
						$ape_mat= trim(strtoupper($fApoderado['ape_mat']));
						$rut_apod = strtoupper($fApoderado['rut_apo'])."-".strtoupper($fApoderado['dig_rut']);
						$direccion = trim(strtoupper($fApoderado['calle']));
						$numero    = trim(strtoupper($fApoderado['nro']));
						$comuna = trim(strtoupper($fApoderado['nom_com']));
						$region = trim(strtoupper($fApoderado['nom_reg']));
						$ciudad = trim(strtoupper($fApoderado['nom_pro']));						
						$email = trim(strtoupper($fApoderado['email']));
						$telefono = trim(strtoupper($fApoderado['telefono']));
						$celular = trim(strtoupper($fApoderado['celular']));
						$nivel_edu = trim(strtoupper($fApoderado['nivel_edu']));
						$profesion = trim(strtoupper($fApoderado['profesion']));
						$lugar_trabajo = trim(strtoupper($fApoderado['lugar_trabajo']));
						$cargo= trim(strtoupper($fApoderado['cargo']));
						if ($fApoderado['relacion']==1) $relacion = "PADRE";
						if ($fApoderado['relacion']==2) $relacion = "MADRE";
						if ($fApoderado['relacion']==3) $relacion = "OTROS";
						if ($fApoderado['sostenedor']>0) $sostenedor = "SI"; else 	$sostenedor = "NO";
						if ($fApoderado['responsable']>0) $responsable = "Y RESPONSABLE"; else $responsable  = "";
						//-------
						if (empty($nombres))  $nombres = "&nbsp;";
						if (empty($apellidos))  $apellidos = "&nbsp;";
						if (empty($direccion))  $direccion = "&nbsp;";
						if (empty($comuna))  $comuna = "&nbsp;";
						if (empty($region))  $region = "&nbsp;";																								
						if (empty($ciudad))  $ciudad = "&nbsp;";																														
						if (empty($email))  $email = "&nbsp;";																														
						if (empty($telefono))  $telefono= "&nbsp;";
						if (empty($celular))  $celular = "&nbsp;";												
						if (empty($nivel_edu))  $nivel_edu = "&nbsp;";												
						if (empty($profesion))  $profesion = "&nbsp;";												
						if (empty($lugar_trabajo))  $lugar_trabajo = "&nbsp;";												
						if (empty($cargo))  $cargo = "&nbsp;";	
																																					
					?>
                   
					<table width="650" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
					  <tr>
						<td colspan="4" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>DATOS - <? echo $relacion." ".$responsable ?></strong></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       
                        </td>
					  </tr>
					  <tr><td>
                       <form method="post" name="frm" id="frm" action="guarda_apoderado.php">
                       <input type="hidden" value="<?=$rut_apo?>" name="rut_apo" id="id_apo">
					  <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
					  <tr>
						<td  rowspan="14" align="left" valign="top">
						<? if ($rsFoto){ ?>
                        <img src="../../../../../../../tmp/<? echo chop($fApoderado['rut_apo'])?>" alt="NO DISPONIBLE"  width=110>                        
						<? } ?>
						</td>
                        
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nombres</strong></font></td>							
						<td class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">
						<? if($frmModo=="mostrar"){
						echo $nombres?></font><? }
						
                        if($frmModo=="modificar"){?>
                        <input type="text" name="nombres" id="nombres" value="<?=trim($nombres)?>">
                        <? }?>
                        </td>
					    <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nivel Educacional</strong></font></td>
					    <td align="left"><input type="text" name="nivel_edu" value="<?=$nivel_edu?>"></td>
					  </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Apellido Paterno</strong></font></td>
						<td><input type="text" name="apellido_pat" value="<?=$ape_pat?>">
                        </td>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Apellido Materno</strong></font></td>
						<td><input type="text" name="apellido_mat" value="<?=$ape_mat?>">
                        </td>
					  </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Tel&eacute;fono</strong></font></td>
						<td><input type="text" name="telefono" value="<?=$telefono?>">
                        </td>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Celular</strong></font></td>
						<td><input type="text" name="celular" value="<?=$celular?>">
                        </td>
					  </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Direcci&oacute;n</strong></font></td>
						<td><input type="text" name="direccion" value="<?=$direccion?>">
                        </td>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>N&deg;</strong></font></td>
						<td>
                        <?php if($frmModo=="modificar"){ ?>
						<input type="text" name="numero" value="<?=$numero?>">
                     <?  };
					 	?>								
                        </td>
					  </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Regi&oacute;n</strong></font></td>						<td><!-- sacar nombre de region -->
	<?php if($frmModo=="modificar"){ ?>
			<select name="Region" id="Region" class="ingreso2" onChange="javascript:LlenaProvincia();"  >
				<option value="0" selected="selected">Seleccione Region</option>
				<?php 
					$sql = "SELECT cod_reg,nom_reg FROM region ORDER BY cod_reg";
					$Rs_Region= pg_exec($conn,$sql);
					for($i=0 ; $i < pg_numrows($Rs_Region) ; $i++){
						$fila = pg_fetch_array($Rs_Region,$i);
						if ($fila["cod_reg"]==$cod_reg){
							echo  "<option selected value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
							
						}else{
							echo  "<option value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
						}
					}
					?>
			</select>	
    <?php }
				;?>
    
	
                        </td>
					    <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Sostenedor</strong></font></td>
					    <td> 
                        <input type="checkbox" name="chkSOS" value="1">
					  
                        </td>
					  </tr>
					  <tr>
					    <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Provincia</strong></font></td>
					    <td><?
                        if ($frmModo=="modificar"){ 
	        $qryPRO		= "SELECT * FROM PROVINCIA WHERE COD_REG='".$cod_reg."'";
			   $resultPRO	= @pg_Exec($conn,$qryPRO);
			   $numPRO      = @pg_numrows($resultPRO);
			   ?>
			   <select name="Provincia" id="Provincia" class="ingreso2" onChange="javascript:LlenaComuna();">
			   <? 
			   for ($p=0; $p < $numPRO; $p++){
		            $filaPRO = @pg_fetch_array($resultPRO,$p);
					$cod_prov =  $filaPRO['cor_pro'];
					$nom_pro =  $filaPRO['nom_pro'];
					?>
					<option value="<?=$cod_prov?>" <? if ($cod_prov==$cod_pro){ ?> selected="selected" <? } ?>><?=$nom_pro?></option>
					<?		   
			   }
			   ?>
			   </select>
			   <? 
		  
		 }
		?> 
                        </td>
					    <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Profesi&oacute;n</strong></font></td>
					    <td align="left" valign="top"><input type="text" name="profesion" value="<?=$profesion?>"></td>
				      </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Comuna</strong></font></td>				<td><?
						if ($frmModo=="modificar"){ 
                	  $qryCOM		= "SELECT * FROM COMUNA WHERE COD_REG='".$cod_reg."' AND COR_PRO='".$cod_pro."'";
			$resultCOM	= @pg_Exec($conn,$qryCOM);
			$numCOM     = @pg_numrows($resultCOM);
			?>
			<select name="Comuna" id="Comuna" class="ingreso2">			
			    <?
				for ($c=0; $c < $numCOM; $c++){
				   $filaCOM = @pg_fetch_array($resultCOM,$c);
				   $nom_com = $filaCOM['nom_com'];
				   $cor_com = $filaCOM['cor_com']; 
				   ?>
				   <option value="<?=$cor_com?>" <? if ($cod_com==$cor_com){ ?> selected="selected" <? } ?> ><?=$nom_com?></option>
				   <?
				
				}   
			?>
			</select>
			<?
    
	 }
	  ?>  
	          
                </td>
					    <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Cargo</strong></font></td>
					    <td align="left" valign="top"><input type="text" name="cargo" value="<?=$cargo?>"></td>
					  </tr>
					  <tr>
					    <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Lugar de Trabajo </strong></font></td>
					    <td align="left" valign="top"><input type="text" name="lugar_trabajo" value="<?=$lugar_trabajo?>"> </td>
                        
                        <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Email </strong></font></td>
                        <td><input type="text" name="email" value="<?=$email?>"></td>
                      </tr>
                      <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Relaci&oacute;n</strong></font></td>
        <td>
        <?php if($frmModo=="modificar"){ ?>
        <Select name="cmbRELACION">
        <option value=0></option>
        <option value=1 <?php echo ($fApoderado['relacion'])==1?"selected":"" ?>>Padre</option>
        <option value=2 <?php echo ($fApoderado['relacion'])==2?"selected":"" ?>>Madre</option>
        <option value=3 <?php echo ($fApoderado['relacion'])==3?"selected":"" ?>>Otro</option>
        </Select>
        <?php };?>								
        </td>
        </tr>
                      <tr><td></td><td></td><td><input align="right" class="botonXX"  name="modificar" type="submit" value="GUARDAR"  onClick= "return valida(this.form)"></td>
                      <td>
        <input align="right" class="botonXX"  name="volver" type="button" value="volver" onClick="javascript:history.back(1)" ></td>
                     
                      </tr>
					  </table>
                      </form>
					</td></tr>
					</table>
					<br>
				<? 
					
				} 
				?>	
				<?
				$sql_hermanos = "select hermanos.* from hermanos, relacion_hermanos where relacion_hermanos.rut_alumno = '$alumno' and hermanos.rut_hermano = hermanos.rut_hermano";
				$rsHermanos = @pg_Exec($conn,$sql_hermanos);
				if (@pg_numrows($rsHermanos)>0){
				?>
					<table width="650" border="0" cellpadding="1" cellspacing="1">
 					 	<TR height=20 bgcolor=#0099cc >
							<TD class="tableindex" align="center">
							HERMANOS
							</TD>
 						</TR>
					</table>		
				<? } ?>
					<br>
				<?
					for($i=0 ; $i < @pg_numrows($rsHermanos) ; $i++){
						$fHemanos = @pg_fetch_array($rsHermanos,$i);				
						$rut_hermano = trim($fHemanos['rut_hermano'])."-".trim($fHemanos['dig_rut']);
						$nombre_hermano = ucwords(strtolower(trim($fHemanos['nombre_hermano'])));
						$apellidos = ucwords(strtolower(trim($fHemanos['ape_pat'])))." ".ucwords(strtolower(trim($fHemanos['ape_mat'])));
						$fecha_nac = Cfecha(trim($fHemanos['fecha_nac']));
						$estudios = ucwords(strtolower(trim($fHemanos['estudios'])));
				?>							
					<table width="650" border="1" cellspacing="0" cellpadding="1">
					  <tr>
					  </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nombres</strong></font></td>
						<td><span class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $nombre_hermano?></font></span></td>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Apellidos</strong></font></td>
						<td><span class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $apellidos?></font></span></td>
					  </tr>
					  <tr>
						<td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Fecha Nacimiento</strong></font></td>
						<td><span class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $fecha_nac?></font></span></td>
                        <td bgcolor="#B0C4DE"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Estudios</strong></font></td>
                        <td colspan="3"><span class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $estudios?></font></span></td>
				      </tr>
			  </table>
			  <br>
			  <? } ?>
		
</center>

								  
								  
								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

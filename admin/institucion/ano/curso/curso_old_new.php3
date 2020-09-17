<?php 	require('../../../../util/header.inc');
		require('../../../../util/LlenarCombo.php3');
		require('../../../../util/SeleccionaCombo.inc');
?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$ext1			=$ext;
	$_PERFIL;
	$_POSP          = 4;
	$_MDINAMICO     = 1;
	
	
	//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano ";
	$sqlCurso = $sqlCurso . " from institucion, ano_escolar ";
	$sqlCurso = $sqlCurso . " where institucion.rdb = $institucion and ano_escolar.id_ano = $ano ";
	$rsCurso =pg_Exec($conn,$sqlCurso);												
	$fCurso2 = @pg_fetch_array($rsCurso,0);		
	//-------		
	
?>
<?php $qryIns="select tipo_instit from institucion where rdb=".$institucion;
		 $resultIns = pg_Exec($conn,$qryIns);
		  $filaIns	= @pg_fetch_array($resultIns,0);
		    $Tipo_Ins = $filaIns['tipo_instit'];
?>
	
<?php
	if($frmModo!="ingresar"){
		//EL MISMO PROBLEMA QUE PASA AL LISTAR -- TIPO_ENSENANZA WHERE COD_TIPO=".$fila['ensenanza'];
		$qry="select curso.*, plan_estudio.*, tipo_ensenanza.* from curso, plan_estudio, tipo_ensenanza where curso.id_curso = ".$_CURSO." and plan_estudio.cod_decreto = curso.cod_decreto and curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$result =pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	
		$fCurso = @pg_fetch_array($result,0);	
	}
?>

<?php 	function TieneNotas($id_insti,$id_ano,$id_curso,$conn){
			$SQL="select max(id_periodo)as id_periodo from periodo where id_ano=".$id_ano ;
			$rs_existenota = pg_Exec($conn,$SQL);
			$fila = @pg_fetch_array($rs_existenota,0);
			if (!$rs_existenota){
				error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
				exit();
			};
			$SQLE="select fecha_termino from periodo where id_periodo=".$fila['id_periodo'] ;
			$existenota = pg_Exec($conn,$SQLE);
			$filaE = @pg_fetch_array($existenota,0);
			if (!$existenota){
				error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
				exit();
			};
			
			$actual=strftime("%Y-%m-%d");
			if ($actual>=$filaE['fecha_termino']){
			return true;
			}else{
				return false;
			};			
			
		}; 

?>

<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include ("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo nuevo -->
								  
<SCRIPT language="JavaScript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
    eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
       if (restore) selObj.selectedIndex=0;
}
		function enviapag(form){
			if (form.cmbPLAN.value!=0){
				form.cmbPLAN.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'curso.php3?institucion=$institucion';
				form.submit(true);
	
			}	
		}
		
		function enviapagENS(form){
			if (form.cmbENS.value!=0){
				form.cmbENS.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'curso.php3?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
		function enviapagSEC(form){
			if (form.cmbSEC.value!=0){
				form.cmbSEC.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'curso.php3?institucion=$institucion';
				form.submit(true);
	
				}	
		}
</script>		  								  
								  
								  
								  
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<script language="javascript">
function valida(form){
   
   if(!chkSelect(form.cmbPLAN,'Debe seleccionar PLAN DE ESTUDIO.')){
		return false;
	};
	
	if(!chkSelect(form.cmbENS,'Debe seleccionar TIPO DE ENSEÑANZA.')){
		return false;
	};
	
	if(!chkSelect(form.cmbSEC,'Debe seleccionar SECTOR ECONOMICO.')){
		return false;
	};
	
	if(!chkSelect(form.cmbESP,'Debe seleccionar ESPECIALIDAD.')){
		return false;
	};


   /*
   if(form.cmbPLAN.value=='0'){
	   alert ('Debe seleccionar PLAN DE ESTUDIO.')
	   form.cmbPLAN.focus();
	   return false;
	}; */
   return true;
}
</script>					  
								  
								  
								   
<?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<?php } ?>
		
	<FORM method="post" name="form" action="procesoCurso.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
	?>
		<TABLE WIDTH=600 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<TR height=15>
				<TD>A&ntilde;o escolar : <?php echo trim($fCurso2['nro_ano']); ?></strong>				</TD>
			</TR>
			<TR >
				
      <TD> 
        <TABLE WIDTH="100%" height="100%" BORDER=0 align="center" CELLPADDING=5 CELLSPACING=5>
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){  ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick=document.location="listarCursos.php3">&nbsp;
								<?php };//FIN INGRESAR	?>
								
								
								<?php if($frmModo=="mostrar"){ ?>
									<!--PENDIENTE POR MUCHO ENRREDO-->
									<?php if($_PERFIL==17){ ?>
									
              		<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=parent.location.href="../../../../session/perfilDocente.php3">
              <?php }?>
              <?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==2)||($_PERFIL==23)||($_PERFIL==24)||($_PERFIL==25)||($_PERFIL==26)){ ?>
              <?php if(($_PERFIL!=17)&& ($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
              		<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaCurso.php3?curso=<?php echo $curso?>&caso=3">
              &nbsp; 
              <?php } ?>
              <?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
              <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
            		<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()">&nbsp;
			  <?php }?>
			  <?php }?>
			        <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarCursos.php3">
              &nbsp;
									<?php }?>
								<?php };//FIN MOSTRAR	?>
								
								
								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaCurso.php3?curso=<?php echo $curso?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR align="right" >
							<TD colspan=2 class="fondo">
								CURSO
                                  <FONT face="arial, geneva, helvetica" size=2>&nbsp;</FONT> </TD>
						</TR>
						<tr><td>&nbsp;</td>
						<td width="600"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                          <tr>
                            <td width="18%"><font color="#6699FF"><strong>PLAN DE ESTUDIO</strong></font></td>
                            <td width="25%"><?php if($frmModo=="ingresar"){ ?>
                              <select name="cmbPLAN" onChange="enviapag(this.form);">
                                <option value="0" selected>Selecione Plan de Estudio</option>
                                <?php 
							$sql="select plan_inst.cod_decreto, plan_estudio.cursos, plan_estudio.nombre_decreto from (plan_estudio inner join plan_inst on plan_inst.cod_decreto=plan_estudio.cod_decreto) where plan_inst.rdb =" . $institucion;
							$result= pg_Exec($conn,$sql);
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
										if ($fila["cod_decreto"]==$cmbPLAN){
											echo  "<option selected value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
										}else{
											echo  "<option value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
										}
													
								}
						?>
                              </select>
                              <?php

																	if($Tipo_Ins==2){//JARDIN INFANTIL
																		if(($fila["cod_tipo"]<100))
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}
																	if($Tipo_Ins==3){//SALACUNA
																		if($fila["cod_tipo"]<=40) // SOLO SALACUNA
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}

													?>
                              <?php };?>
                              <?php 
										if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php 
													echo trim($fCurso['nombre_decreto'])." (".trim($fCurso['cursos']).")";
											};
											?>
                              </strong></font>
                              <?php  if($frmModo=="modificar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php 
							echo trim($fCurso['nombre_decreto'])." (".trim($fCurso['cursos']).")";
						?>
                              </strong></font>
                              <?php
						};

						?></td>
                            <td width="21%"><font color="#6699FF"><strong>&nbsp;TIPO DE ENSE&Ntilde;ANZA</strong></font></td>
                            <td width="36%"><?php if($frmModo=="ingresar"){?>
                              <FONT face="arial, geneva, helvetica" size=1 color=#000000>
                              <select name="cmbENS" onChange="enviapagENS(this.form);">
                                <option value=0 selected>Seleccione Tipo de Ense&ntilde;anza</option>
                                <?php 
							$sqlENS="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from (tipo_ensenanza inner join tipo_ense_inst on tipo_ensenanza.cod_tipo=tipo_ense_inst.cod_tipo) where tipo_ense_inst.cod_decreto=".$cmbPLAN." and tipo_ense_inst.estado<>2 and tipo_ense_inst.rdb=".$institucion;
							$resultENS= pg_Exec($conn,$sqlENS);
								for($i=0 ; $i < @pg_numrows($resultENS) ; $i++){
									$filaENS = @pg_fetch_array($resultENS,$i);
										if ($filaENS["cod_tipo"]==$cmbENS){
											echo  "<option selected value=".$filaENS["cod_tipo"]." >".$filaENS["nombre_tipo"]."</option>";
										}else{
											echo  "<option value=".$filaENS["cod_tipo"]." >".$filaENS["nombre_tipo"]."</option>";
										}
													
								}
						?>
                              </select>
                              </font>
                              <?php 
					
						};
						
						if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							echo trim($fCurso['nombre_tipo']);
						};?>
                              </strong></font>
                              <?php
						
						
						

					if($frmModo=="modificar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							echo trim($fCurso['nombre_tipo']);
							}?>
                              </strong></font></td>
                          </tr>
                        </table>
						
		<?php if($Tipo_Ins==1){//COLEGIO?>
		        <?php
			    //TIPO DE ENSEÑANZA AL QUE CORRESPONDE
			     $qry="SELECT curso.*, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
			     $result =@pg_Exec($conn,$qry);
			     $fila4= @pg_fetch_array($result,0);
		         ?>
		 <?php } //if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//ENSEÑANZA KINDER U OTRO CABRO CHICO
		  ?>
						
						
						
						
						</td></tr>
						<tr><td>&nbsp;</td><td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                          <tr>
                            <td width="18%"><font color="#6699FF"><strong>SECTOR ECONOMICO </strong></font></td>
                            <td width="25%">
							<?php if($frmModo=="ingresar"){ ?>
                              <select name="cmbSEC" onChange="enviapagSEC(this.form);">
                                <option value="0" selected>Seleccione Sector Economico</option>
                                <?php  
							$sqlSEC="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$cmbENS;
							$resultSEC= pg_Exec($conn,$sqlSEC);
								for($i=0 ; $i < @pg_numrows($resultSEC) ; $i++){
									$filaSEC = @pg_fetch_array($resultSEC,$i);
										if ($filaSEC["cod_sector"]==$cmbSEC){
											echo  "<option selected value=".$filaSEC["cod_sector"]." >".$filaSEC["nombre_sector"]."</option>";
										}else{
											echo  "<option value=".$filaSEC["cod_sector"]." >".$filaSEC["nombre_sector"]."</option>";
										}
									$rama=$filaSEC["cod_rama"];		
								}
						?>
                              </select>
                              <?php echo "<input type=hidden name=txtRAMA  value=".$filaSEC["cod_rama"].">"; ?>
                              <?php }?>
                              <?php
							  echo "<br>fila4[cod_sector] tiene: ".$fila4['cod_sector'];
							  echo "<br>fila4[cod_rama] tiene: ".$fila4['cod_rama'];
							  
							  
							   $qry9="SELECT * FROM sector_eco WHERE cod_sector=".$fila4["cod_sector"]." AND cod_rama=".$fila4["cod_rama"];
							$result9= pg_Exec($conn,$qry9);
							$fila9= @pg_fetch_array($result9,0);
					?>
                              <?php if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							imp($fila9['nombre_sector']);
						};?>
                              </strong></font>
                              <?php 
						
						if($frmModo=="modificar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							imp($fila9['nombre_sector']);?>
                              </strong></font>
                              <?php 	};
					?></td>
                            <td width="21%"><font color="#6699FF"><strong>ESPECIALIDAD</strong></font></td>
                            <td width="36%"><?php $qry7="SELECT * FROM especialidad WHERE cod_sector=".$fila4["cod_sector"]." AND cod_rama=".$fila4["cod_rama"]." AND cod_esp=".$fila['cod_es'];
							$result7= pg_Exec($conn,$qry7);
							$fila7= @pg_fetch_array($result7,0);
					?>
                              <?php if($frmModo=="ingresar"){ ?>
                              <select name="cmbESP">
                                <option value=0 selected>Seleccione Especialidad</option>
                                <?php 
							$sqlESP="select * from especialidad where cod_sector =".$cmbSEC." and cod_rama=".$rama;
							$resultESP= pg_Exec($conn,$sqlESP);
								for($i=0 ; $i < @pg_numrows($resultESP) ; $i++){
									$filaESP = @pg_fetch_array($resultESP,$i);
										if ($filaESP["cod_esp"]==$cmbESP){
											echo  "<option selected value=".$filaESP["cod_esp"]." >".$filaESP["nombre_esp"]."</option>";
										}else{
											echo  "<option value=".$filaESP["cod_esp"]." >".$filaESP["nombre_esp"]."</option>";
										}
								}
						?>
                              </select>
                              <?php };?>
                              <?php if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
						imp($fila7['nombre_esp']);
						};?>
                              </strong></font>
                              <?php
						
						if($frmModo=="modificar"){?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php 
						imp($fila7['nombre_esp']);?>
                              </strong></font>
                              <?php };
						?><FONT face="arial, geneva, helvetica" size=2><strong>                              </strong></font></td>
                          </tr>
                        </table></td></tr>
						<tr><td>&nbsp;</td><td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                          <tr class="datosB">
                            <td width="26%" height="15"><font color="#6699FF"><strong>DECRETO DE EVALUACI&Oacute;N</strong></font></td>
                            <td width="10%"><FONT face="arial, geneva, helvetica" size=2><strong><font face="arial, geneva, helvetica" size=2><strong>
                              <?php
						imp($fila['cod_eval']);
						?>
                            </strong></font></strong></font></td>
                            <td width="8%"><strong><font color="#6699FF">GRADO</font></strong></td>
                            <td width="3%"><?php if($frmModo=="ingresar"){ ?>
                              <?php
						$sql2="select * from cursos_plan where cod_decreto=". $cmbPLAN;
						$result2=pg_Exec($conn,$sql2);
						$fila2= @pg_fetch_array($result2,0);
					?>
                              <select name="cmbGRA">
                                <option value=0 selected>Seleccione Grado</option>
                                <?php if ( (($fila2['pa']==1) and ($cmbPLAN==461987)) or (($fila2['pa']==1) and ($cmbPLAN==771982)) ){ ?>
                                <option value=1>PRIMER NIVEL</option>
                                <?php }else if ( (($fila2['pa']==1) and ($cmbPLAN==121987)) or (($fila2['pa']==1) and ($cmbPLAN==1521989)) ){ ?>
                                <option value=1>PRIMER CICLO</option>
                                <?php }else if (($fila2['pa']==1) and ($cmbPLAN==1000)){ ?>
                                <option value=1>SALA CUNA</option>
                                <?php
					  }else if ($fila2['pa']==1) { ?>
                                <option value=1>PRIMER A&Ntilde;O</option>
                                <?php }
					  if ( (($fila2['sa']==1) and ($cmbPLAN==461987)) or (($fila2['sa']==1) and ($cmbPLAN==771982)) ){ ?>
                                <option value=2>SEGUNDO NIVEL</option>
                                <?php }else if (($fila2['sa']==1) and ($cmbPLAN==121987)){ ?>
                                <option value=2>SEGUNDO CICLO</option>
                                <?php }else if (($fila2['sa']==1) and ($cmbPLAN==1000)){ ?>
                                <option value=2>NIVEL MEDIO MENOR</option>
                                <?php }else if ($fila2['sa']==1){ ?>
                                <option value=2>SEGUNDO A&Ntilde;O</option>
                                <?php }
					  if ( (($fila2['ta']==1) and ($cmbPLAN==461987)) or (($fila2['ta']==1) and ($cmbPLAN==771982)) ){ ?>
                                <option value=3>TERCER NIVEL</option>
                                <?php }else if (($fila2['ta']==1) and ($cmbPLAN==1000)){ ?>
                                <option value=3>NIVEL MEDIO MAYOR</option>
                                <?php }else if ($fila2['ta']==1){ ?>
                                <option value=3>TERCER A&Ntilde;O</option>
                                <?php }
					if (($fila2['cu']==1) and ($cmbPLAN==1000)){ ?>
                                <option value=4>TRANSICI&Oacute;N 1er NIVEL</option>
                                <?php }else if($fila2['cu']==1) { ?>
                                <option value=4>CUARTO A&Ntilde;O</option>
                                <?php }
					if (($fila2['qu']==1) and ($cmbPLAN==1000)){ ?>
                                <option value=5>TRANSICI&Oacute;N 2do NIVEL</option>
                                <?php }else if($fila2['qu']==1) { ?>
                                <option value=5>QUINTO A&Ntilde;O</option>
                                <?php }
					if ($fila2['sx']==1){ ?>
                                <option value=6>SEXTO A&Ntilde;O</option>
                                <?php }
					if ($fila2['sp']==1){ ?>
                                <option value=7>SEPTIMO A&Ntilde;O</option>
                                <?php }
					if ($fila2['oc']==1){ ?>
                                <option value=8>OCTAVO A&Ntilde;O</option>
                                <?php } ?>
                              </select>
                              <?php };?>
                              <?php 
						if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL";
							}else if (($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO";
							}else if (($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
								echo "SALA CUNA";
							}else if (($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR";
							}else if (($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR";
							}else if (($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
								echo "TRANSICI&Oacute;N 1er NIVEL";
							}else if (($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
								echo "TRANSICI&Oacute;N 2do NIVEL";
							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL";
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "TERCER NIVEL";
							
							}else{
								imp($fila['grado_curso']);
							}?>
                              </strong></font>
                              <?php 
						};
						if($frmModo=="modificar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL";
							}else if (($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
								echo "SALA CUNA";
							
							}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO";
							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL";
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if (($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR";
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "TERCER NIVEL";
							}else if (($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR";
							}else if (($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
								echo "TRANSICI&Oacute;N 1er NIVEL";
							}else if (($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
								echo "TRANSICI&Oacute;N 2do NIVEL";
							}else{
								imp($fila['grado_curso']);
							}?>
                              </strong></font>
                              <?php	};
					?></td>
                            <td width="8%"><strong><font color="#6699FF">LETRA</font></strong></td>
                            <td width="45%"><?php if($frmModo=="ingresar"){ ?>
                              <Select name="cmbLETRA">
                                <option value=0 selected >Seleccione Letra</option>
                                <option value=A >A</option>
                                <option value=B >B</option>
                                <option value=C >C</option>
                                <option value=D >D</option>
                                <option value=E >E</option>
                                <option value=F >F</option>
                                <option value=G >G</option>
                                <option value=H >H</option>
                                <option value=I >I</option>
                                <option value=J >J</option>
                                <option value=K >K</option>
                                <option value=L >L</option>
                                <option value=M >M</option>
                                <option value=N >N</option>
                                <option value=&Ntilde; >&Ntilde;</option>
                                <option value=O >O</option>
                                <option value=P >P</option>
                                <option value=Q >Q</option>
                                <option value=R >R</option>
                                <option value=S >S</option>
                                <option value=T >T</option>
                                <option value=U >U</option>
                                <option value=V >V</option>
                                <option value=W >W</option>
                                <option value=X >X</option>
                                <option value=Y >Y</option>
                                <option value=Z >Z</option>
                              </Select>
                              <?php };?>
                              <?php if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
						imp($fila['letra_curso']);?>
                              </strong></font>
                              <?php
						};
						if($frmModo=="modificar"){?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
						imp($fila['letra_curso']);?>
                              </strong></font>
                              <?php	};
						?></td>
                          </tr>
                        </table></td></tr>
						<tr><td>&nbsp;</td><td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
                          <tr class="datosB">
                            <td width="33%" height="15"><font color="#6699FF"><strong>APROXIMAR PROMEDIOS FINALES</strong></font></td>
                            <td width="4%"><?php if ($frmModo=="ingresar"){
					//echo $qry7;
					//exit;?>
                              <input name="truncado_per" type="checkbox" id="truncado_per">
                              <?php } ?>
                              <?php 
						if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
							imp( ($fila['truncado_per']==0)?"NO":"SI");?>
                              </strong></font>
                              <?php };?>
                              <?php if($frmModo=="modificar"){ ?>
                              <input type="checkbox" name="truncado_per" size=83 maxlength=50 value=1 
					<?php 
					echo ($fila['truncado_per']==1)?"checked":"";
					?>>
                              <?php };?></td>
                            <td width="16%"><font color="#6699FF"><strong>PROFESOR JEFE</strong></font></td>
                            <td width="47%"><?php if($frmModo=="ingresar"){ ?>
                              <select name="cmbSUP">
                                <option value=0 selected>Seleccione Profesor Jefe</option>
                                <?php
													$qry="SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, empleado.rut_emp, trabaja.cargo, institucion.rdb FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (institucion.rdb=".$institucion.") order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
												
														$result =pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (19)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (20)</B>');
																	//exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	echo  "<option value=".trim($fila1["rut_emp"]).">".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																}
															}
														};
													?>
                              </select>
                              <?php };?>
                              <?php 
												if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php

								$qry55="select * from supervisa where id_curso=".$fila['id_curso'];
							//	$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result55 =pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
								
								$qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
							//	$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result5 =pg_Exec($conn,$qry5);
								$fila5 = @pg_fetch_array($result5,0);

													imp($fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]);
													?>
                              </strong></font>
                              <?php
												};
											?>
                              <?php if($frmModo=="modificar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <select name="cmbSUP">
                                <option value=0></option>
                                <?php
														//SUPERVISOR ACTUAL
														$qry="SELECT curso.id_curso, empleado.rut_emp FROM (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON supervisa.id_curso = curso.id_curso WHERE (((curso.id_curso)=".$curso.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result =pg_Exec($conn,$qry);
														$fila4= @pg_fetch_array($result,0);

														//DOCENTES DE LA INSTITUCION
														$qry="SELECT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat,empleado.ape_mat, trabaja.rdb, trabaja.cargo FROM empleado INNER JOIN (institucion INNER JOIN trabaja ON institucion.rdb = trabaja.rdb) ON empleado.rut_emp = trabaja.rut_emp WHERE ((trabaja.rdb=".$_INSTIT.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result =pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	if($fila4["rut_emp"]!=$fila1["rut_emp"]){
																		echo "<option value=".$fila1["rut_emp"]."> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																	}else{
																		echo "<option value=".$fila1["rut_emp"]." selected> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																	}
																}
															}
														};
													?>
                              </select>
                              </strong></font>
                              <?php };?></td>
                          </tr>
                        </table></td></tr>
						<tr><td>&nbsp;</td><td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
                          <tr class="datosB">
                            <td width="11%" height="15"><font color="#6699FF"><strong>JORNADA</strong></font></td>
                            <td width="35%"><?php if($frmModo=="ingresar"){ ?>
                              <p align="justify">
                                <label>
                                <input name="jornada" type="radio" value="1" checked >
                                <font size="1" face="Arial, Helvetica, sans-serif">MA&Ntilde;ANA</font></label>
                                <br>
                                <label>
                                <input type="radio" name="jornada" value="2">
                                <font size="1" face="Arial, Helvetica, sans-serif"> TARDE</font></label>
                                <br>
                                <label>
                                <input type="radio" name="jornada" value="3">
                                <font size="1" face="Arial, Helvetica, sans-serif"> MA&Ntilde;ANA Y TARDE</font></label>
                                <br>
                                <label>
                                <input type="radio" name="jornada" value="4">
                                <font size="1" face="Arial, Helvetica, sans-serif">VESPERTINO</font></label>
                                <br>
                              </p>
                              <?php };
					if($frmModo=="mostrar"){ ?>
                              <FONT face="arial, geneva, helvetica" size=2><strong>
                              <?php
						$jor = $fila['bool_jor'];
						switch ($jor){
						   case 1;
						      echo "MA&Ntilde;ANA";
						   break;	  
						   case 2;
						       echo "TARDE";
						   break;
						   case 3;
						       echo "MA&Ntilde;ANA Y TARDE";	   
						   break;
						   case 4;
						       echo "VESPERTINO";	   
						   break;
						   } ?>
                              </strong></font>
                              <?php };?>
                              <?php	if($frmModo=="modificar"){ ?>
                              <?php
						$jor = $fila['bool_jor'];
						 ?>
                              <p>
                                <label> <font size="1" face="Arial, Helvetica, sans-serif">
                                <input name="jornada" type="radio" value=1 
					 <?php 
						echo ($jor==1)?"checked":"";
					  ?>>
  MA&Ntilde;ANA </font> </label>
                                <br>
                                <label> <font size="1" face="Arial, Helvetica, sans-serif">
                                <input name="jornada" type="radio" value=2 
						<?php 
							echo ($jor==2)?"checked":"";
						?>>
                                TARDE </font></label>
                                <br>
                                <label> <font size="1" face="Arial, Helvetica, sans-serif">
                                <input name="jornada" type="radio" value=3 
					    <?php 
							echo ($jor==3)?"checked":"";
						?>>
  MA&Ntilde;ANA Y TARDE</font></label>
                                <br>
                                <label> <font size="1" face="Arial, Helvetica, sans-serif">
                                <input name="jornada" type="radio" value=4 
						<?php 
							echo ($jor==4)?"checked":"";
						?>>
                                VESPERTINO</font></label>
                                <br>
                              </p>
                              <?php };?></td>
                            <td width="54%">&nbsp;</td>
                          </tr>
                        </table></td></tr>
	<?php if($Tipo_Ins==1){//COLEGIO?>
		<?php
			//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
			$qry="SELECT curso.*, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE curso.id_curso= '".trim($curso)."'";
			$result =pg_Exec($conn,$qry);
			$fila4= @pg_fetch_array($result,0);
		?>
		<?php //if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//ENSEÑANZA KINDER U OTRO CABRO CHICO
		  ?>
						
			<?php if ((($cmbENS>310) or ($fila['ensenanza']>310)) and ($cmbENS!=360) and ($cmbENS!=361) ) { ?>
						<?php } ?>
						
						
		<?php // }//FIN ENSEÑANZA CURSO?>
	<?php }//COLEGIO?>
						<TR>
							<TD width=0></TD>
							
            <TD> </TD>
						</TR>

						<TR height=15>
			<TD height="60" colspan=2 align="center"> 
			<table width="100%">
			  <tr><td>
              <?php if($frmModo=="mostrar"){?>
			  <!--select name="menu1" size="1" class="imput" onChange="MM_jumpMenu('parent',this,0)">
				<option>Seleccione Opción</option>				
				<option value="alumno/listarAlumnos.php3?_url=0">ALUMNOS</option>
			<?php if(($_PERFIL!=6)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){
					if($fila['ensenanza']>100){// PREBASICA NO TIENE SUBSECTORES?>
						<option value="ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>">SUBSECTORES</option>
						<option value="ramo/listarTalleres.php3">TALLER</option>
						<option value="horario/listarHorario.php">HORARIO</option>
					<?php }?>
					<option value="promocion/promocion_pro.php">PROMOCION</option>
			<? }?>	
			 <?php $sqlFer="select * from feriado where id_ano=".$ano;
			  		$resultFer=pg_Exec($conn,$sqlFer);
					if((@pg_numrows($resultFer)!=0)and ($frmModo=="mostrar")){
						//if($_PERFIL!=6 && $_PERFIL!=15 && $_PERFIL!=16){?>
							<option value="asistencia/seteaAsistencia.php3?caso=2">ASISTENCIA</option>	
 							<option value="inasistencia/inasistencia.php">INASISTENCIA ASIGNATURA</option>
						

				<?php //} 
				}?>
	 		 <?php if($_PERFIL!=17){ ?>
					 <option value="../fichas/listarAlumnosMatriculados.php3?tipoFicha=1">FICHA MEDICA</option>
				 	<option value="../fichas/listarAlumnosMatriculados.php3?tipoFicha=2">FICHA DEPORTIVA</option>
			  <?php }?>
			    <?php if(($_PERFIL==0) or ($_PERFIL==8) or ($_PERFIL==14) or ($_PERFIL==17)){?>
				<option value="informe_educacional/listarAlumnos.php?tipoEns=<?php echo $fila['ensenanza']?>&grado=<?php echo $fila['grado_curso']?>">INFORME EDUCACIONAL</option>
				<? }?>
			   <? if( ($_PERFIL==0) OR ($_PERFIL==17) OR ($_PERFIL==14)) { ?>
			   <option value="frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>">RESULTADOS DEL CURSO</option>
				<option value="Listado_Claves.php?curso=<?php echo $fila['id_curso']?>">CLAVES</option>
	


			   <? }?>


			  </select-->
			  <? }?>
</td></tr><tr><td><p>&nbsp;</p>
    <table width="80%" border="0" cellpadding="0" cellspacing="0" class="boton02">
      <tr align="center" valign="middle">
      <td height="23">
	  <a href="
	  <?php if($frmModo=="modificar"){ ?>seteaCurso.php3?curso=<?php echo $curso?>&caso=1<?php };?>
	  <?php if($frmModo=="mostrar"){ ?>listarCursos.php3<? }?>
	  <?php if($frmModo=="ingresar"){ ?>listarCursos.php3 <? }?>
	  "
	  class="boton02" >
	  
	  <img src="../../../../cortes/atras.gif" width="11" height="11" border="0"> Volver</a></td>
        <td><a href="#arriba" class="boton02"><img src="../../../../cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
        <td><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
      </tr>
    </table></td></tr></table>
            </TD>
			  

						</TR>
		</TABLE>
			  </TD>
			</TR>	
			
	  </TABLE>
	</FORM>

								  
								  
								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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

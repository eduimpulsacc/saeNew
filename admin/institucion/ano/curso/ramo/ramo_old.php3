<?php require('../../../../../util/header.inc');  ?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
	$_POSP         = 5;
	
	
//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto ";
	$sqlCurso = $sqlCurso . " from institucion, ano_escolar, curso, tipo_ensenanza ";
	$sqlCurso = $sqlCurso . " where institucion.rdb = $institucion and ano_escolar.id_ano = $ano and curso.id_curso = $curso";
	$sqlCurso = $sqlCurso . "and curso.ensenanza = tipo_ensenanza.cod_tipo";
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);		
	//-------		


		 $qryIns="select tipo_instit from institucion where rdb=".$institucion;
		 $resultIns = @pg_exec($conn,$qryIns);
		 $filaIns	= @pg_fetch_array($resultIns,0);
		 $Tipo_Ins = $filaIns['tipo_instit'];
	?>

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

<SCRIPT language="JavaScript">
					
			function enviapag(form){
			if (form.cmbSECDIF.value!=0){
				form.cmbSECDIF.target="self";
				form.action = 'ramo.php3?institucion=$institucion&$frmModo=ingresar';
				form.submit(true);
				}	
			}
			
			function ChequearTodos(chkbox)
				{
				for (var i=0;i < document.forms[0].elements.length;i++)
					{
				var elemento = document.forms[0].elements[i];
				if (elemento.type == "checkbox")
					{
					elemento.checked = chkbox.checked
					}
				}
			}
			
			function ocultaText(form)
			{
					form.txtPCT.disabled = true
					form.txtPCT.value = ""
					form.txtNEXIM.disabled = true
					form.txtNEXIM.value = ""
					form.pct_ex_escrito.disable = true
					form.pct_ex_escrito.value = ""
					form.pct_ex_oral.disable = true
					form.pct_ex_oral.value = ""

			}
			
			function muestraText(form)
			{
					form.txtPCT.disabled = false
					form.txtNEXIM.disabled = false
			}
				
			function mText(form)
			{
					form.cmbSUB.disabled = false;
					if(form.cmbSECDIF){
						form.cmbSECDIF.disabled = false;
					}
					form.codSub.disabled = true;
					form.codSub.value = "";
					form.codRes.disabled = true;
					form.codRes.value = "";
					form.txtFecha.disabled = true;
					form.txtFecha.value = "";
			}
				
			function mtaText(form)
			{
					form.codSub.disabled = false;
					form.codRes.disabled = false;
					form.txtFecha.disabled = false;
					form.cmbSUB.disabled = true;
					form.cmbSUB.value = "";
					if(form.cmbSECDIF){
						form.cmbSECDIF.disabled = true;
						form.cmbSECDIF.value = "";
					}
			}					

			function muestraTextPNivel(form)
			{
					form.txtPCTNIV.disabled = false;
					form.cmbMODOpruebaNivel.disabled = false; 
					form.cmbMODOpruebaNivel.value = "";
			}

			function ocultaTextNivel(form)
			{
					form.txtPCTNIV.disabled = true
					form.txtPCTNIV.value = ""
					if(form.cmbMODOpruebaNivel){
						form.cmbMODOpruebaNivel.disabled = true
						form.cmbMODOpruebaNivel.value = ""
					}
			}

</SCRIPT>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
-->
</style>


<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
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

	switch ($fila['modo_eval']) {
		 case 0:
			$_MODOEVAL	=	0;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 1:
			$_MODOEVAL	=	1;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 2:
			$_MODOEVAL	=	2;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 3:
			$_MODOEVAL	=	3;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 4:
			$_MODOEVAL	=	4;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
	 };

?>
<HTML>
	<HEAD>
		
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></script>
	<?php if($Tipo_Ins==1){//COLEGIO ?>
	<!--AQUI DETERMINAR SI EL CURSO ES KINDER O OTRO DE LOS CABROS CHICOS-->
		<script language="JavaScript">
			function valida(form){
				/*if(!chkVacio(form.codSub,'Ingresar CODIGO del subsector.')){
					return false;
				};
				if(!nroOnly(form.codSub,'Se permiten sólo números para el CODIGO del subsector.')){
					return false;
				};*/
				if (document.frm.cmbSUBS[0].checked==false && document.frm.cmbSUBS[1].checked==false ){
					//alert("Debe seleccionar Subsector");
					document.frm.cmbSUBS[0].focus();
					//return false;
				};
				if(document.frm.cmbSUBS[0].checked==true){
				 	if(!chkVacio(form.codSub,'Ingresar Codigo SubSector.')){
						return false;
					};
					if(!nroOnly(form.codSub,'Se permiten sólo números para el CODIGO del subsector.')){
						return false;
					};
				};
				if(document.frm.cmbSUBS[1].checked==true){
					if(!chkSelect(frm.cmbSECDIF,'Seleccionar SubSector.')){
						return false;
					};
				};
				if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
					return false;
				};
				
				return true;
			}
			</SCRIPT>
		
				
		
	<?php }?>
	<?php if(($Tipo_Ins==2)||($Tipo_Ins==3)){//JARDIN O SALACUNA ?>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
						return false;
					};

					if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
						return false;
					};
					
					if(!chkSelect(form.cmbSUB,'Seleccionar DOCENTE.')){
						return false;
					};


					return true;
				}
			</SCRIPT>
	<?php }?>
<?php }?>
	
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayudaza_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						 $menu_lateral= "3_1";
						include ("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390">
								  
								  

<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>

<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>


 <!-- AQUÍ CODIGO NUEVO -->



<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	
	<FORM method=get name="frm" action=<? if ($_PERFIL==0){ echo "procesoRamo_dav.php"; }else{ echo "procesoRamo.php3"; } ?>>
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		echo "<input type=hidden name=curso value=".$curso.">";
		
		$qryVrfyPropio="select * from plan_estudio where cod_decreto=".$_PLAN;
		$resultVrfy=@pg_Exec($conn,$qryVrfyPropio);
		$filaVrfy=@pg_fetch_array($resultVrfy,0);
		
										$qry="SELECT curso.*, tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result25 =@pg_Exec($conn,$qry);
											
											if (!$result25) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result25)!=0){
													$fila3 = @pg_fetch_array($result25,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
												}
											}
		
		
		$nro_ano_notas = trim($fCurso['nro_ano']);
		
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php echo trim($fCurso['nombre_instit']); ?> </strong> </FONT> </TD>
                      </TR>
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php echo trim($fCurso['nro_ano']); ?> </strong> </FONT> </TD>
                      </TR>
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>
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
                      <TR>
                        <TD align=left>
                          <?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
                          <FONT face="arial, geneva, helvetica" size=2> <strong>SUBSECTOR</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT>
                            <?php }?>
                        </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>
                          <?php
								if (@pg_numrows($result)!=0){
									$fila1 = @pg_fetch_array($result,0);	
									echo trim($fila1['nombre']);
								}
							?>
                        </strong> </FONT> </TD>
                      </TR>
                    </TABLE></TD>
			</TR>
			<TR height=15>
				<TD>
					
					
					<!-- aqui tabla nueva -->
					
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">
									&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
								<?php if($_PERFIL==17){ ?>
									<!--INPUT class="botonXX"  TYPE="button" value="INICIO" onClick=parent.location.href="../../../../../fichas/docente/index.html"-->
								<?php }?>
									<?php if($_PERFIL!=17){?> 
										<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
												<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
												<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaRamo.php3?ramo=<?php echo $ramo?>&caso=3">&nbsp;
												
												<? 
												
											//SABEMOS SI EL RAMO TIENE NOTAS , PARA NO MOSTRAR EL BOTON ELIMINAR...*******************	
										    	$qry_tiene_notas="select count (*) as cantidad from notas$nro_ano_notas where id_ramo=$ramo";
		                                        $tiene_notas_1=@pg_Exec($conn,$qry_tiene_notas);
		                                        $filanotitas=@pg_fetch_array($tiene_notas_1,0);
												
										     	$notitas= $filanotitas['cantidad'];	
												
												?> 
												
												<? if ($notitas == 0){?>
												<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick=document.location="seteaRamo.php3?caso=9;">
												&nbsp;
											<?php }
											}?>
										<?php }?>
										<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">&nbsp;
									<?php }?>
								<?php if($_TIPODOCENTE==1){?>
										<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">&nbsp;
									<?php }?>
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" >
									&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaRamo.php3?ramo=<?php echo $ramo?>&caso=1&plan=<?php echo $plan ?>">&nbsp;
								<?php };?>
								
					<!--	<?php if($_PERFIL==17){?>
								<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">
							<? } ?>  -->
							</TD>
						</TR>
						<TR height=20>
							<TD align="middle" colspan="2" class="tableindex">
								SUBSECTOR
							</TD>
						</TR>
						
				<?php if($Tipo_Ins==1 OR $Tipo_Ins==3){//COLEGIO //ESCUELA  ----->//MODIFICADO EL 21/09/2007<------
				 ?>
				
				<?php if (($fila3['cod_tipo']==410) or($fila3['cod_tipo']==510) or ($fila3['cod_tipo']==610) or ($fila3['cod_tipo']==710) or ($fila3['cod_tipo']==810)){?>
				<?php  } ?>
					<?php
					//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
					$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
					$result =@pg_Exec($conn,$qry);
					$fila4= @pg_fetch_array($result,0);
					?>
					<?php if($_PERFIL==0 or $_PERFIL==14 or $_PERFIL==25 ){ 
					
					
					         //if($filaVrfy['rdb']==9074){ ?>
					
					
					
					<TR>
   					<TD width=6></TD>
					
                       <TD width="571"> 
					   <table border=0 cellspacing=2 cellpadding=2>
                  		<tr> 
							<?php if($frmModo=="ingresar"){ ?>  

                  			<td width="22"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                   			 </font> </td>
                 		 	<td width="201"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    		 <strong>COD. SUBSECTOR</strong> </font></td>
							  	<?php //if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>

						  <td width="142"> <font face="arial, geneva, helvetica" size=1 color=#000000><strong>RESOLUCION</strong></font></td>
									  
						  <td width="173"> <font face="arial, geneva, helvetica" size=1 color=#000000>FECHA</font> 
						  </td>
									</tr>
									<tr> 
						
							  
						  <td><input type="radio" name="cmbSUBS" value="1"onClick="mtaText(this.form);">
							 
						  </td>
						  <td> 
						   
							<input type="text" name="codSub" width="60"> 
							<?php }  ?>
							<FONT face="arial, geneva, helvetica" size=2><strong> 
						   
							</strong></font> </td>
						  <td> 
							<?php if($frmModo=="ingresar"){ ?>
							<input type="text" name="codRes"> </td>
						  <td align="top"> <input type="text" name="txtFecha"> 
							<?php };?>
						  </td>
						</tr>				
					  </table></TD>
								</TR>
								
								
				<!-- aqui opcion para agregar nuevos subsectores que no tengan codigo -->
			  <? if ($_PERFIL==0 OR $_PERFIL==14) { ?>
				
				<TR>
   					<TD width=6></TD>
					
                       <TD width="571"> 
					   <table width="100%" border=0 cellpadding=2 cellspacing=2>
                  		<tr> 
							<?php if($frmModo=="ingresar"){ ?>  

                  			<td width="22"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                   			 </font> </td>
                 		 	<td><strong><font color="#000000" size="1" face="arial, geneva, helvetica">NOMBRE SUBSECTOR<br>
</font><font size="2" face="arial, geneva, helvetica"><span class="Estilo1">(solo para crear subsectores hijos que no est&eacute;n en la lista de los subsectores entregados por el ministerio de educaci&oacute;n).</span> </font></strong></td>
							  	<?php //if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
						  </tr>
							<tr> 
												  
						  <td><input type="radio" name="cmbSUBS" value="3"onClick="mtaText(this.form);">						  </td>
						  <td> 
						   
							<input name="nombresubsector" type="text" id="nombresubsector" size="50" width="60"> 
							<?php }  ?>
							<FONT face="arial, geneva, helvetica" size=2><strong> 
						   
							</strong></font> </td>
						  </tr>				
					  </table></TD>
								</TR>
				
				<? } ?>
				
		<!-- fin opcion de agregar nuevos subsectores -->		
						
						
						
						
						
						
						
						
						
	<?php  }?>
		<TR>
		<TD width=6></TD>
							
            <TD width="571"> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
				<?php 
				      $qry5="SELECT * FROM curso WHERE ID_CURSO=".$curso; 
					    $result5 =@pg_Exec($conn,$qry5);
						$fila5= @pg_fetch_array($result5,0);
//						   if((($fila3["cod_tipo"]==110) or ((($fila3["cod_tipo"]==310) and (($frmModo=="mostrar") || ($frmModo=="modificar"))) and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2))) OR ((($fila3["cod_tipo"]>=410) and (($frmModo=="mostrar") || ($frmModo=="modificar"))) and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2) or ($fila5['grado_curso']==3) or ($fila5['grado_curso']==4)))) || $filaVrfy['rdb']!=0){ 
							if((($fila3["cod_tipo"]==110) or (($fila3["cod_tipo"]==310) and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2))) OR (($fila3["cod_tipo"]>=410)  and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2) or ($fila5['grado_curso']==3) or ($fila5['grado_curso']==4))))or ($filaVrfy['rdb']!=0)) {?>
  							    <?php if(($frmModo=="ingresar")and ($filaVrfy['rdb']==0)){ ?>
							   <td width="27"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    </font> </td>
								   <?php } ?>
							  <td width="131"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
								<strong>SUBSECTOR</strong> </font></td>
						 	 
								
							  	<?php //if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
							  	<?php if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
							
                  <td></td>
                  			<td width="226"> <font face="arial, geneva, helvetica" size=1 color=#000000><strong>SECTOR</strong></font></td>
							  <td width="182"> <font face="arial, geneva, helvetica" size=1 color=#000000><font face="arial, geneva, helvetica" size=1 color=#000000>SUBSECTOR</font> 
								</font> </td>
								<?php } ?>
							</tr>
							<tr> 
							   <?php if(($frmModo=="ingresar")){ ?>
							   <td><input type="radio" name="cmbSUBS" value="2"onClick="mText(this.form);"> 
								<?php } ?>                  
								<td> 
                    <?php if($frmModo=="ingresar"){ ?>
					<?php  //if($fila5["cod_tipo"]<>310){ ?>
                    	<select name="cmbSUB">
                      	<option value=0 selected>Seleccione Subsector </option>
					<?php
						//SUBSECTORES QUE CORRESPONDEN AL CURSO DE ACUERDO AL PLAN DE ESTUDIO
						$qry2="SELECT * FROM curso WHERE ID_CURSO=".$curso;
						$result2 =@pg_Exec($conn,$qry2);
						$fila2= @pg_fetch_array($result2,0);
						$qry=0;
							
							if (($fila3['ensenanza']==110) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989"))){
								$qry7="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
							
							}elseif (($fila3['ensenanza']>=310) AND (($fila2['grado_curso']==1) OR ($fila2['grado_curso']==2)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987"))){
								$qry7="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
							
							}elseif (($fila3['ensenanza']>=410) AND (($fila2['grado_curso']==3) OR ($fila2['grado_curso']==4)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989")))  {
								$qry7="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
							}elseif (($fila3['ensenanza']>=460) AND (($fila2['grado_curso']==1) and ($plan=="1521989")) )  {
								$qry7="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
							
							}elseif (($plan!="5451996") and ($plan!="5521997") and ($plan!="2201999") and ($plan!="812000") and ($plan!="4812000") and ($plan!="922002") and ($plan!="771999") and ($plan!="832000") and ($plan!="272001") and ($plan!="1022002") and ($plan!="4592002") and ($plan!="771982") and ($plan!="1901975") and ($plan!="121987") and ($plan!="1521989")){
								$qry7="select * from incluye_propio inner join subsector on incluye_propio.cod_subsector =subsector.cod_subsector where incluye_propio.cod_decreto=".$plan;
							}
						
					 
						$result7 =@pg_Exec($conn,$qry7);
						if (!$result7) 
							error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>'.$qry7);
						else{
																		
						for($i=0 ; $i < @pg_numrows($result7) ; $i++){
							$fila1 = @pg_fetch_array($result7,$i);
							//RAMOS INGRESADOS AL CURSO
							$qry2="SELECT subsector.cod_subsector, subsector.nombre FROM (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((curso.id_curso)=".$curso.") AND ((subsector.cod_subsector)=".$fila1["cod_subsector"]."))";
							$result2 =@pg_Exec($conn,$qry2);
								if (!$result2) 
									error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
								else{
									if (pg_numrows($result2)==0){
										echo  "<option value=".$fila1["cod_subsector"].">"."[".$fila1["cod_subsector"]."]".$fila1["nombre"]."</option>";
									}
								}
								};
						};//fin if modo ingresar
													?>
                    </select> 
                    <?php }  }; //}?>
					 <FONT face="arial, geneva, helvetica" size=2><strong>
					 <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre']);
													
												};
											?>
					 <?php 
												if($frmModo=="modificar"){ 
													imp($fila['nombre']);
												};
											?>
										<?php //echo $qry7;
										//exit; ?>
					</strong></font>
                  
				 
                   
                    <?php if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310)and ($filaVrfy['rdb']==0)) { ?>
                    <?php if($frmModo=="ingresar"){ ?>
					<?php if(($frmModo=="ingresar")and($filaVrfy['rdb']==0)) { ?>
							   <td>
							   <? if($cmbSECDIF==0){?>
							   <input type="radio" name="cmbSUBS" value="2"onClick="mText(this.form);"> 
							   <? }else{?>
							   <input type="radio" name="cmbSUBS" value="2"onClick="mText(this.form);" checked> 
					<?php 		  }
							} ?>                  
								<td> 
                    <select name="cmbSECDIF" onChange="enviapag(this.form);">
                      <option value=0 selected>Seleccione Sector </option>
                      <?php if ($cmbSECDIF==1) {
					  			echo "<option value=1 selected>Lengua Castellana y Comunicación</option>";
					   		}else echo "<option value=1>Lengua Castellana y Comunicación</option>";
					  		if ($cmbSECDIF==2) {
								echo "<option value=2 selected>Idioma Extranjero</option>";
					  		}else echo "<option value=2>Idioma Extranjero</option>";
					  		if ($cmbSECDIF==3){ 
								echo "<option value=3 selected>Matemáticas</option>";
					  		}else echo "<option value=3>Matemáticas</option>";
					  		if ($cmbSECDIF==4){
					  			echo "<option value=4 selected>Historia y Ciencias Sociales</option>";
					  		}else echo "<option value=4>Historia y Ciencias Sociales</option>";
					  		if ($cmbSECDIF==5){
					  			echo "<option value=5 selected>Filosofía y Psicología</option>";
					  		}else echo "<option value=5 >Filosofía y Psicología</option>";
							if ($cmbSECDIF==6){
					  			echo "<option value=6 selected>Biología</option>";
					  		}else echo "<option value=6 >Biología</option>";
					  		if ($cmbSECDIF==7){ 
					  			echo "<option value=7 selected>Física</option>";
					  		}else echo "<option value=7>Física</option>";
					  		if ($cmbSECDIF==8){ 
								echo "<option value=8 selected>Química</option>";
					  		}else echo "<option value=8>Química</option>";
					  		if ($cmbSECDIF==9){ 
								echo "<option value=9 selected>Educación Técnologica</option>";
					  		}else echo "<option value=9>Educación Técnologica</option>";
					  		if ($cmbSECDIF==10){
					  			echo "<option value=10 selected>Artes Visuales</option>";
					  		}else echo "<option value=10>Artes Visuales</option>";
					  		if ($cmbSECDIF==11){
								echo "<option value=11 selected>Artes Musical</option>";
					  		}else echo "<option value=11>Artes Musical</option>";
					  		if ($cmbSECDIF==12){
					  			echo "<option value=12 selected>Educación Física</option>";
					  		}else echo "<option value=12>Educación Física</option>";
					?>
                    </select> </td>
                  <td align="top">
				   <select name="cmbSUB">
                      <option value=0 selected>Selecione Subsector </option>
				  <?php 
				   	$qry="select subsector.cod_subsector, subsector.nombre from (subsector inner join sector_sub on subsector.cod_subsector=sector_sub.cod_subsector) where sector_sub.id_sector=".$cmbSECDIF."union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
					$result =@pg_Exec($conn,$qry);
					for($i=0 ; $i < @pg_numrows($result) ; $i++){ 
					 $fila= @pg_fetch_array($result,$i);
						echo  "<option value=".$fila["cod_subsector"]." >".$fila["nombre"]."</option>";
					}
				
				?>
				</select>
			 <?php }
			 };?>				  </td>
                </tr>
              </table>
			 </TD>
		</TR>
		
		
		<? 
		if ($_PERFIL==0){   /// código para seleccionar varios subsectores  ?>
		           <!--
				   <TR>
					<TD width=6></TD>
								
					<TD width="571"> <table border=0 cellspacing=2 cellpadding=2>
					<tr> 
					<?php 
						  $qry5="SELECT * FROM curso WHERE ID_CURSO=".$curso; 
							$result5 =@pg_Exec($conn,$qry5);
							$fila5= @pg_fetch_array($result5,0);
	//						   if((($fila3["cod_tipo"]==110) or ((($fila3["cod_tipo"]==310) and (($frmModo=="mostrar") || ($frmModo=="modificar"))) and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2))) OR ((($fila3["cod_tipo"]>=410) and (($frmModo=="mostrar") || ($frmModo=="modificar"))) and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2) or ($fila5['grado_curso']==3) or ($fila5['grado_curso']==4)))) || $filaVrfy['rdb']!=0){ 
								if((($fila3["cod_tipo"]==110) or (($fila3["cod_tipo"]==310) and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2))) OR (($fila3["cod_tipo"]>=410)  and (($fila5['grado_curso']==1) or ($fila5['grado_curso']==2) or ($fila5['grado_curso']==3) or ($fila5['grado_curso']==4))))or ($filaVrfy['rdb']!=0)) {?>
									<?php if(($frmModo=="ingresar")and ($filaVrfy['rdb']==0)){ ?>
								   <td width="27"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
						</font> </td>
									   <?php } ?>
								  <td width="131"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
									<strong>SUBSECTOR</strong> </font> </td>
								 
									
									<?php //if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
									<?php if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
								
					  <td></td>
								<td width="226">&nbsp;</td>
								  <td width="182">&nbsp;</td>
									<?php } ?>
								</tr>
								<tr> 
								   <?php if(($frmModo=="ingresar")){ ?>
								   <td>
									<?php } ?>                  
									<td> 
									
									
									
						<?php if($frmModo=="ingresar"){ ?>
						<?php  //if($fila5["cod_tipo"]<>310){ ?>
							
						<?php
							//SUBSECTORES QUE CORRESPONDEN AL CURSO DE ACUERDO AL PLAN DE ESTUDIO
							$qry2="SELECT * FROM curso WHERE ID_CURSO=".$curso;
							$result2 =@pg_Exec($conn,$qry2);
							$fila2= @pg_fetch_array($result2,0);
							$qry=0;
								
								if (($fila3['ensenanza']==110) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989"))){
									$qry7="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
								}elseif (($fila3['ensenanza']>=310) AND (($fila2['grado_curso']==1) OR ($fila2['grado_curso']==2)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987"))){
									$qry7="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
								}elseif (($fila3['ensenanza']>=410) AND (($fila2['grado_curso']==3) OR ($fila2['grado_curso']==4)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989") ))  {
									$qry7="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
									
								}elseif (($fila3['ensenanza']>=460) AND (($fila2['grado_curso']==1) and ($plan=="1521989")) )  {
									$qry7="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
								}elseif (($plan!="5451996") and ($plan!="5521997") and ($plan!="2201999") and ($plan!="812000") and ($plan!="4812000") and ($plan!="922002") and ($plan!="771999") and ($plan!="832000") and ($plan!="272001") and ($plan!="1022002") and ($plan!="4592002") and ($plan!="771982") and ($plan!="1901975") and ($plan!="121987") and ($plan!="1521989")){
									$qry7="select * from incluye_propio inner join subsector on incluye_propio.cod_subsector =subsector.cod_subsector where incluye_propio.cod_decreto=".$plan;
								}
							
						 
							$result7 =@pg_Exec($conn,$qry7);
							if (!$result7) 
								error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>'.$qry7);
							else{
							
							
							echo "<table>";
							echo "<tr>
									<td><input name=chktodos type=checkbox  value=1 /></td>
									<td><font face='arial, geneva, helvetica' size=2 color=red>MODO DE INGRESO MASIVO</font></td>
								  </tr>";	
																			
							for($i=0 ; $i < @pg_numrows($result7) ; $i++){
								$fila1 = pg_fetch_array($result7,$i);
								//RAMOS INGRESADOS AL CURSO
								$qry2="SELECT subsector.cod_subsector, subsector.nombre FROM (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((curso.id_curso)=".$curso.") AND ((subsector.cod_subsector)=".$fila1["cod_subsector"]."))";
								$result2 =@pg_Exec($conn,$qry2);
									if (!$result2) 
										error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
									else{
										if (pg_numrows($result2)==0){
										    echo "<tr>
											        <td><input name=chk".$fila1["cod_subsector"]." type=checkbox  value=".$fila1['cod_subsector']." /></td>
													<td><font face='arial, geneva, helvetica' size=1 color=#000000>".$fila1["nombre"]."  ".$fila1['cod_subsector']."</font></td>
												  </tr>";										
										 }
									}
							  };
							  
							  echo "</table>";
							  
						};//fin if modo ingresar
														?>
					
						<?php }  }; //}?>
						
					   
						
						   
									<td>							  
						<td>&nbsp;</td>
					  <td align="top">&nbsp;</td>
					</tr>
				  </table>
				 </TD>
			    </TR>
				-->
		
	  <? } ?>
	
	
			<?php // if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310)) { ?>
					<TR>
					<TD width=6></TD>
							
            <TD> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
                  
                </tr>
				<tr> 
                  <td width="22"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                   </td>
                 
                  <td width="303">  
                  </td>
                </tr>
                <tr>
				
				   <td align="top" width="310">
				   <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>SUBSECTOR OBLIGATORIO</strong></font>
                        <?php 
						//exit;
						if($frmModo=="ingresar"){ ?>
                    <input name="sub_ob" type="radio" value="1" checked> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp(($fila1['sub_obli']==1)?"SI":"NO");?>
													</strong></font>
												<?php };
											?>
                                           <?php if($frmModo=="modificar"){ ?>
                                            <input name="sub_ob" type="radio" value=1 checked
											<?php 
											  echo ($fila1['sub_obli']==1)?"checked":"";
											?>>
											<?php };?>
                    </td>
                   
                  <td align="top" width="206"> 
				  <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>SUBSECTOR ELECTIVO</strong></font>
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="radio" name="sub_ob" value="2"> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp( ($fila1['sub_obli']==2)?"SI":"NO");?>
													</strong></font>
												<?php };
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="radio" name="sub_ob" value=2
											<?php 
											  echo ($fila1['sub_obli']==2)?"checked":"";
											?>>
											
											<?php };?>
                    </td>
                </tr>
				
              </table></TD>
						</TR>						

                          <TR>
							<TD width=6></TD>
							
            <TD> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
                  <td width="262"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>INCIDE EN PROMOCION (SE IMPRIME EN EL ACTA)</strong></font> </td>
                  <td width="254"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    SUBSECTOR ASOCIADO A RELIGION</font> </td>
                 
                </tr>
                <tr> 
                  	<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=ip size=83 maxlength=50 id="ip" >
											<?php };?>
											
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp( ($fila1['bool_ip']==0)?"NO":"SI");?>
													</strong></font>
												<?php };
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=ip size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila1['bool_ip']==1)?"checked":"";
											?>>
											<?php };?>
										</TD>
                 	
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name=sar size=83 maxlength=50 > 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp( ($fila1['bool_sar']==0)?"NO":"SI");?>
													</strong></font>
												<?php };
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="checkbox" name=sar size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila1['bool_sar']==1)?"checked":"";
											?>>
											<?php };?>
										</TD>
                </tr>
              </table>
              <br>
              <table border=0 cellspacing=2 cellpadding=2>
                <tr>
                  <td width="262"><font face="arial, geneva, helvetica" size=1 color=#000000> <strong>SUBSECTOR ART&Iacute;STICO</strong></font> </td>
                  <td width="254"><font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp;</font> </td>
                </tr>
                <tr>
                  <TD><?php if($frmModo=="ingresar"){ ?>
                      <INPUT type="checkbox" name=artis size=83 maxlength=50 id="artis" >
                      <?php };?>
                      <?php 
												if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong>
                      <?php
													imp( ($fila1['bool_artis']==0)?"NO":"SI");?>
                      </strong></font>
                      <?php };
											?>
                      <?php if($frmModo=="modificar"){ ?>
							  <INPUT type="checkbox" name=artis size=83 maxlength=50 value=1 
									<?php 
									  echo ($fila1['bool_artis']==1)?"checked":"";
									?>>
                      <?php };?>
                  </TD>
                  <TD>&nbsp;</TD>
                </tr>
              </table>
              <table width="100%" border="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
              <table width="100%" border="0">
                <tr>
                  <td><font size="1" face="Arial, Helvetica, sans-serif">APROXIMAR 
                    NOTAS</font> 
                    <?php if ($frmModo=="ingresar"){
					//echo $qry7;
					//exit;?>
                    <input name="truncado" type="checkbox" id="truncado"> 
                    <?php } ?>
                    <?php 
						if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
							imp( ($fila1['truncado']==0)?"NO":"SI");?>
							</strong></font>
						<?php };?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="truncado" size=83 maxlength=50 value=1 
					<?php 
					echo ($fila1['truncado']==1)?"checked":"";
					?>> 
                    <?php };?>
                  </td>
                </tr>
              </table></TD>
						</TR>

<TR>
							<TD width=6></TD>
							
            <TD> 
			
			
			<table width="100%" border=0 cellpadding=2 cellspacing=2>
			   <tr>
			     <td colspan="5"><font size="1" face="Arial, Helvetica, sans-serif">EXAMEN </font></td></tr>
				 
				<tr>
				  <td colspan="5">
				    <?
					 if (($frmModo=="mostrar")){
					        if ($fila1['conex']==1){ ?>
					          <font face="arial, geneva, helvetica" size=1 color=#000000><strong>SI</strong></font>
				         <? } 
					  
					        if ($fila1['conex']==2){ ?>					  
						     <font face="arial, geneva, helvetica" size=1 color=#000000><strong>NO</strong></font>
							 
					
					     <? } elseif ($fila1['conex']==0){ ?>  		
						  <font face="arial, geneva, helvetica" size=1 color=#FF0000><strong>ADVERTENCIA: DEBE DEFINIR SI RINDE EXAMEN</strong></font>
						 <? } ?>
						  
				  <? } 	
				   
				     if ($frmModo=="ingresar"){ ?>
				           <input type="radio" name="conEX" value="1" onClick="muestraText(this.form);">
					    	<font face="arial, geneva, helvetica" size=1 color=#000000><strong>SI</strong></font>
						    &nbsp;
						   <input type="radio" name="conEX" checked="checked" value="2" onClick="ocultaText(this.form);">
						   <font face="arial, geneva, helvetica" size=1 color=#000000><strong>NO</strong></font>
				   <? }				  
				  
				   
				     if ($frmModo=="modificar"){ 
					 
					       ?>
					       <input name="conEX" type="radio" value="1" onClick="muestraText(this.form);" <? if ($fila1['conex']==1){ ?> checked <? } ?> >
						   <font face="arial, geneva, helvetica" size=1 color=#000000><strong>SI</strong></font>
						   &nbsp;
						  
					       <input name="conEX" type="radio" value="2" onClick="ocultaText(this.form);" <? if ($fila1['conex']==2){ ?> checked <? } ?> >
						   <font face="arial, geneva, helvetica" size=1 color=#000000><strong>N0</strong></font>
				     
				  <? } ?>     
				  </td> 			      
				</tr>				
				
				
				
				
                <tr> 
                  <?php if ((($frmModo=="mostrar") and ($fila1['conex']==1)) or ($frmModo=="ingresar") or ($frmModo=="modificar")) {?>
                  <td height="15" align="left" valign="top"><font size="1" face="Arial, Helvetica, sans-serif">PORCENTAJE 
                    EXAMEN</font></td>
                  <td align="left" valign="top"><font size="1" face="Arial, Helvetica, sans-serif">NOTA 
                    EXIMICI&Oacute;N</font></td>
                 
                  <?php // } ?>
                </tr>
                <tr> 
                  <td height="40" align="left" valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <p> 
                      <input name="txtPCT" type="text" disabled size="5" maxlength="2">
                      % 
                      <?php }; ?>
                      <?php if(($frmModo=="mostrar") and ($fila1['conex']==1)){?>
                      <font face="arial, geneva, helvetica" size=2><strong> 
                      <?php 
									imp($fila1['pct_examen']); echo "%";?>
                      </strong></font> 
                      <?php };?>
                      <?php if(($frmModo=="modificar") and ($fila1['conex']==2)){?>
                    </p>
                    <p> 
                      <input name="txtPCT" type="text" disabled value="<?php echo  $fila1['pct_examen'] ?>" size="5" maxlength="2">
                      % 
                      <?php }elseif(($frmModo=="modificar") and ($fila1['conex']!=2)){?>
                    </p>
                    <p> 
                      <input name="txtPCT" type="text" value="<?php echo  $fila1['pct_examen'] ?>" size="5" maxlength="2">
                      % 
                      <?php } ?>
                      &nbsp;</p></td>
                  <td align="left" valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <p> 
                      <input name="txtNEXIM" type="text" size="5" disabled>
                      <?php }; ?>
                      <?php if(($frmModo=="mostrar") and ($fila1['conex']==1)){?>
                      <font face="arial, geneva, helvetica" size=2><strong> 
                      <?php
									imp($fila1['nota_exim']);?>
                      </strong></font> 
                      <?php };?>
                      <?php if(($frmModo=="modificar") and ($fila1['conex']==2)){  ?>
                    </p>
                    <p> 
                      <input name="txtNEXIM" type="text" disabled size="5"value="<?php echo $fila1['nota_exim'] ?>">
                      <?php }elseif(($frmModo=="modificar") and ($fila1['conex']!=2)){?>
                    </p>
                    <p> 
                      <input name="txtNEXIM" type="text" size="5"value="<?php echo $fila1['nota_exim'] ?>">
                      <?php } ?>
                      &nbsp;</p></td>
                  <?php } ?>
                </tr>
				
				
				
				
				<? 
				if(($institucion==12086 || $_PERFIL==0)&&($fila1['conex']==1)){	//&&($fila1["cod_subsector"]==14 || $fila1["cod_subsector"]==15)?>
				<tr>
					<td><font size="1" face="Arial, Helvetica, sans-serif">PORCENTAJE EXAMÉN ESCRITO</font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif">PORCENTAJE EXAMÉN ORAL</font></td>
				</tr>
				<? if($frmModo=="ingresar"){?>
					<tr>
						<td><input name="pct_escrito" type="text" size="3" maxlength="2"></td>
						<td><input name="pct_oral" type="text" size="3" maxlength="2"></td>
					</tr>
				<? } 
					if($frmModo=="modificar"){?>
					<tr>
						<td><input name="pct_escrito" type="text" size="3" maxlength="2"></td>
						<td><input name="pct_oral" type="text" size="3" maxlength="2"></td>
					</tr>
				<? } 
					if($frmModo=="mostrar"){ ?>
					<tr>
						<td><font face="arial, geneva, helvetica" size=2><strong><? echo $fila1["pct_ex_escrito"]; ?></strong></font></td>
						<td><font face="arial, geneva, helvetica" size=2><strong><? echo $fila1["pct_ex_oral"]; ?></strong></font></td>
					</tr>
				<? } ?>
				<? } ?>
<?	//	if($institucion==25452 || $institucion==24977 || $institucion==25478 || $_PERFIL==0 ){	//restringir la prueba de nivel		?>
                <tr> 
          <?php  if( ($frmModo=="mostrar") and ($fila1['prueba_nivel']==1) ) { ?>
                  <td align="left" valign="top"><font size="1" face="Arial, Helvetica, sans-serif">PRUEBA DE NIVEL</font> 
           <?php } elseif ($frmModo=="ingresar" or $frmModo=="modificar") { ?>
				  <td><font size="1" face="Arial, Helvetica, sans-serif">PRUEBA DE NIVEL</font> 
           <?php } ?>
                    <?php if ($frmModo=="ingresar"){	?>
                    <input name="prueba_niv" type="radio" id="prueba_niv" value=1 onClick="muestraTextPNivel(this.form);">
                    <?php } ?>
                    <?php 
						if($frmModo=="mostrar"){  ?>
                    <font face="arial, geneva, helvetica" size=2><strong>
                    <?php
							if ($fila1['prueba_nivel']==1)
								imp( ($fila1['prueba_nivel']==1)?"SI":"NO");?>
                    </strong></font> 
                    <?php };?>
                    <?php if($frmModo=="modificar"){  ?>
                    <input type="radio" name="prueba_niv" size=83 maxlength=50 value=1 onClick="muestraTextPNivel(this.form);" 
					<?php 
					echo ($fila1['prueba_nivel']==1)?"checked":"";
					
					?>> 
                    <?php };?>
                  </td>

          <?php  if( ($frmModo=="mostrar") and ($fila1['prueba_nivel']==2) ) { ?>
                  <td align="left" valign="top"><font size="1" face="Arial, Helvetica, sans-serif">SIN PRUEBA DE NIVEL</font> 
           <?php } elseif ($frmModo=="ingresar" or $frmModo=="modificar") { ?>
                  <td align="left" valign="top"><font size="1" face="Arial, Helvetica, sans-serif">SIN PRUEBA DE NIVEL</font> 
           <?php } ?>
                    <?php if ($frmModo=="ingresar"){	?>
                    <input name="prueba_niv" type="radio" id="prueba_niv" value=2 onClick="ocultaTextNivel(this.form);" checked>
                    <?php } ?>
                    <?php 
						if($frmModo=="mostrar"){  ?>
                    <font face="arial, geneva, helvetica" size=2><strong>
                    <?php
							if ($fila1['prueba_nivel']==2)
								imp( ($fila1['prueba_nivel']==2)?"SI":"NO");?>
                    </strong></font> 
                    <?php };?>
                    <?php if($frmModo=="modificar"){  ?>
                    <input type="radio" name="prueba_niv" size=83 maxlength=50 value=2 onClick="ocultaTextNivel(this.form);" 
					<?php 
					echo ($fila1['prueba_nivel']==2)?"checked":"";
					
					?>> 
                    <?php };?>
                  </td>
				  
                </tr>
				
				
				
				
			
				 <tr>         
                  <td align="left"  height="50"><font size="1" face="Arial, Helvetica, sans-serif">APROXIMA PRUEBA DE NIVEL CON PROMEDIO</font></td> 
          		  <td>
				  <?
				  if ($frmModo=="mostrar"){				  
					  if ($fila1['truncado_pnivel']==0){
					      echo "NO";
					  }else{
					      echo "SI";
					  }	  					  
				  }
				
				  
				  if ($frmModo=="modificar"){
				  
                       ?>				  
					   <input name="truncado_pnivel" type="checkbox" id="truncado_pnivel" value=1 <? if ($fila1['truncado_pnivel']==1) { ?> checked="checked" <? } ?> >	
				       <?
				  }	  
				  ?> 
				  </td>
                  <td align="left" >&nbsp; </td>
				  <td align="left" >&nbsp; </td>
		        </tr>
		 		
				
				
				
				
				
				
                <tr> 
                  <?php if ((($frmModo=="mostrar") and ($fila1['prueba_nivel']==1)) or ($frmModo=="ingresar") or ($frmModo=="modificar")) {?>
                  <td height="15" align="left" valign="top"><font size="1" face="Arial, Helvetica, sans-serif">PORCENTAJE 
                    PRUEBA DE NIVEL</font></td>
                  <TD colspan="2"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>MODO DE EVALUACION PRUEBA DE NIVEL&nbsp;&nbsp;&nbsp;</STRONG></FONT> 
                  </TD>
                  <?php // } ?>
                </tr>
                <tr> 
                  <td height="40" align="left" valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <p> 
                      <input name="txtPCTNIV" type="text" disabled size="5" maxlength="2"> 	
                      % 
                      <?php }; ?>
                      <?php if(($frmModo=="mostrar") and ($fila1['prueba_nivel']==1)){?>
                      <font face="arial, geneva, helvetica" size=2><strong> 
                      <?php 
									imp($fila1['pct_nivel']); echo "%";?>
                      </strong></font> 
                      <?php };?>
                      <?php if(($frmModo=="modificar") and ($fila1['prueba_nivel']==2)){?>
                    </p>
                    <p> 
                      <input name="txtPCTNIV" type="text" disabled value="<?php echo  $fila1['pct_nivel'] ?>" size="5" maxlength="2"> 
                      % 
                      <?php }elseif(($frmModo=="modificar") and ($fila1['prueba_nivel']!=2)){?>
                    </p>
                    <p> 
                      <input name="txtPCTNIV" type="text" value="<?php echo  $fila1['pct_nivel'] ?>" size="5" maxlength="2">
                      % 
                      <?php } ?>
                      &nbsp;</p></td>

					<TD width="39%" valign="top"><?php if($frmModo=="ingresar"){ ?>						
                      <Select name="cmbMODOpruebaNivel" disabled>
								<option value=0 selected></option>
								<option value=1 >Numérico</option>
								<option value=2 >Conceptual</option>
					  </Select>
						<?php };?>
						<?php 
							if($frmModo=="mostrar" AND $fila1['prueba_nivel']==1){ ?>
							<strong><FONT face="arial, geneva, helvetica" size=2><?php
								switch ($fila['modo_eval_pnivel']) {
									 case 0:
										 imp('INDETERMINADO');
										 break;
									 case 1:
										 imp('Numérico');
										 break;
									 case 2:
										 imp('Conceptual');
										 break;
								 };?>
							</font></strong>
							<?php };
						?>
						<?php if($frmModo=="modificar" and $fila1['prueba_nivel']==2){ ?>
							<Select name="cmbMODOpruebaNivel" disabled>
								<option value=0 ></option>
						<option value=1 <?php echo ($fila['modo_eval_pnivel'])==1?"selected":"" ?>>Numérico</option>
						<option value=2 <?php echo ($fila['modo_eval_pnivel'])==2?"selected":"" ?>>Conceptual</option>
							</Select>
				  <?php };?>			
						<?php if($frmModo=="modificar" and $fila1['prueba_nivel']!=2){ ?>
							<Select name="cmbMODOpruebaNivel" >
								<option value=0></option>
						<option value=1 <?php echo ($fila['modo_eval_pnivel'])==1?"selected":"" ?>>Numérico</option>
						<option value=2 <?php echo ($fila['modo_eval_pnivel'])==2?"selected":"" ?>>Conceptual</option>
							</Select>
				  <?php };?>			
				  	  </TD>
                      <?php }  ?>
				</TR>
         <? //	}	// fin if para restringir prueba de nivel  ?>



              </table></TD>
						</TR>

					<?php }else{?>
							<input type=hidden name=cmbSUB value=0> <!--SUBSECTOR INDETERMINADO-->
				<?php // }//FIN ENSEÑANZA CURSO?>
				<?php }//FIN TIPO ENSEÑANZA COLEGIO?>
				<?php if(($Tipo_Ins==2)||($Tipo_Ins==3)){//JARDIN O SALACUNA ?>
					<input type=hidden name=cmbSUB value=0> <!--SUBSECTOR INDETERMINADO-->
				<?php }?>
						<TR>
							<TD width=6></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										
                  <TD colspan="2"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>MODO DE EVALUACION<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp; 
                    &nbsp; <font face="Courier New, Courier, mono">&nbsp;</font></STRONG></FONT></STRONG></FONT> 
                  </TD>
                                        
									</TR>
									<TR>
										<TD width="39%">
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbMODO" >
												<option value=0 selected>Seleccionar Modo</option>
													<option value=1 selected>Numérico</option>
													<option value=2 >Conceptual</option>
													<option value=3 >Numérico-Conceptual</option>
													<option value=4 >Conceptual-Numérico</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													switch ($fila['modo_eval']) {
														 case 0:
															 imp('<span class="EstiloMODO">ADVERTENCIA: DEBE DEFINIR MODO DE EVALUACIÓN</spam>');
															 break;
														 case 1:
															 imp('Numérico');
															 break;
														 case 2:
															 imp('Conceptual');
															 break;
														 case 3:
															 imp('Numérico-Conceptual');
															 break;
														 case 4:
															 imp('Conceptual-Numérico');
															 break;
													 };?>
												</strong></font>
												<?php };
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbMODO" >
											<option value=0 <?php echo ($fila['modo_eval'])==0?"selected":"" ?>>Seleccione Modo</option>		
											<option value=1 <?php echo ($fila['modo_eval'])==1?"selected":"" ?>>Numérico</option>
											<option value=2 <?php echo ($fila['modo_eval'])==2?"selected":"" ?>>Conceptual</option>
											<option value=3 <?php echo ($fila['modo_eval'])==3?"selected":"" ?>>Numérico-Conceptual</option>
											<option value=4 <?php echo ($fila['modo_eval'])==4?"selected":"" ?>>Conceptual-Numérico</option>
												</Select>
											    <?php };?>
										          </TD>
                                         
                                                  
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=6></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DOCENTE</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>AYUDANTE</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php 
												$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM empleado,trabaja, institucion   WHERE (((institucion.rdb)=".$institucion.") AND (empleado.rut_emp = trabaja.rut_emp) AND (trabaja.rdb = institucion.rdb)) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
												$result5 =@pg_Exec($conn,$qry5);
												if (!$result5) 
													error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
												else{
													if (pg_numrows($result5)!=0){
														$fila5 = @pg_fetch_array($result5,0);
														if (!$fila5){
															error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
															exit();
														};
													}
												}
												if($frmModo=="ingresar"){?>
												<Select name="cmbDOC">
											<option>SELECCIONE DOCENTE</option>
													

											<?php
															for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila1 = @pg_fetch_array($result5,$i);
																echo  "<option value=".$fila1["rut_emp"].">".$fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]."</option>";
															}
														};
													?>
												</Select>
											
											<?php 
																	
											 	$qry2="SELECT empleado.rut_emp,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM empleado, dicta, ramo  WHERE (((ramo.id_ramo)=".$ramo.") AND dicta.rut_emp = empleado.rut_emp AND dicta.id_ramo = ramo.id_ramo) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
											 	$result2 =@pg_Exec($conn,$qry2);
												$fila2 = @pg_fetch_array($result2,0);	

												

												if($frmModo=="mostrar"){?>
												<FONT face="arial, geneva, helvetica" size=2><strong><?php 
													imp($fila2['ape_pat']." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"]);?>
													</strong></font>
												<?php };
											?>
											<?php if($frmModo=="modificar"){?>
												<Select name="cmbDOC">
												<option>SELECCIONE DOCENTE</option>
													
													<?php
															for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila5 = @pg_fetch_array($result5,$i);
																if($fila2['rut_emp']!=$fila5['rut_emp']){
																	echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}else{
																	echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}
															}
														};
													?>
												</Select>

										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbAYU">
													<option value=0 selected></option>
													<?php
														for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila1 = @pg_fetch_array($result5,$i);
																echo  "<option value=".$fila1["rut_emp"].">".$fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]."</option>";
															}
														};
													?>
												</Select>
											
											<?php if($frmModo=="mostrar"){?><FONT face="arial, geneva, helvetica" size=2><strong>
													<?php
													 	$qry="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, ayuda.id_ramo FROM ayuda INNER JOIN empleado ON ayuda.rut_emp = empleado.rut_emp WHERE (((ayuda.id_ramo)=".$ramo.")) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (13)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (14)</B>');
																	exit();
																};
																imp($fila1['ape_pat']." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]);
															};
														};
													?>
													</strong></font>
											<?php };?>
											<?php if($frmModo=="modificar"){?>
												<Select name="cmbAYU">
													<option value=0 ></option>;
													<?php 
														// ACTAL AYUDANTE DEL RAMO
														$qry8="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, ayuda.id_ramo FROM ayuda INNER JOIN empleado ON ayuda.rut_emp = empleado.rut_emp WHERE (((ayuda.id_ramo)=".$ramo.")) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
														$result8 =@pg_Exec($conn,$qry8);
														$fila8  = @pg_fetch_array($result8,0);

														for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila5 = @pg_fetch_array($result5,$i);
																if($fila8["rut_emp"]!=$fila5["rut_emp"]){
                                                                   
																	echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}else{
																	echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}
															}
														};
													?>
												</Select>
											
										</TD>

									</TR>
								</TABLE>
							</TD>
						</TR>                        
						
					</TABLE>
					
					
				
				
					<!-- fin tabla nueva -->
					
					
					
				</TD>
			</TR>		
			
		</TABLE>
	</FORM>
<? 

pg_close($conn);
?>

                        <!-- FIN CODIGO ANTIGUO -->
						        </td>
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
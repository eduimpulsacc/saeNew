<?php require('../../../../../util/header.inc');
       require('../../../../../util/LlenarCombo.php3');
	    require('../../../../../util/SeleccionaCombo.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$taller			=$_TALLER;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
	
?>
<?php $qryIns="select tipo_instit from institucion where rdb=".$institucion;
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
			/*function enviapag(form){
			if (form.cmbSEC.value!=0){
				form.cmbSEC.target="self";
				form.action = 'ramo.php3?institucion=$institucion&$frmModo=ingresar';
				form.submit(true);
				}	
			}*/
			
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
</SCRIPT>


<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM taller WHERE (((taller.id_taller)=".$taller."))";
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
	 };

?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	<?php if($Tipo_Ins==1){//COLEGIO ?>
	<!--AQUI DETERMINAR SI EL CURSO ES KINDER O OTRO DE LOS CABROS CHICOS-->
		<?php if(($frmModo=="ingresar") or ($frmModo=="modificar")){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkSelect(form.cmbSUB,'Seleccionar SUBSECTOR AL QUE CORRESPONDE.')){
							return false;
						};

						if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
							return false;
						};

						if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
							return false;
						};
						
						//if (form.txtNEXIM.disabled.value!=""){
						/*if(!notaNroOnly(form.txtNEXIM,'Nota inválida.')){
							return false;
						};*/
						//}
						return true;
					}
				</SCRIPT>
		<?php }else{?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
							return false;
						};

						if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
							return false;
						};
						
						if(!notaNroOnly(form.txtNEXIM,'Nota inválida.')){
							return false;
						};
						
						return true;
					}
				</SCRIPT>
		<?php }?>
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

					return true;
				}
			</SCRIPT>
	<?php }?>
<?php }?>
	
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	<FORM method=post name="frm" action="procesoTaller.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		echo "<input type=hidden name=curso value=".$curso.">";
		
		$qryVrfyPropio="select * from plan_estudio where cod_decreto=".$_PLAN;
		$resultVrfy=@pg_Exec($conn,$qryVrfyPropio);
		$filaVrfy=@pg_fetch_array($resultVrfy,0);
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
						<TR>
							<TD align=left>
							<?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>TALLER</strong>
								</FONT>
							
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							<?php }?>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											//$qry="SELECT subsector.nombre, ramo.sub_obli, ramo.sub_elect, ramo.bool_ip, ramo.bool_sar FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$qry="SELECT * FROM taller  WHERE (((taller.id_taller)=".$taller."))";
											$result =@pg_Exec($conn,$qry);
											if (@pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre_taller']);
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
          <TR height="50" > 
            <TD align=right colspan=2> 
              <?php if($frmModo=="ingresar"){ ?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" > 
              &nbsp; <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarTalleres.php3?plan=<?php echo $plan ?>"> 
              &nbsp; 
              <?php };?>
              <?php if($frmModo=="mostrar"){ ?>
              <?php if($_PERFIL==17){ ?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="INICIO" onClick=parent.location.href="../../../../../fichas/docente/index.html"> 
              <?php }?>
              <?php if($_PERFIL!=17){?>
              <?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
              <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaTaller.php3?taller=<?php echo $taller?>&caso=3"> 
              &nbsp; <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR" name=btnEliminar onClick=document.location="seteaTaller.php3?caso=9;"> 
              &nbsp; 
              <?php }?>
              <?php }?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarTalleres.php3?plan=<?php echo $plan ?>"> 
              &nbsp; 
              <?php }?>
              <?php if($_TIPODOCENTE==1){?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarTalleres.php3?plan=<?php echo $plan ?>"> 
              &nbsp; 
              <?php }?>
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form)?;" > 
              &nbsp; <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaTaller.php3?taller=<?php echo $taller?>&caso=1&plan=<?php echo $plan ?>"> 
              &nbsp; 
              <?php };?>
            </TD>
          </TR>
          <TR height=20 bgcolor=#003b85> 
            <TD align=middle colspan=2> <FONT face="arial, geneva, helvetica" size=2 color=White> 
              <strong>TALLER</strong> </FONT> </TD>
          </TR>
          <?php if($Tipo_Ins==1){//COLEGIO
				 ?>
          <?php if (($fila3['cod_tipo']==410) or($fila3['cod_tipo']==510) or ($fila3['cod_tipo']==610) or ($fila3['cod_tipo']==710) or ($fila3['cod_tipo']==810)){?>
          <?php  } ?>
          <?php
					//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
					$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
					$result =@pg_Exec($conn,$qry);
					$fila4= @pg_fetch_array($result,0);
					?>
          <?php if($filaVrfy['rdb']==0){ ?>
          <TR> 
            <TD width=6></TD>
            <TD width="571"> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
                  <td width="542"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>NOMBRE DE TALLER :</strong> </font> </td>
                  <?php //if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
                </tr>
                <tr> 
                  <td height="25">
				   <?php 
												if(($frmModo=="mostrar")||($frmModo=="modificar")){ 
													imp($fila['nombre_taller']);
												};
											?>
						 <?php 
												if($frmModo=="ingresar"){  ?>					 
                    <input name="NomTall" type="text" maxlength="450" width="450"> 
					 <?php } ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> </strong></font> 
                  </td>
                </tr>
              </table></TD>
          </TR>
          <?php  }?>
		  
          <?php// if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310)) { ?>
          <TR> 
            <TD width=6></TD>
            <TD> <table border=0 cellspacing=2 cellpadding=2>
              </table>
              <table width="100%" border="0">
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
						if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
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
          <?php }else{?>
          <input type=hidden name=cmbSUB value=0>
          <!--SUBSECTOR INDETERMINADO-->
          <?php // }//FIN ENSEÑANZA CURSO?>
          <?php }//FIN TIPO ENSEÑANZA COLEGIO?>
          <?php if(($Tipo_Ins==2)||($Tipo_Ins==3)){//JARDIN O SALACUNA ?>
          <input type=hidden name=cmbSUB value=0>
          <!--SUBSECTOR INDETERMINADO-->
          <?php }?>
          <TR> 
            <TD width=6></TD>
            <TD> <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
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
                      <option value=0 selected></option>
                      <option value=1 >Numérico</option>
                      <option value=2 >Conceptual</option>
                    </Select> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
													switch ($fila['modo_eval']) {
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
                    </strong></font> 
                    <?php };
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <Select name="cmbMODO" >
                      <option value=0></option>
                      <option value=1 <?php echo ($fila['modo_eval'])==1?"selected":"" ?>>Numérico</option>
                      <option value=2 <?php echo ($fila['modo_eval'])==2?"selected":"" ?>>Conceptual</option>
                    </Select> 
                    <?php };?>
                  </TD>
                </TR>
              </TABLE></TD>
          </TR>
          <TR> 
            <TD width=6></TD>
            <TD> <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
                <TR> 
                  <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>DOCENTE</STRONG> </FONT> </TD>
                </TR>
                <TR> 
                  <TD> 
				  <?php
                			$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((trabaja.rdb)=".$institucion.")) order by empleado.ape_mat,empleado.ape_mat asc";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										exit();
									};
								}
				
					 if($frmModo=="ingresar"){?>
                    <Select name="cmbDOC">
                      <option value=0 selected></option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							};
						?>
                    </Select> 
                    <?php };?>
					<?php 
						$qry2="SELECT empleado.rut_emp,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta_taller INNER JOIN empleado ON dicta_taller.rut_emp = empleado.rut_emp) INNER JOIN taller ON dicta_taller.id_taller = taller.id_taller WHERE (((taller.id_taller)=".$taller.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
						$result2 =@pg_Exec($conn,$qry2);
						$fila2 = @pg_fetch_array($result2,0);	

						if($frmModo=="mostrar"){?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php 
													imp($fila2['ape_pat']." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"]);?>
                    </strong></font> 
                    <?php };
											?>
                    <?php if($frmModo=="modificar"){?>
                    <Select name="cmbDOC">
                      <option value=0 selected></option>;
													
				 <?php
					
							for($i=0 ; $i < @pg_numrows($result5) ; $i++){
								$fila5 = @pg_fetch_array($result5,$i);
								if(trim($fila2["rut_emp"])!=trim($fila5["rut_emp"])){
									echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}else{
									echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							}
					
					?>
                    </Select> 
                    <?php };?>
                  </TD>
                </TR>
              </TABLE></TD>
          </TR>
          <TR> 
            <TD colspan=4> <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
                <TR> 
                  <TD> <HR width="100%" color=#003b85> </TD>
                </TR>
              </TABLE></TD>
          </TR>
          <TR> 
            <TD colspan=4> <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
                <TR> 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS INSCRITOS EN EL TALLER</strong></font> </td>
                </TR>
                <tr bgcolor="#003b85"> 
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>ELIMINAR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> </font> 
                    <?php  }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>NOMBRE</strong> </font> </td>
                </tr>
                <?php    if(($frmModo=="modificar")||($frmModo=="mostrar")) {  ?>
                <?php
				$qryP="SELECT tiene_taller.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno)   WHERE (((tiene_taller.id_taller)=".$taller.")) order by ape_pat, ape_mat, nombre_alu asc ";
				$resultP =@pg_Exec($conn,$qryP);			
				if (pg_numrows($resultP)!=0){
					$filaP = @pg_fetch_array($resultP,0);	
					}
				?>
                <?php if ($frmModo=="modificar"){ ?>
                <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong> 
                <td> 
                  <!--input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"-->
                </td>
                </strong></font> 
                <?php  }?>
                <?php
					for($i=0 ; $i < @pg_numrows($resultP) ; $i++){
						$filaP = @pg_fetch_array($resultP,$i);
                           
			?>
                <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'> 
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alum[]" value=<?php echo $filaP["rut_alumno"];?>> 
                    <?php } ?>
                    <?php    // }  ?>
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    <?php    if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                    <strong><?php echo $filaP["ape_pat"]." ".$filaP["ape_mat"].", ".$filaP["nombre_alu"];?></strong> 
                    </font> 
                    <?php     } } ?>
                  </td>
                </tr>
                <?php
					}
                  
                  
//				}
			?>
                <tr> 
                  <td colspan="3"> <hr width="100%" color="#003b85"> </td>
                </tr>
                <tr> 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS NO INSCRITOS DEL CURSO</strong></font> </td>
                </TR>
                <tr bgcolor="#003b85"> 
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>INSCRIBIR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> </font> 
                    <?php    }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong> NOMBRE</strong> </font> </td>
                </tr>
                <?php    if(($frmModo=="modificar")|| ($frmModo=="mostrar")){  ?>
                <?php
                    $qryA="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno) inner join curso on curso.id_curso=matricula.id_curso WHERE  matricula.id_curso='".$curso."' and  alumno.rut_alumno NOT IN (SELECT rut_alumno FROM tiene_taller WHERE tiene_taller.id_taller='".$taller."')order by ape_pat, ape_mat, nombre_alu asc"; 
				    $resultA =@pg_Exec($conn,$qryA);
  					$filaA = @pg_fetch_array($resultA,0);
			                   ?>
                <?php if ($frmModo=="modificar"){ ?>
                <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong> 
                <td> 
                <input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);">
				<font face="arial, geneva, helvetica" size="1" color="#000000"> 
				<strong>TODOS</strong></font>
			    </td>
                </strong></font> 
                <?php  }?>
                <?php
					for($i=0 ; $i < @pg_numrows($resultA) ; $i++){
						$filaA = @pg_fetch_array($resultA,$i);
			                ?>
                <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>	
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alu[]" value=<?php echo $filaA["rut_alumno"];?>> 
                    <?php } ?>
                    <?php  //  }  ?>
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    <?php   // if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#666666"> 
                    <strong><?php echo $filaA["ape_pat"]." ".$filaA["ape_mat"].", ".$filaA["nombre_alu"];?></strong> 
                    </font> 
                    <?php  }  ?>
                  </td>
                </tr>
                <?php
					}
//				}
			?>
                <tr> 
                  <td colspan="3"> <hr width="100%" color="#003b85"> </td>
              </TABLE></TD>
          </TR>
          <TR height=15> 
            <TD colspan=2> 
              <?php if($frmModo=="mostrar"){?>
              <?php
				$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
				$result =@pg_Exec($conn,$qry);
				if (pg_numrows($result)!=0){?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="EVALUACION" onClick=document.location="notas/mostrarNotasTaller.php3?truncado=<?php echo $fila1['truncado']; ?>"> 
              <?php if ($fila1['conex']==1) { ?>
              <input class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button" type="button" onClick=document.location="situacionFinal.php3?frmModo=mostrar" value="SITUACION FINAL ALUMNOS"> 
              <?php } ?>
              <?php
												}else{
											?>
              <!--INPUT TYPE="button" value="EVALUACION" disabled-->
              <?php
												}
											?>
              <?php if($_PLAN>=2){ //PLUS O +?>
            <!--   <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CONTENIDO" onClick=document.location="contenido/listarContenidos.php3">  -->
              <?php }?>
              <?php }else{?>
              <!--INPUT TYPE="button" value="EVALUACION" disabled>
									<?php if($_PLAN>=2){ //PLUS O +?>
										<INPUT TYPE="button" value="CONTENIDO" disabled-->
              <?php }?>
              <?php }?>
            </TD>
          </TR>
        </TABLE>
				</TD>
			</TR>
			<?php if($frmModo=="ingresar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para volver al listado de subsectores.</li>
														<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="mostrar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
													<li>"MODIFICAR" : Modifica la información del subsector ingresado.</li>
													<li>"ELIMINAR" : Elimina toda la información del subsector ingresado.</li>
													<li>"LISTADO" : Despliega el total de subsectores ingresadas.</li>
													<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="modificar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizada la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar modificaciones.</li>
														<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			
		</TABLE>
	</FORM>
</BODY>
</HTML>